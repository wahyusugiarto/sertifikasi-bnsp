<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_penjualan extends AUTH_Controller
{
    const __folder = 'v_report-penjualan/';
    const __kode_menu = 'report-penjualan';
    const __title = 'Report Penjualan';
    const __model = 'M_penjualan';

    public function __construct()
    {
        parent::__construct();
        $this->load->model(self::__model);
        $this->load->model('M_sidebar');
    }

    public function loadkonten($page, $data)
    {
        $data['userdata'] = $this->userdata;
        $ajax = ($this->input->post('status_link') == "ajax" ? true : false);
        if (!$ajax) {
            $this->load->view('Dashboard/layouts/header', $data);
        }
        $this->load->view($page, $data);
        if (!$ajax)
            $this->load->view('Dashboard/layouts/footer', $data);
    }

    public function index()
    {
        $data['userdata'] = $this->userdata;
        $data['page'] = self::__title;
        $data['judul'] = self::__title;
        $this->loadkonten('' . self::__folder . 'v_rekap-data', $data);
    }

    public function ajaxReport()
    {
        $access = $this->M_sidebar->access('view', self::__kode_menu);
        if ($access->menuview > 0) {
            $tanggalAwal = $this->input->post('tanggal_awal');
            $tanggalAkhir = $this->input->post('tanggal_akhir');
            $allDate = $this->input->post('all_date');

            $filter = [
                'tanggal_awal' => $tanggalAwal,
                'tanggal_akhir' => $tanggalAkhir,
                'all_date' => $allDate,
            ];

            $list = $this->M_penjualan->exportData($filter);

            $data = [];
            foreach ($list as $key => $value) {

                $idToko = $value->id_toko;
                $Restoko = $this->M_penjualan->selectToko($idToko);
                $namaToko = $Restoko->nama;

                $namaMember = $value->nama;
                if ($value->nama == '') {
                    $namaMember = '-';
                }

                $noTelp = $value->telp;
                if ($value->telp == '') {
                    $noTelp = '-';
                }

                $row = [];
                $row[] = $key + 1;
                $row[] = $value->kode_penjualan . '<hr>' . $namaToko . '';
                $row[] = $namaMember;
                $row[] = $noTelp;
                $row[] = $value->total;
                $row[] = date('d-m-Y', strtotime($value->tanggal));
                $data[] = $row;
            }
        } else {
            $data = ["You don't have permission"];
        }
        $output = [
            "draw" => $_POST['draw'],
            "data" => $data,
        ];

        echo json_encode($output);
    }


    public function exportExcel()
    {
        $access = $this->M_sidebar->access('view', self::__kode_menu);
        if ($access->menuview > 0) {
            $tanggalAwal = $this->input->post('tanggal_awal');
            $tanggalAkhir = $this->input->post('tanggal_akhir');
            $allDate = $this->input->post('all_date');

            $filter = [
                'tanggal_awal' => $tanggalAwal,
                'tanggal_akhir' => $tanggalAkhir,
                'all_date' => $allDate,
            ];

            $data['excel'] = $this->M_penjualan->exportData($filter);
            $data['title'] = "Report Data Penjualan Skymars Shop " . date("Y-m-d h:i");
            $data['tanggalAwal'] = $tanggalAwal;
            $data['tanggalAkhir'] = $tanggalAkhir;
            $data['allDate'] = $allDate;

            $this->load->view('' . self::__folder . 'v_laporan_excel', $data);
        } else {
            $this->loadkonten('Dashboard/layouts/no_akses', $data);
        }
    }
}

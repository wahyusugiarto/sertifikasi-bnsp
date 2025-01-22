<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_pembelian extends AUTH_Controller
{
    const __folder = 'v_report-pembelian/';
    const __kode_menu = 'report-pembelian';
    const __title = 'Report Pembelian';
    const __model = 'M_pembelian';

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

            $list = $this->M_pembelian->exportData($filter);

            $data = [];
            foreach ($list as $key => $value) {

                $idToko = $value->id_toko;
                $Restoko = $this->M_pembelian->selectToko($idToko);
                $namaToko = $Restoko->nama;

                $kodeInvoice =  $value->no_beli;
                $ResKeterangan = $this->M_pembelian->selectDetail($kodeInvoice);

                $ket = '';

                foreach ($ResKeterangan as $res) {
                    $ket .= '<li>' . $res->nama_brg . ' - ' . '( ' . $res->jml_brg . ' x ' . $res->harga_brg . ' ) <hr>';
                }

                $row = [];
                $row[] = $key + 1;
                $row[] = $value->no_beli;
                $row[] = $value->supplier;
                $row[] = $ket;
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

            $data['excel'] = $this->M_pembelian->exportData($filter);
            $data['title'] = "Report Data Pembelian Barang Skymars Shop" . date("Y-m-d h:i");
            $data['tanggalAwal'] = $tanggalAwal;
            $data['tanggalAkhir'] = $tanggalAkhir;
            $data['allDate'] = $allDate;

            $this->load->view('' . self::__folder . 'v_laporan_excel', $data);
        } else {
            $this->loadkonten('Dashboard/layouts/no_akses', $data);
        }
    }
}

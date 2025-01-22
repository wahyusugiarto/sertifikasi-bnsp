<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Report_stok extends AUTH_Controller
{
    const __folder = 'v_report_stok/';
    const __kode_menu = 'report-stok';
    const __title = 'Report Stok';
    const __model = 'M_stok';

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

            $list = $this->M_stok->exportData($filter);

            $data = [];
            foreach ($list as $key => $value) {

                $row = [];
                $row[] = $key + 1;
                $row[] = $value->kode_barang;
                $row[] = $value->nama_brg;
                $row[] = $value->kategori;
                $row[] = date_indo(date('d-m-Y', strtotime($value->tanggal)));
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

            $data['excel'] = $this->M_stok->exportData($filter);
            $data['title'] = "Report Data Stok Barang Skymars Shop " . date("Y-m-d h:i");
            $data['title2'] = "Report Data Stok Barang Skymars Shop ";
            $data['tanggalAwal'] = $tanggalAwal;
            $data['tanggalAkhir'] = $tanggalAkhir;
            $data['allDate'] = $allDate;

            $this->load->view('' . self::__folder . 'v_laporan_excel', $data);
        } else {
            $this->loadkonten('Dashboard/layouts/no_akses', $data);
        }
    }
}

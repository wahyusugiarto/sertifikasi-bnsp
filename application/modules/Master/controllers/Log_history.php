<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Log_history extends AUTH_Controller
{

	const __tableName = 'tbl_log_transaksi';
	const __tableId   = 'id';
	const __folder    = 'v_history/';
	const __kode_menu = 'kode-log-history';
	const __title     = 'History Transaksi';
	const __model     = 'M_history';

	public function __construct()
	{
		parent::__construct();
		$this->load->model(self::__model);
		$this->load->model('M_sidebar');
	}

	public function loadkonten($page, $data)
	{

		$data['userdata'] 	= $this->userdata;
		$ajax = ($this->input->post('status_link') == "ajax" ? true : false);
		if (!$ajax) {
			$this->load->view('Dashboard/layouts/header', $data);
		}
		$this->load->view($page, $data);
		if (!$ajax) $this->load->view('Dashboard/layouts/footer', $data);
	}

	public function index()
	{
		$accessAdd = $this->M_sidebar->access('add', self::__kode_menu);
		$data['accessAdd']  = $accessAdd->menuview;
		$data['userdata'] 	= $this->session->userdata('nama');
		$data['page'] 		= self::__title;
		$data['judul'] 		= self::__title;

		$this->loadkonten('' . self::__folder . 'home', $data);
	}

	public function ajax_list()
	{
		$list = $this->M_history->getData();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $brand) {

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $brand->kode_transaksi;
			$row[] = $brand->nama_user;
			$row[] = $brand->aktivitas;
			$row[] = $brand->keterangan;
			$row[] = date('d-m-Y H:i', strtotime($brand->tanggal));
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}
}

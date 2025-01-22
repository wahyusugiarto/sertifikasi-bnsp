<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Penjualan extends AUTH_Controller
{

	const __tableName = 'tbl_penjualan';
	const __tableId   = 'no';
	const __folder    = 'v_penjualan/';
	const __kode_menu = 'kode-penjualan';
	const __title     = 'Data Penjualan';
	const __model     = 'M_penjualan';

	public function __construct()
	{
		parent::__construct();
		$this->load->model(self::__model);
		$this->load->model('M_generate_code');
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
		$accessEdit = $this->M_sidebar->access('edit', self::__kode_menu);
		$accessDel = $this->M_sidebar->access('del', self::__kode_menu);

		$tanggalAwal = $this->input->post('tanggal_awal');
		$tanggalAkhir = $this->input->post('tanggal_akhir');
		$allDate = $this->input->post('all_date');

		$filter = [
			'tanggal_awal' => $tanggalAwal,
			'tanggal_akhir' => $tanggalAkhir,
			'all_date' => $allDate,
		];

		$list = $this->M_penjualan->getData(1, $filter);
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $brand) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $brand->kode_penjualan;
			$row[] = date_indo(date('d-m-Y H:i', strtotime($brand->tanggal)));
			$row[] = $brand->status;
			$row[] = $brand->status_print;

			//add html for action
			$CetakInvoice = '';
			if ($accessEdit->menuview > 0) {
				$CetakInvoice = anchor('preview-invoice/' . $brand->kode_penjualan, ' <span tooltip="Preview Invoice"><span class="fa fa-print"></span> ', ' class="btn btn-icon btn-success klik ajaxify" ');
			}
			$buttonDel = '';
			if ($accessDel->menuview > 0) {
				$buttonDel = '<button class="btn btn-icon btn-danger hapus-penjualan" data-id=' . "'" . $brand->kode_penjualan . "'" . '><span tooltip="Delete Data"><i class="fa fa-trash"></i></button>';
			}

			$row[] = $CetakInvoice . ' ' . $buttonDel;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}

	public function Preview($id)
	{

		/*ini harus ada boss */
		$data['userdata'] = $this->userdata;
		$access = $this->M_sidebar->access('edit', self::__kode_menu);
		if ($access->menuview == 0) {
			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$this->loadkonten('Dashboard/layouts/no_akses', $data);
		}
		/*ini harus ada boss */ else {

			$data['dataslider'] = $this->M_penjualan->selectByKode($id);
			$data['detail']     = $this->M_penjualan->selectDetailCart($id);

			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$this->loadkonten('' . self::__folder . 'preview_invoice', $data);
		}
	}

	public function Print($id)
	{
		/*ini harus ada boss */
		$data['userdata'] = $this->userdata;
		$access = $this->M_sidebar->access('edit', self::__kode_menu);
		if ($access->menuview == 0) {
			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$this->loadkonten('Dashboard/layouts/no_akses', $data);
		}
		/*ini harus ada boss */ else {

			$data['dataslider'] = $this->M_penjualan->selectByKode($id);
			$data['detail']     = $this->M_penjualan->selectDetailCart($id);

			$res = array(
				'status_print' => 'Sudah Print',
			);

			$this->db->update(self::__tableName, $res, array('kode_penjualan' => $id));

			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$this->load->view('' . self::__folder . 'print_invoice', $data);
		}
	}



	public function hapus()
	{
		$errCode = 0;
		$errMessage = "";
		$token = $this->input->post('kode_penjualan');
		$this->db->trans_begin();

		if ($errCode == 0) {
			$access = $this->M_sidebar->access('del', self::__kode_menu);
			if ($access->menuview == 0) {
				$errCode++;
				$errMessage = "You don't have access.";
			}
		}

		if ($errCode == 0) {
			if (strlen($token) == 0) {
				$errCode++;
				$errMessage = "ID does not exist.";
			}
		}

		if ($errCode == 0) {
			$checkValid = $this->M_penjualan->selectByKode($token);
			if ($checkValid == null) {
				$errCode++;
				$errMessage = self::__title . " tidak valid.";
			}
		}

		if ($errCode == 0) {
			try {

				$this->db->delete(self::__tableName, array('kode_penjualan' => $token));
				$this->db->delete('tbl_detail_penjualan', array('kode_penjualan' => $token));
			} catch (Exception $ex) {
				$errCode++;
				$errMessage = $ex->getMessage();
			}
		}

		if ($errCode == 0) {
			if ($this->db->trans_status() === FALSE) {
				$errCode++;
				$errMessage = "Error failed delete.";
			}
		}

		if ($errCode == 0) {
			$this->db->trans_commit();
			$out = array('status' => true, 'pesan' => ' Data berhasil di hapus');
		} else {
			$this->db->trans_rollback();
			$out = array('status' => false, 'pesan' => $errMessage);
		}

		echo json_encode($out);
	}
}

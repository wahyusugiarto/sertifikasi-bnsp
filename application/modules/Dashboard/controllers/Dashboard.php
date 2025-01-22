<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Dashboard extends AUTH_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('M_total');
	}

	public function loadkonten($page, $data)
	{

		$data['userdata'] 	= $this->userdata;
		$ajax = ($this->input->post('status_link') == "ajax" ? true : false);
		if (!$ajax) {
			$this->load->view('layouts/header', $data);
		}
		$this->load->view($page, $data);
		if (!$ajax) $this->load->view('layouts/footer', $data);
	}


	public function index()
	{
		$data['pelanggan']    = $this->M_total->totalPelanggan();
		$data['inventory']    = $this->M_total->totalInventory();
		$data['penjualan']    = $this->M_total->totalOrder();
		$data['transaksi']    = $this->M_total->totalTransaksi();
		$data['graph'] 		  = $this->M_total->get_total_penjualan();
		$data['userdata'] 	  = $this->userdata;
		$data['page'] 		  = "home";
		$data['judul'] 		  = "Dashboard";

		$this->loadkonten('home', $data);
	}
}

/* End of file Home.php */
/* Location: ./application/controllers/Home.php */
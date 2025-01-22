<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pembelian extends AUTH_Controller
{

	const __tableName = 'tbl_pembelian';
	const __tableId   = 'no';
	const __folder    = 'v_pembelian/';
	const __kode_menu = 'kode-pembelian';
	const __title     = 'Pembelian Barang';
	const __model     = 'M_pembelian';

	public function __construct()
	{
		parent::__construct();
		$this->load->model(self::__model);
		$this->load->model('M_sidebar');
		$this->load->model('M_generate_code');
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

	public function get_total()
	{
		$this->db->select_sum('subtotal');
		$this->db->from('tbl_temp_beli');
		$this->db->where('sess_id', session_id());
		$query = $this->db->get();
		return $query->row()->subtotal;
	}

	public function del_cart()
	{
		$token = $this->input->post('no');
		$result = $result = $this->db->delete('tbl_temp_beli', array('no' => $token));

		if ($result > 0) {
			$out = array('status' => true, 'pesan' => ' Data berhasil di hapus');
		} else {
			$out = array('status' => false, 'pesan' => 'Data Gagal di hapus');
		}

		echo json_encode($out);
	}

	public function delallcart()
	{
		$where = array(
			'sess_id' => session_id()
		);
		$this->M_pembelian->delcart($where, 'tbl_temp_beli');
	}

	public function searchBrg()
	{
		$data = array(
			'barang' => $this->M_pembelian->tampil()->result(),
		);
		$this->load->view('v_pembelian/v_cr_brg_beli', $data);
	}

	public function view_beli()
	{
		$where = array(
			'sess_id' => session_id()
		);
		$data = array(
			'cart' => $this->M_pembelian->tampil_cart($where, 'tbl_temp_beli')->result(),
			'total' 	=> $this->get_total(),
			'supplier'   => $this->M_pembelian->selekSupplier(),
		);
		$this->load->view('v_pembelian/v_beli', $data);
	}

	public function add_cart()
	{

		$where = array(
			'id' 		=> $this->input->post('kd_brg', TRUE),
			'sess_id'	=> session_id()
		);
		$cek = $this->M_pembelian->tampil_cart($where, 'tbl_temp_beli')->num_rows();
		$data = array(
			'id' 		=> $this->input->post('kd_brg', TRUE),
			'gambar' 	=> $this->input->post('gambar', TRUE),
			'qty' 		=> $this->input->post('qty', TRUE),
			'price' 	=> str_replace(".", "", $this->input->post('harga', TRUE)),
			'name' 		=> $this->input->post('nama', TRUE),
			'subtotal'	=> $this->input->post('qty', TRUE) * str_replace(".", "", $this->input->post('harga', TRUE)),
			'sess_id' 	=> session_id(),
		);
		//jika kosong 
		if ($cek == 0) {
			$this->db->insert('tbl_temp_beli', $data);
		} else { // jika ada 
			$this->db->set('qty', 'qty+' . $data['qty'], FALSE);
			$this->db->set('subtotal', 'price*qty', FALSE);
			$this->db->where('id', $data['id']);
		}
	}

	public function buyProduct()
	{
		$errCode = 0;
		$errMessage = "";
		$this->db->trans_begin();

		$where = array('sess_id'	=> session_id());
		$cekTmpData   = $this->M_pembelian->cek_beli($where, 'tbl_temp_beli')->num_rows();
		$buyCheckTmp = $this->M_pembelian->tampil_cart($where, 'tbl_temp_beli')->result();

		$idToko =  $this->session->userdata('id_toko');
		$username =  $this->session->userdata('nama');

		if ($errCode == 0) {
			if ($cekTmpData < 0) {
				$errCode++;
				$errMessage = "Maaf anda harus input barang dahulu !";
			}
		}

		if ($errCode == 0) {
			if (empty($buyCheckTmp)) {
				$errCode++;
				$errMessage = "Maaf anda harus input barang dahulu !";
			}
		}

		if ($errCode == 0) {

			try {

				$code = $this->M_generate_code->getNextPurchase();
				$supplier = trim($this->input->post("supplier"));

				//SAVE DETAIL pembelian
				foreach ($buyCheckTmp  as $b) {
					$data[] = array(
						'nonota' 	 => $code,
						'id_brg' 	 => $b->id,
						'nama_brg'	 => $b->name,
						'jml_brg' 	 => $b->qty,
						'harga_brg'	 => $b->price,
					);
				}
				$this->M_pembelian->savecart($data, 'tbl_detail_pembelian');
				$this->add_so($where);

				foreach ($buyCheckTmp  as $b) {
					$dataHistory[] = array(
						'kode_transaksi'  => $code,
						'nama_user' 	  => $username,
						'aktivitas'	      => 'Pembelian',
						'id_toko'   	  => $idToko,
						'keterangan' => '<b>' . $username . '</b> Telah Melakukan Pembelian Barang di Supplier <b>' . $supplier . ' </b>Dengan Nama Barang <b>' . $b->name . '</b> sejumlah <b>' . $b->qty . '</b> Pcs',
					);
				}
				$this->db->insert_batch('tbl_log_transaksi', $dataHistory);


				// SAVE ORDER TO DATABASE 
				$order = array(
					'no_beli' 	 => $code,
					'supplier' 	 => $supplier,
					'total'	 	 => $this->get_total(),
					'id_toko'    => $idToko,
				);
				$this->updatestok();
				$this->M_pembelian->saveorder($order, 'tbl_pembelian');
				$this->delallcart();
			} catch (Exception $ex) {
				$errCode++;
				$errMessage = $ex->getMessage();
			}
		}

		if ($errCode == 0) {
			$this->db->trans_commit();
			$out = array('status' => true, 'pesan' => ' Data berhasil di simpan');
		} else {
			$this->db->trans_rollback();
			$out = array('status' => false, 'pesan' => $errMessage);
		}

		echo json_encode($out);
	}

	public function updatestok()
	{
		$where = array(
			'sess_id' => session_id()
		);
		$tampil = $this->M_pembelian->tampil_cart($where, 'tbl_temp_beli')->result();

		foreach ($tampil as $t) {
			$stok 	= $t->qty;
			$id 	= $t->id;
			$this->M_pembelian->updatestock($stok, $id, 'tbl_product');
		}
	}

	public function updatecart()
	{
		$data = array(
			'id' 	=> $this->input->post('id', TRUE),
			'qty'	=> $this->input->post('editval', TRUE)
		);

		$this->db->set('qty', $data['qty']);
		$this->db->set('subtotal', 'qty*price', FALSE);
		$this->db->where('sess_id', session_id());
		$this->db->where('id', $data['id']);
		$this->db->update('tbl_temp_beli');
	}

	public function add_so($where)
	{
		//INPUT STOK MASUK 
		$idToko =  $this->session->userdata('id_toko');
		$beli 	= $this->M_pembelian->tampil_cart($where, 'tbl_temp_beli')->result();
		foreach ($beli as $b) {
			$data[] = array(
				'id_brg' 	 => $b->id,
				'nama_brg'	 => $b->name,
				'id_toko'    => $idToko,
				'beli' 	 	 => $b->qty,
				'tanggal'	 => date('Y-m-d')
			);
		}
		$this->db->insert_batch('tbl_so', $data);
	}

	public function del_pers_akhir()
	{
		$this->M_pembelian->del_pers_akhir();
	}
}

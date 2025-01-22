<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pelanggan extends AUTH_Controller
{

	const __tableName = 'tbl_pelanggan';
	const __tableId   = 'id_pelanggan';
	const __folder    = 'v_pelanggan/';
	const __kode_menu = 'kode-pelanggan';
	const __title     = 'Pelanggan';
	const __model     = 'M_pelanggan';

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
		$accessEdit = $this->M_sidebar->access('edit', self::__kode_menu);
		$accessDel = $this->M_sidebar->access('del', self::__kode_menu);
		$list = $this->M_pelanggan->get_data();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $brand) {

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = $brand->nama;
			$row[] = $brand->telp;
			$row[] = $brand->alamat;

			//add html for action
			$buttonEdit = '';
			if ($accessEdit->menuview > 0) {
				$buttonEdit = anchor('edit-pelanggan/' . $brand->id_pelanggan, ' <span tooltip="Edit Data"><span class="fa fa-edit"></span> ', ' class="btn btn-icon btn-primary klik ajaxify" ');
			}
			$buttonDel = '';
			if ($accessDel->menuview > 0) {
				$buttonDel = '<button class="btn btn-icon btn-danger hapus-pelanggan" data-id=' . "'" . $brand->id_pelanggan . "'" . '><span tooltip="Delete Data"><i class="fa fa-trash"></i></button>';
			}

			$row[] = $buttonEdit . '  ' . $buttonDel;
			$data[] = $row;
		}

		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}


	public function Add()
	{

		/*ini harus ada boss */
		$data['userdata'] = $this->userdata;
		$access = $this->M_sidebar->access('add', self::__kode_menu);
		if ($access->menuview == 0) {
			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$this->loadkonten('Dashboard/layouts/no_akses', $data);
		}

		/*ini harus ada boss */ else {
			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;

			$this->loadkonten('' . self::__folder . 'tambah', $data);
		}
	}

	public function prosesTambah()
	{

		$errCode = 0;
		$errMessage = "";

		$date = date('Y-m-d');
		$nama = trim($this->input->post("nama"));
		$telp = trim($this->input->post("telp"));
		$alamat = trim($this->input->post("alamat"));
		$idToko =  $this->session->userdata('id_toko');

		$this->db->trans_begin();

		if ($errCode == 0) {
			if (strlen($alamat) == 0) {
				$errCode++;
				$errMessage = "Alamat wajib di isi.";
			}
		}

		if ($errCode == 0) {
			if (strlen($telp) == 0) {
				$errCode++;
				$errMessage = "Telpon wajib di isi.";
			}
		}

		if ($errCode == 0) {
			if (strlen($nama) == 0) {
				$errCode++;
				$errMessage = "Nama wajib di isi.";
			}
		}

		if ($errCode == 0) {
			$access = $this->M_sidebar->access('add', self::__kode_menu);
			if ($access->menuview == 0) {
				$errCode++;
				$errMessage = "You don't have access.";
			}
		}

		if ($errCode == 0) {
			try {
				$data = array(
					'nama' => $nama,
					'telp' => $telp,
					'alamat' => $alamat,
					'created_date' => $date,
					'id_toko'   => $idToko,
				);
				$this->db->insert(self::__tableName, $data);
			} catch (Exception $ex) {
				$errCode++;
				$errMessage = $ex->getMessage();
			}
		}

		if ($errCode == 0) {
			if ($this->db->trans_status() === FALSE) {
				$errCode++;
				$errMessage = "Error saving databse.";
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


	public function Edit($id)
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

			$where = array(self::__tableId => $id);
			$data['dataslider']       = $this->M_pelanggan->selectById($id);

			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$this->loadkonten('' . self::__folder . 'update', $data);
		}
	}

	public function prosesUpdate()
	{

		$id = trim($this->input->post(self::__tableId));
		$errCode = 0;
		$errMessage = "";

		$date = date('Y-m-d');
		$nama = trim($this->input->post("nama"));
		$telp = trim($this->input->post("telp"));
		$alamat = trim($this->input->post("alamat"));

		$this->db->trans_begin();


		if ($errCode == 0) {
			if (strlen($alamat) == 0) {
				$errCode++;
				$errMessage = "Alamat wajib di isi.";
			}
		}

		if ($errCode == 0) {
			if (strlen($telp) == 0) {
				$errCode++;
				$errMessage = "Telpon wajib di isi.";
			}
		}

		if ($errCode == 0) {
			if (strlen($nama) == 0) {
				$errCode++;
				$errMessage = "Nama wajib di isi.";
			}
		}

		if ($errCode == 0) {
			$checkValid = $this->M_pelanggan->selectById($id);
			if ($checkValid == null) {
				$errCode++;
				$errMessage = self::__title . " tidak valid.";
			}
		}

		if ($errCode == 0) {
			if (strlen($id) == 0) {
				$errCode++;
				$errMessage = "ID does not exist.";
			}
		}

		if ($errCode == 0) {
			$access = $this->M_sidebar->access('edit', self::__kode_menu);
			if ($access->menuview == 0) {
				$errCode++;
				$errMessage = "You don't have access.";
			}
		}

		if ($errCode == 0) {
			try {
				$data = array(
					'nama' => $nama,
					'telp' => $telp,
					'alamat' => $alamat,
					'updated_date' => $date,
				);
				$this->db->update(self::__tableName, $data, array(self::__tableId => $id));
			} catch (Exception $ex) {
				$errCode++;
				$errMessage = $ex->getMessage();
			}
		}

		if ($errCode == 0) {
			if ($this->db->trans_status() === FALSE) {
				$errCode++;
				$errMessage = "Error saving databse.";
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

	public function hapus()
	{

		$errCode = 0;
		$errMessage = "";
		$token = $this->input->post('id_pelanggan');
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
			$checkValid = $this->M_pelanggan->selectById($token);
			if ($checkValid == null) {
				$errCode++;
				$errMessage = self::__title . " tidak valid.";
			}
		}

		if ($errCode == 0) {
			try {
				$this->db->delete(self::__tableName, array(self::__tableId => $token));
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

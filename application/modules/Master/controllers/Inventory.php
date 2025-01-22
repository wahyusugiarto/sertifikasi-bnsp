<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Inventory extends AUTH_Controller
{

	const __tableName = 'tbl_product';
	const __tableId   = 'id';
	const __folder    = 'v_inventory/';
	const __kode_menu = 'kode-inventory';
	const __title     = 'Inventory Produk';
	const __model     = 'M_inventory';

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

	function ambilData()
	{

		$modul = $this->input->post('modul');

		if ($modul == "kategori") {
			$id = $this->input->post('id_kategori');
			echo $this->M_inventory->selectKat($id);
		} elseif ($modul == "sub_kategori") {
			$id = $this->input->post('id_kategori');
			echo $this->M_inventory->selectSubKat($id);
		}
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
		$list = $this->M_inventory->get_data();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $brand) {


			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<a href="' . $brand->gambar . '" target="_blank"><img class="img-thumbnail" src="' . $brand->gambar . '"   width="70" /></a>';
			$row[] = $brand->nama;
			$row[] = $brand->kategori;
			$row[] = $brand->sub_kategori;
			$row[] = $brand->stok . ' pcs';

			//add html for action
			$buttonEdit = '';
			if ($accessEdit->menuview > 0) {
				$buttonEdit = anchor('edit-inventory/' . $brand->id, ' <span tooltip="Edit Data"><span class="fa fa-edit"></span> ', ' class="btn btn-icon btn-primary klik ajaxify" ');
			}

			$buttonDel = '';
			if ($accessDel->menuview > 0) {
				$buttonDel = '<button class="btn btn-icon btn-danger hapus-inventory" data-id=' . "'" . $brand->id . "'" . '><span tooltip="Delete Data"><i class="fa fa-trash"></i></button>';
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
			$data['kategori']   = $this->M_inventory->selekKategori();
			$data['sub_kategori']   = $this->M_inventory->selekSubKategori();
			$this->loadkonten('' . self::__folder . 'tambah', $data);
		}
	}

	public function prosesTambah()
	{
		$GbrSingle = $this->input->post('gambar_single');
		$tipeFile = $this->input->post('gambar_single_tp');
		$idToko =  $this->session->userdata('id_toko');
		$kodeBarang = $this->M_inventory->CreateCode();

		$errCode = 0;
		$errMessage = "";
		$this->db->trans_begin();

		if ($errCode == 0) {
			$access = $this->M_sidebar->access('add', self::__kode_menu);
			if ($access->menuview == 0) {
				$errCode++;
				$errMessage = "You don't have access.";
			}
		}

		if ($errCode == 0) {
			if (strlen($_POST["harga_jual"]) == 0) {
				$errCode++;
				$errMessage = "harga wajib di isi.";
			}
		}

		if ($errCode == 0) {
			if (strlen($_POST["harga_beli"]) == 0) {
				$errCode++;
				$errMessage = "harga beli di isi.";
			}
		}

		if ($errCode == 0) {
			if (strlen($_POST["sub_kategori"]) == 0) {
				$errCode++;
				$errMessage = "sub kategori barang kosong";
			}
		}

		if ($errCode == 0) {
			if (strlen($_POST["kategori"]) == 0) {
				$errCode++;
				$errMessage = "kategori barang kosong";
			}
		}

		if ($errCode == 0) {
			if (strlen($_POST["nama"]) == 0) {
				$errCode++;
				$errMessage = "nama barang kosong";
			}
		}

		if ($errCode == 0) {
			if ($tipeFile <> 'jpg' && $tipeFile <> 'png' && $tipeFile <> 'jpeg') {
				$errCode++;
				$errMessage = "gambar harus ekstensi jpg/png";
			}
		}

		if ($errCode == 0) {
			if ($GbrSingle == '') {
				$errCode++;
				$errMessage = "gambar tidak boleh kosong!";
			}
		}

		if ($errCode == 0) {

			try {
				$data = array(
					'nama' 		   => $this->input->post('nama'),
					'kode_barang'  => $kodeBarang,
					'kategori' 	   => $this->input->post('kategori'),
					'sub_kategori' => $this->input->post('sub_kategori'),
					'harga_beli'   => trim($this->input->post("harga_beli")),
					'harga_jual'   => trim($this->input->post("harga_jual")),
					'stok' 	       => $this->input->post('stok'),
					'gambar'       => $GbrSingle,
					'id_toko'      => $idToko,
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
			$out = array('status' => true, 'pesan' => ' Data produk berhasil disimpan');
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
			$data['dataslider']       = $this->M_inventory->selectById($id);
			$data['kategori']   = $this->M_inventory->selekKategori();
			$data['sub_kategori']   = $this->M_inventory->selekSubKategori();

			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$this->loadkonten('' . self::__folder . 'update', $data);
		}
	}

	public function prosesUpdate()
	{

		$id = trim($this->input->post(self::__tableId));
		$err = 0;
		$GbrSingle = $this->input->post('gambar_single');
		$tipeFile = $this->input->post('gambar_single_tp');

		$errCode = 0;
		$errMessage = "";
		$this->db->trans_begin();


		if ($errCode == 0) {
			$access = $this->M_sidebar->access('edit', self::__kode_menu);
			if ($access->menuview == 0) {
				$errCode++;
				$errMessage = "You don't have access.";
			}
		}

		if ($errCode == 0) {
			if (strlen($_POST["harga_jual"]) == 0) {
				$errCode++;
				$errMessage = "harga wajib di isi.";
			}
		}


		if ($errCode == 0) {
			if (strlen($_POST["harga_beli"]) == 0) {
				$errCode++;
				$errMessage = "harga beli di isi.";
			}
		}


		if ($errCode == 0) {
			if (strlen($_POST["sub_kategori"]) == 0) {
				$errCode++;
				$errMessage = "sub kategori barang kosong";
			}
		}


		if ($errCode == 0) {
			if (strlen($_POST["kategori"]) == 0) {
				$errCode++;
				$errMessage = "kategori barang kosong";
			}
		}

		if ($errCode == 0) {
			if (strlen($_POST["nama"]) == 0) {
				$errCode++;
				$errMessage = "nama barang kosong";
			}
		}

		if ($errCode == 0) {
			if (strlen($id) == 0) {
				$errCode++;
				$errMessage = "ID does not exist";
			}
		}


		if ($errCode == 0) {
			$checkValid = $this->M_inventory->selectById($id);
			if ($checkValid == null) {
				$err++;
				$errMessage = '' . self::__title . ' tidak valid';
			}
		}



		if ($errCode == 0) {
			try {
				if ($GbrSingle != '') {

					if ($tipeFile <> 'jpg' && $tipeFile <> 'png' && $tipeFile <> 'jpeg') {
						$err++;
						$errMessage = 'gambar harus ekstensi jpg/png';
					} else {

						$data = array(
							'nama' 		   => $this->input->post('nama'),
							'kategori' 	   => $this->input->post('kategori'),
							'sub_kategori' => $this->input->post('sub_kategori'),
							'harga_beli'   => $this->input->post('harga_beli'),
							'harga_jual'   => $this->input->post('harga_jual'),
							'gambar'       => $GbrSingle,
						);

						$this->db->update(self::__tableName, $data, array(self::__tableId => $id));

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
					}
				} else {

					$data = array(
						'nama' 		   => $this->input->post('nama'),
						'kategori' 	   => $this->input->post('kategori'),
						'sub_kategori' => $this->input->post('sub_kategori'),
						'harga_beli'   => $this->input->post('harga_beli'),
						'harga_jual'   => $this->input->post('harga_jual'),
					);

					$this->db->update(self::__tableName, $data, array(self::__tableId => $id));

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
				}
			} catch (Exception $ex) {
				$errCode++;
				$errMessage = $ex->getMessage();
			}
		}

		echo json_encode($out);
	}

	public function hapus()
	{

		$token = $this->input->post('id');
		$gambar = $this->db->get_where('tbl_product', array('id' => $token));

		if ($errCode == 0) {
			$checkValid = $this->M_inventory->selectById($token);
			if ($checkValid == null) {
				$err++;
				$out = array('status' => false, 'pesan' => '' . self::__title . ' tidak valid');
			}
		}

		if ($errCode == 0) {
			$access = $this->M_sidebar->access('del', self::__kode_menu);
			if ($access->menuview == 0) {
				$err++;
				$out = array('status' => false, 'pesan' => 'You dont have access.');
			}
		}

		if ($errCode == 0) {
			if (strlen($token) == 0) {
				$err++;
				$out = array('status' => false, 'pesan' => 'ID does not exist.');
			}
		}

		$result = $this->db->delete('tbl_product', array('id' => $token));

		if ($result > 0) {
			$out = array('status' => true, 'pesan' => 'Data has been deleted');
		} else {
			$out = array('status' => false, 'pesan' => 'Data has been failed deleted!');
		}
		echo json_encode($out);
	}
}

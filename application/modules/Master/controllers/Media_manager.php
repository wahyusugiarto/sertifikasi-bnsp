<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Media_manager extends AUTH_Controller
{

	const __tableName = 'tbl_galeri';
	const __tableId   = 'id';
	const __folder    = 'v_media_manager/';
	const __kode_menu = 'kode-media-manager';
	const __title     = 'Master Media Manager';
	const __model     = 'M_galeri_manager';

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
		$data['list']     = $this->M_galeri_manager->get_data();

		$this->loadkonten('' . self::__folder . 'home', $data);
	}

	public function LoadTes()
	{
		$accessEdit = $this->M_sidebar->access('edit', self::__kode_menu);
		$accessDel = $this->M_sidebar->access('del', self::__kode_menu);
		$list = $this->M_galeri_manager->get_data_tes();
		$data = array();
		$no = $_POST['start'];
		foreach ($list as $brand) {
			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<a href="' . $brand->file1 . '" target="_blank"><img class="img-thumbnail" src="' . $brand->file1 . '"   width="90" /></a>';
			$row[] = '<a href="' . $brand->file2 . '" target="_blank"><img class="img-thumbnail" src="' . $brand->file2 . '"   width="90" /></a>';
			$row[] = $brand->judul;
			//add html for action
			$buttonEdit = '';
			if ($accessEdit->menuview > 0) {
				$buttonEdit = anchor('edit-tes/' . $brand->id, ' <span tooltip="Edit Data"><span class="fa fa-edit"></span> ', ' class="btn btn-sm btn-primary klik ajaxify" ');
			}
			$buttonDel = '';
			if ($accessDel->menuview > 0) {
				$buttonDel = '<button class="btn btn-sm btn-danger hapus-galeri" data-id=' . "'" . $brand->id . "'" . '><span tooltip="Delete Data"><i class="fa fa-trash"></i></button>';
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
			// $data['Status']     = $this->M_file->selek_status();	

			$this->loadkonten('' . self::__folder . 'add', $data);
		}
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
			$data['brand']      = $this->M_galeri_manager->SelectTesId($id);
			$data['mult']       = $this->M_galeri_manager->SelectByMult($id);
			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$this->loadkonten('' . self::__folder . 'update', $data);
		}
	}

	public function HapusTes()
	{

		$id = $this->input->post('id');
		$result = $this->db->delete('tbl_file_looping', array('id' => $id));
		if ($result > 0) {
			$out = array('status' => true, 'pesan' => 'Data berhasil dihapus');
		} else {
			$out = array('status' => false, 'pesan' => 'Data gagal dihapus!');
		}
		echo json_encode($out);
	}

	public function prosesAdd()
	{

		$username = $this->userdata->nama;
		$date = date('Y-m-d H:i:s');
		$err = 0;
		$GbrSingle = $this->input->post('gambar_single');
		$GbrSingleSc = $this->input->post('gambar_single_sc');
		$tipeFile = $this->input->post('gambar_single_tp');
		$tipeFile2 = $this->input->post('gambar_single_sc_tp');
		$GbrMultiple = $this->input->post('gambar_multi');
		$tipeFile3 = $this->input->post('gambar_multi_tp');

		$this->db->trans_begin();

		if ($tipeFile <> 'jpg' && $tipeFile <> 'png') {
			$err++;
			$out = array('status' => false, 'pesan' => 'gambar harus ekstensi jpg/png');
		}

		if ($tipeFile2 <> 'jpg' && $tipeFile2 <> 'png') {
			$err++;
			$out = array('status' => false, 'pesan' => 'gambar harus ekstensi jpg/png');
		}

		if ($GbrMultiple == '') {
			$err++;
			$out = array('status' => false, 'pesan' => 'gambar kosong!');
		}

		if ($tipeFile3 <> 'jpg' && $tipeFile3 <> 'png') {
			$err++;
			$out = array('status' => false, 'pesan' => 'gambar harus ekstensi jpg/png');
		}


		if ($GbrSingleSc == '') {
			$err++;
			$out = array('status' => false, 'pesan' => 'gambar 2 kosong!');
		}

		if ($GbrSingle == '') {
			$err++;
			$out = array('status' => false, 'pesan' => 'gambar 1 kosong!');
		}

		if (strlen($_POST["judul"]) == 0) {
			$err++;
			$out = array('status' => false, 'pesan' => 'judul kosong!');
		}

		if ($err == 0) {
			$data = array(
				'judul'      => $this->input->post('judul'),
				'file1'      => $this->input->post('gambar_single'),
				'file2'      => $this->input->post('gambar_single_sc'),

			);
			$result = $this->db->insert('tbl_tes', $data);
			$idPengajuan = $this->db->insert_id();

			if (strlen($idPengajuan) > 0) {
				foreach ($GbrMultiple as $row) {
					$data = array(
						'id_pengajuan' => $idPengajuan,
						'file' => $row
					);
					$result = $this->db->insert('tbl_file_looping', $data);
				}
			}

			if ($this->db->trans_status() === FALSE) {
				$out = array('status' => false, 'pesan' => 'Data has been failed saved!');
			}

			if ($result > 0) {
				$this->db->trans_commit();
				$out = array('status' => true, 'pesan' => ' Data has been saved');
			} else {
				$this->db->trans_rollback();
				$out = array('status' => false, 'pesan' => 'Data has been failed saved!');
			}
		}

		echo json_encode($out);
	}


	public function prosesUpdate()
	{

		$username = $this->userdata->nama;
		$date = date('Y-m-d H:i:s');
		$err = 0;
		$where = $this->input->post('id');
		$tipeFile   = $this->input->post('gambar_single_tp');
		$tipeFile2  = $this->input->post('gambar_single_sc_tp');
		$inputFile1 = $this->input->post('gambar_single');
		$inputFile2 = $this->input->post('gambar_single_sc');

		$this->db->trans_begin();

		if (strlen($_POST["judul"]) == 0) {
			$err++;
			$out = array('status' => false, 'pesan' => 'judul kosong!');
		}

		if ($err == 0) {

			if ($inputFile1 != '') {

				if ($tipeFile <> 'jpg' && $tipeFile <> 'png') {
					$out = array('status' => false, 'pesan' => 'gambar harus ekstensi jpg/png');
				} else {

					$data = array(
						'file1'      => $this->input->post('gambar_single'),
					);

					$result = $this->db->update('tbl_tes', $data, array('id' => $where));

					if ($this->db->trans_status() === FALSE) {
						$out = array('status' => false, 'pesan' => 'Data has been failed saved!');
					}

					if ($result > 0) {
						$this->db->trans_commit();
						$out = array('status' => true, 'pesan' => ' Data has been saved');
					} else {
						$this->db->trans_rollback();
						$out = array('status' => false, 'pesan' => 'Data has been failed saved!');
					}
				}
			} elseif ($inputFile2 != '') {

				if ($tipeFile2 <> 'jpg' && $tipeFile2 <> 'png') {
					$out = array('status' => false, 'pesan' => 'gambar harus ekstensi jpg/png');
				} else {

					$data = array(
						'file2'      => $this->input->post('gambar_single_sc'),
					);

					$result = $this->db->update('tbl_tes', $data, array('id' => $where));

					if ($this->db->trans_status() === FALSE) {
						$out = array('status' => false, 'pesan' => 'Data has been failed saved!');
					}

					if ($result > 0) {
						$this->db->trans_commit();
						$out = array('status' => true, 'pesan' => ' Data has been saved');
					} else {
						$this->db->trans_rollback();
						$out = array('status' => false, 'pesan' => 'Data has been failed saved!');
					}
				}
			} else {
				$data = array(
					'judul'      => $this->input->post('judul'),
				);

				$result = $this->db->update('tbl_tes', $data, array('id' => $where));

				if ($this->db->trans_status() === FALSE) {
					$out = array('status' => false, 'pesan' => 'Data has been failed saved!');
				}

				if ($result > 0) {
					$this->db->trans_commit();
					$out = array('status' => true, 'pesan' => ' Data has been saved');
				} else {
					$this->db->trans_rollback();
					$out = array('status' => false, 'pesan' => 'Data has been failed saved!');
				}
			}
		}

		echo json_encode($out);
	}


	public function prosesUploadMultiple()
	{

		$username = $this->userdata->nama;
		$date = date('Y-m-d H:i:s');
		$err = 0;

		$GbrMultiple = $this->input->post('gambar_multi');
		$tipeFile3 = $this->input->post('gambar_multi_tp');

		$this->db->trans_begin();

		if ($tipeFile3 <> 'jpg' && $tipeFile3 <> 'png') {
			$err++;
			$out = array('status' => false, 'pesan' => 'gambar harus ekstensi jpg/png');
		}

		if ($GbrMultiple == '') {
			$err++;
			$out = array('status' => false, 'pesan' => 'gambar kosong!');
		}

		if ($err == 0) {
			$idPengajuan = $this->input->post('id_pengajuan');
			if (strlen($idPengajuan) > 0) {
				foreach ($GbrMultiple as $row) {
					$data = array(
						'id_pengajuan' => $idPengajuan,
						'file' => $row
					);
					$result = $this->db->insert('tbl_file_looping', $data);
				}
			}

			if ($this->db->trans_status() === FALSE) {
				$out = array('status' => false, 'pesan' => 'Data has been failed saved!');
			}

			if ($result > 0) {
				$this->db->trans_commit();
				$out = array('status' => true, 'pesan' => ' Data has been saved');
			} else {
				$this->db->trans_rollback();
				$out = array('status' => false, 'pesan' => 'Data has been failed saved!');
			}
		}

		echo json_encode($out);
	}

	function fsize($file)
	{
		$a = array("B", "KB", "MB", "GB", "TB", "PB");
		$pos = 0;
		$size = filesize($file);
		while ($size >= 1024) {
			$size /= 1024;
			$pos++;
		}
		// return round ($size,2)." ".$a[$pos];
		return round($size) . " " . $a[$pos];
	}

	function LoadMediaManager()
	{
		$output = '';
		$query = '';
		$tipe = '';
		$no = 1;
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->M_galeri_manager->LoadMediaManager($query);
		if ($data->num_rows() > 0) {
			foreach ($data->result() as $row) {

				$ukuranFile = $row->gambar;
				$ukuranFileRes = $this->fsize($ukuranFile);
				if (getimagesize($row->gambar) != '') {
					list($width, $height) = getimagesize($row->gambar);
					$ukuranDimension = $width . ' x ' . $height . ' px';
				} else {
					$ukuranDimension = "-";
				}

				$no++;

				if ($row->gambar == '') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pdf') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pdf-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'docx') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'doc') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'ppt') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pptx') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp3') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/mp3-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp4') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/mp4-icon.png" /></center>';
				} else {
					$gambar = '<img class="shadow" id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '' . $row->gambar . '">';
				}

				if ($row->gambar == '') {
					$gambarDetail = '<img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pdf') {
					$gambarDetail = '<iframe src="' . base_url() . '' . $row->gambar . '" width="120" height="140"></iframe>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'doc') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'docx') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'ppt') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pptx') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp3') {
					$gambarDetail = ' <audio style="width:150px;" controls>
					<source src="' . base_url() . '' . $row->gambar . '" type="audio/ogg">
					<source src="' . base_url() . '' . $row->gambar . '" type="audio/mpeg">';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp4') {
					$gambarDetail = ' <video width="150" controls>
					<source src="' . base_url() . '' . $row->gambar . '" type="video/mp4">
					<source src="' . base_url() . '' . $row->gambar . '" type="video/ogg">
					</video>';
				} else {
					$gambarDetail = '<div id="librayr">
					<a href="#">
					<div class="konten2">
					' . $gambar . '
					</a>
					<div class="middle2">
					<a class="fancybox " href="' . base_url() . '' . $row->gambar . '" data-fancybox-group="gallery" title="' . $row->judul_gambar . '"><div class="lingkaran2"><i class="fa fa-search-plus field-icon2" aria-hidden="true"></i></div></a>
					</div>
					</div></div>';
				}


				$output .= '
				<div class="" style="margin-top: 15px;">
				<div class="konten-media ">
				<div id="librayr">
				<div class="konten">
				<a href="#">
				<label class="container2"><input type="checkbox" class="insert_check" name="images-check">
				' . $gambar . '
				<span class="checkmark2"></span></label></a>
				<div class="middle">
				<a href="#" class="popups" id="mpopupLink' . $no . '" data-id=' . "'" . $no . "'" . '><div class="lingkaran"><i class="fa fa-search-plus field-icon2" aria-hidden="true"></i></div></a>
				</div>

				
				<div id="mpopupBox' . $no . '" class="mpopup">
				<div class="modal-content2">
				<div class="modal-header2">
				
				<h4><i class="fa fa-question-circle field-icon2" aria-hidden="true"></i> Detail Informasi</h4>
				</div>
				<div class="modal-body2">
				<div class="row">
				<center><div class="col-md-3" style="margin-top:10px; margin-left:-60px; margin-right:40px;">' . $gambarDetail . '</div></center>
				<div class="col-md-9" style="margin-top:10px;">
				<table id="customers" style="margin-bottom:30px;">
				<tr> 
				<th width="180px;">Judul </th><td>&nbsp;' . $row->judul_gambar . '</td>
				</tr>
				<tr> 
				<th>Path</th><td><div class="input-group"><span tooltip="Copy Link" style="padding:9px;" class="input-group-addon" onclick="myFunction(' . $no . ')"><a href ="#"><i class="fa fa-clone" aria-hidden="true"></i></a></span><input style="width:235px; margin-top:0px;" type="text" class="form-control" id="myInput' . $no . '" name="hasil_link" value="' . base_url() . $row->gambar . '"></div></td>
				</tr>

				<tr> 
				<th>Dimensi / Ukuran / Tipe</th><td><span class="badge bg-blue">' . $ukuranDimension . '</span> / 
				<span class="badge bg-blue">' . $ukuranFileRes . '</span> / <span class="badge bg-blue">' . $row->ekstensi . '</span>  </td>
				</tr>

				<tr> 
				<th>Di Upload Oleh </th><td>&nbsp;' . $row->created_by . '</td>
				</tr>

				<tr> 
				<th>Tanggal Upload </th><td>&nbsp;' . date('d-m-Y', strtotime($row->created_date)) . '</td>
				</tr>

				</table>
				</div>
				</div>
				</div>
				</div>

				</div>
				</div>
				</div></div></div>';
			}
		} else {
			$output .= '<center><img style="border-color:white; margin-top:50px; width:230px; height:230px;" src="' . base_url() . '/assets/tambahan/gambar/no-result.png" /></center>';
		}
		$output .= '</table>';
		echo $output;
	}

	function LoadMediaManager2()
	{
		$output = '';
		$query = '';
		$tipe = '';
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->M_galeri_manager->LoadMediaManager2($query);
		if ($data->num_rows() > 0) {
			foreach ($data->result() as $row) {

				$ukuranFile = $row->gambar;
				$ukuranFileRes = $this->fsize($ukuranFile);
				if (getimagesize($row->gambar) != '') {
					list($width, $height) = getimagesize($row->gambar);
					$ukuranDimension = $width . ' x ' . $height . ' px';
				} else {
					$ukuranDimension = "-";
				}

				$no++;

				if ($row->gambar == '') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pdf') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pdf-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'docx') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'doc') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'ppt') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pptx') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp3') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/mp3-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp4') {
					$gambar = '<img id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/mp4-icon.png" /></center>';
				} else {
					$gambar = '<img class="shadow" id="librayr" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '' . $row->gambar . '">';
				}


				if ($row->gambar == '') {
					$gambarDetail = '<img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pdf') {
					$gambarDetail = '<iframe src="' . base_url() . '' . $row->gambar . '" width="120" height="140"></iframe>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'doc') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'docx') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'ppt') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pptx') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp3') {
					$gambarDetail = ' <audio style="width:150px;" controls>
					<source src="' . base_url() . '' . $row->gambar . '" type="audio/ogg">
					<source src="' . base_url() . '' . $row->gambar . '" type="audio/mpeg">';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp4') {
					$gambarDetail = ' <video width="150" controls>
					<source src="' . base_url() . '' . $row->gambar . '" type="video/mp4">
					<source src="' . base_url() . '' . $row->gambar . '" type="video/ogg">
					</video>';
				} else {
					$gambarDetail = '<div id="librayr">
					<a href="#">
					<div class="konten2">
					' . $gambar . '
					</a>
					<div class="middle2">
					<a class="fancybox " href="' . base_url() . '' . $row->gambar . '" data-fancybox-group="gallery" title="' . $row->judul_gambar . '"><div class="lingkaran2"><i class="fa fa-search-plus field-icon2" aria-hidden="true"></i></div></a>
					</div>
					</div></div>';
				}


				$output .= '
				<div class="" style="margin-top: 15px;">
				<div class="konten-media ">
				<div id="librayr">
				<div class="konten">
				<a href="#">
				<label class="container2"><input type="checkbox" class="insert_check" name="images-check">
				' . $gambar . '
				<span class="checkmark2"></span></label></a>
				<div class="middle">
				<a href="#" class="popups" id="mpopupLink' . $no . '" data-id=' . "'" . $no . "'" . '><div class="lingkaran"><i class="fa fa-search-plus field-icon2" aria-hidden="true"></i></div></a>
				</div>

				
				<div id="mpopupBox' . $no . '" class="mpopup">
				<div class="modal-content2">
				<div class="modal-header2">
				<h4><i class="fa fa-question-circle field-icon2" aria-hidden="true"></i> Detail Informasi</h4>
				</div>
				<div class="modal-body2">
				<div class="row">
				<center><div class="col-md-3" style="margin-top:10px; margin-left:-60px; margin-right:40px;">' . $gambarDetail . '</div></center>
				<div class="col-md-9" style="margin-top:10px;">
				<table id="customers" style="margin-bottom:30px;">
				<tr> 
				<th width="180px;">Judul </th><td>&nbsp;' . $row->judul_gambar . '</td>
				</tr>
				<tr> 
				<th>Path</th><td><div class="input-group"><span tooltip="Copy Link" style="padding:9px;" class="input-group-addon" onclick="myFunction(' . $no . ')"><a href ="#"><i class="fa fa-clone" aria-hidden="true"></i></a></span><input style="width:235px; margin-top:0px;" type="text" class="form-control" id="myInput' . $no . '" name="hasil_link" value="' . base_url() . $row->gambar . '"></div></td>
				</tr>

				<tr> 
				<th>Dimensi / Ukuran / Tipe</th><td><span class="badge bg-blue">' . $ukuranDimension . '</span> / 
				<span class="badge bg-blue">' . $ukuranFileRes . '</span> / <span class="badge bg-blue">' . $row->ekstensi . '</span>  </td>
				</tr>

				<tr> 
				<th>Di Upload Oleh </th><td>&nbsp;' . $row->created_by . '</td>
				</tr>

				<tr> 
				<th>Tanggal Upload </th><td>&nbsp;' . date('d-m-Y', strtotime($row->created_date)) . '</td>
				</tr>

				</table>
				</div>
				</div>
				</div>
				</div>

				</div>
				</div>
				</div></div></div>';
			}
		} else {
			$output .= '<center><img style="border-color:white; margin-top:50px; width:230px; height:230px;" src="' . base_url() . '/assets/tambahan/gambar/no-result.png" /></center>';
		}
		$output .= '</table>';
		echo $output;
	}



	function LoadSingleMediaManager()
	{
		$output = '';
		$query = '';
		$tipe = '';
		$no = 1;
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->M_galeri_manager->LoadMediaManager($query);
		if ($data->num_rows() > 0) {
			foreach ($data->result() as $row) {

				$ukuranFile = $row->gambar;
				$ukuranFileRes = $this->fsize($ukuranFile);
				if (getimagesize($row->gambar) != '') {
					list($width, $height) = getimagesize($row->gambar);
					$ukuranDimension = $width . ' x ' . $height . ' px';
				} else {
					$ukuranDimension = "-";
				}

				$no++;

				if ($row->gambar == '') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pdf') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pdf-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'docx') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'doc') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'ppt') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pptx') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp3') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/mp3-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp4') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/mp4-icon.png" /></center>';
				} else {
					$gambar = '<img title="' . $row->ekstensi . '" id="librayr2" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '' . $row->gambar . '">';
				}


				if ($row->gambar == '') {
					$gambarDetail = '<img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pdf') {
					$gambarDetail = '<iframe src="' . base_url() . '' . $row->gambar . '" width="120" height="140"></iframe>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'doc') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'docx') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'ppt') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pptx') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp3') {
					$gambarDetail = ' <audio style="width:150px;" controls>
					<source src="' . base_url() . '' . $row->gambar . '" type="audio/ogg">
					<source src="' . base_url() . '' . $row->gambar . '" type="audio/mpeg">';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp4') {
					$gambarDetail = ' <video width="150" controls>
					<source src="' . base_url() . '' . $row->gambar . '" type="video/mp4">
					<source src="' . base_url() . '' . $row->gambar . '" type="video/ogg">
					</video>';
				} else {
					$gambarDetail = '<div id="librayr2">
					<a href="#">
					<div class="konten2">
					' . $gambar . '
					</a>
					<div class="middle2">
					<a class="fancybox " href="' . base_url() . '' . $row->gambar . '" data-fancybox-group="gallery" title="' . $row->judul_gambar . '"><div class="lingkaran2"><i class="fa fa-search-plus field-icon2" aria-hidden="true"></i></div></a>
					</div>
					</div></div>';
				}

				$output .= '
				<div class="" style="margin-top: 15px;">
				<div class="konten-media ">
				<div id="librayr2">
				<div class="konten">
				<a href="#">
				<label class="container2"><input type="checkbox" class="insert_check2" name="images-check">
				' . $gambar . '
				<span class="checkmark2"></span></label></a>
				<div class="middle">
				<a href="#" class="popups2" id="mpopupLink' . $no . '" data-id=' . "'" . $no . "'" . '><div class="lingkaran"><i class="fa fa-search-plus field-icon2" aria-hidden="true"></i></div></a>
				</div>

				<div id="popBox2' . $no . '" class="mpopup">
				<div class="modal-content2">
				<div class="modal-header2">

				<h4><i class="fa fa-question-circle field-icon2" aria-hidden="true"></i> Detail Informasi</h4>
				</div>
				<div class="modal-body2">
				<div class="row">
				<center><div class="col-md-3" style="margin-top:10px; margin-left:-60px; margin-right:40px;">' . $gambarDetail . '</div></center>
				<div class="col-md-9" style="margin-top:10px;">

				<table id="customers" style="margin-bottom:30px;">
				<tr> 
				<th width="180px;">Judul </th><td>&nbsp;' . $row->judul_gambar . '</td>
				</tr>
				<tr> 
				<th>Path</th><td><div class="input-group"><span tooltip="Copy Link" style="padding:9px;" class="input-group-addon" onclick="myFunction2(' . $no . ')"><a href ="#"><i class="fa fa-clone" aria-hidden="true"></i></a></span><input style="width:235px; margin-top:0px;" type="text" class="form-control" id="myInput2' . $no . '" name="hasil_link" value="' . base_url() . $row->gambar . '"></div></td>
				</tr>

				<tr> 
				<th>Dimensi / Ukuran / Tipe</th><td><span class="badge bg-blue">' . $ukuranDimension . '</span> / 
				<span class="badge bg-blue">' . $ukuranFileRes . '</span> / <span class="badge bg-blue">' . $row->ekstensi . '</span>  </td>
				</tr>

				<tr> 
				<th>Di Upload Oleh </th><td>&nbsp;' . $row->created_by . '</td>
				</tr>

				<tr> 
				<th>Tanggal Upload </th><td>&nbsp;' . date('d-m-Y', strtotime($row->created_date)) . '</td>
				</tr>

				</table>
				</div>
				</div>
				</div>
				</div>

				</div>
				</div>
				</div></div></div>';
			}
		} else {
			$output .= '<center><img style="border-color:white; margin-top:50px; width:230px; height:230px;" src="' . base_url() . '/assets/tambahan/gambar/no-result.png" /></center>';
		}
		$output .= '</table>';
		echo $output;
	}



	function LoadSingleMediaManager2()
	{
		$output = '';
		$query = '';
		$tipe = '';
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->M_galeri_manager->LoadMediaManager2($query);
		if ($data->num_rows() > 0) {
			foreach ($data->result() as $row) {

				$ukuranFile = $row->gambar;
				$ukuranFileRes = $this->fsize($ukuranFile);
				if (getimagesize($row->gambar) != '') {
					list($width, $height) = getimagesize($row->gambar);
					$ukuranDimension = $width . ' x ' . $height . ' px';
				} else {
					$ukuranDimension = "-";
				}

				$no++;

				if ($row->gambar == '') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pdf') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pdf-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'docx') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'doc') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'ppt') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pptx') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp3') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/mp3-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp4') {
					$gambar = '<img id="librayr2" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/mp4-icon.png" /></center>';
				} else {
					$gambar = '<img title="' . $row->ekstensi . '" id="librayr2" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '' . $row->gambar . '">';
				}

				if ($row->gambar == '') {
					$gambarDetail = '<img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pdf') {
					$gambarDetail = '<iframe src="' . base_url() . '' . $row->gambar . '" width="120" height="140"></iframe>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'doc') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'docx') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'ppt') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pptx') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp3') {
					$gambarDetail = ' <audio style="width:150px;" controls>
					<source src="' . base_url() . '' . $row->gambar . '" type="audio/ogg">
					<source src="' . base_url() . '' . $row->gambar . '" type="audio/mpeg">';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp4') {
					$gambarDetail = ' <video width="150" controls>
					<source src="' . base_url() . '' . $row->gambar . '" type="video/mp4">
					<source src="' . base_url() . '' . $row->gambar . '" type="video/ogg">
					</video>';
				} else {
					$gambarDetail = '<div id="librayr2">
					<a href="#">
					<div class="konten2">
					' . $gambar . '
					</a>
					<div class="middle2">
					<a class="fancybox " href="' . base_url() . '' . $row->gambar . '" data-fancybox-group="gallery" title="' . $row->judul_gambar . '"><div class="lingkaran2"><i class="fa fa-search-plus field-icon2" aria-hidden="true"></i></div></a>
					</div>
					</div></div>';
				}

				$output .= '
				<div class="" style="margin-top: 15px;">
				<div class="konten-media ">
				<div id="librayr2">
				<div class="konten">
				<a href="#">
				<label class="container2"><input type="checkbox" class="insert_check2" name="images-check">
				' . $gambar . '
				<span class="checkmark2"></span></label></a>
				<div class="middle">
				<a href="#" class="popups2" id="mpopupLink' . $no . '" data-id=' . "'" . $no . "'" . '><div class="lingkaran"><i class="fa fa-search-plus field-icon2" aria-hidden="true"></i></div></a>
				</div>

				<div id="popBox2' . $no . '" class="mpopup">
				<div class="modal-content2">
				<div class="modal-header2">

				<h4><i class="fa fa-question-circle field-icon2" aria-hidden="true"></i> Detail Informasi</h4>
				</div>
				<div class="modal-body2">
				<div class="row">
				<center><div class="col-md-3" style="margin-top:10px; margin-left:-60px; margin-right:40px;">' . $gambarDetail . '</div></center>
				<div class="col-md-9" style="margin-top:10px;">

				<table id="customers" style="margin-bottom:30px;">
				<tr> 
				<th width="180px;">Judul </th><td>&nbsp;' . $row->judul_gambar . '</td>
				</tr>
				<tr> 
				<th>Path</th><td><div class="input-group"><span tooltip="Copy Link" style="padding:9px;" class="input-group-addon" onclick="myFunction2(' . $no . ')"><a href ="#"><i class="fa fa-clone" aria-hidden="true"></i></a></span><input style="width:235px; margin-top:0px;" type="text" class="form-control" id="myInput2' . $no . '" name="hasil_link" value="' . base_url() . $row->gambar . '"></div></td>
				</tr>

				<tr> 
				<th>Dimensi / Ukuran / Tipe</th><td><span class="badge bg-blue">' . $ukuranDimension . '</span> / 
				<span class="badge bg-blue">' . $ukuranFileRes . '</span> / <span class="badge bg-blue">' . $row->ekstensi . '</span>  </td>
				</tr>

				<tr> 
				<th>Di Upload Oleh </th><td>&nbsp;' . $row->created_by . '</td>
				</tr>

				<tr> 
				<th>Tanggal Upload </th><td>&nbsp;' . date('d-m-Y', strtotime($row->created_date)) . '</td>
				</tr>

				</table>
				</div>
				</div>
				</div>

				</div>
				</div>
				</div>
				</div></div></div>';
			}
		} else {
			$output .= '<center><img style="border-color:white; margin-top:50px; width:230px; height:230px;" src="' . base_url() . '/assets/tambahan/gambar/no-result.png" /></center>';
		}
		$output .= '</table>';
		echo $output;
	}




	function LoadSingleMediaManager3()
	{
		$output = '';
		$query = '';
		$tipe = '';
		$no = 1;
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->M_galeri_manager->LoadMediaManager($query);
		if ($data->num_rows() > 0) {
			foreach ($data->result() as $row) {

				$ukuranFile = $row->gambar;
				$ukuranFileRes = $this->fsize($ukuranFile);
				if (getimagesize($row->gambar) != '') {
					list($width, $height) = getimagesize($row->gambar);
					$ukuranDimension = $width . ' x ' . $height . ' px';
				} else {
					$ukuranDimension = "-";
				}

				$no++;

				if ($row->gambar == '') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pdf') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pdf-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'docx') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'doc') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'ppt') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pptx') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp3') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/mp3-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp4') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/mp4-icon.png" /></center>';
				} else {
					$gambar = '<img class="shadow" title="' . $row->ekstensi . '" id="librayr3" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '' . $row->gambar . '">';
				}


				if ($row->gambar == '') {
					$gambarDetail = '<img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pdf') {
					$gambarDetail = '<iframe src="' . base_url() . '' . $row->gambar . '" width="120" height="140"></iframe>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'doc') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'docx') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'ppt') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pptx') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp3') {
					$gambarDetail = ' <audio style="width:150px;" controls>
					<source src="' . base_url() . '' . $row->gambar . '" type="audio/ogg">
					<source src="' . base_url() . '' . $row->gambar . '" type="audio/mpeg">';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp4') {
					$gambarDetail = ' <video width="150" controls>
					<source src="' . base_url() . '' . $row->gambar . '" type="video/mp4">
					<source src="' . base_url() . '' . $row->gambar . '" type="video/ogg">
					</video>';
				} else {
					$gambarDetail = '<div id="librayr3">
					<a href="#">
					<div class="konten2">
					' . $gambar . '
					</a>
					<div class="middle2">
					<a class="fancybox " href="' . base_url() . '' . $row->gambar . '" data-fancybox-group="gallery" title="' . $row->judul_gambar . '"><div class="lingkaran2"><i class="fa fa-search-plus field-icon2" aria-hidden="true"></i></div></a>
					</div>
					</div></div>';
				}

				$output .= '
				<div class="" style="margin-top: 15px;">
				<div class="konten-media ">
				<div id="librayr2">
				<div class="konten">
				<a href="#">
				<label class="container2"><input type="checkbox" class="insert_check3" name="images-check">
				' . $gambar . '
				<span class="checkmark2"></span></label></a>
				<div class="middle">
				<a href="#" class="popups3" id="mpopupLink' . $no . '" data-id=' . "'" . $no . "'" . '><div class="lingkaran"><i class="fa fa-search-plus field-icon2" aria-hidden="true"></i></div></a>
				</div>

				<div id="popBox3' . $no . '" class="mpopup">
				<div class="modal-content2">
				<div class="modal-header2">
				
				<h4><i class="fa fa-question-circle field-icon2" aria-hidden="true"></i> Detail Informasi</h4>
				</div>
				<div class="modal-body2">
				<div class="row">
				<center><div class="col-md-3" style="margin-top:10px; margin-left:-60px; margin-right:40px;">' . $gambarDetail . '</div></center>
				<div class="col-md-9" style="margin-top:10px;">
				<table id="customers" style="margin-bottom:30px;">
				<tr> 
				<th width="180px;">Judul </th><td>&nbsp;' . $row->judul_gambar . '</td>
				</tr>
				<tr> 
				<th>Path</th><td><div class="input-group"><span tooltip="Copy Link" style="padding:9px;" class="input-group-addon" onclick="myFunction2(' . $no . ')"><a href ="#"><i class="fa fa-clone" aria-hidden="true"></i></a></span><input style="width:235px; margin-top:0px;" type="text" class="form-control" id="myInput2' . $no . '" name="hasil_link" value="' . base_url() . $row->gambar . '"></div></td>
				</tr>

				<tr> 
				<th>Dimensi / Ukuran / Tipe</th><td><span class="badge bg-blue">' . $ukuranDimension . '</span> / 
				<span class="badge bg-blue">' . $ukuranFileRes . '</span> / <span class="badge bg-blue">' . $row->ekstensi . '</span>  </td>
				</tr>

				<tr> 
				<th>Di Upload Oleh </th><td>&nbsp;' . $row->created_by . '</td>
				</tr>

				<tr> 
				<th>Tanggal Upload </th><td>&nbsp;' . date('d-m-Y', strtotime($row->created_date)) . '</td>
				</tr>

				</table>
				</div>
				</div>
				</div>
				</div>

				</div>
				</div>
				</div></div></div>';
			}
		} else {
			$output .= '<center><img style="border-color:white; margin-top:50px; width:230px; height:230px;" src="' . base_url() . '/assets/tambahan/gambar/no-result.png" /></center>';
		}
		$output .= '</table>';
		echo $output;
	}



	function LoadSingleMediaManager4()
	{
		$output = '';
		$query = '';
		$tipe = '';
		if ($this->input->post('query')) {
			$query = $this->input->post('query');
		}
		$data = $this->M_galeri_manager->LoadMediaManager2($query);
		if ($data->num_rows() > 0) {
			foreach ($data->result() as $row) {

				$ukuranFile = $row->gambar;
				$ukuranFileRes = $this->fsize($ukuranFile);
				if (getimagesize($row->gambar) != '') {
					list($width, $height) = getimagesize($row->gambar);
					$ukuranDimension = $width . ' x ' . $height . ' px';
				} else {
					$ukuranDimension = "-";
				}

				$no++;


				if ($row->gambar == '') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pdf') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pdf-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'docx') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'doc') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'ppt') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pptx') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp3') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/mp3-icon.png" /></center>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp4') {
					$gambar = '<img id="librayr3" title="' . $row->ekstensi . '" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '/assets/tambahan/gambar/mp4-icon.png" /></center>';
				} else {
					$gambar = '<img class="shadow" title="' . $row->ekstensi . '" id="librayr3" alt="' . base_url() . '' . $row->gambar . '" src="' . base_url() . '' . $row->gambar . '">';
				}


				if ($row->gambar == '') {
					$gambarDetail = '<img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pdf') {
					$gambarDetail = '<iframe src="' . base_url() . '' . $row->gambar . '" width="120" height="140"></iframe>';
				} elseif ($row->gambar != '' and $row->ekstensi == 'doc') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'docx') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'ppt') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'pptx') {
					$gambarDetail = ' <img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" />';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp3') {
					$gambarDetail = ' <audio style="width:150px;" controls>
					<source src="' . base_url() . '' . $row->gambar . '" type="audio/ogg">
					<source src="' . base_url() . '' . $row->gambar . '" type="audio/mpeg">';
				} elseif ($row->gambar != '' and $row->ekstensi == 'mp4') {
					$gambarDetail = ' <video width="150" controls>
					<source src="' . base_url() . '' . $row->gambar . '" type="video/mp4">
					<source src="' . base_url() . '' . $row->gambar . '" type="video/ogg">
					</video>';
				} else {
					$gambarDetail = '<div id="librayr3">
					<a href="#">
					<div class="konten2">
					' . $gambar . '
					</a>
					<div class="middle2">
					<a class="fancybox " href="' . base_url() . '' . $row->gambar . '" data-fancybox-group="gallery" title="' . $row->judul_gambar . '"><div class="lingkaran2"><i class="fa fa-search-plus field-icon2" aria-hidden="true"></i></div></a>
					</div>
					</div></div>';
				}

				$output .= '
				<div class="" style="margin-top: 15px;">
				<div class="konten-media ">
				<div id="librayr2">
				<div class="konten">
				<a href="#">
				<label class="container2"><input type="checkbox" class="insert_check3" name="images-check">
				' . $gambar . '
				<span class="checkmark2"></span></label></a>
				<div class="middle">
				<a href="#" class="popups3" id="mpopupLink' . $no . '" data-id=' . "'" . $no . "'" . '><div class="lingkaran"><i class="fa fa-search-plus field-icon2" aria-hidden="true"></i></div></a>
				</div>

				<div id="popBox3' . $no . '" class="mpopup">
				<div class="modal-content2">
				<div class="modal-header2">
				
				<h4><i class="fa fa-question-circle field-icon2" aria-hidden="true"></i> Detail Informasi</h4>
				</div>
				<div class="modal-body2">
				<div class="row">
				<center><div class="col-md-3" style="margin-top:10px; margin-left:-60px; margin-right:40px;">' . $gambarDetail . '</div></center>
				<div class="col-md-9" style="margin-top:10px;">
				<table id="customers" style="margin-bottom:30px;">
				<tr> 
				<th width="180px;">Judul </th><td>&nbsp;' . $row->judul_gambar . '</td>
				</tr>
				<tr> 
				<th>Path</th><td><div class="input-group"><span tooltip="Copy Link" style="padding:9px;" class="input-group-addon" onclick="myFunction2(' . $no . ')"><a href ="#"><i class="fa fa-clone" aria-hidden="true"></i></a></span><input style="width:235px; margin-top:0px;" type="text" class="form-control" id="myInput2' . $no . '" name="hasil_link" value="' . base_url() . $row->gambar . '"></div></td>
				</tr>

				<tr> 
				<th>Dimensi / Ukuran / Tipe</th><td><span class="badge bg-blue">' . $ukuranDimension . '</span> / 
				<span class="badge bg-blue">' . $ukuranFileRes . '</span> / <span class="badge bg-blue">' . $row->ekstensi . '</span>  </td>
				</tr>

				<tr> 
				<th>Di Upload Oleh </th><td>&nbsp;' . $row->created_by . '</td>
				</tr>

				<tr> 
				<th>Tanggal Upload </th><td>&nbsp;' . date('d-m-Y', strtotime($row->created_date)) . '</td>
				</tr>

				</table>
				</div>
				</div>
				</div>
				</div>

				</div>
				</div>
				</div></div></div>';
			}
		} else {
			$output .= '<center><img style="border-color:white; margin-top:50px; width:230px; height:230px;" src="' . base_url() . '/assets/tambahan/gambar/no-result.png" /></center>';
		}
		$output .= '</table>';
		echo $output;
	}


	public function ajaxDataManager()
	{

		$list = $this->M_galeri_manager->get_data();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $brand) {

			if ($brand->gambar == '') {
				$gambar = '<img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" width="90"/></center>';
			} else {
				$gambar = '<a class="fancybox " href="' . base_url() . '' . $brand->gambar . '" data-fancybox-group="gallery" title="' . $brand->judul_gambar . '"><img class="img-thumbnail" src="' . base_url() . '' . $brand->gambar . '"   width="90" /></a>';
			}

			$ukuranFile = $brand->gambar;
			$ukuranFileRes = $this->fsize($ukuranFile);
			list($width, $height) = getimagesize($brand->gambar);
			$ukuranDimension = $width . ' x ' . $height . ' px';


			$no++;
			$row = array();
			$row[] = "<label class='container2'><input type='checkbox' class='delete_check' id='delcheck_" . $brand->id_opd . "' onclick='checkcheckbox();' value='" . $brand->id_gambar . "'><span class='checkmark'></span></label>";
			$row[] = $gambar;
			$row[] = '<li>' . $brand->judul_gambar . '</li><br><li><span class="badge bg-blue">' . $ukuranDimension . '</span></li>';
			$row[] = $ukuranFileRes;
			$row[] = $brand->ekstensi;
			$data[] = $row;
		}


		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}


	public function ajaxDataManager2()
	{

		$list = $this->M_galeri_manager->get_data2();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $rows) {

			if ($rows->gambar == '') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" width="90"/></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'pdf') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/pdf-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'docx') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'doc') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'ppt') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'pptx') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'mp3') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/mp3-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'mp4') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/mp4-icon.png" /></center>';
			}

			$ukuranFile = $rows->gambar;
			$ukuranFileRes = $this->fsize($ukuranFile);

			$no++;
			$row = array();
			$row[] = "<label class='container2'><input type='checkbox' class='delete_check' id='delcheck_" . $rows->id_gambar . "' onclick='checkcheckbox();' value='" . $rows->id_gambar . "'><span class='checkmark'></span></label>";
			$row[] = $gambar;
			$row[] = $rows->judul_gambar;
			$row[] = $ukuranFileRes;
			$row[] = $rows->ekstensi;
			$data[] = $row;
		}


		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}


	public function ajaxSingleDataManager()
	{

		$list = $this->M_galeri_manager->get_data();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $brand) {

			if ($brand->gambar == '') {
				$gambar = '<img id="librayr" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" width="90"/></center>';
			} else {
				$gambar = '<a class="fancybox " href="' . base_url() . '' . $brand->gambar . '" data-fancybox-group="gallery" title="' . $brand->judul_gambar . '"><img class="img-thumbnail" src="' . base_url() . '' . $brand->gambar . '"   width="90" /></a>';
			}

			$ukuranFile = $brand->gambar;
			$ukuranFileRes = $this->fsize($ukuranFile);
			list($width, $height) = getimagesize($brand->gambar);
			$ukuranDimension = $width . ' x ' . $height . ' px';


			$no++;
			$row = array();
			$row[] = "<label class='container2'><input type='checkbox' class='delete_check2' id='delcheck_" . $brand->id_gambar . "' onclick='checkcheckbox2();' value='" . $brand->id_gambar . "'><span class='checkmark'></span></label>";
			$row[] = $gambar;
			$row[] = '<li>' . $brand->judul_gambar . '</li><br><li><span class="badge bg-blue">' . $ukuranDimension . '</span></li>';
			$row[] = $ukuranFileRes;
			$row[] = $brand->ekstensi;
			$data[] = $row;
		}


		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}


	public function ajaxSingleDataManager2()
	{

		$list = $this->M_galeri_manager->get_data2();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $rows) {

			if ($rows->gambar == '') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" width="90"/></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'pdf') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/pdf-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'docx') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'doc') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'ppt') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'pptx') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'mp3') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/mp3-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'mp4') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/mp4-icon.png" /></center>';
			}

			$ukuranFile = $rows->gambar;
			$ukuranFileRes = $this->fsize($ukuranFile);

			$no++;
			$row = array();
			$row[] = "<label class='container2'><input type='checkbox' class='delete_check2' id='delcheck_" . $rows->id_gambar . "' onclick='checkcheckbox2();' value='" . $rows->id_gambar . "'><span class='checkmark'></span></label>";
			$row[] = $gambar;
			$row[] = $rows->judul_gambar;
			$row[] = $ukuranFileRes;
			$row[] = $rows->ekstensi;
			$data[] = $row;
		}


		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}


	public function ajaxSingleDataManager3()
	{

		$list = $this->M_galeri_manager->get_data();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $brand) {

			if ($brand->gambar == '') {
				$gambar = '<img id="librayr3" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" width="90"/></center>';
			} else {
				$gambar = '<a class="fancybox " href="' . base_url() . '' . $brand->gambar . '" data-fancybox-group="gallery" title="' . $brand->judul_gambar . '"><img class="img-thumbnail" src="' . base_url() . '' . $brand->gambar . '"   width="90" /></a>';
			}

			$ukuranFile = $brand->gambar;
			$ukuranFileRes = $this->fsize($ukuranFile);
			list($width, $height) = getimagesize($brand->gambar);
			$ukuranDimension = $width . ' x ' . $height . ' px';


			$no++;
			$row = array();
			$row[] = "<label class='container2'><input type='checkbox' class='delete_check3' id='delcheck_" . $brand->id_gambar . "' onclick='checkcheckbox3();' value='" . $brand->id_gambar . "'><span class='checkmark'></span></label>";
			$row[] = $gambar;
			$row[] = '<li>' . $brand->judul_gambar . '</li><br><li><span class="badge bg-blue">' . $ukuranDimension . '</span></li>';
			$row[] = $ukuranFileRes;
			$row[] = $brand->ekstensi;
			$data[] = $row;
		}


		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}



	public function ajaxSingleDataManager4()
	{

		$list = $this->M_galeri_manager->get_data2();
		$data = array();
		$no = $_POST['start'];

		foreach ($list as $rows) {

			if ($rows->gambar == '') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/tidak-ada.png" width="90"/></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'pdf') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/pdf-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'docx') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'doc') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/docx-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'ppt') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'pptx') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/pptx-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'mp3') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/mp3-icon.png" /></center>';
			} elseif ($rows->gambar != '' and $rows->ekstensi == 'mp4') {
				$gambar = '<img width="90" src="' . base_url() . '/assets/tambahan/gambar/mp4-icon.png" /></center>';
			}

			$ukuranFile = $rows->gambar;
			$ukuranFileRes = $this->fsize($ukuranFile);

			$no++;
			$row = array();
			$row[] = "<label class='container2'><input type='checkbox' class='delete_check3' id='delcheck_" . $rows->id_gambar . "' onclick='checkcheckbox3();' value='" . $rows->id_gambar . "'><span class='checkmark'></span></label>";
			$row[] = $gambar;
			$row[] = $rows->judul_gambar;
			$row[] = $ukuranFileRes;
			$row[] = $rows->ekstensi;
			$data[] = $row;
		}


		$output = array(
			"draw" => $_POST['draw'],
			"data" => $data,
		);
		//output to json format
		echo json_encode($output);
	}



	//Untuk proses upload foto
	function UploadMediaManager()
	{

		$username =  $this->session->userdata('nama');
		$date = date('Y-m-d');
		$idToko =  $this->session->userdata('id_toko');

		$config['upload_path'] = "./upload/media-upload/";
		$config['allowed_types'] = 'gif|jpg|png|jpeg|JPEG|PNG|JPG|GIF|pdf|PDF|doc|docx|xls|xlsx|ppt|pptx|mp3|mp4';
		$config['max_size'] = '30048'; //maksimum besar file 2M
		$config['overwrite'] = TRUE;
		// $config['encrypt'] = TRUE;

		$this->load->library('upload', $config);

		if ($this->upload->do_upload('userfile')) {

			$image_data = $this->upload->data();
			$path['link'] = "upload/media-upload/";
			$fileExt = pathinfo($this->upload->data('file_name'), PATHINFO_EXTENSION);
			$nama = $this->upload->data('file_name');

			$data = array(
				'judul_gambar' 		   => $nama,
				'id_toko'  		       => $idToko,
				'ekstensi'             => $fileExt,
				'nama_gambar'          => $nama,
				'gambar'               => $path['link'] . '' . $image_data['file_name'],
				'created_date'         => $date,
				'created_by'           => $username,
			);
			$result = $this->db->insert('tbl_gambar', $data);
		}
	}


	public function HapusMedia()
	{
		$this->load->helper("file");
		$id = $_POST['deleteids_arr'];
		foreach ($id as $deleteid) {
			$gambar = $this->db->get_where('tbl_gambar', array('id_gambar' => $deleteid));
			foreach ($gambar as $hasil) {
				$hasil = $gambar->row();
				$judul = $hasil->gambar;
				//hapus unlink foto
				if (file_exists($file = $judul)) {
					unlink($file);
				}
				$this->db->delete('tbl_gambar', array('id_gambar' => $token));
			}
			$result = $this->db->delete('tbl_gambar', array('id_gambar' => $deleteid));
		}

		if ($result) {
			$out = array('status' => true, 'pesan' => 'Data has been deleted');
		} else {
			$out = array('status' => false, 'pesan' => 'Data has been failed deleted!');
		}
		echo json_encode($out);
	}
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gambar extends AUTH_Controller {

	const __tableName = 'tbl_gambar';
	const __tableId   = 'id_gambar';
	const __folder    = 'v_gambar/';
	const __kode_menu = 'kode-gambar';
	const __title     = 'Upload Image';
	const __model     = 'M_gambar';

	public function __construct()
	{
		parent::__construct();
		$this->load->model(self::__model);
		$this->load->model('M_sidebar');
	}
	
	public function loadkonten($page, $data) {
		
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
		$accessAdd = $this->M_sidebar->access('add',self::__kode_menu);
		$access = $this->M_sidebar->access('add',self::__kode_menu);
		if ($access->menuview == 0){
			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$this->loadkonten('Dashboard/layouts/no_akses',$data);
		} else {
		$data['accessAdd']  = $accessAdd->menuview;
		$data['userdata'] 	= $this->session->userdata('nama'); 
		$data['page'] 		= self::__title;
		$data['judul'] 		= self::__title;
		$data['list']       = $this->M_gambar->get_data();
		
		$this->loadkonten(''.self::__folder.'home',$data);
	}
	}

	public function ajax_list()
	{
		$accessEdit = $this->M_sidebar->access('edit',self::__kode_menu);
		$accessDel = $this->M_sidebar->access('del',self::__kode_menu);
		$list = $this->M_gambar->get_data();
		$data = array();
		$no = $_POST['start'];
		
		foreach ($list as $brand) {

			$status = '<span class="badge bg-red">Hidden</span>';
			if ($brand->status == 'Publish') {
				$status = '<span class="badge bg-blue">Publish</span>';
			}

			$no++;
			$row = array();
			$row[] = $no;
			$row[] = '<a href="'.base_url().''.$brand->gambar.'" target="_blank"><img class="img-thumbnail" src="'.base_url().''.$brand->gambar.'"   width="90" /></a>';    
			$row[] = $brand->judul_gambar;
			$row[] = '<div class="input-group"><span tooltip="Copy Link" class="input-group-addon" onclick="myFunction('.$no.')"><a href ="#"><i class="fa fa-clone" aria-hidden="true"></i></a></span><input style="width:400px;" type="text" class="form-control" id="myInput'.$no.'" name="hasil_link" value="'.base_url().$brand->gambar.'"></div>';

			//add html for action
			$buttonEdit = '';
			if ($accessEdit->menuview > 0) {
				$buttonEdit = anchor('edit-gambar/'.$brand->id_gambar, ' <span tooltip="Edit Data"><span class="fa fa-edit"></span> ', ' class="btn btn-icon btn-primary klik ajaxify" ');
			}
			$buttonDel = '';
			if ($accessDel->menuview > 0) {
				$buttonDel = '<button class="btn btn-icon btn-danger hapus-gambar" data-id='."'".$brand->id_gambar."'".'><span tooltip="Delete Data"><i class="glyphicon glyphicon-trash"></i></button>';
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

	
	
	public function Add() {
		
		/*ini harus ada boss */
		$data['userdata'] = $this->userdata;
		$access = $this->M_sidebar->access('add',self::__kode_menu);
		if ($access->menuview == 0){
			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$this->loadkonten('Dashboard/layouts/no_akses',$data);
		}
		
		/*ini harus ada boss */
		else{
			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$data['Status']     = $this->M_gambar->selek_status();	

			$this->loadkonten(''.self::__folder.'tambah',$data);
		}
	}

	public function prosesTambah() {
		
		$config['upload_path']="./upload/media-upload/";
		$config['allowed_types']='gif|jpg|png|jpeg|JPEG';
		$config['max_size'] = '2048'; //maksimum besar file 2M
		$config['overwrite'] = TRUE;
		
		$this->load->library('upload',$config);
		
		if($this->upload->do_upload("gambar"))
		{
			$image_data = $this->upload->data();
			$path['link']= "upload/media-upload/";
			$fileExt = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
			$nama=$this->upload->data('file_name');

			$data = array(
				'judul_gambar' 		   => $this->input->post('judul_gambar'),
				'ekstensi'             => $fileExt,
				'nama_gambar'          => $nama,
				'gambar'               => $path['link'] . ''. $image_data['file_name'],
			);
			$result = $this->db->insert(self::__tableName, $data);
			
			if ($result > 0) {
				$out = array('status' => true, 'pesan' => ' Data has been saved');
			} else {
				$out = array('status' => false, 'pesan' => 'Data has been failed save!');
			}

		} 
		
		else {
			$data = array( 
				'judul_gambar' 		   => $this->input->post('judul_gambar'),						 
			);  
			$result = $this->db->insert(self::__tableName, $data);
			if ($result > 0) {
				$out = array('status' => true, 'pesan' => ' Data has been saved');
			} else {
				$out = array('status' => false, 'pesan' => 'Data has been failed save!');
			}
		}

		echo json_encode($out);
	}
	
	
	public function Edit($id) {
		
		/*ini harus ada boss */
		$data['userdata'] = $this->userdata;
		$access = $this->M_sidebar->access('edit',self::__kode_menu);
		if ($access->menuview == 0){
			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$this->loadkonten('Dashboard/layouts/no_akses',$data);
		}
		/*ini harus ada boss */
		else{

			$where=array(self::__tableId => $id);
			$data['dataGambar']       = $this->M_gambar->selectById($id);
			$data['Status']     = $this->M_gambar->selek_status();

			$data['page'] 		= self::__title;
			$data['judul'] 		= self::__title;
			$this->loadkonten(''.self::__folder.'update',$data);
		}
	}
	
	public function prosesUpdate() {

		$where = trim($this->input->post(self::__tableId));
		
		$config['upload_path']="./upload/media-upload/";
		$config['allowed_types']='gif|jpg|png|jpeg|JPEG';
		$config['max_size'] = '2048'; //maksimum besar file 2M
		$config['overwrite'] = TRUE;
		
		$this->load->library('upload',$config);
		
		if($this->upload->do_upload("gambar"))
		{

			$id_gambar = $this->input->post('id_gambar');
			$data_kode = array('id_gambar'=>$id_gambar);
			$gambar = $this->db->get_where('tbl_gambar',$data_kode);

			if($gambar->num_rows()>0){
				$pros=$gambar->row();
				$name=$pros->gambar;

				if(file_exists($lok=FCPATH.$name)){
					unlink($lok);
				}
			}	

			$image_data = $this->upload->data();
			$path['link']= "upload/media-upload/";
			$fileExt = pathinfo($_FILES["gambar"]["name"], PATHINFO_EXTENSION);
			$nama=$this->upload->data('file_name');

			$data = array(
				'judul_gambar' 		   => $this->input->post('judul_gambar'),
				'ekstensi'             => $fileExt,
				'nama_gambar'          => $nama,
				'gambar'               => $path['link'] . ''. $image_data['file_name'],
			);

			$result = $this->db->update(self::__tableName, $data, array(self::__tableId => $where));
			
			if ($result > 0) {
				$out = array('status' => true, 'pesan' => 'Data has been updated');
			} else {
				$out = array('status' => false, 'pesan' => 'Data has been failed save!');
			}
		} 
		
		else {	

			$data = array( 
				'judul_gambar' 		   => $this->input->post('judul_gambar'),					 
			);

			$result = $this->db->update(self::__tableName, $data, array(self::__tableId => $where));
			if ($result > 0) {
				$out = array('status' => true, 'pesan' => 'Data has been updated');
			} else {
				$out = array('status' => false, 'pesan' => 'Data has been failed save!');
			}
		}

		echo json_encode($out);
	}
	
	public function hapus() {
		
		$token = $this->input->post('id_gambar');
		$gambar=$this->db->get_where('tbl_gambar',array('id_gambar'=>$token));
		if($gambar->num_rows()>0){
			$hasil=$gambar->row();
			$judul=$hasil->gambar;
			//hapus unlink foto
			if(file_exists($file=$judul)){
				unlink($file);
			}
			$result = $this->db->delete('tbl_gambar',array('id_gambar'=>$token));
		}

		if ($result > 0) {
			$out = array('status' => true, 'pesan' => 'Data has been deleted');
		} else {
			$out = array('status' => false, 'pesan' => 'Data has been failed deleted!');
		}
		echo json_encode($out);
	}
	
	
}

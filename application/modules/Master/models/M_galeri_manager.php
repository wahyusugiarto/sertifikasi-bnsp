<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_galeri_manager extends CI_Model
{

	const __tableName = 'tbl_gambar';
	const __tableId = 'id_gambar';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->idToko = $this->session->userdata('id_toko');
	}

	public function get_data_tes()
	{
		$sql = " SELECT * FROM tbl_tes ORDER BY id DESC ";
		$data = $this->db->query($sql);
		return $data->result();
	}

	public function SelectTesId($id)
	{
		$sql = " SELECT * FROM tbl_tes WHERE id='$id'";
		$data = $this->db->query($sql);
		return $data->row();
	}

	public function SelectByMult($id)
	{
		$sql = " SELECT * FROM tbl_file_looping WHERE id_pengajuan='$id'";
		$data = $this->db->query($sql);
		return $data->result();
	}

	function LoadMediaManager($query)
	{
		$this->db->select("*");
		$this->db->from("tbl_gambar");
		if ($this->idToko > 0) {
			$this->db->where('id_toko', $this->idToko);
		}
		if ($query != '') {
			$this->db->like('judul_gambar', $query);
			$this->db->or_like('nama_gambar', $query);
			$this->db->or_like('ekstensi', $query);
		}
		$this->db->order_by('id_gambar', 'DESC');
		return $this->db->get();
	}

	function LoadMediaManager2($query)
	{
		$this->db->select("*");
		$this->db->from("tbl_gambar");
		if ($this->idToko > 0) {
			$this->db->where('id_toko', $this->idToko);
		}
		$this->db->order_by('id_gambar', $query);
		return $this->db->get();
	}

	public function selek_status()
	{

		$sql = " select * from status_grup WHERE nama in ('Hidden','Publish')";
		$data = $this->db->query($sql);
		return $data->result();
	}

	public function get_data()
	{
		$sql = " SELECT * FROM tbl_gambar WHERE ekstensi in ('gif','png','jpg','jpeg')  ";
		if ($this->idToko > 0) {
			$sql .= " AND id_toko = '{$this->idToko}'";
		}
		$sql .= "ORDER BY id_gambar DESC";
		$data = $this->db->query($sql);
		return $data->result();
	}

	public function get_data2()
	{
		$sql = " SELECT * FROM tbl_gambar WHERE ekstensi in ('pdf','doc','docx','xls','xlsx','ppt','pptx','mp3','mp4')";
		if ($this->idToko > 0) {
			$sql .= " AND id_toko = '{$this->idToko}'";
		}
		$sql .= "ORDER BY id_gambar DESC";
		$data = $this->db->query($sql);
		return $data->result();
	}

	public function selectById($id)
	{
		$sql = "SELECT * FROM " . self::__tableName . " WHERE " . self::__tableId . " = '{$id}'";
		$data = $this->db->query($sql);
		return $data->row();
	}


	public function hapus($id)
	{
		$sql = "DELETE FROM " . self::__tableName . " WHERE  " . self::__tableId . " = '{$id}'";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
}

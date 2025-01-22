<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_kategori extends CI_Model
{

	const __tableName = 'tbl_kategori';
	const __tableId = 'id_kategori';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}


	public function get_data()
	{
		$this->db->from(self::__tableName);
		$this->db->order_by('id_kategori', "DESC");
		$data = $this->db->get();
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

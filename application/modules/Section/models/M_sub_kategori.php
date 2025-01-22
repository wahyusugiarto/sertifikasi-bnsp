<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_sub_kategori extends CI_Model
{
	const __tableName = 'tbl_sub_kategori';
	const __tableId = 'id';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
	}

	public function selekKategori()
	{
		$sql = " SELECT * FROM tbl_kategori";
		$data = $this->db->query($sql);
		return $data->result();
	}

	public function get_data()
	{
		$sql  = "SELECT tbl_kategori.kategori as kategori ,tbl_sub_kategori.kategori as kat,tbl_sub_kategori.id as id, tbl_sub_kategori.sub_kategori as sub_kategori FROM " . self::__tableName . " ";
		$sql .= "LEFT JOIN tbl_kategori ON " . self::__tableName . ".`kategori` = tbl_kategori.`id_kategori`";
		$sql .= "ORDER BY id DESC";
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

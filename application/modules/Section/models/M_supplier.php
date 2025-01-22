<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_supplier extends CI_Model {

	const __tableName = 'tbl_supplier';
    const __tableId = 'id';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->idBengkel = $this->session->userdata('id_bengkel');
	}

 
	public function get_data() {
        $sql = "SELECT * FROM tbl_supplier ";
		if ($this->idBengkel > 0) {
            $sql .= " WHERE id_bengkel = '{$this->idBengkel}'";
        }
		$sql .= "ORDER BY id DESC";
		$data = $this->db->query($sql);
        return $data->result();
    }
	
	public function selectById($id) {
        $sql = "SELECT * FROM " . self::__tableName . " WHERE " . self::__tableId . " = '{$id}'";
        $data = $this->db->query($sql);
        return $data->row();
    }

	public function hapus($id) {
		$sql = "DELETE FROM " . self::__tableName . " WHERE  ". self::__tableId . " = '{$id}'";
		$this->db->query($sql);
		return $this->db->affected_rows();
	}
	
	
}

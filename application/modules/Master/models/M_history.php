<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_history extends CI_Model {

	const __tableName = 'tbl_log_transaksi';
    const __tableId = 'id';

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->idBengkel = $this->session->userdata('id_bengkel');
	}

	public function getData() {
        $sql = "SELECT * FROM tbl_log_transaksi ";
		if ($this->idBengkel > 0) {
            $sql .= " WHERE id_bengkel = '{$this->idBengkel}'";
        }
		$sql .= "ORDER BY id DESC";
		$data = $this->db->query($sql);
        return $data->result();
    }
	
	
	
}

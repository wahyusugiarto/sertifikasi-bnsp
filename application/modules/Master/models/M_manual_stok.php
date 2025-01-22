<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_manual_stok extends CI_Model
{

    const __tableName = 'tbl_manual_stok';
    const __tableId = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
    }

    public function selectProduk()
    {
        $sql = "SELECT * FROM tbl_product ORDER BY id DESC ";
        $data = $this->db->query($sql);
        return $data->result();
    }

    public function selectByIdProduk($id)
    {
        $sql = "SELECT * FROM tbl_product WHERE id = '$id' ";
        $data = $this->db->query($sql);
        return $data->row();
    }

    function updatestockAdd($stok, $id)
    {
        $this->db->set('stok', 'stok+' . $stok, FALSE);
        $this->db->where_in('id', $id);
        $this->db->update('tbl_product');
    }

    function updatestockDelete($stok, $id)
    {
        $this->db->set('stok', 'stok-' . $stok, FALSE);
        $this->db->where_in('id', $id);
        $this->db->update('tbl_product');
    }

    public function getData()
    {
        $sql = "SELECT * FROM tbl_manual_stok ";
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

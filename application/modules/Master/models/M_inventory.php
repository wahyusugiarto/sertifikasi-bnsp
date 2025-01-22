<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_inventory extends CI_Model
{

    const __tableName = 'tbl_product';
    const __tableId = 'id';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->idBengkel = $this->session->userdata('id_bengkel');
    }

    public function CreateCode()
    {
        $this->db->select('RIGHT(tbl_product.kode_barang,4) as kode_barang', FALSE);
        $this->db->order_by('kode_barang', 'DESC');
        $this->db->limit(1);
        $query = $this->db->get('tbl_product');
        if ($query->num_rows() <> 0) {
            $data = $query->row();
            $kode = intval($data->kode_barang) + 1;
        } else {
            $kode = 1;
        }
        $batas = str_pad($kode, 4, "0", STR_PAD_LEFT);
        $kodetampil = "BR" . $batas;
        return $kodetampil;
    }

    public function selectKat($kategori)
    {
        $this->db->order_by('id_kategori', 'ASC');
        $kab = $this->db->get_where('tbl_kategori', array('id_kategori' => $kategori));
        foreach ($kab->result_array() as $data) {
            $res .= "$data[kategori]";
        }
        return $res;
    }

    public function selectSubKat($kode)
    {
        $kategori = "";
        $this->db->order_by('id', 'ASC');
        $kab = $this->db->get_where('tbl_sub_kategori', array('kategori' => $kode));

        foreach ($kab->result_array() as $data) {
            $kategori .= "<option value='$data[sub_kategori]'>$data[sub_kategori]</option>";
        }
        return $kategori;
    }

    public function selekKategori()
    {
        $sql = " SELECT * FROM tbl_kategori";
        $data = $this->db->query($sql);
        return $data->result();
    }

    public function selekSubKategori()
    {
        $sql = " SELECT * FROM tbl_sub_kategori";
        $data = $this->db->query($sql);
        return $data->result();
    }

    public function get_data()
    {
        $sql = "SELECT * FROM tbl_product ";
        if ($this->idBengkel > 0) {
            $sql .= " WHERE id_bengkel = '{$this->idBengkel}'";
        }
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

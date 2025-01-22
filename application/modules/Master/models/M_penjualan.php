<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penjualan extends CI_Model
{

    const __tableName = 'tbl_penjualan';
    const __tableId   = 'no';
    const __tableId2   = 'kode_penjualan';

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->idToko = $this->session->userdata('id_toko');
    }

    public function getData($isAjaxList = 0, $filter = [])
    {
        $tanggalAwal = $filter['tanggal_awal'];
        $tanggalAkhir = $filter['tanggal_akhir'];
        $allDate = $filter['all_date'];

        $sql = " SELECT * FROM tbl_penjualan WHERE 1=1 ";
        if ($this->idToko > 0) {
            $sql .= " AND id_toko = '{$this->idToko}'";
        }
        if ($allDate == 0) {
            if (strlen($tanggalAwal) > 0 && strlen($tanggalAkhir) > 0) {
                $tanggalAwal = date('Y-m-d', strtotime($tanggalAwal));
                $tanggalAkhir = date('Y-m-d', strtotime($tanggalAkhir));
                $sql .= " AND tanggal >= '{$tanggalAwal}' AND tanggal <= '{$tanggalAkhir}'";
            }
        }

        if ($isAjaxList > 0) {
            $sql .= "ORDER BY no DESC";
        }
        $data = $this->db->query($sql);
        return $data->result();
    }


    public function getData2($isAjaxList = 0, $filter = [])
    {

        $sql = " SELECT * FROM tbl_penjualan WHERE 1=1 ";
        if ($this->idToko > 0) {
            $sql .= " AND id_toko = '{$this->idToko}'";
        }

        if ($isAjaxList > 0) {
            $sql .= "ORDER BY no DESC";
        }
        $data = $this->db->query($sql);
        return $data->result();
    }

    public function selectDetailCart($kode)
    {
        $sql = " SELECT * FROM tbl_detail_penjualan WHERE kode_penjualan = '$kode' ";
        $data = $this->db->query($sql);
        return $data->result();
    }

    public function selectById($id)
    {
        $sql = "SELECT * FROM " . self::__tableName . " WHERE " . self::__tableId . " = '{$id}'";
        $data = $this->db->query($sql);
        return $data->row();
    }

    public function selectByKode($id)
    {
        $sql = "SELECT * FROM " . self::__tableName . " WHERE " . self::__tableId2 . " = '{$id}'";
        $data = $this->db->query($sql);
        return $data->row();
    }

    public function selectCustomer()
    {
        $sql = " SELECT * FROM tbl_pelanggan ";
        $data = $this->db->query($sql);
        return $data->result();
    }

    public function selectNama($idUser)
    {
        $this->db->order_by('id_pelanggan', 'ASC');
        $has = $this->db->get_where('tbl_pelanggan', array('id_pelanggan' => $idUser));
        foreach ($has->result_array() as $data) {
            $res .= "$data[nama]";
        }
        return $res;
    }

    public function selectTelp($idUser)
    {
        $this->db->order_by('id_pelanggan', 'ASC');
        $has = $this->db->get_where('tbl_pelanggan', array('id_pelanggan' => $idUser));
        foreach ($has->result_array() as $data) {
            $res .= "$data[telp]";
        }
        return $res;
    }

    function SearchProduct()
    {
        $this->db->select('*');
        $this->db->from('tbl_product');
        if ($this->idToko > 0) {
            $this->db->where('id_toko', $this->idToko);
        }
        $this->db->order_by('id_toko', 'DESC');
        return $this->db->get();
    }

    function ViewCart($where)
    {
        return $this->db->get_where('tbl_temp_penjualan', $where);
    }

    function CheckSell($where)
    {
        return $this->db->get_where('tbl_temp_penjualan', $where);
    }

    function delcart($where)
    {
        $this->db->delete('tbl_temp_penjualan', $where);
    }

    function updatestock($stok, $id)
    {
        $this->db->set('stok', 'stok-' . $stok, FALSE);
        $this->db->where_in('id', $id);
        $this->db->update('tbl_product');
    }

    function cek_jual($where)
    {
        return $this->db->get_where('tbl_temp_penjualan', $where);
    }
}

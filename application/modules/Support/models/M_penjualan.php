<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_penjualan extends CI_Model
{

    const __tableName = 'tbl_penjualan';
    const __tableId = 'id_penjualan';

    public function __construct()
    {
        parent::__construct();
        $this->idToko = $this->session->userdata('id_toko');
    }

    public function exportData($filter)
    {
        $tanggalAwal = $filter['tanggal_awal'];
        $tanggalAkhir = $filter['tanggal_akhir'];
        $allDate = $filter['all_date'];

        $sql = "SELECT " . self::__tableName . ".* FROM " . self::__tableName . " WHERE " . self::__tableName . ".tanggal != ' ' ";
        if ($this->idToko > 0) {
            $sql .= "AND " . self::__tableName . ".id_bengkel = '{$this->idToko}' ";
        }
        if ($allDate == 0) {
            if (strlen($tanggalAwal) > 0 && strlen($tanggalAkhir) > 0) {
                $tanggalAwal = date('Y-m-d H:i:s', strtotime($tanggalAwal . ' 00:00:00'));
                $tanggalAkhir = date('Y-m-d H:i:s', strtotime($tanggalAkhir . ' 23:58:59'));
                if ($this->idToko > 0) {
                    $sql .= "AND " . self::__tableName . ".id_bengkel = '{$this->idToko}' ";
                }
                $sql .= " AND " . self::__tableName . ".tanggal >= '{$tanggalAwal}' AND " . self::__tableName . ".tanggal <= '{$tanggalAkhir}'";
            }
        }
        $data = $this->db->query($sql);
        return $data->result();
    }

    public function selectToko($idToko)
    {
        $sql = "SELECT * FROM tbl_toko WHERE id_toko = '$idToko' ";
        $data = $this->db->query($sql);
        return $data->row();
    }

    public function selectDetail($id)
    {
        $sql = "SELECT * FROM tbl_detail_penjualan WHERE kode_penjualan = '$id' ";
        $data = $this->db->query($sql);
        return $data->result();
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_total extends CI_Model
{
  public function __construct()
  {
    parent::__construct();
    $this->load->database();
    $this->idToko = $this->session->userdata('id_toko');
  }

  public function totalPelanggan()
  {
    $sql = "SELECT * FROM tbl_pelanggan";
    if ($this->idToko > 0) {
      $sql .= " WHERE id_toko = '{$this->idToko}'";
    }
    $data = $this->db->query($sql);
    return $data->num_rows();
  }

  public function totalInventory()
  {
    $sql = "SELECT * FROM tbl_product";
    if ($this->idToko > 0) {
      $sql .= " WHERE id_toko = '{$this->idToko}'";
    }
    $data = $this->db->query($sql);
    return $data->num_rows();
  }

  public function totalOrder()
  {
    $bulan = date('m');
    $sql = "SELECT * FROM tbl_penjualan WHERE month(tanggal)='$bulan' ";
    if ($this->idToko > 0) {
      $sql .= " AND id_toko = '{$this->idToko}'";
    }
    $data = $this->db->query($sql);
    return $data->num_rows();
  }

  public function totalTransaksi()
  {
    $hari = date('d');
    $sql = "SELECT SUM(total) AS total,tanggal FROM tbl_penjualan WHERE DAY(tanggal)='$hari' ";
    if ($this->idToko > 0) {
      $sql .= " AND id_toko = '{$this->idToko}'";
    }
    $data = $this->db->query($sql);
    return $data->row();
  }


  public function get_total_penjualan()
  {
    $bulan = date('m');
    $tahun = date('Y');
    $query = " SELECT id_toko, tanggal,SUM(total) AS total FROM tbl_penjualan WHERE MONTH(tanggal) = $bulan AND YEAR(tanggal) = $tahun ";
    if ($this->idToko > 0) {
      $query .= " AND id_toko = '{$this->idToko}'";
    }
    $query .= "GROUP BY tanggal";
    $data = $this->db->query($query);
    if ($data->num_rows() > 0) {
      foreach ($data->result() as $res) {
        $hasil[] = $res;
      }
      return $hasil;
    }
  }


  public function query_v_stok()
  {
    $query = "SELECT tbl_so.id as id_stok tbl_so.id_brg as id_brg,tbl_so.id_toko as id_toko,tbl_so.nama_brg as nama_brg,tbl_so.tanggal as tanggal,tbl_so.beli as beli,tbl_so.jual as jual,tbl_product.kode_barang as kode_barang,tbl_product.kategori as kategori,tbl_product.stok as stok
    FROM tbl_so
    LEFT JOIN tbl_product ON tbl_product.id = tbl_so.id_brg
    ORDER BY tbl_so.id DESC ";
  }
}

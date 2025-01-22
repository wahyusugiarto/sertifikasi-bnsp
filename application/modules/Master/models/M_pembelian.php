<?php

class M_pembelian extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
		$this->load->database();
		$this->idToko = $this->session->userdata('id_toko');
	}

	public function selekSupplier()
	{
		$sql = " SELECT * FROM tbl_supplier";
		$data = $this->db->query($sql);
		return $data->result();
	}

	function tampil()
	{
		$this->db->select('*');
		$this->db->from('tbl_product');
		if ($this->idToko > 0) {
			$this->db->where('id_toko', $this->idToko);
		}
		$this->db->order_by('id', 'ASC');
		return $this->db->get();
	}

	function tampil_brg()
	{
		return $this->db->get('tbl_product');
	}

	function tampil_cart($where)
	{
		return $this->db->get_where('tbl_temp_beli', $where);
	}

	function tampil_tt($where)
	{
		return $this->db->get_where('tbl_temp_tt', $where);
	}

	function savecart($data)
	{
		$this->db->insert_batch('tbl_detail_pembelian', $data);
	}

	function cek_beli($where)
	{
		return $this->db->get_where('tbl_temp_beli', $where);
	}

	function saveorder($order)
	{
		$this->db->insert('tbl_pembelian', $order);
	}

	function getnonota()
	{
		return $this->db->get('tbl_pembelian');
	}

	function notaterakhir()
	{
		return $this->db->get('tbl_pembelian');
		$this->db->order_by('no_beli', 'DESC');
	}

	function updatestock($stok, $id)
	{
		$this->db->set('stok', 'stok+' . $stok, FALSE);
		$this->db->where_in('id', $id);
		$this->db->update('tbl_product');
	}

	function delcart($where)
	{
		$this->db->delete('tbl_temp_beli', $where);
	}

	function get_so($where)
	{
		$this->db->select('id_brg,tanggal');
		$this->db->from('tbl_so');
		$this->db->where('id_brg', $where);
		$this->db->where('tanggal', date('Y-m-d'));
		return $this->db->get();
	}

	function stok_awal($where, $idbrg)
	{
		$this->db->select('id_brg,tanggal');
		$this->db->from('tbl_so');
		$this->db->where('id_brg', $idbrg);
		$this->db->where('date_format(tanggal,"%m")', $where);
		return $this->db->get();
	}
}

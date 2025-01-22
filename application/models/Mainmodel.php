<?php
class Mainmodel extends CI_Model{
	function __construct(){
		parent::__construct();
	}
	function insert($tabel='', $data=''){
		$this->load->database();		
		$this->db->trans_start();
		$this->db->insert($tabel, $data);
		return $this->db->trans_complete();
	}
	function update($tabel='', $data='', $kolom='', $value){
		$this->load->database();		
		$this->db->trans_start();
		$this->db->where($kolom, $value);
		$this->db->update($tabel, $data);
		return $this->db->trans_complete();
	}
	function updatenew($tabel='', $data='', $paramsArray=array()){
	
		$this->db->trans_start();
		while(list($key,$val) = each($paramsArray))
		{
			$this->db->where($key, $val);
		}

		$this->db->update($tabel, $data);
		return $this->db->trans_complete();
	}
	function delete($tabel='', $id='id', $value=''){
		$this->db->where($id, $value);
		return $this->db->delete($tabel);
	}
	function deletenew($tabel='', $paramsArray=array()){
		while(list($key,$val) = each($paramsArray))
		{
			$this->db->where($key, $val);
		}
		return $this->db->delete($tabel);
	}
	function get_all_table($table='', $limit=0, $from=0, $paramsArray=array(), $id='id', $order='ASC', $codition = "%"){
		$this->db->limit($from, $limit);
		while(list($key,$val) = each($paramsArray))
		{
			if ($codition == "=") 
			$this->db->where($key, $val);
			else
			$this->db->or_like("lower(".$key.")", strtolower($val));
		}

		$this->db->order_by($id, $order);
		$q = $this->db->get($table);
		$data = $q->result();
		$q->free_result();
		return $data;
	}
	function get_all_table_new($table='', $limit=0, $from=0, $paramsArray=array(), $orderArray=array(), $codition = "%"){
		$this->db->limit($from, $limit);
		while(list($key,$val) = each($paramsArray))
		{
			if ($codition == "=") 
			$this->db->where($key, $val);
			else
			$this->db->or_like("lower(".$key.")", strtolower($val));
		}

		while(list($key,$val) = each($orderArray))
		{

			$this->db->order_by($key, $val);
		}

		
		$q = $this->db->get($table);
		$data = $q->result();
		$q->free_result();
		return $data;
	}
	function get_table_byid($table='', $id='id', $kolom='id'){
		$this->db->where($kolom, $id);
		$q = $this->db->get($table);
		$data = $q->row();
		$q->free_result();
		return $data;
	}
	function query_multiple_row($sql=""){
		$q = $this->db->query($sql);
		$data = $q->result();
		$q->free_result();
		return $data;
	}
	function query_multiple_row_array($sql=""){
		$q = $this->db->query($sql);
		$data = $q->result_array();
		$q->free_result();
		return $data;
	}
	function query_single_row($sql=""){
		$q = $this->db->query($sql);
		$data = $q->row();
		$q->free_result();
		return $data;
	}
	function query_no_result($sql=""){
		return $this->db->query($sql);
	}
	function get_login($username='', $password=''){
		$sql = "SELECT COUNT(*) AS jumlah FROM  ".$this->db->skema_set."user WHERE (email = '{$username}' or username = '{$username}') 
		and password='{$password}' AND status_aktif = 'Y' ";
		//echo $sql; exit;
		$q = $this->db->query($sql);
		$data = $q->row();
		$q->free_result();
		return $data;
	}
	function get_user_akun($username=''){
		$sql = "SELECT A.id, A.group_id, A.id_kabupaten, A.type_user, A.password, A.username, A.email, A.nama_depan, A.nama_belakang, A.alamat, A.telpon, A.reset, A.status_aktif,
            B.nama AS nama_group 
        FROM ".$this->db->skema_set."user A 
        LEFT JOIN ".$this->db->skema_set."user_group B on A.group_id = B.id  
        WHERE A.email = '". $username . "' OR A.username = '". $username . "' 
		";
		//echo $sql;
		$q = $this->db->query($sql);
		$data = $q->row();
		$q->free_result();
		return $data;
	}
	function get_admin_menu($level=0, $group_id=0, $type_user=0){
		
		$sql = " SELECT A.id AS id_menu, A.menu_alias, A.parent_id, A.nama, A.link, A.urutan, A.ikon, 
			(SELECT COUNT(*) FROM ".$this->db->skema_set."menu X WHERE X.parent_id = A.id) AS menu_child
			FROM  ".$this->db->skema_set."menu A 
			INNER JOIN  ".$this->db->skema_set."menu_akses B ON A.id = B.menu_id  AND B.group_id = $group_id AND B.akses <> 3
			WHERE A.parent_id = ". intval($level). "
			ORDER BY  A.urutan ASC ";
		//echo $sql;
		$q = $this->db->query($sql);
		$data = $q->result();
		$q->free_result();
		return $data;
	}
	function cek_akses_menu($alias='', $sessi=array()){
		$sql = " SELECT C.nama AS menu, B.nama AS nama_group, A.akses 
			FROM ".$this->db->skema_set."menu_akses A
			LEFT JOIN ".$this->db->skema_set."user_group B ON A.group_id = B.id 
			LEFT JOIN ".$this->db->skema_set."menu C ON A.menu_id = C.id
			WHERE A.group_id = ". intval($sessi['id_group']);
		$q = $this->db->query($sql);
		$data = $q->row();
		$q->free_result();
		return $data;
	}
	function cek_akses_menu2($id_group){
		$sql = " SELECT C.menu_alias, C.nama, A.group_id, A.akses 
			FROM ".$this->db->skema_set."menu_akses A
            LEFT JOIN ".$this->db->skema_set."user_group B ON A.group_id = B.id
            LEFT JOIN ".$this->db->skema_set."menu C ON A.menu_id = C.id
            WHERE A.group_id = ". intval($id_group) ." and A.akses <> 3";
		$q = $this->db->query($sql);
		$access = array();
	
		foreach($q->result() as $row)
		{	
			$access[] = array("id" => $row->menu_alias, "nama" => $row->nama, "group" => $row->group_id, "akses" => $row->akses);			
		}
		$q->free_result();
		return ($access);
	}
	function get_id_baru_int($tabel='', $kolom=''){

		$this->db->select_max($kolom, "ID_BARU");
		$result = $this->db->get($tabel)->row();  

		return (isset($result->ID_BARU) ? $result->ID_BARU + 1 : 1);

		/*
		$sql = " SELECT MAX($kolom) AS id_baru from IMASYS_ETC.2".$tabel;
		$q = $this->db->query($sql);
		$data = $q->row();
		$q->free_result();
		return $data->id_baru;*/
	}
	function get_no_nota($kd_cabang='', $tahun='', $jenis_jurnal='', $tipe=''){
		$no_nota = "";
		$query = "select no_dipakai from " . $this->db->skema_keu . "m_no_transaksi where kd_cabang = $kd_cabang
		and kd_bukti = '". $tipe.$jenis_jurnal ."' and kd_periode = '". $tahun ."' ";
		$q = $this->db->query($query);
		$data = $q->row();
		$q->free_result();

		if (count($data)=="0") {
			$id_no_transaksi = $this->get_id_baru_int($this->db->skema_keu . "m_no_transaksi", 'id_no_transaksi');

			$this->db->query("insert into " . $this->db->skema_keu . "m_no_transaksi (kd_cabang, kd_bukti, ket_bukti, kd_periode, no_start, no_stop, no_dipakai, kd_aktif, created_date, created_by, id_no_transaksi) values ($kd_cabang, '" . $tipe.$jenis_jurnal . "', '" . $tipe.$jenis_jurnal . "', '$tahun', 1, 999999, 0, 'Y', '". date('Y-m-d H:i:s') ."', 'admin', $id_no_transaksi)");
			$current_no = 0;
		} else {
			$current_no = $data->no_dipakai;
		}

		$no_dipakai = $current_no + 1;

		$this->db->query("update " . $this->db->skema_keu . "m_no_transaksi set no_dipakai = $no_dipakai where kd_cabang = $kd_cabang
		and kd_bukti = '". $tipe.$jenis_jurnal ."' and kd_periode = '". $tahun ."' ");

		if ($tipe=="POS") {
			$no_nota = str_pad($no_dipakai, 5, "0", STR_PAD_LEFT);	
		} else {
			$no_nota = str_pad($no_dipakai, 5, "0", STR_PAD_LEFT) . "/".$jenis_jurnal."/" . $tahun;
		}
		
		return $no_nota;
	}
	function get_no_nota_baru($kd_cabang='', $tahun='', $jenis_jurnal='', $tipe=''){
		$no_nota = "";

		$query = " select coalesce(max(substr(no_nota, 0, 5)), 1) current_no 
					from keuangan_t_jurnal_transaksi where kd_cabang = $kd_cabang
				   and jen_jurnal = '". $jenis_jurnal ."' and thn_buku = '". $tahun ."' ";
		$q = $this->db->query($query);
		$data = $q->row();
		$q->free_result();

		$current_no = $data->current_no + 1;

		if ($tipe=="POS") {
			$no_nota = str_pad($current_no, 5, "0", STR_PAD_LEFT);	
		} else {
			$no_nota = str_pad($current_no, 5, "0", STR_PAD_LEFT) . "/".$jenis_jurnal."/" . $tahun;
		}
		
		return $no_nota;
	}
	function get_no_invoice($no_nota, $bulan, $tahun){
		
		$romance = array(1 => "I", 2 => "II", 3 => "III", 4 => "IV", 
			5 => "V", 6 => "VI", 7 => "VII", 8 => "VIII", 9 => "IX", 10 => "X", 11 => "XI", 12 => "XII");
		$no_nota = substr($no_nota, 0, 5) . "/INV/" . $romance[intval($bulan)] . "-" . $tahun;
		return $no_nota;
	}	
	function get_kode($tipe='', $tanggal=''){
		$sql = "SELECT logistik_get_kode('". $tipe ."', STR_TO_DATE('". $tanggal ."', '%Y-%m-%d') ) AS kode ";
		$q = $this->db->query($sql);
		$result = $q->row();
		return $result->kode;
	}
	function kickUser() {
		
		$status_link = $this->input->post('status_link');

		if ($status_link == "ajax") {
			echo "out";exit;
		} else {
			redirect('logout');	
		}
	}
}
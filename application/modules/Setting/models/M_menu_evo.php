<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_menu_evo extends CI_Model
{

    public function selekDataMenu()
    {
        $sql = " select * from tbl_menu order by urutan ASC";
        $data = $this->db->query($sql);

        return $data->result();
    }

    public function selectByExist($arrWhere = array(), $id = null)
    {
        $sql = "SELECT * FROM tbl_menu WHERE ";
        if (is_array($arrWhere)) {
            foreach ($arrWhere as $key => $value) {
                $sql .= $key . " = '{$value}'";
            }
        }
        if ($id != null) {
            $sql .= " AND id_menu <> '{$id}'";
        }
        $data = $this->db->query($sql);

        return $data->row();
    }

    public function selectById($id)
    {
        $sql = "SELECT * FROM tbl_menu WHERE id_menu = '{$id}'";
        $data = $this->db->query($sql);

        return $data->row();
    }

    public function update($data, $where)
    {
        $result = $this->db->update('tbl_menu', $data, $where);

        return $result;
    }

    public function pilih_menu()
    {
        $sql = " select * from tbl_menu where menu_file in ('view')";
        $data = $this->db->query($sql);

        return $data->result();
    }

    public function selectParent($id)
    {
        $sql = " select * from tbl_menu where parent = '" . $id . "' ";
        $data = $this->db->query($sql);

        return $data->result();
    }

    public function cari_ajax($cari)
    {
        $where = "menu_file='view'";
        $this->db->select('*');
        $this->db->from('tbl_menu');
        $this->db->like('nama_menu', $cari);
        $this->db->where($where);

        return $this->db->get()->result_array();
    }
}

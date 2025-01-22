<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_User extends CI_Model
{

    public function getData()
    {
        $sql = "SELECT admin.*,
                grup.nama_grup AS grup_id, 
                status_grup.nama AS status 
                FROM admin
                left join(grup)on admin.grup_id=grup.grup_id
                left join(status_grup)on admin.status=status_grup.id_status
                WHERE admin.hidden ='1'
                ORDER BY id DESC ";
        $data = $this->db->query($sql);

        return $data->result();
    }

    public function selectById($id)
    {
        $sql = "SELECT * FROM admin WHERE id = '{$id}'";
        $data = $this->db->query($sql);

        return $data->row();
    }

    public function selectByUsername($username, $id = null)
    {
        $sql = "SELECT * FROM admin WHERE username = '{$username}'";
        if ($id != null) {
            $sql .= " AND id <> '{$id}'";
        }
        $data = $this->db->query($sql);

        return $data->row();
    }

    public function select_status()
    {
        $sql = " select * from status_grup WHERE nama in ('Aktif', 'Non aktif')";
        $data = $this->db->query($sql);

        return $data->result();
    }

    public function selectToko()
    {
        $sql = " SELECT * FROM tbl_toko";
        $data = $this->db->query($sql);

        return $data->result();
    }

    public function select_group()
    {
        $sql = " select * from grup WHERE grup_id <> '1'";
        $data = $this->db->query($sql);
        return $data->result();
    }
}

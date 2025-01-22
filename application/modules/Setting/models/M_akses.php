
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_akses extends CI_Model
{

    public function select_by_id($id)
    {
        $sql = "SELECT * FROM grup WHERE grup_id = '{$id}'";
        $data = $this->db->query($sql);

        return $data->row();
    }

    public function hapus($id)
    {
        $sql = "DELETE FROM menu_akses WHERE grup_id='" . $id . "'";
        $this->db->query($sql);

        return $this->db->affected_rows();
    }

    // VIEW USER PRIVILEGE
    public function hak_akses($id)
    {
        if (!$id)
            return FALSE;
        $query = "  select a.id_menuakses, b.id_menu as menus, a.id_menu, b.nama_menu,b.icon as icon, a.grup_id, b.menuparent, c.nama_grup, a.view, a.add, a.edit, a.del, b.menu_file
					from (select * from menu_akses where grup_id = '" . $id . "') a
					right join (select a.*, b.nama_menu as menuparent from tbl_menu a left join tbl_menu b on a.parent = b.id_menu) b
					on a.id_menu = b.id_menu
					left join grup c
					on a.grup_id = c.grup_id
					order by menuparent";
        $data = $this->db->query($query);

        return $data->result();
    }

    function save($data)
    {
        $result = $this->db->insert('menu_akses', $data);

        return $result;
    }

    public function delete($id)
    {
        $sql = "DELETE FROM menu_akses WHERE grup_id ='" . $id . "'";
        $this->db->query($sql);

        return $this->db->affected_rows();
    }
}

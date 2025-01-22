<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Akses extends AUTH_Controller
{

    function __construct()
    {
        parent::__construct();
        $this->load->model('M_akses', 'akses');
        $this->load->model('M_sidebar');
    }

    // ADD DATA
    public function hak_akses($id)
    {
        /* ini harus ada boss */
        $data['page'] = "Hak Akses";
        $data['judul'] = "Hak Akses";
        $access = $this->M_sidebar->access('edit', 'grup');
        if ($access->menuview == 1) {
            parent::loadkonten('Dashboard/layouts/no_akses', $data);
        } else {
            $this->_set_rules_privilege();
            $data['privilege'] = $this->akses->hak_akses($id);
            $data['groupname'] = $this->akses->select_by_id($id);
            $data['grup_id'] = $id;
            $data['userdata'] = $this->userdata;
            parent::loadkonten('v_akses/v_hak_akses', $data);
        }
    }

    public function update_hak_akses($id)
    {
        $data['privilege'] = $this->akses->hak_akses($id);
        $data['groupname'] = $this->akses->select_by_id($id);
        $data['grup_id'] = $id;
        $data['userdata'] = $this->userdata;

        $delete = $this->akses->hapus($id);

        $data = array(
            'last_update_date' => date('Y-m-d H:i:s'),
            'last_update_by' => $this->session->userdata('username'),
        );
        $result = $this->db->update('grup', $data, array('grup_id' => $id));

        if ($delete == FALSE) {
            $menu = $this->input->post('id_menu');
            foreach ($menu as $row => $id_menu) {
                $view = isset($_REQUEST['view'][$id_menu]);
                $add = isset($_REQUEST['add'][$id_menu]);
                $edit = isset($_REQUEST['edit'][$id_menu]);
                $del = isset($_REQUEST['del'][$id_menu]);

                $data = array(
                    'id_menu' => $id_menu,
                    'grup_id' => $id,
                    'view' => $view,
                    'add' => $add,
                    'edit' => $edit,
                    'del' => $del,
                );
                $result = $this->akses->save($data);

                if ($result > 0) {
                    $out = array('status' => true, 'pesan' => ' Hak akses berhasil di update');
                } else {
                    $out = array('status' => false, 'pesan' => 'Hak akses gagal disimpan !');
                }
            }
        } else {
            $menu = $this->input->post('id_menu');
            foreach ($menu as $row => $id_menu) {
                $view = isset($_REQUEST['view'][$id_menu]);
                $add = isset($_REQUEST['add'][$id_menu]);
                $edit = isset($_REQUEST['edit'][$id_menu]);
                $del = isset($_REQUEST['del'][$id_menu]);

                $data = array(
                    'id_menu' => $id_menu,
                    'grup_id' => $id,
                    'view' => $view,
                    'add' => $add,
                    'edit' => $edit,
                    'del' => $del,
                );
                $result = $this->akses->save($data);

                if ($result > 0) {
                    $out = array('status' => true, 'pesan' => ' Hak akses berhasil di update');
                    // echo "<meta http-equiv='refresh' content='0; url=".base_url()."user-grup.html'>";
                } else {
                    $out = array('status' => false, 'pesan' => 'Hak akses gagal disimpan !');
                }
            }
        }

        echo json_encode($out);
    }

    function _set_rules_privilege()
    {
        $this->form_validation->set_rules('id_menu', 'Menu', '');
    }
}

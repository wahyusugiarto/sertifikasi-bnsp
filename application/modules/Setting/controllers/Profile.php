<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Profile extends AUTH_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_sidebar');
    }

    public function index()
    {
        $data['userdata'] = $this->userdata;

        $data['page'] = "profile";
        $data['judul'] = "Profile";
        $data['datagrup'] = $this->M_admin->select_group();
        $data['dataStatus'] = $this->M_admin->select_status();
        parent::loadkonten('v_profil/profile', $data);
    }

    public function update()
    {
        $err = 0;
        $id = $this->input->post('id');
        $nama = $this->input->post('nama');
        $foto = $this->input->post('gambar_single');
        $tipeFile = $this->input->post('gambar_single_tp');

            
            if ($tipeFile <> 'jpg' && $tipeFile <> 'png' && $tipeFile <> 'jpeg') {
                $err++;
                $out = array('status' => false, 'pesan' => 'gambar harus ekstensi jpg/png');
            }

            if ($foto != '') {
                if ($tipeFile <> 'jpg' && $tipeFile <> 'png' && $tipeFile <> 'jpeg') {
                    $out = array('status' => false, 'pesan' => 'gambar harus ekstensi jpg/png');
                } else {
    
                    $data = array(
                        'foto'      => $foto,
                        'nama'      => $nama,
                    );
                    
                    $result = $this->db->update('admin', $data, array('id' => $id));
                    $this->session->set_userdata('nama', $nama);
                    $this->session->set_userdata('foto', $foto);
                    if ($result > 0) {
                        $out = array('status' => true, 'pesan' => ' Data has been updated');
                    } else {
                        $out = array('status' => false, 'pesan' => 'Data has been failed updated!');
                    }
                } 
            } else {

                $data = array(
                    'nama'      => $nama,
                );
                $result = $this->db->update('admin', $data, array('id' => $id));

                $this->session->set_userdata('nama', $nama);
                if ($result > 0) {
                    $out = array('status' => true, 'pesan' => ' Data has been updated');
                } else {
                    $out = array('status' => false, 'pesan' => 'Data has been failed updated!');
                }
            } 

        echo json_encode($out);
    }

    public function ubah_password()
    {
        $this->form_validation->set_rules('passLama', 'Password Lama', 'trim|required');
        $this->form_validation->set_rules('passBaru', 'Password Baru', 'trim|required');
        $this->form_validation->set_rules('passKonf', 'Password Konfirmasi', 'trim|required');
        $this->form_validation->set_rules('last_update_by', 'last_update_by', 'trim|required');
        $password = $this->input->post('passLama');
        $id = $this->session->userdata('id');
        if ($this->form_validation->run() == TRUE) {
            if (md5($this->input->post('passLama')) == $this->session->userdata('password')) {
                if ($this->input->post('passBaru') != $this->input->post('passKonf')) {
                    $out = array('status' => false, 'pesan' => 'Password Baru dan Konfirmasi Password harus sama !');
                } else {
                    $data = [
                        'password' => md5($this->input->post('passBaru'))
                    ];

                    $result = $this->M_admin->update($data, $id);
                    if ($result > 0) {
                        $this->session->set_userdata('password', $password);
                        $this->updateProfil();
                        $out = array('status' => true, 'pesan' => ' Password berhasil di update');
                    } else {
                        $out = array('status' => false, 'pesan' => 'Maaf gagal update password !');
                    }
                }
            } else {
                $out = array('status' => false, 'pesan' => 'Maaf gagal update password !');
            }
        } else {
            $out = array('status' => false, 'pesan' => 'Maaf gagal update password kosong !');
        }
        echo json_encode($out);
    }
}

/* End of file Profile.php */
/* Location: ./application/controllers/Profile.php */
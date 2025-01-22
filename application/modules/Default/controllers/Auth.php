<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Auth extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_auth');
        $this->load->library('form_validation', 'Cookie', 'session', 'url');
    }

    public function messageAlert($type, $title)
    {
        $messageAlert = "
        Swal.fire(
			'Berhasil Login',
			'" . $title . "',
			'" . $type . "'
		  )";
        return $messageAlert;
    }

    public function index()
    {
        $session = $this->session->userdata('status');
        $cookie = get_cookie('wahyu');

        if ($session == true) {
            redirect('dashboard');
        } else if ($cookie <> '') {
            // cek cookie
            $data = $this->M_auth->get_by_cookie($cookie)->row();
            if ($data) {
                $this->_daftarkan_session($data);
            } else {
                $data = array(
                    'username' => set_value('username'),
                    'password' => set_value('password'),
                    'remember' => set_value('remember'),
                );
                $this->load->view('login', $data);
            }
        } else {
            $data = array(
                'username' => set_value('username'),
                'password' => set_value('password'),
                'remember' => set_value('remember'),
            );
            $this->load->view('login', $data);
        }
    }

    public function login2()
    {

        if ($this->input->is_ajax_request()) {
            $this->form_validation->set_rules('username', 'Username', 'required|min_length[4]|max_length[30]');
            $this->form_validation->set_rules('password', 'Password', 'required');

            if ($this->form_validation->run() == TRUE) {
                $username = trim($_POST['username']);
                $password = trim($_POST['password']);
                $remember = trim($_POST['remember']);

                $data = $this->M_auth->login($username, $password);

                /* ketika status aktif tidak sama */

                if ($remember) {
                    $key = random_string('alnum', 64);
                    set_cookie('wahyu', $key, 3600 * 24 * 30); // set expired 30 hari kedepan
                    // simpan key di database
                    $update_key = array(
                        'cookie' => $key
                    );
                    $this->M_auth->update_cookie($update_key, $data->id);
                }
                $this->_daftarkan_session($data);

                $session['id'] = $data->id;
                $session['username'] = $data->username;
                $session['grup_id'] = $data->grup_id;
                $session['nama'] = $data->nama;
                $session['status'] = $data->status;
                $session['id_toko'] = $data->id_toko;

                $stat = $data->status;
                if ($stat == 3) {
                    $this->session->set_userdata($session);
                    $status = 3;
                    $this->M_auth->update($session['id'], $status);
                    $data = array(
                        'last_login_user' => date('Y-m-d H:i:s')
                    );
                    $this->session->set_flashdata('messageAlert', $this->messageAlert('success', 'Hallo Admin ' . $session['nama'] . ''));
                    $this->M_auth->update_user($session['id'], $data);
                    $URL_home = base_url('Dashboard');
                    $json['status']        = true;
                    $json['url_home']     = $URL_home;
                    $json['pesan']     = "Login berhasil.";
                } else {
                    $json['pesan']     = "akun belum aktif.";
                }

                if ($data == false) {
                    $json['pesan']     = "username atau password salah";
                } else {
                    // $session = [ 'userdata' => $data, 'status' => "Loged in"];			
                    $this->session->set_userdata($session);
                    // $URL_home = site_url('Dashboard');
                    // $json['status']		= 1;
                    // $json['url_home'] 	= $URL_home;
                }
            } else {
                $json['pesan']     = "Tidak bisa login silahkan cek username & password";
            }
        } else {
            redirect('login');
        }

        echo json_encode($json);
    }

    public function _daftarkan_session($data)
    {
        $sess = array(
            'id' => $data->id,
            'username' => $data->username,
        );
        $this->session->set_userdata($sess);
        $URL_home = base_url('dashboard');
        $json['status'] = true;
        $json['url_home'] = $URL_home;
        $json['pesan'] = "Success Login.";
    }

    public function logout()
    {
        delete_cookie('wahyu');
        $this->session->sess_destroy();
        redirect('login');
    }
}

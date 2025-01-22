<?php
defined('BASEPATH') or exit('No direct script access allowed');

class User extends AUTH_Controller
{
    const __tableName = 'admin';
    const __tableId = 'id';
    const __folder = 'v_user/';
    const __kode_menu = 'user';
    const __title = 'User';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_user');
        $this->load->model('M_sidebar');
    }

    public function index()
    {
        /* ini harus ada boss */
        $access = $this->M_sidebar->access('view', self::__kode_menu);
        $data['userdata'] = $this->userdata;
        $data['page'] = self::__title;
        $data['judul'] = "Tambah " . self::__title;
        if ($access->menuview == 0) {
            parent::loadkonten('Dashboard/layouts/no_akses', $data);
        } else {
            $accessAdd = $this->M_sidebar->access('add', self::__kode_menu);
            $data['accessAdd'] = $accessAdd->menuview;
            parent::loadkonten(self::__folder . 'home', $data);
        }
    }

    public function ajax_list()
    {
        $list = $this->M_user->getData();

        $accessEdit = $this->M_sidebar->access('edit', self::__kode_menu);
        $accessDel = $this->M_sidebar->access('del', self::__kode_menu);

        $data = array();
        $no = $_POST['start'];
        foreach ($list as $user) {
            $no++;
            $row = array();
            $row[] = $no;

            $userFoto =  base_url() . 'assets/tambahan/gambar/no-image.jpg';
            if (strlen($user->foto) > 0) {
                $userFoto = $user->foto;
            }

            $row[] = '<a href="' . $userFoto . '" target="_blank"><img class="img-thumbnail" src="' . $userFoto . '"   width="90" /></a>';
            $row[] = $user->email;
            $row[] = $user->nama;
            $row[] = $user->grup_id;
            $row[] = '<small class="label pull-center bg-green">' . $user->status . '</small">';
            $row[] = anchor('edit-user/' . $user->id, ' <span class="fa fa-edit"></span>', ' class="btn btn-icon btn-primary ajaxify klik " ') .
                ' <button class="btn btn-icon btn-danger hapus-user" data-id=' . "'" . $user->id . "'" . '><i class="fa fa-trash"></i></button>';
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }

    public function add()
    {
        /* ini harus ada boss */
        $access = $this->M_sidebar->access('add', self::__kode_menu);
        $data['userdata'] = $this->userdata;
        $data['page'] = self::__title;
        $data['judul'] = "Tambah " . self::__title;
        if ($access->menuview == 0) {
            parent::loadkonten('Dashboard/layouts/no_akses', $data);
        } else {
            $data['menuName'] = self::__kode_menu;
            $data['datagrup'] = $this->M_user->select_group();
            $data['dataToko'] = $this->M_user->selectToko();
            parent::loadkonten('' . self::__folder . 'tambah', $data);
        }
    }

    public function prosesAdd()
    {
        $errCode = 0;
        $errMessage = "";

        $grupId = trim($this->input->post("grup_id"));
        $idToko = trim($this->input->post("id_toko"));
        $nama = trim($this->input->post("nama"));
        $email = trim($this->input->post("email"));
        $username = trim($this->input->post("username"));
        $password = trim($this->input->post("password"));

        $this->db->trans_begin();
        if ($errCode == 0) {
            $access = $this->M_sidebar->access('add', self::__kode_menu);
            if ($access->menuview == 0) {
                $errCode++;
                $errMessage = "You don't have access.";
            }
        }
        if (strlen($grupId) == 0) {
            $errCode++;
            $errMessage = "Grup wajib di isi.";
        }

        if ($errCode == 0) {
            if (strlen($idToko) == 0) {
                $errCode++;
                $errMessage = "Id toko wajib di isi.";
            }
        }

        if ($errCode == 0) {
            if (strlen($nama) == 0) {
                $errCode++;
                $errMessage = "Nama wajib di isi.";
            }
        }
        if ($errCode == 0) {
            if (strlen($email) == 0) {
                $errCode++;
                $errMessage = "Email wajib di isi.";
            }
        }
        if ($errCode == 0) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errCode++;
                $errMessage = "Format Email salah.";
            }
        }
        if ($errCode == 0) {
            if (strlen($username) == 0) {
                $errCode++;
                $errMessage = "Username wajib di isi.";
            }
        }
        if ($errCode == 0) {
            if (strlen($password) == 0) {
                $errCode++;
                $errMessage = "Password wajib di isi.";
            }
        }
        if ($errCode == 0) {
            try {
                $data = array(
                    'grup_id' => $grupId,
                    'id_toko' => $idToko,
                    'nama' => $nama,
                    'email' => $email,
                    'username' => $username,
                    'password' => md5($password),
                    'hidden' => '1',
                    'status' => '3',
                    'created_by' => $this->session->userdata('nama'),
                    'last_created_date' => date('Y-m-d H:i:s')
                );
                $this->db->insert(self::__tableName, $data);
            } catch (Exception $ex) {
                $errCode++;
                $errMessage = $ex->getMessage();
            }
        }
        if ($errCode == 0) {
            if ($this->db->trans_status() === FALSE) {
                $errCode++;
                $errMessage = "Error saving databse.";
            }
        }

        if ($errCode == 0) {
            $this->db->trans_commit();
            $out = array('status' => true, 'pesan' => ' Data berhasil di simpan');
        } else {
            $this->db->trans_rollback();
            $out = array('status' => false, 'pesan' => $errMessage);
        }

        echo json_encode($out);
    }

    public function Edit($id)
    {
        /* ini harus ada boss */
        $access = $this->M_sidebar->access('edit', self::__kode_menu);
        $data['userdata'] = $this->userdata;
        $data['page'] = self::__title;
        $data['judul'] = "Ubah " . self::__title;
        if ($access->menuview == 0) {
            parent::loadkonten('Dashboard/layouts/no_akses', $data);
        } else {
            $resultData = $this->M_user->selectById($id);
            if ($resultData != null) {
                $data['resultData'] = $resultData;
                $data['datagrup'] = $this->M_user->select_group();
                $data['dataStatus'] = $this->M_user->select_status();
                $data['dataToko'] = $this->M_user->selectToko();
                $data['menuName'] = self::__kode_menu;
                parent::loadkonten('' . self::__folder . 'update', $data);
            } else {
                echo "<script>alert('" . self::__title . " tidak tersedia.'); window.location = '" . base_url(self::__kode_menu) . "';</script>";
            }
        }
    }

    public function prosesUpdate($id)
    {
        $errCode = 0;
        $errMessage = "";

        $grupId = trim($this->input->post("grup_id"));
        $idToko = trim($this->input->post("id_toko"));
        $status = trim($this->input->post("status"));
        $nama = trim($this->input->post("nama"));
        $email = trim($this->input->post("email"));
        $password = trim($this->input->post("password"));

        $this->db->trans_begin();
        if ($errCode == 0) {
            $access = $this->M_sidebar->access('edit', self::__kode_menu);
            if ($access->menuview == 0) {
                $errCode++;
                $errMessage = "You don't have access.";
            }
        }
        if ($errCode == 0) {
            if (strlen($id) == 0) {
                $errCode++;
                $errMessage = "ID does not exist.";
            }
        }
        if ($errCode == 0) {
            if (strlen($idToko) == 0) {
                $errCode++;
                $errMessage = "Id toko wajib di isi.";
            }
        }
        if ($errCode == 0) {
            $checkValid = $this->M_user->selectById($id);
            if ($checkValid == null) {
                $errCode++;
                $errMessage = self::__title . " tidak valid.";
            }
        }
        if ($errCode == 0) {
            if (strlen($grupId) == 0) {
                $errCode++;
                $errMessage = "Grup wajib di isi.";
            }
        }
        if ($errCode == 0) {
            if (strlen($nama) == 0) {
                $errCode++;
                $errMessage = "Nama wajib di isi.";
            }
        }
        if ($errCode == 0) {
            if (strlen($email) == 0) {
                $errCode++;
                $errMessage = "Email wajib di isi.";
            }
        }
        if ($errCode == 0) {
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $errCode++;
                $errMessage = "Format Email salah.";
            }
        }
        if ($errCode == 0) {
            if (strlen($status) == 0) {
                $errCode++;
                $errMessage = "Status wajib di isi.";
            }
        }
        if ($errCode == 0) {
            try {
                $data = array(
                    'grup_id' => $grupId,
                    'id_toko' => $idToko,
                    'nama' => $nama,
                    'email' => $email,
                    'status' => $status,
                    'last_update_date' => date('Y-m-d H:i:s'),
                    'last_update_by' => $this->session->userdata('username'),
                );
                if (strlen($password) > 0) {
                    $data = array_merge($data, array(
                        'password' => md5($password),
                    ));
                }
                $result = $this->db->update(self::__tableName, $data, array(self::__tableId => $id));
            } catch (Exception $ex) {
                $errCode++;
                $errMessage = $ex->getMessage();
            }
        }
        if ($errCode == 0) {
            if ($this->db->trans_status() === FALSE) {
                $errCode++;
                $errMessage = "Error saving databse.";
            }
        }

        if ($errCode == 0) {
            $this->db->trans_commit();
            $out = array('status' => true, 'pesan' => ' Data berhasil di update');
        } else {
            $this->db->trans_rollback();
            $out = array('status' => false, 'pesan' => $errMessage);
        }

        echo json_encode($out);
    }

    public function prosesDelete()
    {
        $date = date('Y-m-d H:i:s');
        $errCode = 0;
        $errMessage = "";

        $id = $_POST[self::__tableId];

        $this->db->trans_begin();
        if ($errCode == 0) {
            $access = $this->M_sidebar->access('del', self::__kode_menu);
            if ($access->menuview == 0) {
                $errCode++;
                $errMessage = "You don't have access.";
            }
        }
        if ($errCode == 0) {
            if (strlen($id) == 0) {
                $errCode++;
                $errMessage = "ID does not exist.";
            }
        }
        if ($errCode == 0) {
            $checkValid = $this->M_user->selectById($id);
            if ($checkValid == null) {
                $errCode++;
                $errMessage = self::__title . " tidak valid.";
            }
        }
        if ($errCode == 0) {
            try {
                $this->db->delete(self::__tableName, array('id' => $id));
            } catch (Exception $ex) {
                $errCode++;
                $errMessage = $ex->getMessage();
            }
        }
        if ($errCode == 0) {
            if ($this->db->trans_status() === FALSE) {
                $errCode++;
                $errMessage = "Error saving databse.";
            }
        }

        if ($errCode == 0) {
            $this->db->trans_commit();
            $out = array('status' => true, 'pesan' => ' Data berhasil di hapus');
        } else {
            $this->db->trans_rollback();
            $out = array('status' => false, 'pesan' => $errMessage);
        }

        echo json_encode($out);
    }
}

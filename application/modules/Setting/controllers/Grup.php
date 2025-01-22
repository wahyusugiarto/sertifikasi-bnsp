<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Grup extends AUTH_Controller
{
    const __tableName = 'grup';
    const __tableId = 'grup_id';
    const __folder = 'v_grup/';
    const __kode_menu = 'user-grup';
    const __title = 'Group';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_grup');
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
            $data['dataWarna'] = $this->M_grup->getData();
            parent::loadkonten(self::__folder . 'home', $data);
        }
    }

    public function add()
    {
        $access = $this->M_sidebar->access('add', self::__kode_menu);
        $data['userdata'] = $this->userdata;
        $data['page'] = self::__title;
        $data['judul'] = "Tambah " . self::__title;
        if ($access->menuview == 0) {
            parent::loadkonten('Dashboard/layouts/no_akses', $data);
        } else {
            $data['page'] = self::__title;
            $data['judul'] = self::__title;
            parent::loadkonten('' . self::__folder . 'tambah', $data);
        }
    }

    public function prosesTambah()
    {
        $errCode = 0;
        $errMessage = "";

        $namaGrup = trim($this->input->post("nama_grup"));
        $deskripsi = trim($this->input->post("deskripsi"));

        $this->db->trans_begin();
        if ($errCode == 0) {
            $access = $this->M_sidebar->access('add', self::__kode_menu);
            if ($access->menuview == 0) {
                $errCode++;
                $errMessage = "You don't have access.";
            }
        }
        if ($errCode == 0) {
            if (strlen($namaGrup) == 0) {
                $errCode++;
                $errMessage = "Nama Group wajib di isi.";
            }
        }
       
        if ($errCode == 0) {
            try {
                $data = array(
                    'nama_grup' => $namaGrup,
                    'deskripsi' => $deskripsi,
                    'last_created_date' => date('Y-m-d H:i:s'),
                    'created_by' => $this->session->userdata('username'),
                    'last_update_date' => date('Y-m-d H:i:s'),
                    'can_delete' =>'1',
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
        $access = $this->M_sidebar->access('edit', self::__kode_menu);
        $data['userdata'] = $this->userdata;
        $data['page'] = self::__title;
        $data['judul'] = "Ubah " . self::__title;
        if ($access->menuview == 0) {
            parent::loadkonten('Dashboard/layouts/no_akses', $data);
        } else {
            if ($id > 1) {
                $datagrup = $this->M_grup->selectById($id);
                if ($datagrup != null) {
                    if ($datagrup->can_delete > 0) {
                        $data['datagrup'] = $datagrup;
                        $data['menuName'] = self::__kode_menu;
                        parent::loadkonten('' . self::__folder . 'update', $data);
                    } else {
                        echo "<script>alert('" . self::__title . " tidak dapat diubah.'); window.location = '" . base_url(self::__kode_menu) . "';</script>";
                    }
                } else {
                    echo "<script>alert('" . self::__title . " tidak tersedia.'); window.location = '" . base_url(self::__kode_menu) . "';</script>";
                }
            } else {
                echo "<script>alert('Super Administrator tidak dapat di ubah.'); window.location = '" . base_url(self::__kode_menu) . "';</script>";
            }
        }
    }

    public function prosesUpdate($id)
    {
        $errCode = 0;
        $errMessage = "";

        $namaGrup = trim($this->input->post("nama_grup"));
        $deskripsi = trim($this->input->post("deskripsi"));

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
            if ($id == 1) {
                $errCode++;
                $errMessage = "Super Administrator tidak dapat di ubah.";
            }
        }
        if ($errCode == 0) {
            $checkValid = $this->M_grup->selectById($id);
            if ($checkValid == null) {
                $errCode++;
                $errMessage = self::__title . " tidak valid.";
            }
        }
        if ($errCode == 0) {
            if ($checkValid->can_delete == 0) {
                $errCode++;
                $errMessage = self::__title . " tidak dapat diubah.";
            }
        }
        if ($errCode == 0) {
            if (strlen($namaGrup) == 0) {
                $errCode++;
                $errMessage = "Nama Group wajib di isi.";
            }
        }
        if ($errCode == 0) {
            try {
                $data = array(
                    'nama_grup' => $namaGrup,
                    'deskripsi' => $deskripsi,
                    'last_update_date' => date('Y-m-d H:i:s'),
                    'last_update_by' => $this->session->userdata('username'),
                );
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
            $out = array('status' => true, 'pesan' => ' Data berhasil di simpan');
        } else {
            $this->db->trans_rollback();
            $out = array('status' => false, 'pesan' => $errMessage);
        }

        echo json_encode($out);
    }

    public function prosesDelete()
    {
        $errCode = 0;
        $errMessage = "";

        $id = $_POST['grup_id'];
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
            if ($id == 1) {
                $errCode++;
                $errMessage = "Super Administrator tidak dapat di hapus.";
            }
        }
        if ($errCode == 0) {
            $checkValid = $this->M_grup->selectById($id);
            if ($checkValid == null) {
                $errCode++;
                $errMessage = self::__title . " tidak valid.";
            }
        }
        if ($errCode == 0) {
            if ($checkValid->can_delete == 0) {
                $errCode++;
                $errMessage = self::__title . " tidak dapat dihapus.";
            }
        }
        if ($errCode == 0) {
            try {
            $this->db->delete(self::__tableName, array('grup_id' => $id));
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
}

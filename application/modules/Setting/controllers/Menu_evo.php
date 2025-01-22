<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Menu_evo extends AUTH_Controller
{
    const __tableName = 'tbl_menu';
    const __tableId = 'id_menu';
    const __folder = 'v_menu_evo/';
    const __kode_menu = 'menu-master';
    const __title = 'Menu';

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_menu_evo');
        $this->load->model('M_sidebar');
    }

    public function index()
    {
        $data['userdata'] = $this->userdata;
        $data['page'] = "menu";
        $data['judul'] = "menu";
        $data['dataMenu'] = $this->M_menu_evo->selekDataMenu();
        parent::loadkonten(self::__folder . 'home', $data);
    }

    public function menu_ajax()
    {
        $cari = $this->input->get('q');
        $data_menu = $this->M_menu_evo->cari_ajax($cari);
        echo json_encode($data_menu);
    }

    public function icon()
    {
        $data['userdata'] = $this->userdata;
        $data['page'] = "icon";
        $data['judul'] = "icon";
        parent::loadkonten('v_menu_evo/icon', $data);
    }

    public function prosesTambah()
    {
        $username = $this->session->userdata('nama');
        $date = date('Y-m-d H:i:s');
        $date2 = date('Y-m-d');

        $errCode = 0;
        $errMessage = "";

        $namaMenu = trim($this->input->post("nama_menu"));
        $icon = trim($this->input->post("icon"));
        $link = trim($this->input->post("link"));
        $kodeMenu = trim($this->input->post("kode_menu"));
        $parent = trim($this->input->post("parent"));
        $urutan = trim($this->input->post("urutan"));
        $menuFile = $this->input->post("menu_file");

        $this->db->trans_begin();
        if ($errCode == 0) {
            $access = $this->M_sidebar->access('add', self::__kode_menu);
            if ($access->menuview == 0) {
                $errCode++;
                $errMessage = "You don't have access.";
            }
        }
        if ($errCode == 0) {
            if (strlen($namaMenu) == 0) {
                $errCode++;
                $errMessage = "Nama Menu wajib di isi.";
            }
        }
        if ($errCode == 0) {
            $checkValid = $this->M_menu_evo->selectByExist(array('nama_menu' => $namaMenu));
            if ($checkValid != null) {
                $errCode++;
                $errMessage = "Nama Menu sudah digunakan.";
            }
        }
        if ($errCode == 0) {
            if (strlen($icon) == 0) {
                $errCode++;
                $errMessage = "Icon Menu wajib di isi.";
            }
        }
        if ($errCode == 0) {
            if (strlen($link) == 0) {
                $errCode++;
                $errMessage = "Link Menu wajib di isi.";
            }
        }
        if ($errCode == 0) {
            $checkValid = $this->M_menu_evo->selectByExist(array('link' => $link));
            if ($checkValid != null) {
                $errCode++;
                $errMessage = "Link Menu sudah digunakan.";
            }
        }
        if ($errCode == 0) {
            if (strlen($kodeMenu) == 0) {
                $errCode++;
                $errMessage = "Kode Menu wajib di isi.";
            }
        }
        if ($errCode == 0) {
            $checkValid = $this->M_menu_evo->selectByExist(array('kode_menu' => $kodeMenu));
            if ($checkValid != null) {
                $errCode++;
                $errMessage = "Kode Menu sudah digunakan.";
            }
        }
        if ($errCode == 0) {
            if (strlen($parent) == 0) {
                $errCode++;
                $errMessage = "Jenis Menu wajib di isi.";
            }
        }
        if ($errCode == 0) {
            if (strlen($urutan) == 0) {
                $errCode++;
                $errMessage = "Urutan Menu wajib di isi.";
            }
        }
        if ($errCode == 0) {
            if (count($menuFile) == 0) {
                $errCode++;
                $errMessage = "Menu Available wajib di isi.";
            }
        }
        if ($errCode == 0) {
            try {
                $data = array(
                    'nama_menu' => $namaMenu,
                    'icon' => $icon,
                    'link' => $link,
                    'kode_menu' => $kodeMenu,
                    'parent' => $parent,
                    'urutan' => $urutan,
                    'menu_file' => implode(",", $menuFile),
                    'created_by' => $username,
                    'last_created_date' => $date,
                    'last_update_by' => $username,
                    'last_update_date' => $date
                );
                $this->db->insert(self::__tableName, $data);
                $insertId = $this->db->insert_id();

                $out['menu'] = '<li class="dd-item dd3-item" data-id="' . $insertId . '" >
	                    <div class="dd-handle dd3-handle"></div>
	                    <div class="dd3-content"><i class="' . $icon . '"></i><span id="label_show' . $insertId . '">' . $namaMenu . '</span>
	                        <span class="span-right"><span id="link_show' . $insertId . '">' . $link . '</span> &nbsp;&nbsp; 
	                        	<a class="edit-button" id="' . $insertId . '" label="' . $namaMenu . '" link="' . $link . '" ><i class="fa fa-pencil"></i></a>
                           		<a class="del-button" id="' . $insertId . '"><i class="fa fa-trash"></i></a>
	                        </span> 
	                    </div>';
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
        //*ini harus ada boss */
        $access = $this->M_sidebar->access('edit', self::__kode_menu);
        $data['userdata'] = $this->userdata;
        $data['page'] = self::__title;
        $data['judul'] = "Ubah " . self::__title;
        if ($access->menuview == 0) {
            parent::loadkonten('Dashboard/layouts/no_akses', $data);
        } else {
            $dataMenu = $this->M_menu_evo->selectById($id);
            if ($dataMenu != null) {
                $data['dataMenu'] = $this->M_menu_evo->selectById($id);
                $data['dataMenu2'] = $this->M_menu_evo->pilih_menu();
                $data['dataMenu3'] = $this->M_menu_evo->selekDataMenu();
                $data['menuName'] = self::__kode_menu;
                parent::loadkonten('' . self::__folder . 'update', $data);
            } else {
                echo "<script>alert('" . self::__title . " tidak tersedia.'); window.location = '" . base_url(self::__kode_menu) . "';</script>";
            }
        }
    }

    public function prosesUpdate($id)
    {
        $username = $this->session->userdata('nama');
        $date = date('Y-m-d H:i:s');
        $date2 = date('Y-m-d');

        $errCode = 0;
        $errMessage = "";

        $namaMenu = trim($this->input->post("nama_menu"));
        $icon = trim($this->input->post("icon"));
        $link = trim($this->input->post("link"));
        $kodeMenu = trim($this->input->post("kode_menu"));
        $parent = trim($this->input->post("parent"));
        $urutan = trim($this->input->post("urutan"));
        $menuFile = $this->input->post("menu_file");

        $this->db->trans_begin();
        if ($errCode == 0) {
            $access = $this->M_sidebar->access('add', self::__kode_menu);
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
            $checkValid = $this->M_menu_evo->selectById($id);
            if ($checkValid == null) {
                $errCode++;
                $errMessage = self::__title . " tidak valid.";
            }
        }
        if ($errCode == 0) {
            if (strlen($namaMenu) == 0) {
                $errCode++;
                $errMessage = "Nama Menu wajib di isi.";
            }
        }
        if ($errCode == 0) {
            $checkValid = $this->M_menu_evo->selectByExist(array('nama_menu' => $namaMenu), $id);
            if ($checkValid != null) {
                $errCode++;
                $errMessage = "Nama Menu sudah digunakan.";
            }
        }
        if ($errCode == 0) {
            if (strlen($icon) == 0) {
                $errCode++;
                $errMessage = "Icon Menu wajib di isi.";
            }
        }
        if ($errCode == 0) {
            if (strlen($link) == 0) {
                $errCode++;
                $errMessage = "Link Menu wajib di isi.";
            }
        }
        if ($errCode == 0) {
            $checkValid = $this->M_menu_evo->selectByExist(array('link' => $link), $id);
            if ($checkValid != null) {
                $errCode++;
                $errMessage = "Link Menu sudah digunakan.";
            }
        }
        if ($errCode == 0) {
            if (strlen($kodeMenu) == 0) {
                $errCode++;
                $errMessage = "Kode Menu wajib di isi.";
            }
        }
        if ($errCode == 0) {
            $checkValid = $this->M_menu_evo->selectByExist(array('kode_menu' => $kodeMenu), $id);
            if ($checkValid != null) {
                $errCode++;
                $errMessage = "Kode Menu sudah digunakan.";
            }
        }
        if ($errCode == 0) {
            if (strlen($parent) == 0) {
                $errCode++;
                $errMessage = "Jenis Menu wajib di isi.";
            }
        }
        if ($errCode == 0) {
            if (strlen($urutan) == 0) {
                $errCode++;
                $errMessage = "Urutan Menu wajib di isi.";
            }
        }
        if ($errCode == 0) {
            if (count($menuFile) == 0) {
                $errCode++;
                $errMessage = "Menu Available wajib di isi.";
            }
        }
        if ($errCode == 0) {
            try {
                $data = array(
                    'nama_menu' => $namaMenu,
                    'icon' => $icon,
                    'link' => $link,
                    'kode_menu' => $kodeMenu,
                    'parent' => $parent,
                    'urutan' => $urutan,
                    'menu_file' => implode(",", $menuFile),
                    'last_update_by' => $username,
                    'last_update_date' => $date
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
            $out = array('status' => true, 'pesan' => ' Data berhasil di update');
        } else {
            $this->db->trans_rollback();
            $out = array('status' => false, 'pesan' => $errMessage);
        }

        echo json_encode($out);
    }

    function prosesDelete()
    {
        $date = date('Y-m-d H:i:s');
        $errCode = 0;
        $errMessage = "";

        $id = $_POST['id'];

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
            $checkValid = $this->M_menu_evo->selectById($id);
            if ($checkValid == null) {
                $errCode++;
                $errMessage = self::__title . " tidak valid.";
            }
        }
        if ($errCode == 0) {
            try {
                $result = $this->recursiveDelete($_POST['id']);
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

    public function saveSort()
    {
        $data = json_decode($_POST['data']);
        $readbleArray = $this->parseJsonArray($data);
        $i = 0;
        foreach ($readbleArray as $row) {
            $i++;
            $data2 = array(
                'parent' => $row['parentID'],
                'urutan' => $i
            );
            $result = $this->db->update('tbl_menu', $data2, array('id_menu' => $row['id_menu']));

            if ($result > 0) {

                $out = array('status' => true, 'pesan' => ' Data has been saved');
            } else {

                $out = array('status' => false, 'pesan' => 'Data has been failed save!');
            }
        }
        echo json_encode($out);
    }

    function parseJsonArray($jsonArray, $parentID = 0)
    {
        $return = array();
        foreach ($jsonArray as $subArray) {
            $returnSubSubArray = array();
            if (isset($subArray->children)) {
                $returnSubSubArray = $this->parseJsonArray($subArray->children, $subArray->id);
            }

            $return[] = array('id_menu' => $subArray->id, 'parentID' => $parentID);
            $return = array_merge($return, $returnSubSubArray);
        }
        return $return;
    }

    function recursiveDelete($id)
    {
        $query = $this->M_menu_evo->selectParent($id);
        if ($query > 0) {
            foreach ($query as $current) {
                $this->recursiveDelete($current['id_menu']);
            }
        }
        $this->db->delete(self::__tableName, array(self::__tableId => $id));
    }
}

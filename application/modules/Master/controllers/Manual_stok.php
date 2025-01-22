<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Manual_stok extends AUTH_Controller
{

    const __tableName = 'tbl_manual_stok';
    const __tableId = 'id';
    const __folder    = 'v_manual_stok/';
    const __kode_menu = 'kode-manual-stok';
    const __title     = 'Manual Stok';
    const __model     = 'M_manual_stok';

    public function __construct()
    {
        parent::__construct();
        $this->load->model(self::__model);
        $this->load->model('M_sidebar');
    }

    public function loadkonten($page, $data)
    {

        $data['userdata']     = $this->userdata;
        $ajax = ($this->input->post('status_link') == "ajax" ? true : false);
        if (!$ajax) {
            $this->load->view('Dashboard/layouts/header', $data);
        }
        $this->load->view($page, $data);
        if (!$ajax) $this->load->view('Dashboard/layouts/footer', $data);
    }

    public function index()
    {
        $accessAdd = $this->M_sidebar->access('add', self::__kode_menu);
        $data['accessAdd']  = $accessAdd->menuview;
        $data['userdata']     = $this->session->userdata('nama');
        $data['page']         = self::__title;
        $data['judul']         = self::__title;

        $this->loadkonten('' . self::__folder . 'home', $data);
    }

    public function ajax_list()
    {
        $accessDel = $this->M_sidebar->access('del', self::__kode_menu);
        $list = $this->M_manual_stok->getData();
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $brand) {

            $idProduk = $brand->id_barang;
            $resProduk = $this->M_manual_stok->selectByIdProduk($idProduk);
            $namaProduk = $resProduk->nama;
            $kodeProduk = $resProduk->kode_barang;

            if ($brand->tipe == 'kurang') {
                $tipe = 'kurang stok';
            } else {
                $tipe = 'tambah stok';
            }

            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $tipe;
            $row[] = $kodeProduk;
            $row[] = $namaProduk;
            $row[] = $brand->catatan;
            $row[] = $brand->qty;
            $row[] = date('d-m-Y H:i', strtotime($brand->created_date));
            $buttonDel = '';
            if ($accessDel->menuview > 0) {
                $buttonDel = '<button class="btn btn-icon btn-danger hapus-manual-stok" data-id=' . "'" . $brand->id . "'" . '><span tooltip="Delete Data"><i class="fa fa-trash"></i></button>';
            }

            $row[]  = $buttonDel;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function Add()
    {

        /*ini harus ada boss */
        $data['userdata'] = $this->userdata;
        $access = $this->M_sidebar->access('add', self::__kode_menu);
        if ($access->menuview == 0) {
            $data['page']         = self::__title;
            $data['judul']         = self::__title;
            $this->loadkonten('Dashboard/layouts/no_akses', $data);
        }

        /*ini harus ada boss */ else {
            $data['page']      = self::__title;
            $data['judul']     = self::__title;
            $data['produk']    = $this->M_manual_stok->selectProduk();

            $this->loadkonten('' . self::__folder . 'tambah', $data);
        }
    }

    public function prosesTambah()
    {
        $errCode = 0;
        $errMessage = "";

        $idBarang = trim($this->input->post("id_barang"));
        $qty = trim($this->input->post("qty"));
        $catatan = trim($this->input->post("catatan"));
        $tipe = trim($this->input->post("tipe"));

        $resProduk = $this->M_manual_stok->selectByIdProduk($idBarang);
        $namaProduk = $resProduk->nama;

        $this->db->trans_begin();

        if ($errCode == 0) {
            if (strlen($qty) == 0) {
                $errCode++;
                $errMessage = "Qty wajib di isi.";
            }
        }

        if ($errCode == 0) {
            if (strlen($idBarang) == 0) {
                $errCode++;
                $errMessage = "Id Barang wajib di isi.";
            }
        }

        if ($errCode == 0) {
            $access = $this->M_sidebar->access('add', self::__kode_menu);
            if ($access->menuview == 0) {
                $errCode++;
                $errMessage = "You don't have access.";
            }
        }

        if ($errCode == 0) {
            try {

                $data = array(
                    'id_barang' => $idBarang,
                    'tipe' => $tipe,
                    'qty' => $qty,
                    'catatan' => $catatan,
                );
                $this->db->insert(self::__tableName, $data);

                if ($tipe == 'tambah') {
                    $stok  = $qty;
                    $id    = $idBarang;
                    $this->M_manual_stok->updatestockAdd($stok, $id, 'tbl_product');

                    $idToko =  $this->session->userdata('id_toko');
                    $data2 = array(
                        'id_brg'      => $idBarang,
                        'id_toko'     => $idToko,
                        'nama_brg'    => $namaProduk,
                        'beli'        => $qty,
                        'tanggal'     => date('Y-m-d')
                    );

                    $this->db->insert('tbl_so', $data2);
                } else {
                    $stok  = $qty;
                    $id    = $idBarang;
                    $this->M_manual_stok->updatestockDelete($stok, $id, 'tbl_product');

                    $idToko =  $this->session->userdata('id_toko');
                    $data2 = array(
                        'id_brg'      => $idBarang,
                        'id_toko'     => $idToko,
                        'nama_brg'    => $namaProduk,
                        'jual'        => $qty,
                        'tanggal'     => date('Y-m-d')
                    );

                    $this->db->insert('tbl_so', $data2);
                }
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


    public function hapus()
    {

        $errCode = 0;
        $errMessage = "";
        $token = $this->input->post('id');

        $this->db->trans_begin();

        if ($errCode == 0) {
            $access = $this->M_sidebar->access('del', self::__kode_menu);
            if ($access->menuview == 0) {
                $errCode++;
                $errMessage = "You don't have access.";
            }
        }

        if ($errCode == 0) {
            if (strlen($token) == 0) {
                $errCode++;
                $errMessage = "ID does not exist.";
            }
        }

        if ($errCode == 0) {
            $checkValid = $this->M_manual_stok->selectById($token);
            if ($checkValid == null) {
                $errCode++;
                $errMessage = self::__title . " tidak valid.";
            }
        }

        if ($errCode == 0) {
            try {
                $this->db->delete(self::__tableName, array(self::__tableId => $token));
            } catch (Exception $ex) {
                $errCode++;
                $errMessage = $ex->getMessage();
            }
        }

        if ($errCode == 0) {
            if ($this->db->trans_status() === FALSE) {
                $errCode++;
                $errMessage = "Error failed delete.";
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

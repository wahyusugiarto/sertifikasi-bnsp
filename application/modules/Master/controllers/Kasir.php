<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kasir extends AUTH_Controller
{

    const __tableName = 'tbl_penjualan';
    const __tableId   = 'no';
    const __folder    = 'v_penjualan/';
    const __kode_menu = 'kode-kasir';
    const __title     = 'Kasir';
    const __model     = 'M_penjualan';

    public function __construct()
    {
        parent::__construct();
        $this->load->model(self::__model);
        $this->load->model('M_generate_code');
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
        /*ini harus ada boss */
        $data['userdata'] = $this->userdata;
        $access = $this->M_sidebar->access('edit', self::__kode_menu);
        if ($access->menuview == 0) {
            $data['page']         = 'Penjualan';
            $data['judul']        = 'Penjualan';
            $this->loadkonten('Dashboard/layouts/no_akses', $data);
        }
        /*ini harus ada boss */ else {
            $data['page']         = 'Kasir';
            $data['judul']        = 'Kasir';
            $this->loadkonten('' . self::__folder . 'add_invoice', $data);
        }
    }

    function ambilData()
    {
        $modul = $this->input->post('modul');

        if ($modul == "nama") {
            $id = $this->input->post('id_pelanggan');
            echo $this->M_penjualan->selectNama($id);
        } elseif ($modul == "telp") {
            $id = $this->input->post('id_pelanggan');
            echo $this->M_penjualan->selectTelp($id);
        }
    }

    public function ajaxData()
    {
        $accessEdit = $this->M_sidebar->access('edit', self::__kode_menu);
        $list = $this->M_penjualan->getData(1);
        $data = array();
        $no = $_POST['start'];

        foreach ($list as $brand) {
            $no++;
            $row = array();
            $row[] = $no;
            $row[] = $brand->kode_penjualan;
            $row[] = date_indo(date('d-m-Y H:i', strtotime($brand->tanggal)));
            $row[] = $brand->status;
            $row[] = $brand->status_print;

            //add html for action
            $CetakInvoice = '';
            if ($accessEdit->menuview > 0) {
                $CetakInvoice = anchor('preview-invoice_kasir/' . $brand->kode_penjualan, ' <span tooltip="Preview Invoice"><span class="fa fa-print"></span> ', ' class="btn btn-icon btn-success klik ajaxify" ');
            }

            $row[] = $CetakInvoice;
            $data[] = $row;
        }

        $output = array(
            "draw" => $_POST['draw'],
            "data" => $data,
        );
        //output to json format
        echo json_encode($output);
    }


    public function searchBrg()
    {
        $data = array(
            'barang' => $this->M_penjualan->SearchProduct()->result(),
        );
        $this->load->view('v_penjualan/v_cr_brg_jual', $data);
    }

    public function del_cart()
    {
        $errCode = 0;
        $errMessage = "";
        $this->db->trans_begin();

        $token = $this->input->post('no');

        if ($errCode == 0) {
            if (strlen($token) == 0) {
                $errCode++;
                $errMessage = "Token nomor kosong .";
            }
        }

        if ($errCode == 0) {
            try {
                $this->db->delete('tbl_temp_penjualan', array('no' => $token));
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

    public function view_jual()
    {
        $where = array(
            'sess_id' => session_id()
        );
        $data = array(
            'customer'   => $this->M_penjualan->selectCustomer(),
            'cart'       => $this->M_penjualan->ViewCart($where, 'tbl_temp_penjualan')->result(),
            'total'      => $this->get_total(),
        );
        $this->load->view('v_penjualan/v_jual', $data);
    }

    public function add_cart()
    {
        $where = array(
            'id'         => $this->input->post('kd_brg', TRUE),
            'sess_id'    => session_id()
        );
        $cek = $this->M_penjualan->ViewCart($where, 'tbl_temp_penjualan')->num_rows();
        $data = array(
            'id'         => $this->input->post('kd_brg', TRUE),
            'qty'        => $this->input->post('qty', TRUE),
            'gambar'     => $this->input->post('gambar', TRUE),
            'price'      => str_replace(".", "", $this->input->post('harga', TRUE)),
            'price_buy'  => str_replace(".", "", $this->input->post('harga_beli', TRUE)),
            'name'       => $this->input->post('nama', TRUE),
            'subtotal'   => $this->input->post('qty', TRUE) * str_replace(".", "", $this->input->post('harga', TRUE)),
            'subtotal2'  => $this->input->post('qty', TRUE) * str_replace(".", "", $this->input->post('harga_beli', TRUE)),
            'sess_id'    => session_id(),
        );
        //jika kosong 
        if ($cek == 0) {
            $this->db->insert('tbl_temp_penjualan', $data);
        } else { // jika ada 
            $this->db->set('qty', 'qty+' . $data['qty'], FALSE);
            $this->db->set('subtotal', 'price*qty', FALSE);
            $this->db->where('id', $data['id']);
        }
    }

    public function SimpanPenjualan()
    {

        $errCode = 0;
        $errMessage = "";
        $this->db->trans_begin();

        $username   = $this->session->userdata('nama');
        $tampil     = $this->cart->contents();
        $code       = $this->M_generate_code->getNextSale();
        $nama       = $this->input->post('nama');
        $idToko     = $this->session->userdata('id_toko');

        $where = array('sess_id'    => session_id());
        $cekTmpData = $this->M_penjualan->CheckSell($where, 'tbl_temp_penjualan')->num_rows();
        $buyCheckTmp = $this->M_penjualan->ViewCart($where, 'tbl_temp_penjualan')->result();

        if ($errCode == 0) {
            if (empty($buyCheckTmp)) {
                $errCode++;
                $errMessage = "Maaf anda harus input barang dahulu !";
            }
        }

        if ($errCode == 0) {
            if ($cekTmpData < 0) {
                $errCode++;
                $errMessage = "Maaf anda harus input barang dahulu !";
            }
        }

        if ($errCode == 0) {
            if (strlen($idToko) == 0) {
                $errCode++;
                $errMessage = "Id toko kosong .";
            }
        }

        if ($errCode == 0) {

            //SAVE DETAIL PENJUALAN
            try {
                foreach ($buyCheckTmp  as $b) {
                    $keterangan = 'penjualan barang kepada customer ' . $nama . '</b> Dengan Nama Barang <b>' . $b->name . ' sejumlah <b>' . $b->qty . '</b> Pcs';
                    $dataHistory[] = array(
                        'kode_transaksi'  => $code,
                        'nama_user'       => $username,
                        'aktivitas'       => 'Penjualan',
                        'id_toko'         => $idToko,
                        'keterangan'      => $keterangan,
                    );
                }
                $this->db->insert_batch('tbl_log_transaksi', $dataHistory);

                foreach ($buyCheckTmp as $b) {
                    $dataSpk[] = array(
                        'kode_penjualan' => $code,
                        'id'             => $b->id,
                        'name'           => $b->name,
                        'qty'            => $b->qty,
                        'price'          => $b->price,
                        'price_buy'      => $b->price_buy,
                        'subtotal'       => $b->subtotal,
                        'subtotal2'      => $b->subtotal2,
                    );
                }

                $this->db->insert_batch('tbl_detail_penjualan', $dataSpk);

                //SAVE TABLE TRANSAKSI PENJUALAN
                $data = array(
                    'kode_penjualan'  => $code,
                    'id_toko'         => $idToko,
                    'id_user'         => $this->input->post('id_user'),
                    'nama'            => $this->input->post('nama'),
                    'telp'            => $this->input->post('telp'),
                    'admin'           => $username,
                    'total'           => str_replace('.', '', $this->input->post('total', TRUE)),
                    'status_print'    => 'Belum Print',
                    'status'          => 'Lunas',
                );
                $this->db->insert('tbl_penjualan', $data);
                $this->add_so($where);
                $this->updatestok();

                //DELETE CART TEMPORARY
                foreach ($tampil as $items) {
                    $cart[] = array(
                        'rowid' => $items['rowid'],
                        'qty'     => 0
                    );
                }
                $this->cart->update($cart);
                $this->DeleteTmpPenjualan();
            } catch (Exception $ex) {
                $errCode++;
                $errMessage = $ex->getMessage();
            }
        }

        if ($errCode == 0) {
            if ($this->db->trans_status() === FALSE) {
                $errCode++;
                $errMessage = "Error failed save.";
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

    public function DeleteTmpPenjualan()
    {
        $where = array('sess_id' => session_id());
        $this->M_penjualan->delcart($where, 'tbl_temp_penjualan');
    }

    public function add_so($where)
    {
        //INPUT STOK MASUK 
        $idToko =  $this->session->userdata('id_toko');
        $beli     = $this->M_penjualan->ViewCart($where, 'tbl_temp_penjualan')->result();
        foreach ($beli as $b) {
            $data[] = array(
                'id_brg'      => $b->id,
                'id_toko'     => $idToko,
                'nama_brg'    => $b->name,
                'jual'        => $b->qty,
                'tanggal'     => date('Y-m-d')
            );
        }

        $this->db->insert_batch('tbl_so', $data);
    }

    public function updatestok()
    {
        $where = array(
            'sess_id' => session_id()
        );
        $tampil = $this->M_penjualan->ViewCart($where, 'tbl_temp_penjualan')->result();

        foreach ($tampil as $t) {
            $stok     = $t->qty;
            $id       = $t->id;
            $this->M_penjualan->updatestock($stok, $id, 'tbl_product');
        }
    }

    public function get_total()
    {
        $this->db->select_sum('subtotal');
        $this->db->from('tbl_temp_penjualan');
        $this->db->where('sess_id', session_id());
        $query = $this->db->get();
        return $query->row()->subtotal;
    }

    public function Preview($id)
    {
        /*ini harus ada boss */
        $data['userdata'] = $this->userdata;
        $access = $this->M_sidebar->access('edit', self::__kode_menu);
        if ($access->menuview == 0) {
            $data['page']         = self::__title;
            $data['judul']         = self::__title;
            $this->loadkonten('Dashboard/layouts/no_akses', $data);
        }
        /*ini harus ada boss */ else {

            $data['dataslider'] = $this->M_penjualan->selectByKode($id);
            $data['detail']     = $this->M_penjualan->selectDetailCart($id);
            $data['page']         = self::__title;
            $data['judul']         = self::__title;
            $this->loadkonten('' . self::__folder . 'preview_invoice_kasir', $data);
        }
    }
}

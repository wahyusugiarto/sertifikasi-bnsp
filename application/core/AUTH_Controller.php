<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class AUTH_Controller extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('M_admin');
        $this->userdata = $this->session->userdata('userdata');
        $this->session->set_flashdata('segment', explode('/', $this->uri->uri_string()));

        if ($this->session->userdata('status') == '') {
            redirect('login');
        }
    }

    public function loadkonten($page, $data)
    {
        $data['userdata'] = $this->userdata;
        $ajax = ($this->input->post('status_link') == "ajax" ? true : false);
        if (!$ajax) {
            $this->load->view('Dashboard/layouts/header', $data);
        }
        $this->load->view($page, $data);
        if (!$ajax)
            $this->load->view('Dashboard/layouts/footer', $data);
    }

    public function updateProfil()
    {
        if ($this->userdata != '') {
            $data = $this->M_admin->select($this->userdata->id);
            $this->session->set_userdata('userdata', $data);
            $this->userdata = $this->session->userdata('userdata');
        }
    }

    public static function rotate($source_array, $keep_keys = TRUE)
    {
        $new_array = array();
        foreach ($source_array as $key => $value) {
            $value = ($keep_keys === TRUE) ? $value : array_values($value);
            foreach ($value as $k => $v) {
                $new_array[$k][$key] = $v;
            }
        }

        return $new_array;
    }

    public static function loadCreatedUpdatedContent($arrCreatedUpdated = array())
    {
        $content = "";
        $datetime = $arrCreatedUpdated['datetime'];
        $by = $arrCreatedUpdated['by'];
        if (strlen($datetime) > 0 && strlen($by) > 0) {
            if (strlen($datetime) > 0) {
                $datetime = date('d-m-Y H:i:s', strtotime($datetime));
            }

            $content = "<table>
                            <tr>
                                <td style='width: 45px; vertical-align: top;'><b>Waktu</b></td>
                                <td style='vertical-align: top;'>:</td>
                                <td>" . $datetime . "</td>
                            </tr>
                            <tr>
                                <td><b>Oleh</b></td>
                                <td>:</td>
                                <td>" . $arrCreatedUpdated['by'] . "</td>
                            </tr>
                        </table>";
        }

        return $content;
    }

    public static function createFolder($folderName = "")
    {
        if (strlen($folderName) > 0) {
            $path = "./upload/";
            if (!is_dir($path)) {
                mkdir($path);
            }
            $path = $path . "/" . $folderName . "/";
            if (!is_dir($path)) {
                mkdir($path);
            }
        }

        return $folderName;
    }

    //Fungsi Konversi nilai angka menjadi nilai huruf
    public function penyebut($nilai)
    {
        $nilai = abs($nilai);
        $huruf = array("", "Satu", "Dua", "Tiga", "Empat", "Lima", "Enam", "Tujuh", "Delapan", "Sembilan", "Sepuluh", "Sebelas");
        $temp = "";
        if ($nilai < 12) {
            $temp = " " . $huruf[$nilai];
        } else if ($nilai < 20) {
            $temp = $this->penyebut($nilai - 10) . " Belas";
        } else if ($nilai < 100) {
            $temp = $this->penyebut($nilai / 10) . " Puluh" . $this->penyebut($nilai % 10);
        } else if ($nilai < 200) {
            $temp = " seratus" . $this->penyebut($nilai - 100);
        } else if ($nilai < 1000) {
            $temp = $this->penyebut($nilai / 100) . " Ratus" . $this->penyebut($nilai % 100);
        } else if ($nilai < 2000) {
            $temp = " seribu" . $this->penyebut($nilai - 1000);
        } else if ($nilai < 1000000) {
            $temp = $this->penyebut($nilai / 1000) . " Ribu" . $this->penyebut($nilai % 1000);
        } else if ($nilai < 1000000000) {
            $temp = $this->penyebut($nilai / 1000000) . " Juta" . $this->penyebut($nilai % 1000000);
        } else if ($nilai < 1000000000000) {
            $temp = $this->penyebut($nilai / 1000000000) . " Milyar" . $this->penyebut(fmod($nilai, 1000000000));
        } else if ($nilai < 1000000000000000) {
            $temp = $this->penyebut($nilai / 1000000000000) . " Trilyun" . $this->penyebut(fmod($nilai, 1000000000000));
        }
        return $temp;
    }

    public function terbilang($nilai)
    {
        if ($nilai < 0) {
            $hasil = "minus " . trim($this->penyebut($nilai));
        } else {
            $hasil = trim($this->penyebut($nilai));
        }
        return $hasil;
    }

    //Fungsi ambil tanggal aja
    public function tgl_aja($tgl_a)
    {
        $tanggal = substr($tgl_a, 8, 2);
        return $tanggal;
    }

    //Fungsi Ambil bulan aja
    public function bln_aja($bulan_a)
    {
        $bulan = $this->getBulan(substr($bulan_a, 5, 2));
        return $bulan;
    }

    //Fungsi Ambil tahun aja
    public function thn_aja($thn)
    {
        $tahun = substr($thn, 0, 4);
        return $tahun;
    }

    //Fungsi konversi tanggal bulan dan tahun ke dalam bahasa indonesia
    public function tgl_indo($tgl)
    {
        $tanggal = substr($tgl, 8, 2);
        $bulan = $this->getBulan(substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }

     public function tgl_indo2($tgl)
    {
        $tanggal = substr($tgl, 8, 2);
        $bulan = $this->getBulan2(substr($tgl, 5, 2));
        $tahun = substr($tgl, 0, 4);
        return $tanggal . ' ' . $bulan . ' ' . $tahun;
    }

    //Fungsi konversi nama bulan ke dalam bahasa indonesia
    public function getBulan($bln)
    {
        switch ($bln) {
            case 1:
                return "Januari";
                break;
            case 2:
                return "Februari";
                break;
            case 3:
                return "Maret";
                break;
            case 4:
                return "April";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Juni";
                break;
            case 7:
                return "Juli";
                break;
            case 8:
                return "Agustus";
                break;
            case 9:
                return "September";
                break;
            case 10:
                return "Oktober";
                break;
            case 11:
                return "November";
                break;
            case 12:
                return "Desember";
                break;
        }
    }

   //Fungsi konversi nama bulan ke dalam bahasa indonesia
   public function getBulan2($bln)
   {
        switch ($bln) {
            case 1:
                return "Jan";
                break;
            case 2:
                return "Feb";
                break;
            case 3:
                return "Mar";
                break;
            case 4:
                return "Apr";
                break;
            case 5:
                return "Mei";
                break;
            case 6:
                return "Jun";
                break;
            case 7:
                return "Jul";
                break;
            case 8:
                return "Ags";
                break;
            case 9:
                return "Sep";
                break;
            case 10:
                return "Okt";
                break;
            case 11:
                return "Nov";
                break;
            case 12:
                return "Des";
                break;
        }
    }

    //Fungsi konversi nama hari ke dalam bahasa indonesia
    public function getHari($hari)
    {
        switch ($hari) {
            case "Sunday":
                return "Minggu";
                break;
            case "Monday":
                return "Senin";
                break;
            case "Tuesday":
                return "Selasa";
                break;
            case "Wednesday":
                return "Rabu";
                break;
            case "Thursday":
                return "Kamis";
                break;
            case "Friday":
                return "Jumat";
                break;
            case "Saturday":
                return "Sabtu";
                break;
        }
    }
}

/* End of file MY_Auth.php */
/* Location: ./application/core/MY_Auth.php */
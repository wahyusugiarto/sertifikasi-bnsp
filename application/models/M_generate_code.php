<?php

defined('BASEPATH') OR exit('No direct script access allowed');

/**
 *
 * @author Septian Satrya Nugraha
 * @since  Dec 28, 2019
 * @license Susi Susanti Group
 */
class M_generate_code extends CI_Model {

    public function __construct() {
        parent::__construct();
        $this->load->database();
    }

    public function _getNextCodeFromFormat($keyFormat) {
        $keyCounter = self::_getKeyCounter($keyFormat);
        $result = $keyCounter;
        $counter = self::_getNextCounter($keyCounter);
        preg_match_all("/{([\w]*)}/", $keyFormat, $matches, PREG_SET_ORDER);
        foreach ($matches as $val) {
            $str = $val[1]; //matches str without bracket {}
            $bStr = $val[0]; //matches str with bracket {}
            $lenCounter = strlen($str);
            $padCounter = str_pad($counter, $lenCounter, "0", STR_PAD_LEFT);
            $result = str_replace($bStr, $padCounter, $result);
        }
        return $result;
    }

    public function _getKeyCounter($keyFormat) {
        $result = $keyFormat;
        preg_match_all("/{([\w]*)}/", $keyFormat, $matches, PREG_SET_ORDER);

        foreach ($matches as $val) {
            $str = $val[1]; //matches str without bracket {}
            $bStr = $val[0]; //matches str with bracket {}
            switch ($str) {
                case "yyyy":
                    $result = str_replace("{yyyy}", date('Y'), $result);
                    break;
                case "yy":
                    $result = str_replace("{yy}", date('y'), $result);
                    break;
                case "mm":
                    $result = str_replace("{mm}", date('m'), $result);
                    break;
                case "dd":
                    $result = str_replace("{dd}", date('d'), $result);
                    break;
                case "MM":
                    $result = str_replace("{MM}", cutils::month_romawi(date('m')), $result);
                    break;
            }
        }
        return $result;
    }

    public function _getNextCounter($keyCounter) {
        $nextCounter = 1;
        $isInsert = 1;

        $sql = "select case when counter is null then 1 else counter+1 end as next_counter from sys_counter where `key`= '{$keyCounter}'";
        $r = $this->db->query($sql)->row();

        if ($r != null) {
            $nextCounter = $r->next_counter;
            $isInsert = 0;
        }
        $cmd = "";
        if ($isInsert == 1) {
            $cmd = "insert into sys_counter(`key`,counter,created) values ('{$keyCounter}',1,now());";
        } else {
            $cmd = "update sys_counter set counter = counter+1, updated = now() where `key` = '{$keyCounter}'";
        }
        $this->db->query($cmd);

        return $nextCounter;
    }

    public function getNextBooking() {
        $prefix = "BK-" . date('dmY') . "{nn}";
        return self::_getNextCodeFromFormat($prefix);
    }

    public function getNextSPK() {
        $prefix = "SPK-" . date('dmY') . "{nn}";
        return self::_getNextCodeFromFormat($prefix);
    }

    public function getNextPurchase() {
        $prefix = "PCHS-" . date('dmY') . "{nn}";
        return self::_getNextCodeFromFormat($prefix);
    }

    public function getNextSale() {
        $prefix = "SLE-" . date('dmY') . "{nn}";
        return self::_getNextCodeFromFormat($prefix);
    }

}

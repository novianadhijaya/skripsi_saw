<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Dashboard_model extends CI_Model {

    public function get_total_pengaduan() {
        return $this->db->count_all('tbl_pengaduan');
    }

    public function get_total_lokasi_tpa() {
        return $this->db->count_all('tbl_tps');
    }

    public function get_total_kegiatan() {
        return $this->db->count_all('tbl_kegiatan');
    }

    public function get_total_masyarakat() {
        return $this->db->count_all('tbl_user');
    }

    public function get_all_kegiatan() {
        return $this->db->get('tbl_kegiatan')->result(); // Jadi objek

    }

    public function get_all_tpa() {
        return $this->db->get('tbl_tps')->result_array();
    }
}

<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Daftar_model extends CI_Model {
    public function __construct() {
        parent::__construct();
    }

    public function register_user($data) {
        return $this->db->insert('tbl_user', $data);
    }

}

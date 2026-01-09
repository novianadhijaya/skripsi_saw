<?php
Class Auth extends CI_Controller{
    
    
    
    function index(){
        $this->load->view('auth/login');
    }
    
    function cheklogin(){
        $email      = $this->input->post('email');
        $password   = $this->input->post('password');
        // cek email terlebih dahulu
        $user = $this->db->get_where('tbl_user', array('email' => $email));
        if($user->num_rows() === 0){
            $this->session->set_flashdata('status_login','Harap Isi Email dan Password.');
            redirect('auth');
            return;
        }

        $dataUser = $user->row_array();
        // blokir akun tidak aktif
        if (isset($dataUser['is_aktif']) && strtolower($dataUser['is_aktif']) !== 'y') {
            $this->session->set_flashdata('status_login','Akun Anda tidak aktif, silakan hubungi administrator.');
            redirect('auth');
            return;
        }

        // validasi password
        if ($dataUser['password'] !== md5($password)) {
            $this->session->set_flashdata('status_login','Password salah / Belum di isi.');
            redirect('auth');
            return;
        }

        // retrive user data to session
        $this->session->set_userdata($dataUser);
        redirect('welcome');
    }
    
    function logout(){
        $this->session->sess_destroy();
        $this->session->set_flashdata('status_login','Anda sudah berhasil keluar dari aplikasi');
        redirect('auth');
    }
}

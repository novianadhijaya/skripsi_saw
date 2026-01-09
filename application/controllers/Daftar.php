<?php
Class Daftar extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('Daftar_model');
        $this->load->library(['form_validation', 'upload']);
    }

    function index()
    {
        $this->form_validation->set_rules('full_name', 'Full Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required|valid_email|is_unique[tbl_user.email]');
        $this->form_validation->set_rules('password', 'Password', 'required|min_length[6]');
        $this->form_validation->set_rules('alamat', 'Alamat', 'required');
        $this->form_validation->set_rules('phone', 'phone', 'required');

        if ($this->form_validation->run() == FALSE) {
            $this->load->view('auth/daftar');
        } else {
            // Konfigurasi upload file
            $config['upload_path']   = './assets/foto_profil/';
            $config['allowed_types'] = 'jpg|jpeg|png';
            $config['max_size']      = 10000; // Maksimal 2MB
            $config['file_name']     = time() . '_' . $_FILES['images']['name'];

            $this->upload->initialize($config);

            // Cek apakah file diupload atau tidak
            if (!empty($_FILES['images']['name'])) {
                if ($this->upload->do_upload('images')) {
                    $uploadData = $this->upload->data();
                    $image_name = $uploadData['file_name'];
                } else {
                    $this->session->set_flashdata('error', $this->upload->display_errors());
                    redirect('daftar/');
                }
            } else {
                $image_name = 'default.png'; // Jika tidak upload, pakai default image
            }

            $data = [
                'full_name' => $this->input->post('full_name'),
                'email' => $this->input->post('email'),
                'password' => md5($this->input->post('password')),
                'alamat' => $this->input->post('alamat'),
                'phone' => $this->input->post('phone'),
                'images' => $image_name,
                'id_user_level' => 4,
                'is_aktif' => 'y'
            ];

            if ($this->Daftar_model->register_user($data)) {
                $this->session->set_flashdata('success', 'Registrasi berhasil, silakan login!');
                redirect('daftar/');
            } else {
                $this->session->set_flashdata('error', 'Registrasi gagal, coba lagi!');
                redirect('auth/daftar');
            }
        }
    }
}

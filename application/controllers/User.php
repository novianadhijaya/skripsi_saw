<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class User extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('User_model');
        $this->load->library('form_validation');        
	$this->load->library('datatables');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));

        if ($q <> '') {
            $config['base_url'] = site_url('user') . '?q=' . urlencode($q);
            $config['first_url'] = site_url('user') . '?q=' . urlencode($q);
        } else {
            $config['base_url'] = site_url('user');
            $config['first_url'] = site_url('user');
        }

        $config['per_page'] = 5;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->User_model->total_rows_with_level($q);
        $users = $this->User_model->get_limit_data_with_level($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'users' => $users,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','user/tbl_user_list', $data);
    } 
    
    // public function json() {
    //     header('Content-Type: application/json');
    //     echo $this->User_model->json();
    // }

    public function read($id) 
    {
        $row = $this->User_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_users' => $row->id_users,
		'full_name' => $row->full_name,
		'email' => $row->email,
		'password' => $row->password,
		'images' => $row->images,
		'id_user_level' => $row->id_user_level,
		'is_aktif' => $row->is_aktif,
	    );
            $this->template->load('template','user/tbl_user_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }

    public function create() 
    {
        $karyawanList = $this->db->order_by('nama_karyawan','ASC')->get('karyawan')->result();
        $levelList = $this->db->order_by('nama_level','ASC')->get('tbl_user_level')->result();
        $data = array(
            'button' => 'Create',
            'action' => site_url('user/create_action'),
	    'id_users' => set_value('id_users'),
	    'full_name' => set_value('full_name'),
	    'email' => set_value('email'),
	    'password' => set_value('password'),
	    'images' => set_value('images'),
	    'id_user_level' => set_value('id_user_level'),
	    'is_aktif' => set_value('is_aktif'),
            'karyawan_list' => $karyawanList,
            'level_list' => $levelList,
            'show_password' => true,
	);
        $this->template->load('template','user/tbl_user_form', $data);
    }
    
    public function create_action() 
    {
        if (strtolower($this->input->method()) !== 'post') {
            redirect(site_url('user/create'));
        }

        $this->_rules(false);
        $foto = $this->upload_foto();
        if (!$foto['success'] && $foto['tried']) {
            $this->session->set_flashdata('message', $foto['error']);
            $this->create();
            return;
        }
        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'full_name' => $this->input->post('full_name',TRUE),
		'email' => $this->input->post('email',TRUE),
		'password' => md5($this->input->post('password',TRUE)),
		'images' => $foto['file_name'],
		'id_user_level' => $this->input->post('id_user_level',TRUE),
		'is_aktif' => $this->input->post('is_aktif',TRUE),
	    );

            $this->User_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success');
            redirect(site_url('user'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->User_model->get_by_id($id);
        $karyawanList = $this->db->order_by('nama_karyawan','ASC')->get('karyawan')->result();
        $levelList = $this->db->order_by('nama_level','ASC')->get('tbl_user_level')->result();
        $currentUserId = $this->session->userdata('id_users');
        $isSelf = ($currentUserId && (int)$currentUserId === (int)$id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('user/update_action'),
		'id_users' => set_value('id_users', $row->id_users),
		'full_name' => set_value('full_name', $row->full_name),
		'email' => set_value('email', $row->email),
		'password' => set_value('password', $row->password),
		'images' => set_value('images', $row->images),
		'id_user_level' => set_value('id_user_level', $row->id_user_level),
                'is_aktif' => set_value('is_aktif', $row->is_aktif),
                'karyawan_list' => $karyawanList,
                'level_list' => $levelList,
                'show_password' => true,
                'lock_profile_fields' => $isSelf,
            );
            $this->template->load('template','user/tbl_user_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }
    
    public function update_action() 
    {
        $id = $this->input->post('id_users', TRUE);
        $row = $this->User_model->get_by_id($id);
        if (!$row) {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }

        $currentUserId = $this->session->userdata('id_users');
        $lockProfile = ($currentUserId && (int)$currentUserId === (int)$id);

        // Pastikan field terkunci tidak bisa dimodifikasi dari request
        if ($lockProfile) {
            $_POST['full_name'] = $row->full_name;
            $_POST['email'] = $row->email;
            $_POST['id_user_level'] = $row->id_user_level;
            $_POST['is_aktif'] = $row->is_aktif;
        }

        $this->_rules(true);
        $foto = $this->upload_foto();
        if (!$foto['success'] && $foto['tried']) {
            $this->session->set_flashdata('message', $foto['error']);
            $this->update($this->input->post('id_users', TRUE));
            return;
        }
        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_users', TRUE));
        } else {
            $data = array(
                'full_name' => $lockProfile ? $row->full_name : $this->input->post('full_name',TRUE),
                'email' => $lockProfile ? $row->email : $this->input->post('email',TRUE),
                'id_user_level' => $lockProfile ? $row->id_user_level : $this->input->post('id_user_level',TRUE),
                'is_aktif' => $lockProfile ? $row->is_aktif : $this->input->post('is_aktif',TRUE)
            );

            $passwordInput = $this->input->post('password', TRUE);
            if (!empty($passwordInput)) {
                $data['password'] = md5($passwordInput);
            }

            if($foto['file_name']!=''){
                $data['images'] = $foto['file_name'];
                // ubah foto profil yang aktif
                $this->session->set_userdata('images',$foto['file_name']);
            }

            $this->User_model->update($this->input->post('id_users', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');

            // Jika user mengedit profil dirinya sendiri, kembalikan ke halaman profil
            if ($lockProfile) {
                redirect(site_url('user/profile'));
            }

            redirect(site_url('user'));
        }
    }
    
    
    function upload_foto(){
        $tried = !empty($_FILES['images']['name']);
        if (!$tried) {
            return array('success' => true, 'tried' => false, 'file_name' => '', 'error' => '');
        }

        $origName = $_FILES['images']['name'];
        $config['upload_path']          = './assets/foto_profil';
        $config['allowed_types']        = 'gif|jpg|jpeg|png';
        $config['file_name']            = time().'_'.preg_replace('/\\s+/', '_', $origName);
        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('images')) {
            return array(
                'success' => false,
                'tried'   => true,
                'file_name' => '',
                'error'   => strip_tags($this->upload->display_errors())
            );
        }

        $data = $this->upload->data();
        return array(
            'success' => true,
            'tried'   => true,
            'file_name' => isset($data['file_name']) ? $data['file_name'] : '',
            'error'   => ''
        );
    }
    
    public function delete($id) 
    {
        $row = $this->User_model->get_by_id($id);

        if ($row) {
            $this->User_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('user'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('user'));
        }
    }

    public function profile()
    {
        $userId = $this->session->userdata('id_users');
        if (!$userId) {
            redirect(site_url('auth/login'));
        }

        $row = $this->User_model->get_by_id($userId);
        if (!$row) {
            $this->session->set_flashdata('message', 'Data user tidak ditemukan');
            redirect(site_url('user'));
        }

        $level = $this->db->get_where('tbl_user_level', array('id_user_level' => $row->id_user_level))->row();
        $data = array(
            'user' => $row,
            'level' => $level
        );
        $this->template->load('template', 'user/profile', $data);
    }

    public function _rules($is_update = false) 
    {
        $this->form_validation->set_rules('full_name', 'full name', 'trim|required');

        $emailRules = 'trim|required|valid_email';
        if ($is_update) {
            $id = $this->input->post('id_users', TRUE);
            $this->form_validation->set_rules('email', 'email', $emailRules . '|callback_unique_email[' . $id . ']');
        } else {
            $this->form_validation->set_rules('email', 'email', $emailRules . '|is_unique[tbl_user.email]');
        }

        if ($is_update) {
            $this->form_validation->set_rules('password', 'password', 'trim|callback_validate_password_optional');
        } else {
            $this->form_validation->set_rules('password', 'password', 'trim|required|min_length[6]');
        }

        $this->form_validation->set_rules('id_user_level', 'level user', 'trim|required');
        $this->form_validation->set_rules('is_aktif', 'status aktif', 'trim|required');
        $this->form_validation->set_rules('images', 'foto profile', $is_update ? 'callback_validate_image_optional' : 'callback_validate_image_required');

        $this->form_validation->set_rules('id_users', 'id_users', 'trim');
        $this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function unique_email($email, $id) 
    {
        $id = (int) $id;
        $exists = $this->db->where('email', $email)
                           ->where('id_users !=', $id)
                           ->get('tbl_user')
                           ->num_rows();
        if ($exists > 0) {
            $this->form_validation->set_message('unique_email', 'Email sudah digunakan');
            return false;
        }
        return true;
    }

    public function validate_password_optional($password)
    {
        if ($password === '') {
            return true;
        }
        if (strlen($password) < 6) {
            $this->form_validation->set_message('validate_password_optional', 'Password minimal 6 karakter');
            return false;
        }
        return true;
    }

    public function validate_image_required()
    {
        if (empty($_FILES['images']['name'])) {
            $this->form_validation->set_message('validate_image_required', 'Foto profile wajib diupload');
            return false;
        }
        return true;
    }

    public function validate_image_optional()
    {
        return true;
    }

    

}

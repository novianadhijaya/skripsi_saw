<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Karyawan extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Karyawan_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = site_url('karyawan') . '?q=' . urlencode($q);
            $config['first_url'] = site_url('karyawan') . '?q=' . urlencode($q);
        } else {
            $config['base_url'] = site_url('karyawan');
            $config['first_url'] = site_url('karyawan');
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Karyawan_model->total_rows($q);
        $karyawan = $this->Karyawan_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'karyawan_data' => $karyawan,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','karyawan/karyawan_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Karyawan_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_karyawan' => $row->id_karyawan,
		'nik' => $row->nik,
		'nama_karyawan' => $row->nama_karyawan,
		'alamat' => $row->alamat,
		'departemen' => $row->departemen,
	    );
            $this->template->load('template','karyawan/karyawan_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('karyawan'));
        }
    }

    public function create() 
    {
        $departemenOptions = array(
            'HRD','Keuangan','Operasional','IT','Gudang','Produksi','Marketing','Sales','Logistik','QA/QC'
        );
        $data = array(
            'button' => 'Create',
            'action' => site_url('karyawan/create_action'),
	    'id_karyawan' => set_value('id_karyawan'),
	    'nik' => set_value('nik'),
	    'nama_karyawan' => set_value('nama_karyawan'),
	    'alamat' => set_value('alamat'),
	    'departemen' => set_value('departemen'),
            'departemen_options' => $departemenOptions,
	);
        $this->template->load('template','karyawan/karyawan_form', $data);
    }
    
    public function create_action() 
    {
        $departemenInput = $this->input->post('departemen', TRUE);
        $nikInput = $this->input->post('nik', TRUE);
        if (empty($nikInput)) {
            $nikInput = $this->_generate_nik($departemenInput);
            $_POST['nik'] = $nikInput; // supaya lolos validasi required
        }
        $this->_rules(false);

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'nik' => $nikInput,
		'nama_karyawan' => $this->input->post('nama_karyawan',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'departemen' => $this->input->post('departemen',TRUE),
	    );

            $this->Karyawan_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('karyawan'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Karyawan_model->get_by_id($id);
        $departemenOptions = array(
            'HRD','Keuangan','Operasional','IT','Gudang','Produksi','Marketing','Sales','Logistik','QA/QC'
        );

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('karyawan/update_action'),
		'id_karyawan' => set_value('id_karyawan', $row->id_karyawan),
		'nik' => set_value('nik', $row->nik),
		'nama_karyawan' => set_value('nama_karyawan', $row->nama_karyawan),
		'alamat' => set_value('alamat', $row->alamat),
		'departemen' => set_value('departemen', $row->departemen),
                'departemen_options' => $departemenOptions,
	    );
            $this->template->load('template','karyawan/karyawan_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('karyawan'));
        }
    }
    
    public function update_action() 
    {
        $departemenInput = $this->input->post('departemen', TRUE);
        $nikInput = $this->input->post('nik', TRUE);
        if (empty($nikInput)) {
            $nikInput = $this->_generate_nik($departemenInput);
            $_POST['nik'] = $nikInput;
        }
        $this->_rules(true);

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_karyawan', TRUE));
        } else {
            $data = array(
		'nik' => $nikInput,
		'nama_karyawan' => $this->input->post('nama_karyawan',TRUE),
		'alamat' => $this->input->post('alamat',TRUE),
		'departemen' => $this->input->post('departemen',TRUE),
	    );

            $this->Karyawan_model->update($this->input->post('id_karyawan', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('karyawan'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Karyawan_model->get_by_id($id);

        if ($row) {
            $this->Karyawan_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('karyawan'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('karyawan'));
        }
    }

    public function _rules($is_update = false) 
    {
        $nikRule = 'trim|required';
        if ($is_update) {
            $id = $this->input->post('id_karyawan', TRUE);
            $nikRule .= '|callback_unique_nik['.$id.']';
        } else {
            $nikRule .= '|is_unique[karyawan.nik]';
        }

	$this->form_validation->set_rules('nik', 'nik', $nikRule);
	$this->form_validation->set_rules('nama_karyawan', 'nama karyawan', 'trim|required');
	$this->form_validation->set_rules('alamat', 'alamat', 'trim|required');
	$this->form_validation->set_rules('departemen', 'departemen', 'trim|required');

	$this->form_validation->set_rules('id_karyawan', 'id_karyawan', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function unique_nik($nik, $id)
    {
        $id = (int) $id;
        $exists = $this->db->where('nik', $nik)
                           ->where('id_karyawan !=', $id)
                           ->get('karyawan')
                           ->num_rows();
        if ($exists > 0) {
            $this->form_validation->set_message('unique_nik', 'NIK sudah digunakan');
            return false;
        }
        return true;
    }

    private function _departemen_prefix($departemen)
    {
        $map = array(
            'hrd' => 'HRD',
            'keuangan' => 'KEU',
            'operasional' => 'OPS',
            'it' => 'IT',
            'gudang' => 'GUD',
            'produksi' => 'PRD',
            'marketing' => 'MKT',
            'sales' => 'SLS',
            'logistik' => 'LOG',
            'qa/qc' => 'QAQC',
            'qaqc' => 'QAQC',
        );
        $key = strtolower(trim((string)$departemen));
        return isset($map[$key]) ? $map[$key] : 'GEN';
    }

    private function _generate_nik($departemen)
    {
        $prefix = $this->_departemen_prefix($departemen);
        $this->db->select('nik');
        $this->db->like('nik', $prefix.'-', 'after');
        $this->db->order_by('nik', 'DESC');
        $this->db->limit(1);
        $row = $this->db->get('karyawan')->row();

        $lastNumber = 0;
        if ($row && preg_match('/(\\d+)$/', $row->nik, $m)) {
            $lastNumber = (int) $m[1];
        }

        $nextNumber = $lastNumber + 1;
        return sprintf('%s-%04d', $prefix, $nextNumber);
    }

}

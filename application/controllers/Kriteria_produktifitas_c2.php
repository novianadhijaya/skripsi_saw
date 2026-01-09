<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Kriteria_produktifitas_c2 extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Kriteria_produktifitas_c2_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = urldecode($this->input->get('q', TRUE));
        $start = intval($this->input->get('start'));
        
        if ($q <> '') {
            $config['base_url'] = base_url() . 'kriteria_produktifitas_c2/index.html?q=' . urlencode($q);
            $config['first_url'] = base_url() . 'kriteria_produktifitas_c2/index.html?q=' . urlencode($q);
        } else {
            $config['base_url'] = base_url() . 'kriteria_produktifitas_c2/index.html';
            $config['first_url'] = base_url() . 'kriteria_produktifitas_c2/index.html';
        }

        $config['per_page'] = 10;
        $config['page_query_string'] = TRUE;
        $config['total_rows'] = $this->Kriteria_produktifitas_c2_model->total_rows($q);
        $kriteria_produktifitas_c2 = $this->Kriteria_produktifitas_c2_model->get_limit_data($config['per_page'], $start, $q);
        $config['full_tag_open'] = '<ul class="pagination pagination-sm no-margin pull-right">';
        $config['full_tag_close'] = '</ul>';
        $this->load->library('pagination');
        $this->pagination->initialize($config);

        $data = array(
            'kriteria_produktifitas_c2_data' => $kriteria_produktifitas_c2,
            'q' => $q,
            'pagination' => $this->pagination->create_links(),
            'total_rows' => $config['total_rows'],
            'start' => $start,
        );
        $this->template->load('template','kriteria_produktifitas_c2/kriteria_produktifitas_c2_list', $data);
    }

    public function read($id) 
    {
        $row = $this->Kriteria_produktifitas_c2_model->get_by_id($id);
        if ($row) {
            $data = array(
		'id_kriteria' => $row->id_kriteria,
		'pilihan_kriteria' => $row->pilihan_kriteria,
		'bobot_kriteria' => $row->bobot_kriteria,
	    );
            $this->template->load('template','kriteria_produktifitas_c2/kriteria_produktifitas_c2_read', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kriteria_produktifitas_c2'));
        }
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('kriteria_produktifitas_c2/create_action'),
	    'id_kriteria' => set_value('id_kriteria'),
	    'pilihan_kriteria' => set_value('pilihan_kriteria'),
	    'bobot_kriteria' => set_value('bobot_kriteria'),
	);
        $this->template->load('template','kriteria_produktifitas_c2/kriteria_produktifitas_c2_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'pilihan_kriteria' => $this->input->post('pilihan_kriteria',TRUE),
		'bobot_kriteria' => $this->input->post('bobot_kriteria',TRUE),
	    );

            $this->Kriteria_produktifitas_c2_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('kriteria_produktifitas_c2'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Kriteria_produktifitas_c2_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('kriteria_produktifitas_c2/update_action'),
		'id_kriteria' => set_value('id_kriteria', $row->id_kriteria),
		'pilihan_kriteria' => set_value('pilihan_kriteria', $row->pilihan_kriteria),
		'bobot_kriteria' => set_value('bobot_kriteria', $row->bobot_kriteria),
	    );
            $this->template->load('template','kriteria_produktifitas_c2/kriteria_produktifitas_c2_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kriteria_produktifitas_c2'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_kriteria', TRUE));
        } else {
            $data = array(
		'pilihan_kriteria' => $this->input->post('pilihan_kriteria',TRUE),
		'bobot_kriteria' => $this->input->post('bobot_kriteria',TRUE),
	    );

            $this->Kriteria_produktifitas_c2_model->update($this->input->post('id_kriteria', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('kriteria_produktifitas_c2'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Kriteria_produktifitas_c2_model->get_by_id($id);

        if ($row) {
            $this->Kriteria_produktifitas_c2_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('kriteria_produktifitas_c2'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('kriteria_produktifitas_c2'));
        }
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('pilihan_kriteria', 'pilihan kriteria', 'trim|required');
	$this->form_validation->set_rules('bobot_kriteria', 'bobot kriteria', 'trim|required|numeric');

	$this->form_validation->set_rules('id_kriteria', 'id_kriteria', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}


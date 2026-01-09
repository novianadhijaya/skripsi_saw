<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Data_penilaian extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Data_penilaian_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $q = trim($this->input->get('q', TRUE));
        $data['record'] = $this->Data_penilaian_model->tampil_data($q);
        $data['q'] = $q;
        
        $this->template->load('template','data_penilaian/nilai_list', $data);
    }
   

    public function create() 
    {
        $prefill_karyawan = $this->input->get('id_karyawan', TRUE);
        if (!empty($prefill_karyawan)) {
            $existing = $this->Data_penilaian_model->get_by_karyawan($prefill_karyawan);
            if ($existing) {
                $this->session->set_flashdata('message', 'Nilai untuk karyawan ini sudah ada, silakan update data.');
                redirect(site_url('data_penilaian/update/'.$existing->id_nilai));
                return;
            }
        }
        $kriteria = $this->_get_kriteria_lists();

        $data = array(
            'button' => 'Create',
            'action' => site_url('data_penilaian/create_action'),
	    'id_nilai' => set_value('id_nilai'),
	    'id_karyawan' => set_value('id_karyawan', $prefill_karyawan),
	    'C1' => set_value('C1'),
	    'C2' => set_value('C2'),
	    'C3' => set_value('C3'),
	    'C4' => set_value('C4'),
            'karyawan_list' => $this->db->order_by('nik','ASC')->get('karyawan')->result(),
            'list_c1' => $kriteria['c1'],
            'list_c2' => $kriteria['c2'],
            'list_c3' => $kriteria['c3'],
            'list_c4' => $kriteria['c4'],
	);
        $this->template->load('template','data_penilaian/nilai_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules(false);

        if ($this->form_validation->run() == FALSE) {
            $this->create();
        } else {
            $data = array(
		'id_karyawan' => $this->input->post('id_karyawan',TRUE),
		'C1' => $this->input->post('C1',TRUE),
		'C2' => $this->input->post('C2',TRUE),
		'C3' => $this->input->post('C3',TRUE),
		'C4' => $this->input->post('C4',TRUE),
	    );

            $this->Data_penilaian_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('data_penilaian'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Data_penilaian_model->get_by_id($id);

        if ($row) {
            $kriteria = $this->_get_kriteria_lists();
            $data = array(
                'button' => 'Update',
                'action' => site_url('data_penilaian/update_action'),
		'id_nilai' => set_value('id_nilai', $row->id_nilai),
		'id_karyawan' => set_value('id_karyawan', $row->id_karyawan),
		'C1' => set_value('C1', $row->C1),
		'C2' => set_value('C2', $row->C2),
		'C3' => set_value('C3', $row->C3),
		'C4' => set_value('C4', $row->C4),
                'karyawan_list' => $this->db->order_by('nik','ASC')->get('karyawan')->result(),
                'list_c1' => $kriteria['c1'],
                'list_c2' => $kriteria['c2'],
                'list_c3' => $kriteria['c3'],
                'list_c4' => $kriteria['c4'],
	    );
            $this->template->load('template','data_penilaian/nilai_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_penilaian'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules(true);

        if ($this->form_validation->run() == FALSE) {
            $this->update($this->input->post('id_nilai', TRUE));
        } else {
            $data = array(
		'id_karyawan' => $this->input->post('id_karyawan',TRUE),
		'C1' => $this->input->post('C1',TRUE),
		'C2' => $this->input->post('C2',TRUE),
		'C3' => $this->input->post('C3',TRUE),
		'C4' => $this->input->post('C4',TRUE),
	    );

            $this->Data_penilaian_model->update($this->input->post('id_nilai', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('data_penilaian'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Data_penilaian_model->get_by_id($id);

        if ($row) {
            $this->Data_penilaian_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('data_penilaian'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('data_penilaian'));
        }
    }

    public function _rules($is_update = false) 
    {
        $idNilai = $this->input->post('id_nilai', TRUE);
        // gunakan nama tabel yang benar: nilai
        $uniqueRule = $is_update ? 'callback_unique_karyawan['.$idNilai.']' : 'is_unique[nilai.id_karyawan]';

	$this->form_validation->set_rules('id_karyawan', 'karyawan', 'trim|required|'.$uniqueRule);
	$this->form_validation->set_rules('C1', 'c1', 'trim|required');
	$this->form_validation->set_rules('C2', 'c2', 'trim|required');
	$this->form_validation->set_rules('C3', 'c3', 'trim|required');
	$this->form_validation->set_rules('C4', 'c4', 'trim|required');

	$this->form_validation->set_rules('id_nilai', 'id_nilai', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

    public function unique_karyawan($id_karyawan, $id_nilai)
    {
        $id_nilai = (int) $id_nilai;
        $exists = $this->db->where('id_karyawan', $id_karyawan)
                           ->where('id_nilai !=', $id_nilai)
                           ->get('nilai')
                           ->num_rows();
        if ($exists > 0) {
            $this->form_validation->set_message('unique_karyawan', 'Karyawan sudah memiliki nilai, silakan update data yang ada.');
            return false;
        }
        return true;
    }

    private function _get_kriteria_lists()
    {
        return array(
            'c1' => $this->db->order_by('bobot_kriteria', 'DESC')->get('kriteria_absensi_c1')->result(),
            'c2' => $this->db->order_by('bobot_kriteria', 'DESC')->get('kriteria_produktifitas_c2')->result(),
            'c3' => $this->db->order_by('bobot_kriteria', 'DESC')->get('kriteria_kualitaskerja_c3')->result(),
            'c4' => $this->db->order_by('bobot_kriteria', 'DESC')->get('kriteria_perilaku_c4')->result(),
        );
    }

}

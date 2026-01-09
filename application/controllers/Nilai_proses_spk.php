<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nilai_proses_spk extends CI_Controller
{
    function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Nilai_proses_spk_model');
        $this->load->library('form_validation');
    }

    public function index()
    {
        $data['record']     =    $this->Nilai_proses_spk_model->tampil_data();
        $data['ranking']   =    $this->Nilai_proses_spk_model->tampil_data_ranking();
        $unscored = $this->Nilai_proses_spk_model->get_unscored_karyawan()->result();
        $data['unscored_employees'] = $unscored;
        $data['unscored_count'] = count($unscored);
        $data['threshold'] = 0.80;
        $this->template->load('template','nilai_proses_spk/nilai_list', $data);
    }

    public function create() 
    {
        $data = array(
            'button' => 'Create',
            'action' => site_url('nilai_proses_spk/create_action'),
	    'id_nilai' => set_value('id_nilai'),
	    'id_karyawan' => set_value('id_karyawan'),
	    'C1' => set_value('C1'),
	    'C2' => set_value('C2'),
	    'C3' => set_value('C3'),
	    'C4' => set_value('C4'),
	);
        $this->template->load('template','nilai_proses_spk/nilai_form', $data);
    }
    
    public function create_action() 
    {
        $this->_rules();

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

            $this->Nilai_proses_spk_model->insert($data);
            $this->session->set_flashdata('message', 'Create Record Success 2');
            redirect(site_url('nilai_proses_spk'));
        }
    }
    
    public function update($id) 
    {
        $row = $this->Nilai_proses_spk_model->get_by_id($id);

        if ($row) {
            $data = array(
                'button' => 'Update',
                'action' => site_url('nilai_proses_spk/update_action'),
		'id_nilai' => set_value('id_nilai', $row->id_nilai),
		'id_karyawan' => set_value('id_karyawan', $row->id_karyawan),
		'C1' => set_value('C1', $row->C1),
		'C2' => set_value('C2', $row->C2),
		'C3' => set_value('C3', $row->C3),
		'C4' => set_value('C4', $row->C4),
	    );
            $this->template->load('template','nilai_proses_spk/nilai_form', $data);
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('nilai_proses_spk'));
        }
    }
    
    public function update_action() 
    {
        $this->_rules();

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

            $this->Nilai_proses_spk_model->update($this->input->post('id_nilai', TRUE), $data);
            $this->session->set_flashdata('message', 'Update Record Success');
            redirect(site_url('nilai_proses_spk'));
        }
    }
    
    public function delete($id) 
    {
        $row = $this->Nilai_proses_spk_model->get_by_id($id);

        if ($row) {
            $this->Nilai_proses_spk_model->delete($id);
            $this->session->set_flashdata('message', 'Delete Record Success');
            redirect(site_url('nilai_proses_spk'));
        } else {
            $this->session->set_flashdata('message', 'Record Not Found');
            redirect(site_url('nilai_proses_spk'));
        }
    }

    public function print_pdf()
    {
        $record   = $this->Nilai_proses_spk_model->tampil_data()->result();
        $ranking   = $this->Nilai_proses_spk_model->tampil_data_ranking()->result();
        $threshold = 0.80;
        $midThreshold = 0.60;

        $teladanCount = 0;
        $perluCount = 0;
        $belumCount = 0;
        foreach ($ranking as $p) {
            $nilai = (float)$p->nilai;
            if ($nilai >= $threshold) {
                $teladanCount++;
            } elseif ($nilai >= $midThreshold) {
                $perluCount++;
            } else {
                $belumCount++;
            }
        }
        $totalRanking = count($ranking);

        $this->load->library('pdf'); // wrapper yang include FPDF
        $pdf = new FPDF('P', 'mm', 'A4');
        $pdf->AddPage();

        $pdf->SetFont('Arial', 'B', 14);
        $pdf->Cell(0, 10, 'Laporan Nilai Proses SPK (SAW)', 0, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $pdf->Cell(0, 6, 'Tanggal: ' . date('d/m/Y'), 0, 1, 'L');
        $pdf->Cell(0, 6, 'Threshold Teladan: '.$threshold.' | Perlu Peningkatan: '.$midThreshold.' - '.($threshold).' | Belum Teladan: < '.$midThreshold, 0, 1, 'L');
        $pdf->Cell(0, 6, 'Total: '.$totalRanking.' | Teladan: '.$teladanCount.' | Perlu Peningkatan: '.$perluCount.' | Belum Teladan: '.$belumCount, 0, 1, 'L');
        $pdf->Ln(3);

        // Rating Kecocokan (dihapus sesuai permintaan)

        // Hasil
        $pdf->SetFont('Arial', 'B', 12);
        $pdf->Cell(0, 8, 'Hasil Penilaian Karyawan', 0, 1, 'L');

        $pdf->SetFont('Arial', 'B', 9);
        $pdf->Cell(15, 8, 'No', 1, 0, 'C');
        $pdf->Cell(70, 8, 'Nama Karyawan', 1, 0, 'L');
        $pdf->Cell(30, 8, 'Nilai', 1, 0, 'C');
        $pdf->Cell(55, 8, 'Status', 1, 1, 'C');

        $pdf->SetFont('Arial', '', 10);
        $no = 1;
        $statusThreshold = isset($threshold) ? (float)$threshold : 0.80;
        $midThreshold = 0.60;

        foreach ($ranking as $row) {
            $nilai = (float)$row->nilai;
            $nilaiFormatted = rtrim(rtrim(number_format($nilai, 3), '0'), '.');
            if ($nilaiFormatted === '') { $nilaiFormatted = '0'; }
            if ($nilai >= $statusThreshold) {
                $statusText = 'Karyawan Teladan';
            } elseif ($nilai >= $midThreshold) {
                $statusText = 'Perlu Peningkatan';
            } else {
                $statusText = 'Belum Teladan';
            }

            $pdf->Cell(15, 8, 'V '.$no, 1, 0, 'C');
            $pdf->Cell(70, 8, $row->nama_karyawan, 1, 0, 'L');
            $pdf->Cell(30, 8, $nilaiFormatted, 1, 0, 'C');
            $pdf->Cell(55, 8, $statusText, 1, 1, 'C');
            $no++;
        }

        if (ob_get_length()) { ob_end_clean(); }
        $pdf->Output('I', 'laporan_nilai_proses_spk.pdf');
    }

    public function _rules() 
    {
	$this->form_validation->set_rules('id_karyawan', 'id puskesmas', 'trim|required');
	$this->form_validation->set_rules('C1', 'c1', 'trim|required');
	$this->form_validation->set_rules('C2', 'c2', 'trim|required');
	$this->form_validation->set_rules('C3', 'c3', 'trim|required');
	$this->form_validation->set_rules('C4', 'c4', 'trim|required');

	$this->form_validation->set_rules('id_nilai', 'id_nilai', 'trim');
	$this->form_validation->set_error_delimiters('<span class="text-danger">', '</span>');
    }

}

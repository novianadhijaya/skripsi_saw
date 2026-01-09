<?php

if (!defined('BASEPATH')) exit('No direct script access allowed');

class Hasil_penilaian_individu extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        is_login();
        $this->load->model('Nilai_proses_spk_model');
    }

    public function index()
    {
        $namaSession = $this->session->userdata('full_name');
        if (empty($namaSession)) {
            $this->session->set_flashdata('status_login', 'Silakan login untuk melihat hasil penilaian.');
            redirect('auth');
            return;
        }

        $threshold = 0.80;
        $midThreshold = 0.60;
        $scoreRow = $this->Nilai_proses_spk_model->get_individual_score_by_name($namaSession);

        $statusText = 'Belum Teladan';
        $statusClass = 'pill-neutral';
        if ($scoreRow) {
            $nilai = (float) $scoreRow->nilai;
            if ($nilai >= $threshold) {
                $statusText = 'Karyawan Teladan';
                $statusClass = 'pill-success';
            } elseif ($nilai >= $midThreshold) {
                $statusText = 'Perlu Peningkatan';
                $statusClass = 'pill-warning';
            }
        }

        $data = array(
            'scoreRow' => $scoreRow,
            'namaSession' => $namaSession,
            'threshold' => $threshold,
            'midThreshold' => $midThreshold,
            'statusText' => $statusText,
            'statusClass' => $statusClass,
        );

        $this->template->load('template', 'nilai_proses_spk/nilai_individu', $data);
    }
}

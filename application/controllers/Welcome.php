<?php

defined('BASEPATH') OR exit('No direct script access allowed');

class Welcome extends CI_Controller {

    public function __construct() {
        parent::__construct();
        is_login();
        $this->load->model('Dashboard_model');
        $this->load->model('Nilai_proses_spk_model');
    }

    public function index() {
        $thresholdValue = 0.80;
        $midThreshold = 0.60;

        // Data untuk chart nilai proses SPK
        $rankingData = $this->Nilai_proses_spk_model->tampil_data_ranking()->result();

        $data['tampil_data'] = $this->Nilai_proses_spk_model->tampil_data();
        $data['ranking_chart'] = $rankingData;
        $data['threshold_value'] = $thresholdValue;
        $data['mid_threshold'] = $midThreshold;
        $data['ranking_labels'] = array();
        $data['ranking_values'] = array();
        $data['status_counts'] = array(
            'teladan' => 0,
            'perlu' => 0,
            'belum' => 0,
        );
        $data['top_score'] = 0;
        $data['top_name'] = '';

        foreach ($rankingData as $row) {
            $nilai = (float) $row->nilai;
            $data['ranking_labels'][] = $row->nama_karyawan;
            $data['ranking_values'][] = round($nilai, 3);

            if ($nilai >= $thresholdValue) {
                $data['status_counts']['teladan']++;
            } elseif ($nilai >= $midThreshold) {
                $data['status_counts']['perlu']++;
            } else {
                $data['status_counts']['belum']++;
            }

            if ($nilai > $data['top_score']) {
                $data['top_score'] = $nilai;
                $data['top_name'] = $row->nama_karyawan;
            }
        }


        $this->template->load('template', 'dashboard', $data);
    }

    public function form() {
        $this->template->load('template', 'form');
    }
}

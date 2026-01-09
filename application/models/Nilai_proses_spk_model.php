<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Nilai_proses_spk_model extends CI_Model
{

    public $table = 'nilai';
    public $id = 'id_nilai';
    public $order = 'DESC';

    function __construct()
    {
        parent::__construct();
    }

function tampil_data()
{
    $sql = "
    SELECT
      n.id_nilai,
      k.id_karyawan,
      k.nama_karyawan,
      a.bobot_kriteria  AS C1,   -- Absensi
      pr.bobot_kriteria AS C2,   -- Produktifitas
      q.bobot_kriteria  AS C3,   -- Kualitas Kerja
      p.bobot_kriteria  AS C4    -- Perilaku
    FROM nilai n
    LEFT JOIN karyawan k
      ON n.id_karyawan = k.id_karyawan
    LEFT JOIN kriteria_absensi_c1 a
      ON n.C1 = a.id_kriteria
    LEFT JOIN kriteria_produktifitas_c2 pr
      ON n.C2 = pr.id_kriteria
    LEFT JOIN kriteria_kualitaskerja_c3 q
      ON n.C3 = q.id_kriteria
    LEFT JOIN kriteria_perilaku_c4 p
      ON n.C4 = p.id_kriteria
    ";
    return $this->db->query($sql);
}





    public function get_unscored_karyawan()
    {
        $sql = "
        SELECT k.id_karyawan, k.nama_karyawan, k.nik
        FROM karyawan k
        LEFT JOIN nilai n
          ON n.id_karyawan = k.id_karyawan
        WHERE n.id_karyawan IS NULL
        ORDER BY k.nama_karyawan ASC
        ";
        return $this->db->query($sql);
    }

    public function tampil_data_ranking()
    {
        $sql = "
        SELECT
            x.nama_karyawan,
            x.C1,
            x.C2,
            x.C3,
            x.C4,
            x.nilai,
            ROW_NUMBER() OVER (ORDER BY x.nilai DESC, x.C1 DESC, x.C2 DESC, x.C3 DESC, x.C4 DESC, x.nama_karyawan ASC) AS ranking
        FROM (
            SELECT
                drv.nama_karyawan,
                drv.C1,
                drv.C2,
                drv.C3,
                drv.C4,
                (
                    (CASE WHEN m.maxC1 > 0 THEN drv.C1 / m.maxC1 ELSE 0 END) * 0.40 +
                    (CASE WHEN m.maxC2 > 0 THEN drv.C2 / m.maxC2 ELSE 0 END) * 0.25 +
                    (CASE WHEN m.maxC3 > 0 THEN drv.C3 / m.maxC3 ELSE 0 END) * 0.15 +
                    (CASE WHEN m.maxC4 > 0 THEN drv.C4 / m.maxC4 ELSE 0 END) * 0.20
                ) AS nilai
            FROM (
                SELECT
                    f.nama_karyawan,
                    b.bobot_kriteria AS C1,
                    c.bobot_kriteria AS C2,
                    d.bobot_kriteria AS C3,
                    e.bobot_kriteria AS C4
                FROM nilai AS a
                LEFT JOIN kriteria_absensi_c1 AS b ON a.C1 = b.id_kriteria
                LEFT JOIN kriteria_produktifitas_c2 AS c ON c.id_kriteria = a.C2
                LEFT JOIN kriteria_kualitaskerja_c3 AS d ON d.id_kriteria = a.C3
                LEFT JOIN kriteria_perilaku_c4 AS e ON e.id_kriteria = a.C4
                LEFT JOIN karyawan AS f ON f.id_karyawan = a.id_karyawan
            ) drv
            CROSS JOIN (
                SELECT
                    MAX(b.bobot_kriteria) AS maxC1,
                    MAX(c.bobot_kriteria) AS maxC2,
                    MAX(d.bobot_kriteria) AS maxC3,
                    MAX(e.bobot_kriteria) AS maxC4
                FROM nilai AS a
                LEFT JOIN kriteria_absensi_c1 AS b ON a.C1 = b.id_kriteria
                LEFT JOIN kriteria_produktifitas_c2 AS c ON c.id_kriteria = a.C2
                LEFT JOIN kriteria_kualitaskerja_c3 AS d ON d.id_kriteria = a.C3
                LEFT JOIN kriteria_perilaku_c4 AS e ON e.id_kriteria = a.C4
            ) m
        ) x
        ORDER BY x.nilai DESC, x.C1 DESC, x.C2 DESC, x.C3 DESC, x.C4 DESC, x.nama_karyawan ASC;
        ";
        return $this->db->query($sql);
    }

    public function get_individual_score_by_name($nama_karyawan)
    {
        $sql = "
        SELECT
            drv.id_karyawan,
            drv.nama_karyawan,
            drv.C1,
            drv.C2,
            drv.C3,
            drv.C4,
            drv.C1_label,
            drv.C2_label,
            drv.C3_label,
            drv.C4_label,
            (CASE WHEN m.maxC1 > 0 THEN drv.C1 / m.maxC1 ELSE 0 END) AS normC1,
            (CASE WHEN m.maxC2 > 0 THEN drv.C2 / m.maxC2 ELSE 0 END) AS normC2,
            (CASE WHEN m.maxC3 > 0 THEN drv.C3 / m.maxC3 ELSE 0 END) AS normC3,
            (CASE WHEN m.maxC4 > 0 THEN drv.C4 / m.maxC4 ELSE 0 END) AS normC4,
            (
                (CASE WHEN m.maxC1 > 0 THEN drv.C1 / m.maxC1 ELSE 0 END) * 0.40 +
                (CASE WHEN m.maxC2 > 0 THEN drv.C2 / m.maxC2 ELSE 0 END) * 0.25 +
                (CASE WHEN m.maxC3 > 0 THEN drv.C3 / m.maxC3 ELSE 0 END) * 0.15 +
                (CASE WHEN m.maxC4 > 0 THEN drv.C4 / m.maxC4 ELSE 0 END) * 0.20
            ) AS nilai
        FROM (
            SELECT
                f.id_karyawan,
                f.nama_karyawan,
                b.pilihan_kriteria AS C1_label,
                c.pilihan_kriteria AS C2_label,
                d.pilihan_kriteria AS C3_label,
                e.pilihan_kriteria AS C4_label,
                b.bobot_kriteria AS C1,
                c.bobot_kriteria AS C2,
                d.bobot_kriteria AS C3,
                e.bobot_kriteria AS C4
            FROM nilai AS a
            LEFT JOIN kriteria_absensi_c1 AS b ON a.C1 = b.id_kriteria
            LEFT JOIN kriteria_produktifitas_c2 AS c ON c.id_kriteria = a.C2
            LEFT JOIN kriteria_kualitaskerja_c3 AS d ON d.id_kriteria = a.C3
            LEFT JOIN kriteria_perilaku_c4 AS e ON e.id_kriteria = a.C4
            LEFT JOIN karyawan AS f ON f.id_karyawan = a.id_karyawan
        ) drv
        CROSS JOIN (
            SELECT
                MAX(b.bobot_kriteria) AS maxC1,
                MAX(c.bobot_kriteria) AS maxC2,
                MAX(d.bobot_kriteria) AS maxC3,
                MAX(e.bobot_kriteria) AS maxC4
            FROM nilai AS a
            LEFT JOIN kriteria_absensi_c1 AS b ON a.C1 = b.id_kriteria
            LEFT JOIN kriteria_produktifitas_c2 AS c ON a.C2 = c.id_kriteria
            LEFT JOIN kriteria_kualitaskerja_c3 AS d ON a.C3 = d.id_kriteria
            LEFT JOIN kriteria_perilaku_c4 AS e ON a.C4 = e.id_kriteria
        ) m
        WHERE drv.nama_karyawan = ?
        LIMIT 1;
        ";
        return $this->db->query($sql, array($nama_karyawan))->row();
    }


    

    // get all
    function get_all()
    {
        $this->db->order_by($this->id, $this->order);
        return $this->db->get($this->table)->result();
    }

    // get data by id
    function get_by_id($id)
    {
        $this->db->where($this->id, $id);
        return $this->db->get($this->table)->row();
    }
    
    // get total rows
    function total_rows($q = NULL) {
        $this->db->like('id_nilai', $q);
	$this->db->or_like('id_karyawan', $q);
	$this->db->or_like('C1', $q);
	$this->db->or_like('C2', $q);
	$this->db->or_like('C3', $q);
	$this->db->or_like('C4', $q);
	$this->db->from($this->table);
        return $this->db->count_all_results();
    }

    // get data with limit and search
    function get_limit_data($limit, $start = 0, $q = NULL) {
        $this->db->order_by($this->id, $this->order);
        $this->db->like('id_nilai', $q);
	$this->db->or_like('id_karyawan', $q);
	$this->db->or_like('C1', $q);
	$this->db->or_like('C2', $q);
	$this->db->or_like('C3', $q);
	$this->db->or_like('C4', $q);
	$this->db->limit($limit, $start);
        return $this->db->get($this->table)->result();
    }

    // insert data
    function insert($data)
    {
        $this->db->insert($this->table, $data);
    }

    // update data
    function update($id, $data)
    {
        $this->db->where($this->id, $id);
        $this->db->update($this->table, $data);
    }

    // delete data
    function delete($id)
    {
        $this->db->where($this->id, $id);
        $this->db->delete($this->table);
    }

}

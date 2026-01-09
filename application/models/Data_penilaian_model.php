<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Data_penilaian_model extends CI_Model
{

    public $table = 'nilai';
    public $id = 'id_nilai';
    public $order = 'ASC';

    function __construct()
    {
        parent::__construct();
    }

    public function tampil_data($q = null)
    {
        $this->db->select('
            k.id_karyawan,
            k.nik,
            k.nama_karyawan,
            k.departemen,
            k.alamat,
            n.id_nilai,
            a.pilihan_kriteria   AS C1,
            pr.pilihan_kriteria  AS C2,
            qk.pilihan_kriteria  AS C3,
            p.pilihan_kriteria   AS C4
        ');
        $this->db->from('karyawan k');
        $this->db->join('nilai n', 'n.id_karyawan = k.id_karyawan', 'left');
        $this->db->join('kriteria_absensi_c1 a', 'n.C1 = a.id_kriteria', 'left');
        $this->db->join('kriteria_produktifitas_c2 pr', 'n.C2 = pr.id_kriteria', 'left');
        $this->db->join('kriteria_kualitaskerja_c3 qk', 'n.C3 = qk.id_kriteria', 'left');
        $this->db->join('kriteria_perilaku_c4 p', 'n.C4 = p.id_kriteria', 'left');

        if (!empty($q)) {
            $q = trim($q);
            $this->db->group_start()
                     ->like('k.nik', $q)
                     ->or_like('k.nama_karyawan', $q)
                     ->or_like('k.departemen', $q)
                     ->or_like('k.alamat', $q)
                     ->group_end();
        }

        $this->db->order_by('k.id_karyawan', 'ASC');
        return $this->db->get();
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

    function get_by_karyawan($id_karyawan)
    {
        return $this->db->get_where($this->table, array('id_karyawan' => $id_karyawan))->row();
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

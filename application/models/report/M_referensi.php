<?php

use PhpOffice\PhpSpreadsheet\Worksheet\Row;

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_referensi extends CI_Model
{    
    static $table1  = 'm_emply';
    static $table2  = 'departemen';
    static $table3  = 'm_jabatan';
    static $table4  = 't_referensi';
    static $table5  = 'pkwt';
    
    public function __construct() {
        parent::__construct();
        
    }
          function enumField($table1, $field)
    {
        $enums = field_enums($table1, $field);
        return json_encode($enums);
    }


    function cetak($nama, $tgl, $tgl_pengajuan, $cetak)
    {

        $this->db->select('*');
        $this->db->where('t_referensi_nik', $nama);
        $query  = $this->db->get(self::$table4);
        $row = $query->row();
        if (!$row) {

            $this->db->where('m_emply_nik', $nama);
            $this->db->update(self::$table1, array(
                'm_emply_end'            => $tgl

            ));

            $this->db->select('MAX(t_referensi_no_surat) AS nosurat');
            $query1  = $this->db->get(self::$table4);
            $row = $query1->row();

            $this->db->insert(self::$table4, array(
                't_referensi_nik'                        => $nama,
                't_referensi_tgl_pengunduran'            => $tgl_pengajuan,
                't_referensi_no_surat'                   => $row->nosurat + 1,

            ));
        }

        $this->db->select('a.m_emply_nik AS m_emply_nik, a.m_emply_name AS m_emply_name, a.m_emply_sex AS m_emply_sex, a.m_emply_start AS m_emply_start,
                          a.m_emply_status AS m_emply_status, a.m_emply_end AS m_emply_end, b.m_jabatan_nama AS m_jabatan_nama, c.t_referensi_tgl_pengunduran AS t_referensi_tgl_pengunduran,
                          c.t_referensi_no_surat AS t_referensi_no_surat, d.departemen_id AS departemen_id, e.departemen_nama AS departemen_nama,
                          f.pkwt_sign AS pkwt_sign, f.pkwt_start AS pkwt_start, f.pkwt_end AS pkwt_end, f.pkwt_id AS pkwt_id');
        $this->db->where('a.m_emply_nik', $nama);
        $this->db->join(self::$table3.' b', 'a.m_emply_jabatan=b.m_jabatan_id', 'left');
        $this->db->join(self::$table4.' c', 'a.m_emply_nik=c.t_referensi_nik', 'left');
        $this->db->join(self::$table2.' d','a.m_emply_dept=d.departemen_id', 'left');
        $this->db->join(self::$table2.' e', 'd.departemen_induk=e.departemen_id', 'left');
        $this->db->join(self::$table5.' f', 'a.m_emply_nik=f.pkwt_nik', 'left');
        // $this->db->group_by('');
        $header = $this->db->get(self::$table1. ' a');


        $tgl = $this->db->query('SELECT "' . $cetak . '" as Tanggal');

        $result = array();
        $result['header'] = $header;
        $result['cetak']  = $tgl;
        return $result;
    }

    function getNama($q)
    {
        $this->db->select('m_emply_nik, m_emply_name', NULL);
        $this->db->like('m_emply_name', $q);
        $query  = $this->db->get(self::$table1);

        $data = array();
        foreach ($query->result() as $row) {
            array_push($data, $row);
        }
        return json_encode($data);
    } 
    
}
?>

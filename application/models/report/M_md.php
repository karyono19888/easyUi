<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_md extends CI_Model
{    
    static $table   = 't_proposal';
    static $table2  = 'departemen';
    static $table3  = 'm_materi';
    static $table4  = 'm_emply';
    static $table5  = 't_schedule';
    static $table6  = 'm_tempat';
    static $table7  = 'm_jabatan';
    static $table8  = 'm_standar_nilai';
    static $table9  = 't_evaluasi';
    static $table10 = 'm_jobs_spec';
    static $table11 = 'm_emply_image';
    static $table12 = 'm_pendidikan';
    static $table13 = 'view_t_evaluasi';
    
    public function __construct() {
        parent::__construct();
        
    }
          function enumField($table1, $field)
    {
        $enums = field_enums($table1, $field);
        return json_encode($enums);
    }
    

  function cetak($dept, $tahun){
        $this->db->select('departemen_induk,departemen_nama,t_evaluasi_tgl_test_tertulis');
        $this->db->where('departemen_induk', $dept)
                 ->where('YEAR(t_evaluasi_tgl_test_tertulis)', $tahun);
        $header = $this->db->get(self::$table13);
        
        //proses
        $this->db->select('nik,m_jabatan_id,m_jabatan_nama,AVG(persen) AS rata');
        $this->db->where('departemen_induk', $dept)
                 ->where('YEAR(t_evaluasi_tgl_test_tertulis)', $tahun);
        $this->db->join(self::$table4,'nik=m_emply_nik', 'left');
        $this->db->join(self::$table7,'m_emply_jabatan=m_jabatan_id', 'left');
        $this->db->group_by('departemen_induk,m_jabatan_id');
        $detail = $this->db->get(self::$table13);
        
       
        $result = array();
        $result['header'] = $header;
        $result['detail'] = $detail;
        return $result;
    }

    
function getDept()
    {
        $this->db->select('departemen_id,departemen_nama', NULL);
        $this->db->where('departemen_induk',0);
        $query  = $this->db->get(self::$table2);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
    

}
?>

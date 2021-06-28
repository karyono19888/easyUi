<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class M_evaluasi extends CI_Model
{    
    static $table  = 't_proposal';
    static $table2 = 'departemen';
    static $table3 = 'm_materi';
    static $table4 = 'm_emply';
    static $table6 = 'm_tempat';
    static $table7 = 'm_jabatan';
    static $table8 = 'm_std_nilai_pelatihan';
    static $table9 = 't_evaluasi';
    static $table10 ='view_t_evaluasi';
    static $table11 ='eval';
    
    public function __construct() {
        parent::__construct();
        
    }
          function enumField($table1, $field)
    {
        $enums = field_enums($table1, $field);
        return json_encode($enums);
    }
   
     function cetak($dept, $materi, $dari, $sampai, $cetak){
        $this->db->select('departemen_nama, m_materi_nama');
        $this->db->where('m_std_nilai_pelatihan_materi', $materi)
		 ->where('departemen_induk',$dept);
        //$this->db->join(self::$table2.'departemen_induk=departemen_id', 'left');			
        $header = $this->db->get(self::$table10.' a');
        
        //proses
        $this->db->select('t_evaluasi_tgl_pelatihan,  t_evaluasi_tgl_test_tertulis,
			 m_emply_name, m_standar_nilai_range, t_evaluasi_pengetahuan_materi,
			 t_evaluasi_penerapan_lap, t_evaluasi_peningkatan_kinerja ');
        $this->db->where('m_std_nilai_pelatihan_materi', $materi)
		 ->where('departemen_induk',$dept)
                 ->where('t_evaluasi_tgl_test_tertulis >=',$dari)
                 ->where('t_evaluasi_tgl_test_tertulis <=',$sampai);
        //$this->db->join(self::$table2. 'a.departemen_id=b.departemen_id', 'left');		
        $detail = $this->db->get(self::$table10);
        
        $tgl = $this->db->query('SELECT "'.$cetak.'" as Tanggal');
       
        $result = array();
		$result['header'] = $header;
        $result['detail'] = $detail;
        $result['cetak']  = $tgl;
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
    
     function getMat()
    {
        $this->db->select('m_materi_no,m_materi_nama', NULL);
       // $this->db->join(self::$table2, 't_proposal_dept=departemen_id', 'left');
        $query  = $this->db->get(self::$table3);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
}

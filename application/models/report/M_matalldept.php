<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_matalldept extends CI_Model
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
        
        $DB2 = $this->load->database('database_kedua', TRUE);
    }
          function enumField($table1, $field)
    {
        $enums = field_enums($table1, $field);
        return json_encode($enums);
    }
    

  function cetak($tahun){ 
        //proses
      $detail = $this->db->query("SELECT departemen_nama, AVG(rata) as rata
									FROM
									(SELECT
										t1.departemen_induk AS departemen,
										t2.departemen_nama AS departemen_nama,
										ROUND(AVG(t1.persen)) AS rata,
										t1.m_emply_name
									FROM
										hris_hikari.view_t_evaluasi t1
									LEFT JOIN hris_hikari.departemen t2
									ON
										t1.departemen_induk = t2.departemen_id
									WHERE
										YEAR(
											t1.t_evaluasi_tgl_test_tertulis
										) = '$tahun' 
									AND t1.departemen_induk !=100
									GROUP BY t1.nik
									UNION ALL
									SELECT
										t3.departemen_induk AS departemen,
										t4.departemen_nama AS departemen_nama,
										ROUND(AVG(t3.persen)) AS rata,
										t3.m_emply_name
									FROM
										hris_saga.view_t_evaluasi t3
									LEFT JOIN hris_saga.departemen t4
									ON
										t3.departemen_induk = t4.departemen_id
									WHERE
										YEAR(
											t3.t_evaluasi_tgl_test_tertulis
										) = '$tahun'
									AND t3.departemen_induk !=100  
									GROUP BY t3.nik) AS gg
									group by departemen_nama");
      
      
      
      /*$this->db->select('a.departemen_induk AS departemen_induk,b.departemen_nama AS departemen_nama,AVG(a.persen) AS rata');
        $this->db->where('YEAR(a.t_evaluasi_tgl_test_tertulis)', $tahun)
                 ->where('a.departemen_induk != 100');
        $this->db->join(self::$table2.' b', 'a.departemen_induk = b.departemen_id', 'left');
        $this->db->group_by('departemen_induk');
        $detail = $this->db->get(self::$table13.' a'); */
        
       
        $result = array();
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

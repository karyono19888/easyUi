<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_hasil extends CI_Model
{    
    static $table  = 't_proposal';
    static $table2 = 'departemen';
    static $table3 = 'm_materi';
    static $table4 = 'm_emply';
    static $table5 = 't_schedule';
    static $table6 = 'm_tempat';
    static $table7 = 'm_jabatan';
    static $table8 = 'm_standar_nilai';
	static $table9 = 'view_t_evaluasi';
    
    public function __construct() {
        parent::__construct();
        
    }
          function enumField($table1, $field)
    {
        $enums = field_enums($table1, $field);
        return json_encode($enums);
    }
    

  function cetak($materi, $tes, $cetak){
       $this->db->select('m_materi_nama,t_evaluasi_tgl_test_tertulis');
       $this->db->where('m_std_nilai_pelatihan_materi', $materi);
       $this->db->where('t_evaluasi_tgl_test_tertulis', $tes);
     // $this->db->join(self::$table3, 't_proposal_materi=m_materi_no', 'left');
    //  $this->db->join(self::$table5, 't_proposal_id=t_schedule_proposal', 'left');
       $this->db->group_by('m_std_nilai_pelatihan_materi,t_evaluasi_tgl_test_tertulis');
       $header = $this->db->get(self::$table9);
        
        //proses
       $this->db->select('*');
       $this->db->where('m_std_nilai_pelatihan_materi', $materi);
       $this->db->where('t_evaluasi_tgl_test_tertulis', $tes);
      // $this->db->join(self::$table, 't_schedule_proposal=t_proposal_id', 'left');
      // $this->db->join(self::$table4, 't_proposal_peserta=m_emply_nik', 'left');     // Join Ke tabel m_emply
     //  $this->db->join(self::$table7, 'm_emply_jabatan=m_jabatan_id', 'left');     // Join Ke tabel m_jabatan
     //  $this->db->join(self::$table8, 'm_jabatan_grade=m_standar_nilai_grade', 'left');
     //  $this->db->join(self::$table2, 't_proposal_dept=departemen_id', 'left');
            // Join Ke tabel m_jabatan    // Join Ke tabel standar nilai
       $detail = $this->db->get(self::$table9);
        
       $tgl = $this->db->query('SELECT "'.$cetak.'" as Tanggal');
       
        $result = array();
	$result['header'] = $header;
        $result['detail'] = $detail;
        $result['cetak']  = $tgl;
        return $result;
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
?>

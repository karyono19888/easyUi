<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_schedule extends CI_Model
{    
    static $table  = 't_proposal';
    static $table2 = 'departemen';
    static $table3 = 'm_materi';
    static $table4 = 'm_emply';
    static $table5 = 't_schedule';
    static $table6 = 'm_tempat';
    
    public function __construct() {
        parent::__construct();
        
    }
          function enumField($table1, $field)
    {
        $enums = field_enums($table1, $field);
        return json_encode($enums);
    }
    

  function cetak($tahun, $periode, $tglStart,$tglEnd, $cetak){
       $this->db->select('*');
       $this->db->where('t_proposal_tahun', $tahun);
       $this->db->where('t_proposal_periode', $periode);
       //$this->db->where('t_schedule_tgl', $tglschedule);
       $this->db->group_by('t_proposal_tahun,t_proposal_periode');
       $header = $this->db->get(self::$table);
        
        //proses
       $this->db->select('*');
       $this->db->where('t_proposal_tahun', $tahun);
       $this->db->where('t_proposal_periode', $periode);
       $this->db->where('t_schedule_tgl >=', $tglStart);
       $this->db->where('t_schedule_tgl <=', $tglEnd);
       $this->db->join(self::$table, 't_schedule_proposal=t_proposal_id', 'left');
       $this->db->join(self::$table2, 't_proposal_dept=departemen_id', 'left');
       $this->db->join(self::$table3, 't_proposal_materi=m_materi_no', 'left');
       $this->db->join(self::$table4, 't_proposal_peserta=m_emply_nik', 'left');
       $this->db->join(self::$table6, 't_schedule_tempat=m_tempat_id', 'left');
       $this->db->order_by('t_schedule_tgl', 'ASC')
				->order_by('t_schedule_waktu_dari', 'ASC')
				->order_by('departemen_nama', 'ASC')
				->order_by('m_emply_name', 'ASC');	   
       $detail = $this->db->get(self::$table5);
        
       //tanggalcetak
        $tgl = $this->db->query('SELECT "'.$cetak.'" as Tanggal');
       
        $result = array();
	$result['header'] = $header;
        $result['detail'] = $detail;
        $result['cetak']  = $tgl;
        return $result;
    }
}
?>

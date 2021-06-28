<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_proposal extends CI_Model
{    
    static $table  = 't_proposal';
    static $table2 = 'departemen';
    static $table3 = 'm_materi';
    static $table4 = 'm_emply';
    
    public function __construct() {
        parent::__construct();
        
    }
          function enumField($table1, $field)
    {
        $enums = field_enums($table1, $field);
        return json_encode($enums);
    }
    
 function getProp()
    {
        $this->db->select('departemen_id, departemen_induk,departemen_nama', NULL);
        $this->db->where('departemen_induk', 0);
        $query  = $this->db->get(self::$table2);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
  function cetak($dept, $tahun, $periode, $cetak){
       // $this->db->select('*');
        $this->db->where('t_proposal_dept', $dept);
        $this->db->where('t_proposal_tahun', $tahun);
        $this->db->where('t_proposal_periode', $periode);
        $this->db->join(self::$table2, 't_proposal_dept=departemen_id', 'left');
        $this->db->join(self::$table3, 't_proposal_materi=m_materi_no', 'left');
        $this->db->join(self::$table4, 't_proposal_peserta=m_emply_nik', 'left');
        $this->db->group_by('t_proposal_dept,t_proposal_tahun,t_proposal_periode');
        $header = $this->db->get(self::$table);
        
        //proses
        $this->db->where('t_proposal_dept', $dept);
        $this->db->where('t_proposal_tahun', $tahun);
        $this->db->where('t_proposal_periode', $periode);
        $this->db->join(self::$table2, 't_proposal_dept=departemen_id', 'left');
        $this->db->join(self::$table3, 't_proposal_materi=m_materi_no', 'left');
        $this->db->join(self::$table4, 't_proposal_peserta=m_emply_nik', 'left');
        $this->db->order_by('m_materi_nama', 'asc');
        $detail = $this->db->get(self::$table);
        
        //tanggalcetak
        $tgl = $this->db->query('SELECT "'.$cetak.'" as Tanggal');
        
        $result = array();
	$result['header'] = $header;
        $result['detail'] = $detail;
        $result['cetak'] = $tgl;
        return $result;
    }
}
?>

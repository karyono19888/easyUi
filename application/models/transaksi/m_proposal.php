<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class M_proposal extends CI_Model
{    
    static $table  = 't_proposal';
    static $table2 = 'departemen';
    static $table3 = 'm_materi';
    static $table4 = 'm_emply';
     
    public function __construct() {
        parent::__construct();
      //  $this->load->helper('database'); // Digunakan untuk memunculkan data Enum
    }

    function index()
    {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 't_proposal_id';
        $order  = isset($_POST['order']) ? strval($_POST['order']) : 'desc';
        
        $filterRules = isset($_POST['filterRules']) ? ($_POST['filterRules']) : '';
	$cond = '1=1';
	if (!empty($filterRules)){
            $filterRules = json_decode($filterRules);
            //print_r ($filterRules);
            foreach($filterRules as $rule){
                $rule = get_object_vars($rule);
                $field = $rule['field'];
                $op = $rule['op'];
                $value = $rule['value'];
                if (!empty($value)){
                    if ($op == 'contains'){
                        $cond .= " and ($field like '%$value%')";
                    } else if ($op == 'beginwith'){
                        $cond .= " and ($field like '$value%')";
                    } else if ($op == 'endwith'){
                        $cond .= " and ($field like '%$value')";
                    } else if ($op == 'equal'){
                        $cond .= " and $field = $value";
                    } else if ($op == 'notequal'){
                        $cond .= " and $field != $value";
                    } else if ($op == 'less'){
                        $cond .= " and $field < $value";
                    } else if ($op == 'lessorequal'){
                        $cond .= " and $field <= $value";
                    } else if ($op == 'greater'){
                        $cond .= " and $field > $value";
                    } else if ($op == 'greaterorequal'){
                        $cond .= " and $field >= $value";
                    } 
                }
            }
	}
        
        $this->db->select('*');
        $this->db->where($cond, NULL, FALSE);
        $this->db->join(self::$table2, 't_proposal_dept=departemen_id', 'left');
        $this->db->join(self::$table3, 't_proposal_materi=m_materi_no', 'left');
        $this->db->join(self::$table4, 't_proposal_peserta=m_emply_nik', 'left');
        $total  = $this->db->count_all_results(self::$table);
        
        $this->db->select('*');
        $this->db->where($cond, NULL, FALSE);
        $this->db->join(self::$table2, 't_proposal_dept=departemen_id', 'left');
        $this->db->join(self::$table3, 't_proposal_materi=m_materi_no', 'left');
        $this->db->join(self::$table4, 't_proposal_peserta=m_emply_nik', 'left');
        $this->db->order_by($sort, $order);
        $this->db->limit($rows, $offset);
        $query  = $this->db->get(self::$table);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }
 
        $result = array();
	$result["total"] = $total;
	$result['rows'] = $data;
        
        return json_encode($result);          
    }   
        
    function create($t_proposal_dept,$t_proposal_periode,$t_proposal_tahun,$t_proposal_jenis,$t_proposal_materi,$t_proposal_peserta,
                                   $t_proposal_instruktur,$t_proposal_keterangan){
        $query = $this->db->insert(self::$table,array(
            't_proposal_dept'            => $t_proposal_dept,
            't_proposal_periode'         => $t_proposal_periode,
            't_proposal_tahun'           => $t_proposal_tahun,
            't_proposal_jenis'           => $t_proposal_jenis,
            't_proposal_materi'          => $t_proposal_materi,
            't_proposal_peserta'         => $t_proposal_peserta,
            't_proposal_instruktur'      => $t_proposal_instruktur,
            't_proposal_keterangan'      => $t_proposal_keterangan


            
        ));
        
        if($query){
            return json_encode(array('success'=>true,'test'=>'50'));
        }
        else{
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
      function update($t_proposal_id,$t_proposal_dept,$t_proposal_periode,$t_proposal_tahun,$t_proposal_jenis,$t_proposal_materi,$t_proposal_peserta,
                                   $t_proposal_instruktur,$t_proposal_keterangan)
    {
        $this->db->where('t_proposal_id', $t_proposal_id);
        $query = $this->db->update(self::$table,array(
            't_proposal_dept'            => $t_proposal_dept,
            't_proposal_periode'         => $t_proposal_periode,
            't_proposal_tahun'           => $t_proposal_tahun,
            't_proposal_jenis'           => $t_proposal_jenis,
            't_proposal_materi'          => $t_proposal_materi,
            't_proposal_peserta'         => $t_proposal_peserta,
            't_proposal_instruktur'      => $t_proposal_instruktur,
            't_proposal_keterangan'      => $t_proposal_keterangan
            
        ));
        if($query)
        {
            return json_encode(array('success'=>true));
        }
        else
        {
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
    function delete($t_proposal_id)
    {
        $query = $this->db->delete(self::$table, array('t_proposal_id' => $t_proposal_id));
        if($query)
        {
            return json_encode(array('success'=>true));
        }
        else
        {
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
  function getDept()
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
    
  function getProp()
    {
        $this->db->select('departemen_id, departemen_nama', NULL);
        //$this->db->where('departemen_induk', 0);
        $query  = $this->db->get(self::$table2);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
    
   function getMateri()
    {
        $this->db->select('m_materi_no, m_materi_nama', NULL);
        $query  = $this->db->get(self::$table3);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    } 
    
  function getPeserta($q, $dept)
    {
        $this->db->select('m_emply_nik, m_emply_name', NULL);
        $this->db->where('departemen_induk', $dept);
        $this->db->join(self::$table2, 'm_emply_dept=departemen_id', 'left');
        $this->db->like('m_emply_name', $q);
        $query  = $this->db->get(self::$table4);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    } 
    
  function getPesertaU($q)
    {
        $this->db->select('m_emply_nik, m_emply_name', NULL);
        $this->db->like('m_emply_name', $q);
        $query  = $this->db->get(self::$table4);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    } 
    
    function getInstruktur(){
        $this->db->select('t_proposal_instruktur');
        $this->db->group_by('t_proposal_instruktur');
        $query  = $this->db->get(self::$table);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
}

/* End of file m_pesertakpd.php */
/* Location: ./application/models/master/m_pesertakpd.php */
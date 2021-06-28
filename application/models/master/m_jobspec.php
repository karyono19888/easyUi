<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class M_jobspec extends CI_Model
{    
    static $table   = 'm_jobs_spec';
    static $table2  = 'departemen';
    static $table3  = 'm_pendidikan';
     
    public function __construct() {
        parent::__construct();
      //  $this->load->helper('database'); // Digunakan untuk memunculkan data Enum
    }

    function index()
    {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 'm_jobspec_id';
        $order  = isset($_POST['order']) ? strval($_POST['order']) : 'asc';
        
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
        
        $this->db->where($cond, NULL, FALSE);
        $this->db->join(self::$table2, 'm_jobspec_dept=departemen_id', 'left');
        $this->db->join(self::$table3, 'm_jobspec_educ_std=m_pendidikan_id', 'left');
        $total  = $this->db->count_all_results(self::$table);
        
        $this->db->where($cond, NULL, FALSE);
        $this->db->join(self::$table2, 'm_jobspec_dept=departemen_id', 'left');
        $this->db->join(self::$table3, 'm_jobspec_educ_std=m_pendidikan_id', 'left');
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
        
    function create($m_jobspec_nama,$m_jobspec_dept,$m_jobspec_educ_std,$m_jobspec_pengalaman_std){
        $query = $this->db->insert(self::$table,array(
            'm_jobspec_nama'            => $m_jobspec_nama,
            'm_jobspec_dept'            => $m_jobspec_dept,
            'm_jobspec_educ_std'        => $m_jobspec_educ_std,
            'm_jobspec_pengalaman_std'  => $m_jobspec_pengalaman_std

            
        ));
        
        if($query){
            return json_encode(array('success'=>true,'test'=>'50'));
        }
        else{
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
      function update($m_jobspec_id,$m_jobspec_nama,$m_jobspec_dept,$m_jobspec_educ_std,$m_jobspec_pengalaman_std)
    {
        $this->db->where('m_jobspec_id', $m_jobspec_id);
        $query = $this->db->update(self::$table,array(
            'm_jobspec_nama'            => $m_jobspec_nama,
            'm_jobspec_dept'            => $m_jobspec_dept,
            'm_jobspec_educ_std'        => $m_jobspec_educ_std,
            'm_jobspec_pengalaman_std'  => $m_jobspec_pengalaman_std
            
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
    
    function delete($m_jobspec_id)
    {
        $query = $this->db->delete(self::$table, array('m_jobspec_id' => $m_jobspec_id));
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
        $this->db->select('a.departemen_id as departemen_id, b.departemen_nama as departemen_idk, a.departemen_nama as departemen_nama');
        $this->db->join(self::$table2.' b', 'a.departemen_induk = b.departemen_id', 'left');
        $this->db->where('a.departemen_induk > 0');
        $this->db->order_by('a.departemen_induk', 'asc')
                 ->order_by('a.departemen_nama', 'asc');
        $query  = $this->db->get(self::$table2.' a');
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
    
     function getEduc()
    {
        $this->db->select('m_pendidikan_id, m_pendidikan_nama', NULL);
        $query  = $this->db->get(self::$table3);
                   
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
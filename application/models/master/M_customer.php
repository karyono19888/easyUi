<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class M_customer extends CI_Model
{    
    static $table = 'm_cust';
     
    public function __construct() {
        parent::__construct();
      //  $this->load->helper('database'); // Digunakan untuk memunculkan data Enum
    }

    function index()
    {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 'm_cust_id';
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
        $total  = $this->db->count_all_results(self::$table);
        
        $this->db->where($cond, NULL, FALSE);
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
        
    function create($m_cust_id, $m_cust_name)
    {
        $this->db->where('m_cust_id', $m_cust_id);
        $res = $this->db->get(self::$table);
        
        if($res->num_rows == 0)
        {            
            return $this->db->insert(self::$table,array(
                'm_cust_id'   => $m_cust_id,
                'm_cust_name' => $m_cust_name        
            ));
        }
        else
        {
            return false;
        }
        
    }
    
    function update($m_cust_id, $m_cust_name)
    {
        $this->db->where('m_cust_id', $m_cust_id);
        return $this->db->update(self::$table,array(
            'm_cust_name' => $m_cust_name
        ));
    }
    
    function delete($m_cust_id)
    {
        return $this->db->delete(self::$table, array('m_cust_id' => $m_cust_id)); 
    }
  
    function upload($m_cust_id, $m_cust_name){
        $query_1 = $this->db->insert(self::$table,array(
            'm_cust_id'            => $m_cust_id,
            'm_cust_name'          => $m_cust_name,
        ));
        if($query_1){
            return TRUE;
        }
        else{
            return FALSE;
        }
    }
        
}

/* End of file m_customer.php */
/* Location: ./application/models/master/m_customer.php */
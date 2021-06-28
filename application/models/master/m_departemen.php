<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class M_departemen extends CI_Model
{    
    static $table1 = 'departemen';
     
    public function __construct() {
        parent::__construct();
      //  $this->load->helper('database'); // Digunakan untuk memunculkan data Enum
    }

    function index()
    {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 'a.departemen_id';
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
                    } else if ($op == 'is'){
                        $cond .= " and $field IS $value";
                    }
                }
            }
	}
        
        $this->db->select('a.departemen_id as "a.departemen_id", a.departemen_induk as "a.departemen_induk", 
                            b.departemen_nama as "b.departemen_nama", a.departemen_nama as "a.departemen_nama"');
        $this->db->join(self::$table1.' b', 'a.departemen_induk = b.departemen_id', 'left');
        $this->db->where($cond, NULL, FALSE);
        //$this->db->where('a.departemen_induk > 0');
        $total  = $this->db->count_all_results(self::$table1.' a');
        
        $this->db->select('a.departemen_id as "a.departemen_id", a.departemen_induk as "a.departemen_induk", 
                            b.departemen_nama as "b.departemen_nama", a.departemen_nama as "a.departemen_nama"');
        $this->db->join(self::$table1.' b', 'a.departemen_induk = b.departemen_id', 'left');
        $this->db->where($cond, NULL, FALSE);
        //$this->db->where('a.departemen_induk > 0');
        
        $this->db->order_by($sort, $order);
        $this->db->limit($rows, $offset);
        $query  = $this->db->get(self::$table1.' a');
                   
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
        
    function create($induk, $bagian)
    {
        $this->db->where('departemen_induk', $induk)
                 ->where('departemen_nama', $bagian);
        $res = $this->db->get(self::$table1);
        
        if($res->num_rows == 0)
        {            
            return $this->db->insert(self::$table1,array(
                'departemen_induk'  => $induk,
                'departemen_nama'   => $bagian         
            ));
        }
        else
        {
            return false;
        }        
    }
    
    function update($id, $induk, $bagian)
    {
        $this->db->where('departemen_induk', $induk)
                 ->where('departemen_nama', $bagian);
        $res = $this->db->get(self::$table1);
        
        if($res->num_rows == 0)
        {            
            $this->db->where('departemen_id', $id);
            return $this->db->update(self::$table1,array(
                'departemen_induk'  => $induk,
                'departemen_nama'   => $bagian            
            ));
        }
        else
        {
            return false;
        }
    }
    
    function delete($id)
    {
        return $this->db->delete(self::$table1, array('departemen_id' => $id)); 
    }
    
    function getDept()
    {
        $this->db->select('departemen_id AS id, departemen_nama AS departemen');
        $this->db->where('departemen_induk = 0');
        $this->db->order_by('departemen_nama', 'asc');
        $query  = $this->db->get(self::$table1);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
  
}

/* End of file m_departemen.php */
/* Location: ./application/models/master/m_departemen.php */
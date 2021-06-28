<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class M_notebook extends CI_Model
{    
    static $table1 = 'm_notebook';
    static $table2 = 'm_departemen';
    static $table3 = 'm_notebook_view';
    
    public function __construct() {
        parent::__construct();
       $this->load->helper('database'); // Digunakan untuk memunculkan data Enum
    }
         function enumField($table, $field)
    {
        $enums = field_enums($table, $field);
        return json_encode($enums);
    }

    function index()
    {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 'm_notebook_hostname';
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
        
        //$this->db->select('m_notebook.*, m_departemen.*', FALSE);
        $this->db->where($cond, NULL, FALSE);
        $this->db->join(self::$table2, 'm_notebook_dept=m_departemen_id', 'left');
        $total  = $this->db->count_all_results(self::$table3);
        
        //$this->db->select('m_notebook.*, concat(m_notebook_tahun,m_notebook_pt,m_notebook_urut) AS m_notebook_hostname', FALSE);
       // $this->db->select('m_notebook.*, m_departemen.*', FALSE);
        $this->db->where($cond, NULL, FALSE);
        $this->db->join(self::$table2, 'm_notebook_dept=m_departemen_id', 'left');
        $this->db->order_by($sort, $order);
        $this->db->limit($rows, $offset);
        $query  = $this->db->get(self::$table3);
                   
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
    function create($m_notebook_pt,$m_notebook_dept,$m_notebook_user,$m_notebook_masuk,$m_notebook_keterangan){
        
        $exp_tgl_asli = explode('-', $m_notebook_masuk);
        $th = substr($exp_tgl_asli[0], -2);
        
        if($m_notebook_pt=='SAGA'){
            $pt = 'SNB';
        }
        else{
            $pt = 'HNB';
        }
        $this->db->select('m_notebook_urut');
        $this->db->where('m_notebook_pt', $pt);
        $this->db->order_by('m_notebook_urut', 'desc');
        $this->db->limit(1);
        $query_1  = $this->db->get(self::$table1);
        $row_1 = $query_1->row();
        if($row_1){
            $urut = $row_1->m_notebook_urut+1;
        }
        else{
            $urut = 1;
        }
         $query = $this->db->insert(self::$table1,array(
            'm_notebook_pt'             => $pt,
            'm_notebook_urut'           => $urut,
            'm_notebook_user'           => $m_notebook_user,
            'm_notebook_dept'           => $m_notebook_dept,
            'm_notebook_masuk'          => $m_notebook_masuk,
            'm_notebook_keterangan'     => $m_notebook_keterangan
           
        ));
        
        if($query){
            return json_encode(array('success'=>true,'test'=>'50'));
        }
        else{
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
    function update($m_notebook_id,$m_notebook_dept,$m_notebook_user,$m_notebook_masuk,$m_notebook_keluar,$m_notebook_keterangan)
    {
        $this->db->where('m_notebook_id', $m_notebook_id);
        $query = $this->db->update(self::$table1,array(
            'm_notebook_dept'         => $m_notebook_dept,
            'm_notebook_user'         => $m_notebook_user,
            'm_notebook_masuk'        => $m_notebook_masuk,
            'm_notebook_keluar'       => $m_notebook_keluar,
            'm_notebook_keterangan'   => $m_notebook_keterangan
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
    
    
    function getDept($cat){
        $this->db->where('m_departemen_pt', $cat);
        $query  = $this->db->get(self::$table2);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
    
    function cetak($pt, $dept){
        if($dept){
            $cond = array('m_departemen_id'=>$dept);
        }
        else{
            $cond = array('m_departemen_pt'=>$pt);
        }
        $this->db->where($cond);
        $this->db->join(self::$table2, 'm_notebook_dept=m_departemen_id', 'left');
        $this->db->order_by('m_notebook_hostname', 'asc');
        $detail = $this->db->get(self::$table3);
        
        $pt = $this->db->query('SELECT "'.$pt.'" as Pt');
        
        $result = array();
        $result['pta'] = $pt;
	$result['rows'] = $detail;        
        return $result;
    }    
    function urut($th, $pt){
        $this->db->select('m_notebook_urut');
        $this->db->where('m_notebook_tahun', $th)
                 ->where('m_notebook_pt', $pt);
        $this->db->order_by('m_notebook_urut', 'desc');
        $this->db->limit(1);
        $query  = $this->db->get(self::$table1);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
    
   
    
}

/* End of file m_customer.php */
/* Location: ./application/models/master/m_customer.php */
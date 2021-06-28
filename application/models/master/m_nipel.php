<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class M_nipel extends CI_Model
{    
    static $table1 = 'm_std_nilai_pelatihan';
    static $table2 = 'departemen';
    static $table3 = 'm_materi';
    static $table4 = 'm_jabatan';
    static $table5 = 'm_standar_nilai';
     
    public function __construct() {
        parent::__construct();
      //  $this->load->helper('database'); // Digunakan untuk memunculkan data Enum
    }

    function index()
    {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 'm_std_nilai_pelatihan_id';
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
        
        $this->db->select('m_std_nilai_pelatihan_id, a.departemen_id AS "a.departemen_id", b.departemen_nama AS "b.departemen_nama", a.departemen_nama AS "a.departemen_nama", m_std_nilai_pelatihan_bag, m_materi_nama, m_std_nilai_pelatihan_materi, m_std_nilai_pelatihan_jab, m_jabatan_nama, m_std_nilai_pelatihan_nilai');
        $this->db->join(self::$table2.' a', 'm_std_nilai_pelatihan_bag=a.departemen_id', 'left');
        $this->db->join(self::$table2.' b', 'a.departemen_induk = b.departemen_id', 'left');
        $this->db->join(self::$table3, 'm_std_nilai_pelatihan_materi=m_materi_no', 'left');
        $this->db->join(self::$table4, 'm_std_nilai_pelatihan_jab=m_jabatan_id', 'left');
        //$this->db->join(self::$table5, 'm_std_nilai_pelatihan_nilai=m_standar_nilai_min', 'left');
		$this->db->where($cond, NULL, FALSE);
        $total  = $this->db->count_all_results(self::$table1);
        
        
        $this->db->select('m_std_nilai_pelatihan_id, a.departemen_id AS "a.departemen_id", b.departemen_nama AS "b.departemen_nama", a.departemen_nama AS "a.departemen_nama", m_std_nilai_pelatihan_bag, m_materi_nama, m_std_nilai_pelatihan_materi, m_std_nilai_pelatihan_jab, m_jabatan_nama, m_std_nilai_pelatihan_nilai');
        $this->db->join(self::$table2.' a', 'm_std_nilai_pelatihan_bag=a.departemen_id', 'left');
        $this->db->join(self::$table2.' b', 'a.departemen_induk = b.departemen_id', 'left');
        $this->db->join(self::$table3, 'm_std_nilai_pelatihan_materi=m_materi_no', 'left');
        $this->db->join(self::$table4, 'm_std_nilai_pelatihan_jab=m_jabatan_id', 'left');
        //$this->db->join(self::$table5, 'm_std_nilai_pelatihan_nilai=m_standar_nilai_min', 'left');
		$this->db->where($cond, NULL, FALSE);
        $this->db->order_by($sort, $order);
        $this->db->limit($rows, $offset);
        $query  = $this->db->get(self::$table1);
                   
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
        
    function create($m_std_nilai_pelatihan_bag,$m_std_nilai_pelatihan_materi,$m_std_nilai_pelatihan_jab,$m_std_nilai_pelatihan_nilai){
            $this->db->where('m_std_nilai_pelatihan_bag', $m_std_nilai_pelatihan_bag)
                     ->where('m_std_nilai_pelatihan_materi', $m_std_nilai_pelatihan_materi)
                     ->where('m_std_nilai_pelatihan_jab', $m_std_nilai_pelatihan_jab);
             $query_1    = $this->db->count_all_results(self::$table1);
        if($query_1 > 0){
            return json_encode(array('success'=>false,'error'=>'Standar nilai sudah ada'));
        }
        else{
            $query_2 = $this->db->insert(self::$table1,array(
                'm_std_nilai_pelatihan_bag'           => $m_std_nilai_pelatihan_bag,
                'm_std_nilai_pelatihan_materi'        => $m_std_nilai_pelatihan_materi,
                'm_std_nilai_pelatihan_jab'           => $m_std_nilai_pelatihan_jab,
                'm_std_nilai_pelatihan_nilai'         => $m_std_nilai_pelatihan_nilai

            ));

            if($query_2){
                return json_encode(array('success'=>true,'test'=>'50'));
            }
            else{
               return json_encode(array('success'=>false,'error'=>$this->db->_error_message())); 
            }
        }      
    }
    
      function update($m_std_nilai_pelatihan_id,$m_std_nilai_pelatihan_bag,$m_std_nilai_pelatihan_materi,$m_std_nilai_pelatihan_jab,$m_std_nilai_pelatihan_nilai)
              {
            $this->db->where('m_std_nilai_pelatihan_bag', $m_std_nilai_pelatihan_bag)
                     ->where('m_std_nilai_pelatihan_materi', $m_std_nilai_pelatihan_materi)
                     ->where('m_std_nilai_pelatihan_jab', $m_std_nilai_pelatihan_jab);
             $query_1    = $this->db->count_all_results(self::$table1);
        if($query_1 > 0){
            return json_encode(array('success'=>false,'error'=>'Standar nilai sudah ada'));
        }
        else{
            $this->db->where('m_std_nilai_pelatihan_id', $m_std_nilai_pelatihan_id);
            $query_2 = $this->db->update(self::$table1,array(
                'm_std_nilai_pelatihan_bag'           => $m_std_nilai_pelatihan_bag,
                'm_std_nilai_pelatihan_materi'        => $m_std_nilai_pelatihan_materi,
                'm_std_nilai_pelatihan_jab'           => $m_std_nilai_pelatihan_jab,
                'm_std_nilai_pelatihan_nilai'         => $m_std_nilai_pelatihan_nilai

            ));
            if($query_2)
            {
                return json_encode(array('success'=>true));
        }
        else
            {
                return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
            }
        }
    }
    
    function delete($m_std_nilai_pelatihan_id)
    {
        $query = $this->db->delete(self::$table1, array('m_std_nilai_pelatihan_id' => $m_std_nilai_pelatihan_id));
        if($query)
        {
            return json_encode(array('success'=>true));
        }
        else
        {
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
        function getBag()
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
    
    function getMat()
    {        
        $this->db->select('m_materi_no,m_materi_nama');
        $query  = $this->db->get(self::$table3);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
    
    function getJab()
    {        
        $this->db->select('m_jabatan_id,m_jabatan_nama');
        $query  = $this->db->get(self::$table4);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
    
    function getStd()
    {        
        $this->db->select('m_standar_nilai_min');
        $query  = $this->db->get(self::$table5);
                   
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
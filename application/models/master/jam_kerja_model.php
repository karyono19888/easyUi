<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Jam_kerja_model extends CI_Model
{    
    static $table = 'workday';
    
    public function __construct() {
        parent::__construct();
    }

    public function getJson()
    {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 'workday_id';
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
        $this->db->from(self::$table);
        $total  = $this->db->count_all_results();
        
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
    
    public function create()
    {

        return $this->db->insert(self::$table,array(
            'workday_name'=>$this->input->post('workday_name',true),
            'workday_I_top'=>$this->input->post('workday_I_top',true),
            'workday_I_bottom'=>$this->input->post('workday_I_bottom',true),
            'workday_P_top'=>$this->input->post('workday_P_top',true),
            'workday_P_bottom'=>$this->input->post('workday_P_bottom',true),
            'workday_II_top'=>$this->input->post('workday_II_top',true),
            'workday_II_bottom'=>$this->input->post('workday_II_bottom',true)
        ));
    }
    
    public function update($workday_id)
    {
        $this->db->where('workday_id', $workday_id);
        return $this->db->update(self::$table,array(
            'workday_name'=>$this->input->post('workday_name',true),
            'workday_I_top'=>$this->input->post('workday_I_top',true),
            'workday_I_bottom'=>$this->input->post('workday_I_bottom',true),
            'workday_P_top'=>$this->input->post('workday_P_top',true),
            'workday_P_bottom'=>$this->input->post('workday_P_bottom',true),
            'workday_II_top'=>$this->input->post('workday_II_top',true),
            'workday_II_bottom'=>$this->input->post('workday_II_bottom',true)
        ));
    }
   
    public function delete($workday_id)
    {
        return $this->db->delete(self::$table, array('workday_id' => $workday_id));
    }
    
    public function upload($workday_id)
    {
        $path = $_FILES["workday_path"]["name"];
        
        $this->db->where('workday_id', $workday_id);
        return $this->db->update(self::$table,array(
            'workday_path'=>$path
        ));
    }
    
    public function cekPath($workday_id)
    {
        $this->db->select('workday_path');
        $this->db->where('workday_id', $workday_id);
        $query  = $this->db->get(self::$table);
        
        foreach ($query->result() as $row)
        {
            if ($row->workday_path != ''){
                return true;
            }
                return false;           
        } 
    }
    
    public function deleteFile($workday_id)
    {
        $this->db->select('workday_path');
        $this->db->where('workday_id', $workday_id);
        $query  = $this->db->get(self::$table);
        
        foreach ($query->result() as $row)
        {
            $path = $row->workday_path;
            $filename = "assets/schedules/".$path;
            unlink($filename);                     
        }
    }
    

}
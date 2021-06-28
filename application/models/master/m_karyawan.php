<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class M_karyawan extends CI_Model
{    
    static $table  = 'm_emply';
    static $table2 = 'm_jabatan';
    static $table3 = 'departemen';
    static $table4 = 'm_jobs_spec';
    static $table5 = 'm_emply_image';
    static $table6 = 'm_pendidikan';
    static $table7 = 't_karyawan';
     
    public function __construct() {
        parent::__construct();
      //  $this->load->helper('database'); // Digunakan untuk memunculkan data Enum
    }

  function index()
    {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 'm_emply_nik';
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
        
        $this->db->select('m_emply_nik, m_emply_name, m_emply_sex, m_emply_bop, m_emply_bod, m_emply_relig, 
                          m_emply_marital, m_emply_ktp, m_emply_add, m_emply_start, m_emply_status, m_emply_dept, 
                          a.departemen_id AS "a.departemen_id", b.departemen_nama AS "b.departemen_nama", a.departemen_nama AS "a.departemen_nama",
                          m_emply_educ, m_pendidikan_nama,m_emply_jabatan,m_jabatan_nama,m_emply_job_spec, m_jobspec_pengalaman_std,m_emply_end');
        $this->db->where($cond, NULL, FALSE);
        $this->db->join(self::$table2, 'm_emply_jabatan=m_jabatan_id', 'left');
        $this->db->join(self::$table3.' a', 'm_emply_dept=a.departemen_id', 'left');
        $this->db->join(self::$table3.' b', 'a.departemen_induk = b.departemen_id', 'left');
        $this->db->join(self::$table4, 'm_emply_job_spec=m_jobspec_id', 'left');
        $this->db->join(self::$table6, 'm_emply_educ=m_pendidikan_id', 'left');    
        $total  = $this->db->count_all_results(self::$table);
        
        
        $this->db->select('m_emply_nik, m_emply_name, m_emply_sex, m_emply_bop, m_emply_bod, m_emply_relig, 
                          m_emply_marital, m_emply_ktp, m_emply_add, m_emply_start, m_emply_status, m_emply_dept,
                          a.departemen_id AS "a.departemen_id", b.departemen_nama AS "b.departemen_nama", a.departemen_nama AS "a.departemen_nama",
                          m_emply_educ,m_pendidikan_nama,m_emply_jabatan, m_jabatan_nama, m_emply_job_spec, m_jobspec_pengalaman_std,m_emply_end');
        $this->db->where($cond, NULL, FALSE);
        $this->db->join(self::$table2, 'm_emply_jabatan=m_jabatan_id', 'left');
        $this->db->join(self::$table3.' a', 'm_emply_dept=a.departemen_id', 'left');
        $this->db->join(self::$table3.' b', 'a.departemen_induk = b.departemen_id', 'left');
        $this->db->join(self::$table4, 'm_emply_job_spec=m_jobspec_id', 'left');
        $this->db->join(self::$table6, 'm_emply_educ=m_pendidikan_id', 'left');
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
        
 function create($m_emply_nik,$m_emply_name,$m_emply_sex,$m_emply_bop,$m_emply_bod,$m_emply_relig,$m_emply_marital,
                 $m_emply_ktp,$m_emply_add,$m_emply_city,$m_emply_zip,$m_emply_cell,$m_emply_start,$m_emply_status,$m_emply_dept,
                 $m_emply_educ, $m_emply_jabatan,$m_emply_job_spec,$m_emply_end){
        $query = $this->db->insert(self::$table,array(
            'm_emply_nik'             => $m_emply_nik,
            'm_emply_name'            => $m_emply_name,
            'm_emply_sex'             => $m_emply_sex,
            'm_emply_bop'             => $m_emply_bop,
            'm_emply_bod'             => $m_emply_bod,
            'm_emply_relig'           => $m_emply_relig,
            'm_emply_marital'         => $m_emply_marital,
            'm_emply_ktp'             => $m_emply_ktp,
            'm_emply_add'             => $m_emply_add,
            'm_emply_city'            => $m_emply_city,
            'm_emply_zip'             => $m_emply_zip,
            'm_emply_cell'            => $m_emply_cell,
            'm_emply_start'           => $m_emply_start,
            'm_emply_status'          => $m_emply_status,
            'm_emply_dept'            => $m_emply_dept,
            'm_emply_educ'            => $m_emply_educ,
            'm_emply_jabatan'         => $m_emply_jabatan,
            'm_emply_job_spec'        => $m_emply_job_spec,
            'm_emply_end'             => $m_emply_end
            
        ));

        $this->db->insert(self::$table, array(
            'm_emply_nik'             => $m_emply_nik,
            'm_emply_name'            => $m_emply_name,

        ));

        if($query){
            return json_encode(array('success'=>true,'test'=>'50'));
        }
        else{
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
 function update($m_emply_nik,$m_emply_name,$m_emply_sex,$m_emply_bop,$m_emply_bod,$m_emply_relig,$m_emply_marital,
                 $m_emply_ktp,$m_emply_add,$m_emply_city,$m_emply_zip,$m_emply_cell,$m_emply_start,$m_emply_status,$m_emply_dept,
                 $m_emply_educ, $m_emply_jabatan,$m_emply_job_spec,$m_emply_end)
    {
        $this->db->where('m_emply_nik', $m_emply_nik);
        $query = $this->db->update(self::$table,array(
            'm_emply_name'            => $m_emply_name,
            'm_emply_sex'             => $m_emply_sex,
            'm_emply_bop'             => $m_emply_bop,
            'm_emply_bod'             => $m_emply_bod,
            'm_emply_relig'           => $m_emply_relig,
            'm_emply_marital'         => $m_emply_marital,
            'm_emply_ktp'             => $m_emply_ktp,
            'm_emply_add'             => $m_emply_add,
            'm_emply_city'            => $m_emply_city,
            'm_emply_zip'             => $m_emply_zip,
            'm_emply_cell'            => $m_emply_cell,
            'm_emply_start'           => $m_emply_start,
            'm_emply_status'          => $m_emply_status,
            'm_emply_dept'            => $m_emply_dept,
            'm_emply_educ'            => $m_emply_educ,
            'm_emply_jabatan'         => $m_emply_jabatan,
            'm_emply_job_spec'        => $m_emply_job_spec,
            'm_emply_end'             => $m_emply_end
            
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
    
 function delete($m_emply_nik)
    {
        $query = $this->db->delete(self::$table, array('m_emply_nik' => $m_emply_nik));
        if($query)
        {
            return json_encode(array('success'=>true));
        }
        else
        {
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
 function getJab()
    {
        $this->db->select('m_jabatan_id, m_jabatan_nama', NULL);
        $query  = $this->db->get(self::$table2);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
function getExp($q)
    {
        
        $this->db->select('m_jobspec_id, m_jobspec_nama, departemen_nama,m_jobspec_educ_std,m_jobspec_pengalaman_std', NULL);
        $this->db->join(self::$table3, 'm_jobspec_dept=departemen_id', 'left');
        $this->db->like('m_jobspec_nama', $q);
        $query  = $this->db->get(self::$table4);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }  

  function getBag()
    {        
        $this->db->select('a.departemen_id as departemen_id, b.departemen_nama as departemen_idk, a.departemen_nama as departemen_nama');
        $this->db->join(self::$table3.' b', 'a.departemen_induk = b.departemen_id', 'left');
        $this->db->where('a.departemen_induk > 0');
        $this->db->order_by('a.departemen_induk', 'asc')
                 ->order_by('a.departemen_nama', 'asc');
        $query  = $this->db->get(self::$table3.' a');
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }

    
    function upload($m_emply_nik,$imgu){
        $query = $this->db->insert(self::$table5,array(     
            'm_emply_image_id'           => $m_emply_nik,
            'm_emply_image_img'          => $imgu
            
        ));
        
        if($query){
            return json_encode(array('success'=>true,'test'=>'50'));
        }
        else{
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
    function viewImage($id)
    {        
        $this->db->select('m_emply_image_img');
        $this->db->where('m_emply_image_id', $id);
        $query = $this->db->get(self::$table5);
        $row = $query->row();
        if($row){
            return json_encode(array('success'=>true,'img'=>$row->m_emply_image_img));
        }
        else{
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
    
    function deleteImage($m_emply_nik)
    {
        $query = $this->db->delete(self::$table5, array('m_emply_image_id' => $m_emply_nik));
        if($query)
        {
            return json_encode(array('success'=>true));
        }
        else
        {
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
     function getEduc()
    {
        $this->db->select('m_pendidikan_id, m_pendidikan_nama', NULL);
        $query  = $this->db->get(self::$table6);
                   
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
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class Pkwt_model extends CI_Model
{    
    static $table = 'pkwt';
    static $table3 = 'departemen';
    static $table4 = 'm_emply';
    static $table5 = ' m_jabatan';
	
    public function __construct() {
        parent::__construct();
        $this->load->helper('database');
    }

    public function getJson()
    {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 'pkwt_id';
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
        
        $this->db->join('m_emply', 'pkwt.pkwt_nik = m_emply.m_emply_nik', 'left')
                 ->join('departemen', 'pkwt.pkwt_dept = departemen.departemen_id', 'left')
                 ->join('m_jabatan', 'pkwt.pkwt_post = m_jabatan.m_jabatan_id', 'left');
        $this->db->where($cond, NULL, FALSE);
        $this->db->from(self::$table);
        $total  = $this->db->count_all_results();
       
      
        $this->db->join('m_emply', 'pkwt.pkwt_nik = m_emply.m_emply_nik', 'left')
                 ->join('departemen', 'pkwt.pkwt_dept = departemen.departemen_id', 'left')
                 ->join('m_jabatan', 'pkwt.pkwt_post = m_jabatan.m_jabatan_id', 'left');
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
	$result['total'] = $total;
	$result['rows'] = $data;
        
        return json_encode($result);          
    }
    
    public function getPkwtBeforeData($pkwt_id)
    {   
        $this->db->select('pkwt.*, m_emply.m_emply_name, departemen.departemen_nama, post.post_name');
        $this->db->join('m_emply', 'pkwt.pkwt_nik = m+emply.m_emply_nik', 'left')
                 ->join('dept', 'pkwt.pkwt_dept = dept.dept_id', 'left');
                 //->join('post', 'pkwt.pkwt_post = post.post_id', 'left');
        $this->db->where('pkwt_id', $pkwt_id);
        $query  = $this->db->get(self::$table);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
    
    public function create()
    {
        $pecah      = explode('-', $this->input->post('pkwt_start',true));
        $th         = $pecah[0];
        $bl         = $pecah[1];
        $tg         = $pecah[2]; 
                
        $jangka = $this->input->post('pkwt_period',true);
        $akhir = date( 'Y-m-d', mktime(0, 0, 0, $bl + $jangka, $tg - 1, $th));
        
        return $this->db->insert(self::$table,array(
            'pkwt_id'=>$this->input->post('pkwt_id',true),
            'pkwt_kk'=>$this->input->post('pkwt_kk',true),
            'pkwt_nik'=>$this->input->post('pkwt_nik',true),
            'pkwt_dept'=>$this->input->post('pkwt_dept',true),
            'pkwt_post'=>$this->input->post('pkwt_post',true),
            'pkwt_status'=>$this->input->post('pkwt_status',true),
            'pkwt_start'=>$this->input->post('pkwt_start',true),
            'pkwt_period'=>$this->input->post('pkwt_period',true),
            'pkwt_end'=>$akhir,
            'pkwt_salary'=>$this->input->post('pkwt_salary',true),
            'pkwt_spc_salary'=>$this->input->post('pkwt_spc_salary',true),
            'pkwt_sign'=>$this->input->post('pkwt_sign',true),
            'pkwt_before'=>$this->input->post('pkwt_before',true),
            'pkwt_process'=>$this->input->post('pkwt_process',true),
            'pkwt_manual'=>$this->input->post('pkwt_manual',true)
        ));
    }
    
    public function update($pkwt_id)
    {
        $pecah      = explode('-', $this->input->post('pkwt_start',true));
        $th         = $pecah[0];
        $bl         = $pecah[1];
        $tg         = $pecah[2]; 
                
        $jangka = $this->input->post('pkwt_period',true);
        $akhir = date( 'Y-m-d', mktime(0, 0, 0, $bl + $jangka, $tg - 1, $th));
        
        $this->db->where('pkwt_id', $pkwt_id);
        return $this->db->update(self::$table,array(
            'pkwt_kk'=>$this->input->post('pkwt_kk',true),
            'pkwt_nik'=>$this->input->post('pkwt_nik',true),
            'pkwt_dept'=>$this->input->post('pkwt_dept',true),
            'pkwt_post'=>$this->input->post('pkwt_post',true),
            'pkwt_status'=>$this->input->post('pkwt_status',true),
            'pkwt_start'=>$this->input->post('pkwt_start',true),
            'pkwt_period'=>$this->input->post('pkwt_period',true),
            'pkwt_end'=>$akhir,
            'pkwt_salary'=>$this->input->post('pkwt_salary',true),
            'pkwt_spc_salary'=>$this->input->post('pkwt_spc_salary',true),
            'pkwt_sign'=>$this->input->post('pkwt_sign',true),
            'pkwt_before'=>$this->input->post('pkwt_before',true),
            'pkwt_process'=>$this->input->post('pkwt_process',true),
            'pkwt_manual'=>$this->input->post('pkwt_manual',true)
        ));
    }
    
    public function updatePkwtBefore()
    {
        $proc = 'Y';
        $pkwt_before = $this->input->post('pkwt_before',true);
        $this->db->where('pkwt_id', $pkwt_before);
        return $this->db->update(self::$table,array(
            'pkwt_process'=>$proc
        ));
    }

    public function delete($pkwt_id)
    {
        return $this->db->delete(self::$table, array('pkwt_id' => $pkwt_id)); 
    }
    
    public function enumField($table, $field)
    {
        $enums = field_enums($table, $field);
        return json_encode($enums);
    }



     function getEmply($q)
    {
        $this->db->select('m_emply_nik, m_emply_name');
        $this->db->like('m_emply_name', $q);
        $query  = $this->db->get('m_emply');

        $data = array();
        foreach ($query->result() as $row) {
            array_push($data, $row);
        }
        return json_encode($data);
    }
    
    

    function getDept()
    {
        $this->db->select('a.departemen_id as departemen_id, b.departemen_nama as departemen_idk, a.departemen_nama as departemen_nama');
        $this->db->join(self::$table3 . ' b', 'a.departemen_induk = b.departemen_id', 'left');
        $this->db->where('a.departemen_induk > 0');
        $this->db->order_by('a.departemen_induk', 'asc')
        ->order_by('a.departemen_nama', 'asc');
        $query  = $this->db->get(self::$table3 . ' a');

        $data = array();
        foreach ($query->result() as $row) {
            array_push($data, $row);
        }
        return json_encode($data);
    }
    
    public function getJab()
    {    
        $this->db->order_by('m_jabatan_nama', 'asc');
        $query  = $this->db->get('m_jabatan');
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }

    public function getSalary()
    {    
        $query  = $this->db->get('salary');
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
    
    public function getPkwtBefore()
    {   
        $this->db->select('p.pkwt_id AS pkwt_id, e.m_emply_name AS m_emply_name');
        $this->db->join('m_emply e', 'p.pkwt_nik = e.m_emply_nik', 'left');
        //$this->db->where('p.pkwt_before = 0')
        $this->db->where('p.pkwt_process = "N"')
                ->where('p.pkwt_kk != "II"');
        
        $query  = $this->db->get('pkwt p');
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }
    
    public function get_pkwt_by_id($pkwt_id)
    {
        $this->db->select('m_emply.*, workday.*, salary.*, m_jabatan.*,
                           p.pkwt_id AS pkwt_id, p.pkwt_kk AS pkwt_kk, p.pkwt_sign AS pkwt_sign, p.pkwt_start AS pkwt_start, p.pkwt_end AS pkwt_end,
                           p1.pkwt_id AS id_1, p1.pkwt_sign AS sign_1, p1.pkwt_start AS start_1, p1.pkwt_end AS end_1, p1.pkwt_manual AS manual_1,
                           p2.pkwt_id AS id_2, p2.pkwt_sign AS sign_2, p2.pkwt_start AS start_2, p2.pkwt_end AS end_2, p2.pkwt_manual AS manual_2,
                           p.pkwt_status AS pkwt_status, p.pkwt_process AS pkwt_process, p.pkwt_spc_salary AS pkwt_spc_salary, p.pkwt_post AS pkwt_post,
                           departemen.departemen_nama AS dept_name,departemen2.departemen_nama AS departemen');
        $this->db->join('m_emply','m_emply_nik=p.pkwt_nik','left')
                 ->join('departemen', 'p.pkwt_dept=departemen_id','left')
                 ->join('workday','departemen_workday=workday_id','left')
                 ->join('salary','p.pkwt_salary=salary_id','left')
                 ->join('m_jabatan', 'p.pkwt_post=m_jabatan_id','left')
                 ->join('pkwt p1','p.pkwt_before=p1.pkwt_id','left')
                 ->join('pkwt p2','p1.pkwt_before=p2.pkwt_id','left')
                 ->join('departemen departemen2', 'departemen.departemen_induk=departemen2.departemen_id','left');
        $this->db->where('p.pkwt_id',$pkwt_id);
        return $this->db->get('pkwt p');
    }



     

    function UpdateTglSurat($pkwt_id, $tgl_tandatangan, $tgl_terbit)
    {
        $this->db->where('pkwt_id', $pkwt_id);
        $query = $this->db->update(self::$table, array(
            'pkwt_tgl_suratp3'      => $tgl_tandatangan,
            'pkwt_tgl_terbit'            => $tgl_terbit

        ));
        if ($query) {
            return json_encode(array('success' => true, 'pkwt_id' => $pkwt_id));
        } else {
            return json_encode(array('success' => false, 'error' => $this->db->_error_message()));
        }
    }

    function CetakSuratP3($pkwt_id)
    {
        $this->db->select('pkwt_id, m_emply_nik, m_emply_name,pkwt_kk, pkwt_sign, pkwt_end, pkwt_tgl_suratp3, pkwt_tgl_terbit');
        $this->db->where('pkwt_id', $pkwt_id);
        $this->db->join(self::$table4, 'm_emply_nik=pkwt_nik', 'left');
        return $this->db->get('pkwt');
    }

    function UpdateStatusKaryawan($pkwt_id, $tgl_berlaku, $tgl_buat)
    {
     
        $this->db->select('pkwt_id, pkwt_nik, m_emply_status');
        $this->db->join(self::$table4, 'pkwt_nik=m_emply_nik', 'left');
        $this->db->where('pkwt_id', $pkwt_id);
        $query  = $this->db->get(self::$table);

        if ($query) {
                 $this->db->update(self::$table, array(
                'pkwt_tgl_berlaku_sk'           => $tgl_berlaku,
                'pkwt_tgl_buat_sk'              => $tgl_buat

            ));
                $this->db->update(self::$table4, array(
                    'm_emply_status'           => 'Tetap'
                )); 

            return json_encode(array('success' => true, 'pkwt_id' => $pkwt_id));
        }
         else {
            return json_encode(array('success' => false, 'error' => $this->db->_error_message()));
        }
    }

    function CetakSK($pkwt_id)
    {
        $this->db->select('pkwt_id, m_emply_nik, m_emply_name,pkwt_kk, pkwt_sign, pkwt_end, pkwt_tgl_suratp3, pkwt_tgl_terbit,
                           m_emply_add, pkwt_tgl_berlaku_sk, m_jabatan_nama, pkwt_tgl_buat_sk,
                           departemen.departemen_nama AS dept_name,departemen2.departemen_nama AS departemen');
        $this->db->join('m_emply', 'm_emply_nik=p.pkwt_nik', 'left')
        ->join('departemen', 'p.pkwt_dept=departemen_id', 'left')
        ->join('m_jabatan', 'p.pkwt_post=m_jabatan_id', 'left')
        ->join('departemen departemen2', 'departemen.departemen_induk=departemen2.departemen_id', 'left');
        $this->db->where('pkwt_id', $pkwt_id);
        return $this->db->get('pkwt p');
    }

    

}
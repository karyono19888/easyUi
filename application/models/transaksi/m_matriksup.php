<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class M_matriksup extends CI_Model
{    
    static $table1 = 't_evaluasi'; 
    static $table2 = 'm_emply';
    static $table3 = 'departemen';
    static $table4 = 'm_jabatan';
    static $table5 = 'm_standar_nilai';
    static $table6 = 'm_materi';
     
    public function __construct() {
        parent::__construct();
      //  $this->load->helper('database'); // Digunakan untuk memunculkan data Enum
    }

    function index()
    {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 't_evaluasi_id';
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
        $this->db->join(self::$table2, 't_evaluasi_peserta=m_emply_nik', 'left');
        $this->db->join(self::$table3, 'm_emply_dept=departemen_id', 'left');
        $this->db->join(self::$table4, 'm_emply_jabatan=m_jabatan_id', 'left');
        $this->db->join(self::$table5, 'm_jabatan_grade=m_standar_nilai_grade', 'left');
        $this->db->join(self::$table6, 't_evaluasi_materi=m_materi_no', 'left');
        $total  = $this->db->count_all_results(self::$table1);
        
        $this->db->select('*');
        $this->db->where($cond, NULL, FALSE);
        $this->db->join(self::$table2, 't_evaluasi_peserta=m_emply_nik', 'left');
        $this->db->join(self::$table3, 'm_emply_dept=departemen_id', 'left');
        $this->db->join(self::$table4, 'm_emply_jabatan=m_jabatan_id', 'left');
        $this->db->join(self::$table5, 'm_jabatan_grade=m_standar_nilai_grade', 'left');
        $this->db->join(self::$table6, 't_evaluasi_materi=m_materi_no', 'left');
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
        
    function create($t_matriksup_peserta,$t_matriksup_tgl_pelatihan,$t_matriksup_tgl_test_tertulis,$t_matriksup_materi,$t_matriksup_peningkatan_kinerja){
        $query = $this->db->insert(self::$table1,array(
            't_evaluasi_peserta'                => $t_matriksup_peserta,
            't_evaluasi_tgl_pelatihan'          => $t_matriksup_tgl_pelatihan,
            't_evaluasi_tgl_test_tertulis'      => $t_matriksup_tgl_test_tertulis,
            't_evaluasi_materi'                 => $t_matriksup_materi,
            't_evaluasi_peningkatan_kinerja'    => $t_matriksup_peningkatan_kinerja

        ));
        
        if($query){
            return json_encode(array('success'=>true,'test'=>'50'));
        }
        else{
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
      function update($t_evaluasi_id,$t_evaluasi_tgl_pelatihan,$t_evaluasi_tgl_test_tertulis,$t_evaluasi_peningkatan_kinerja)
    {
        $this->db->where('t_evaluasi_id', $t_evaluasi_id);
        $query = $this->db->update(self::$table1,array(
            't_evaluasi_tgl_pelatihan'          => $t_evaluasi_tgl_pelatihan,
            't_evaluasi_tgl_test_tertulis'      => $t_evaluasi_tgl_test_tertulis,
            't_evaluasi_peningkatan_kinerja'    => $t_evaluasi_peningkatan_kinerja
            
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
    
    function delete($t_evaluasi_id)
    {
        $query = $this->db->delete(self::$table1, array('t_evaluasi_id' => $t_evaluasi_id));
        if($query)
        {
            return json_encode(array('success'=>true));
        }
        else
        {
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
   function getKar()
    {
        $this->db->select('m_emply_nik, m_emply_name');
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
        $this->db->select('m_materi_no, m_materi_nama');
        $query  = $this->db->get(self::$table6);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    } 
    
   function EvaCheck($m_emply_nik) {
        $this->db->select('departemen_nama, m_jabatan_nama, m_standar_nilai_min');
        $this->db->join(self::$table3, 'm_emply_dept=departemen_id', 'left');
        $this->db->join(self::$table4, 'm_emply_jabatan=m_jabatan_id', 'left');
        $this->db->join(self::$table5, 'm_jabatan_grade=m_standar_nilai_grade', 'left');
        $this->db->where('m_emply_nik',$m_emply_nik);
        $query_1  = $this->db->get(self::$table2);
        $row_1 = $query_1->row();
        if($row_1){
            echo json_encode(array('berhasil'=>true,'departemen_nama'=>$row_1->departemen_nama,'m_jabatan_nama'=>$row_1->m_jabatan_nama,'m_standar_nilai_min'=>$row_1->m_standar_nilai_min));
        }
        else{
            echo json_encode(array('berhasil'=>false,'error'=>'Lot tidak ditemukan'));
        }
    }
    
  
}

/* End of file m_pesertakpd.php */
/* Location: ./application/models/master/m_pesertakpd.php */
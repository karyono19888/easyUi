<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class M_schedule extends CI_Model
{    
    static $table  = 't_schedule';
    static $table2 = 't_proposal';
    static $table3 = 'departemen';
    static $table4 = 'm_materi';
    static $table5 = 'm_emply';
    static $table6 = 'm_tempat';
    static $table7 = 't_evaluasi';
     
    public function __construct() {
        parent::__construct();
      //  $this->load->helper('database'); // Digunakan untuk memunculkan data Enum
    }

 function index()
    {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 't_schedule_id';
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
        $this->db->join(self::$table6, 't_schedule_tempat=m_tempat_id', 'left');     // Join Ke tabel tempat
        $this->db->join(self::$table2, 't_schedule_proposal=t_proposal_id', 'left'); //join ke tabel proposal
        $this->db->join(self::$table3, 't_proposal_dept=departemen_id', 'left');     //Join ke tabel departemen
        $this->db->join(self::$table4, 't_proposal_materi=m_materi_no', 'left');     //Join ke tabel materi
        $this->db->join(self::$table5, 't_proposal_peserta=m_emply_nik', 'left');     // Join Ke tabel m_emply
        $total  = $this->db->count_all_results(self::$table);
        
        $this->db->select('*');
        $this->db->where($cond, NULL, FALSE);
        $this->db->join(self::$table6, 't_schedule_tempat=m_tempat_id', 'left');     // Join Ke tabel tempat
        $this->db->join(self::$table2, 't_schedule_proposal=t_proposal_id', 'left'); //join ke tabel proposal
        $this->db->join(self::$table3, 't_proposal_dept=departemen_id', 'left');     //Join ke tabel departemen
        $this->db->join(self::$table4, 't_proposal_materi=m_materi_no', 'left');     //Join ke tabel materi
        $this->db->join(self::$table5, 't_proposal_peserta=m_emply_nik', 'left');     // Join Ke tabel m_emply
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
        
  function create($t_schedule_tgl,$t_schedule_waktu_dari,$t_schedule_waktu_sampai,$t_schedule_tgl2,
                    $t_schedule_waktu_dari2,$t_schedule_waktu_sampai2,$t_schedule_tempat,$t_schedule_proposal){
        $query = $this->db->insert(self::$table,array(
            't_schedule_tgl'            => $t_schedule_tgl,
            't_schedule_waktu_dari'     => $t_schedule_waktu_dari,
            't_schedule_waktu_sampai'   => $t_schedule_waktu_sampai,
            't_schedule_tgl2'            => $t_schedule_tgl2,
            't_schedule_waktu_dari2'     => $t_schedule_waktu_dari2,
            't_schedule_waktu_sampai2'   => $t_schedule_waktu_sampai2,
            't_schedule_tempat'         => $t_schedule_tempat,
            't_schedule_proposal'       => $t_schedule_proposal
        ));
        
        if($query){
            $this->db->where('t_proposal_id', $t_schedule_proposal);
            $query2 = $this->db->update(self::$table2,array(
            't_proposal_status'            => 1,            
            ));
            if($query2){
                return json_encode(array('success'=>true));
            }
            else {
                return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
            }
        }
        else{
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
  function update($t_schedule_id,$t_schedule_tgl,$t_schedule_waktu_dari,$t_schedule_waktu_sampai,$t_schedule_tgl2,
                      $t_schedule_waktu_dari2,$t_schedule_waktu_sampai2,$t_schedule_tempat)
      {
        $this->db->where('t_schedule_id', $t_schedule_id);
        $query = $this->db->update(self::$table,array(
            't_schedule_tgl'            => $t_schedule_tgl,
            't_schedule_waktu_dari'     => $t_schedule_waktu_dari,
            't_schedule_waktu_sampai'   => $t_schedule_waktu_sampai,
            't_schedule_tgl2'            => $t_schedule_tgl2,
            't_schedule_waktu_dari2'     => $t_schedule_waktu_dari2,
            't_schedule_waktu_sampai2'   => $t_schedule_waktu_sampai2,
            't_schedule_tempat'         => $t_schedule_tempat
            
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
    
  function delete($t_schedule_id,$t_schedule_proposal)
    {
         $this->db->where('t_proposal_id', $t_schedule_proposal);
         $query = $this->db->update(self::$table2, array(
            't_proposal_status'            => 0
             ));
         
         if($query){
            $query2 = $this->db->delete(self::$table, array('t_schedule_id' => $t_schedule_id));
            if($query2){
                return json_encode(array('success'=>true));
            }
            else {
                return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
            }
        }
        else
        {
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
    
  function getTemp()
    {
        $this->db->select('m_tempat_id, m_tempat_nama', NULL);
        $query  = $this->db->get(self::$table6);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    }    
    
  function getProposal($q)
    {
      
        $this->db->select('m_emply_nik, t_proposal_id, t_proposal_instruktur,m_materi_nama,m_emply_name,departemen_nama', NULL);
        $this->db->where('t_proposal_status', 0);
        $this->db->join(self::$table3, 't_proposal_dept=departemen_id', 'left');     //Join ke tabel departemen
        $this->db->join(self::$table4, 't_proposal_materi=m_materi_no', 'left');     //Join ke tabel materi
        $this->db->join(self::$table5, 't_proposal_peserta=m_emply_nik', 'left');     // Join Ke tabel m_emply
        $this->db->like('m_emply_name', $q);
        $query  = $this->db->get(self::$table2);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    } 
    
    function createeval($t_schedule_id, $m_emply_nik, $m_materi_no, $t_evaluasi_tgl_pelatihan,$t_evaluasi_tgl_test_tertulis,$t_evaluasi_pengetahuan_materi,
                $t_evaluasi_penerapan_lap,$t_evaluasi_peningkatan_kinerja,$t_evaluasi_keterangan){
        $query1 = $this->db->insert(self::$table7,array(
            't_evaluasi_peserta'                => $m_emply_nik,
            't_evaluasi_materi'                 => $m_materi_no,
            't_evaluasi_tgl_pelatihan'          => $t_evaluasi_tgl_pelatihan,
            't_evaluasi_tgl_test_tertulis'      => $t_evaluasi_tgl_test_tertulis,
            't_evaluasi_pengetahuan_materi'     => $t_evaluasi_pengetahuan_materi,
            't_evaluasi_penerapan_lap'          => $t_evaluasi_penerapan_lap,
            't_evaluasi_peningkatan_kinerja'    => $t_evaluasi_peningkatan_kinerja,
            't_evaluasi_keterangan'             => $t_evaluasi_keterangan
        ));
        
        if($query1){
            $this->db->where('t_schedule_id', $t_schedule_id);
            $query2 = $this->db->update(self::$table,array(
            't_schedule_aktual'            => $t_evaluasi_tgl_pelatihan            
            ));
            if($query2){
                return json_encode(array('success'=>true));
            }
            else {
                return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
            }
        }
        else{
            return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
        }
    }
}

/* End of file m_pesertakpd.php */
/* Location: ./application/models/master/m_pesertakpd.php */
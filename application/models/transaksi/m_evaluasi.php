<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
 
class M_evaluasi extends CI_Model
{    
    static $table  = 't_schedule';
    static $table2 = 't_proposal';
    static $table3 = 'departemen';
    static $table4 = 'm_materi';
    static $table5 = 'm_emply';
    static $table6 = 'm_tempat';
    static $table7 = 'm_jabatan';
    static $table8 = 'm_std_nilai_pelatihan';
    static $table9 = 't_evaluasi';
    static $table10 = 'view_t_evaluasi';
	static $table11 = 't_educ_experience';
	static $table12 = 'm_standar_nilai';
     
    public function __construct() {
        parent::__construct();
      //  $this->load->helper('database'); // Digunakan untuk memunculkan data Enum
    }
    
    function index2() {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 't_evaluasi_tgl_test_tertulis';
        $order  = isset($_POST['order']) ? strval($_POST['order']) : 'desc';

        $filterRules = isset($_POST['filterRules']) ? ($_POST['filterRules']) : '';
        $cond = '1=1';
        if (!empty($filterRules)){
            $filterRules = json_decode($filterRules);
            foreach($filterRules as $rule){
                $rule   = get_object_vars($rule);
                $field  = $rule['field'];
                $op     = $rule['op'];
                $value  = $rule['value'];
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
      //  $this->db->join(self::$table5, 't_evaluasi_peserta=m_emply_nik', 'left');
      //  $this->db->join(self::$table7, 'm_emply_jabatan=m_jabatan_id', 'left');
      //  $this->db->join(self::$table3, 'm_emply_dept=departemen_id', 'left');
      //  $this->db->join(self::$table8, 'departemen_id=m_std_nilai_pelatihan_bag AND m_jabatan_id=m_std_nilai_pelatihan_jab AND t_evaluasi_materi=m_std_nilai_pelatihan_materi', 'left');
      //  $this->db->join(self::$table12, 'm_std_nilai_pelatihan_nilai=m_standar_nilai_min', 'left');
        $resrow = $this->db->get(self::$table10);
        $total  = $resrow->num_rows();

        $this->db->select('*');
        $this->db->where($cond, NULL, FALSE);
      //  $this->db->join(self::$table5, 't_evaluasi_peserta=m_emply_nik', 'left');
      //  $this->db->join(self::$table7, 'm_emply_jabatan=m_jabatan_id', 'left');
     //   $this->db->join(self::$table3, 'm_emply_dept=departemen_id', 'left');
     //   $this->db->join(self::$table8, 'departemen_id=m_std_nilai_pelatihan_bag AND m_jabatan_id=m_std_nilai_pelatihan_jab AND t_evaluasi_materi=m_std_nilai_pelatihan_materi', 'left');
    //    $this->db->join(self::$table12, 'm_std_nilai_pelatihan_nilai=m_standar_nilai_min', 'left');
    //    $this->db->order_by($sort, $order);
        $this->db->limit($rows, $offset);
        $query  = $this->db->get(self::$table10);
        
        $result = array();
	$result['total'] = $total->num_rows();
	$result['rows']  = $data;
        
        return json_encode($result);
    }
    
    function index() {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page-1)*$rows;      
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 't_evaluasi_tgl_test_tertulis';
        $order  = isset($_POST['order']) ? strval($_POST['order']) : 'desc';

        $filterRules = isset($_POST['filterRules']) ? ($_POST['filterRules']) : '';
        $cond = '1=1';
        if (!empty($filterRules)){
            $filterRules = json_decode($filterRules);
            foreach($filterRules as $rule){
                $rule   = get_object_vars($rule);
                $field  = $rule['field'];
                $op     = $rule['op'];
                $value  = $rule['value'];
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
        $total  = $this->db->count_all_results(self::$table10);
        
        $this->db->select('*');
        $this->db->where($cond, NULL, FALSE);
        $this->db->order_by($sort, $order);
        $this->db->limit($rows, $offset);
        $query  = $this->db->get(self::$table10);
                   
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
    
      function update($t_evaluasi_id,$t_evaluasi_pengetahuan_materi,$t_evaluasi_penerapan_lap,
                                   $t_evaluasi_peningkatan_kinerja,$t_evaluasi_keterangan)
    {
        $this->db->where('t_evaluasi_id', $t_evaluasi_id);
        $query = $this->db->update(self::$table9,array(
            't_evaluasi_pengetahuan_materi'     => $t_evaluasi_pengetahuan_materi,
            't_evaluasi_penerapan_lap'          => $t_evaluasi_penerapan_lap,
            't_evaluasi_peningkatan_kinerja'    => $t_evaluasi_peningkatan_kinerja,
            't_evaluasi_keterangan'             => $t_evaluasi_keterangan
            
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
	
	
    function tutuptahun($tahun)
    {
        $before = $tahun - 1;
        $this->db->select('*');
        $this->db->where('YEAR(t_evaluasi_tgl_pelatihan)', $before);
        $query_1    = $this->db->get(self::$table9);
        if ($query_1->num_rows()) {
            foreach ($query_1->result() as $row_1) {
                $this->db->select('*');
                $this->db->where('t_evaluasi_peserta', $row_1->t_evaluasi_peserta)
                    ->where('t_evaluasi_materi', $row_1->t_evaluasi_materi)
                    ->where('YEAR(t_evaluasi_tgl_pelatihan)', $tahun);
                $query_2    = $this->db->get(self::$table9);
                if (!$query_2->num_rows()) {
                    $this->db->insert(self::$table9, array(
                        't_evaluasi_peserta'                => $row_1->t_evaluasi_peserta,
                        't_evaluasi_materi'                 => $row_1->t_evaluasi_materi,
                        't_evaluasi_tgl_pelatihan'          => $tahun . '-10-31',
                        't_evaluasi_tgl_test_tertulis'      => $tahun . '-10-31',
                        't_evaluasi_pengetahuan_materi'     => $row_1->t_evaluasi_pengetahuan_materi,
                        't_evaluasi_penerapan_lap'          => $row_1->t_evaluasi_penerapan_lap,
                        't_evaluasi_peningkatan_kinerja'    => $row_1->t_evaluasi_peningkatan_kinerja

                    ));
                }
            }

            $this->db->select('*');
            $this->db->where('YEAR(t_educ_experience_tgl_up)', $before);
            $this->db->join(self::$table5, 't_educ_experience_nik=m_emply_nik', 'left');
            $query_3    = $this->db->get(self::$table11);
            if ($query_3->num_rows()) {
                foreach ($query_3->result() as $row_2) {
                    $this->db->select('*');
                    $this->db->where('t_educ_experience_nik', $row_2->t_educ_experience_nik)
                        ->where('YEAR(t_educ_experience_tgl_up)', $tahun);
                    $query_4    = $this->db->get(self::$table11);
                    if (!$query_4->num_rows()) {
                        $this->db->insert(self::$table11, array(
                            't_educ_experience_tgl_up'  => $tahun . '-10-31',
                            't_educ_experience_nik'     => $row_2->t_educ_experience_nik,
                            't_educ_experience_educ'    => $row_2->m_emply_educ,
                            't_educ_experience_exp'     => $this->diffInMonths(date_create($row_2->m_emply_start), date_create($tahun . '-12-31')) //$this->diffInMonths($row_3->m_emply_start, date('Y-m-d'))
                        ));
                    }
                }
            }
            return json_encode(array('success' => true));
        } else {
            return json_encode(array('success' => false, 'error' => $this->db->_error_message()));
        }
    }
   
    
    function diffInMonths(\DateTime $date1, \DateTime $date2){
        $diff =  $date1->diff($date2);
        $months = $diff->y * 12 + $diff->m + $diff->d / 30;
        return (int) round($months); //setelah tanggal 15 maka akan dihitung satu bulan , jika di bawah 15 maka tidak dihitung
    }
    
}

/* End of file m_pesertakpd.php */
/* Location: ./application/models/master/m_pesertakpd.php */
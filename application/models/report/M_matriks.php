<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class M_matriks extends CI_Model
{    
    static $table  = 't_proposal';
    static $table2 = 'departemen';
    static $table3 = 'm_materi';
    static $table4 = 'm_emply';
    static $table5 = 't_schedule';
    static $table6 = 'm_tempat';
    static $table7 = 'm_jabatan';
    static $table8 = 'm_standar_nilai';
    static $table9 = 't_evaluasi';
    static $table10 = 'm_jobs_spec';
    static $table11 = 'm_emply_image';
    static $table12 = 'm_pendidikan';
    
    public function __construct() {
        parent::__construct();
        
    }
          function enumField($table1, $field)
    {
        $enums = field_enums($table1, $field);
        return json_encode($enums);
    }
    

  function cetak($karyawan, $jab, $cetak){
      $tahun = strftime( "%Y", strtotime($cetak));
      $tahunA=$tahun-2;
      $tahunB=$tahun-1;
      $tahunC=$tahun;

      $this->db->select('m_emply_nik,m_emply_image_img,m_emply_name,m_emply_start,a.departemen_id AS departemen_id, b.departemen_nama AS departemen_induk, a.departemen_nama AS bagian,m_jabatan_nama,m_jabatan_id,
                       '.$tahunA.' AS filedA, '.$tahunB.' AS filedB, '.$tahunC.' AS filedC', FALSE);
       $this->db->where('t_evaluasi_peserta', $karyawan)
                ->where('m_jabatan_id', $jab);
       $this->db->join(self::$table4, 't_evaluasi_peserta=m_emply_nik', 'left');
       $this->db->join(self::$table2.' a', 'm_emply_dept=a.departemen_id', 'left');
       $this->db->join(self::$table2.' b', 'a.departemen_induk = b.departemen_id', 'left');
       $this->db->join(self::$table7, 'm_emply_jabatan=m_jabatan_id', 'left');
       $this->db->join(self::$table11,'m_emply_nik=m_emply_image_id', 'left');
       $this->db->group_by('m_emply_name');
       $header = $this->db->get(self::$table9);

      //proses
       $detail = $this->db->query("SELECT m_materi_nama,IFNULL(m_std_nilai_pelatihan_nilai,0) AS m_standar_nilai_min,
                MAX( IF(YEAR(t_evaluasi_tgl_pelatihan)='$tahunA', t_evaluasi_peningkatan_kinerja,0) ) AS A,
                MAX( IF(YEAR(t_evaluasi_tgl_pelatihan)='$tahunB', t_evaluasi_peningkatan_kinerja,0) ) AS B,
                MAX( IF(YEAR(t_evaluasi_tgl_pelatihan)='$tahunC', t_evaluasi_peningkatan_kinerja,0) ) AS C
        FROM (SELECT t_evaluasi.*, CONCAT(m_emply_dept,'-',t_evaluasi_materi,'-',m_emply_jabatan) AS idsa FROM `t_evaluasi`
                LEFT JOIN m_emply ON t_evaluasi.t_evaluasi_peserta=m_emply.m_emply_nik) AS t_evaluasi
        LEFT JOIN m_materi ON t_evaluasi.t_evaluasi_materi=m_materi.m_materi_no
        LEFT JOIN (SELECT `m_std_nilai_pelatihan_id`,`m_std_nilai_pelatihan_nilai`, CONCAT(`m_std_nilai_pelatihan_bag`,'-',`m_std_nilai_pelatihan_materi`,'-',`m_std_nilai_pelatihan_jab`) AS ids FROM `m_std_nilai_pelatihan`) AS m_std_nilai_pelatihan 
                ON t_evaluasi.idsa=m_std_nilai_pelatihan.ids
        WHERE t_evaluasi_peserta='$karyawan'
        GROUP BY t_evaluasi_materi");
       
               
      //Pendidikan Pengalaman

       $exp = $this->db->query("SELECT `t_educ_experience_nik`,m_emply_name,IFNULL(m_jobspec_pengalaman_std,0) AS m_jobspec_pengalaman_min,
                MAX( IF(YEAR(t_educ_experience_tgl_up)='$tahunA', `t_educ_experience_exp`,0) ) AS A,
                MAX( IF(YEAR(t_educ_experience_tgl_up)='$tahunB', `t_educ_experience_exp`,0) ) AS B,
                MAX( IF(YEAR(t_educ_experience_tgl_up)='$tahunC', `t_educ_experience_exp`,0) ) AS C
        FROM  t_educ_experience
        		LEFT JOIN m_emply ON t_educ_experience.t_educ_experience_nik=m_emply.m_emply_nik
                LEFT JOIN m_jobs_spec ON m_emply.m_emply_job_spec=m_jobs_spec.m_jobspec_id
        WHERE t_educ_experience_nik='$karyawan'");
       
       
       $edu = $this->db->query("SELECT a.t_educ_experience_nik AS nik, b.m_emply_name AS nama,IFNULL(f.m_pendidikan_id,0) AS Std_edu,
                MAX( IF(YEAR(t_educ_experience_tgl_up)='$tahunA', e.m_pendidikan_id,0) ) AS A,
                MAX( IF(YEAR(t_educ_experience_tgl_up)='$tahunB', e.m_pendidikan_id,0) ) AS B,
                MAX( IF(YEAR(t_educ_experience_tgl_up)='$tahunC', e.m_pendidikan_id,0) ) AS C
        FROM  t_educ_experience a
        		LEFT JOIN m_pendidikan e ON a.t_educ_experience_educ=e.m_pendidikan_id
        		LEFT JOIN m_emply b ON a.t_educ_experience_nik=b.m_emply_nik
                LEFT JOIN m_jobs_spec c ON b.m_emply_job_spec=c.m_jobspec_id
                LEFT JOIN m_pendidikan f ON c.m_jobspec_educ_std=f.m_pendidikan_id
                LEFT JOIN m_pendidikan d ON b.m_emply_educ=d.m_pendidikan_id
        WHERE a.t_educ_experience_nik='$karyawan'");
       
        
       $tgl = $this->db->query('SELECT "'.$cetak.'" as Tanggal');
       
        $result = array();
	    $result['header']   = $header;
        $result['edu']      = $edu;
        $result['exp']      = $exp;
        $result['detail']   = $detail;
        $result['cetak']    = $tgl;
        return $result;
    }
    
    function getPeserta($q)
    {
        $this->db->select('m_emply_nik, m_emply_name , m_jabatan_id', NULL);
        $this->db->join(self::$table7, 'm_emply_jabatan=m_jabatan_id', 'left');
        $this->db->like('m_emply_name', $q);
        $query  = $this->db->get(self::$table4);
                   
        $data = array();
        foreach ( $query->result() as $row )
        {
            array_push($data, $row); 
        }       
        return json_encode($data);
    } 
    
    function viewImage($id){        
        $this->db->select('m_emply_image_img');
        $this->db->where('m_emply_image_id', $id);
        $query = $this->db->get(self::$table11);
        $row = $query->row();
        if($row){
            //$exploded = explode(';', $row->m_emply_image_img);
           // $mimetype = substr($exploded[0], 5);
            //$data = explode(',', $exploded[1])[1];

          //  header('Content-type: ' . $mimetype);
           // return base64_decode($data);
            return $row->m_emply_image_img;
        }
        //if($row){
         //   return json_encode(array('success'=>true,'img'=>$row->m_emply_image_img));
       // }
       // else{
       //     return json_encode(array('success'=>false,'error'=>$this->db->_error_message()));
       // }
    }
}
?>

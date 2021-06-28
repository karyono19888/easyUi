<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Schedule extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('transaksi/m_schedule','record');
    }
    
   function index()
    {
        $auth       = new Auth();
         // mencegah user yang belum login untuk mengakses halaman ini
        $auth->restrict();
        
        if (isset($_GET['grid']))
        {
            echo $this->record->index();      
        }
        else 
        {
            $this->load->view('transaksi/v_schedule'); 
        }
    } 
    
  function create(){
        $auth       = new Auth();
        $auth->restrict();
        if(!isset($_POST))	
            show_404();
        
        $t_schedule_tgl             = addslashes($_POST['t_schedule_tgl']);
        $t_schedule_waktu_dari      = addslashes($_POST['t_schedule_waktu_dari']);
        $t_schedule_waktu_sampai    = addslashes($_POST['t_schedule_waktu_sampai']);
        $t_schedule_tgl2             = addslashes($_POST['t_schedule_tgl2']);
        $t_schedule_waktu_dari2      = addslashes($_POST['t_schedule_waktu_dari2']);
        $t_schedule_waktu_sampai2    = addslashes($_POST['t_schedule_waktu_sampai2']);
        $t_schedule_tempat          = addslashes($_POST['t_schedule_tempat']);
        $t_schedule_proposal        = addslashes($_POST['t_schedule_proposal']);
                           
        echo $this->record->create($t_schedule_tgl,$t_schedule_waktu_dari,$t_schedule_waktu_sampai,$t_schedule_tgl2,
                                   $t_schedule_waktu_dari2,$t_schedule_waktu_sampai2,$t_schedule_tempat,$t_schedule_proposal);
    }
  function update($t_schedule_id=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $t_schedule_tgl             = addslashes($_POST['t_schedule_tgl']);
        $t_schedule_waktu_dari      = addslashes($_POST['t_schedule_waktu_dari']);
        $t_schedule_waktu_sampai    = addslashes($_POST['t_schedule_waktu_sampai']);
        $t_schedule_tgl2             = addslashes($_POST['t_schedule_tgl2']);
        $t_schedule_waktu_dari2      = addslashes($_POST['t_schedule_waktu_dari2']);
        $t_schedule_waktu_sampai2    = addslashes($_POST['t_schedule_waktu_sampai2']);
        $t_schedule_tempat          = addslashes($_POST['t_schedule_tempat']);
 
        
        echo $this->record->update($t_schedule_id,$t_schedule_tgl,$t_schedule_waktu_dari,$t_schedule_waktu_sampai,$t_schedule_tgl2,
                                   $t_schedule_waktu_dari2,$t_schedule_waktu_sampai2,$t_schedule_tempat);
        
    }
  function delete()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $t_schedule_id          = addslashes($_POST['t_schedule_id']);
        $t_schedule_proposal    = addslashes($_POST['t_schedule_proposal']);
        
        echo $this->record->delete($t_schedule_id,$t_schedule_proposal);
        
    }
    
  function getTemp()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getTemp();
    }  
    
  function getProposal()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        $q = isset($_GET['q']) ? $_GET['q'] : '';
        
        echo $this->record->getProposal($q);
    } 
    
  function createeval($id=null){
        $auth       = new Auth();
        $auth->restrict();
        
        $pecah                  = explode('_', $id);
        $t_schedule_id          = $pecah[0];
        $m_emply_nik            = $pecah[1];
        $m_materi_no            = $pecah[2];
        if(!isset($_POST))	
            show_404();
        
 
        
        $t_evaluasi_tgl_pelatihan           = addslashes($_POST['t_evaluasi_tgl_pelatihan']);
        $t_evaluasi_tgl_test_tertulis       = addslashes($_POST['t_evaluasi_tgl_test_tertulis']);
        $t_evaluasi_pengetahuan_materi      = addslashes($_POST['t_evaluasi_pengetahuan_materi']);
        $t_evaluasi_penerapan_lap           = addslashes($_POST['t_evaluasi_penerapan_lap']);
        $t_evaluasi_peningkatan_kinerja     = addslashes($_POST['t_evaluasi_peningkatan_kinerja']);
        $t_evaluasi_keterangan              = addslashes($_POST['t_evaluasi_keterangan']);
                           
        echo $this->record->createeval($t_schedule_id, $m_emply_nik, $m_materi_no, $t_evaluasi_tgl_pelatihan,$t_evaluasi_tgl_test_tertulis,$t_evaluasi_pengetahuan_materi,
                $t_evaluasi_penerapan_lap,$t_evaluasi_peningkatan_kinerja,$t_evaluasi_keterangan);
    }  
}

/* End of file pesertakpd.php */
/* Location: ./application/controllers/master/pesertakpd.php */
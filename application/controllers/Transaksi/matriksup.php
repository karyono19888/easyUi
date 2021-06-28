<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Matriksup extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('transaksi/m_matriksup','record');
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
            $this->load->view('transaksi/v_matriksup'); 
        }
    } 
    
  function create(){
        $auth       = new Auth();
        $auth->restrict();
        if(!isset($_POST))	
            show_404();
        
        $t_matriksup_peserta                     = addslashes($_POST['t_matriksup_peserta']);
        $t_matriksup_tgl_pelatihan               = addslashes($_POST['t_matriksup_tgl_pelatihan']);
        $t_matriksup_tgl_test_tertulis           = addslashes($_POST['t_matriksup_tgl_test_tertulis']);
        $t_matriksup_materi                      = addslashes($_POST['t_matriksup_materi']);
        $t_matriksup_peningkatan_kinerja         = addslashes($_POST['t_matriksup_peningkatan_kinerja']);
        
                           
        echo $this->record->create($t_matriksup_peserta,$t_matriksup_tgl_pelatihan,$t_matriksup_tgl_test_tertulis,$t_matriksup_materi,$t_matriksup_peningkatan_kinerja);
    }
  function update($t_evaluasi_id=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();
        
        $t_evaluasi_tgl_pelatihan               = addslashes($_POST['t_evaluasi_tgl_pelatihan']);
        $t_evaluasi_tgl_test_tertulis           = addslashes($_POST['t_evaluasi_tgl_test_tertulis']);
        $t_evaluasi_peningkatan_kinerja         = addslashes($_POST['t_evaluasi_peningkatan_kinerja']);
 
        
        echo $this->record->update($t_evaluasi_id,$t_evaluasi_tgl_pelatihan,$t_evaluasi_tgl_test_tertulis,$t_evaluasi_peningkatan_kinerja);
        
    }
  function delete()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $t_evaluasi_id          = addslashes($_POST['t_evaluasi_id']);
        
        echo $this->record->delete($t_evaluasi_id);
        
    }
   function getKar()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getKar();
    } 
    
   function EvaCheck() {        
        if(!isset($_POST))	
            show_404();

        $m_emply_nik = addslashes($_POST['m_emply_nik']);

        echo $this->record->EvaCheck($m_emply_nik);

    }
    
  function getMateri()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getMateri();
    }  
    
  
}

/* End of file pesertakpd.php */
/* Location: ./application/controllers/master/pesertakpd.php */
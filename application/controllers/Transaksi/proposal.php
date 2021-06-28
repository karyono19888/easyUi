<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Proposal extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('transaksi/m_proposal','record');
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
            $this->load->view('transaksi/v_proposal'); 
        }
    } 
    
  function create(){
        $auth       = new Auth();
        $auth->restrict();
        if(!isset($_POST))	
            show_404();
        
        $t_proposal_dept        = addslashes($_POST['t_proposal_dept']);
        $t_proposal_periode     = addslashes($_POST['t_proposal_periode']);
        $t_proposal_tahun       = addslashes($_POST['t_proposal_tahun']);
        $t_proposal_jenis       = addslashes($_POST['t_proposal_jenis']);
        $t_proposal_materi      = addslashes($_POST['t_proposal_materi']);
        $t_proposal_peserta     = addslashes($_POST['t_proposal_peserta']);
        $t_proposal_instruktur  = addslashes($_POST['t_proposal_instruktur']);
        $t_proposal_keterangan  = addslashes($_POST['t_proposal_keterangan']);
        
                           
        echo $this->record->create($t_proposal_dept,$t_proposal_periode,$t_proposal_tahun,$t_proposal_jenis,$t_proposal_materi,$t_proposal_peserta,
                                   $t_proposal_instruktur,$t_proposal_keterangan);
    }
  function update($t_proposal_id=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $t_proposal_dept        = addslashes($_POST['t_proposal_dept']);
        $t_proposal_periode     = addslashes($_POST['t_proposal_periode']);
        $t_proposal_tahun       = addslashes($_POST['t_proposal_tahun']);
        $t_proposal_jenis       = addslashes($_POST['t_proposal_jenis']);
        $t_proposal_materi      = addslashes($_POST['t_proposal_materi']);
        $t_proposal_peserta     = addslashes($_POST['t_proposal_peserta']);
        $t_proposal_instruktur  = addslashes($_POST['t_proposal_instruktur']);
        $t_proposal_keterangan  = addslashes($_POST['t_proposal_keterangan']); 
 
        
        echo $this->record->update($t_proposal_id,$t_proposal_dept,$t_proposal_periode,$t_proposal_tahun,$t_proposal_jenis,$t_proposal_materi,$t_proposal_peserta,
                                   $t_proposal_instruktur,$t_proposal_keterangan);
        
    }
  function delete()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $t_proposal_id          = addslashes($_POST['t_proposal_id']);
        
        echo $this->record->delete($t_proposal_id);
        
    }
    
  function getDept()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getDept();
    }
    
  function getProp()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getProp();
    }  
    
  function getMateri()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getMateri();
    }  
    
  function getPeserta($dept=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        $q = isset($_GET['q']) ? $_GET['q'] : '';
        
        echo $this->record->getPeserta($q, $dept);
    }   
    
  function getPesertaU()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        $q = isset($_GET['q']) ? $_GET['q'] : '';
        
        echo $this->record->getPesertaU($q);
    } 
    
    function getInstruktur() {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getInstruktur();
    } 
}

/* End of file pesertakpd.php */
/* Location: ./application/controllers/master/pesertakpd.php */
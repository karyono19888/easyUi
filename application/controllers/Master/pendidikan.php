<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pendidikan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_pendidikan','record');
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
            $this->load->view('master/v_pendidikan'); 
        }
    } 
    
  function create(){
        $auth       = new Auth();
        $auth->restrict();
        if(!isset($_POST))	
            show_404();
        
        $m_pendidikan_nama      = addslashes($_POST['m_pendidikan_nama']);
        $m_pendidikan_tk        = addslashes($_POST['m_pendidikan_tk']);
        
                           
        echo $this->record->create($m_pendidikan_nama,$m_pendidikan_tk);
    }
  function update($m_pendidikan_id=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_pendidikan_nama      = addslashes($_POST['m_pendidikan_nama']);
        $m_pendidikan_tk        = addslashes($_POST['m_pendidikan_tk']);
 
        
        echo $this->record->update($m_pendidikan_id,$m_pendidikan_nama,$m_pendidikan_tk);
        
    }
  function delete()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_pendidikan_id          = addslashes($_POST['m_pendidikan_id']);
        
        echo $this->record->delete($m_pendidikan_id);
        
    }

    
                
}

/* End of file pesertakpd.php */
/* Location: ./application/controllers/master/pesertakpd.php */
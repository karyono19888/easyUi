<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Materi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_materi','record');
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
            $this->load->view('master/v_materi'); 
        }
    } 
    
    function create(){
        $auth       = new Auth();
        $auth->restrict();
        if(!isset($_POST))	
            show_404();
        
        $m_materi_nama      = addslashes($_POST['m_materi_nama']);
        
                           
        echo $this->record->create($m_materi_nama);
    }
    function update($m_materi_no=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_materi_nama     = addslashes($_POST['m_materi_nama']); 
 
        
        echo $this->record->update($m_materi_no,$m_materi_nama);
        
    }
      function delete()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_materi_no          = addslashes($_POST['m_materi_no']);
        
        echo $this->record->delete($m_materi_no);
        
    }
    
    
                
}

/* End of file pesertakpd.php */
/* Location: ./application/controllers/master/pesertakpd.php */
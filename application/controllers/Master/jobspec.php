<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jobspec extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_jobspec','record');
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
            $this->load->view('master/v_jobspec'); 
        }
    } 
    
    function create(){
        $auth       = new Auth();
        $auth->restrict();
        if(!isset($_POST))	
            show_404();
        
        $m_jobspec_nama             = addslashes($_POST['m_jobspec_nama']);
        $m_jobspec_dept             = addslashes($_POST['m_jobspec_dept']);
        $m_jobspec_educ_std         = addslashes($_POST['m_jobspec_educ_std']);
        $m_jobspec_pengalman_std    = addslashes($_POST['m_jobspec_pengalaman_std']);
        
                           
        echo $this->record->create($m_jobspec_nama,$m_jobspec_dept,$m_jobspec_educ_std,$m_jobspec_pengalman_std);
    }
    
    function update($m_jobspec_id=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_jobspec_nama             = addslashes($_POST['m_jobspec_nama']);
        $m_jobspec_dept             = addslashes($_POST['m_jobspec_dept']);
        $m_jobspec_educ_std         = addslashes($_POST['m_jobspec_educ_std']);
        $m_jobspec_pengalman_std    = addslashes($_POST['m_jobspec_pengalaman_std']);
 
        
        echo $this->record->update($m_jobspec_id,$m_jobspec_nama,$m_jobspec_dept,$m_jobspec_educ_std,$m_jobspec_pengalman_std);
        
    }
      function delete()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_jobspec_id          = addslashes($_POST['m_jobspec_id']);
        
        echo $this->record->delete($m_jobspec_id);
        
    }
    
    function getDept()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getDept();
    }
    
    function getEduc()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getEduc();
    }
    
    
                
}

/* End of file pesertakpd.php */
/* Location: ./application/controllers/master/pesertakpd.php */
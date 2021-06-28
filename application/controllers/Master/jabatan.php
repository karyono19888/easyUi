<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Jabatan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_jabatan','record');
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
            $this->load->view('master/v_jabatan'); 
        }
    } 
    
  function create(){
        $auth       = new Auth();
        $auth->restrict();
        if(!isset($_POST))	
            show_404();
        
        $m_jabatan_nama      = addslashes($_POST['m_jabatan_nama']);
        $m_jabatan_grade      = addslashes($_POST['m_jabatan_grade']);
        
                           
        echo $this->record->create($m_jabatan_nama,$m_jabatan_grade);
    }
  function update($m_jabatan_id=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_jabatan_nama      = addslashes($_POST['m_jabatan_nama']);
        $m_jabatan_grade      = addslashes($_POST['m_jabatan_grade']);
 
        
        echo $this->record->update($m_jabatan_id,$m_jabatan_nama,$m_jabatan_grade);
        
    }
  function delete()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_jabatan_id          = addslashes($_POST['m_jabatan_id']);
        
        echo $this->record->delete($m_jabatan_id);
        
    }
 function getGrade()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getGrade();
    } 
    
                
}

/* End of file pesertakpd.php */
/* Location: ./application/controllers/master/pesertakpd.php */
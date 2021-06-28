<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nilai extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_nilai','record');
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
            $this->load->view('master/v_nilai'); 
        }
    } 
    
    function create(){
        $auth       = new Auth();
        $auth->restrict();
        if(!isset($_POST))	
            show_404();
        
        $m_standar_nilai_grade      = addslashes($_POST['m_standar_nilai_grade']);
        $m_standar_nilai_skala      = addslashes($_POST['m_standar_nilai_skala']);
        $m_standar_nilai_min        = addslashes($_POST['m_standar_nilai_min']);
        $m_standar_nilai_range      = addslashes($_POST['m_standar_nilai_range']);
        
                           
        echo $this->record->create($m_standar_nilai_grade,$m_standar_nilai_skala,$m_standar_nilai_min,$m_standar_nilai_range);
    }
    function update($m_standar_nilai_grade=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_standar_nilai_grade      = addslashes($_POST['m_standar_nilai_grade']);
        $m_standar_nilai_skala      = addslashes($_POST['m_standar_nilai_skala']);
        $m_standar_nilai_min      = addslashes($_POST['m_standar_nilai_min']);
        $m_standar_nilai_range      = addslashes($_POST['m_standar_nilai_range']);
 
        
        echo $this->record->update($m_standar_nilai_grade,$m_standar_nilai_skala,$m_standar_nilai_min,$m_standar_nilai_range);
        
    }
      function delete()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_standar_nilai_grade          = addslashes($_POST['m_standar_nilai_grade']);
        
        echo $this->record->delete($m_standar_nilai_grade);
        
    }
    
    
                
}

/* End of file pesertakpd.php */
/* Location: ./application/controllers/master/pesertakpd.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Nipel extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_nipel','record');
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
            $this->load->view('master/v_nipel'); 
        }
    } 
    
    function create(){
        $auth       = new Auth();
        $auth->restrict();
        if(!isset($_POST))	
            show_404();
        
        $m_std_nilai_pelatihan_bag      = addslashes($_POST['m_std_nilai_pelatihan_bag']);
        $m_std_nilai_pelatihan_materi   = addslashes($_POST['m_std_nilai_pelatihan_materi']);
        $m_std_nilai_pelatihan_jab      = addslashes($_POST['m_std_nilai_pelatihan_jab']);
        $m_std_nilai_pelatihan_nilai    = addslashes($_POST['m_std_nilai_pelatihan_nilai']);
        
                           
        echo $this->record->create($m_std_nilai_pelatihan_bag,$m_std_nilai_pelatihan_materi,$m_std_nilai_pelatihan_jab,$m_std_nilai_pelatihan_nilai);
    }
    function update($m_std_nilai_pelatihan_id=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_std_nilai_pelatihan_bag      = addslashes($_POST['m_std_nilai_pelatihan_bag']);
        $m_std_nilai_pelatihan_materi   = addslashes($_POST['m_std_nilai_pelatihan_materi']);
        $m_std_nilai_pelatihan_jab      = addslashes($_POST['m_std_nilai_pelatihan_jab']);
        $m_std_nilai_pelatihan_nilai    = addslashes($_POST['m_std_nilai_pelatihan_nilai']);
 
        
        echo $this->record->update($m_std_nilai_pelatihan_id,$m_std_nilai_pelatihan_bag,$m_std_nilai_pelatihan_materi,$m_std_nilai_pelatihan_jab,$m_std_nilai_pelatihan_nilai);
        
    }
      function delete()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_std_nilai_pelatihan_id          = addslashes($_POST['m_std_nilai_pelatihan_id']);
        
        echo $this->record->delete($m_std_nilai_pelatihan_id);
        
    }
    
    function getBag()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getBag();
    }
    
     function getMat()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getMat();
    }
    
    function getJab()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getJab();
    }
    
    function getStd()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getStd();
    }
   
    
    
                
}

/* End of file pesertakpd.php */
/* Location: ./application/controllers/master/pesertakpd.php */
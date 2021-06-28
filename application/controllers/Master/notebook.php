<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Notebook extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_notebook','record');
        $this->load->library('fpdf');
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
            $this->load->view('master/v_notebook');  
        }
    }
    
    function create(){
        $auth       = new Auth();
        $auth->restrict();
        if(!isset($_POST))	
            show_404();
        
        $m_notebook_pt         = addslashes($_POST['m_departemen_pt']);
        $m_notebook_dept       = addslashes($_POST['m_notebook_dept']); 
        $m_notebook_user       = addslashes($_POST['m_notebook_user']);
        $m_notebook_masuk      = addslashes($_POST['m_notebook_masuk']);
        $m_notebook_keterangan = addslashes($_POST['m_notebook_keterangan']);
        
                           
        echo $this->record->create($m_notebook_pt,$m_notebook_dept,$m_notebook_user,$m_notebook_masuk,$m_notebook_keterangan);
    }
    function update($m_notebook_id=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();
        
        $m_notebook_dept       = addslashes($_POST['m_notebook_dept']); 
        $m_notebook_user       = addslashes($_POST['m_notebook_user']);
        $m_notebook_masuk      = addslashes($_POST['m_notebook_masuk']);
        $m_notebook_keluar      = addslashes($_POST['m_notebook_keluar']);
        $m_notebook_keterangan = addslashes($_POST['m_notebook_keterangan']);
        
        
        echo $this->record->update($m_notebook_id,$m_notebook_dept,$m_notebook_user,$m_notebook_masuk,$m_notebook_keluar,$m_notebook_keterangan);
        
    }
    
 
        function enumPt()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->enumField('m_departemen', 'm_departemen_pt');
    }
        function enumCOs()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->enumField('m_notebook', 'm_notebook_cos');
    }
    
    function getDept($cat=null){
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getDept($cat);
    }
    
    function cetak($id=null)
    {
        $auth = new Auth();
        $auth->restrict();
        
        $par    = explode('-', $id);
        $pt     = $par[0];
        $dept   = $par[1];
        
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        //$id = $this->uri->segment(4);
        $data = $this->record->cetak($pt, $dept);
        $this->load->view('master/v_notebook_cetak.php',$data);
    }
    
    function urut()
    {
        $auth = new Auth();

        $auth->restrict();
        //$auth->cek_menu(14);
        $id = $this->uri->segment(4);
        echo $this->record->urut($_GET['ptu']);
    }
}

/* End of file customer.php */
/* Location: ./application/controllers/master/customer.php */
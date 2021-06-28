<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Komputer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_komputer','record');
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
            $this->load->view('master/v_komputer');  
        }
    }
    
    function create(){
        $auth       = new Auth();
        $auth->restrict();
        if(!isset($_POST))	
            show_404();
        
        $m_komputer_pt         = addslashes($_POST['m_departemen_pt']);
        $m_komputer_dept       = addslashes($_POST['m_komputer_dept']); 
        $m_komputer_user       = addslashes($_POST['m_komputer_user']);
        $m_komputer_masuk      = addslashes($_POST['m_komputer_masuk']);
        $m_komputer_keterangan = addslashes($_POST['m_komputer_keterangan']);
        
                           
        echo $this->record->create($m_komputer_pt,$m_komputer_dept,$m_komputer_user,$m_komputer_masuk,$m_komputer_keterangan);
    }
    function update($m_komputer_id=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();
        
        $m_komputer_dept       = addslashes($_POST['m_komputer_dept']); 
        $m_komputer_user       = addslashes($_POST['m_komputer_user']);
        $m_komputer_masuk      = addslashes($_POST['m_komputer_masuk']);
        $m_komputer_keluar      = addslashes($_POST['m_komputer_keluar']);
        $m_komputer_keterangan = addslashes($_POST['m_komputer_keterangan']);
        
        
        echo $this->record->update($m_komputer_id,$m_komputer_dept,$m_komputer_user,$m_komputer_masuk,$m_komputer_keluar,$m_komputer_keterangan);
        
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
        
        echo $this->record->enumField('m_komputer', 'm_komputer_cos');
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
        $this->load->view('master/v_komputer_cetak.php',$data);
    }
    
    function urut()
    {
        $auth = new Auth();

        $auth->restrict();
        //$auth->cek_menu(14);
        $id = $this->uri->segment(4);
        echo $this->record->urut($_GET['thu'], $_GET['ptu']);
    }
}

/* End of file customer.php */
/* Location: ./application/controllers/master/customer.php */
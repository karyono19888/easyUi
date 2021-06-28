<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Matalldept extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('report/M_matalldept','record');
        $this->auth->restrict(); //mencegah user yang belum login untuk mengakses halaman ini
      //  $this->auth->menu(55);
       // $this->load->library('FPDF_Ellipse');
        //$this->load->library('FPDF_MemImage');
        $this->load->library('FPDF');
    }
    
    function index(){
        $this->load->view('report/matriks_all_dept/v_dialog_matalldept');
    }
     
    

 function cetak($tahun=null)
    {
        $auth = new Auth();
        $auth->restrict();
        
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        //$id = $this->uri->segment(4);
        $data = $this->record->cetak($tahun);
        $this->load->view('report/matriks_all_dept/v_matalldept_cetak',$data);
    }    
    
    
 function getDept()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getBag();
    }
    
    function viewImagePdf($nik){
        echo $this->record->viewImage($nik);
    }
    
}
?>

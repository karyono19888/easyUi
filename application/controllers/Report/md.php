<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Md extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('report/M_md','record');
        $this->auth->restrict(); //mencegah user yang belum login untuk mengakses halaman ini
      //  $this->auth->menu(55);
       // $this->load->library('FPDF_Ellipse');
        //$this->load->library('FPDF_MemImage');
        $this->load->library('FPDF');
    }
    
    function index(){
        $this->load->view('report/Matriks_Dept/v_dialog_md');
    }
     
    
    function cetak($id=null)
    {
        $auth = new Auth();
        $auth->restrict();
        
        $pecah      = explode('_', $id);
        $dept       = $pecah[0];
        $tahun      = $pecah[1];
        
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        //$id = $this->uri->segment(4);
        $data = $this->record->cetak($dept, $tahun);
        //$this->db->where('t_proposal_dept', $dept);
        //$this->db->where('t_proposal_materi', $materi);
        $this->load->view('report/matriks_dept/v_md_cetak',$data);
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

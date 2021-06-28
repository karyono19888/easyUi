<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Matriks extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('report/M_matriks','record');
        $this->auth->restrict(); //mencegah user yang belum login untuk mengakses halaman ini
      //  $this->auth->menu(55);
       // $this->load->library('FPDF_Ellipse');
        //$this->load->library('FPDF_MemImage');
        $this->load->library('FPDF');
    }
    
    function index(){
        $this->load->view('report/matriks/v_dialog_matriks');
    }
     
    
    function cetak($id=null)
    {
        $auth = new Auth();
        $auth->restrict();
        
        $pecah      = explode('_', $id);
        $karyawan   = $pecah[0];
        $jab        = $pecah[1];
        $cetak      = $pecah[2];
        
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        //$id = $this->uri->segment(4);
        $data = $this->record->cetak($karyawan, $jab, $cetak);
          if($jab=='1'){
                return $this->load->view('report/matriks/v_matriks_cetak_man',$data);
            }
		  else if ( $jab=='2'){
                return $this->load->view('report/matriks/v_matriks_cetak_asman',$data);
            }
          else{
               return $this->load->view('report/matriks/v_matriks_cetak',$data);
    }    
    
    }
    
   function getPeserta()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        $q = isset($_GET['q']) ? $_GET['q'] : '';
        
        echo $this->record->getPeserta($q);
    }
    
    function viewImagePdf($nik){
        echo $this->record->viewImage($nik);
    }
    
}
?>

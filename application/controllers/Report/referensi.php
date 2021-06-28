<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Referensi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('report/M_referensi','record');
        $this->auth->restrict(); //mencegah user yang belum login untuk mengakses halaman ini
      //  $this->auth->menu(55);
        $this->load->library('FPDF_Ellipse');
    }
    
    function index(){
        $this->load->view('report/referensi/v_dialog_referensi');
    }
     
    
    function cetak($id=null)
    {
        $auth = new Auth();
        $auth->restrict();
        
        $pecah                  = explode('_', $id);
        $nama                   = $pecah[0];
        $tgl                    = $pecah[1];
        $tgl_pengajuan          = $pecah[2];
        $cetak                  = $pecah[3];
        
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        $data = $this->record->cetak($nama, $tgl, $tgl_pengajuan, $cetak);
        $this->load->view('report/referensi/v_referensi_cetak',$data);
    }


    function getNama()
    {
        $auth       = new Auth();
        $auth->restrict();

        $q = isset($_GET['q']) ? $_GET['q'] : '';

        echo $this->record->getNama($q);
    }
  
}
?>

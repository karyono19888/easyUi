<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Evaluasi extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('report/M_evaluasi','record');
        $this->auth->restrict(); //mencegah user yang belum login untuk mengakses halaman ini
      //  $this->auth->menu(55);
        $this->load->library('FPDF_Ellipse');
    }
    
    function index(){
        $this->load->view('report/evaluasi/v_dialog_evaluasi');
    }
     
    
    function cetak($id=null)
    {
        $auth = new Auth();
        $auth->restrict();
        
        $pecah      = explode('_', $id);
        $dept       = $pecah[0];
        $materi     = $pecah[1];
        $dari       = $pecah[2];
        $sampai     = $pecah[3];
        $cetak      = $pecah[4];
        
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        //$id = $this->uri->segment(4);
        $data = $this->record->cetak($dept, $materi, $dari, $sampai, $cetak);
        //$this->db->where('t_proposal_dept', $dept);
        //$this->db->where('t_proposal_materi', $materi);
        $this->load->view('report/evaluasi/v_evaluasi_cetak',$data);
    }    
    
  function getDept()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getDept();
    }
  function getMat()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getMat();
    }
    
    function tutuptahun($tahun) {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->tutuptahun($tahun);
    }
}
?>

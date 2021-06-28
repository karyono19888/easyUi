<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Hasil extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('report/M_hasil','record');
        $this->auth->restrict(); //mencegah user yang belum login untuk mengakses halaman ini
      //  $this->auth->menu(55);
        $this->load->library('FPDF_Ellipse');
    }
    
    function index(){
        $this->load->view('report/hasil/v_dialog_hasil');
    }
     
    
    function cetak($id=null)
    {
        $auth = new Auth();
        $auth->restrict();
        
        $pecah      = explode('_', $id);
        $materi     = $pecah[0];
        $tes        = $pecah[1];
        $cetak      = $pecah[2];
        
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        //$id = $this->uri->segment(4);
        $data = $this->record->cetak($materi,$tes, $cetak);
        //$this->db->where('t_proposal_dept', $dept);
        //$this->db->where('t_proposal_materi', $materi);
        $this->load->view('report/hasil/v_hasil_cetak',$data);
    }    
    
  function getMat()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getMat();
    }
}
?>

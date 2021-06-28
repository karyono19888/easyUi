<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Proposal extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('report/M_proposal','record');
        $this->auth->restrict(); //mencegah user yang belum login untuk mengakses halaman ini
      //  $this->auth->menu(55);
        $this->load->library('FPDF_Ellipse');
    }
    
    function index(){
        $this->load->view('report/proposal/v_dialog_proposal');
    }
    
    
    function getProp()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getProp();
    }
    
    
    function cetak($id=null)
    {
        $auth = new Auth();
        $auth->restrict();
        
        $pecah                  = explode('_', $id);
        $dept                   = $pecah[0];
        $tahun                  = $pecah[1];
        $periode                = $pecah[2];
        $cetak                  = $pecah[3];
        
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        //$id = $this->uri->segment(4);
        $data = $this->record->cetak($dept, $tahun, $periode, $cetak);
       // $this->db->where('t_proposal_dept', $dept);
        //$this->db->where('t_proposal_tahun', $tahun);
        //$this->db->where('t_proposal_periode', $periode);
        $this->load->view('report/proposal/v_proposal_cetak',$data);
    }    
    
}
?>

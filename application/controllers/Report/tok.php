<?php if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Tok extends CI_Controller {

    function __construct() {
        parent::__construct();
        $this->load->model('report/M_tok','record');
        $this->auth->restrict(); //mencegah user yang belum login untuk mengakses halaman ini
      //  $this->auth->menu(55);
        $this->load->library('FPDF_Ellipse');
    }
    
    function index(){
        $this->load->view('report/turn_over_karyawan/v_dialog_tok');
    }
     
    
    function cetak($id=null)
    {
        $auth = new Auth();
        $auth->restrict();
        
        $pecah          = explode('_', $id);
        $tahun          = $pecah[0];
        $periode        = $pecah[1];
        $tglStart       = $pecah[2];
        $tglEnd         = $pecah[3];
        $cetak          = $pecah[4];
        
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        //$id = $this->uri->segment(4);
        $data = $this->record->cetak($tahun, $periode, $tglStart,$tglEnd, $cetak);
       // $this->db->where('t_proposal_tahun', $tahun);
        //$this->db->where('t_proposal_periode', $periode);
       // $this->db->where('t_tok_tgl', $tgltok);
        $this->load->view('report/turn_over_karyawan/v_tok_cetak',$data);
    }    
    
}
?>

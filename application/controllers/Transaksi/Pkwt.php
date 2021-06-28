<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pkwt extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('transaksi/pkwt_model','record');
        $this->load->library('FPDF_Ellipse');
    }
    
    public function index()
    {
        $auth       = new Auth();
         // mencegah user yang belum login untuk mengakses halaman ini
        $auth->restrict();
        
        if (isset($_GET['grid'])) 
            echo $this->record->getJson();        
         else 
            $this->load->view('transaksi/pkwt/v_pkwt');        
    } 

    
    
    public function getPkwtBeforeData($pkwt_id=null)
    {
        echo $this->record->getPkwtBeforeData($pkwt_id);
    }
    
    public function create()
    {
        if(!isset($_POST))	
            show_404();

        if($this->record->create() && $this->record->updatePkwtBefore())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal memasukkan data'));
    }     
    
    public function update($pkwt_id=null)
    {
        if(!isset($_POST))	
            show_404();

        if($this->record->update($pkwt_id) && $this->record->updatePkwtBefore())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal mengubah data'));
    }
        
    public function delete()
    {
        if(!isset($_POST))	
            show_404();

        $pkwt_id = intval(addslashes($_POST['pkwt_id']));
        if($this->record->delete($pkwt_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menghapus data'));
    }
    
    public function enumPkwtKk()
    {
        echo $this->record->enumField('pkwt', 'pkwt_kk');
    }
    
    public function enumPkwtStatus()
    {
        echo $this->record->enumField('pkwt', 'pkwt_status');
    }
    
    public function enumPkwtPeriod()
    {
        echo $this->record->enumField('pkwt', 'pkwt_period');
    }
    
    public function enumPkwtProcess()
    {
        echo $this->record->enumField('pkwt', 'pkwt_process');
    }
    
 
	
	function getEmply()
    {
        $auth       = new Auth();
        $auth->restrict();

        $q = isset($_GET['q']) ? $_GET['q'] : '';

        echo $this->record->getEmply($q);
    }

    
    
    public function getDept()
    {
        echo $this->record->getDept();
    }
    
    public function getJab()
    {
        echo $this->record->getJab();
    }
   
    public function getSalary()
    {
        echo $this->record->getSalary();
    }
    
    public function getPkwtBefore()
    {
        echo $this->record->getPkwtBefore();
    }
    
    function cetak_pkwt()
    {
        $auth = new Auth();

        $auth->restrict();
        //$auth->cek_menu(14);
        
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        $id = $this->uri->segment(4);
        $data['pkwt'] = $this->record->get_pkwt_by_id($id);
        $this->load->view('transaksi/pkwt/cetak_pkwt.php',$data);
    }
    
    function cetak_evaluasi()
    {
        $auth = new Auth();

        $auth->restrict();
        //$auth->cek_menu(14);
        
        define('FPDF_FONTPATH',$this->config->item('fonts_path'));
        $id = $this->uri->segment(4);
        $data['pkwt'] = $this->record->get_pkwt_by_id($id);
        $this->load->view('transaksi/pkwt/cetak_evaluasi.php',$data);
    }

    function UpdateTglSurat($pkwt_id = null)
    {
        $auth       = new Auth();
        $auth->restrict();

        if (!isset($_POST))
            show_404();

            
        $tgl_tandatangan             = addslashes($_POST['tgl_tandatangan']);
        $tgl_terbit                  = addslashes($_POST['tgl_terbit']);



        echo $this->record->UpdateTglSurat($pkwt_id,$tgl_tandatangan,$tgl_terbit);
    }


    function CetakSuratP3($pkwt_id = null)
    {
        $auth = new Auth();
        $auth->restrict();

        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
        $data['pkwtsp3'] = $this->record->CetakSuratP3($pkwt_id);
        $this->load->view('transaksi/pkwt/cetak_surat_p3', $data);
    }

    function UpdateStatusKaryawan($pkwt_id = null)
    {
        $auth       = new Auth();
        $auth->restrict();

        if (!isset($_POST))
            show_404();

        $tgl_berlaku             = addslashes($_POST['tgl_berlaku']);
        $tgl_buat                = addslashes($_POST['tgl_buat']);

        echo $this->record->UpdateStatusKaryawan($pkwt_id, $tgl_berlaku, $tgl_buat);
    }

    function CetakSK($pkwt_id = null)
    {
        $auth = new Auth();
        $auth->restrict();

        define('FPDF_FONTPATH', $this->config->item('fonts_path'));
        $data['pkwtsk'] = $this->record->CetakSK($pkwt_id);
        $this->load->view('transaksi/pkwt/cetak_SK', $data);
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
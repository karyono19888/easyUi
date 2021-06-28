<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require 'assets/excel/vendor/autoload.php';
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;
class Customer extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_customer','record');
        $this->auth->restrict(); //mencegah user yang belum login untuk mengakses halaman ini
        $this->auth->menu(9);
        $this->load->library('PHPExcel');
    }
    
    function index(){
        if (isset($_GET['grid'])){
            echo $this->record->index();      
        }
        else {
            $this->load->view('master/v_customer'); 
        }
    } 
    
    function create() {
        if(!isset($_POST))	
            show_404();

        $m_cust_id    = addslashes($_POST['m_cust_id']);
        $m_cust_name  = addslashes($_POST['m_cust_name']);
        
        if($this->record->create($m_cust_id, $m_cust_name)){
            echo json_encode(array('success'=>true));
        }
        else{
            echo json_encode(array('success'=>false));
        }
    }     
    
    function update($m_cust_id=null) {
        $m_cust_name  = addslashes($_POST['m_cust_name']);
        
        if(!isset($_POST))	
            show_404();

        if($this->record->update($m_cust_id, $m_cust_name)){
            echo json_encode(array('success'=>true));
        }
        else{
            echo json_encode(array('success'=>false));
        }
    }
        
    function delete(){
        if(!isset($_POST))	
            show_404();

        $m_cust_id = addslashes($_POST['m_cust_id']);
        
        if($this->record->delete($m_cust_id)){
            echo json_encode(array('success'=>true));
        }
        else{
            echo json_encode(array('success'=>false));
        }
    }
    
     function blankData($data){
        if($data==''){
            return 0;
        }
        else{
            return $data;
        }
    }
    
    function convertDateUnix($date){
        if($date==''){
            return '0000-00-00';
        }
        else{
            $unix_date = ($date - 25569) * 86400;
            $xls_date = 25569 + ($unix_date / 86400);
            $unix_date_a = ($xls_date - 25569) * 86400;
            return date("Y-m-d", $unix_date_a);
        }
    }
    
 
    function upload(){
        move_uploaded_file($_FILES["fileb"]["tmp_name"],
                "assets/temp_upload/" . $_FILES["fileb"]["name"]);
        ini_set('memory_limit', '-1');
        $inputFileName = 'assets/temp_upload/' . $_FILES["fileb"]["name"];
        $reader         = new Xlsx();
        $spreadsheet    = $reader->load($inputFileName);
        $worksheet      = $spreadsheet->getActiveSheet();

        $baris  = count($worksheet->toArray());
        $ok     = 0;
        $ng     = 0;
        
        for ($i = 2; $i <= $baris; $i++){            
            $m_cust_id                       = $this->blankData($worksheet->getCellByColumnAndRow(1, $i)->getValue());
            $m_cust_name                     = $this->blankData($worksheet->getCellByColumnAndRow(2, $i)->getValue());
            
            $query = $this->record->upload($m_cust_id, $m_cust_name);
            
            
            if ($query){
                $ok++;
            }
            else{
                $ng++;
            }
        } 
        unlink('assets/temp_upload/' . $_FILES["fileb"]["name"]);
        echo json_encode(array('success'=>true,
                                'total'=>'Total Data: '.($baris-1),
                                'ok'=>'Data OK: '.$ok,
                                'ng'=>'Data NG: '.$ng));
        
    }
                
}

/* End of file customer.php */
/* Location: ./application/controllers/master/customer.php */
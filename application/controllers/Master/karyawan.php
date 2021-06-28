<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Karyawan extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/m_karyawan','record');
    }
    
  function index()
    {
        $auth       = new Auth();
         // mencegah user yang belum login untuk mengakses halaman ini
        $auth->restrict();
        
        if (isset($_GET['grid']))
        {
            echo $this->record->index();      
        }
        else 
        {
            $this->load->view('master/v_karyawan'); 
        }
    } 
    
  function create(){
        $auth       = new Auth();
        $auth->restrict();
        if(!isset($_POST))	
            show_404();
        
        $m_emply_nik            = addslashes($_POST['m_emply_nik']);
        $m_emply_name           = htmlentities($_POST['m_emply_name']); 
        $m_emply_sex            = addslashes($_POST['m_emply_sex']);
        $m_emply_bop            = addslashes($_POST['m_emply_bop']);
        $m_emply_bod            = addslashes($_POST['m_emply_bod']);
        $m_emply_relig          = addslashes($_POST['m_emply_relig']);
        $m_emply_marital        = addslashes($_POST['m_emply_marital']);
        $m_emply_ktp            = addslashes($_POST['m_emply_ktp']);
        $m_emply_add            = addslashes($_POST['m_emply_add']);
        $m_emply_city           = addslashes($_POST['m_emply_city']);
        $m_emply_zip            = addslashes($_POST['m_emply_zip']);
        $m_emply_cell           = addslashes($_POST['m_emply_cell']);
        $m_emply_start          = addslashes($_POST['m_emply_start']);
        $m_emply_status         = addslashes($_POST['m_emply_status']);
        $m_emply_dept           = addslashes($_POST['m_emply_dept']);
        $m_emply_educ           = addslashes($_POST['m_emply_educ']);
        $_emply_jabatan         = addslashes($_POST['m_emply_jabatan']);
        $m_emply_job_spec       = addslashes($_POST['m_emply_job_spec']);
        $m_emply_end            = addslashes($_POST['m_emply_end']);
        
                           
        echo $this->record->create($m_emply_nik,$m_emply_name,$m_emply_sex,$m_emply_bop,$m_emply_bod,$m_emply_relig,$m_emply_marital,
                                   $m_emply_ktp,$m_emply_add,$m_emply_city,$m_emply_zip,$m_emply_cell,$m_emply_start,$m_emply_status,$m_emply_dept,
                                   $m_emply_educ, $_emply_jabatan,$m_emply_job_spec,$m_emply_end);
    }
  function update($m_emply_nik=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_emply_name           = htmlentities($_POST['m_emply_name']); 
        $m_emply_sex            = addslashes($_POST['m_emply_sex']);
        $m_emply_bop            = addslashes($_POST['m_emply_bop']);
        $m_emply_bod            = addslashes($_POST['m_emply_bod']);
        $m_emply_relig          = addslashes($_POST['m_emply_relig']);
        $m_emply_marital        = addslashes($_POST['m_emply_marital']);
        $m_emply_ktp            = addslashes($_POST['m_emply_ktp']);
        $m_emply_add            = addslashes($_POST['m_emply_add']);
        $m_emply_city           = addslashes($_POST['m_emply_city']);
        $m_emply_zip            = addslashes($_POST['m_emply_zip']);
        $m_emply_cell           = addslashes($_POST['m_emply_cell']);
        $m_emply_start          = addslashes($_POST['m_emply_start']);
        $m_emply_status         = addslashes($_POST['m_emply_status']);
        $m_emply_dept           = addslashes($_POST['m_emply_dept']);
        $m_emply_educ           = addslashes($_POST['m_emply_educ']);
        $_emply_jabatan         = addslashes($_POST['m_emply_jabatan']);
        $m_emply_job_spec       = addslashes($_POST['m_emply_job_spec']);
        $m_emply_end            = addslashes($_POST['m_emply_end']);
 
        
        echo $this->record->update($m_emply_nik,$m_emply_name,$m_emply_sex,$m_emply_bop,$m_emply_bod,$m_emply_relig,$m_emply_marital,
                                   $m_emply_ktp,$m_emply_add,$m_emply_city,$m_emply_zip,$m_emply_cell,$m_emply_start,$m_emply_status,$m_emply_dept,
                                   $m_emply_educ, $_emply_jabatan,$m_emply_job_spec,$m_emply_end);
        
    }
  function delete()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_emply_nik          = addslashes($_POST['m_emply_nik']);
        
        echo $this->record->delete($m_emply_nik);
        
    }
    
  function getJab()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getJab();
    } 
    
 function getExp()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        $q = isset($_GET['q']) ? $_GET['q'] : '';
        
        echo $this->record->getExp($q);
    }  
    
    
function getBag()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getBag();
    }
    
 function upload($m_emply_nik=null){
        
        //$dir = 'assets/temp_upload/';
        move_uploaded_file($_FILES["filea"]["tmp_name"],
                "assets/temp_upload/" . $_FILES["filea"]["name"]);
        $files = glob('assets/temp_upload/'. $_FILES["filea"]["name"]); 
               // "assets/temp_upload/" . $_FILES["filea"]["name"];
	$img_src = $files[0];
        $imgbinary = fread(fopen($img_src, 'r'), filesize($img_src));
        $imgu = 'data:image/jpeg;base64,'.base64_encode($imgbinary);
        
        $data   = $this->record->upload($m_emply_nik,$imgu);
        if ($data)
        {
            echo json_encode(array('success'=>$imgu));
        }
        else
        {
            echo json_encode(array('success'=>FALSE));
        }
		unlink($img_src);
    }
    
    
 function viewImage(){
        $id         = addslashes($_POST['id']);
        echo $this->record->viewImage($id);
    }
    
    
 function deleteImage()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $m_emply_nik          = addslashes($_POST['m_emply_nik']);
        
        echo $this->record->deleteImage($m_emply_nik);
        
    }
    
    
 function getEduc()
    {
        $auth       = new Auth();
        $auth->restrict();
        
        echo $this->record->getEduc();
    }   
                
}

/* End of file pesertakpd.php */
/* Location: ./application/controllers/master/pesertakpd.php */
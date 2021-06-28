<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Upah extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/upah_model','record');
    }
    
    public function index()
    {
        $auth       = new Auth();
         // mencegah user yang belum login untuk mengakses halaman ini
        $auth->restrict();
        
        if (isset($_GET['grid'])) 
            echo $this->record->getJson();        
         else 
            $this->load->view('master/v_upah');        
    } 
    
    public function create()
    {
        if(!isset($_POST))	
            show_404();

        if($this->record->create())
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal memasukkan data'));
    }     
    
    public function update($salary_id=null)
    {
        if(!isset($_POST))	
            show_404();

        if($this->record->update($salary_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal mengubah data'));
    }
        
    public function delete()
    {
        if(!isset($_POST))	
            show_404();

        $salary_id = intval(addslashes($_POST['salary_id']));
        if($this->record->delete($salary_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menghapus data'));
    }
               
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
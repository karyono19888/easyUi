<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Bank extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('master/bank_model','record');
    }
    
    public function index()
    {
        $auth       = new Auth();
         // mencegah user yang belum login untuk mengakses halaman ini
        $auth->restrict();
        
        if (isset($_GET['grid'])) 
            echo $this->record->getJson();        
         else 
            $this->load->view('master/bank');        
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
    
    public function update($bank_id=null)
    {
        if(!isset($_POST))	
            show_404();

        if($this->record->update($bank_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal mengubah data'));
    }
        
    public function delete()
    {
        if(!isset($_POST))	
            show_404();

        $bank_id = intval(addslashes($_POST['bank_id']));
        if($this->record->delete($bank_id))
            echo json_encode(array('success'=>true));
        else
            echo json_encode(array('msg'=>'Gagal menghapus data'));
    }
               
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
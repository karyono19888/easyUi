<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class spk extends CI_Controller {

    function __construct(){
        parent::__construct();
        
        $this->load->model('M_spk');
    }

    function index()
    {
        $this->load->view('spk/v_spk');
    }
 

    function spk()
    {
        $session = $this->session->userdata('nama');
        $data = $this->M_spk->spk($session);
        echo json_encode($data);
    }

  

    function buatspk()
    {
        $t_spk_jenis = $this->input->post('t_spk_jenis');
        $t_spk_user = $this->input->post('t_spk_user');
        $t_spk_uraian = $this->input->post('t_spk_uraian');
        $t_spk_duedate = $this->input->post('t_spk_duedate');
        $data = $this->M_spk->buatspk($t_spk_jenis, $t_spk_user , $t_spk_uraian, $t_spk_duedate);
        echo json_encode($data);
    }
 

    function get_id()
    {
        $t_spk_id = $this->input->get('id');
        $data = $this->M_spk->get_id_spk($t_spk_id);
        echo json_encode($data);
    }


    function updatespk()
    {
        $t_spk_id                 = $this->input->post('id');
        $t_spk_uraian             = $this->input->post('deskripsi');
        $t_spk_duedate            = $this->input->post('target');
        $data = $this->M_spk->updatespk($t_spk_id, $t_spk_uraian, $t_spk_duedate);
        echo json_encode($data);
    }

    function deletespk()
    {
        $t_spk_id                 = $this->input->post('t_spk_id');

        $data = $this->M_spk->deletespk($t_spk_id);
        echo json_encode($data);
    }

    

}


/* End of file menu.php */
/* Location: ./application/controllers/menu.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class heading extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('M_heading');
        $this->load->model('M_highcharts');
    }
    
    function heading(){
    	$data['heading'] = $this->M_heading->tampil_heading()->result();
        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('menu/v_heading',$data);
        $this->load->view('template/v_footer'); 
    }

    function subheading($a){
        $data = ['chart_oee'    => $this->M_highcharts->report($a),
                'chart_prod'    => $this->M_highcharts->report_p($a),
                'chart_output'  => $this->M_highcharts->report_out($a),
                'chart_wh'      => $this->M_highcharts->report_wh($a),
                'heading'       => $a];

        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('machmon/heading/v_heading',$data);
        $this->load->view('template/v_footer');  
    }

    /*

    function indexa(){
        //echo $this->record->indexOk();
        //$data = $this->record->indexOk();
        $data['report'] = $this->M_oee->indexOk();
        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('machmon/heading/v_heading',$data);
        $this->load->view('template/v_footer');  
    } 
    */
    
}


/* End of file menu.php */
/* Location: ./application/controllers/menu.php */
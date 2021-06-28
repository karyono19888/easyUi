<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Trimming extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('M_heading');
        $this->load->model('M_highcharts');
    }

    function trimming(){
        $data['trimming'] = $this->M_heading->tampil_trimming()->result();
        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('menu/v_trimming',$data);
        $this->load->view('template/v_footer'); 
    }

    function subtrimming($a){
        $data = ['chart_oee'    => $this->M_highcharts->tr_report($a),
                'chart_prod'    => $this->M_highcharts->tr_report_p($a),
                'chart_output'  => $this->M_highcharts->tr_report_out($a),
                'chart_wh'      => $this->M_highcharts->tr_report_wh($a),
                'trimming'       => $a];

        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('machmon/trimming/v_trimming',$data);
        $this->load->view('template/v_footer'); 
    }

}


/* End of file menu.php */
/* Location: ./application/controllers/menu.php */
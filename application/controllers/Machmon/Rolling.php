<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Rolling extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('M_heading');
        $this->load->model('M_highcharts');
    }

    function rolling(){
        $data['rolling'] = $this->M_heading->tampil_rolling()->result();
        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('menu/v_rolling',$data);
        $this->load->view('template/v_footer'); 
    }

    function subrolling($a){
        $data = ['chart_oee'    => $this->M_highcharts->R_report($a),
                'chart_prod'    => $this->M_highcharts->R_report_p($a),
                'chart_output'  => $this->M_highcharts->R_report_out($a),
                'chart_wh'      => $this->M_highcharts->R_report_wh($a),
                'rolling'       => $a];

        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('machmon/rolling/v_rolling',$data);
        $this->load->view('template/v_footer'); 
    }

}


/* End of file menu.php */
/* Location: ./application/controllers/menu.php */
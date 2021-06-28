<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Pressing extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('M_heading');
        $this->load->model('M_highcharts');
    }

    function pressing(){
        $data['pressing'] = $this->M_heading->tampil_pressing()->result();
        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('menu/v_pressing',$data);
        $this->load->view('template/v_footer'); 
    }

    function subpressing($a){
        $data = ['chart_oee'    => $this->M_highcharts->press_report($a),
                'chart_prod'    => $this->M_highcharts->press_report_p($a),
                'chart_output'  => $this->M_highcharts->press_report_out($a),
                'chart_wh'      => $this->M_highcharts->press_report_wh($a),
                'pressing'       => $a];

        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('machmon/pressing/v_pressing',$data);
        $this->load->view('template/v_footer'); 
    }

}


/* End of file menu.php */
/* Location: ./application/controllers/menu.php */
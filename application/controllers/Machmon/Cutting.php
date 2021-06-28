<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Cutting extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('M_heading');
        $this->load->model('M_highcharts');
    }

    function cutting(){
        $data['cutting'] = $this->M_heading->tampil_cutting()->result();
        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('menu/v_cutting',$data);
        $this->load->view('template/v_footer'); 
    }

    function subcutting($a){
        $data = ['chart_oee'    => $this->M_highcharts->ct_report($a),
                'chart_prod'    => $this->M_highcharts->ct_report_p($a),
                'chart_output'  => $this->M_highcharts->ct_report_out($a),
                'chart_wh'      => $this->M_highcharts->ct_report_wh($a),
                'cutting'       => $a];

        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('machmon/cutting/v_cutting',$data);
        $this->load->view('template/v_footer'); 
    }

}


/* End of file menu.php */
/* Location: ./application/controllers/menu.php */
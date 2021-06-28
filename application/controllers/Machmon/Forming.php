<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Forming extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('M_heading');
        $this->load->model('M_highcharts');
    }

    function forming(){
        $data['forming'] = $this->M_heading->tampil_forming()->result();
        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('menu/v_forming',$data);
        $this->load->view('template/v_footer'); 
    }

    function subforming($a){
        $data = ['chart_oee'    => $this->M_highcharts->fm_report($a),
                'chart_prod'    => $this->M_highcharts->fm_report_p($a),
                'chart_output'  => $this->M_highcharts->fm_report_out($a),
                'chart_wh'      => $this->M_highcharts->fm_report_wh($a),
                'forming'       => $a];

        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('machmon/forming/v_forming',$data);
        $this->load->view('template/v_footer'); 
    }

}


/* End of file menu.php */
/* Location: ./application/controllers/menu.php */
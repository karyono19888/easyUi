<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Slotting extends CI_Controller {

    function __construct(){
        parent::__construct();
        $this->load->model('M_heading');
        $this->load->model('M_highcharts');
    }

    function slotting(){
        $data['slotting'] = $this->M_heading->tampil_slotting()->result();
        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('menu/v_slotting',$data);
        $this->load->view('template/v_footer'); 
    }

    function subslotting($a){
        $data = ['chart_oee'    => $this->M_highcharts->sl_report($a),
                'chart_prod'    => $this->M_highcharts->sl_report_p($a),
                'chart_output'  => $this->M_highcharts->sl_report_out($a),
                'chart_wh'      => $this->M_highcharts->sl_report_wh($a),
                'slotting'       => $a];

        $this->load->view('template/v_header');
        $this->load->view('template/v_sidebar');
        $this->load->view('machmon/slotting/v_slotting',$data);
        $this->load->view('template/v_footer'); 
    }

}


/* End of file menu.php */
/* Location: ./application/controllers/menu.php */
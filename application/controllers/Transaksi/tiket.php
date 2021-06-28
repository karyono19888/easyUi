<?php if (!defined('BASEPATH')) exit('No direct script access allowed');
require 'assets/excel/vendor/autoload.php';

use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

class tiket extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('transaksi/m_tiket', 'record');
        $this->auth->restrict(); //mencegah user yang belum login untuk mengakses halaman ini
        $this->auth->menu(66);
        $this->load->library('PHPExcel');
    }

    function index()
    {
        if (isset($_GET['grid'])) {
            echo $this->record->index();
        } else {
            $this->load->view('transaksi/v_tiket');
        }
    }



    function create()
    {
        $auth       = new Auth();
        $auth->restrict();
        if (!isset($_POST))
            show_404();

        $t_spk_respontime		= addslashes($_POST['t_spk_respontime']);
		$t_spk_jenis    		= addslashes($_POST['t_spk_jenis']);
        $t_spk_man      		= addslashes($_POST['t_spk_man']);
        $t_spk_user     		= addslashes($_POST['t_spk_user']);
        $t_spk_dept     		= addslashes($_POST['t_spk_dept']);
        $t_spk_uraian   		= addslashes($_POST['t_spk_uraian']);
        $t_spk_duedate  		= addslashes($_POST['t_spk_duedate']);


        echo $this->record->create($t_spk_respontime,$t_spk_jenis, $t_spk_man, $t_spk_user, $t_spk_dept, $t_spk_uraian,  $t_spk_duedate);
    }

    function update($t_spk_id = null)
    {
        $auth       = new Auth();
        $auth->restrict();

        if (!isset($_POST))
            show_404();

        $t_spk_respontime		= addslashes($_POST['t_spk_respontime']);
		$t_spk_jenis    		= addslashes($_POST['t_spk_jenis']);
        $t_spk_man      		= addslashes($_POST['t_spk_man']);
        $t_spk_user     		= addslashes($_POST['t_spk_user']);
        $t_spk_dept     		= addslashes($_POST['t_spk_dept']);
        $t_spk_uraian   		= addslashes($_POST['t_spk_uraian']);
        $t_spk_duedate  		= addslashes($_POST['t_spk_duedate']);


        echo $this->record->update($t_spk_id, $t_spk_respontime,$t_spk_jenis, $t_spk_man, $t_spk_user, $t_spk_dept, $t_spk_uraian,  $t_spk_duedate);
    }



    function ceklis_spk($t_spk_id = null)
    {
        $auth       = new Auth();
        $auth->restrict();

        if (!isset($_POST))
            show_404();

        $t_spk_closed               = addslashes($_POST['t_spk_closed']);
        $t_spk_perbaikan            = addslashes($_POST['t_spk_perbaikan']);

        echo $this->record->ceklis_spk($t_spk_id, $t_spk_closed, $t_spk_perbaikan );
    }

    function getDept()
    {
        $auth       = new Auth();
        $auth->restrict();

        $q = isset($_GET['q']) ? $_GET['q'] : '';

        echo $this->record->getDept($q);
    }
    
    

    function exportExcel()
    {
        $auth       = new Auth();
        $auth->restrict();
        if (!isset($_POST))
            show_404();

        $t_spk_tgl_start            = addslashes($_POST['t_spk_tgl_start']);
        $t_spk_tgl_end              = addslashes($_POST['t_spk_tgl_end']);


        $data = $this->record->exportExcel($t_spk_tgl_start, $t_spk_tgl_end);
        $this->load->view('report/tiket/excel_tiket.php', $data);
    }
}


/* End of file tiket.php */
/* Location: ./application/controllers/transaksi/tiket.php */

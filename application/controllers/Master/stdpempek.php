<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Stdpempek extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->model('master/m_stdpempek', 'record');
    }

    function index()
    {
        $auth       = new Auth();
        // mencegah user yang belum login untuk mengakses halaman ini
        $auth->restrict();

        if (isset($_GET['grid'])) {
            echo $this->record->index();
        } else {
            $this->load->view('master/v_stdpempek');
        }
    }

    function create()
    {
        $auth       = new Auth();
        $auth->restrict();
        if (!isset($_POST))
            show_404();

        $m_std_nilai_eval_pekerjaan_bag         = addslashes($_POST['m_std_nilai_eval_pekerjaan_bag']);
        $m_std_nilai_eval_pekerjaan_kriteria    = addslashes($_POST['m_std_nilai_eval_pekerjaan_kriteria']);


        echo $this->record->create($m_std_nilai_eval_pekerjaan_bag, $m_std_nilai_eval_pekerjaan_kriteria);
    }
    function update($m_std_nilai_eval_pekerjaan_id = null)
    {
        $auth       = new Auth();
        $auth->restrict();

        if (!isset($_POST))
            show_404();

        $m_std_nilai_eval_pekerjaan_bag         = addslashes($_POST['m_std_nilai_eval_pekerjaan_bag']);
        $m_std_nilai_eval_pekerjaan_kriteria    = addslashes($_POST['m_std_nilai_eval_pekerjaan_kriteria']);


        echo $this->record->update($m_std_nilai_eval_pekerjaan_id, $m_std_nilai_eval_pekerjaan_bag, $m_std_nilai_eval_pekerjaan_kriteria);
    }
    function delete()
    {
        $auth       = new Auth();
        $auth->restrict();

        if (!isset($_POST))
            show_404();

        $m_std_nilai_eval_pekerjaan_id          = addslashes($_POST['m_std_nilai_eval_pekerjaan_id']);

        echo $this->record->delete($m_std_nilai_eval_pekerjaan_id);
    }

    function getBag()
    {
        $auth       = new Auth();
        $auth->restrict();

        echo $this->record->getBag();
    }


}

/* End of file pesertakpd.php */
/* Location: ./application/controllers/master/pesertakpd.php */
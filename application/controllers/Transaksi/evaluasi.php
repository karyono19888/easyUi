<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Evaluasi extends CI_Controller {

    public function __construct() {
        parent::__construct();
        $this->load->model('transaksi/m_evaluasi','record');
    }
    
   function index()
    {
        $auth       = new Auth();
         // mencegah user yang belum login untuk mengakses halaman ini
        $auth->restrict();
        
        if (isset($_GET['grid']))
        {
            echo $this->record->index();      
        }
        else 
        {
            $this->load->view('transaksi/v_evaluasi'); 
        }
    } 
    
 
  function update($t_evaluasi_id=null)
    {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $t_evaluasi_pengetahuan_materi      = addslashes($_POST['t_evaluasi_pengetahuan_materi']);
        $t_evaluasi_penerapan_lap           = addslashes($_POST['t_evaluasi_penerapan_lap']);
        $t_evaluasi_peningkatan_kinerja     = addslashes($_POST['t_evaluasi_peningkatan_kinerja']);
        $t_evaluasi_keterangan              = addslashes($_POST['t_evaluasi_keterangan']);
 
        
        echo $this->record->update($t_evaluasi_id,$t_evaluasi_pengetahuan_materi,$t_evaluasi_penerapan_lap,
                                   $t_evaluasi_peningkatan_kinerja,$t_evaluasi_keterangan);
        
    }
  function tutuptahun() {
        $auth       = new Auth();
        $auth->restrict();
        
        if(!isset($_POST))	
            show_404();

        $tahun      = addslashes($_POST['tahun']);
        //$tahun= '2019';
        
        echo $this->record->tutuptahun($tahun);
    }             
}

/* End of file pesertakpd.php */
/* Location: ./application/controllers/master/pesertakpd.php */
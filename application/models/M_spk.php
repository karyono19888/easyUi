<?php
defined('BASEPATH') or exit('No direct script access allowed');

class M_spk extends CI_Model
{
    static $table1 = 't_spk';

    public function __construct()
    { 
        parent::__construct(); 
    }


    function spk($session)
    {
        $hasil = $this->db->query("SELECT *  FROM t_spk ");
        return $hasil->result();
    }
 


    function buatspk($t_spk_jenis, $t_spk_user,  $t_spk_uraian, $t_spk_duedate)
    {
        //$this->db->trans_start();
        $hasil = $this->db->insert(self::$table1, array(
            't_spk_jenis'           => $t_spk_jenis, 
            't_spk_user'            => $t_spk_user,
            't_spk_uraian'          => $t_spk_uraian,
            't_spk_duedate'         => $t_spk_duedate

        ));
        return $hasil;
       // $this->db->trans_complete();
    }

    

    function get_id_spk($t_spk_id)
    {
        $hsl = $this->db->query("SELECT * FROM t_spk WHERE t_spk_id='$t_spk_id'");
        if ($hsl->num_rows() > 0) {
            foreach ($hsl->result() as $data) {
                $hasil = array(
                    't_spk_id'      => $data->t_spk_id, 
                    't_spk_user'    => $data->t_spk_user,
                    't_spk_jenis'   => $data->t_spk_jenis,
                    't_spk_uraian'  => $data->t_spk_uraian,
                    't_spk_duedate' => $data->t_spk_duedate,
                );
            }
        }
        return $hasil;
    }


    function updatespk($t_spk_id, $t_spk_uraian, $t_spk_duedate)
    {
        //$this->db->trans_start();
        $this->db->where('t_spk_id', $t_spk_id);
        $hasil = $this->db->update(self::$table1, array(
            't_spk_uraian'     => $t_spk_uraian,
            't_spk_duedate'     => $t_spk_duedate
        ));
        return $hasil;
        //$this->db->trans_complete();
    }


    function deletespk($t_spk_id)
    {
        $this->db->trans_start();
        $hasil = $this->db->delete('t_spk', array('t_spk_id' => $t_spk_id));
        $this->db->trans_complete();
        return $hasil;
    }
}

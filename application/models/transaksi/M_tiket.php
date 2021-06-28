<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class M_tiket extends CI_Model
{
    static $table = 't_spk';
    static $table2 = 'departemen';

    public function __construct()
    {
        parent::__construct();
        //  $this->load->helper('database'); // Digunakan untuk memunculkan data Enum
    }

    function index()
    {
        $page   = isset($_POST['page']) ? intval($_POST['page']) : 1;
        $rows   = isset($_POST['rows']) ? intval($_POST['rows']) : 50;
        $offset = ($page - 1) * $rows;
        $sort   = isset($_POST['sort']) ? strval($_POST['sort']) : 'Selisih';
        $order  = isset($_POST['order']) ? strval($_POST['order']) : 'desc';

        $filterRules = isset($_POST['filterRules']) ? ($_POST['filterRules']) : '';
        $cond = '1=1';
        if (!empty($filterRules)) {
            $filterRules = json_decode($filterRules);
            //print_r ($filterRules);
            foreach ($filterRules as $rule) {
                $rule = get_object_vars($rule);
                $field = $rule['field'];
                $op = $rule['op'];
                $value = $rule['value'];
                if (!empty($value)) {
                    if ($op == 'contains') {
                        $cond .= " and ($field like '%$value%')";
                    } else if ($op == 'beginwith') {
                        $cond .= " and ($field like '$value%')";
                    } else if ($op == 'endwith') {
                        $cond .= " and ($field like '%$value')";
                    } else if ($op == 'equal') {
                        $cond .= " and $field = $value";
                    } else if ($op == 'notequal') {
                        $cond .= " and $field != $value";
                    } else if ($op == 'less') {
                        $cond .= " and $field < $value";
                    } else if ($op == 'lessorequal') {
                        $cond .= " and $field <= $value";
                    } else if ($op == 'greater') {
                        $cond .= " and $field > $value";
                    } else if ($op == 'greaterorequal') {
                        $cond .= " and $field >= $value";
                    }
                }
            }
        }
		
		$total = $this->db->query('SELECT *, datediff(`t_spk_duedate`, CURRENT_DATE ) AS Selisih, 
									IF(t_spk_closed >= t_spk_duedate,"TIDAK TERCAPAI","OK") AS Keterangan
									FROM `t_spk`
									LEFT JOIN departemen
									ON t_spk.t_spk_dept=departemen.departemen_id
									WHERE '.$cond);
        
        $query = $this->db->query('SELECT *, datediff(`t_spk_duedate`, CURRENT_DATE ) AS Selisih,
									IF(t_spk_closed >= t_spk_duedate,"TIDAK TERCAPAI","OK") AS Keterangan
									FROM `t_spk`
									LEFT JOIN departemen
									ON t_spk.t_spk_dept=departemen.departemen_id
									WHERE '.$cond.
                                    ' ORDER BY '.$sort.' '.$order.
                                    ' LIMIT '.$offset.', '.$rows);

        $data = array();
        foreach ($query->result() as $row) {
            array_push($data, $row);
        }

        $result = array();
        $result["total"] = $total;
        $result['rows'] = $data;

        return json_encode($result);
    }

    function create($t_spk_respontime, $t_spk_jenis, $t_spk_man, $t_spk_user, $t_spk_dept, $t_spk_uraian,  $t_spk_duedate)
    {
        $query = $this->db->insert(self::$table, array(
			't_spk_respontime'  => $t_spk_respontime,
            't_spk_jenis'       => $t_spk_jenis,
            't_spk_man'         => $t_spk_man,
            't_spk_user'        => $t_spk_user,
            't_spk_dept'        => $t_spk_dept,
            't_spk_uraian'      => $t_spk_uraian,
            't_spk_duedate'     => $t_spk_duedate

        ));

        if ($query) {
            return json_encode(array('success' => true, 'test' => '50'));
        } else {
            return json_encode(array('success' => false, 'error' => $this->db->_error_message()));
        }
    }



    function update($t_spk_id, $t_spk_respontime, $t_spk_jenis, $t_spk_man, $t_spk_user, $t_spk_dept, $t_spk_uraian,  $t_spk_duedate)
    {
        $this->db->where('t_spk_id', $t_spk_id);
        $query = $this->db->update(self::$table, array(
            't_spk_respontime'  => $t_spk_respontime,
            't_spk_jenis'       => $t_spk_jenis,
            't_spk_man'         => $t_spk_man,
            't_spk_user'        => $t_spk_user,
            't_spk_dept'        => $t_spk_dept,
            't_spk_uraian'      => $t_spk_uraian,
            't_spk_duedate'     => $t_spk_duedate
        ));
        if ($query) {
            return json_encode(array('success' => true));
        } else {
            return json_encode(array('success' => false, 'error' => $this->db->_error_message()));
        }
    }



    function ceklis_spk($t_spk_id, $t_spk_closed, $t_spk_perbaikan)
    {
        $this->db->where('t_spk_id', $t_spk_id);
        $query = $this->db->update(self::$table, array(
            't_spk_closed'          => $t_spk_closed,
            't_spk_perbaikan'       => $t_spk_perbaikan,

        ));
        if ($query) {
            return json_encode(array('success' => true));
        } else {
            return json_encode(array('success' => false, 'error' => $this->db->_error_message()));
        }
    }

    function getDept($q)
    {
        $this->db->select('*');
        $this->db->where('departemen_induk > 0');
        $this->db->like('departemen_nama', $q);
        $query  = $this->db->get(self::$table2);

        $data = array();
        foreach ($query->result() as $row) {
            array_push($data, $row);
        }
        return json_encode($data);
    }
    
    function exportExcel($t_spk_tgl_start, $t_spk_tgl_end){
		
		
        $this->db->select(" * , IF(t_spk_duedate > t_spk_closed, '0', '1') AS skor ");  //SELECT * , IF(`t_spk_duedate`> `t_spk_closed`, "0", "1") AS nilai FROM `t_spk` WHERE 1
        $this->db->where('t_spk_tgl_pembuatan >=', $t_spk_tgl_start);
        $this->db->where('t_spk_tgl_pembuatan <=', $t_spk_tgl_end);
        $this->db->join(self::$table2, 'departemen_id=t_spk_dept', 'left');
        
        $detail = $this->db->get(self::$table);
		
		
        $result = array();
		$result['detail'] = $detail;
        
        return $result;      
    }
}

/* End of file m_tiket.php */
/* Location: ./application/models/transaksi/m_tiket.php */

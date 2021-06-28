<?php

/**
 * 
 */
class M_highcharts extends CI_Model
{
	/////// HEADING ////////////////// HEADING ///////////// HEADING //////

    function report($a){
        $query = $this->db->query("SELECT * from t_oee WHERE t_oee_mesin = 'heading ".$a."' order by t_oee_tanggal ASC limit 5");
        //$query = $this->db->query("SELECT * from t_oee order by t_oee_tanggal desc limit 5");

        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function report_p($a){
        $query = $this->db->query("SELECT * from t_productivity WHERE t_productivity_mesin = 'heading ".$a."' order by t_productivity_tanggal ASC limit 5");
        //$query = $this->db->query("SELECT * from t_productivity order by t_productivity_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }


    function report_out($a){
        $query = $this->db->query("SELECT * from t_output WHERE t_output_mesin = 'heading ".$a."' order by t_output_tanggal ASC limit 5");
        //$query = $this->db->query("SELECT * from t_output order by t_output_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function report_wh($a){
        $query = $this->db->query("SELECT * from t_working_hour WHERE t_working_hour_mesin = 'heading ".$a."' order by t_working_hour_tanggal ASC limit 5");
        //$query = $this->db->query("SELECT * from t_output order by t_output_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
    

    function indexOk(){
        //$this->db->select('kat_proses_nama, SUM(transaction_pcs) AS Qty');
        //$this->db->join(self::$table3, 't_proc_item=m_item_id', 'left')
                 //->join(self::$table4, 't_proc_proc=m_process_cat_id', 'left');
        //$this->db->where('t_proc_proc < 213');
        //$this->db->group_by('transaction_proses');
        //$this->db->order_by('transaction_proses ASC');
        $query  = $this->db->get('t_productivity');
                   
        //$data = array();
        foreach ( $query->result() as $row ){
            //array_push($data, $row); 
            $hasil[]= $row;
        }       
        //return json_encode($data);
        return $hasil;
    }

    ///////// ROLLING ///////////////// ROLLING //////////////// ROLLING /////

    function R_report($a){
        $query = $this->db->query("SELECT * from t_oee WHERE t_oee_mesin = 'rolling ".$a."' order by t_oee_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_oee order by t_oee_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function R_report_p($a){
        $query = $this->db->query("SELECT * from t_productivity WHERE t_productivity_mesin = 'rolling ".$a."' order by t_productivity_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_productivity order by t_productivity_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function R_report_out($a){
        $query = $this->db->query("SELECT * from t_output WHERE t_output_mesin = 'rolling ".$a."' order by t_output_tanggal DESC limit 5");

        //$query = $this->db->query("SELECT * from t_output order by t_output_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function R_report_wh($a){
        $query = $this->db->query("SELECT * from t_working_hour WHERE t_working_hour_mesin = 'rolling ".$a."' order by t_working_hour_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_working_hour order by t_working_hour_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

     ///////// FORMING ///////////////// FORMING //////////////// FORMING /////

    function fm_report($a){
        $query = $this->db->query("SELECT * from t_oee WHERE t_oee_mesin = 'forming ".$a."' order by t_oee_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_oee order by t_oee_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function fm_report_p($a){
        $query = $this->db->query("SELECT * from t_productivity WHERE t_productivity_mesin = 'forming ".$a."' order by t_productivity_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_productivity order by t_productivity_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function fm_report_out($a){
        $query = $this->db->query("SELECT * from t_output WHERE t_output_mesin = 'forming ".$a."' order by t_output_tanggal DESC limit 5");

        //$query = $this->db->query("SELECT * from t_output order by t_output_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function fm_report_wh($a){
        $query = $this->db->query("SELECT * from t_working_hour WHERE t_working_hour_mesin = 'forming ".$a."' order by t_working_hour_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_working_hour order by t_working_hour_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }


     ///////// pressing ///////////////// pressing //////////////// pressing /////

    function press_report($a){
        $query = $this->db->query("SELECT * from t_oee WHERE t_oee_mesin = 'pressing ".$a."' order by t_oee_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_oee order by t_oee_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function press_report_p($a){
        $query = $this->db->query("SELECT * from t_productivity WHERE t_productivity_mesin = 'pressing ".$a."' order by t_productivity_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_productivity order by t_productivity_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function press_report_out($a){
        $query = $this->db->query("SELECT * from t_output WHERE t_output_mesin = 'pressing ".$a."' order by t_output_tanggal DESC limit 5");

        //$query = $this->db->query("SELECT * from t_output order by t_output_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function press_report_wh($a){
        $query = $this->db->query("SELECT * from t_working_hour WHERE t_working_hour_mesin = 'pressing ".$a."' order by t_working_hour_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_working_hour order by t_working_hour_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }


     ///////// slotting ///////////////// slotting //////////////// slotting /////

    function sl_report($a){
        $query = $this->db->query("SELECT * from t_oee WHERE t_oee_mesin = 'slotting ".$a."' order by t_oee_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_oee order by t_oee_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function sl_report_p($a){
        $query = $this->db->query("SELECT * from t_productivity WHERE t_productivity_mesin = 'slotting ".$a."' order by t_productivity_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_productivity order by t_productivity_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function sl_report_out($a){
        $query = $this->db->query("SELECT * from t_output WHERE t_output_mesin = 'slotting ".$a."' order by t_output_tanggal DESC limit 5");

        //$query = $this->db->query("SELECT * from t_output order by t_output_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function sl_report_wh($a){
        $query = $this->db->query("SELECT * from t_working_hour WHERE t_working_hour_mesin = 'slotting ".$a."' order by t_working_hour_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_working_hour order by t_working_hour_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }


     ///////// trimming ///////////////// trimming //////////////// trimming /////

    function tr_report($a){
        $query = $this->db->query("SELECT * from t_oee WHERE t_oee_mesin = 'trimming ".$a."' order by t_oee_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_oee order by t_oee_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function tr_report_p($a){
        $query = $this->db->query("SELECT * from t_productivity WHERE t_productivity_mesin = 'trimming ".$a."' order by t_productivity_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_productivity order by t_productivity_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function tr_report_out($a){
        $query = $this->db->query("SELECT * from t_output WHERE t_output_mesin = 'trimming ".$a."' order by t_output_tanggal DESC limit 5");

        //$query = $this->db->query("SELECT * from t_output order by t_output_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function tr_report_wh($a){
        $query = $this->db->query("SELECT * from t_working_hour WHERE t_working_hour_mesin = 'trimming ".$a."' order by t_working_hour_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_working_hour order by t_working_hour_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    
     ///////// cutting ///////////////// cutting //////////////// cutting /////

    function ct_report($a){
        $query = $this->db->query("SELECT * from t_oee WHERE t_oee_mesin = 'cutting ".$a."' order by t_oee_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_oee order by t_oee_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function ct_report_p($a){
        $query = $this->db->query("SELECT * from t_productivity WHERE t_productivity_mesin = 'cutting ".$a."' order by t_productivity_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_productivity order by t_productivity_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function ct_report_out($a){
        $query = $this->db->query("SELECT * from t_output WHERE t_output_mesin = 'cutting ".$a."' order by t_output_tanggal DESC limit 5");

        //$query = $this->db->query("SELECT * from t_output order by t_output_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }

    function ct_report_wh($a){
        $query = $this->db->query("SELECT * from t_working_hour WHERE t_working_hour_mesin = 'cutting ".$a."' order by t_working_hour_tanggal DESC limit 5");
        //$query = $this->db->query("SELECT * from t_working_hour order by t_working_hour_tanggal desc limit 5");
         
        if($query->num_rows() > 0){
            foreach($query->result() as $data){
                $hasil[] = $data;
            }
            return $hasil;
        }
    }
}

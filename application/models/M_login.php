<?php
class M_login extends CI_Model{
    function auth_admin($username,$password){
        $query=$this->db->query("SELECT * FROM a_user WHERE a_user_username='$username' AND a_user_password=MD5('$password') AND a_user_level='1' LIMIT 1");
        return $query;
    }

	function cek_login($table,$where){		
		return $this->db->get_where($table,$where);
	}	

	function tampil_user(){
		return $this->db->query('SELECT * FROM a_user');
	}
}

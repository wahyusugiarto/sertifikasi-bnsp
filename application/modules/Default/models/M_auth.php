<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class M_auth extends CI_Model {
	
	public function login($user, $pass) {
		$this->db->select('');
		$this->db->from('admin');
		$this->db->where('username', $user);
		$this->db->where('password', md5($pass));
		$this->db->join('grup', 'grup.grup_id = admin.grup_id');
		$data = $this->db->get();

		if ($data->num_rows() == 1) {
			$result = $data->row();
			$sessiondata['id']			    = $result->id;
			$sessiondata['username']		= $result->username;
			$sessiondata['password']		= $result->password;
			$sessiondata['nama']		    = $result->nama;
			$sessiondata['email']			= $result->email;
			$sessiondata['grup_id']			= $result->grup_id;
			$sessiondata['foto']			= $result->foto;
			$sessiondata['status']			= $result->status;
			$sessiondata['id_bengkel']		= $result->id_bengkel;
			$this->session->set_userdata($sessiondata);
			return $data->row();
			
		} else {
			return false;
		}
	}
	
	function update($id,$stat)
    {
        $data['status'] = $stat;
        $this->db->where('id', $id);
        $this->db->update('admin', $data);
        return TRUE;
    }
	
	function update_user($id,$data)
    {
        $this->db->where('id', $id);
        $this->db->update('admin', $data);
        return TRUE;
    }

    public function update_cookie($data, $id)
    {
        $this->db->where('id', $id);
        $this->db->update('admin', $data);
    }

    public function get_by_cookie($cookie)
    {
        $this->db->where('cookie', $cookie);
        return $this->db->get('admin');
    }
	
	
	
	
}

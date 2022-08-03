<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Login_Model extends CI_Model {
	public function getMatchedUser($username) {
		// check either the username is a 'NIP' or an valid user username
		if (preg_match('/\d{18}/', $username)) {
			return $this->db->where('nip', $username)->get('kepala_sekolah')->row();
		}

		return $this->db->where('username', $username)->get('user')->row();
	}
}

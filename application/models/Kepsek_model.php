<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Kepsek_Model extends CI_Model {
	protected string $table = 'kepala_sekolah';

	public function create($data) {
		return $this->db->insert($this->table, array_merge($data, [
			'password' => md5($data['nip'])
		]));
	}

	public function deleteById($id) {
		return $this->db->where('id', $id)->delete($this->table);
	}

	public function getAll() {
		return $this->db->get($this->table)->result();
	}

	public function getById($id) {
		return $this->db->where('id', $id)->get($this->table)->row();
	}

	public function updateById($id, $data) {
		return $this->db->where('id', $id)->update($this->table, $data);
	}
}

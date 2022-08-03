<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Users_model extends CI_Model {

    public function cek_user($username)
    {
		return $this->db->where('username', $username)->get('user')->result();
    }

    public function getLevel($level)
    {
        return $this->db->where('id_user_grup',$level)->get('user');
    }

    public function getById($id)
    {
        return $this->db->where('id', $id)->get('user');
    }

    public function getAll()
    {
        return $this->db->get('user');
    }

    public function gantiStatus($id,$status)
    {
        $data = array('status'=>$status);
        $query = $this->db->where('id', $id)->update('user',$data);

		return (bool) $query;
    }

    public function tambah($foto,$level)
    {
        $data=array(
            'id_user_grup'	=> $level,
            'nama_depan'	=> $this->input->post('nama_depan'),
            'nama_belakang'	=> $this->input->post('nama_belakang'),
			'tgl_lahir'		=> $this->input->post('tgl_lahir'),
            'jenis_kelamin'	=> $this->input->post('jenis_kelamin'),
            'telp'			=> $this->input->post('telp'),
            'alamat'		=> $this->input->post('alamat'),
            'email'			=> $this->input->post('email'),
            'username'		=> $this->input->post('username'),
            'password'		=> md5($this->input->post('username')),
            'status'		=> 'nonaktif',
            'foto'			=> $foto
        );

		// only run when the submitted data is detected as
		// the "alumni" type of levels, when detected, 
		// it will automatically injecting additional
		// data to the array so the array will fit
		// the data provided in the database
		if ($level == "3") {
			$data = array_merge($data, [
				'angkatan' 			=> $this->input->post('angkatan'),
				'bidang_pekerjaan' 	=> $this->input->post('bidang_pekerjaan'),
				'konsentrasi' 		=> $this->input->post('konsentrasi'),
				'kota' 				=> $this->input->post('kota'),
				'tahun_lulus' 		=> $this->input->post('tahun_lulus')
			]);
		}

        $query=$this->db->insert('user',$data);

        return (bool) $query;
    }

    public function update($id,$new_foto)
    {
        if ($this->session->userdata('id_user_grup')==3) {
            $data=array(
                'nama_depan'		=> $this->input->post('nama_depan'),
                'nama_belakang'		=> $this->input->post('nama_belakang'),
                'jenis_kelamin'		=> $this->input->post('jenis_kelamin'),
                'tgl_lahir'			=> $this->input->post('tgl_lahir'),
                'telp'				=> $this->input->post('telp'),
                'email'				=> $this->input->post('email'),
                'alamat'			=> $this->input->post('alamat'),
                'username'			=> $this->input->post('username'),
                'tahun_lulus'		=> $this->input->post('tahun_lulus'),
                'mulai_kerja'		=> $this->input->post('mulai_kerja'),
                'angkatan'			=> $this->input->post('angkatan'),
                'konsentrasi'		=> $this->input->post('konsentrasi'),
                'bidang_pekerjaan'	=> $this->input->post('bidang_pekerjaan'),
                'alamat_kerja'		=> $this->input->post('alamat_kerja'),
                'kota'				=> $this->input->post('kota'),
                'foto'				=> $new_foto
            );
        }else{
            $data=array(
                'nama_depan'	=> $this->input->post('nama_depan'),
                'nama_belakang'	=> $this->input->post('nama_belakang'),
                'jenis_kelamin'	=> $this->input->post('jenis_kelamin'),
                'telp'			=> $this->input->post('telp'),
                'email'			=> $this->input->post('email'),
                'alamat'		=> $this->input->post('alamat'),
                'username'		=> $this->input->post('username'),
                'foto'			=> $new_foto
            );
        }
        
        $query = $this->db->where('id',$id)->update('user', $data);
		return (bool) $query;
    }

    public function edit($id,$foto)
    {
        $data = array(
            'nama' 			=> $this->input->post('nama'),
            'nomor_induk' 	=> $this->input->post('nomor_induk'),
            'jenis_kelamin' => $this->input->post('jenis_kelamin'),
            'telepon' 		=> $this->input->post('telepon'),
            'email' 		=> $this->input->post('email'),
            'konsentrasi' 	=> $this->input->post('konsentrasi'),
            'angkatan' 		=> $this->input->post('angkatan'),
            'jabatan' 		=> $this->input->post('jabatan'),
            'foto' 			=> $foto
        );

        $query = $this->db->where('id', $id)->update('users',$data);
		return (bool) $query;
    }

    public function delete($id)
    {
        $query = $this->db->where('id', $id)->delete('user');
		return (bool) $query;
    }

    public function daftar($foto)
    {
        $data=array(
            'id_user_grup'		=> 3,
            'nama_depan'		=> $this->input->post('nama_depan'),
            'nama_belakang'		=> $this->input->post('nama_belakang'),
            'jenis_kelamin'		=> $this->input->post('jenis_kelamin'),
            'tgl_lahir'			=> $this->input->post('tanggal_lahir'),
            'telp'				=> $this->input->post('telp'),
            'email'				=> $this->input->post('email'),
            'alamat'			=> $this->input->post('alamat'),
            'username'			=> $this->input->post('username'),
            'password'			=> md5($this->input->post('password')),
            'tahun_lulus'		=> $this->input->post('tahun_lulus'),
            'mulai_kerja'		=> $this->input->post('mulai_kerja'),
            'angkatan'			=> $this->input->post('angkatan'),
            'konsentrasi'		=> $this->input->post('konsentrasi'),
            'bidang_pekerjaan'	=> $this->input->post('bidang_pekerjaan'),
            'alamat_kerja'		=> $this->input->post('alamat_kerja'),
            'kota'				=> $this->input->post('kota'),
            'foto'				=> $foto,
            'status'			=> 'nonaktif'
        );

        $query=$this->db->insert('user',$data);
		return (bool) $query;
    }

    public function ubahpassword($id)
    {
        $cek = $this->db->get_where('user', ['id'=>$id]);

        if ($cek->num_rows()>0) {
            foreach($cek->result() as $user) {
                $password = $user->password;
            }

            if (md5($this->input->post('old_password'))==$password) {
                $password_baru = array('password'=>md5($this->input->post('new_password')));
                $query = $this->db->where('id', $id)->update('user',$password_baru);

				return (bool) $query;
            } else {
                return false;
            }
        } else {
            return false;
        }
    }

}

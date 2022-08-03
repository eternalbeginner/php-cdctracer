<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Loker_model extends CI_Model
{
    public function create($id, $foto)
    {
        $data = array(
            'id_user'     => $id,
            'judul'     => $this->input->post('judul'),
            'deskripsi' => $this->input->post('deskripsi'),
            'tgl_buat'    => $this->input->post('tgl_buat'),
            'tgl_akhir'    => $this->input->post('tgl_akhir'),
            'foto'        => $foto,
            'status'    => 'unpublish'
        );

        $query = $this->db->insert('loker', $data);
        return (bool) $query;
    }

    public function deleteById($id)
    {
        return $this->db->delete('loker', ['id' => $id]);
    }

    public function getAll()
    {
        return $this->db->where('status', 'publish')->get('loker');
    }

    public function getAllAdmin()
    {
        return $this->db
            ->select('l.*, u.nama_depan, u.nama_belakang')
            ->from('loker l')
            ->join('user u', 'l.id_user = u.id', 'inner')
            ->get()
            ->result();
    }

    public function getById($id)
    {
        return $this->db
            ->select('l.*, u.nama_depan, u.nama_belakang')
            ->from('loker l')
            ->join('user u', 'l.id_user = u.id', 'inner')
            ->where('l.id', $id)
            ->get()
            ->row();
    }

    public function getByIdAdmin($id)
    {

        return $this->db
            ->select('l.judul,l.deskripsi,l.tgl_buat, l.tgl_akhir,l.foto,l.status, u.nama_depan, u.nama_belakang')
            ->from('loker l')
            ->join('user u', 'l.id_user = u.id', 'inner')
            ->where('l.id', $id)
            ->get()
            ->row();
    }

    public function updateById($id, $data)
    {
        return $this->db->where('id', $id)->update('loker', $data);
    }
}

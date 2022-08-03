<?php

defined('BASEPATH') or exit('No direct script access allowed');

class Loker extends CI_Controller
{
    private function _loadView($viewName, $viewData)
    {
        $this->load->view('backend/include/head');
        $this->load->view('backend/include/navbar');
        $this->load->view('backend/include/sider');
        $this->load->view($viewName, $viewData);
        $this->load->view('backend/include/footer');
    }

    private function _redirectWithFlash($options)
    {
        $this->session->set_flashdata('alert', true);
        $this->session->set_flashdata('alert_data', [
            'type' => $options['flash_type'],
            'message' => $options['flash_message']
        ]);

        return redirect($options['fallback']);
    }

    public function index()
    {
        $this->load->model('loker_model');

        $data = [
            'loker' => $this->loker_model->getAllAdmin(),
            'user'  => (object) $this->session->userdata(),
        ];

        $this->_loadView('backend/loker/index', $data);
    }

    public function create($id)
    {

        $this->load->model('loker_model');
        $config['upload_path']          = './assets/loker/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['max_size']             = 15000;
        $config['max_width']            = 10000;
        $config['max_height']           = 10000;

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload('foto')) {
            $this->session->set_flashdata('kondisi', '0');
            $this->session->set_flashdata('msg', 'Tambah Loker Gagal');

            redirect('admin/loker');
        }

        $foto = $this->upload->data('file_name');
        $query = $this->loker_model->create($id, $foto);

        if (!(bool) $query) {
            $this->session->set_flashdata('kondisi', '0');
            $this->session->set_flashdata('msg', 'Loker gagal ditambahkan');
            redirect('admin/loker');
        }

        $this->session->set_flashdata('kondisi', '1');
        $this->session->set_flashdata('msg', 'Loker berhasil ditambahkan');
        redirect('admin/loker');
    }


    // sisanya di frontend loker.php
}

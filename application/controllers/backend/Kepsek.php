<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Kepsek extends CI_Controller
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
		$this->load->model('kepsek_model');

		$data = [
			'kepsek' => $this->kepsek_model->getAll(),
			'user' => (object) $this->session->userdata()
		];

		$this->_loadView('backend/kepsek/index', $data);
	}

	public function detail($id)
	{
		$this->load->model('kepsek_model');

		$data = [
			'kepsek' => $this->kepsek_model->getById($id),
			'user' => (object) $this->session->userdata()
		];

		$this->_loadView('backend/kepsek/detail', $data);
	}

	public function hapus($id)
	{
		$this->load->model('kepsek_model');
		$query = $this->kepsek_model->deleteById($id);

		if (!(bool) $query) {
			return $this->_redirectWithFlash([
				'flash_type' => 'danger',
				'flash_message' => 'Gagal menghapus data!',
				'fallback' => 'admin/kepsek/' . $id . '/detail'
			]);
		}

		return $this->_redirectWithFlash([
			'flash_type' => 'success',
			'flash_message' => 'Berhasil menghapus data!',
			'fallback' => 'admin/kepsek/'
		]);
	}

	public function tambah()
	{
		$this->load->model('kepsek_model');

		$data = $this->input->post();
		$query = $this->kepsek_model->create($data);

		if (!(bool) $query) {
			$this->session->set_flashdata('kondisi', '0');
			$this->session->set_flashdata('msg', 'Data gagal ditambahkan');
			redirect('admin/loker');
		}

		$this->session->set_flashdata('kondisi', '1');
		$this->session->set_flashdata('msg', 'Data berhasil ditambahkan');
		redirect('admin/kepsek');
	}

	public function update($id)
	{

		$this->load->model('kepsek_model');

		$data = $this->input->post();
		$query = $this->kepsek_model->updateById($id, $data);

		if (!(bool) $query) {
			$this->session->set_flashdata('kondisi', '0');
			$this->session->set_flashdata('msg', 'Data gagal diupdate');
			redirect('admin/kepsek');
		}

		$this->session->set_flashdata('kondisi', '1');
		$this->session->set_flashdata('msg', 'Data berhasil diupdate');
		redirect('admin/kepsek');
	}
}

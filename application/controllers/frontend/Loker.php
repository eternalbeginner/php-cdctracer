<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Loker extends CI_Controller
{

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see https://codeigniter.com/user_guide/general/urls.html
	 */

	public function __construct()
	{
		parent::__construct();

		if ($this->session->userdata('isLogin') != "1") {
			return redirect('login');
		}

		$this->load->model('loker_model');
	}



	// public function create($id)
	// {
	//     $config['upload_path']          = './assets/loker/';
	// 	$config['allowed_types']        = 'gif|jpg|png|jpeg';
	// 	$config['max_size']             = 15000;
	// 	$config['max_width']            = 10000;
	//     $config['max_height']           = 10000;

	//     $this->load->library('upload', $config);

	//     if (!$this->upload->do_upload('foto')) {
	//         $this->session->set_flashdata('kondisi','0');
	//         $this->session->set_flashdata('msg','Tambah Loker Gagal');

	//         return redirect('alumni');
	//     }

	// 	$foto = $this->upload->data('file_name');
	// 	$query = $this->loker_model->create($id,$foto);

	// 	if ((bool) $query) {
	// 		$this->session->set_flashdata('kondisi','1');
	// 		$this->session->set_flashdata('msg','Tambah Loker Berhasil');

	// 		return redirect('alumni');
	// 	}

	// 	$this->session->set_flashdata('kondisi','0');
	// 	$this->session->set_flashdata('msg','Tambah Loker Gagal');

	// 	return redirect('alumni');
	// }

	public function delete($id)
	{
		$this->load->model('loker_model');
		$query = $this->loker_model->deleteById($id);

		// if the query is not false or it's an instance
		// of CI_DB class, then assume the process
		// was executed successfully
		if ($query || (bool) $query) {
			$this->session->set_flashdata('kondisi', '1');
			$this->session->set_flashdata('msg', 'Loker berhasil dihapus');

			redirect('admin/loker/');
		}

		$this->session->set_flashdata('kondisi', '0');
		$this->session->set_flashdata('msg', 'Loker gagal dihapus');

		redirect('admin/loker' . $id);
	}

	public function detail($id)
	{
		$data = [
			'loker' => $this->loker_model->getById($id),
			'user' => (object) $this->session->userdata()
		];

		$this->load->view('frontend/alumni/loker', $data);
	}

	public function update($id)
	{
		$data = $this->input->post();

		if (isset($_FILES['foto']) && $_FILES['foto']['error'] !== 4) {
			$config['upload_path']          = './assets/loker/';
			$config['allowed_types']        = 'gif|jpg|png|jpeg';
			$config['max_size']             = 15000;
			$config['max_width']            = 10000;
			$config['max_height']           = 10000;

			$this->load->library('upload', $config);

			if (!(bool) $this->upload->do_upload('foto')) {
				$this->session->set_flashdata('kondisi', '0');
				$this->session->set_flashdata('msg', 'Gagal mengupload foto loker');

				redirect('/admin/loker');
			}

			// delete file after uploading a new one and push the new file name
			$loker = $this->loker_model->getById($id)->row();
			unlink('./assets/loker/' . $loker->foto);
			$data = array_merge($data, ['foto' => $this->upload->data('file_name')]);
		}

		$query = $this->loker_model->updateById($id, $data);

		if ($query) {
			$this->session->set_flashdata('kondisi', '1');
			$this->session->set_flashdata('msg', 'Loker berhasil diperbarui');

			redirect('/admin/loker');
		}

		$this->session->set_flashdata('kondisi', '0');
		$this->session->set_flashdata('msg', 'Loker gagal diperbarui');

		redirect('admin/loker/');
	}
}

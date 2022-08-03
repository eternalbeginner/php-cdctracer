<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Dashboard extends CI_Controller
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
			redirect('login');
		}
	}

	public function index()
	{
		$this->load->model('users_model');
		$this->load->model('survey_model');
		$this->load->model('HasilKmeans_model');

		$this->load->model('survey_pertanyaan_model');
		$this->load->model('survey_jawaban_model');
		$this->load->model('jawaban_pertanyaan_model');

		$data['user'] = $this->users_model->getLevel(3)->num_rows();
		$data['userDosen'] = $this->users_model->getLevel(2)->num_rows();
		$data['usersDosen'] = $this->users_model->getLevel(2)->result();
		$data['users'] = $this->users_model->getLevel(3)->result();
		$data['survey'] = $this->survey_model->getAll()->num_rows();
		$data['kmeans'] = $this->HasilKmeans_model->getAll()->row();

		$selected_question = $_GET["q_id"] ?? 15;


		$data['id_pertanyaan'] = 15;

		// $data['pertanyaan'] = $this->survey_pertanyaan_model->getAll()->result();
		$data['jawaban'] = null;
		$data['pertanyaan_terpilih'] = null;
		$data['jawaban_terpilih'] = null;
		$data['pertanyaan_terpilih'] = $this->survey_pertanyaan_model->getByIdPertanyaan($selected_question)->row();
		$data['jawaban'] = $this->survey_jawaban_model->getAll()->result();
		$data['jawaban_terpilih'] = $this->jawaban_pertanyaan_model->getAll()->result();


		$this->load->view('backend/include/head');
		$this->load->view('backend/include/navbar');
		$this->load->view('backend/include/sider');
		$this->load->view('backend/dashboard', $data);
		$this->load->view('backend/include/footer');
	}
}

<?php
error_reporting(0);
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
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
	public function index()
	{
		if ($this->session->userdata('isLogin') == "1") {
			$this->session->set_userdata('login', 'Anda sudah login !');
			return redirect('alumni');
		}

		$this->load->view('login');
	}

	public function doLogin()
	{
		$this->load->model('login_model');

		$username = $this->input->post('username');
		$password = $this->input->post('password');

		$matched = $this->login_model->getMatchedUser($username);


		if (!(bool) $matched) {
			$this->session->set_flashdata('login', 'Username anda tidak terdaftar !');
			return redirect('login');
		}

		if (isset($matched->nip)) {
			$userdata = (array) $matched;
			$userdata = array_merge($userdata, ['isLogin' => '1']);
			$this->session->set_userdata($userdata);
			$this->session->set_flashdata('login', 'Login berhasil !');
			if ($matched->id_user_grup == '4') {
				return redirect('backend/survey/hasilSurvey');
			} else {
				return redirect('admin');
			}
		} else {
			if (md5($password) !== $matched->password) {
				$this->session->set_flashdata('login', 'Password anda tidak cocok !');
				return redirect('login');
			}
		}

		$userdata = (array) $matched;
		$userdata = array_merge($userdata, ['isLogin' => '1']);

		$this->session->set_userdata($userdata);
		$this->session->set_flashdata('login', 'Login berhasil !');

		if ($matched->id_user_grup == '3') {
			return redirect('alumni');
		}

		return redirect('admin');
	}

	public function logout()
	{
		$this->session->set_userdata('isLogin') == "0";
		$this->session->sess_destroy();

		redirect('login');
	}
}

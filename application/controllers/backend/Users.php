<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Reader\Csv;
use PhpOffice\PhpSpreadsheet\Reader\Xls;
use PhpOffice\PhpSpreadsheet\Reader\Xlsx;

$uploaded_file_column_order = [
	'id_user_grup',
	'nama_depan',
	'nama_belakang',
	'jenis_kelamin',
	'tgl_lahir',
	'telp',
	'email',
	'alamat',
	'username',
	'password',
	'tahun_lulus',
	'mulai_kerja',
	'angkatan',
	'konsentrasi',
	'bidang_pekerjaan',
	'alamat_kerja',
	'kota',
	'status',
	'foto'
];

$idx_of_pwd_field = array_search("password", $uploaded_file_column_order);

function getSheetReader($file_type) {
	switch ($file_type) {
		case "csv": return new Csv();
		case "xls": return new Xls();
		case "xlsx": return new Xlsx();
		default: return new Xlsx();
	}
}

function getSQLRowFields($cols) {
	return sprintf(
		"(%s)",
		implode(", ", $cols)
	);
}

function getSQLRowValues($values, $id_user_group) {
	global $idx_of_pwd_field;

	array_unshift($values, $id_user_group);
	array_push($values, "admin.jpg");

	$values[$idx_of_pwd_field] = password_hash(
		$values[$idx_of_pwd_field],
		PASSWORD_BCRYPT
	);

	return sprintf(
		"('%s')",
		implode("', '", $values)
	);
}

class Users extends CI_Controller {

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
    public function __construct(){
        parent::__construct();
        if ($this->session->userdata('isLogin')!="1") {
			redirect('login');
		}
        $this->load->model('users_model');
    }

	public function user($level)
	{
		$this->load->model('konsentrasi_model');
		$this->load->model('bidang_pekerjaan_model');
		$data['title'] = $level;
        $data['user'] = $this->users_model->getLevel($level)->result();
        $data['user2'] = $this->users_model->getLevel($level)->result();
        $data['konsentrasi'] = $this->konsentrasi_model->getAll()->result();
        $data['bidang_pekerjaan'] = $this->bidang_pekerjaan_model->getAll()->result();
		$this->load->view('backend/include/head');
		$this->load->view('backend/include/navbar');
		$this->load->view('backend/include/sider');
		$this->load->view('backend/users',$data);
		$this->load->view('backend/include/footer');
	}

	public function importUser($level)
	{
		global $uploaded_file_column_order;

		$config['upload_path']			= "./assets/upload";
		$config['allowed_types']		= 'xlsx|xls|csv';
		$config['max_size']				= 300000;
		$config['overwrite']			= true;
		$config['file_name']			= uniqid(rand());

		$this->load->library('upload', $config);
		$this->load->library('user_agent');

		if ($this->upload->do_upload('inp-imported-file')) {
			$sheetType = $this->upload->data("file_ext");
			$reader = getSheetReader(substr($sheetType, 1));

			$spreadsheet = $reader->load($this->upload->data("full_path"));
			$sheet = $spreadsheet->getActiveSheet();
			$sheetArr = $sheet->toArray();
			$sheetLen = count($sheetArr);

			// bulk insert query building, build the query string to insert
			// multiple users at same time
			$sqlRowFields = getSQLRowFields($uploaded_file_column_order);
			$sqlRowsValues = [];

			for ($idx = 1; $idx < $sheetLen; $idx++) {
				$current_row = $sheetArr[$idx];
				$sqlRowsValues[] = getSQLRowValues($current_row, $level);
			}

			$fullSQL = sprintf(
				"INSERT INTO user %s VALUES %s",
				$sqlRowFields,
				implode(', ', $sqlRowsValues)
			);

			// use the database instance to execute the query
			if ($this->db->query($fullSQL)) {
				$this->session->set_flashdata('kondisi','1');
            	$this->session->set_flashdata('status','Data berhasil di-import dan ditambahkan!');
			}
			
			// delete uploaded file after finishing the process
			// of convert and insert data into the database
			unlink($this->upload->data('full_path'));
		}

		return redirect($this->agent->referrer());
	}

	public function tambah($level)
    {
        $config['upload_path']          = './assets/user/';
		$config['allowed_types']        = 'gif|jpg|png|jpeg';
		$config['max_size']             = 15000;
		$config['max_width']            = 10000;
        $config['max_height']           = 10000;
        
        $this->load->library('upload', $config);

        if (! $this->upload->do_upload('foto')) {
            $this->session->set_flashdata('kondisi','0');
            $this->session->set_flashdata('status','Gambar terlalu besar !');
            redirect('backend/users/user/'.$level);
        }else{
            $foto = $this->upload->data('file_name');
            $data = $this->users_model->tambah($foto,$level);
            if ($data == TRUE) {
                $this->session->set_flashdata('kondisi','1');
                $this->session->set_flashdata('status','Data Berhasil disimpan !');
                redirect('backend/users/user/'.$level);
            }else{
                $this->session->set_flashdata('kondisi','0');
                $this->session->set_flashdata('status','Data Gagal diedit !');
                redirect('backend/users/user/'.$level);
            }
        }
	}
	
	public function update($id,$level)
    {
        $config['upload_path']          = './assets/user/';
        $config['allowed_types']        = 'gif|jpg|png|jpeg';
        $config['overwrite']			= true;
        $config['max_size']             = 15000; // 1MB
        $config['max_width']            = 5000;
        $config['max_height']           = 5000;

        $this->load->library('upload', $config);
        if ( ! $this->upload->do_upload('new_foto')){
			// $error = array('error' => $this->upload->display_errors());
            // $this->load->view('v_upload', $error);
            $new_foto=$this->input->post('old_foto');
            $data=$this->users_model->update($id,$new_foto);
            if($data==true){
                $this->session->set_flashdata('kondisi','1');
                $this->session->set_flashdata('status','update berhasil !');
                if ($this->session->userdata('id_user_grup')==3) {
                    redirect('alumni');
                }
                redirect('backend/users/user/'.$level);
            }else {
                $this->session->set_flashdata('kondisi','0');
                $this->session->set_flashdata('status','update gagal !');
                                if ($this->session->userdata('id_user_grup')==3) {
                                    redirect('alumni');
                                }
                redirect('backend/users/user/'.$level);
            }
		}else {
            $new_foto=$this->upload->data('file_name');
            $data=$this->users_model->update($id,$new_foto);
            if($data==true){
                $this->session->set_flashdata('kondisi','1');
                $this->session->set_flashdata('status','Edit data berhasil !');
                if ($this->session->userdata('id_user_grup')==3) {
                    redirect('alumni');
                }
                redirect('backend/users/user/'.$level);
            }else {
                $this->session->set_flashdata('kondisi','0');
                $this->session->set_flashdata('status','Edit data gagal !');
                        if ($this->session->userdata('id_user_grup')==3) {
                            redirect('alumni');
                        }
                redirect('backend/users/user/'.$level);
            }
        }
    }

	public function editStatus($id,$status,$level){
        if ($status=="nonaktif") {
            $newStatus = "nonaktif";
        }else{
            $newStatus = "aktif";
        }
        $data = $this->users_model->gantiStatus($id,$newStatus);
        if ($data == TRUE) {
            $this->session->set_flashdata('kondisi','1');
            $this->session->set_flashdata('status','Status Berhasil diganti !');
            redirect('backend/users/user/'.$level);
        }else{
            $this->session->set_flashdata('kondisi','0');
            $this->session->set_flashdata('status','Status Gagal diganti !');
            redirect('backend/users/user/'.$level);
        }
    }

    public function ubahpassword()
    {
        if($this->input->post('submit'))
        {
            if (md5($this->input->post('new_password'))!=md5($this->input->post('confirm_password'))) {
                if ($this->session->userdata('id_user_grup')==2) {
                    $this->session->set_flashdata('msg','password tidak sesuai');
                    redirect('backend/users/ubahpassword');
                }else if($this->session->userdata('id_user_grup')==3){
                    $this->session->set_flashdata('gantiPass','password tidak sesuai');
                    redirect('alumni');
                }
            }else{
                $where = $this->session->userdata('id');
                $data = $this->users_model->ubahpassword($where);
                if($data==true){
                    redirect('login/logout');
                }else {
                    if ($this->session->userdata('id_user_grup')==2) {
                        $this->session->set_flashdata('msg','ganti password gagal atau password lama salah!');
                        redirect('backend/users/ubahpassword');
                    }else if($this->session->userdata('id_user_grup')==3){
                        $this->session->set_flashdata('gantiPass','ganti password gagal atau password lama salah!');
                        redirect('alumni');
                    }
                }
            }
        }
        $this->load->view('backend/include/head');
		$this->load->view('backend/include/navbar');
        $this->load->view('backend/include/sider');
        $this->load->view('backend/ubahpassword');
		$this->load->view('backend/include/footer');
    }

    public function delete($id,$level){
        $data=$this->users_model->delete($id);
        if($data==true){
            $this->session->set_flashdata('kondisi','1');
			$this->session->set_flashdata('status','delete berhasil !');
			redirect('backend/users/user/'.$level);
		}else {
            $this->session->set_flashdata('kondisi','0');
			$this->session->set_flashdata('status','delete gagal !');
			redirect('backend/users/user/'.$level);
        }
    }
    public function alumni()
    {
        $this->load->model('loker_model');
        $this->load->model('survey_model');
        $this->load->model('konsentrasi_model');
		$this->load->model('bidang_pekerjaan_model');
        $data['user'] = $this->users_model->getById($this->session->userdata('id'))->row();
        $data['loker']=$this->loker_model->getAll()->result();
        $data['survey']=$this->survey_model->getAll()->result();
        $data['konsentrasi'] = $this->konsentrasi_model->getAll()->result();
        $data['bidang_pekerjaan'] = $this->bidang_pekerjaan_model->getAll()->result();
        $this->load->view('frontend/alumni/index',$data);
    }

    public function editProfil($id)
    {
        $this->load->model('konsentrasi_model');
		$this->load->model('bidang_pekerjaan_model');
        $data['user'] = $this->users_model->getById($id)->row();
        $data['konsentrasi'] = $this->konsentrasi_model->getAll()->result();
        $data['bidang_pekerjaan'] = $this->bidang_pekerjaan_model->getAll()->result();
        $this->load->view('frontend/alumni/editProfil',$data);
    }
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');

use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use PhpOffice\PhpSpreadsheet\Style\Border;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;

class Survey extends CI_Controller
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
		$this->load->model('survey_model');
	}

	public function detailSurvey()
	{
		$selected_question = $_GET["q_id"] ?? 15;

		$this->load->model('survey_pertanyaan_model');
		$this->load->model('survey_jawaban_model');
		$this->load->model('jawaban_pertanyaan_model');


		$data['id_pertanyaan'] = 15;

		// $data['pertanyaan'] = $this->survey_pertanyaan_model->getAll()->result();
		$data['jawaban'] = null;
		$data['pertanyaan_terpilih'] = null;
		$data['jawaban_terpilih'] = null;

		if (!is_null($selected_question)) {
			$data['pertanyaan_terpilih'] = $this->survey_pertanyaan_model->getByIdPertanyaan($selected_question)->row();
			$data['jawaban'] = $this->survey_jawaban_model->getAll()->result();
			$data['jawaban_terpilih'] = $this->jawaban_pertanyaan_model->getAll()->result();
		}

		$this->load->view('backend/include/head');
		$this->load->view('backend/include/navbar');
		$this->load->view('backend/include/sider');
		$this->load->view('backend/detailSurvey', $data);
		$this->load->view('backend/include/footer');
	}

	public function export($id)
	{
		$this->load->model('survey_model');

		$data = $this->survey_model->getExportedById($id);
		$dataLength = count($data);

		$spreadsheet = new Spreadsheet();
		$sheet = $spreadsheet->getActiveSheet();

		$spare = 3;
		$start = 1 + $spare;
		$prevRow = $data[0];

		// set columns autosizing
		$sheet->getColumnDimension('A')->setAutoSize(true);
		$sheet->getColumnDimension('B')->setAutoSize(true);
		$sheet->getColumnDimension('C')->setAutoSize(true);

		// set sheet title
		$sheet->setCellValue('A1', 'Data Survei');
		$sheet->mergeCells('A1:C1');

		$titleStyle = $sheet->getStyle('A1');

		$titleStyle->getFont()->setSize(20);
		$titleStyle->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		// set columns header
		$sheet->setCellValue('A3', 'Pertanyaan');
		$sheet->setCellValue('B3', 'Jawaban');
		$sheet->setCellValue('C3', 'Responden');

		$sheet->getStyle('A3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('B3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);
		$sheet->getStyle('C3')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

		foreach ($data as $index => $row) {
			$afterIndex = $index + $spare;

			// vcells alue setup
			$sheet->setCellValue('A' . ($afterIndex + 1), $row->pertanyaan);
			$sheet->setCellValue('B' . ($afterIndex + 1), $row->jawaban);
			$sheet->setCellValue('C' . ($afterIndex + 1), $row->responden);

			// merging cells
			if ($index === $dataLength - 1 || $prevRow->pertanyaan !== $row->pertanyaan) {
				$end = $index === $dataLength - 1 ? $afterIndex + 1 : $afterIndex;

				$sheet->mergeCells('A' . $start . ':A' . $end);

				$sheet
					->getStyle('A' . $start . ':A' . $end)
					->getAlignment()
					->setVertical(Alignment::VERTICAL_CENTER);

				$start = $afterIndex + 1;
			}

			$prevRow = $row;
		}

		// columns border styling
		$sheet
			->getStyle('A' . $spare . ':C' . ($dataLength + $spare))
			->getBorders()
			->getAllBorders()
			->setBorderStyle(Border::BORDER_THIN);

		// columns centering
		$sheet
			->getStyle('C' . ($spare + 1) . ':C' . ($dataLength + $spare))
			->getAlignment()
			->setHorizontal(Alignment::HORIZONTAL_CENTER);

		$file = new Xlsx($spreadsheet);
		$file->save('assets/report.xlsx');

		return redirect('assets/report.xlsx');
	}

	public function index()
	{
		$data['survey'] = $this->survey_model->getAll()->result();
		$data['survey2'] = $this->survey_model->getAll()->result();
		$this->load->view('backend/include/head');
		$this->load->view('backend/include/navbar');
		$this->load->view('backend/include/sider');
		$this->load->view('backend/survey', $data);
		$this->load->view('backend/include/footer');
	}

	public function detail($id)
	{
		$this->load->model('survey_pertanyaan_model');
		$data['title'] = $id;
		$data['survey'] = $this->survey_model->getById($id)->row();
		$data['surveyPertanyaan'] = $this->survey_pertanyaan_model->getById($id)->result();
		$data['surveyPertanyaan2'] = $this->survey_pertanyaan_model->getById($id)->result();
		$this->load->view('backend/include/head');
		$this->load->view('backend/include/navbar');
		$this->load->view('backend/include/sider');
		$this->load->view('backend/surveyDetail', $data);
		$this->load->view('backend/include/footer');
	}

	public function tambah($id)
	{
		$data = $this->survey_model->tambah($id);
		if ($data == true) {
			$this->session->set_flashdata('kondisi', '1');
			$this->session->set_flashdata('status', 'Data berhasil ditambahkan !');
			redirect('backend/survey');
		} else {
			$this->session->set_flashdata('kondisi', '0');
			$this->session->set_flashdata('status', 'Data gagal ditambahkan !');
			redirect('backend/survey');
		}
	}

	public function update($id)
	{
		$data = $this->survey_model->edit($id);
		if ($data == true) {
			$this->session->set_flashdata('kondisi', '1');
			$this->session->set_flashdata('status', 'Data berhasil ditambahkan !');
			redirect('backend/survey');
		} else {
			$this->session->set_flashdata('kondisi', '0');
			$this->session->set_flashdata('status', 'Data gagal ditambahkan !');
			redirect('backend/survey');
		}
	}

	public function delete($id)
	{
		$data = $this->survey_model->delete($id);
		if ($data == true) {
			$this->session->set_flashdata('kondisi', '1');
			$this->session->set_flashdata('status', 'delete berhasil !');
			redirect('backend/survey');
		} else {
			$this->session->set_flashdata('kondisi', '0');
			$this->session->set_flashdata('status', 'delete gagal !');
			redirect('backend/survey');
		}
	}

	public function survei($id)
	{
		$this->load->model('survey_pertanyaan_model');
		$this->load->model('jawaban_pertanyaan_model');
		$data['title'] = $id;
		$data['survey'] = $this->survey_model->getById($id)->row();
		$data['surveyPertanyaan'] = $this->survey_pertanyaan_model->getByIdPertanyaanSatu($id, 1)->row();
		$data['cekPertanyaan'] = $this->survey_pertanyaan_model->getByIdPertanyaan($id)->num_rows();
		$data['cekJawabanUser'] = $this->jawaban_pertanyaan_model->getById($id)->num_rows();
		$this->load->view('frontend/alumni/survei', $data);
	}

	public function lakukansurvei()
	{
		$idSurvei = $this->uri->segment(2);
		$idPertanyaan = $this->uri->segment(3);

		if ($this->input->post('submit')) {
			$this->load->model('jawaban_pertanyaan_model');
			$this->load->model('survey_pertanyaan_model');
			$input = $this->jawaban_pertanyaan_model->tambah($idSurvei, $idPertanyaan);
			$pertanyaan = $this->survey_pertanyaan_model->getById($idSurvei);
			foreach ($pertanyaan->result() as $pertanyaan) {
				if ($pertanyaan->id > $idPertanyaan) {
					$idPertanyaan = $pertanyaan->id;
					break;
				}
			}
		} else if ($this->input->post('save')) {
			$this->load->model('jawaban_pertanyaan_model');
			$input = $this->jawaban_pertanyaan_model->tambah($idSurvei, $idPertanyaan);
			$this->session->set_flashdata('hasilSurvey', 'Pengisian Survey Berhasil ! Terimakasih. Silahkan klik Home untuk Kembali atau Logout untuk keluar dari aplikasi. ');
			redirect('detailSurvey/' . $idSurvei);
		}
		$this->load->model('survey_pertanyaan_model');
		$this->load->model('survey_jawaban_model');
		$data['idSurvei'] = $idSurvei;
		$data['idPertanyaan'] = $idPertanyaan;
		$data['surveyPertanyaanLimitStart'] = $this->survey_pertanyaan_model->getByIdPertanyaanLimitStart($idSurvei, $idPertanyaan);
		$data['surveyPertanyaanLimit'] = $this->survey_pertanyaan_model->getByIdPertanyaanLimit($idSurvei, $idPertanyaan)->row();
		$data['surveyJawaban'] = $this->survey_jawaban_model->getByIdJawaban($idSurvei, $idPertanyaan)->result();
		$this->load->view('frontend/alumni/lakukanSurvei', $data);
	}

	public function hasilSurvey()
	{
		$this->load->model('survey_pertanyaan_model');
		$this->load->model('survey_jawaban_model');
		$this->load->model('jawaban_pertanyaan_model');

		$data['survey'] = $this->survey_model->getAll()->result();
		$data['surveyPertanyaan'] = $this->survey_pertanyaan_model->getAll()->result();
		$data['surveyJawaban'] = $this->survey_jawaban_model->getAll()->result();
		$data['cekJawabanUser'] = $this->jawaban_pertanyaan_model->getAll()->result();
		$this->load->view('backend/include/head');
		$this->load->view('backend/include/navbar');
		$this->load->view('backend/include/sider');
		$this->load->view('backend/hasilSurvey', $data);
		$this->load->view('backend/include/footer');
	}
}

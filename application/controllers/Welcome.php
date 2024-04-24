<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Welcome extends CI_Controller
{

	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('m_admin');
		$language = $this->session->userdata('language');
		$this->lang->load('general', $language);
	}
	public function index()
	{

		$this->load->view('public/test/Lang');
	}
	public function show_pdf()
	{
		header("content-type: application/pdf");
		readfile('src/assets/pdf/output.pdf');
	}
	public function mail()
	{
		include APPPATH . 'third_party/phpmailer/src/Exception.php';
		include APPPATH . 'third_party/phpmailer/src/PHPMailer.php';
		include APPPATH . 'third_party/phpmailer/src/SMTP.php';
		$this->load->view('public/test/test_mail');
	}
	function lang_change()
	{
		$language = $this->input->post('lan');
		$this->session->set_userdata('language', $language);
		$this->session->set_flashdata('suc', 'Successfully language Change at ' .
			ucfirst($language));
		echo '1';

	}
}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mail extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('m_admin');
		$language = $this->session->userdata('language');
		$this->lang->load('general', $language);
		// if (!$this->m_admin->is_login()) {
		// 	redirect('AuthAdmin/Login');
		// } else {
		// 	require_once 'set_menu.php';
		// }
	}
	public function index()
	{
		echo 'masuk ke controller mail/index';
	}
	public function push($as, $qrcode, $redirect)
	{

		include APPPATH . 'third_party/phpmailer/src/Exception.php';
		include APPPATH . 'third_party/phpmailer/src/PHPMailer.php';
		include APPPATH . 'third_party/phpmailer/src/SMTP.php';

		$this->data['as'] = $as;
		$this->data['redirect'] = $redirect;
		$this->data['Gatepass'] = $this->m_admin->GetGatepassForMail($qrcode);
		$this->load->view('public/mail/Send_mail', $this->data);

	}
	public function pushbyemail($as, $qrcode, $what)
	{

		include APPPATH . 'third_party/phpmailer/src/Exception.php';
		include APPPATH . 'third_party/phpmailer/src/PHPMailer.php';
		include APPPATH . 'third_party/phpmailer/src/SMTP.php';

		$this->data['as'] = $as;
		$this->data['what'] = $what;
		$this->data['Gatepass'] = $this->m_admin->GetGatepassForMail($qrcode);
		$this->load->view('public/mail/Send_mail2', $this->data);

	}
	public function approve_from_mail($what, $as, $qrcode, $id_verifikasi, $id_gatepass)
	{
		if ($what == 1) {
			$this->m_admin->AcceptGatepassFromMail($what, $as, $qrcode, $id_verifikasi, $id_gatepass);
		} else {
			$this->m_admin->RejectGatepassFromMail($what, $as, $qrcode, $id_verifikasi, $id_gatepass);
		}
	}






}

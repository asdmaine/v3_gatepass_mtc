<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Mail extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('m_admin');
		$this->load->model('m_signature');
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
		$this->data['pst_pnr'] = 0;
		$this->data['what'] = $what;
		$this->data['as'] = $as;
		$this->data['qrcode'] = $qrcode;
		$this->data['id_verifikasi'] = $id_verifikasi;
		$this->data['id_gatepass'] = $id_gatepass;

		// ambil pst_pnr
		$gatepass = $this->m_admin->getpstpnrfromgatepass($id_gatepass);
		if ($as == 'requested') {
			$this->data['pst_pnr'] = $gatepass[0]->requestedby_pst_pnr;
		} else if ($as == 'recommended') {
			$this->data['pst_pnr'] = $gatepass[0]->recommendedby_pst_pnr;
		} else if ($as == 'approved') {
			$this->data['pst_pnr'] = $gatepass[0]->approvedby_pst_pnr;
		} else if ($as == 'acknowledged') {
			$this->data['pst_pnr'] = $gatepass[0]->acknowledgedby_pst_pnr;
		}


		// cek apakah sudah buat signature
		$num = $this->m_admin->cekSignature($this->data['pst_pnr']);
		if ($num < 1) {
			$this->data['signSet'] = 0;
			$this->load->view('public/mail/Sig_mail', $this->data);
		} else {
			// cek apakah sudah pernah
			$verif = 3;
			if ($as == 'recommended') {
				$verif = $this->m_admin->cekrecommended($id_verifikasi, $id_gatepass);
			} else if ($as == 'approved') {
				$verif = $this->m_admin->cekapproved($id_verifikasi, $id_gatepass);
			} else if ($as == 'acknowledged') {
				$verif = $this->m_admin->cekacknowledged($id_verifikasi, $id_gatepass);
			}
			if ($verif == '1') {
				echo '<script>alert("Anda sudah menerima permintaan ini"); window.close();</script>';
			} else if ($verif == '-1') {
				echo '<script>alert("Anda sudah menolak permintaan ini"); window.close();</script>';
			} else if ($verif == '0') {
				if ($what == 1) {
					$this->m_admin->AcceptGatepassFromMail($what, $as, $qrcode, $id_verifikasi, $id_gatepass);
				} else {
					$this->m_admin->RejectGatepassFromMail($what, $as, $qrcode, $id_verifikasi, $id_gatepass);
				}
			}
		}
	}
	public function upSignatureFromMail()
	{
		$post = $this->input->post();
		if (empty($post)) {
			redirect('dashboard?alert=ditolak');
		} else {
			$this->m_signature->SetSignatureFromMail();
		}
	}






}

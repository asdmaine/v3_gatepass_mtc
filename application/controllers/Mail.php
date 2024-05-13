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
	public function approve_from_mail($what, $as, $qrcode, $id_verifikasi, $id_gatepass,$id_remarks)
	{
		$this->data['pst_pnr'] = 0;
		$this->data['what'] = base64_decode($what);
		$this->data['as'] = base64_decode($as);
		$this->data['qrcode'] = base64_decode($qrcode);
		$this->data['id_verifikasi'] = base64_decode($id_verifikasi);
		$this->data['id_gatepass'] = base64_decode($id_gatepass);
		$this->data['id_remarks'] = base64_decode($id_remarks);

		// ambil pst_pnr
		$gatepass = $this->m_admin->getpstpnrfromgatepass($this->data['id_gatepass']);
		if ($this->data['as'] == 'requested') {
			$this->data['pst_pnr'] = $gatepass[0]->requestedby_pst_pnr;
		} else if ($this->data['as'] == 'recommended') {
			$this->data['pst_pnr'] = $gatepass[0]->recommendedby_pst_pnr;
		} else if ($this->data['as'] == 'approved') {
			$this->data['pst_pnr'] = $gatepass[0]->approvedby_pst_pnr;
		} else if ($this->data['as'] == 'acknowledged') {
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
			if ($this->data['as'] == 'recommended') {
				$verif = $this->m_admin->cekrecommended($this->data['id_verifikasi'], $this->data['id_gatepass']);
			} else if ($this->data['as'] == 'approved') {
				$verif = $this->m_admin->cekapproved($this->data['id_verifikasi'], $this->data['id_gatepass']);
			} else if ($this->data['as'] == 'acknowledged') {
				$verif = $this->m_admin->cekacknowledged($this->data['id_verifikasi'], $this->data['id_gatepass']);
			}
			if ($verif == '1') {
				echo '<script>alert("Anda sudah menerima permintaan ini"); window.close();</script>';
			} else if ($verif == '-1') {
				echo '<script>alert("Anda sudah menolak permintaan ini"); window.close();</script>';
			} else if ($verif == '0') {
					$post = $this->input->post();
					if (empty($post)) {
						$this->load->view('public/mail/Remarks_mail', $this->data);
					} else {
						$this->m_admin->ApproveMail();
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
			redirect('mail/approve_from_mail/' . base64_encode($post['what']) . '/' . base64_encode($post['as']) . '/' . base64_encode($post['qrcode']) . '/' . base64_encode($post['id_verifikasi']) . '/' . base64_encode($post['id_gatepass']).'/'.base64_encode($post['id_remarks']));
		}
	}







}

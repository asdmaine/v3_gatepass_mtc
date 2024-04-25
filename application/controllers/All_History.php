<?php
defined('BASEPATH') or exit('No direct script access allowed');
class All_History extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('m_admin');
		if (!$this->m_admin->is_login()) {
			redirect('AuthAdmin/Login');
		} else {
			require_once 'set_menu.php';
			include APPPATH . 'third_party/qrlib/src/qrlib.php';
			include APPPATH . 'third_party/fpdf/fpdf.php';
			include APPPATH . 'third_party/fpdf/src/autoload.php';
			$language = $this->session->userdata('language');
			$this->lang->load('general', $language);
		}
	}
	public function index()
	{
		$year_now = date('Y');
		$this->data['Gatepass'] = $this->m_admin->GetHistoryYear($year_now);
		$this->sidebar->view('public/history/All_history', array_merge($this->logindata, $this->data));
	}
	public function from($year)
	{
		$this->data['Gatepass'] = $this->m_admin->GetHistoryYear($year);
		$this->data['year'] = $year;
		$this->sidebar->view('public/history/All_history', array_merge($this->logindata, $this->data));
	}
	public function detail($qrcode = '0')
	{
		if ($qrcode == '0') {
			redirect('dashboard');
		} else {
			$this->data['Gatepass'] = $this->m_admin->GetGatepassByQrcode('security', $qrcode);
			if (empty($this->data['Gatepass'])) {
				redirect('dashboard?errorss');
				// echo 'kosong';
			} else {
				//getsignature
				$this->data['Gatepass'][0]->recommended_signature = $this->m_admin->GetSignature($this->data['Gatepass'][0]->recommendedby_pst_pnr);
				$this->data['Gatepass'][0]->approved_signature = $this->m_admin->GetSignature($this->data['Gatepass'][0]->approvedby_pst_pnr);
				$this->data['Gatepass'][0]->acknowledged_signature = $this->m_admin->GetSignature($this->data['Gatepass'][0]->acknowledgedby_pst_pnr);
				$this->data['Gatepass'][0]->securityin_signature = $this->m_admin->GetSignature($this->data['Gatepass'][0]->securityin_pst_pnr);
				$this->data['Gatepass'][0]->securityout_signature = $this->m_admin->GetSignature($this->data['Gatepass'][0]->securityout_pst_pnr);


				if (!isset($this->data['Gatepass'][0]->qrcode)) {
					$this->data['Gatepass'][0]->qrcode_64 = 'tidak ada qrcode';
				} else {
					ob_start();
					QRcode::png($this->data['Gatepass'][0]->qrcode, null, QR_ECLEVEL_H, 20);
					$imageData = ob_get_clean();
					$this->data['Gatepass'][0]->qrcode_64 = base64_encode($imageData);
				}
				if (!isset($this->data['Gatepass'][0]->rl_time_out) || $this->data['Gatepass'][0]->rl_time_out === null) {
					$this->data['Gatepass'][0]->rl_time_out = '';
				}
				if (!isset($this->data['Gatepass'][0]->rl_time_in) || $this->data['Gatepass'][0]->rl_time_in === null) {
					$this->data['Gatepass'][0]->rl_time_in = '';
				}

				// $this->load->view('public/pdf/Pdf', array_merge($this->logindata, $this->data));
				$this->load->view('public/pdf/Pdf', array_merge($this->logindata, $this->data));
			}


		}
	}
	


}

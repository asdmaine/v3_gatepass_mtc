<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Scan extends CI_Controller
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
		}
	}
	public function index()
	{
		$this->sidebar->view('public/scan/Scan', array_merge($this->logindata));
	}
	public function output()
	{
		$post = $this->input->post();
		if (empty($post)) {
			redirect('dashboard?alert=ditolak');
		} else {

			$string = $this->logindata['level'];
			$this->data['Gatepass'] = $this->m_admin->GetGatepassByQrcode($string, $post['qr']);
			if (empty($this->data['Gatepass'])) {
				redirect('scan?alert=gp0');
			} else {
				if ($this->data['Gatepass'][0]->status != 1) {
					redirect('scan?alert=gp0');
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


					$this->load->view('public/scan/Scanned', array_merge($this->logindata, $this->data));
				}

			}

		}
	}
	public function set_real_time_out()
	{
		if ($this->logindata['level'] == 'security') {
			$post = $this->input->post();
			if (empty($post)) {
				redirect('dashboard?alert=error');
			} else {
				$string = $this->logindata['user']['pst_pnr'];
				$this->m_admin->SetRealTimeOut($string);
			}
		} else {
			redirect('dashboard?alert=error');
		}
	}
	public function set_real_time_in()
	{
		if ($this->logindata['level'] == 'security') {
			$post = $this->input->post();
			if (empty($post)) {
				redirect('dashboard?alert=error');
			} else {
				$string = $this->logindata['user']['pst_pnr'];
				$this->m_admin->SetRealTimeIn($string);
			}
		} else {
			redirect('dashboard?alert=error');
		}
	}



}

<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Submit extends CI_Controller
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
			$language = $this->session->userdata('language');
			$this->lang->load('general', $language);
		}
	}
	public function index()
	{
		$string = $this->logindata['user']['pst_pnr'];
		$this->data['Progress'] = $this->m_admin->GetProgress($string);
		$this->data['Recommended'] = $this->m_admin->GetRecommended();
		$this->data['Approved'] = $this->m_admin->GetApproved();
		// acknowledged(belum ada fungsinya)
		// $this->data['Acknowledged'] = $this->m_admin->GetAcknowledged();
		$this->sidebar->view('public/submit/Submit', array_merge($this->logindata, $this->data));
	}
	public function do_submit()
	{
		$post = $this->input->post();
		$string = $this->logindata['user']['pst_pnr'];
		$row = $this->m_admin->NumHistoryToday($string);
		if ($row > 0) {
			redirect('dashboard?alert=limit');
		} else {
			if (empty($post)) {
				redirect('submit');
			} else {
				function generateRandomString($length = 10)
				{
					$characters = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZ';
					$charactersLength = strlen($characters);
					$randomString = '';
					for ($i = 0; $i < $length; $i++) {
						$randomString .= $characters[rand(0, $charactersLength - 1)];
					}
					return $randomString;
				}
				$randomString = generateRandomString(10);
				$this->m_admin->SubmitGatepass($randomString);
			}
		}

	}
	public function do_delete($id_gatepass)
	{
		$this->m_admin->DeleteGatepass($id_gatepass);
	}

}

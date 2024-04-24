<?php
defined('BASEPATH') or exit('No direct script access allowed');
class Approve extends CI_Controller
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
		$this->data['Progress'] = $this->m_admin->GetProgressApproval($string);
		$this->sidebar->view('public/approve/Approve', array_merge($this->logindata, $this->data));
	}
	public function do_approve()
	{
		$post = $this->input->post();
		if (empty($post)) {
			redirect('dashboard?alert=error');
		} else {
			if ($post['what'] == 1) {
				$this->m_admin->AcceptGatepass();
			} else if ($post['what'] == -1) {
				$this->m_admin->RejectGatepass();
			}
		}

	}


}

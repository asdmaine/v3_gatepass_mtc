<?php
defined('BASEPATH') or exit('No direct script access allowed');
class History extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		date_default_timezone_set('Asia/Jakarta');
		$this->load->model('m_admin');
		if (!$this->m_admin->is_login()) {
			redirect('AuthAdmin/Login');
		}else{
			require_once 'set_menu.php';
			$language = $this->session->userdata('language');
			$this->lang->load('general', $language);
		}
	}
	public function index()
	{
		$string = $this->logindata['user']['pst_pnr'];	
		$this->data['History'] = $this->m_admin->GetHistory($string);
		$this->sidebar->view('public/history/History',array_merge($this->logindata,$this->data));
	}
	
	
}

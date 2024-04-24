<?php

	/**
	 * 
	 */
	class Sidebar {

		protected $_CI;

		function __construct(){
			$this->_CI = &get_instance();
		}

		function view($admintemp,$data=null){
			// $this->_CI->load->view('tempuser/front_header');
			$this->_CI->load->view('sidebar/nav');
			$this->_CI->load->view($admintemp,$data);
			// $this->_CI->load->view('tempuser/front_footer');
		}


	}

?>
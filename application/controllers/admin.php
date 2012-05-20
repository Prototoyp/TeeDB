<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Admin extends Admin_Controller {
	
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('file');
	}
	
	function index()
	{
		$this->template->set_subtitle('Dashboard');
		$this->template->view('admin');
	}
}

/* End of file welcome.php */
/* Location: ./system/application/controllers/admin.php */
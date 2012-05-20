<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Intern extends User_Controller {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->template->set_subtitle('Intern');
		$this->template->view('intern');
	}
}

/* End of file intern.php */
/* Location: ./application/modules/user/controllers/intern.php */
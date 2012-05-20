<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class User_Request_Controller extends Request_Controller {
	
	private $user_controller;
		
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->library('user/auth');
		
		if( ! $this->auth->logged_in())
		{
			redirect('user/login');
		}
	}
}
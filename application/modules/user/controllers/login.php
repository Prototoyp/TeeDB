<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Login extends Public_Controller {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('form_validation', 'user/auth'));
		$this->lang->load('user');
	}

	public function index()
	{
		if ($this->_submit_validate() === TRUE)
		{
			$this->auth->redirect();
			return;
		}
		
		//Restrict if already logged in
		$this->auth->restrict();
		
		// if($this->auth->logged_in())
		// {
			// $this->template->add_info_msg($this->lang->line('info_logged_in'));
		// }
		
		$this->template->set_subtitle('Login');
		$this->template->view('login');
	}

	private function _submit_validate()
	{
				
		$this->form_validation->set_rules('username', 'lang:field_username', 'callback__not_logged_in|trim|required|callback__status|callback__authenticate');
		$this->form_validation->set_rules('password', 'lang:field_password', 'trim|required');

		return $this->form_validation->run();
	}
	
	function _status()
	{
		$status = $this->user->get_status($this->input->post('username'));
		
		if($status === User::STATUS_DEACTIVE)
		{
			$this->form_validation->set_message('_activate', $this->lang->line('error_invalid_banned').' '.anchor('user/signup/resend/'.$this->input->post('username'), $this->lang->line('error_resend_link')));
			return FALSE;
		}
		elseif($status === User::STATUS_BANNED)
		{
			$this->form_validation->set_message('_not_banned', $this->lang->line('error_invalid_banned'));
			return FALSE;
		}
		
		return TRUE;
	}
	
	function _authenticate()
	{
		//per input->post
		$this->form_validation->set_message('_authenticate',$this->lang->line('error_invalid_login'));
		return $this->auth->login();
	}
	
	function _not_logged_in()
	{
		$this->form_validation->set_message('_not_logged_in', $this->lang->line('error_already_logged_in'));
		return !$this->auth->logged_in();
	}
}

/* End of file login.php */
/* Location: ./application/modules/user/controllers/login.php */
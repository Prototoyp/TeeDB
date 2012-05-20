<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Edit extends User_Controller {

	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('form_validation', 'user/auth'));		
		$this->load->model(array('user/user'));
		$this->lang->load('user');
	}

	public function index()
	{
		$data['email'] = $this->user->get_email($this->auth->get_id());
			
		$this->template->set_subtitle('Profil bearbeiten');
		$this->template->view('edit', $data);
	}
	
	public function pass()
	{
		//Show messages by password form
		$this->load->vars(array('pass' => TRUE));
		
		if ($this->_pass_validate() === TRUE)
		{
			$user_id = $this->user->change_pass(
				$this->auth->get_id(),
				$this->auth->get_hash($this->input->post('new_password'))
			);
			
			$this->template->add_success_msg($this->lang->line('success_changed_password'));
		}

		$this->index();
	}
	
	private function _pass_validate()
	{
		$this->form_validation->set_rules('new_password', 'lang:field_password', 'required|min_length[6]|max_length[12]');
		$this->form_validation->set_rules('passconf', 'lang:field_confirm_password', 'required|matches[new_password]');

		return $this->form_validation->run();
	}
	
	public function email()
	{		
		//Show messages by email form
		$this->load->vars(array('mail' => TRUE));
		
		if ($this->_email_validate() === TRUE)
		{
			$user_id = $this->user->change_email(
				$this->auth->get_id(),
				$this->input->post('email')
			);
			
			$this->template->add_success_msg($this->lang->line('success_changed_email'));
		}

		$this->index();
	}
	
	private function _email_validate()
	{
		$this->form_validation->set_rules('email', 'lang:field_email', 'required|valid_email|unique[users.email]');

		return $this->form_validation->run();
	}
	
	public function del()
	{		
		//Show messages by delete form
		$this->load->vars(array('del' => TRUE));
		
		if($this->input->post('delete'))
		{
			$this->template->add_info_msg($this->lang->line('info_delete_account'));
		}
		elseif($this->input->post('really_delete'))
		{
			$this->user->remove($this->auth->get_id());
			$this->auth->logout();
		}
		
		$this->index();
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
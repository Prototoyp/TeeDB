<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Signup extends Public_Controller {
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		parent::__construct();
		
		$this->load->library(array('form_validation', 'user/auth', 'email'));
		$this->load->model(array('user','confirm'));
		
		$this->lang->load('user');
		$this->config->load('user');
	}

	// --------------------------------------------------------------------

	/**
	 * Signup page
	 * 
	 * Also handle signup form inputs
	 * Form:
	 * 	- username
	 * 	- password
	 * 	- passconf
	 * 	- email
	 */
	public function index()
	{
		$success = FALSE;
		
		if ($this->form_validation->run('signup') === TRUE)
		{
			//Add user
			$user_id = $this->user->add_user(
				$this->input->post('username'), 
				$this->auth->get_hash($this->input->post('password')),
				$this->input->post('email')
			);
			
			//Activated accounts via confirm link?
			if(($this->config->item('confirm_signup')))
			{
				//generate confirm link
				$link = $this->confirm->add_signup_link($user_id);
				
				if($this->_send_mail($this->input->post('username'), $this->input->post('email'), $link) === FALSE)
				{
					$this->form_validation->add_message('Failed to send an confirm email. Please use following link to try again: ...');
				}
				else
				{
					$success = 'Confirm link has been sent to your email address.';
				}
			}
			else
			{
				$success = 'You can now login.';
			}
		}
		
		$this->template->set_subtitle('Signup');
		$this->template->view('signup', array('success' => $success));
	}

	// --------------------------------------------------------------------

	/**
	 * Resent an confirm link
	 * 
	 * @access	public
	 * @param	string	email
	 * @return	bool
	 */
	public function resend($email)
	{
		//Get link and username form email
		if($link = $this->confirm->get_signup_link($email) && $username = $this->user->get_name_by_mail($email))
		{
			if($this->_send_mail($username, $email, $link))
			{
				$this->output->set_output('Confirm link resend to '.url_title($email).'.');
			}
			else
			{
				show_error('Failed to send an email. Please try again later. :(');
			}
		}
		else
		{
			show_error('Invalid email or account already activated.');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Confirm links
	 * 
	 * If link is invalid or user already activated an error is shown.
	 * If link is valid the user is activated and redirect to main page
	 * 
	 * @access	public
	 * @param	string	link
	 */
	public function confirm($link)
	{
		//Try to activate
		if(!$this->confirm->confirm($link))
		{
			show_error('Invalid link or account already activated.');
		}
		else
		{
			$this->output->set_header('refresh:10; url='.base_url());
			$this->output->set_output('Activation successful. You can now log in.');
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Send confirm email with given link
	 * 
	 * @access	public
	 * @param	string	username
	 * @param	string	email
	 * @param	string	link
	 * @return	bool
	 */
	private function _send_mail($username, $email, $link)
	{		
		//create mail
		$this->email->from($this->config->item('email'), 'TeeDB - Teeworlds database');
		$this->email->to($email);
		
		$this->email->subject('TeeDB - Confirm signup');
		$this->email->message('
			Hi '.$username.',
			
			If you did NOT create an account at teedb.info, you can ignore this message.
			
			------------------------------------------
			
			With the following link you can activate your created account on teedb.info.
			
			Confirm link: {unwrap}'.base_url('user/signup/confirm/'.$link).'{/unwrap}
			
			Username: '.$username.'
			
			Your password is stored encrypted, so remember your password 
			or use the forgotten password function to create a new one.
			(Function avaible after account activation.)
			
			So long...
			Your teeworlds database
			TeeDB
		');
		
		//Try to send email
		if(!$this->email->send()){
			if(ENVIRONMENT == 'development'){
				$this->email->print_debugger();
				exit();
			}
			return FALSE;
		}
		
		return TRUE;
	}
}

/* End of file signup.php */
/* Location: ./application/modules/user/controllers/signup.php */
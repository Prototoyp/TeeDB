<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * NOTICE OF LICENSE
 * 
 * Licensed under the Academic Free License version 3.0
 * 
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2011, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

class UpComing extends MY_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('form');
		$this->load->library(array('form_validation', 'auth'));
		$this->load->model('user/user');
	}
	
	public function index()
	{
		//One week
		//$this->output->cache(10080);
		
		$data = array();
		$data['transfers'] = $this->db
		->select('username, error')
		->where('name', '')
		->get('transfer_invalid_users')
		->result();
		
		$this->template->clear_layout();
		$this->template->set_theme('default');
		$this->template->set_subtitle('Update');
		$this->template->view('upcoming', $data);
	}
	
	public function change_username()
	{
		$data = array();
		
		if($this->_validate() == TRUE)
		{
			$data['success'] = TRUE;
			
			//change username
			$this->db
			->set('name', $this->input->post('new_username'))
			->where('username', $this->input->post('username'))
			->update('transfer_invalid_users');
			
			//Add user
			$user = $this->db
			->select('email, create')
			->where('username', $this->input->post('username'))
			->get('transfer_invalid_users')
			->row();
		
			$this->db
			->set('name', $this->input->post('new_username'))
			->set('password', $this->auth->get_hash($this->input->post('password')))
			->set('email', $user->email)
			->set('status', 1)
			->set('update', 'NOW()', FALSE)
			->set('create', $user->create)
			->insert(USER::TABLE);
		}
		
		$data['transfers'] = $this->db
		->select('username, name')
		->where('name !=', '')
		->get('transfer_invalid_users')
		->result();
		
		$this->template->clear_layout();
		$this->template->set_theme('default');
		$this->template->set_subtitle('Change username');
		$this->template->view('user_transfer', $data);
	}
	
	public function _validate()
	{
		$this->form_validation->set_rules('username', 'Username', 'trim|required|exist[transfer_invalid_users.username]');
		$this->form_validation->set_rules('password', 'Password', 'required|callback_pw_check');
		$this->form_validation->set_rules('new_username', 'New username', 'not_logged_in|trim|required|alpha_numeric|min_length[3]|max_length[20]|unique[users.name]');
		
		return $this->form_validation->run();
	}
	
	function pw_check($str)
	{
		$this->form_validation->set_message('pw_check', 'Invalid password.');
		
		$query = $this->db
		->select('old_id, password')
		->where('username', $this->input->post('username'))
		->get('transfer_invalid_users');
		
		if ($query->num_rows())
		{
			$user = $query->row();
			return ($user->password == md5(md5($user->old_id).$str));
		}
		
		return FALSE;
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
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
	}
	
	public function index()
	{
		//One week
		$this->output->cache(10080);
		
		$data = array();
		$data['transfers'][] = array('name' => 'Picachu', 'type' => 'skin', 'reason' => 'Dismatched minimum or maximum size of 256x125.');
		$data['transfers'][] = array('name' => 'Blubb(&%)', 'type' => 'user', 'reason' => 'No Symbols allowed in name.');
		
		$this->template->clear_layout();
		$this->template->set_theme('default');
		$this->template->set_subtitle('Update');
		$this->template->view('upcoming', $data);
	}
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Maintenance extends MY_Controller {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
		
		if($this->config->item('maintenance') === FALSE)
        {
        	show_404();
		}
	}
	
	public function index()
	{
		$this->template->maintenance();
	}
}

/* End of file maintenance.php */
/* Location: ./application/controllers/maintenance.php */
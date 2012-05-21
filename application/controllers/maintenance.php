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
		$data['google_analytic_id'] = '';
		if (@include(APPPATH.'config/template'.EXT))
		{
			$data['google_analytic_id'] = $template['google_analytic_id'];
		}
		$this->load->view('maintenance', $data);
	}
}

/* End of file maintenance.php */
/* Location: ./application/controllers/maintenance.php */
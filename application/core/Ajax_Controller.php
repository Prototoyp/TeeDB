<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Ajax_Controller extends CI_Controller{
	
	function __construct()
	{
		parent::__construct();
		
		if(!$this->input->is_ajax_request())
		{
            show_404('Enable javascript in your browser to use this feature.');
		}
	}
	
}
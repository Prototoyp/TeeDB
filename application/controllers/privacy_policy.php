<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Privacy_policy extends Public_Controller {
	
	public function index()
	{
		$this->template->set_subtitle('Privacy policy');
		$this->template->view('privacy_policy');
	}
}

/* End of file privacy_policy.php */
/* Location: ./application/controllers/privacy_policy.php */
<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Disclaimer extends Public_Controller {
	
	public function index()
	{
		$this->template->set_subtitle('Disclaimer');
		$this->template->view('disclaimer');
	}
}

/* End of file disclaimer.php */
/* Location: ./application/controllers/disclaimer.php */
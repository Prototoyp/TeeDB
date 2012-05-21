<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rates extends Request_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->model('teedb/rate');
	}
	
	function _set_rate()
	{		
		//Check values
		if ($this->form_validation->run('rate') === TRUE)
		{
			return $this->rate->setRate($type, $id, $rate);
		}
		
		return FALSE;
	}
	
	function _ajax_index()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_set_rate());
	}
	
	function _post_index()
	{
		
		if ($this->form_validation->run('rate') === TRUE)
		{
			$this->template->add_success_msg($this->input->post('type').' successful rated. :)');
			return $this->rate->setRate($type, $id, $rate);
		}
		
		echo show_messages();
	}
}

/* End of file rates.php */
/* Location: ./application/modules/teedb/controllers/rates.php */
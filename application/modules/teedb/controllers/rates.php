<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Rates extends Request_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('download');
		$this->load->model('teedb/rate');
	}
	
	function _set_rate()
	{		
		//Check values
		$id = (int) $this->input->post('id');
		if(!is_numeric($id) or $id <= 0)
			return FALSE;
		
		$type = trim($this->input->post('type'));
		switch($type){
			case 'skin':
			case 'mapres':
			case 'mod':
			case 'map':
			case 'demo':
				break;
			default: return FALSE;
		}
		
		$rate = (int) $this->input->post('rate');
		if(!is_numeric($rate) or $rate!= 1 and $rate != 0)
			return FALSE;
		
		return $this->rate->setRate($type, $id, $rate);
	}
	
	function _ajax_index()
	{
		$this->set_multi_ajax(TRUE);
		$this->output->set_output($this->_set_rate());
	}
	
	function _post_index()
	{
		//$this->load->view($this->_set_rate());
		show_error('Enable javascript to use this feature!');
	}
}

/* End of file rates.php */
/* Location: ./application/modules/teedb/controllers/rates.php */
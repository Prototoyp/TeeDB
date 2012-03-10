<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class API extends CI_Controller{

	function __construct()
	{
		parent::__construct();
		
		$this->load->model(array('teedb/skin','teedb/gameskin','teedb/demo','teedb/tileset','teedb/map','teedb/mod'));
	}
	
	public function index()
	{
		show_error('You have to choose the type of output by URL! See more in the wiki on github.');
	}
	
	function xml()
	{
		
	}
	
	function plain()
	{
		
	}
	
	function yaml()
	{
		
	}
	
	function json($data) 
	{
	    $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
	    $this->output->set_header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
	    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0");
	    $this->output->set_header("Pragma: no-cache");
		$this->output->append_output(json_encode($data));
	}
	
	public function _remap($method, $params = array())
	{
		$data = array();
		
		foreach($params as $para)
		{
			switch ($para) {
				case 'skins': $data = $this->skin->get(); break;
				case 'mapres': $data = $this->tileset->get(); break;
				case 'gameskins': $data = $this->gameskin->get(); break;
				case 'demos': $data = $this->demo->get(); break;
				case 'maps': $data = $this->map->get(); break;
				case 'mods': $data = $this->mod->get(); break;
				default: 
					$data['skins'] = $this->skin->get();
					$data['mapres'] = $this->tileset->get();
					$data['gameskins'] = $this->gameskin->get();
					$data['demos'] = $this->demo->get();
					$data['maps'] = $this->map->get();
					$data['mods'] = $this->mod->get();
			}
		}
		
		
    	if(method_exists($this, $method))
    	{
        	return call_user_func_array(array($this, $method), $data);
    	}
    	show_404();
	}
}
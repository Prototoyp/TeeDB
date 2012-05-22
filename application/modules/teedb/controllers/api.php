<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class API extends Public_Controller{

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
				case 'skins': $data['skins']  = $this->skin->get_skins(); break;
				case 'mapres': $data['mapres'] = $this->tileset->get_mapres(); break;
				case 'gameskins': $data['gameskins'] = $this->gameskin->get_gameskins(); break;
				case 'demos': $data['demos'] = $this->demo->get_demos(); break;
				case 'maps': $data['maps'] = $this->map->get_maps(); break;
				case 'mods': $data['mods'] = $this->mod->get_mods(); break;
				default: 
					$data['skins'] = $this->skin->get_skins();
					$data['mapres'] = $this->tileset->get_mapres();
					$data['gameskins'] = $this->gameskin->get_gameskins();
					$data['demos'] = $this->demo->get_demos();
					$data['maps'] = $this->map->get_maps();
					$data['mods'] = $this->mod->get_mods();
			}
		}
		
		
    	if(method_exists($this, $method))
    	{
        	return call_user_func_array(array($this, $method), $data);
    	}
    	show_404();
	}
}
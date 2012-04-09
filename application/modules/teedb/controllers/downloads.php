<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');

class Downloads extends Public_Controller {

	function __construct()
	{
		parent::__construct();
		
		$this->load->helper('download');
		$this->load->model(array('teedb/download', 'teedb/skin', 'teedb/tileset', 'teedb/demo', 'teedb/gameskin', 'teedb/map'));
		$this->load->config('upload');
	}
	
	function index($type, $name)
	{
		
		switch($type)
		{
			case 'skin':
				$ext = '.png';
				$table = $this->skin; 
				break;
			case 'mapres': 
				$ext = '.png';
				$table = $this->tileset; 
				break;
			case 'gameskin': 
				$ext = '.png';
				$table = $this->gameskin; 
				break;
			case 'map': 
				$ext = '.map'; 
				$table = $this->map; 
				break;
			case 'demo': 
				$ext = '.demo'; 
				$table = $this->demo; 
				break;
			default: 
				show_error('Wrong type for force download.');
				return FALSE;
		}
		
		$file = $this->config->item('upload_path', $type).'/'.$name.$ext;
		
		if(is_file($file) and $data = file_get_contents($file))
		{
			$this->download->increment($type, $table, $name);
			force_download($name.$ext, $data);
		}else{
			show_error('File not found.');
		}
	}
}

/* End of file download.php */
/* Location: ./application/modules/teedb/controllers/download.php */
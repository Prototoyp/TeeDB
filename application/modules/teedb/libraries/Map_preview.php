<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Map Preview Class
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	Previews
 * @author		Andreas Gehle
 */

require_once('map.php');

class Skin_preview {

	protected $CI;
	
	protected $mod		= 0;
		
	const PREV_FOLDER	= '/previews';
	
	const MOD_VANILLA	= 0;
	const MOD_RACE		= 1;
	const MOD_DDRACE	= 2;
	
	/**
	 * Constructor
	 */
	function __construct()
	{
		$this->CI =& get_instance();

		//Load additional libraries, helpers, etc.
		$this->CI->load->config('teedb/teedb');
		$this->mod = self::MOD_VANILLA;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set the mod type
	 * 
	 * Use e.g. Map_preview::MOD_VANILLA
	 * Avable mod types: MOD_VANILLA, MOD_RACE, MOD_DDRACE
	 *
	 * @access public
	 * @param integer mod-number
	 */
	public function set_mod($mod_nr)
	{
		$this->mod = $mod_nr;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Create the preview file
	 *
	 * @access public
	 * @param file Path to the skin file
	 * @return boolean
	 */
	public function create($file)
	{		
		//Set preview name
		$this->name = pathinfo($file, PATHINFO_FILENAME);
		
		$map = new Map($this->CI->config->item('upload_path_maps').'/'.$file);
		$map->draw_layers(
			$this->CI->config->item('upload_path_maps').self::PREV_FOLDER,
			$this->mod
		);
		
		return TRUE;
	}
}

/* End of file: Map_preview.php */
/* Location: application/libraries/Map_preview.php */
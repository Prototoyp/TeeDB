<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Template Class
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	Output
 * @author		Andreas Gehle
 */
class Template {
	
	protected $CI;	
	
	protected $theme		= 'default';
	protected $admin_bar	= FALSE;
	protected $layouts   	= array();
	protected $layout_data 	= array();	
	public $header_data		= array();
	protected $footer_data	= array();
	
	protected $css 			= array();
	protected $js 			= array();
	
	private $_success_array	= array();
	private $_info_array	= array();
	
	private $_success_prefix = '<p>';
	private $_success_suffix = '</p>';
	
	private $_info_prefix 	= '<p>';
	private $_info_suffix 	= '</p>';
	
	/**
	 * Constructor
	 */
	function __construct($config = array())
	{			
		$this->CI =& get_instance();
			
		if( count($config) > 0)
		{
			$this->initialize($config);
		}
		else
		{
			$this->_load_config_file();
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Initialize class preferences
	 *
	 * @access	public
	 * @param	array
	 * @return	void
	 */
	public function initialize($props = array())
	{
		if (count($props) > 0)
		{
			foreach ($props as $key => $val)
			{
				$this->$key = $val;
			}
		}
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Load template config
	 * 
	 * Load template specific config items from config/template.php
	 */
	private function _load_config_file()
	{
		if ( ! @include(APPPATH.'config/template'.EXT))
		{
			return FALSE;
		}

		foreach($template as $key => $item)
		{
			switch($key)
			{
				case 'title':
					$this->header_data['site_title'] = $item;
				case 'author':
				case 'description':
					$this->header_data[$key] = $item;
					break;
				case 'google_analytic_id':
					$this->footer_data[$key] = $item;
					break;
				case $this->theme: 
					$this->set_info_delimiters($item['info_delimiters']['open'], $item['info_delimiters']['close']);
					$this->set_success_delimiters($item['success_delimiters']['open'], $item['success_delimiters']['close']);
					$key = 'error_delimiters';
					$item['open'] = $item['error_delimiters']['open'];
					$item['close'] = $item['error_delimiters']['close'];
				case 'error_delimiters':
					if($this->CI->load->library('form_validation'))
					{
						$this->CI->form_validation->set_error_delimiters($item['open'], $item['close']);
					}
					if($this->CI->load->library('upload'))
					{
						$this->CI->upload->set_error_delimiters($item['open'], $item['close']);
					}
					break;
				case 'info_delimiters':
					$this->set_info_delimiters($item['open'], $item['close']);
					break;
				case 'success_delimiters':
					$this->set_success_delimiters($item['open'], $item['close']);
					break;
				default:
					$this->$key = $item;
					break;
			}
		}
		unset($template);

		return TRUE;
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Load template config
	 * 
	 * Load template specific config items from config/template.php
	 */
	public function view($view, $data = NULL){
		$this->CI->load->view('templates/'.$this->theme.'/header', $this->header_data);
		
		if($this->admin_bar)
		{
			$this->CI->load->view('templates/admin_nav', $this->get_admin_data());
		}
		
		foreach($this->layouts as $layout)
		{
			if(isset($this->layout_data[$layout]))
			{
				$this->CI->load->view('templates/'.$this->theme.'/'.$layout, $this->layout_data[$layout]);				
			}
			else
			{
				$this->CI->load->view('templates/'.$this->theme.'/'.$layout);
			}
		}
		
		if($data == NULL)
		{
			$this->CI->load->view($view);
		}
		else {			
			$this->CI->load->view($view, $data);
		}
		
		$this->CI->load->view('templates/'.$this->theme.'/footer', $this->footer_data);
	}
	// --------------------------------------------------------------------	
	
	/**
	 * Get admin nav data
	 * 
	 * Check which modules exist and if they support administration
	 */
	private function get_admin_data()
	{
		$modules = array();
		$module_dirs = get_dir_file_info(APPPATH.'modules/');		
		foreach($module_dirs as $module => $info)
		{
			if(is_dir(APPPATH.'modules/'.$module))
			{
				$modules[$module] = FALSE;
				if(file_exists(APPPATH.'modules/'.$module.'/controllers/admin.php'))
				{
					$modules[$module] = TRUE;
				}
			}
		}
		return array('modules' => $modules);
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Show admin-nav on every site page
	 */
	public function show_admin_bar()
	{
		$this->admin_bar = TRUE;
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Set layouts
	 * 
	 * Layouts will be loaded after header
	 */
	public function set_layout_data($layout, $data)
	{
		if( in_array($layout, $this->layouts))
		{
			$this->layout_data[$layout] = $data;
			return TRUE;
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Clear layouts
	 */
	public function clear_layout()
	{
		$this->layouts = array();
		$this->layout_data = array();
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Set theme
	 */
	public function set_theme($theme)
	{
		$this->clear_layout();
		$this->theme = $theme;
	}

	// --------------------------------------------------------------------	
	
	/**
	 * Set Subtitle
	 * 
	 * Subtitle will be add to title
	 */
	public function set_subtitle($subtitle)
	{
		if(isset($this->header_data['title']))
		{
			$this->header_data['title'] = $subtitle.' - '.$this->header_data['title'];
		}
		else
		{
			$this->header_data['title'] = $subtitle;
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set The Success Delimiter
	 *
	 * Permits a prefix/suffix to be added to each success message
	 *
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function set_success_delimiters($prefix = '<p>', $suffix = '</p>')
	{
		$this->_success_prefix = $prefix;
		$this->_success_suffix = $suffix;

		return $this;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Set The Success Delimiter
	 *
	 * Permits a prefix/suffix to be added to each success message
	 *
	 * @param	string
	 * @param	string
	 * @return	void
	 */
	public function set_info_delimiters($prefix = '<p>', $suffix = '</p>')
	{
		$this->_info_prefix = $prefix;
		$this->_info_suffix = $suffix;

		return $this;
	}

	// --------------------------------------------------------------------

	/**
	 * Success String
	 *
	 * Returns the success messages as a string, wrapped in the success delimiters
	 *
	 * @param	string
	 * @param	string
	 * @return	str
	 */
	public function success_string($prefix = '', $suffix = '')
	{
		// No success messages
		if (count($this->_success_array) === 0)
		{
			return '';
		}

		if ($prefix == '')
		{
			$prefix = $this->_success_prefix;
		}

		if ($suffix == '')
		{
			$suffix = $this->_success_suffix;
		}

		// Generate the success string
		$str = '';
		foreach ($this->_success_array as $val)
		{
			if ($val != '')
			{
				$str .= $prefix.$val.$suffix."\n";
			}
		}

		return $str;
	}

	// --------------------------------------------------------------------

	/**
	 * Info String
	 *
	 * Returns the info messages as a string, wrapped in the info delimiters
	 *
	 * @param	string
	 * @param	string
	 * @return	str
	 */
	public function info_string($prefix = '', $suffix = '')
	{
		// No info messages
		if (count($this->_info_array) === 0)
		{
			return '';
		}

		if ($prefix == '')
		{
			$prefix = $this->_info_prefix;
		}

		if ($suffix == '')
		{
			$suffix = $this->_info_suffix;
		}

		// Generate the success string
		$str = '';
		foreach ($this->_info_array as $val)
		{
			if ($val != '')
			{
				$str .= $prefix.$val.$suffix."\n";
			}
		}

		return $str;
	}
    
    // --------------------------------------------------------------------
 
    /**
     * Add an success message
	 * 
	 * @access	public
	 * @param	string	success message
     */
	function add_success_msg($message)
	{
		if(is_array($message))
		{
			$this->_success_array = array_merge($this->_success_array, $message);
		}
		else
		{
			$this->_success_array[] = $message;
		}
	}
    
    // --------------------------------------------------------------------
 
    /**
     * Add an info message
	 * 
	 * @access	public
	 * @param	string	info message
     */
	function add_info_msg($message)
	{
		if(is_array($message))
		{
			$this->_info_array = array_merge($this->_info_array, $message);
		}
		else
		{
			$this->_info_array[] = $message;
		}
	}
}
<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * My Form Validation Class
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	Validation
 * @author		Andreas Gehle
 */
class MY_Form_validation extends CI_Form_validation {
	
	protected $check_input = FALSE;
	
 	function __construct($rules=array())
	{
		parent::__construct($rules);
		
		$this->CI->lang->load('MY_form_validation');
	}
 
    /**
     * Error Array
     *
     * Returns the error messages as an array
     *
     * @return  array
     */
    function error_array()
    {
        if (count($this->_error_array) === 0)
        {
          	return FALSE;
        }
        else
		{
        	return $this->_error_array;
		}
    }
    
    // --------------------------------------------------------------------
 
    /**
     * Add an error message
	 * 
	 * @access	public
	 * @param	string	error message
     */
	function add_message($message)
	{
		if(is_array($message))
		{
			$this->_error_array = array_merge($this->_error_array, $message);
		}
		else
		{
			$this->_error_array[] = $message;
		}
	}
    
    // --------------------------------------------------------------------
 
    /**
     * Reset validation
     *
	 * @access	public
     */	
	public function reset_validation()
	{
		// Store current rules
		$rules = $this->_config_rules;
		
		// Create new validation object
		$this->CI->form_validation = new MY_Form_validation($rules);
		$this->CI->form_validation->set_error_delimiters($this->_error_prefix, $this->_error_suffix);
	}
    
    // --------------------------------------------------------------------

	/**
	 * Validate URL
	 * 
	 * @access	public
	 * @param	string URL
	 * @return	bool
	 */
    public function valid_url($url)
    {
		$pattern = "/^(http|https|ftp):\/\/([A-Z0-9][A-Z0-9_-]*(?:\.[A-Z0-9][A-Z0-9_-]*)+):?(\d+)?\/?/i";
        return (bool) preg_match($pattern, $url);
    }
    
    // --------------------------------------------------------------------

	/**
	 * Check if website exist
	 * 
	 * @access	public
	 * @param	string URL
	 * @return	bool
	 */
    public function real_url($url)
    {
		return @fsockopen("$url", 80, $errno, $errstr, 30); exit();
    }

	// --------------------------------------------------------------------

	/**
	 * Unique in table
	 * 
	 * @access	public
	 * @param	string
	 * @param	string	Must be in the format Table.column
	 * @return	bool
	 */
	public function unique($str, $params)
	{
		$this->CI->load->database();

		list($table, $field) = explode(".", $params, 2);

		$query = $this->CI->db->select($field)->from($table)->where($field, $str)->limit(1)->get();

		if ($query->row())
		{
			return FALSE;
		}
		else
		{
			return TRUE;
		}

	}

	// --------------------------------------------------------------------

	/**
	 * Exist in table
	 * 
	 * @access	public
	 * @param	string
	 * @param	string	Must be in the format Table.column
	 * @return	bool
	 */
	public function exist($str, $params)
	{
		return !$this->unique($str, $params);
	}

	// --------------------------------------------------------------------

	/**
	 * Spam protection
	 * 
	 * Checks if last {$max = 3} entries insert by the same user.
	 * Requires a 'user_id' and 'create' field in table.
	 * user_id - unsigned int foreign key
	 * create - datetime
	 * 
	 * @access	public
	 * @param	string
	 * @param	string	Must be in format Table or Table.Max
	 * @return	bool
	 */
	public function no_spam($value, $params)
	{
		$max = 3;
		
		$this->CI->load->database();

		list($table, $max) = explode(".", $params, 2);

		$query = $this->CI->db->select('user_id')->from($table)->order_by('create')->limit($max)->get();

		if ($query->num_rows() < $max)
		{
			return TRUE;		
		}
		
		foreach ($query->result() as $row)
		{
			if (!isset($last))
			{
				$last = $row->user_id;
			}
			elseif ($last != $row->user_id)
			{
				return TRUE;
			}
		}
			
		return FALSE;
	}

	// --------------------------------------------------------------------

	/**
	 * Logged in
	 * 
	 * Checks if a user is already loged in
	 * 
	 * @access	public
	 * @return	bool
	 */	
	public function logged_in()
	{
		$this->CI->load->library('user/auth');
		
		return $this->CI->auth->logged_in();
	}

	// --------------------------------------------------------------------

	/**
	 * Logged in
	 * 
	 * Checks if a user is already loged in
	 * 
	 * @access	public
	 * @return	bool
	 */	
	public function not_logged_in()
	{
		return !$this->logged_in();
	}

	// --------------------------------------------------------------------

	/**
	 * Tell the user to check the input again
	 * when the input was changed
	 * 
	 * Changes can be done by:
	 * - purifier_html
	 * 
	 * @access	public
	 * @return	boolean
	 */	
	public function recheck_input()
	{
		return ! $this->check_input;
	}

	// --------------------------------------------------------------------

	/**
	 * Clean up html
	 * 
	 * @access	public
	 * @return	string Clean string or FALSE when mismatched
	 */	
	public function purifier_html($dirty_html)
	{
		require_once APPPATH . 'third_party/htmlpurifier-4.4.0-standalone/HTMLPurifier.standalone.php';

		$config = HTMLPurifier_Config::createDefault();
		$config->set('Core.Encoding', 'utf-8');
		//$config->set('Core.CollectErrors', TRUE);
		$config->set('HTML.AllowedElements', '');
		$config->set('HTML.Doctype', 'HTML 4.01 Transitional');
		
		$purifier = new HTMLPurifier($config);
		$clean_html = $purifier->purify($dirty_html);
		
		if($clean_html !== $dirty_html)
		{
			$this->check_input = TRUE;
		}
		
		return $clean_html;
	}

	// --------------------------------------------------------------------

	/**
	 * Markup parser
	 * 
	 * Rules:
	 * *text* => <strong>text</strong>
	 * _text_ => <em>text</em>
	 * -text- => <i>text</i>
	 * 
	 * @access	public
	 * @param	string
	 * @return	string	Formatted text
	 */	
	public function markup_parser($str)
	{
		$find = array(
		  "'\*(.*?)\*'is",
		  "'_(.*?)_'is",
		  "'-(.*?)-'is"
		);
		
		$replace = array(
		  '<strong>\\1</strong>',
		  '<em>\\1</em>',
		  '<span style="text-decoration: line-through;">\\1</span>'
		);
		
		return preg_replace($find, $replace, $str);
	}

}

/* End of file MY_Form_validation.php */
/* Location: ./application/libraries/MY_Form_validation.php */
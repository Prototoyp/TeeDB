<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Authentication Class
 *
 * @package		Application
 * @subpackage	Libraries
 * @category	Authentication
 * @author		Andreas Gehle
 */
class Auth {

	protected $CI;
	protected $index_redirect 	= '/';
	protected $login_redirect 	= 'user/login';
	
	private static $salt		= 'm}WGbb_VyQ"|f#]LqNxk1(`VfFENY)1z';
	private static $user_id 	= 0;
	private static $is_admin 	= NULL;
	private static $user_name 	= ''; 
	private static $rights		= array();

	
	/**
	 * Constructor
	 */
	function __construct($props = array())
	{
		$this->CI =& get_instance();

		// Load additional libraries, helpers, etc.
		$this->CI->load->library(array('session','user_agent'));
		$this->CI->load->helper('url');
		$this->CI->load->model('user/user');
		
		if($this->CI->config->item('encryption_key'))
		{
			self::$salt = $this->CI->config->item('encryption_key');
		}

		if (count($props) > 0)
		{
			$this->initialize($props);
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
	 * Redirects users after logging in
	 *
	 * @access	public
	 * @return	void
	 */
	public function set_redirect_from()
	{
		if($this->CI->uri->uri_string() != $this->login_redirect)
		{
			$this->CI->session->set_userdata('redirected_from', $this->CI->uri->uri_string());
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Redirects users after logging in
	 *
	 * @access	public
	 * @return	void
	 */
	public function redirect()
	{
		if ($this->CI->session->userdata('redirected_from') == FALSE)
		{
			redirect($this->index_redirect);
		}
		else
		{
			redirect($this->CI->session->userdata('redirected_from'));
		}
	}

	// --------------------------------------------------------------------

	/**
	 * Restrict users from certain pages
	 * 
	 * use restrict if a user can't access a page when logged in
	 *
	 * @access	public
	 * @return	void
	 */
	public function restrict()
	{
		if($this->logged_in())
		{
			redirect($this->index_redirect);
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Checks login data
	 * 
	 * Requires user name and password as post data
	 * @access public
	 * @return boolean	if login successful the user will be redirect else false is given back
	 */
	public function login()
	{
		//FIXME: Only for transfer
		{
			
			$query = $this->CI->db
			->select('id')
			->where('name', $this->CI->input->post('username'))
			->where('password IS NULL', NULL, FALSE)
			->limit(1)
			->get(User::TABLE);
			
			if ($query->num_rows())
			{
				$user = $query->row();
				
				$query = $this->CI->db
				->select('old_id, password')
				->where('user_id', $user->id)
				->limit(1)
				->get('transfer_user');
				
				if ($query->num_rows())
				{
					$user_transfer = $query->row();
					
					if($user_transfer->password == md5(md5($user_transfer->old_id).$this->CI->input->post('password')))
					{
						//Transfer pw
						$this->CI->db
						->set('password', $this->get_hash($this->CI->input->post('password')))
						->set('update', 'NOW()', FALSE)
						->where('id', $user->id)
						->update(User::TABLE);
						
						$this->CI->db
						->where('user_id', $user->id)
						->delete('transfer_user');
					}
					else
					{
						return FALSE;
					}
				}
			}
		}
		
		self::$user_id = $this->CI->user->login(
			$this->CI->input->post('username'), 
			$this->get_hash($this->CI->input->post('password'))
		);

		if(self::$user_id > 0)
		{
			$this->CI->session->set_userdata('user_id', self::$user_id);
			self::$is_admin = $this->CI->user->is_admin(self::$user_id);
			$this->CI->session->set_userdata('is_admin', self::$is_admin);
			self::$user_name = $this->CI->input->post('username');
			return TRUE;
		}
		
		// No existing user or password wrong
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * User is logged in
	 * 
	 * @access public
	 * @return boolean
	 */
	public function logged_in()
	{
		return (self::$user_id > 0 || self::$user_id = $this->CI->session->userdata('user_id'));
	}

	// --------------------------------------------------------------------
	
	/**
	 * User is admin
	 * 
	 * @access public
	 * @return boolean
	 */
	public function is_admin()
	{
		if(self::$is_admin != NULL)
		{
			return self::$is_admin;
		}
		return self::$is_admin = $this->CI->session->userdata('is_admin');
	}

	// --------------------------------------------------------------------
	
	/**
	 * Getter for user id
	 *
	 * @access	public
	 * @return	mixed	value - user id or boolean false if not logged in
	 */
	public function get_id()
	{
		if($this->logged_in())
		{
			return self::$user_id;
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Getter for user name
	 * 
	 * @access public
	 * @return mixed
	 */
	public function get_name()
	{		
		if(!$this->logged_in())
		{
			return FALSE;
		}
			
		if(self::$user_name != '')
		{
			return self::$user_name;
		}
		
		self::$user_name = $this->CI->user->get_name(self::$user_id);
			
		if(self::$user_name != '')
		{
			return self::$user_name;
		}
		
		return FALSE;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get the user database object
	 * 
	 * @access public
	 * @return db-obj
	 */
	public function get_user()
	{
		if(!$this->logged_in())
		{
			return FALSE;
		}
			
		return $this->user->get_user(self::$user_id);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Logout
	 *
	 * Log out the current user and redirect to index page
	 */
	public function logout()
	{
		$this->CI->session->set_userdata('user_id', '');
		$this->CI->session->set_userdata('is_admin', '');
		$this->CI->session->set_userdata('redirected_from', '');
		$this->CI->session->sess_destroy();
		$this->restrict();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Get the hash for a password
	 * 
	 * @access public
	 * @param string
	 * @return string
	 */
	public function get_hash($password)
	{
		return sha1(self::$salt.$password);
	}
}

/* End of file: Auth.php */
/* Location: application/libraries/Auth.php */
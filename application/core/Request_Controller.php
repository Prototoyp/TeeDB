<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class Ajax_Controller extends CI_Controller {
		
	/**
	 * Constructor
	 */
	function __construct()
	{
		parent::__construct();
	}

	// --------------------------------------------------------------------
	
	/**
	 * Remap requests of post/ajax
	 * 
	 * Remap ajax requests to ajax_{$methode} and post requests to post_{$methode}
	 */	
	public function _remap($method, $params = array())
	{
		if($this->input->is_ajax_request())
		{
	    	if(method_exists($this, 'ajax_'.$method))
	    	{
	        	return call_user_func_array(array($this, 'ajax_'.$method), $params);
	    	}
			else 
			{
            	show_error('No ajax-handler.');
			}
		}
		elseif($this->input->post())
		{
	    	if(method_exists($this, 'post_'.$method))
	    	{
	        	return call_user_func_array(array($this, 'post_'.$method), $params);
	    	}
			else 
			{
            	show_error('No post-handler.');
			}
		}
		else
		{
            show_404();
		}
	}

	// --------------------------------------------------------------------
	
	/**
	 * Output json
	 * 
	 * Set header for json and output given array in json encoding
	 * 
	 * @access protected
	 * @param array Array converted to json
	 * @param boolean Set if csrf token should be refreshed (default: off)
	 * @return null
	 */	
	protected function _output_json($json, $refresh_csrf = FALSE) 
	{
	    $this->output->set_header('Last-Modified: '.gmdate('D, d M Y H:i:s', time()).' GMT');
	    $this->output->set_header('Expires: '.gmdate('D, d M Y H:i:s', time()).' GMT');
	    $this->output->set_header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0, post-check=0, pre-check=0");
	    $this->output->set_header("Pragma: no-cache");
		
		//To generate a new csrf hash
		if($refresh_csrf)
		{
			form_open();
			$json['csrf_token_name'] = $this->security->get_csrf_token_name();
			$json['csrf_hash'] = $this->security->get_csrf_hash();
			$this->security->csrf_set_cookie();			
		}
		
		$this->output->append_output(json_encode($json));
	}

	// --------------------------------------------------------------------
	
	/**
	 * Output json error message
	 * 
	 * Set header for json and output given error message in json encoding
	 * 
	 * @access protected
	 * @param string/array Error message(s)
	 * @return null
	 */	
	protected function _output_error($msg = NULL) 
	{
		$json = array(
			'error' => TRUE,
			'html' => (is_array($msg))? $msg : array($msg)
		);
		
		$this->_output_json($json);
	}

	// --------------------------------------------------------------------
	
	/**
	 * Output json info message
	 * 
	 * Set header for json and output given info message in json encoding
	 * 
	 * @access protected
	 * @param string Info message
	 * @param array Upload data
	 * @return null
	 */	
	protected function _output_info($msg = '', $uploads = array()) 
	{
		$json = array(
			'error' => FALSE,
			'html' => $msg,
			'uploads' => $uploads
		);
		
		$this->_output_json($json);
	}
	
}
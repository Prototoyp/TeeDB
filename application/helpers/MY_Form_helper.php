<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Validation Error String
 *
 * Returns all the errors associated with a form submission.  This is a helper
 * function for the form validation class.
 *
 * @access	public
 * @param	string
 * @param	string
 * @return	string
 */
if ( ! function_exists('show_messages'))
{
	function show_messages($prefix = '', $suffix = '')
	{
		$display_str = '';
		
		//Success and info messages
		if (FALSE !== ($template =& _get_template_object()))
		{
			$display_str .= $template->success_string();
			$display_str .= $template->info_string();
		}
		
		//Form errors
		if (FALSE !== ($form_validation =& _get_validation_object()))
		{
			$display_str .= $form_validation->error_string();
		}
		
		//Upload errors
		if (FALSE !== ($upload =& _get_upload_object()))
		{
			$display_str .= $upload->display_errors();
		}

		return $display_str;
	}
}

// ------------------------------------------------------------------------

/**
 * Template Object
 *
 * Determines what the template class was instantiated as, fetches
 * the object and returns it.
 *
 * @access	private
 * @return	mixed
 */
if ( ! function_exists('_get_template_object'))
{
	function &_get_template_object()
	{
		$CI =& get_instance();

		// We set this as a variable since we're returning by reference.
		$return = FALSE;

		if (FALSE !== ($object = $CI->load->is_loaded('template')))
		{
			if ( ! isset($CI->$object) OR ! is_object($CI->$object))
			{
				return $return;
			}

			return $CI->$object;
		}

		return $return;
	}
}

// ------------------------------------------------------------------------

/**
 * Upload Object
 *
 * Determines what the upload validation class was instantiated as, fetches
 * the object and returns it.
 *
 * @access	private
 * @return	mixed
 */
if ( ! function_exists('_get_upload_object'))
{
	function &_get_upload_object()
	{
		$CI =& get_instance();

		// We set this as a variable since we're returning by reference.
		$return = FALSE;

		if (FALSE !== ($object = $CI->load->is_loaded('upload')))
		{
			if ( ! isset($CI->$object) OR ! is_object($CI->$object))
			{
				return $return;
			}

			return $CI->$object;
		}

		return $return;
	}
}
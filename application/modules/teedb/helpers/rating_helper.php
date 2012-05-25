<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get percent
 *
 * @access	public
 * @param	integer Value
 * @param	integer Amount
 * @param	integer Decimal places [default = 0]
 * @return	decimal Percent
 */
if ( ! function_exists('get_precent'))
{
	function get_precent($value, $amount, $decimal = 0)
	{
		if($amount == 0)
		{
			return 50;
		}
		
		return round($value/$amount*100, $decimal);
	}
}

// --------------------------------------------------------------------

/**
 * Value between min and max
 *
 * @access	public
 * @param	integer Value
 * @param	integer Minimal allowed value
 * @param	integer Maximal allowed value
 * @param	integer Value between min and max
 */
if ( ! function_exists('value_between'))
{
	function value_between($value, $min, $max)
	{
		if($value < $min)
		{
			return $min;
		}
		elseif($value > $max)
		{
			return $max;
		}
		
		return $value;
	}
}
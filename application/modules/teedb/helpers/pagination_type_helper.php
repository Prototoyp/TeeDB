<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Get sort and order
 *
 * @access	public
 * @param	order To validate and set sorting for database query
 * @param	alias Alias for tablename
 * @return	array(order, sort)
 */
if ( ! function_exists('get_db_sort'))
{
	function get_db_sort($order, $alias)
	{
		switch($order)
		{
			case 'new': $sort = $alias.'.create'; break;
			case 'rate': $sort = 'SUM(rate.value)'; break;
			case 'dw': $sort = $alias.'.downloads'; break;
			case 'name': $sort = $alias.'.name'; break;
			case 'author': $sort = 'user.name'; break;
			default: $order = 'new'; $sort = $alias.'.create';
		}
		
		return array($order, $sort);
	}
}

// --------------------------------------------------------------------

/**
 * Validate sql order direction
 * 
 * Can be DESC or ASC
 *
 * @access	public
 * @param	string
 * @return	string
 */
if ( ! function_exists('validate_direction'))
{
	function validate_direction($direction)
	{
		switch($direction)
		{
			case 'desc': break;
			case 'asc': break;
			default: $direction = 'desc';
		}
		
		return $direction;
	}
}

// --------------------------------------------------------------------

/**
 * Validate sql limit offset and amount
 *
 * @access	public
 * @param	integer Offset
 * @param	interger Maximum value
 * @return	integer
 */
if ( ! function_exists('validate_limit'))
{
	function validate_limit($offset, $max, $num_get)
	{
		if(!is_numeric($offset) || $offset < 0 || $offset > $max)
		{
			$offset = 0;
		}
		
		$limit = $max - $offset; 
		if($limit > $num_get)
		{
			$limit = $num_get;
		}
		
		return array($offset, $limit);
	}
}
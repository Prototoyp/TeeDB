<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if( ! function_exists('string_limiter'))
{
	function string_limiter($str, $n = 500, $end_char = '&#8230;')
	{
		$str = trim($str);
		$len = strlen($str);//length of original string
		
		if($len <= $n)
		{
			return $str;
		}
		
		$substr = trim(substr($str,0,$n));
		
		//if string has only 2 chars more == len of end char '...'
		if($end_char == '&#8230;' && $len <=  $n+3)
		{
			return $str;
		}
		
	    return $substr.$end_char;
	} 
}
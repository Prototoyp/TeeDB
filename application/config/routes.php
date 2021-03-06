<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * CodeIgniter
 *
 * An open source application development framework for PHP 5.1.6 or newer
 *
 * NOTICE OF LICENSE
 * 
 * Licensed under the Academic Free License version 3.0
 * 
 * This source file is subject to the Academic Free License (AFL 3.0) that is
 * bundled with this package in the files license_afl.txt / license_afl.rst.
 * It is also available through the world wide web at this URL:
 * http://opensource.org/licenses/AFL-3.0
 * If you did not receive a copy of the license and are unable to obtain it
 * through the world wide web, please send an email to
 * licensing@ellislab.com so we can send you a copy immediately.
 *
 * @package		CodeIgniter
 * @author		EllisLab Dev Team
 * @copyright	Copyright (c) 2008 - 2012, EllisLab, Inc. (http://ellislab.com/)
 * @license		http://opensource.org/licenses/AFL-3.0 Academic Free License (AFL 3.0)
 * @link		http://codeigniter.com
 * @since		Version 1.0
 * @filesource
 */

/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There are two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/

$route['default_controller'] = "welcome";
$route['404_override'] = '';

//Blog routing
$route['feed'] = "blog/feed";
$route['news'] = "blog/news";
$route['news/page/(:num)'] = "blog/news/index/$1";
$route['news/(:any)'] = "blog/news/title/$1";

//User routing
$route['login'] = "user/login";
$route['intern'] = "user/intern";
$route['logout'] = "user/logout";

//TeeDB routing for database types
$route['demos'] = "teedb/demos";
$route['demos/(:any)'] = "teedb/demos/index/$1";

$route['gameskins'] = "teedb/gameskins";
$route['gameskins/(:any)'] = "teedb/gameskins/index/$1";

$route['mapres'] = "teedb/mapres";
$route['mapres/(:any)'] = "teedb/mapres/index/$1";

$route['maps'] = "teedb/maps";
$route['maps/(:any)'] = "teedb/maps/index/$1";

$route['mods'] = "teedb/mods";
$route['mods/(:any)'] = "teedb/mods/index/$1";

$route['skins'] = "teedb/skins";
$route['skins/(:any)'] = "teedb/skins/index/$1";

//TeeDB routing part 2
$route['upload'] = "teedb/upload";
$route['upload/(:any)'] = "teedb/upload/$1";

$route['myteedb'] = "teedb/myteedb";
$route['myteedb/(:any)'] = "teedb/myteedb/$1";

$route['api'] = "teedb/api";
$route['api/(:any)'] = "teedb/api/$1";

$route['download/(:any)'] = "teedb/downloads/index/$1";


/* End of file routes.php */
/* Location: ./application/config/routes.php */
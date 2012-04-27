<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
|--------------------------------------------------------------------------
| Set the theme
|--------------------------------------------------------------------------
|
| Theme is set by default to standart html5boilerplate template.
| New theme can be create under view/templates and must contain header.php and footer.php
|
*/

$template['theme'] = 'teedb';

/*
|--------------------------------------------------------------------------
| Set message delimiters
|--------------------------------------------------------------------------
|
| Set global message delimiters for errors [validation_errors (form_validation)
| and display_errors (upload validation)], success and info messages.
|
*/

$template['error_delimiters']['open'] = '<p class="error color border"><span class="icon color icon100"></span>';
$template['error_delimiters']['close'] = '</p>';
$template['success_delimiters']['open'] = '<p class="success color border"><span class="icon color icon101"></span>';
$template['success_delimiters']['close'] = '</p>';
$template['info_delimiters']['open'] = '<p class="info border"><span class="icon color icon112"></span>';
$template['info_delimiters']['close'] = '</p>';

/*
|--------------------------------------------------------------------------
| Add layout views
|--------------------------------------------------------------------------
|
| Add views load between header and footer
| Dont forget to autoload used libs and helper classes
|
*/

$template['layouts'] = array('nav');

/*
|--------------------------------------------------------------------------
| Set header data
|--------------------------------------------------------------------------
|
| Header data will be set in the <head> tag inside header.php
| Set page title, author and a small description
|
*/

$template['title'] = 'TeeDB';
$template['author'] = 'Andreas Gehle';
$template['description'] = '';

/*
|--------------------------------------------------------------------------
| Google analytics ID
|--------------------------------------------------------------------------
|
| Set the google analytic ID for your site
|
*/

$template['google_analytic_id'] = 'UAXXXXXXXX1';

/*
 * Note: css, js must be define in the template cause of Ant Builder
 */
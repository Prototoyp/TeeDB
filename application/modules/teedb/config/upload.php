<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

	$config['skin']['upload_path']			= 'uploads/skins';
	$config['skin']['preview_path'] 		= 'uploads/skins/previews';
	$config['skin']['allowed_types']		= 'png';
	$config['skin']['max_size']				= '100'; //100kB
	$config['skin']['max_width']  			= '256';
	$config['skin']['max_height']  			= '128';
	$config['skin']['min_width'] 			= '256';
	$config['skin']['min_height']  			= '128';
	
	$config['mapres']['upload_path'] 		= 'uploads/mapres';
	$config['mapres']['preview_path'] 		= 'uploads/mapres/previews';
	$config['mapres']['allowed_types'] 		= 'png';
	$config['mapres']['max_size']			= '1000'; //1MB
	
	$config['gameskin']['upload_path'] 		= 'uploads/gameskins';
	$config['gameskin']['preview_path'] 	= 'uploads/gameskins/previews';
	$config['gameskin']['allowed_types']	= 'png';
	$config['gameskin']['max_size']			= '1000'; //1MB
	$config['gameskin']['max_width']  		= '1024';
	$config['gameskin']['max_height']  		= '512';
	$config['gameskin']['min_width']  		= '1024';
	$config['gameskin']['min_height']  		= '512';
	
	$config['map']['upload_path'] 			= 'uploads/maps';
	$config['map']['preview_path'] 			= 'uploads/maps/previews';
	$config['map']['allowed_types'] 		= 'map';
	$config['map']['max_size']				= '10000'; //10MB
	
	$config['demo']['upload_path'] 			= 'uploads/demos';
	$config['demo']['preview_path'] 		= 'uploads/demos/previews';	
	$config['demo']['allowed_types'] 		= 'demo';
	$config['demo']['max_size']				= '10000'; //10MB
	
	$config['mod']['upload_path'] 			= 'uploads/mods';
	$config['mod']['encrypt_name']  		= TRUE;
	$config['mod']['allowed_types'] 		= 'png';
	$config['mod']['max_size']				= '1000'; //1MB
	$config['mod']['min_width']  			= '180';
	$config['mod']['min_height']  			= '180';			
	
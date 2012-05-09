<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Old TeeDB database-data and upload transfer Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Transfer_Skins extends Transfer_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->library(array('teedb/Skin_preview'));
		$this->load->model(array('user/user','teedb/skin'));
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{
		//Flush example data
		$this->db->empty_table(Skin::TABLE);
		
		//Uploads
		// $uploads = scandir('database/skins');
		// $uploads = array_flip($uploads);
		// unset($uploads['previews']);
		// unset($uploads['.']);
		// unset($uploads['..']);
		
		$uploads = array();
	    // $directory = opendir('database/skins'); 
	    // while($item = readdir($directory)){ 
	         // if(($item != ".") && ($item != "..") && ($item != "previews")){ 
	              // $uploads[$item] = true; 
	         // } 
	    // }
	    $uploads = get_filenames('database/skins');
		$uploads = array_flip($uploads);
		$countfiles = count($uploads);
		
		//Skins
		$old_skins = $this->old_db
		->select('name, username, s.date')
		->from('skins AS s')
		->join('user AS u', 's.user_id = u.id')
		->get()->result();
		
		$error = 0;
		$files = 0;
		foreach($old_skins as $skin)
		{
			if(array_key_exists($skin->name.'.png', $uploads))
			{
				unset($uploads[$skin->name]);
				$files++;
				
				if(!file_exists('database/skins/'.$skin->name.'.png'))
				{
					$this->db
					->set('type', 'skin')
					->set('name', $skin->name)
					->set('username', $skin->username)
					->set('error', 'No file found to given skinname in database.')
					->insert('transfer_invalid');
					
					$error++; 
				}
				else
				{
				
					//Check
					list($width, $height, $type, $attr) = getimagesize('database/skins/'.$skin->name.'.png');
					
					if($width != 256 or $height != 128)
					{
						$this->db
						->set('type', 'skin')
						->set('name', $skin->name)
						->set('username', $skin->username)
						->set('error', 'Dimension of skins must be 1024x512. Given '.$width.'x'.$height.'.')
						->insert('transfer_invalid');
						
						$error++; 
					}
					elseif(filesize('database/skins/'.$skin->name.'.png') > 100000)
					{
						$this->db
						->set('type', 'skin')
						->set('name', $skin->name)
						->set('username', $skin->username)
						->set('error', 'Filesize greater than allowed 100kB for skin uploads.')
						->insert('transfer_invalid');
						
						$error++;
					}
					else
					{
						//User transfered?
						$query = $this->db
						->select('id')
						->where('name', $skin->username)
						->get(User::TABLE);
						
						if($query->num_rows())
						{
							$filename = $this->security->sanitize_filename($skin->name);
							
							//Add skin
							$this->db
							->set('name', $filename)
							->set('user_id', $query->row()->id)
							->set('update', 'NOW()', FALSE)
							->set('create', $skin->date)
							->insert(Skin::TABLE);
							
							//Add file
							copy('database/skins/'.$skin->name.'.png' , 'uploads/skins/'.$filename.'.png');
							if(!copy('database/skins/previews/'.$skin->name.'.png' , 'uploads/skins/previews/'.$filename.'.png'))
							{
								$this->skin_preview->create($filename);
							}
						}
						else
						{
							$this->db
							->set('type', 'skin')
							->set('name', $skin->name)
							->set('username', $skin->username)
							->set('error', 'User/Owner not transfered')
							->insert('transfer_invalid');
							
							$error++;
						}
					}
				}
			}
			else
			{
				$this->db
				->set('type', 'skin')
				->set('name', $skin->name)
				->set('username', $skin->username)
				->set('error', 'Missing file!')
				->insert('transfer_invalid');
				
				$error++;
			}
		}

		$count = $this->old_db->count_all_results('skins');
		$this->_output_info('Skins db', $count, array('Invalid' => $error, 'Transfered' => $count-$error));
		$this->_output_info('Skins files', $countfiles, array('Has publisher' => $files, 'No publisher' => $countfiles-$files));
	}

	/**
	 * Build table down
	 */
	function down() 
	{
		$this->db->empty_table(Skin::TABLE);
		
		if( ! delete_files('uploads/skins'))
		{
			show_error('Coundn\'t delete skin files in uploads');
		}
		
		if( ! delete_files('uploads/skins/previews'))
		{
			show_error('Coundn\'t delete skin previews files in uploads');
		}
		
		$this->db->where('type', 'skin')->delete('transfer_invalid'); 
	}
}

/* End of file 012_teedb_rates.php */
/* Location: ./application/migrations/012_teedb_rates.php */
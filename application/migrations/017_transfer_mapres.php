<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Old TeeDB database-data and upload transfer Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Transfer_Mapres extends Transfer_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->library(array('image_lib','security'));
		$this->load->model(array('user/user','teedb/tileset'));
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{
		$type = 'mapres';
		
		//Flush example data
		$this->db->empty_table(Mapres::TABLE);
		
		$uploads = array();
	    $directory = opendir('database/'.$type); 
	    while($item = readdir($directory)){ 
	         if(($item != ".") && ($item != "..") && ($item != "previews")){ 
	              $uploads[$item] = true; 
	         } 
	    }
		$countfiles = count($uploads);
		
		//Skins
		$old_skins = $this->old_db
		->select('name, username, s.date')
		->from($type.' AS s')
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
				
				//Check
				if(filesize('database/'.$type.'/'.$skin->name.'.png') > 1000000)
				{
					$this->db
					->set('type', 'mapres')
					->set('name', $skin->name)
					->set('username', $skin->username)
					->set('error', 'Filesize greater than allowed 1MB for mapres uploads not allowed.')
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
						->insert(Tileset::TABLE);
						
						//Add file
						copy('database/'.$type.'/'.$skin->name.'.png' , 'uploads/'.$type.'/'.$filename.'.png');
						$this->skin_preview->create($filename);
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
		
		$this->delete_files('uploads/skins');
		$this->delete_files('uploads/skins/previews');
		
		$this->db->where('type', 'skin')->delete('transfer_invalid'); 
	}
}

/* End of file 012_teedb_rates.php */
/* Location: ./application/migrations/012_teedb_rates.php */
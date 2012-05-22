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
	
	const TABLE = 'transfer_invalid_mapres';
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->library(array('image_lib'));
		$this->load->model(array('user/user','teedb/tileset'));
		$this->load->config('teedb/upload');
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{
		//Flush example data
		$this->db->empty_table(Tileset::TABLE);
		
		//Build invalide data table
		$this->dbforge->add_key('id', TRUE);
		
		$this->dbforge->add_field(array(
			'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
			'create' => array('type' => 'DATETIME', 'null' => FALSE),
			'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
			'error' => array('type' => 'TEXT', 'null' => FALSE)
		));
		$this->dbforge->create_table(self::TABLE, TRUE);
		
		//Uploads
		$uploads = array();
	    $uploads = get_filenames('database/mapres');
		$uploads = array_flip($uploads);
		$countfiles = count($uploads);
		
		//Mapresis
		$old_skins = $this->old_db
		->select('name, username, s.date, user_id')
		->from('mapres AS s')
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
				
				if(!file_exists('database/mapres/'.$skin->name.'.png'))
				{
					$this->db
					->set('name', $skin->name)
					->set('user_id', $skin->user_id)
					->set('error', 'No file found to given mapresname in database.')
					->insert(self::TABLE);
					
					$error++; 
				}
				else
				{
				
					//Check
					if(filesize('database/mapres/'.$skin->name.'.png') > 1000000)
					{
						$this->db
						->set('name', $skin->name)
						->set('user_id', $skin->user_id)
						->set('error', 'Filesize greater than allowed 1MB for mapres uploads.')
						->insert(self::TABLE);
						
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
							$filename = str_replace(' ', '_', $this->security->sanitize_filename($skin->name));
							
							//Add skin
							$this->db
							->set('name', $filename)
							->set('user_id', $query->row()->id)
							->set('update', 'NOW()', FALSE)
							->set('create', $skin->date)
							->insert(Tileset::TABLE);
							
							//Add file
							copy('database/mapres/'.$skin->name.'.png' , 'uploads/mapres/'.$filename.'.png');
							
							//Create thumbnail
							$configResize['source_image'] = 'uploads/mapres/'.$filename.'.png';
							$configResize['new_image'] = $this->config->item('preview_path', 'mapres');
							$configResize['width'] = 110;
							$configResize['height'] = 64;
							
							$this->image_lib->initialize($configResize);
							if(!$this->image_lib->resize())
							{
								//Add errors
								$this->db
								->set('name', $skin->name)
								->set('user_id', $skin->user_id)
								->set('error', 'Transfered, but coundn\'t generate preview file.')
								->insert(self::TABLE);
								
								$error++;
							}
							
							$this->image_lib->clear();
							$this->image_lib->initialize($configResize);
							if(!$this->image_lib->resize())
							{
								//Add errors
								$this->db
								->set('name', $skin->name)
								->set('user_id', $skin->user_id)
								->set('error', 'Transfered, but coundn\'t generate preview again file.')
								->insert(self::TABLE);
								
								$error++;
							}
						}
						else
						{
							$this->db
							->set('name', $skin->name)
							->set('user_id', $skin->user_id)
							->set('error', 'User/Owner not transfered')
							->insert(self::TABLE);
							
							$error++;
						}
					}
				}
			}
			else
			{
				$this->db
				->set('name', $skin->name)
				->set('user_id', $skin->user_id)
				->set('error', 'Missing file!')
				->insert(self::TABLE);
				
				$error++;
			}
		}

		$count = $this->old_db->count_all_results('mapres');
		
		//stats
		$this->load->vars(
			array('feedback' => (
				$this->_output_info('Mapres db', $count, array('Invalid' => $error, 'Transfered' => $count-$error))
				.'<br />'.
				$this->_output_info('Mapres files', $countfiles, array('Has publisher' => $files, 'No publisher' => $countfiles-$files))
			))
		);
	}

	/**
	 * Build table down
	 */
	function down() 
	{
		$this->dbforge->drop_table(self::TABLE);
		
		$this->db->empty_table(Tileset::TABLE);
		
		if( ! delete_files('uploads/mapres'))
		{
			show_error('Coundn\'t delete mapres files in uploads');
		}
		
		if( ! delete_files('uploads/mapres/previews'))
		{
			show_error('Coundn\'t delete mapres previews files in uploads');
		}
		
		$this->db->empty_table(self::TABLE); 
	}
}

/* End of file 012_teedb_rates.php */
/* Location: ./application/migrations/012_teedb_rates.php */
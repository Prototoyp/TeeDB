<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Old TeeDB database-data and upload transfer Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Transfer_Skins extends CI_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->library('teedb/Skin_preview');
		$this->load->model(array('user/user','teedb/skin'));
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		
		if ($this->old_db = $this->load->database('transfer', TRUE))
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
		    $directory = opendir('database/skins'); 
		    while($item = readdir($directory)){ 
		         if(($item != ".") && ($item != "..") && ($item != "previews")){ 
		              $uploads[$item] = true; 
		         } 
		    }
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
					//else check skin name is valid
					else
					{
						//User transfered?
						$query = $this->db
						->select('id')
						->where('name', $skin->username)
						->get(User::TABLE);
						
						if($query->num_rows())
						{
							//Add skin
							$this->db
							->set('name', $skin->name)
							->set('user_id', $query->row()->id)
							->set('update', 'NOW()', FALSE)
							->set('create', $skin->date)
							->insert(Skin::TABLE);
							
							//Add file
							copy('database/skins/'.$skin->name.'.png' , 'uploads/skins/'.$skin->name.'.png');
							if(!copy('database/skins/previews/'.$skin->name.'.png' , 'uploads/skins/previews/'.$skin->name.'.png'))
							{
								$this->skin_preview->create($skin->name);
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
			$this->_output_info('Skins', $count, $error, $files, $countfiles);
		}
		else
		{
			echo 'Cant connect to transfer DB';
		}
	}

	/**
	 * Build table down
	 */
	function down() 
	{
		$this->db
		->empty_table(Skin::TABLE);
		
		$this->db
		->where('type', 'skin')
		->delete('transfer_invalid'); 
	}

	private function _output_info($type, $count, $invalid, $files = 0, $countfiles = 0)
	{
		echo '<strong>'.$type.': </strong><br>';
		echo 'Count: '.$count.'<br>';
		echo 'Invalid: '.$invalid.' ('.round(($invalid*100)/$count).'%)<br>';
		echo 'Transfered: '.($count-$invalid).' ('.round((($count-$invalid)*100)/$count).'%)<br>';
		echo 'Files without DB: '.($countfiles-$files).'/'.$countfiles.'<br>';
		echo '<br>------------------<br>';
	}
}

/* End of file 012_teedb_rates.php */
/* Location: ./application/migrations/012_teedb_rates.php */
<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Old TeeDB database-data and upload transfer Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Transfer extends CI_Migration {
	
	private $old_db = NULL;
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->library(array('form_validation', 'user/auth'));
		$this->load->model(array('user/user','teedb/skin'));
		
		$config['hostname'] = "localhost";
		$config['username'] = "root";
		$config['password'] = "";
		$config['database'] = "twdoodads";
		$config['dbdriver'] = "mysql";
		$config['dbprefix'] = "tw_";
		$config['pconnect'] = FALSE;
		$config['db_debug'] = TRUE;
		$config['cache_on'] = FALSE;
		$config['cachedir'] = "";
		$config['char_set'] = "utf8";
		$config['dbcollat'] = "utf8_general_ci";
		
		$this->old_db = $this->load->database($config, TRUE);
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		
		if ($this->old_db)
		{
			//Flush example data
			$this->db->empty_table(User::TABLE);
			
			//Build invalide data table
			$this->dbforge->add_key('id', TRUE);
			
			$this->dbforge->add_field(array(
				'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
				'type' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				'name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				'username' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
				'error' => array('type' => 'TEXT', 'null' => FALSE)
			));
			$this->dbforge->create_table('transfer_invalid', TRUE);
			
			
			//Build user password transfer table
			$this->dbforge->add_key('user_id', TRUE);
			
			$this->dbforge->add_field(array(
				'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
				'password' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => FALSE)
			));
			$this->dbforge->create_table('transfer_user', TRUE);
			
			
			
			
			//Transfer the data
			
			//Userdata
			$old_activ_users = $this->old_db
			->select('username, passwort, email, RegDatum')
			->where('activated', 1)
			->get('user')
			->result();
			
			$_POST = array();
			$error = 0;
			foreach($old_activ_users as $user)
			{
				$_POST['username'] = $user->username;
				$_POST['password'] = 'validpassword';
				$_POST['passconf'] = 'validpassword';
				$_POST['email'] = $user->email;
				
				if($this->form_validation->run('signup') === TRUE)
				{
					//Add user
					$user_id = $this->user->add_user(
						$user->username, 
						NULL,
						$user->email
					);
					
					//Transfer password
					$this->db
					->set('user_id', $user_id)
					->set('password', $user->passwort)
					->insert('transfer_user');
				}
				else
				{
					$this->db
					->set('type', 'user')
					->set('username', $user->username)
					->set('error', validation_errors())
					->insert('transfer_invalid');
					
					$error++;
				}
				
				//Reset form input
				$_POST = array();
				$this->form_validation->reset_validation();
			}

			$count_deleted = $this->old_db
			->select('count(*) as count')
			->where('activated', 0)
			->get('user')
			->row()->count;
			$count = $this->old_db->count_all_results('user');
			$this->_output_info('Users', $count, $error, $count_deleted);
			
			//TODO: Uploads
		}
	}

	/**
	 * Build table down
	 */
	function down() 
	{
		$this->dbforge->drop_table('transfer_user');
		$this->dbforge->drop_table('transfer_invalid');
		
		$this->db->empty_table(User::TABLE);
		//$this->db->empty_table(Skin::TABLE);
	}

	private function _output_info($type, $count, $invalid, $ignored = 0)
	{
		echo '<strong>'.$type.': </strong><br>';
		echo 'Count: '.$count.'<br>';
		echo 'Invalid: '.$invalid.' ('.round(($invalid*100)/$count).'%)<br>';
		echo 'Deleted: '.$ignored.' ('.round(($ignored*100)/$count).'%)<br>';
		echo 'Transfered: '.($count-($invalid+$ignored)).' ('.round((($count-($invalid+$ignored))*100)/$count).'%)<br>';
		echo '<br>------------------<br>';
	}
}

/* End of file 012_teedb_rates.php */
/* Location: ./application/migrations/012_teedb_rates.php */
<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Old TeeDB database-data and upload transfer Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Transfer_Users extends Transfer_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->library(array('form_validation', 'user/auth'));
		$this->load->model('user/user');
		
		$this->load->config('user/form_validation');
	}
	
	/**
	 * Build table up
	 */	
	function up() 
	{	
		//Flush example data
		$this->db->empty_table(User::TABLE);
		
		//Build invalide data table
		$this->dbforge->add_key('id', TRUE);
		
		$this->dbforge->add_field(array(
			'id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'auto_increment' => TRUE),
			'name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
			'username' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
			'email' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
			'create' => array('type' => 'DATETIME', 'null' => FALSE),
			'old_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
			'password' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => FALSE),
			'error' => array('type' => 'TEXT', 'null' => FALSE)
		));
		$this->dbforge->create_table('transfer_invalid_users', TRUE);
		
		
		//Build user password transfer table
		$this->dbforge->add_key('user_id', TRUE);
		$this->dbforge->add_key('old_id', TRUE);
		
		$this->dbforge->add_field(array(
			'user_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
			'old_id' => array('type' => 'INT', 'constraint' => 10, 'unsigned' => TRUE, 'null' => FALSE),
			'password' => array('type' => 'VARCHAR', 'constraint' => 32, 'null' => FALSE)
		));
		$this->dbforge->create_table('transfer_user', TRUE);
		
		
		
		
		//Transfer the data
		
		//Userdata
		$old_activ_users = $this->old_db
		->select('id, username, passwort, email, RegDatum')
		->where('activated', 1)
		->get('user');
		
		$_POST = array();
		$error = 0;
		$has_uploads = 0;
		$count_active = $old_activ_users->num_rows();
		foreach($old_activ_users->result() as $user)
		{
			$_POST['username'] = $user->username;
			//Pseudo password for validation
			$_POST['password'] = 'validpassword';
			$_POST['passconf'] = 'validpassword';
			$_POST['email'] = $user->email;
			
			if($this->form_validation->run('signup') === TRUE)
			{
				//Add user
				$this->db
				->set('name', $user->username)
				->set('password', NULL)
				->set('email', $user->email)
				->set('status', 1)
				->set('update', 'NOW()', FALSE)
				->set('create', $user->RegDatum)
				->insert(USER::TABLE);
				
				//Transfer password
				$this->db
				->set('user_id', $this->db->insert_id())
				->set('old_id', $user->id)
				->set('password', $user->passwort)
				->insert('transfer_user');
			}
			else
			{
				$error++;
				
				if($count = $this->count_uploads($user->id))
				{
					$has_uploads++;
					$this->form_validation->add_message('<strong style="color:red">I have '.$count.' uploads! :( </strong>');
				}
				else {
					$this->form_validation->add_message('<strong style="color:green">No uploads. Can be deleted.</strong>');
				}
				
				$this->db
				->set('username', $user->username)
				->set('email', $user->email)
				->set('password', $user->passwort)
				->set('old_id', $user->id)
				->set('error', validation_errors())
				->set('create', $user->RegDatum)
				->insert('transfer_invalid_users');
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
		
		$this->load->vars(
			array('feedback' => (
				$this->_output_info('Users', $count, array('Transfered' => $count_active-$error, 'Invalid (No uploads)' => $error-$has_uploads, 'Invalid (Has uploads)' => $has_uploads, 'Not activated/ Deleted' => $count_deleted))
				.'<br />'.
				$this->_output_info('Invalid Users', $error, array('Has uploads' => $has_uploads, 'Has no uploads' => $error-$has_uploads))
			))
		);
	}

	/**
	 * Build table down
	 */
	function down() 
	{
		$this->dbforge->drop_table('transfer_user');
		$this->dbforge->drop_table('transfer_invalid_users');
		
		$this->db->empty_table(User::TABLE);
	}
	
	
	public function has_uploads($id)
	{
		$tables = array('tw_gameskins', 'tw_mapres', 'tw_maps', 'tw_mods', 'tw_demos', 'tw_skins');
		
		foreach($tables as $table){		
			$query = $this->old_db
				->select('id')
				->where('user_id', $id)
				->get($table);
			if($query->num_rows() > 0)
			{
				return TRUE;
			}
		}
		
		return FALSE;
	}
	
	
	public function count_uploads($id)
	{
		$tables = array('tw_gameskins', 'tw_mapres', 'tw_maps', 'tw_mods', 'tw_demos', 'tw_skins');
		
		$count = 0;
		
		foreach($tables as $table){		
			$query = $this->old_db
				->select('id')
				->where('user_id', $id)
				->get($table);
			if($query->num_rows() > 0)
			{
				$count += $query->num_rows();
			}
		}
		
		return $count;
	}
}

/* End of file 012_teedb_rates.php */
/* Location: ./application/migrations/012_teedb_rates.php */
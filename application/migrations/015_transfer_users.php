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
			'type' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
			'name' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
			'username' => array('type' => 'VARCHAR', 'constraint' => '255', 'null' => FALSE),
			'error' => array('type' => 'TEXT', 'null' => FALSE)
		));
		$this->dbforge->create_table('transfer_invalid', TRUE);
		
		
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
		$this->_output_info('Users', $count, array('Transfered' => $count_active-$error, 'Invalid' => $error, 'Not activated/ Deleted' => $count_deleted));
	}

	/**
	 * Build table down
	 */
	function down() 
	{
		$this->dbforge->drop_table('transfer_user');
		$this->dbforge->drop_table('transfer_invalid');
		
		$this->db->empty_table(User::TABLE);
	}
}

/* End of file 012_teedb_rates.php */
/* Location: ./application/migrations/012_teedb_rates.php */
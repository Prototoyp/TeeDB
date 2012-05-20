<?php defined('BASEPATH') OR exit('No direct script access allowed');
/**
 * Example datas Migration
 *
 * @package		Application
 * @subpackage	Migrations
 * @category	Migrations
 * @author		Andreas Gehle
 */
class Migration_Example_News extends CI_Migration {
	
	/**
	 * Constructor
	 */
	function __construct()
	{
        parent::__construct();
		
		$this->load->model(array('user/user','blog/blog'));
	}
	
	/**
	 * Build sample data
	 */	
	function up() 
	{
		if(ENVIRONMENT == 'development' && $this->db->table_exists(Blog::TABLE))
		{
			$query = $this->db
			->select('id')
			->limit(1)
			->get(User::TABLE);
			
			$user_id = $query->row()->id;
			
			//Bacon news... its tasty ;)
			for($i=0;$i<10;$i++)
			{
				$title = 'Boring Lorem Ipsum? No.'.$i;
				
				$this->db
				->set('title', $title)
				->set('url_title', url_title($title))
				->set('content', 'Salami spare ribs pastrami corned beef pork belly filet mignon.  Shank bresaola corned beef, drumstick pancetta salami pork loin shoulder venison chuck.  Short loin tail turkey andouille jerky.  Pastrami brisket pork shank beef ribs, turkey rump sirloin ham hamburger shankle pork loin frankfurter.  Turducken shank short loin, jerky bacon capicola shankle ham venison pork chop boudin ball tip corned beef.  Brisket strip steak bresaola, ribeye venison tongue boudin meatloaf swine ham hock jerky.  Sirloin swine ham pork loin drumstick.<br><br>Chuck brisket spare ribs sirloin ham hock.  Drumstick salami corned beef, pork chop ground round prosciutto bresaola.  T-bone andouille beef ribs, beef pastrami bacon brisket kielbasa capicola ball tip filet mignon jowl.  Ball tip capicola ham hock turducken turkey, brisket tail shoulder.  Ribeye filet mignon tri-tip, flank fatback pork loin hamburger swine bacon pork belly tenderloin ball tip.  T-bone ham pork, jerky bresaola fatback turducken.  Tail tri-tip pastrami, ground round cow shankle ball tip prosciutto short ribs chicken.<br><br>Pastrami drumstick chicken sausage.  Chuck drumstick ham hock, short ribs capicola rump swine tenderloin sirloin pig t-bone pork chop.  Pig jerky cow, venison strip steak pastrami bacon brisket short loin jowl biltong fatback hamburger turducken pork belly.  Flank corned beef swine, shank shoulder pork chop pork belly brisket shankle ground round.  Shoulder ham kielbasa, chuck turducken short ribs tri-tip.  Bresaola pastrami drumstick, prosciutto fatback salami shoulder spare ribs.  Ham hock filet mignon tri-tip, drumstick pastrami cow beef ribeye flank pork chop biltong.<br><br>Sirloin turkey ham hock sausage, cow pastrami tenderloin jerky flank rump tongue.  Frankfurter tail filet mignon, shankle sirloin corned beef andouille turkey venison ribeye leberkas.  Turducken shank cow biltong venison, beef ribs chicken.  Meatball turducken capicola, pancetta shankle ribeye swine sausage.  Brisket swine filet mignon, prosciutto ham ham hock tail tri-tip shankle.  Capicola fatback rump beef, tenderloin shoulder chicken salami.  Pastrami shoulder chicken ham, boudin ribeye kielbasa jerky.<br><br>Short loin shoulder pastrami, fatback flank ball tip brisket.  Short loin brisket andouille t-bone.  Sausage meatball beef, beef ribs pastrami capicola ribeye.  Shankle flank pork chop chuck t-bone swine, strip steak ground round filet mignon biltong pancetta jerky ham.  Fatback filet mignon corned beef, salami hamburger turkey ham hock jowl biltong shank drumstick pork beef ribs ribeye.  Short ribs pork loin tenderloin, pork belly ham hock spare ribs chuck pig strip steak tongue capicola.  Venison bresaola sausage pastrami, pork chop meatball cow prosciutto shank frankfurter chuck fatback tenderloin meatloaf shankle.')
				->set('user_id', $user_id)
				->set('update', 'NOW()', FALSE)
				->set('create', 'NOW()', FALSE)
				->insert(Blog::TABLE);
			}
		}
	}

	/**
	 * Build clear sample data
	 */
	function down() 
	{
		if(ENVIRONMENT == 'development')
		{	
			//Cascading should do the rest for us
			$this->db->empty_table(Blog::TABLE);
		}
	}
}

/* End of file 090_example_datas.php */
/* Location: ./application/migrations/090_example_datas.php */
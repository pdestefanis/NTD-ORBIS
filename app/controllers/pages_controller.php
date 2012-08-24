<?php
/**
 * Static content controller.
 *
 * This file will render views from views/pages/
 *
 * PHP versions 4 and 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2010, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Static content controller
 *
 * Override this controller by placing a copy in controllers directory of an application
 *
 * @package       cake
 * @subpackage    cake.cake.libs.controller
 */
 
class PagesController extends AppController {

/**
 * Controller name
 *
 * @var string
 * @access public
 */
	var $name = 'Pages';

/**
 * Default helper
 *
 * @var array
 * @access public
 */
	var $helpers = array('Html', 'Form', 'Javascript', 'GoogleMap', 'Crumb', 'UpdateFile', 'Ajax', 'GoogleChart', 'GoogleMapv3', 'Time');
	

/**
 * This controller does not use a model
 *
 * @var array
 * @access public
 */
	var $uses = array();

/**
 * Displays a view
 *
 * @param mixed What page to display
 * @access public
 */
	function  beforeFilter() {
		parent::beforeFilter();
        //load the stats model to update the points file
		$this->loadModel('Stat');
    }
	
	function display() {

		if (isset($this->data['pages']['displayMode']) && $this->data['pages']['displayMode'] == "all") {
			$this->Session->write("displayOption", true);
		}

		$path = func_get_args();
		//$this->buildMenus();
		$count = count($path);
		if (!$count) {
			$this->redirect('/');
		}
		$page = $subpage = $title_for_layout = null;

		if (!empty($path[0])) {
			$page = $path[0];
		}
		if (!empty($path[1])) {
			$subpage = $path[1];
		}
		if (!empty($path[$count - 1])) {
			$title_for_layout = Inflector::humanize($path[$count - 1]);
		}
		$this->updateJSONFile();
		$this->set(compact('page', 'subpage', 'title_for_layout'));
		$this->render(implode('/', $path));
	}
	
	function resetDatabase () {
		$this->autoRender = false;
		$sql = preg_replace('/--.*/', '', file_get_contents("test_data.sql") );
		$config = new DATABASE_CONFIG();
		$config = $config->default;
		//pr($sql);
		//pr(new DATABASE_CONFIG());
		mysqli_multi_query(new mysqli($config['host'], $config['login'], $config['password'], $config['database']), $sql) or die("error."); 
		echo "Database set to contents of test_data.sql \n\n";
		pr($sql);
	}	
	//moved from stats contreoller so that file update is on the fly here
	private function updateJSONFile() {
		/* App::import('Controller', 'Stats');
		var $Stats;
		
		// We need to load the class
		$Stats = new StatsController;
		// If we want the model associations, components, etc to be loaded
		$Stats->constructClasses(); */
		
		if (!($this->data['Stat']['JSONFile'])) {	
				$locations = $this->Stat->query('SELECT * FROM locations where deleted = 0 and id IN (' .  implode(",", $this->Session->read("userLocations"))  . ') ');
	
				$this->set('locations', $locations);
				$listitems = $this->getReports($locations);

				$this->set(compact('listitems', $listitems));
				//echo "<pre>" . print_r($listitems, true) . "</pre>";
				App::import('Controller', 'Alerts');
				$Alerts = new AlertsController;

				$Alerts->constructClasses();
				$alerts = $Alerts->triggeredAlerts();
				$this->set('alerts', $alerts);
				
				
				App::import('Controller', 'Stats');
				$Stats = new StatsController;

				$Stats->constructClasses();
				$graphURL = $Stats->graphTimeline();
				
				$this->set('update_times', $Stats->getUpdateTimes());
				
				$this->set('graphURL', $graphURL);
		}
	}
	
	
	
	private function &getReports($locations) {
		
				App::import('Controller', 'Stats');
				$stat = new StatsController;
				$stat->constructClasses();

				
				//for ($j = 1; $j <= count($locations); $j++)
				//get current date less report threshold
				Configure::load('options');
				$threshold = Configure::read('Map.threshold');
				if ($this->Session->check("displayOption") && $this->Session->read("displayOption") == true) {
					$showAll = true;
				} else {
					$showAll = Configure::read('App.displayMode') == 'all';
				}

				$currDate = date("Y-m-d H:i:s");
				$dateLessMonths = strtotime ('-'.$threshold.' month' , strtotime ($currDate)) ;
				$dateLessMonths = date("Y-m-d H:i:s" , $dateLessMonths);

				$all_stats = $stat->Stat->find("all", array( "recursive" => 1 ));
				$last_stat_by_location = array();
				foreach ($all_stats as $stat)
				{
					if (!$showAll && empty($stat['Approval'])) continue;
					if ( isset( $last_stat_by_location[$stat['Stat']['location_id']] ) )
					{
						if ($last_stat_by_location[$stat['Stat']['location_id']]['Stat']['created'] < $stat['Stat']['created'])
						{
							$last_stat_by_location[$stat['Stat']['location_id']] = $stat;
						}
					} else 
					{
						$last_stat_by_location[$stat['Stat']['location_id']] = $stat;
					}
				}

				$location_data = array();
				foreach ($last_stat_by_location as $location)
				{

					$result_object = array( array(
						'loc' => $location['Stat']['location_id'],
						'st' => array(
							'quantity_after' => $location['Stat']['quantity_after'],
							'item_id'        => $location['Stat']['item_id'],
							'created'        => $location['Stat']['created'],
						),
						'item' => array(
							'dname' => $location['Item']['name']
						)
					) );

					array_push($location_data, $result_object);

				}

				$listitems = array();
				$temp = array();

				foreach ($location_data as $temp)
				{

					$listd= array();

					$i = 0;
					/*while ($row = $result->fetch_assoc()) {
						$listd[$i++]['Listitems'] = $row;
						//print_r($row);
					}*/
					foreach ($temp as $row ){
						if (date($row['st']['created']) > $dateLessMonths)
							$row['st']['threshold'] = 0;
						else 
							$row['st']['threshold'] = 1;
						$listd[$i++]['Listitems'] = $row;
					}
					if (!empty($listd )){
						$listitems[$temp[0]['loc']] = $listd;
					}
					
				}

				return $listitems;
	}
	
}

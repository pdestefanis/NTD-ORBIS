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
	var $helpers = array('Html', 'Form', 'Javascript', 'GoogleMap', 'Crumb', 'UpdateFile', 'Ajax', 'GoogleChart', 'GoogleMapv3');
	

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
				
				$this->set('graphURL', $graphURL);
		}
	}
	
	private function &getReports($locations) {
				$listitems = array();
				$temp = array();
				
				//for ($j = 1; $j <= count($locations); $j++)
				//get current date less report threshold
				Configure::load('options');
				$threshold = Configure::read('Map.threshold');
				$currDate = date("Y-m-d H:i:s");
				$dateLessMonths = strtotime ('-'.$threshold.' month' , strtotime ($currDate)) ;
				$dateLessMonths = date("Y-m-d H:i:s" , $dateLessMonths);
					
				foreach ($locations as $loc)
				{
					//items
					$query = "SELECT quantity_after, item.name as dname, st.item_id, st.created ";
					$query .= "FROM stats st, items item ";
					$query .= "WHERE st.item_id = item.id ";
					$query .= "AND st.id = (select max(sa.id) from stats sa where sa.item_id = st.item_id  ";
					$query .= "AND location_id =" . $loc['locations']['id'] . " ) ";
					$query .= "AND location_id =" . $loc['locations']['id'] . " ";
					$query .= "ORDER by created DESC ";


					//$result = runQuery($query);
					$temp = $this->Stat->query($query);
					//$this->set('listitems',$listitems);

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
						$listitems[$loc['locations']['id']] = $listd;
					}
					
				}
				return $listitems;
	}
	
}
 
    


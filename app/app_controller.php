<?php
/**
 * Application level Controller
 *
 * This file is application-wide controller file. You can put all
 * application-wide controller-related methods here.
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
 * @subpackage    cake.app
 * @since         CakePHP(tm) v 0.2.9
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
/**
 * Application Controller
 *
 * Add your application-wide methods in the class below, your controllers
 * will inherit them.
 *
 * @package       cake
 * @subpackage    cake.app
 */
class AppController extends Controller {
	var $components = array('Acl', 'AuthExt', 'Session', 'RequestHandler', 'Access', 'ControllerList');
	var $helpers = array('Access', 'Html', 'Form');

	function beforeFilter() {

		//$this->AuthExt->allow('*');
		$this->AuthExt->userScope = array('User.active' => 1);
		$this->AuthExt->autoRedirect = false;
		$this->AuthExt->actionPath = 'controllers/';

		//Configure AuthComponent
		$this->AuthExt->authorize = 'actions';
		$this->AuthExt->loginAction = array('controller' => 'users', 'action' => 'login');
		$this->AuthExt->logoutRedirect = array('controller' => 'users', 'action' => 'login');
		$this->AuthExt->loginRedirect = array('controller' => '/', 'action' => '');

		$this->AuthExt->loginError = "Username and password did not match";
		$this->AuthExt->authError = "You are not allowed to perform this action";

		if (strstr($this->params['url']['url'], "approvals/rest"))
		{
			App::import('Controller', 'Users');
			$users = new UsersController;
			$users->constructClasses();
			$pId =$this->params['pId'];
			$user = $users->User->find("list", array(
				"conditions" => array("phone_id" => $pId), 
				"recursive"  => -1, 
				"fields"     => array("User.reach")
			));

			$user = $users->User->find('first', array('conditions' => array('User.phone_id' => $pId)));
			$users->setUserLocation($user);
			Configure::write('authLocations', $this->Session->read("userLocations"));
		} else
		{
			Configure::write('authLocations', $this->Session->read("userLocations"));
		}
		//$this->buildMenus();
		
	
	}
	
	protected function findLocationChildren ($loc, &$children) {
		$class = get_class($this);
		if ($class == 'UsersController') 
			$child = $this->User->Location->find('list', array('callbacks' => 'false', 'conditions' => array( 'parent_id' => $loc, 'deleted = 0')));
		else 
			$child = $this->Location->find('list', array('callbacks' => 'false', 'conditions' => array( 'parent_id' => $loc, 'deleted = 0')));
			
			foreach (array_keys($child) as $c) {
				if ($c == NULL)
					continue;
				$children[] = $c; 
				$this->findLocationChildren($c, $children);	
			}
		//return $children;
	}
	
	protected function findLocationParent ($loc, &$parents, $reach) {
		if ($reach != 0) {	
			$parent = $this->User->Location->find('list', array('callbacks' => 'false', 'fields' => array('Location.id', 'Location.parent_id'), 'conditions' => array( 'Location.id' => $loc, 'Location.deleted = 0')));
			if ( $parent[$loc] == 0) { //exit if top
				$parents[] = $loc;
				return;
			}
			$parents[] = $parent[$loc]; 
			$this->findLocationParent($parent[$loc], $parents, $reach-1);	
		} else {
			$parents[] = $loc; 
		}
	}
	 
	protected function findTopParent ($loc, &$parents, $reach) {	
		if ($reach >= 0) {
			$parent = $this->User->Location->find('list', array('callbacks' => 'false','fields' => array('Location.id', 'Location.parent_id'), 'conditions' => array( 'Location.id' => $loc, 'Location.deleted = 0')));
			if ( $parent[$loc] == 0) { //exit top
				$parents = 0;
				return;
			}
			$parent =  $parent[$loc]; 
			$this->findTopParent($parent, $parents, $reach-1);	
		} else {
			$parents = $loc; 
		}
	}
	 
	protected function findLevel ($loc, &$level) {
			$parent = $this->Location->find('list', array('callbacks' => 'false','fields' => array('Location.id', 'Location.parent_id'), 'conditions' => array( 'Location.id' => $loc)));
			if ( $parent[$loc] == 0) { //exit top
				return;
			} 
			$level += 1;
			$parent =  $parent[$loc]; 
			$this->findLevel($parent, $level);
	}
	 
	protected function findLocationFirstChildren ($loc, &$children) {
		$child = $this->Stat->Location->find('list', array('callbacks' => 'false','conditions' => array( 'parent_id' => $loc, 'deleted = 0')));
			foreach (array_keys($child) as $c) {
				if ($c == NULL)
					continue;
				$children[] = $c; 
			}
		//return $children;
	}
	
	protected function getReport(&$listitems, $strFilter = null) {
		$query = "SELECT quantity_after, items.code as icode, items.name as dname, items.id as did, created, phone_id as pid, stat_items.location_id, stat_items.id as sid, stat_items.created as screated, locations.id as lid, locations.name as lname, locations.parent_id parent ";
		$query .= "FROM stats stat_items, items, locations ";
		$query .= "WHERE stat_items.item_id = items.id ";
		//$query .= "AND stat_items.phone_id = phones.id "; //not needed
		
		$query .= "AND stat_items.location_id = locations.id ";
		$query .= "AND stat_items.id = (select max(sa.id) from stats sa where sa.item_id = stat_items.item_id  ";
		$query .= "AND location_id = stat_items.location_id) ";
		
		if (isset($strFilter) && !is_numeric($strFilter) ) {
			$query .= "AND (locations.name LIKE '%"  . $strFilter . "%' ";
			$query .= "OR items.name LIKE '%"  . $strFilter . "%' ";
			$query .= "OR items.code LIKE '%"  . $strFilter . "%') ";
		}  
		$query .= "AND stat_items.location_id IN ( " . implode(",", $this->Session->read("userLocations")) . ") ";
		$query .= "ORDER by locations.parent_id ";
		
		$listd = $this->Stat->query($query);

		foreach ($listd as $ld){
			$listitems[$ld['locations']['lid']][] = $ld;
			$listitems[$ld['locations']['lid']]['Parent'] = $ld['locations']['parent'];
		}
	}
	
	protected function getGraphTimelineReport() {
		//load configuraion options
		Configure::load('graphs');
		$limit    = Configure::read('Graph.limit');

		if ($this->Session->check("displayOption") && $this->Session->read("displayOption") == true) {
			$showAll = true;
		} else {
			$showAll = Configure::read('App.displayMode') == 'all';
		}
		$listitems = array();
		$query  = "SELECT quantity_after, items.code as code, stat_items.location_id, stat_items.id as sid, stat_items.created ";
		$query .= "FROM stats stat_items, items ";
		$query .= "WHERE stat_items.item_id = items.id ";
		//$query .= "AND stat_items.phone_id = phones.id ";
		//$query .= "AND stat_items.location_id = locations.id ";
		//$query .= "AND stat_items.location_id =" . $locId . " ";
		$query .= "AND stat_items.location_id IN ( " . implode(",", $this->Session->read("userLocations")) . ") ";
		if ($limit != '') {
			$query .= "AND stat_items.created >= (NOW() - INTERVAL " . $limit . " MONTH ) AND stat_items.created <= NOW() ";
		}
		$query .= "ORDER by stat_items.created ASC ";
		
		$listd = $this->Stat->query($query);

		$all_stats = $this->Stat->find("all", array( "recursive" => 1 ));
		$listd = array();
		foreach ($all_stats as $stat)
		{
			if (!$showAll && empty($stat['Approval'])) continue;

			$result_object = array(
				'stat_items' => array(
					'quantity_after' => $stat['Stat']['quantity_after'],
					'location_id'    => $stat['Stat']['location_id'],
					'sid'            => $stat['Stat']['id'],
					'created'        => $stat['Stat']['created'],
				),
				'items' => array(
					'code' => $stat['Item']['code']
				)
			);

			array_push($listd, $result_object);

		}

		foreach ($listd as $ld){
			//$listitems[$ld['stat_items']['location_id']]['values'][$ld['items']['code']][1] = '';
			$ld['stat_items']['code'] = $ld['items']['code'];
			unset($ld['items']);
			$listitems[$ld['stat_items']['location_id']][] = $ld;
			$listitems[$ld['stat_items']['location_id']]['values'][$ld['stat_items']['code']] = array();
			
			
		}
		foreach ($listitems as $key => $li) {
			//put first and last dates into array for location
			//put date diff for total time span
			// for each of these measures put distance from 0
			//$listitems[key(reset($li))]['first'] = reset($li);
			//$listitems[$li['stat_items']['location_id']]['last'] = end($li);
			
			//first last dates plus difference representing the itnerval
			$first = 0;
			$last =0;
			$diff =  0;
			if (count($li) >= 1 && !isset($listitems[$key]['first'])) {
				$first = new DateTime($li[0]['stat_items']['created']);
				$firstOfMonth = new DateTime($first->format('Y-') . $first->format('m'). '-01 ' . $first->format('H:i:s') );
				$last = new DateTime($li[count($li)-2]['stat_items']['created']); //-2 one for count function and one for values array
				$lastOfMonth = new DateTime($last->format('Y-') . $last->format('m-') . $last->format('t ') . $last->format('H:i:s') );
				//echo date_format($last, "Y-m-d H:i:s") . " " . $lastOfMonth . "<br>";
				$listitems[$key]['first'] = $firstOfMonth->format("U");
				$listitems[$key]['last'] = $lastOfMonth->format("U");
				$diff = $lastOfMonth->format("U") - $firstOfMonth->format("U");
				$listitems[$key]['diff'] = $diff;
			}
			
			//distance from point 0 which is first date
			$i = 0;
			$min = 9999999999;
			$max = 0;
			//foreach($li as $k=>$val) {
			for ($j = 0; $j < count($li)-1; $j++){
				//if ($k != 'values') {
					
					
					$curr = new DateTime($li[$j]['stat_items']['created']);
					$distance = $curr->format("U") - $firstOfMonth->format("U");
					$listitems[$key][$j] ['stat_items']['distance'] = $distance;
					//$listitems[$key][$j] ['stat_items']['xAxis'] = round(($distance/$diff)*100);
					$listitems[$key][$j] ['stat_items']['xAxisMonthDay'] =  date_format($curr, 'M%20Y');
					$listitems[$key][$j] ['stat_items']['xAxisYear'] =  date_format($curr, 'Y');
					
					//adjust min and max for y axis
					if ($listitems[$key][$j]['stat_items']['quantity_after'] < $min)
						$min = $listitems[$key][$j]['stat_items']['quantity_after'];
					if ($listitems[$key][$j]['stat_items']['quantity_after'] > $max)
						$max = $listitems[$key][$j]['stat_items']['quantity_after'];
					
					//[1] is for position [0] for data [2] for max
					if (!isset($listitems[$key]['values'][ $listitems[$key][$j]['stat_items']['code']][1]) ) { 
						$listitems[$key]['values'][ $listitems[$key][$j]['stat_items']['code']][1] = $listitems[$key][$j]['stat_items']['quantity_after'] ; 
						$listitems[$key]['values'][ $listitems[$key][$j]['stat_items']['code']][0] = round(($distance/$diff)*100) ; 
						if (!isset($listitems[$key]['scale'])) //get the largest qty so that scaling can be set to it
							$listitems[$key]['scale'] = $listitems[$key][$j]['stat_items']['quantity_after'] ; 
						else {
							if ($listitems[$key]['scale'] < $listitems[$key][$j]['stat_items']['quantity_after'] ) {
								$listitems[$key]['scale'] = $listitems[$key][$j]['stat_items']['quantity_after'] ; 
							}
						}
						if ($listitems[$key][$j]['stat_items']['quantity_after']  < 0) {//set minimum qty for negative values
								$listitems[$key]['scaleMin']  = $listitems[$key][$j]['stat_items']['quantity_after'];
						}
					} else {
						$listitems[$key]['values'][ $listitems[$key][$j]['stat_items']['code']][1] .= "," . $listitems[$key][$j]['stat_items']['quantity_after'] ; 
						$listitems[$key]['values'][ $listitems[$key][$j]['stat_items']['code']][0] .= "," . round(($distance/$diff)*100) ; 
						//set to highest qty for scaling later
						if ($listitems[$key]['scale'] < $listitems[$key][$j]['stat_items']['quantity_after'] )
							$listitems[$key]['scale'] = $listitems[$key][$j]['stat_items']['quantity_after'] ; 
						if ($listitems[$key][$j]['stat_items']['quantity_after']  < 0) {//set minimum qty for negative values
								$listitems[$key]['scaleMin']  = $listitems[$key][$j]['stat_items']['quantity_after'];
						}
					}
					
					
						
					if ($i == 0){	
						
						$listitems[$key]['xAxisMonthDay'] = $listitems[$key][$j] ['stat_items']['xAxisMonthDay'] ; 
						$listitems[$key]['xAxisYear'] = $listitems[$key][$j] ['stat_items']['xAxisYear'] ; 
					} else {
						
						$listitems[$key]['xAxisMonthDay'] .= "|" . $listitems[$key][$j] ['stat_items']['xAxisMonthDay'] ; 
						$listitems[$key]['xAxisYear'] .= "|" . $listitems[$key][$j] ['stat_items']['xAxisYear'] ; 
					}
					
					$i++;
					
				//}
			}
			$r = 1;
			//must be for each values
			
			foreach ($listitems[$key]['values'] as $item){
				if ($r++ == count($listitems[$key]['values'])) {
					if (!isset($listitems[$key]['scaled']))
						$listitems[$key]['scaled'] = "0,100," .(isset($listitems[$key]['scaleMin'])?$listitems[$key]['scale']/(-4):'0' ). "," . $listitems[$key]['scale']; //first & last
					else 	
						$listitems[$key]['scaled'] .= $listitems[$key]['scale'] ; //last
				}else{
					if (!isset($listitems[$key]['scaled']))
						$listitems[$key]['scaled'] = "0,100,"  .(isset($listitems[$key]['scaleMin'])?$listitems[$key]['scale']/(-4):'0' ). "," . $listitems[$key]['scale'] ."," ; //first
					else 	
						$listitems[$key]['scaled'] .= $listitems[$key]['scale'] ."," ; //any
				}	
				
				if (!isset($listitems[$key]['xAxis'])) {
					$listitems[$key]['xAxis'] = $item[0]; 
					$listitems[$key]['xAxis'] .= "|" .$item[1];
					$listitems[$key]['scale'] = "0,100,"  .(isset($listitems[$key]['scaleMin'])?$listitems[$key]['scale']/(-4):'0' ). "," .$listitems[$key]['scale'] ;
				} else {
					$listitems[$key]['xAxis'] .= "|" .$item[0]; 
					$listitems[$key]['xAxis'] .= "|" .$item[1];
				}
			}
			
			
			//legend values
			$listitems[$key]['legent'] = implode ("|", array_keys($listitems[$key]['values']));
			//y axis values
			$listitems[$key]['min'] = 0;
			$listitems[$key]['lowest'] = $min;
			$listitems[$key]['half'] = ($max) /2;
			$listitems[$key]['max'] = $max;
			//colors for data
			$collor = array();
			for ($i = 0; $i < count($listitems[$key]['values']); $i++) {
				$collor[] = $this->get_random_color();
			}
			$listitems[$key]['colors'] = implode (",", $collor);
			
			
		}
		
		return $listitems;
	}
	//random color generation for graph chart
	protected function get_random_color() {
		$c = '';
		for ($i = 0; $i<6; $i++) {
			$c .=  dechex(rand(0,15));
		}
		return "$c";
	} 
	
	protected function buildGraphURL($listitems) {
		$graphURL = array();
		//$locs = Configure::read('authLocations');
		foreach ($listitems as $key => $l) { //for each user location get the statistics'
			$graphURL[$key] = "http://chart.apis.google.com/chart?chs=350x175&cht=lxy&chd=t:";
			$graphURL[$key] .= $l['xAxis'];
			$graphURL[$key] .= "&chco=" . $l['colors'];
			$xAxisMonthDay = explode("|", $l['xAxisMonthDay']); 
			$xAxisMonthDay = array_unique($xAxisMonthDay);//remove dup dates
			$xAxisMonthDay = array_values($xAxisMonthDay); //reindexes the array
			//add missing months in between for axis labels
			$months = array('Jan','Feb','Mar','Apr','May','Jun','Jul','Aug','Sep','Oct','Nov','Dec');
			$firstMonth = substr($xAxisMonthDay[0], 0, 3); //locate first month 
			$firstYear = substr($xAxisMonthDay[0], -4, 4); 
			$lastMonth = substr($xAxisMonthDay[(count($xAxisMonthDay))-1], 0, 3); //locate last month
			$lastYear = substr($xAxisMonthDay[(count($xAxisMonthDay))-1], -4, 4);  
			
			$firstYearMonths = array();
			$lastYearMonths = array();
			if ($firstYear != $lastYear) { //time spans over years
				$firstYearMonths = array_slice($months, array_search($firstMonth,$months), 11, true);
				$lastYearMonths = array_slice($months, 0, ((array_search($lastMonth,$months))+1),true);	
			} else {
				if (count($xAxisMonthDay) == 1){ //only one month in array add the next month as end month
					$firstYearMonths = array_slice($months, array_search($firstMonth,$months), 1, true);
					//$firstYearMonths[] = $months[array_search($firstMonth,$months)+1];
					if ($firstMonth == 'Dec') { //if it is end of year and next month for graph's last period is Jan display jan of the next year
						//$firstYearMonths[] = $months[0];
						$lastYearMonths[] = $months[0];
						$lastYear = $firstYear+1;
					} else
						$firstYearMonths[] = $months[array_search($firstMonth,$months)+1];
				} else {
					$firstYearMonths = array_slice($months, array_search($firstMonth,$months), (array_search($lastMonth,$months) - array_search($firstMonth,$months))+1, true);
					if ($lastMonth == 'Dec') { //if it is end of year and next month for graph's last period is Jan display jan of the next year
						//$firstYearMonths[] = $months[0];
						$lastYearMonths[] = $months[0];
						$lastYear = $lastYear+1;
					} else
						$firstYearMonths[] = $months[array_search($lastMonth,$months)+1];
				}
			}
			
			//add all months from first and last to xAxis labels
			$firstYears = array();
			$lastYears = array();
			foreach ($firstYearMonths as $fm) {
				$firstYears[] = $firstYear;
			}
			foreach ($lastYearMonths as $fm) {
				$lastYears[] = $lastYear;
			}
			
			$xAxisMonthDay = array_merge($firstYearMonths, $lastYearMonths);
			$xAxisYear = array_merge($firstYears, $lastYears);
			
			
			$graphURL[$key] .= "&chxt=x,x,r&chxl=0:|" .  implode("|", $xAxisMonthDay); //axis 0-x,1 -x, 2 -y
			$graphURL[$key] .= "|1:|" . implode("|",$xAxisYear);
			$graphURL[$key] .= "|2:|"  .(isset($listitems[$key]['scaleMin'])?round($l['max']/(-4)). "|":'' )  
						. $l['min']  . "|"  
						. round($l['max']/4)  
						//. "|"  . round($l['max']/3) 
						 . "|"  . round($l['max']/2) 
						  . "|"  . round(3*$l['max']/4)
						  //. "|"  . round(3*$l['max']/4)
						 . "|"  . $l['max']; //. "|"  . $l['lowest']
			$graphURL[$key] .= "&chdlp=b"; //lecgend bottom
			$graphURL[$key] .= "&&chxtc=0,10|2,10"; //tick marks of length 10 for both axis 0 and 1
			$colors = explode(",", $l['colors']); 
			$graphURL[$key] .= "&chm="; //like dot
			$circles = array();
			for ($i = 0; $i < count($colors); $i++) //add line dot for measurement with the same color
				$circles[] = "o,". $colors [$i]. "," . $i .",-1,5"; //line dot on quantity 0 for circle
			$graphURL[$key] .= implode("|", $circles);
			$graphURL[$key] .= "&chxs=0,000000|1,000000|2,000000"; //label color from above layers
			$graphURL[$key] .= "&chdl=" . $l['legent']; 
			$graphURL[$key] .= "&chds=" . $l['scaled'];
			$graphURL[$key] .= "&chg=0," .(isset($listitems[$key]['scaleMin'])?'20':'25' ). "" ; //step size for lines on y axis
			
		}
		//

		return $graphURL;
	}

	protected function sumChildren ($children, &$listitems, $loc) {
		$sum = NULL;

		foreach ($children as $child) {
			
			if (isset($listitems[$child]))
				for ($j = 0; $j < count($listitems[$child])-1; $j++) 
					if ($child == $loc) {
						$sum[$listitems[$child][$j]['items']['did']]['sum'] = 0;
						$sum[$listitems[$child][$j]['items']['did']]['name'] = '';
						$sum[$listitems[$child][$j]['items']['did']]['code'] = $listitems[$child][$j]['items']['icode'];
					} else 
					if (isset($sum[$listitems[$child][$j]['items']['did']])) {
						$sum[$listitems[$child][$j]['items']['did']]['sum'] += $listitems[$child][$j]['stat_items']['quantity_after'];
						$sum[$listitems[$child][$j]['items']['did']]['name'] = $listitems[$child][$j]['items']['dname'];
						$sum[$listitems[$child][$j]['items']['did']]['code'] = $listitems[$child][$j]['items']['icode'];
					} else {
						$sum[$listitems[$child][$j]['items']['did']]['sum'] = $listitems[$child][$j]['stat_items']['quantity_after'];
						$sum[$listitems[$child][$j]['items']['did']]['name'] = $listitems[$child][$j]['items']['dname'];
						$sum[$listitems[$child][$j]['items']['did']]['code'] = $listitems[$child][$j]['items']['icode'];
					}
		}
		return $sum;
	}
	
	protected function processItems($count,  $p, &$locations, &$listitems, &$items, &$report, &$app) {
	
		foreach (array_keys($locations) as $l) {
			if (!isset($listitems[$l]['Parent'])){ //add missing parents to structure so that children with reports are displayed
				$listitems[$l]['Parent'] = key($locations[$l]);
			}
			if ( key($locations[$l]) == $p ) {


				$children = NULL;
				$children[] = $l;
				$app->findLocationChildren ($l, $children);
				$sum = $app->sumChildren($children, $listitems, $l);
				
				if (isset($sum)){
					// foreach (array_keys($items) as $s) {
						foreach (array_keys($sum) as $s) { 
						
							$agg = 0;
							$own = 0;
							
							$report[$l][$s]['lname'] = $locations[$l][$p] ;
							$report[$l][$s]['lid'] = $l ;
							$report[$l][$s]['parent'] =   $listitems[$l]['Parent'] ;
							$report[$l][$s]['level'] =  $count-1 ;
							
							$report[$l][$s]['iname'] =  $items[$s];
							$report[$l][$s]['icode'] =  $sum[$s]['code'];
							$report[$l][$s]['iid'] =  $s;
							
							
							if (isset($sum[$s])) {
								$agg = $sum[$s]['sum'] ;
							} else {
								$agg = 0;
							}
							$report[$l][$s]['aggregated'] =  $agg;
							
							for ($k = 0; $k < count($listitems[$l])-1; $k++) { 
								if ($listitems[$l][$k]['items']['did'] == $s) {
									$own = $listitems[$l][$k]['stat_items']['quantity_after'];
									if (!isset($report[$l][$s]['sid'])) {
										$report[$l][$s]['sid'] = $listitems[$l][$k]['stat_items']['sid'] ;
										$report[$l][$s]['screated'] =  $listitems[$l][$k]['stat_items']['screated'] ;
									}
									if ($report[$l][$s]['sid'] < $listitems[$l][$k]['stat_items']['sid']) {
										$report[$l][$s]['sid'] = $listitems[$l][$k]['stat_items']['sid'] ;
										$report[$l][$s]['screated'] =  $listitems[$l][$k]['stat_items']['screated'] ;
									}
								}
							}
							$report[$l][$s]['own'] = $own;
							
							$report[$l][$s]['total'] =   $own + $agg ;
							
						}
					// }
				}
				
				$this->processItems($count+1,  $l, $locations, $listitems, $items, $report, $app);
				
				
			}
		}
	}

	protected function storeConfig($name, $data = array(), $reload = false) {
		
		
		$content = '';
		if (!empty($data)) {
			foreach ($data as $key => $value) {
				foreach ($value as $subKey => $subValue) {
					$content .= sprintf("\$config['%s']['%s'] = %s;\n", $key, $subKey, $subValue);
				}
			}
		}
	 
		$content = "<?php\n".$content."?>";
	 
		App::import('core', 'File');
		$name = strtolower($name);
		$file = new File(CONFIGS.$name.'.php');
		if ($file->open('w')) {
			$file->append($content);
		}
		$file->close();
	 
		if ($reload) {
			Configure::load($name);
		}
	}

	protected function buildMenus() {
		if (!isset($menus)) {
		//all available menu options
		$menus = array (
					'Main Menu' => array(
								array('label' =>'Inventory by Facility',
										'url' => '/stats/facilityInventory',
										'ACL' => 'Stats/facilityInventory',
										'order' => '0',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								array('label' =>'Aggregated Inventory',
										'url' => '/stats/aggregatedInventory',
										'ACL' => 'Stats/aggregatedInventory',
										'order' => '1',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								array('label' =>'Aggregated Chart',
										'url' => '/stats/aggregatedChart',
										'ACL' => 'Stats/aggregatedChart',
										'order' => '2',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								array('label' =>'Triggered Alerts',
										'url' => '/alerts/triggeredAlerts',
										'ACL' => 'Alerts/triggeredAlerts',
										'order' => '3',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								'label' => 'Main Menu',
								'url' => '/',
								'ACL' => 'Pages/display',
								'tooltip' => '',
								'exclude' => array (0 => 'Locations/index',
													1 => 'Locations/view',
													2 => 'Locations/edit',
													3 => 'Stats/index',
													4 => 'Items/index',
													5 => 'Alerts/index',
													5 => 'Users/index',
													6 => 'Roles/index'),
								'sub' => '',
								'order' => '0',
										),
					'System Management' => array(
								array('label' =>'Facilities',
										'url' => '/locations/index',
										'ACL' => 'Locations/index',
										'order' => '0',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								array('label' =>'Items',
										'url' => '/items/index',
										'ACL' => 'Items/index',
										'order' => '1',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								array('label' =>'Phones',
										'url' => '/phones/index',
										'ACL' => 'Phones/index',
										'order' => '2',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								array('label' =>'Users',
										'url' => '/users/index',
										'ACL' => 'Users/index',
										'order' => '3',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								array('label' =>'Roles',
										'url' => '/roles/index',
										'ACL' => 'Roles/index',
										'order' => '4',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								array('label' =>'Alerts',
										'url' => '/alerts/index',
										'ACL' => 'Alerts/index',
										'order' => '5',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								array('label' =>'Approvals',
										'url' => '/approvals/index',
										'ACL' => 'Approvals/index',
										'order' => '6',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								'label' => 'System Management',
								'url' => '/locations/index',
								'ACL' => 'Locations/index',
								'tooltip' => '',
								'exclude' => array (0 => 'Stats/facilityInventory',
													1 => 'Stats/graphTimeline',
													2 => 'Stats/aggregatedChart',
													3 => 'Stats/aggregatedInventory',
													4 => 'Stats/update_facility_select',
													5 => 'Alerts/triggeredAlerts',
													5 => 'Users/changePass',
													6 => 'Roles/managePermissions',
													6 => 'Stats/options'),
								'sub' => '',
								'order' => '1',
								),
						'Updates and Messages' => array(
								array('label' =>'Updates',
										'url' => '/stats/index',
										'ACL' => 'Stats/index',
										'order' => '0',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								array('label' =>'Raw Messages',
										'url' => '/messagereceiveds/index',
										'ACL' => 'Messagereceiveds/index',
										'order' => '1',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								'label' => 'Updates and Messages',
								'url' => '/stats/index',
								'ACL' => 'Stats/index',
								'tooltip' => '',
								'exclude' => array (0 => 'Stats/facilityInventory',
													1 => 'Stats/graphTimeline',
													2 => 'Stats/aggregatedChart',
													3 => 'Stats/aggregatedInventory',
													3 => 'Stats/options',
													4 => 'Stats/update_facility_select'),
								'sub' => '',
								'order' => '2',
								),
						'Account' => array(
								array('label' =>'Account',
										'url' => '/users/changePass',
										'ACL' => 'Users/changePass',
										'order' => '0',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								'label' => 'Account',
								'url' => '/users/changePass',
								'ACL' => 'Users/changePass',
								'tooltip' => '',
								'exclude' => array (0 => 'Users/index',
													1 => 'Users/view',
													2 => 'Users/edit',
													3 => 'Users/add'),
								'sub' => '',
								'order' => '3',
								),
						'Permissions' => array(
								array('label' =>'Permissions',
										'url' => '/roles/managePermissions',
										'ACL' => 'Roles/managePermissions',
										'order' => '0',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								'label' => 'Permissions',
								'url' => '/roles/managePermissions',
								'ACL' => 'Roles/managePermissions',
								'tooltip' => '',
								'exclude' => array (0 => 'Locations/index',
													1 => 'Locations/view',
													2 => 'Locations/edit',
													3 => 'Stats/index',
													4 => 'Items/index',
													5 => 'Alerts/index',
													5 => 'Users/index',
													6 => 'Phones/index',
													7 => 'Approvals/index',
													8 => 'Roles/index'),
								'sub' => '',
								'order' => '4',
								),
						'Options' => array(
								array('label' =>'Options',
										'url' => '/stats/options',
										'ACL' => 'Stats/options',
										'order' => '0',
										'exclude' => '',
										'sub' => '',
										'tooltip' => ''),
								'label' => 'Options',
								'url' => '/stats/options',
								'ACL' => 'Stats/options',
								'tooltip' => '',
								'exclude' => array (0 => 'Stats/facilityInventory',
													1 => 'Stats/graphTimeline',
													2 => 'Stats/aggregatedChart',
													3 => 'Stats/aggregatedInventory',
													4 => 'Stats/update_facility_select'),
								'sub' => '',
								'order' => '5',
								),
					);
		
		
		//build list of sub pages in parent array
		foreach ($menus as $key => $value) {
			foreach ($value as $k => $v) {
				if (is_numeric($k)) {
					$menus[$key]['sub'][] =  $v['ACL'];
					//$actoins = $this->ControllerList->get(substr($v['ACL'], 0, strpos($v['ACL'], '/')));
					//foreach($actoins[substr($v['ACL'], 0, strpos($v['ACL'], '/'))] as $k => $a)
						//$menus[$key]['sub'][] = substr($v['ACL'], 0, strpos($v['ACL'], '/')) . "/" . $a;
				}
			}
			$menus[$key]['sub'][] = $value['ACL'];
			
			//add all class methods to sub
			
		}	

		$this->set('menus', $menus);

	}	
	}
}
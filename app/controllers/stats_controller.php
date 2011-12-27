<?php
class StatsController extends AppController {

	var $name = 'Stats';
	var $helpers = array('Html', 'Crumb', 'Javascript', 'Ajax', 'UpdateFile', 'GoogleChart' );
	var $components = array('RequestHandler', 'Access');

   function beforeRender() {
		
			if ($this->action == 'view'){
			
					if (!in_array($this->viewVars['stat']['Stat']['location_id'], $this->Session->read("userLocations") )) { //view
						$this->Session->setFlash('You are not allowed to access this record.' . $l, 'flash_failure'); 
						$this->redirect( '/stats/index', null, false);
					} 
			}
			if ($this->action == 'edit'){
					if (!in_array($this->data['Stat']['location_id'], $this->Session->read("userLocations") )) { //edit
						$this->Session->setFlash('You are not allowed to access this record.' . $l, 'flash_failure'); 
						$this->redirect( '/stats/index', null, false);
					} 
			}

   }	
   

	function index() {
		$this->Stat->recursive = 2;
		$this->paginate['Stat'] = array('order' => 'Stat.created DESC');
		$search = (empty($this->data['Search']['search'])?(isset($this->passedArgs[0])?$this->passedArgs[0]:$this->data['Search']['search']):$this->data['Search']['search']);
		if (!empty($search) ) {
				$this->paginate['Stat'] = array('order' => 'Stat.created DESC',
										'conditions'=>array( 
											"OR" => array("Location.name LIKE "=>"%".$search."%", 
													"Item.name LIKE" => "%".$search."%", 
													"Item.code LIKE" => "%".$search."%", 
													"Stat.quantity LIKE" => "%".$search."%",
													"User.name LIKE" => "%".$search."%",
													"Phone.name LIKE" => "%".$search."%")
									));
		} 
		$this->set('stats', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid stat', true));
			$this->redirect(array('action' => 'index'));
		}
		$stat =  $this->Stat->read(null, $id);
		$this->set('stat', $stat);
	}

	function add() {
		if (!empty($this->data)) {
			//TODO put quantity_after into data stat array
			print_r($this->data['Stat']);
			if (isset($this->data['Stat']['location_id']) && isset($this->data['Stat']['item_id']) && isset ($this->data['Stat']['modifier_id'])) {
				$query = 'SELECT quantity_after from stats st ';
				$query .= ' WHERE location_id=' . $this->data['Stat']['location_id'];
				$query .= ' AND item_id='. $this->data['Stat']['item_id'];
				$query .= ' AND item_id='. $this->data['Stat']['item_id'];
				$query .= ' AND id = (select max(id) from stats s  WHERE s.location_id=' . $this->data['Stat']['location_id'] . ' AND s.item_id='. $this->data['Stat']['item_id'] . ')';
				
				$result = $this->Stat->query($query);
				
				if (!isset($result[0]['st']['quantity_after']))
					$result = 0; //first submissoin
				else
					$result = $result[0]['st']['quantity_after'];
				switch ($this->data['Stat']['modifier_id']) {
					case 1: //plus
						$this->data['Stat']['quantity_after'] = $result + $this->data['Stat']['quantity'];
						break;
					case 2: //minus
						$this->data['Stat']['quantity_after'] = $result - $this->data['Stat']['quantity'];
						break;
					case 3: //equal
						$this->data['Stat']['quantity_after'] = $this->data['Stat']['quantity'];
						break;
				};
			} else {
				$this->Session->setFlash(__('The update could not be saved. Please, try again.', true));
			}
			$this->Stat->create();
			if ($this->Stat->save($this->data)) {
				$this->Session->setFlash('The update has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The update could not be saved. Please, try again.', true));
			}
			
		}
		$items = $this->Stat->Item->find('list');
		
		$messagereceived = $this->Stat->Messagereceived->find('all', 
						array('callbacks' => false, 'conditions' => array('Phone.location_id in (' . implode(",", $this->Session->read("userLocations")) . ')')) ); 
		foreach ($messagereceived as $rr) {
			$messagereceiveds[$rr['Messagereceived']['id']] = $rr['Messagereceived']['rawmessage'];
		}
		//$phones = $this->Stat->Phone->find('list',  array ('conditions' => array('Phone.deleted = 0','Phone.location_id is not null'))); 
		$users = $this->Stat->User->find('list', array ('conditions' => array('User.id = '. $this->Session->read('Auth.User.id') )) );
		//$locations = $this->Stat->Location->find('list',  array ('conditions' => array('Location.deleted = 0')));
		$modifiers = $this->Stat->Modifier->find('list'); 
		
		$this->set(compact('items', 'messagereceiveds', 'locations', 'modifiers', 'users'));

	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid update', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
				if ($this->Stat->save($this->data)) {
					$this->Session->setFlash('The update has been saved', 'flash_success');
					$this->redirect(array('action' => 'index'));
				} else {
					$this->Session->setFlash(__('The update could not be saved. Please, try again.', true));
				}
		}
		if (empty($this->data)) {
			$this->data = $this->Stat->read(null, $id);
		}

		$items = $this->Stat->Item->find('list');
		
		$messagereceived = $this->Stat->Messagereceived->find('all', 
						array('callbacks' => false, 'conditions' => 'Phone.location_id in (' . implode(",", $this->Session->read("userLocations")) . ')' ) ); 
		foreach ($messagereceived as $rr) {
			$messagereceiveds[$rr['Messagereceived']['id']] = $rr['Messagereceived']['rawmessage'];
		}
		$phones = $this->Stat->Phone->find('list',  array ('conditions' => array('Phone.deleted = 0','Phone.location_id is not null'))); 
		if (isset($this->data['Stat']['user_id'] ))
			$users = $this->Stat->User->find('list', array ('conditions' => 
						array('User.id IN ('. $this->Session->read('Auth.User.id') . ", " . $this->data['Stat']['user_id'] .  " )" )) );
		else 
			$users = $this->Stat->User->find('list', array ('conditions' => 
						array('User.id ='. $this->Session->read('Auth.User.id') )) );
		//$locations = $this->Stat->Location->find('list');
		$this->set('locations', $this->Stat->Location->find('list', array('conditions' => array('Location.id' => $this->data['Stat']['location_id'] ))));
		$modifiers = $this->Stat->Modifier->find('list');
		
		$this->set(compact('items', 'messagereceiveds', 'users',  'phones', 'modifiers'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for stat', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Stat->delete($id)) {
			$this->Session->setFlash('Report deleted.' . $this->Session->read("modelStat") , 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Report was not deleted', true));
		$this->redirect(array('action' => 'index'));

	}

	function update_facility_select() {

			if (isset($this->data['Stat']['user_id'])) {
				$phone = $this->Stat->User->findById($this->data['Stat']['user_id']);
				$this->set('options', array($phone['User']['location_id']  => $phone['Location']['name']) );

			} else if (isset($this->data['Stat']['phone_id'])) {
				$phone = $this->Stat->Phone->findById($this->data['Stat']['phone_id']);
				$this->set('options', array($phone['Phone']['location_id']  => $phone['Location']['name']) );

			}

			$this->render('update_select');
	}

	
	
	function aggregatedInventory($strFilter = null) {
		//print_r($this->Stat->Location->Alert->find('all'));
		$locations = $this->Stat->Location->find('list',  
						array('fields' => array('Location.parent_id', 'Location.name', 'Location.id'), 
											array('conditions' => array('id IN ' => implode(",", $this->Session->read("userLocations"))))
								)
						);

		$items = $this->Stat->Item->find('list');
		$this->set(compact('locations', 'items'));

		$listitems = array();

		$this->getReport($listitems, $strFilter);
		
		$newlistitems = array();
		foreach (array_keys($locations) as $loca) {
			if ( isset($listitems[$loca][0]['locations']['parent'] ) && $listitems[$loca][0]['locations']['parent'] == 0) {
				$newlistitems[$loca] = $listitems[$loca][0]['locations']['parent'];
			}
		}
		
		$this->set('listitems', $listitems);
		
		$parent = null;
		App::import('Controller', 'Users');
		$app = new UsersController;
		$app->constructClasses();
		$u = $app->AuthExt->user();
		
		$app->findTopParent($u['User']['location_id'], $parent, $u['User']['reach'] );
		$report = NULL;
		$this->processItems(1, $parent, $locations, $listitems, $items, $report, $app);
	
		$this->set('report', $report);
		/* echo "<pre>";
		print_r ($report);
		echo "</pre>";   */
		return $report;

	}
	
	function aggregatedChart($strFilter = null) {
		$allLocations =  $this->Stat->Location->find('list', array('callbacks' =>false, 'conditions' => array('Location.deleted = 0')));
		$this->set('allLocations', $allLocations);
		$report = $this->aggregatedInventory($strFilter);
		return $report;
	}
	
	function facilityInventory($strFilter = null) {
		$allLocations =  $this->Stat->Location->find('list', array('callbacks' =>false, 'conditions' => array('Location.deleted = 0')));
		$this->set('allLocations', $allLocations);
		$this->aggregatedInventory($this->data['Search']['search']);
	}
	
	 function graphTimeline() {
		$locations = $this->Stat->Location->find('list',  array('fields' => array('Location.parent_id', 'Location.name', 'Location.id'), array('conditions' => array('id IN ' => implode(",", $this->Session->read("userLocations"))))));

		$items = $this->Stat->Item->find('list');
		$this->set(compact('locations', 'items'));

		$listitems = array();
		
		// foreach ($locations as $loc)
		// {
		$listitems = $this->getGraphTimelineReport();
		// }
		
		$graphURL = $this->buildGraphURL($listitems);
		$this->set('graphURL', $graphURL);
		
		return $graphURL;
	}
	
	//options action to cater for the last n digits
	function  options() {
		if (!($this->data['Stat']['ndigits'])) {
			Configure::load('options');
			$length = Configure::read('Phone.length');
			$limit = Configure::read('Graph.limit');
			$threshold = Configure::read('Map.threshold');
			$appName = Configure::read('App.name');
			//set the form
			$this->data['Stat']['ndigits'] = $length;
			$this->data['Stat']['ndigitsOld'] = $length;
			$this->data['Stat']['limit'] = $limit;
			$this->data['Stat']['threshold'] = $threshold;
			$this->data['Stat']['appName'] = $appName;

		} else {
			if (($this->data['Stat']['ndigitsOld'] < $this->data['Stat']['ndigits']) 
				|| $this->data['Stat']['ndigits'] == '' || $this->data['Stat']['ndigits'] <=6
				|| !is_numeric($this->data['Stat']['ndigits'])){
				$this->Session->setFlash(__('Last n digits cannot be empty  or less then the previous value.', true));
				$this->Stat->invalidate('ndigits', 'Please enter numeric value > 6 and less than the previous value used: <= '. $this->data['Stat']['ndigitsOld']);
			} else if ($this->data['Stat']['limit'] == ''  || !is_numeric($this->data['Stat']['limit']) 
					|| $this->data['Stat']['limit'] <=0 || $this->data['Stat']['limit'] > 25){
				$this->Session->setFlash(__('Number of months must be numeric', true));
				$this->Stat->invalidate('limit', 'Please enter numeric value between 1 and 24 for number of months');
			} else if ($this->data['Stat']['threshold'] == ''  || !is_numeric($this->data['Stat']['threshold']) 
					|| $this->data['Stat']['threshold'] <=0 || $this->data['Stat']['threshold'] > 25){
				$this->Session->setFlash(__('Report warning must be numeric', true));
				$this->Stat->invalidate('threshold', 'Please enter numeric value between 1 and 24 for number of months');
			} else {
				$options = array(	'Phone' => 	
										array('length' => $this->data['Stat']['ndigits'] ),
									'Graph' =>
										array('limit' => $this->data['Stat']['limit'] ),
										
									'Map' =>
										array('threshold' => $this->data['Stat']['threshold'] ),
									'App' =>
										array('name' => "'". addslashes($this->data['Stat']['appName']) ."'" ),
								);
				$this->storeConfig('options', $options );

				$this->Session->setFlash('Options updated successfully', 'flash_success');
				$this->redirect( '/' );
			}
		}
    }
}
?>
<?php
class AlertsController extends AppController {

	var $name = 'Alerts';
	var $helpers = array('Html', 'Crumb', 'Javascript', 'Ajax');
	//var $components = array('RequestHandler', 'Access');

	function beforeRender() {
			if ($this->action == 'view'){
					if (!in_array($this->viewVars['alert']['Alert']['location_id'], $this->Session->read("userLocations") )) { //view
						$this->Session->setFlash('You are not allowed to access this record.' . $l, 'flash_failure'); 
						$this->redirect( '/alerts/index', null, false);
					} 
			}
			if ($this->action == 'edit'){
					if (!in_array($this->data['Alert']['location_id'], $this->Session->read("userLocations") )) { //edit
						$this->Session->setFlash('You are not allowed to access this record.' . $l, 'flash_failure'); 
						$this->redirect( '/alerts/index', null, false);
					} 
			}
	}	
	
	function beforeFilter () {
		parent::beforeFilter();
		
	}
   
	function index() {
		$this->Alert->recursive = 0;
		$search = (empty($this->data['Search']['search'])?(isset($this->passedArgs[0])?$this->passedArgs[0]:$this->data['Search']['search']):$this->data['Search']['search']);
		if (!empty($search) ) {
				$this->paginate['Alert'] = array('order' => 'Alert.created Desc',
										'conditions'=>array( 
											"OR" => array("User.name LIKE "=>"%".$search."%", 
													"User.username LIKE" => "%".$search."%", 
													"Location.name LIKE" => "%".$search."%", 
													"Item.name LIKE" => "%".$search."%", 
													"Item.code LIKE" => "%".$search."%", 
													)
									));
		} 
		$this->set('alerts', $this->paginate('Alert'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid alert', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('alert', $this->Alert->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Alert->create();
			$this->data['Alert']['user_id'] = $this->Session->read("Auth.User.id") ;
			$this->data["authLocations"] =  $this->Session->read("userLocations") ;
			if ($this->Alert->save($this->data)) {
				$this->Session->setFlash('The alert has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The alert could not be saved. Please, try again.', true));
			}
		}
		$items = $this->Alert->Item->find('list');
		$locations = $this->Alert->Location->find('list', array ('conditions' => array('Location.deleted = 0'))); 
		$this->set(compact('items', 'locations'));
		
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid alert', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Alert->save($this->data)) {
				$this->Session->setFlash('The alert has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The alert could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Alert->read(null, $id);
		}
		$items = $this->Alert->Item->find('list');
		$locations = $this->Alert->Location->find('list', array ('conditions' => array('Location.deleted = 0'))); 
		$this->set(compact('items', 'locations'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for alert', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($id) { 
			$this->Alert->delete($id);
			$this->Session->setFlash('Alert deleted', 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Alert was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function triggeredAlerts() {
		$alerts = $this->Alert->find('all');
		//find current quantitity
		foreach (array_keys($alerts) as $a) {	
			$stat = $this->Alert->Item->Stat->find('all', array('conditions' => array('item_id' => $alerts[$a]['Alert']['item_id'], 'Stat.location_id' => $alerts[$a]['Alert']['location_id'])));
			$tmp[$a] = end($stat);	
			
			if (isset($tmp[$a]['Stat']['id'])) {
				$alerts[$a]['Alert']['qty_after'] = $tmp[$a]['Stat']['quantity_after'] ;
				$alerts[$a]['Alert']['triggered'] = $tmp[$a]['Stat']['created'] ;
				$alerts[$a]['Alert']['sid'] = $tmp[$a]['Stat']['id'] ;
				//we know that at least last update triggers alert
				$this->checkCondition($alerts, $tmp, $a);
				//if (isset($alerts[$a]['Alert']['Alarm']) && $alerts[$a]['Alert']['Alarm'] == 1) { //alert is triggered check previous updates
				$cont = true;
				$tmpPrevOrig[$a] =  $tmp[$a];
				$tmpPrev[$a] = prev($stat);	
				
				if (isset($alerts[$a]['Alert']['Alarm']) && $alerts[$a]['Alert']['Alarm'] == 1) {
		
					while ($cont) {
						
						if (isset($tmpPrev[$a]['Stat']['id'])) {
							$alerts[$a]['Alert']['Alarm'] = NULL;
							$this->checkCondition($alerts, $tmpPrev, $a);
							if ($alerts[$a]['Alert']['Alarm'] == 1) {
								$alerts[$a]['Alert']['triggered'] = $tmpPrev[$a]['Stat']['created'] ;
								$alerts[$a]['Alert']['sid'] = $tmpPrev[$a]['Stat']['id'] ;
								$alerts[$a]['Alert']['qty_after'] = $tmpPrev[$a]['Stat']['quantity_after'] ;
							} else {
								$alerts[$a]['Alert']['Alarm'] = 1;
								$alerts[$a]['Alert']['triggered'] = $tmpPrevOrig[$a]['Stat']['created'] ;
								$alerts[$a]['Alert']['sid'] = $tmpPrevOrig[$a]['Stat']['id'] ;
								$alerts[$a]['Alert']['qty_after'] = $tmpPrevOrig[$a]['Stat']['quantity_after'] ;
								$cont = false;
							}
						} else {
								$cont = false;
						}
						$tmpPrevOrig[$a] =  $tmpPrev[$a];
						$tmpPrev[$a] = prev($stat);		
					}
				}
				
				//}
			}
		}
		
		$this->set(compact('alerts'));
		return $alerts;
	}
	private function checkCondition(&$alerts, &$tmp, &$a) {
		switch ($alerts[$a]['Alert']['conditions']) { //above
			case 1:
				if ($tmp[$a]['Stat']['quantity_after'] > $alerts[$a]['Alert']['threshold']) 
					$alerts[$a]['Alert']['Alarm'] = 1;
				else
					$alerts[$a]['Alert']['Alarm'] = 0;
				break;
			case 2:
				if ($tmp[$a]['Stat']['quantity_after'] < $alerts[$a]['Alert']['threshold']) 
					$alerts[$a]['Alert']['Alarm'] = 1;
				else
					$alerts[$a]['Alert']['Alarm'] = 0;
				break;
			case 3:
				if ($tmp[$a]['Stat']['quantity_after'] == $alerts[$a]['Alert']['threshold']) 
					$alerts[$a]['Alert']['Alarm'] = 1;
				else
					$alerts[$a]['Alert']['Alarm'] = 0;
				break;
			default: 
				$alerts[$a]['Alert']['Alarm'] = 0;
		};
	}

}
?>
<?php
class LocationsController extends AppController {

	var $name = 'Locations';
	var $helpers = array('Html', 'Crumb', 'Javascript', 'Ajax');
	var $components = array('RequestHandler', 'Access');


	function beforeRender() {
			if ($this->action == 'view'){
				
					if (!in_array($this->viewVars['location']['Location']['id'], $this->Session->read("userLocations") )) { //view
						$this->Session->setFlash('You are not allowed to access this record.' . $l, 'flash_failure'); 
						$this->redirect( '/locations/index', null, false);
					} 
			}
			if ($this->action == 'edit'){
					if (!in_array($this->data['Location']['id'], $this->Session->read("userLocations") )) { //edit
						$this->Session->setFlash('You are not allowed to access this record.' . $l, 'flash_failure'); 
						$this->redirect( '/locations/index', null, false);
					} 
			}
	}	
   
	function index() {
		$this->Location->recursive = 0;
		$this->paginate['Location'] = array('order' => 'Location.name ASC');
		
		$search = (empty($this->data['Search']['search'])?(isset($this->passedArgs[0])?$this->passedArgs[0]:$this->data['Search']['search']):$this->data['Search']['search']);
		if (!empty($search) ) {
				$this->paginate['Location'] = array('order' => 'Location.name Asc',
										'conditions'=>array( 
											"OR" => array("Location.name LIKE "=>"%".$search."%", 
													"Location.shortname LIKE" => "%".$search."%", 
													)
									));
		} 
		$this->set('locations', $this->paginate());
		$locs = $this->Location->find('list', array ('callbacks' => false));
		$this->set('parents', $locs);
		foreach (array_keys($locs) as $l) {
			$level =0;
			$this->findLevel($l, $level);
			$locs[$l] = $level;
		}
		$this->set('levels', $locs);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid location', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('location', $this->Location->read(null, $id));
		$roles = $this->Location->User->Role->find('list');
		$this->set('roles', $roles);
	}

	function add() {
		if (!empty($this->data)) {
			$this->Location->create();
			if ($this->Location->save($this->data)) {
				//add location to session
				$newLocations = $this->Session->read("userLocations");
				$newLocations[] = $this->Location->getLastInsertID();
				$this->Session->write("userLocations", $newLocations);
			
				$this->Session->setFlash('The location has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The location could not be saved. Please, try again.', true));
			}
		}
		
		
		$par = $this->Location->Parent->find('list', array('conditions' => array ('deleted' => 0), 'order' => array('name' => 'ASC')));	   
		$parents = array();
		$parents[0] = 'No Parent';
		foreach ($par as $key => $lname)
			$parents[$key] = $lname;
		$this->set('parents', $parents);
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid location', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Location->save($this->data)) {
				$this->Session->setFlash('The location has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The location could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Location->read(null, $id);
			$children = array();
			$this->findLocationChildren ($id, $children);
			if (!empty($children))
				$par= $this->Location->Parent->find('list', array('callbacks' => 'false','conditions' => array ('id not in (' . implode(',', $children) . ')', 'deleted' => 0), 'order' => array('name' => 'ASC')));
			else
				$par= $this->Location->Parent->find('list', array('callbacks' => 'false','conditions' => array ('id not in (' .  $id . ')', 'deleted' => 0), 'order' => array('name' => 'ASC')));
			$parents = array();
			$parents[0] = 'No Parent';
			foreach ($par as $key => $lname)
				$parents[$key] = $lname;
			$this->set('parents', $parents);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for location', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Location->delete($id)) {
			$this->Session->setFlash('Location deleted', 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Location->data['softDel'] == 1) { //soft deletion give success message
			//remove deleted location from session
			$newLocations = array();
			foreach ($this->Session->read("userLocations") as $l) {
				if ($l != $id)
					$newLocations[] = $l;
				
			}
			$this->Session->write("userLocations", $newLocations);
			
			$this->Session->setFlash('Location deleted' , 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		
		$this->Session->setFlash(__('Location was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>
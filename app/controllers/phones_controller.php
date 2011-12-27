<?php
class PhonesController extends AppController {

	var $name = 'Phones';
	var $helpers = array('Html', 'Crumb', 'Javascript', 'Ajax');
	var $components = array('RequestHandler', 'Access');

	function beforeRender() {

			if ($this->action == 'view'){
					if (!in_array($this->viewVars['phone']['Phone']['location_id'], $this->Session->read("userLocations")) && $this->viewVars['phone']['Phone']['location_id'] != "") { //view
						
						$this->Session->setFlash('You are not allowed to access this record.'  , 'flash_failure'); 
						$this->redirect( '/phones/index', null, false);
					} 
			}
			if ($this->action == 'edit'){
					if (!in_array($this->data['Phone']['location_id'], $this->Session->read("userLocations") ) && $this->data['Phone']['location_id'] != "") { //edit
						$this->Session->setFlash('You are not allowed to access this record.' , 'flash_failure'); 
						$this->redirect( '/phones/index', null, false);
					} 
			}
	}	

   
	function index() {
		$this->Phone->recursive = 0;
		$this->paginate['Phone'] = array('order' => 'Phone.name ASC');
		$search = (empty($this->data['Search']['search'])?(isset($this->passedArgs[0])?$this->passedArgs[0]:$this->data['Search']['search']):$this->data['Search']['search']);
		if (!empty($search) ) {
			
				$this->paginate['Phone'] = array('order' => 'Phone.name Asc',
										'conditions'=>array( 
											"OR" => array("Phone.phonenumber LIKE "=>"%".$search."%", 
													"Location.name LIKE" => "%".$search."%", 
													)
									));
		} 
		$this->set('phones', $this->paginate(array( 'Phone.deleted = 0')));
		$stats= array();
		foreach (array_keys($this->Phone->find('list')) as $p) {
			$st = $this->Phone->Stat->find('list', array ('fields' => array('Stat.id', 'Stat.created'), 'conditions' => array('Stat.phone_id = ' . $p)));
			$stats[$p]['created'] = end($st);
			$stats[$p]['sid'] = key($st);
		}
		$this->set('stats', $stats);
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid phone', true));
			$this->redirect(array('action' => 'index'));
		}
		if (empty($this->data['Config']['limit'])) {
			$this->Phone->hasMany['Messagereceived']['limit'] = 20;
			$this->Phone->hasMany['Stat']['limit'] = 20;
			$this->Phone->hasMany['Messagereceived']['order'] = 'created desc';
			$this->Phone->hasMany['Stat']['order'] = 'created desc';
		}else {
			$this->layout = 'ajax';
			$this->Phone->hasMany['Messagereceived']['limit'] = $this->data['Config']['limit'];
			$this->Phone->hasMany['Messagereceived']['order'] = 'created desc';
			$this->Phone->hasMany['Stat']['limit'] = $this->data['Config']['limit'];
			$this->Phone->hasMany['Stat']['order'] = 'created desc';
		}
		$this->set('phone', $this->Phone->read(null, $id));
		$this->set('drug', $this->Phone->Location->Stat->find('list'));
		$this->set('locations', $this->Phone->Location->find('list', array ('conditions' => array('Location.deleted = 0'))));
		$this->set('messagesents', $this->Phone->Messagesent->find('list', array ('fields' => array('messagereceived_id', 'rawmessage'), 'callbacks' => false)));
		$this->set('phones', $this->Phone->find('list', array ('conditions' => array('Phone.deleted = 0'), 'callbacks' => false)));
		$this->set('userLocations', $this->Session->read("userLocations"));
	}

	function add() {
		if (!empty($this->data)) {
			$phoneDeleted = $this->Phone->findByPhonenumber($this->data['Phone']['phonenumber']);
			if (!empty($phoneDeleted)) {
				//phone has been delted reactive
				$this->Session->setFlash('This phone has been deleted prevously. Please confirm to re-activate.', 'flash_success');
				$this->redirect(array('action' => 'edit', $phoneDeleted['Phone']['id'], 1));
			}
			$this->Phone->create();
			if ($this->Phone->save($this->data)) {
				$this->Session->setFlash('The phone has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The phone could not be saved. Please, try again.', 'flash_failure');
			}
		}
		$locations =  $this->Phone->Location->find('list', array ('conditions' => array('Location.deleted = 0'), 'order' => 'Location.name ASC'));
		$this->set(compact('locations'));
	}

	function edit($id = null) {
		
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid phone', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			
			if ($this->Phone->save($this->data)) {
				$this->Session->setFlash('The phone has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The phone could not be saved. Please, try again.', 'flash_failure');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Phone->read(null, $id);
			if (isset($this->passedArgs[1]) && $this->passedArgs[1] == 1)
				$this->data['Phone']['deleted'] = 0;
		}
		
		$locations =  $this->Phone->Location->find('list', array ('conditions' => array('Location.deleted = 0'), 'order' => 'Location.name ASC'));
		$this->set(compact('locations'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for phone', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Phone->delete($id)) { //$this->Phone->delete($id)
			$this->Session->setFlash('Phone deleted' , 'flash_success');
			$this->redirect(array('action'=>'index'));
		} 
		if ($this->Phone->data['softDel'] == 1) { //soft deletion give success message
			$this->Session->setFlash('Phone deleted' , 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Phone was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
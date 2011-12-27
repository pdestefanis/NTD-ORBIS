<?php
class ItemsController extends AppController {

	var $name = 'Items';
	var $helpers = array('Html', 'Crumb', 'Javascript', 'Ajax');
	var $components = array('RequestHandler', 'Access');

	function beforeFilter () {
		parent::beforeFilter();
		$this->Item->Stat->Location->data["authUser"] =  $this->Session->read("Auth.User") ;
		$this->Item->Stat->Location->data["authLocations"] =  $this->Session->read("userLocations") ;
		
   }
   
	function index() {
		$this->Item->recursive = 0;
		$this->paginate['Item'] = array('order' => 'Item.name ASC');
		$search = (empty($this->data['Search']['search'])?(isset($this->passedArgs[0])?$this->passedArgs[0]:$this->data['Search']['search']):$this->data['Search']['search']);
		if (!empty($search) ) {
				$this->paginate['Item'] = array('order' => 'Item.name Asc',
										'conditions'=>array( 
											"OR" => array("Item.name LIKE "=>"%".$search."%", 
													"Item.code LIKE" => "%".$search."%", 
													"Item.units LIKE" => "%".$search."%"
													)
									));
		} 
		$this->set('items', $this->paginate());
		$this->set('modifiers', $this->Item->Modifier->find('list'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid item', true));
			$this->redirect(array('action' => 'index'));
		}
		if (empty($this->data['Config']['limit'])) {
			$this->Item->hasMany['Stat']['limit'] = 20;
			$this->Item->hasMany['Stat']['order'] = 'created desc';
		}else {
			$this->layout = 'ajax';
			$this->Item->hasMany['Stat']['limit'] = $this->data['Config']['limit'];
			$this->Item->hasMany['Stat']['order'] = 'created desc';
		}
		$this->set('item', $this->Item->read(null, $id));
		$this->set('userLocations', $this->Session->read("userLocations"));
		//$this->set('item', $this->Item->find('all', array('conditions' => array('Location.id IN (' . implode(",", $this->Session->read("userLocations")) . ')' , 'Item.id = ' . $id), 'recursive' => 1)));
		$this->set('locations', $this->Item->Stat->Location->find('list', array ('conditions' => array('Location.deleted = 0'))));
		$this->set('phones', $this->Item->Stat->Phone->find('list', array ('conditions' => array('Phone.deleted = 0'), 'callbacks' => false)));
		$this->set('modifiers', $this->Item->Modifier->find('list'));
		$this->set('users', $this->Item->Stat->User->find('list'));
	}

	function add() {
		if (!empty($this->data)) {
			$this->data['Item']['code'] = strtoupper($this->data['Item']['code']);
			$this->Item->create();
			if ($this->Item->save($this->data)) {
				$this->Session->setFlash('The item has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The item could not be saved. Please, try again.','flash_failure');
			}
		}
		$this->set('modifiers', $this->Item->Modifier->find('list'));
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid item', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			$this->data['Item']['code'] = strtoupper($this->data['Item']['code']);
			if ($this->Item->save($this->data)) {
				$this->Session->setFlash('The item has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The item could not be saved. Please, try again.', 'flash_failure');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Item->read(null, $id);
		}
		$this->set('modifiers', $this->Item->Modifier->find('list'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for item', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Item->delete($id)) {
			$this->Session->setFlash('Item deleted', 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Item was not deleted', true));
		$this->redirect(array('action' => 'index'));
		
	}
}
?>
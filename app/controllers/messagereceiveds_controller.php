<?php
class MessagereceivedsController extends AppController {

	var $name = 'Messagereceiveds';
	var $helpers = array('Html', 'Crumb', 'Javascript', 'Ajax');
	var $components = array('RequestHandler', 'Access');

	
	function beforeRender() {
			if ($this->action == 'view'){
				if ($this->viewVars['messagereceived']['Messagereceived']['phone_id'] != -1 && !empty($this->viewVars['messagereceived']['Phone']['location_id'])) {
					if (!in_array($this->viewVars['messagereceived']['Phone']['location_id'], $this->Session->read("userLocations") )) { //view
						$this->Session->setFlash('You are not allowed to access this record.' . $l, 'flash_failure'); 
						$this->redirect( '/messagereceiveds/index', null, false);
					} 
				}
			}
			if ($this->action == 'edit'){
					if ($this->data['Messagereceived']['phone_id'] != -1 && !empty($this->data['Messagereceived']['phone_id'] )) {
						$phone = $this->Messagereceived->Phone->find('list', array('fields' => array('id', 'location_id'), 'conditions' => array('id' => $this->data['Messagereceived']['phone_id'])));
						if (!in_array($phone[$this->data['Messagereceived']['phone_id']], $this->Session->read("userLocations") ) ) { //edit
							$this->Session->setFlash('You are not allowed to access this record.' , 'flash_failure'); 
							$this->redirect( '/stats/index', null, false);
						} 
					}
			}

   }
	
	function index() {
		$this->Messagereceived->recursive = 0;
		$this->paginate['Messagereceived'] = array('order' => 'Messagereceived.created DESC');
		
		$search = (empty($this->data['Search']['search'])?(isset($this->passedArgs[0])?$this->passedArgs[0]:$this->data['Search']['search']):$this->data['Search']['search']);
		if (!empty($search) ) {
				$this->paginate['Messagereceived'] = array('order' => 'Messagereceived.created DESC',
										'conditions'=>array( 
											"OR" => array("Messagereceived.rawmessage LIKE "=>"%".$search."%", 
													"Phone.name LIKE" => "%".$search."%", 
													)
									));
		} 
		$this->set('messagereceiveds', $this->paginate());
		$stats = $this->Messagereceived->Phone->Stat->find('list', array('fields' => array('messagereceived_id', 'id')));
		$this->set(compact('stats'));
		$messagesents = $this->Messagereceived->Messagesent->find('list', array('callbacks' => false, 'fields' => array('messagereceived_id', 'id')));
		$this->set(compact('messagesents'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid messagereceived', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('messagereceived', $this->Messagereceived->read(null, $id));
	}

	private function add() {
		if (!empty($this->data)) {
			$this->Messagereceived->create();
			if ($this->Messagereceived->save($this->data)) {
				$this->Session->setFlash(__('The messagereceived has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The messagereceived could not be saved. Please, try again.', true));
			}
		}
		$phones = $this->Messagereceived->Phone->find('list');
		$this->set(compact('phones'));
	}

	private function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid messagereceived', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Messagereceived->save($this->data)) {
				$this->Session->setFlash(__('The messagereceived has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The messagereceived could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Messagereceived->read(null, $id);
		}
		$phones = $this->Messagereceived->Phone->find('list');
		$this->set(compact('phones'));
	}

	private function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for messagereceived', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Messagereceived->delete($id)) {
			$this->Session->setFlash(__('Messagereceived deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Messagereceived was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
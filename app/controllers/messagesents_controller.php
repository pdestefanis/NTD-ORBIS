<?php
class MessagesentsController extends AppController {

	var $name = 'Messagesents';

	function beforeRender() {
		
			if ($this->action == 'view'){
				if ($this->viewVars['messagesent']['Messagesent']['phone_id'] != -1 && !empty($this->viewVars['messagesent']['Phone']['location_id'])) {
					if (!in_array($this->viewVars['messagesent']['Phone']['location_id'], $this->Session->read("userLocations") )) { //view
						$this->Session->setFlash('You are not allowed to access this record.' . $l, 'flash_failure'); 
						$this->redirect( '/messagereceiveds/index', null, false);
					} 
				}
			}
			if ($this->action == 'edit'){
					if ($this->data['Messagesent']['phone_id'] != -1 && !empty($this->data['Messagesent']['phone_id'] )) {
						$phone = $this->Messagesent->Phone->find('list', array('fields' => array('id', 'location_id'), 'conditions' => array('id' => $this->data['Messagesent']['phone_id'])));
						if (!in_array($phone[$this->data['Messagesent']['phone_id']], $this->Session->read("userLocations") ) ) { //edit
							$this->Session->setFlash('You are not allowed to access this record.' , 'flash_failure'); 
							$this->redirect( '/stats/index', null, false);
						} 
					}
			}

   }
	
	function index() {
		$this->Messagesent->recursive = 0;
		$this->paginate['Messagesent'] = array('order' => 'Messagesent.created DESC');
		$this->set('messagesents', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid messagesent', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('messagesent', $this->Messagesent->read(null, $id));
	}

	private function add() {
		if (!empty($this->data)) {
			$this->Messagesent->create();
			if ($this->Messagesent->save($this->data)) {
				$this->Session->setFlash(__('The messagesent has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The messagesent could not be saved. Please, try again.', true));
			}
		}
		$messagereceiveds = $this->Messagesent->Messagereceived->find('list');
		$phones = $this->Messagesent->Phone->find('list');
		$this->set(compact('messagereceiveds', 'phones'));
	}

	private function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid messagesent', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Messagesent->save($this->data)) {
				$this->Session->setFlash(__('The messagesent has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The messagesent could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Messagesent->read(null, $id);
		}
		$messagereceiveds = $this->Messagesent->Messagereceived->find('list', array('callbacks' => false));
		$phones = $this->Messagesent->Phone->find('list');
		$this->set(compact('messagereceiveds', 'phones'));
	}

	private function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for messagesent', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Messagesent->delete($id)) {
			$this->Session->setFlash(__('Messagesent deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Messagesent was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}

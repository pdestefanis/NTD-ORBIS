<?php
class ApprovalsController extends AppController {

	var $name = 'Approvals';
	var $helpers = array('Html', 'Crumb', 'Javascript', 'Ajax');
	var $components = array('RequestHandler', 'Access');
	
	function index() {
		$this->Approval->recursive = 0;
		$this->paginate['Approval'] = array('order' => 'Approval.created DESC');
		$search = (empty($this->data['Search']['search'])?(isset($this->passedArgs[0])?$this->passedArgs[0]:$this->data['Search']['search']):$this->data['Search']['search']);
		if (!empty($search) ) {
				$this->paginate['Approval'] = array('order' => 'Approval.created ASC',
										'conditions'=>array( 
											"OR" => array("Messagereceived.rawmessage LIKE "=>"%".$search."%", 
													"User.name LIKE" => "%".$search."%", 
													"User.username LIKE" => "%".$search."%", 
													)
									));
		} 
		$this->set('approvals', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid approval', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('approval', $this->Approval->read(null, $id));
		$this->set('locations', $this->Approval->Stat->Location->find('list', array ('conditions' => array('Location.deleted = 0'))));
		$this->set('items', $this->Approval->Stat->Item->find('list'));
	}

	private function add() {
		if (!empty($this->data)) {
			$this->Approval->create();
			if ($this->Approval->save($this->data)) {
				$this->Session->setFlash(__('The approval has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The approval could not be saved. Please, try again.', true));
			}
		}
		$messagereceiveds = $this->Approval->Messagereceived->find('list');
		$users = $this->Approval->User->find('list');
		$stats = $this->Approval->Stat->find('list');
		$this->set(compact('messagereceiveds', 'users', 'stats'));
	}

	private function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid approval', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Approval->save($this->data)) {
				$this->Session->setFlash(__('The approval has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The approval could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Approval->read(null, $id);
		}
		$messagereceiveds = $this->Approval->Messagereceived->find('list');
		$users = $this->Approval->User->find('list');
		$stats = $this->Approval->Stat->find('list');
		$this->set(compact('messagereceiveds', 'users', 'stats'));
	}

	private function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for approval', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Approval->delete($id)) {
			$this->Session->setFlash(__('Approval deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Approval was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
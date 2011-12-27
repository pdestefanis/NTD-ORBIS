<?php
class ModifiersController extends AppController {

	var $name = 'Modifiers';
	var $helpers = array('Html', 'Crumb'); // 'Javascript', 'Ajax');
	//var $components = array('RequestHandler');


	function index() {
		$this->Modifier->recursive = 0;
		$this->set('modifiers', $this->paginate('Modifier'));
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid modifier', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('modifier', $this->Modifier->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Modifier->create();
			if ($this->Modifier->save($this->data)) {
				$this->Session->setFlash('The modifier has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The modifier could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid modifier', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Modifier->save($this->data)) {
				$this->Session->setFlash('The modifier has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The modifier could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Modifier->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for modifier', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($id) { //$this->Modifier->delete($id)
			$this->Session->setFlash('Modifier deleted', 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Modifier was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}

}
?>
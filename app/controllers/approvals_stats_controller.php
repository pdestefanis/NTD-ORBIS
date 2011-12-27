<?php
class ApprovalsStatsController extends AppController {

	var $name = 'ApprovalsStats';

	function index() {
		$this->ApprovalsStat->recursive = 0;
		$this->set('approvalsStats', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid approvals stat', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('approvalsStat', $this->ApprovalsStat->read(null, $id));
	}

	private function add() {
		if (!empty($this->data)) {
			$this->ApprovalsStat->create();
			if ($this->ApprovalsStat->save($this->data)) {
				$this->Session->setFlash(__('The approvals stat has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The approvals stat could not be saved. Please, try again.', true));
			}
		}
		$approvals = $this->ApprovalsStat->Approval->find('list');
		$stats = $this->ApprovalsStat->Stat->find('list');
		$this->set(compact('approvals', 'stats'));
	}

	private function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid approvals stat', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->ApprovalsStat->save($this->data)) {
				$this->Session->setFlash(__('The approvals stat has been saved', true));
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The approvals stat could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->ApprovalsStat->read(null, $id);
		}
		$approvals = $this->ApprovalsStat->Approval->find('list');
		$stats = $this->ApprovalsStat->Stat->find('list');
		$this->set(compact('approvals', 'stats'));
	}

	private function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for approvals stat', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->ApprovalsStat->delete($id)) {
			$this->Session->setFlash(__('Approvals stat deleted', true));
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Approvals stat was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
}
?>
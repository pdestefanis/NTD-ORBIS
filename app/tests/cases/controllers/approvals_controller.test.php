<?php
/* Approvals Test cases generated on: 2011-08-27 16:08:40 : 1314461020*/
App::import('Controller', 'Approvals');

class TestApprovalsController extends ApprovalsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ApprovalsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.approval', 'app.messagereceived', 'app.user', 'app.location', 'app.phone', 'app.rawreport', 'app.stat', 'app.item', 'app.modifier', 'app.alert', 'app.group', 'app.approvals_stat');

	function startTest() {
		$this->Approvals =& new TestApprovalsController();
		$this->Approvals->constructClasses();
	}

	function endTest() {
		unset($this->Approvals);
		ClassRegistry::flush();
	}

	function testIndex() {

	}

	function testView() {

	}

	function testAdd() {

	}

	function testEdit() {

	}

	function testDelete() {

	}

}
?>
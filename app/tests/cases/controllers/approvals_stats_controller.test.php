<?php
/* ApprovalsStats Test cases generated on: 2011-08-27 16:08:01 : 1314461041*/
App::import('Controller', 'ApprovalsStats');

class TestApprovalsStatsController extends ApprovalsStatsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ApprovalsStatsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.approvals_stat', 'app.approval', 'app.messagereceived', 'app.user', 'app.location', 'app.phone', 'app.rawreport', 'app.stat', 'app.item', 'app.modifier', 'app.alert', 'app.group');

	function startTest() {
		$this->ApprovalsStats =& new TestApprovalsStatsController();
		$this->ApprovalsStats->constructClasses();
	}

	function endTest() {
		unset($this->ApprovalsStats);
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
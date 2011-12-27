<?php
/* Rawreports Test cases generated on: 2010-08-30 17:08:18 : 1283179038*/
App::import('Controller', 'Rawreports');

class TestRawreportsController extends RawreportsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class RawreportsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.rawreport', 'app.phone', 'app.location', 'app.stat', 'app.drug', 'app.treatment');

	function startTest() {
		$this->Rawreports =& new TestRawreportsController();
		$this->Rawreports->constructClasses();
	}

	function endTest() {
		unset($this->Rawreports);
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
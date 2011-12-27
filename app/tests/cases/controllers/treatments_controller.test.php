<?php
/* Treatments Test cases generated on: 2010-08-29 22:08:21 : 1283111841*/
App::import('Controller', 'Treatments');

class TestTreatmentsController extends TreatmentsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class TreatmentsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.treatment', 'app.drug', 'app.stat', 'app.rawreport', 'app.phone', 'app.location');

	function startTest() {
		$this->Treatments =& new TestTreatmentsController();
		$this->Treatments->constructClasses();
	}

	function endTest() {
		unset($this->Treatments);
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
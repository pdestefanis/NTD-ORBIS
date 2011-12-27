<?php
/* Phones Test cases generated on: 2010-08-30 17:08:37 : 1283179417*/
App::import('Controller', 'Phones');

class TestPhonesController extends PhonesController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class PhonesControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.phone', 'app.location', 'app.stat', 'app.drug', 'app.treatment', 'app.rawreport');

	function startTest() {
		$this->Phones =& new TestPhonesController();
		$this->Phones->constructClasses();
	}

	function endTest() {
		unset($this->Phones);
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
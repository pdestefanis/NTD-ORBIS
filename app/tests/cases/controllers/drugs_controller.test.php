<?php
/* Drugs Test cases generated on: 2010-08-29 22:08:01 : 1283111821*/
App::import('Controller', 'Drugs');

class TestDrugsController extends DrugsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class DrugsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.drug', 'app.stat', 'app.treatment');

	function startTest() {
		$this->Drugs =& new TestDrugsController();
		$this->Drugs->constructClasses();
	}

	function endTest() {
		unset($this->Drugs);
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
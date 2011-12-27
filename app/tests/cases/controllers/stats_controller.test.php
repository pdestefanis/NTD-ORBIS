<?php
/* Stats Test cases generated on: 2010-08-30 17:08:17 : 1283177657*/
App::import('Controller', 'Stats');

class TestStatsController extends StatsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class StatsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.stat', 'app.drug', 'app.treatment', 'app.rawreport', 'app.phone', 'app.location');

	function startTest() {
		$this->Stats =& new TestStatsController();
		$this->Stats->constructClasses();
	}

	function endTest() {
		unset($this->Stats);
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
<?php
/* Treatment Test cases generated on: 2010-08-29 22:08:21 : 1283111841*/
App::import('Model', 'Treatment');

class TreatmentTestCase extends CakeTestCase {
	var $fixtures = array('app.treatment', 'app.drug', 'app.stat', 'app.rawreport', 'app.phone', 'app.location');

	function startTest() {
		$this->Treatment =& ClassRegistry::init('Treatment');
	}

	function endTest() {
		unset($this->Treatment);
		ClassRegistry::flush();
	}

}
?>
<?php
/* Stat Test cases generated on: 2010-08-29 22:08:17 : 1283111837*/
App::import('Model', 'Stat');

class StatTestCase extends CakeTestCase {
	var $fixtures = array('app.stat', 'app.drug', 'app.treatment', 'app.rawreport', 'app.phone', 'app.location');

	function startTest() {
		$this->Stat =& ClassRegistry::init('Stat');
	}

	function endTest() {
		unset($this->Stat);
		ClassRegistry::flush();
	}

}
?>
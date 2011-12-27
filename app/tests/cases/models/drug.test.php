<?php
/* Drug Test cases generated on: 2010-08-29 22:08:00 : 1283111820*/
App::import('Model', 'Drug');

class DrugTestCase extends CakeTestCase {
	var $fixtures = array('app.drug', 'app.stat', 'app.treatment');

	function startTest() {
		$this->Drug =& ClassRegistry::init('Drug');
	}

	function endTest() {
		unset($this->Drug);
		ClassRegistry::flush();
	}

}
?>
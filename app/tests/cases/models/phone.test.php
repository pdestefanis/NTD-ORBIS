<?php
/* Phone Test cases generated on: 2010-08-29 22:08:08 : 1283111828*/
App::import('Model', 'Phone');

class PhoneTestCase extends CakeTestCase {
	var $fixtures = array('app.phone', 'app.location', 'app.rawreport', 'app.stat');

	function startTest() {
		$this->Phone =& ClassRegistry::init('Phone');
	}

	function endTest() {
		unset($this->Phone);
		ClassRegistry::flush();
	}

}
?>
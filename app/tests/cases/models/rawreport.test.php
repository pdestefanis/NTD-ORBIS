<?php
/* Rawreport Test cases generated on: 2010-08-30 17:08:11 : 1283179271*/
App::import('Model', 'Rawreport');

class RawreportTestCase extends CakeTestCase {
	var $fixtures = array('app.rawreport', 'app.phone', 'app.location', 'app.stat', 'app.drug', 'app.treatment');

	function startTest() {
		$this->Rawreport =& ClassRegistry::init('Rawreport');
	}

	function endTest() {
		unset($this->Rawreport);
		ClassRegistry::flush();
	}

}
?>
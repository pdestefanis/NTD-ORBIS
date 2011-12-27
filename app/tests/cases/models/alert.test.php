<?php
/* Alert Test cases generated on: 2011-08-26 11:08:33 : 1314358773*/
App::import('Model', 'Alert');

class AlertTestCase extends CakeTestCase {
	var $fixtures = array('app.alert', 'app.location', 'app.phone', 'app.rawreport', 'app.stat', 'app.item', 'app.modifier', 'app.user', 'app.group');

	function startTest() {
		$this->Alert =& ClassRegistry::init('Alert');
	}

	function endTest() {
		unset($this->Alert);
		ClassRegistry::flush();
	}

}
?>
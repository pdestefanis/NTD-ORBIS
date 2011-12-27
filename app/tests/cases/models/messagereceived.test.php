<?php
/* Messagereceived Test cases generated on: 2011-08-28 12:08:59 : 1314533219*/
App::import('Model', 'Messagereceived');

class MessagereceivedTestCase extends CakeTestCase {
	var $fixtures = array('app.messagereceived', 'app.phone', 'app.location', 'app.stat', 'app.item', 'app.modifier', 'app.alert', 'app.user', 'app.group', 'app.rawreport', 'app.approval', 'app.approvals_stat', 'app.messagesent');

	function startTest() {
		$this->Messagereceived =& ClassRegistry::init('Messagereceived');
	}

	function endTest() {
		unset($this->Messagereceived);
		ClassRegistry::flush();
	}

}
?>
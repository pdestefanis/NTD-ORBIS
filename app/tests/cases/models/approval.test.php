<?php
/* Approval Test cases generated on: 2011-08-27 16:08:39 : 1314461019*/
App::import('Model', 'Approval');

class ApprovalTestCase extends CakeTestCase {
	var $fixtures = array('app.approval', 'app.messagereceived', 'app.user', 'app.location', 'app.phone', 'app.rawreport', 'app.stat', 'app.item', 'app.modifier', 'app.alert', 'app.group', 'app.approvals_stat');

	function startTest() {
		$this->Approval =& ClassRegistry::init('Approval');
	}

	function endTest() {
		unset($this->Approval);
		ClassRegistry::flush();
	}

}
?>
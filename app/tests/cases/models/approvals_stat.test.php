<?php
/* ApprovalsStat Test cases generated on: 2011-08-27 16:08:59 : 1314461039*/
App::import('Model', 'ApprovalsStat');

class ApprovalsStatTestCase extends CakeTestCase {
	var $fixtures = array('app.approvals_stat', 'app.approval', 'app.messagereceived', 'app.user', 'app.location', 'app.phone', 'app.rawreport', 'app.stat', 'app.item', 'app.modifier', 'app.alert', 'app.group');

	function startTest() {
		$this->ApprovalsStat =& ClassRegistry::init('ApprovalsStat');
	}

	function endTest() {
		unset($this->ApprovalsStat);
		ClassRegistry::flush();
	}

}
?>
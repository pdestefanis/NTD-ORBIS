<?php
/* Messagereceiveds Test cases generated on: 2011-08-28 12:08:04 : 1314533224*/
App::import('Controller', 'Messagereceiveds');

class TestMessagereceivedsController extends MessagereceivedsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class MessagereceivedsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.messagereceived', 'app.phone', 'app.location', 'app.stat', 'app.item', 'app.modifier', 'app.alert', 'app.user', 'app.group', 'app.rawreport', 'app.approval', 'app.approvals_stat', 'app.messagesent');

	function startTest() {
		$this->Messagereceiveds =& new TestMessagereceivedsController();
		$this->Messagereceiveds->constructClasses();
	}

	function endTest() {
		unset($this->Messagereceiveds);
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
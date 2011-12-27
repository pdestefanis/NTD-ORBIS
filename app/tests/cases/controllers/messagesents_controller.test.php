<?php
/* Messagesents Test cases generated on: 2011-09-01 12:15:05 : 1314879305*/
App::import('Controller', 'Messagesents');

class TestMessagesentsController extends MessagesentsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class MessagesentsControllerTestCase extends CakeTestCase {
	var $fixtures = array('app.messagesent', 'app.messagereceived', 'app.phone', 'app.location', 'app.stat', 'app.item', 'app.modifier', 'app.alert', 'app.user', 'app.role', 'app.user_role', 'app.approval', 'app.approvals_stat');

	function startTest() {
		$this->Messagesents =& new TestMessagesentsController();
		$this->Messagesents->constructClasses();
	}

	function endTest() {
		unset($this->Messagesents);
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

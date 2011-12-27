<?php
/* Messagesent Test cases generated on: 2011-09-01 12:12:13 : 1314879133*/
App::import('Model', 'Messagesent');

class MessagesentTestCase extends CakeTestCase {
	function startTest() {
		$this->Messagesent =& ClassRegistry::init('Messagesent');
	}

	function endTest() {
		unset($this->Messagesent);
		ClassRegistry::flush();
	}

}

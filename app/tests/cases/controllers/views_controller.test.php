<?php
/* Views Test cases generated on: 2010-10-06 10:10:10 : 1286351890*/
App::import('Controller', 'Views');

class TestViewsController extends ViewsController {
	var $autoRender = false;

	function redirect($url, $status = null, $exit = true) {
		$this->redirectUrl = $url;
	}
}

class ViewsControllerTestCase extends CakeTestCase {
	function startTest() {
		$this->Views =& new TestViewsController();
		$this->Views->constructClasses();
	}

	function endTest() {
		unset($this->Views);
		ClassRegistry::flush();
	}

}
?>
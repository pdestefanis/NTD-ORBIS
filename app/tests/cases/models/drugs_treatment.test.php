<?php
/* DrugsTreatment Test cases generated on: 2010-10-06 12:10:20 : 1286356100*/
App::import('Model', 'DrugsTreatment');

class DrugsTreatmentTestCase extends CakeTestCase {
	function startTest() {
		$this->DrugsTreatment =& ClassRegistry::init('DrugsTreatment');
	}

	function endTest() {
		unset($this->DrugsTreatment);
		ClassRegistry::flush();
	}

}
?>
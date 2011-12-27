<?php
/* DrugsTreatment Fixture generated on: 2010-10-06 12:10:20 : 1286356100 */
class DrugsTreatmentFixture extends CakeTestFixture {
	var $name = 'DrugsTreatment';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'drug_id' => array('type' => 'integer', 'null' => false),
		'treatment_id' => array('type' => 'integer', 'null' => false),
		'quantity' => array('type' => 'integer', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'drug_id' => 1,
			'treatment_id' => 1,
			'quantity' => 1
		),
	);
}
?>
<?php
/* Treatment Fixture generated on: 2010-08-29 22:08:21 : 1283111841 */
class TreatmentFixture extends CakeTestFixture {
	var $name = 'Treatment';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'code' => array('type' => 'string', 'null' => false, 'length' => 4, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'drug_id' => array('type' => 'integer', 'null' => false),
		'units' => array('type' => 'integer', 'null' => false, 'length' => 2),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'code' => 'Lo',
			'drug_id' => 1,
			'units' => 1
		),
	);
}
?>
<?php
/* Stat Fixture generated on: 2010-08-29 22:08:17 : 1283111837 */
class StatFixture extends CakeTestFixture {
	var $name = 'Stat';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'report_type' => array('type' => 'string', 'null' => false, 'length' => 2, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'quantity' => array('type' => 'integer', 'null' => false, 'length' => 5),
		'created' => array('type' => 'datetime', 'null' => false),
		'drug_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'treatment_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'rawreport_id' => array('type' => 'integer', 'null' => false),
		'phone_id' => array('type' => 'integer', 'null' => false),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'report_type' => '',
			'quantity' => 1,
			'created' => '2010-08-29 22:57:17',
			'drug_id' => 1,
			'treatment_id' => 1,
			'rawreport_id' => 1,
			'phone_id' => 1
		),
	);
}
?>
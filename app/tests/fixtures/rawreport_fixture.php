<?php
/* Rawreport Fixture generated on: 2010-08-30 17:08:08 : 1283179268 */
class RawreportFixture extends CakeTestFixture {
	var $name = 'Rawreport';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'raw_message' => array('type' => 'string', 'null' => false, 'length' => 160, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'message_code' => array('type' => 'string', 'null' => false, 'length' => 90, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'created' => array('type' => 'datetime', 'null' => false),
		'phone_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'raw_message' => 'Lorem ipsum dolor sit amet',
			'message_code' => 'Lorem ipsum dolor sit amet',
			'created' => '2010-08-30 17:41:08',
			'phone_id' => 1
		),
	);
}
?>
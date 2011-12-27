<?php
/* Phone Fixture generated on: 2010-08-29 22:08:08 : 1283111828 */
class PhoneFixture extends CakeTestFixture {
	var $name = 'Phone';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'phonenumber' => array('type' => 'integer', 'null' => false),
		'active' => array('type' => 'integer', 'null' => false, 'length' => 1),
		'location_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'phonenumber' => 1,
			'active' => 1,
			'location_id' => 1
		),
	);
}
?>
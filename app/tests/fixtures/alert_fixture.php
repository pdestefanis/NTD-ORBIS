<?php
/* Alert Fixture generated on: 2011-08-26 11:08:32 : 1314358772 */
class AlertFixture extends CakeTestFixture {
	var $name = 'Alert';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'location_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'item_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'threshold' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'location_id' => 1,
			'item_id' => 1,
			'threshold' => 1,
			'user_id' => 1,
			'created' => '2011-08-26 11:39:32'
		),
	);
}
?>
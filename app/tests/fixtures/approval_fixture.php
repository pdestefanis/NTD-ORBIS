<?php
/* Approval Fixture generated on: 2011-08-27 16:08:39 : 1314461019 */
class ApprovalFixture extends CakeTestFixture {
	var $name = 'Approval';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'messagereceived_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'user_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'messagereceived_id' => 1,
			'user_id' => 1
		),
	);
}
?>
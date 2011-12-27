<?php
/* ApprovalsStat Fixture generated on: 2011-08-27 16:08:59 : 1314461039 */
class ApprovalsStatFixture extends CakeTestFixture {
	var $name = 'ApprovalsStat';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'approval_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'stat_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'approval_id' => 1,
			'stat_id' => 1
		),
	);
}
?>
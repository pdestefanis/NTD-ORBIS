<?php
/* Messagereceived Fixture generated on: 2011-08-28 12:08:58 : 1314533218 */
class MessagereceivedFixture extends CakeTestFixture {
	var $name = 'Messagereceived';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'phone_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'rawmessage' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 160, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'phone_id' => 1,
			'created' => '2011-08-28 12:06:58',
			'rawmessage' => 'Lorem ipsum dolor sit amet'
		),
	);
}
?>
<?php
/* Messagesent Fixture generated on: 2011-09-01 12:12:13 : 1314879133 */
class MessagesentFixture extends CakeTestFixture {
	var $name = 'Messagesent';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'messagereceived_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'phone_id' => array('type' => 'integer', 'null' => true, 'default' => NULL),
		'created' => array('type' => 'datetime', 'null' => true, 'default' => NULL),
		'rawmessage' => array('type' => 'string', 'null' => true, 'default' => NULL, 'length' => 160, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'messagereceived_id' => 1,
			'phone_id' => 1,
			'created' => '2011-09-01 12:12:13',
			'rawmessage' => 'Lorem ipsum dolor sit amet'
		),
	);
}

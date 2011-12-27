<?php
/* Location Fixture generated on: 2010-08-29 22:08:04 : 1283111824 */
class LocationFixture extends CakeTestFixture {
	var $name = 'Location';

	var $fields = array(
		'id' => array('type' => 'integer', 'null' => false, 'default' => NULL, 'key' => 'primary'),
		'name' => array('type' => 'string', 'null' => false, 'length' => 70, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'shortname' => array('type' => 'string', 'null' => false, 'length' => 4, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'locationLatitude' => array('type' => 'string', 'null' => false, 'length' => 13, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'locationLongitude' => array('type' => 'string', 'null' => false, 'length' => 13, 'collate' => 'latin1_swedish_ci', 'charset' => 'latin1'),
		'indexes' => array('PRIMARY' => array('column' => 'id', 'unique' => 1)),
		'tableParameters' => array('charset' => 'latin1', 'collate' => 'latin1_swedish_ci', 'engine' => 'InnoDB')
	);

	var $records = array(
		array(
			'id' => 1,
			'name' => 'Lorem ipsum dolor sit amet',
			'shortname' => 'Lo',
			'locationLatitude' => 'Lorem ipsum',
			'locationLongitude' => 'Lorem ipsum'
		),
	);
}
?>
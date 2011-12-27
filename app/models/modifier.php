<?php
class Modifier extends AppModel {
	var $name = 'Modifier';
	var $displayField = 'name';

	   var $belongsTo = array(
			'Item' => array(
				'className' => 'Item',
				'foreignKey' => 'id',
				'conditions' => '',
			), 
			'Stat' => array(
				'className' => 'Stat',
				'foreignKey' => 'id',
				'conditions' => '',
			)
	   );
}
?>
<?php
class Item extends AppModel {
	var $name = 'Item';
	var $order = "Item.name ASC";
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Name is required',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'code' => array(
			'notempty' => array(
				'rule' => array('between', 3, 10),
				'message' => 'Item must be between 3 and 10 letters',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				'rule' =>  'isUnique',
				'message' => 'This item code has already been added.'
			),
			'rule' =>  'isUnique',
			'message' => 'This item has already been added.'
		),
		'units' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter the units for this item',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
			'Stat' => array(
				'className' => 'Stat',
				'foreignKey' => 'item_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			),
			'Alert' => array(
				'className' => 'Alert',
				'foreignKey' => 'item_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			)
			
	);
	var $belongsTo = array(
			'Modifier' => array(
				'className' => 'Modifier',
				'foreignKey' => 'modifier_id',
				'dependent' => false,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'exclusive' => '',
				'finderQuery' => '',
				'counterQuery' => ''
			)	
	);

}
?>
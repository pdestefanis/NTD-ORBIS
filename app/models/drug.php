<?php
class Drug extends AppModel {
	var $name = 'Drug';
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
				'rule' => array('between', 3, 3),
				'message' => 'Drug must be 3 letters',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
				'rule' =>  'isUnique',
				'message' => 'This drug code has already been added.'
			),
			'rule' =>  'isUnique',
			'message' => 'This drug has already been added.'
		),
		'presentation' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter the presentation for this drug',
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
				'foreignKey' => 'drug_id',
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
			//,
			//'Treatment' => array(
			//	'className' => 'Treatment',
			//	'foreignKey' => 'drug_id',
			//	'dependent' => false,
			//	'conditions' => '',
			//	'fields' => '',
			//	'order' => '',
			//	'limit' => '',
			//	'offset' => '',
			//	'exclusive' => '',
			//	'finderQuery' => '',
			//	'counterQuery' => ''
			//)
		);


		var $hasAndBelongsToMany = array(
			'Treatment' => array(
				'className' => 'Treatment',
				'joinTable' => 'drugs_treatments',
				'foreignKey' => 'drug_id',
				'associationForeignKey' => 'treatment_id',
				'unique' => true,
				'conditions' => '',
				'fields' => '',
				'order' => '',
				'limit' => '',
				'offset' => '',
				'finderQuery' => '',
				'deleteQuery' => '',
				'insertQuery' => ''
			)
	);


}
?>
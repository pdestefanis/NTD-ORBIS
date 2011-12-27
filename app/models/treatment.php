<?php
class Treatment extends AppModel {
	var $name = 'Treatment';
	var $displayField = 'code';

	// function beforeValidate() {
	  // if (!isset($this->data['Drug']['Drug'])
	  // || empty($this->data['Drug']['Drug'])) {
	    // $this->invalidate('non_existent_field'); // fake validation error on Project
	    // $this->Drug->invalidate('Drug', 'Please select at least one drug');
	  // }
	  // return true;
	// }



	var $validate = array(
		'code' => array(
			'notempty' => array(
				'rule' => array('between', 4, 4),
				'message' => 'Code must be 4 letters',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'rule' =>  'isUnique',
			'message' => 'This treatment has already been added.'
		),
		//'drug_id' => array(
		//	'notempty' => array(
			//	'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
		//	),
		//),
		//'units' => array(
		//	'numeric' => array(
		//		'rule' => array('numeric'),
		//		'message' => 'Please enter an integer value',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
		//	),
		//),



	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

		//var $belongsTo = array(
		//	'Drug' => array(
		//		'className' => 'Drug',
		//		'foreignKey' => 'drug_id',
		//		'conditions' => '',
		//		'fields' => '',
		//		'order' => ''
		//	)
		//);

		var $hasMany = array(
			'Stat' => array(
				'className' => 'Stat',
				'foreignKey' => 'treatment_id',
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


		var $hasAndBelongsToMany = array(
			'Drug' => array(
				'className' => 'Drug',
				'joinTable' => 'drugs_treatments',
				'foreignKey' => 'treatment_id',
				'associationForeignKey' => 'drug_id',
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
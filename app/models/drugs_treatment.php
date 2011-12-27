<?php
class DrugsTreatment extends AppModel {
	var $name = 'DrugsTreatment';
	var $displayField = 'quantity';
	
	function beforeValidate() {
	  if (!isset($this->data['DrugsTreatment']['quantity'])
	  || empty($this->data['DrugsTreatment']['quantity'])) {
	    $this->invalidate('non_existent_field'); // fake validation error on Project
	    $this->DrugsTreatment->invalidate('quantity', 'Please enter quantity');
	  }
	  return true;
	}
	
	
	var $validate = array(
		'quantity' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please eneter quantity',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Drug' => array(
			'className' => 'Drug',
			'foreignKey' => 'drug_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Treatment' => array(
			'className' => 'Treatment',
			'foreignKey' => 'treatment_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
}
?>
<?php
class DrugsTreatment extends AppModel {
	var $name = 'DrugsTreatment';
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $displayField = 'quantity';

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
<?php
class Location extends AppModel {
	var $name = 'Location';
	var $order = "Location.name ASC";
	var $validate = array(
		'name' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter location name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'shortname' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter location short name',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'locationLatitude' => array(
			'notempty' => array(
				'rule' => '/^-?([1-8]?[0-9]\.{1}\d{1,6}$|90\.{1}0{1,6}$)/',
				'message' => 'Please enter a number between +-90 degrees and up to 6 decimal points.',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'locationLongitude' => array(
			'notempty' => array(
				'rule' => '/^-?([1]?[1-7][1-9]|[1]?[1-8][0]|[1-9]?[0-9])\.{1}\d{1,6}/',
				'message' => 'Please enter a number between +-180 degrees and up to 6 decimal points',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $hasMany = array(
		'Phone' => array(
			'className' => 'Phone',
			'foreignKey' => 'location_id',
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
		'Stat' => array(
			'className' => 'Stat',
			'foreignKey' => 'location_id',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'location_id',
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
			'foreignKey' => 'location_id',
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
	);
	
	var $belongsTo  = array(
		'Parent' =>
			array(
				'className' => 'Location',
				'foreignKey' => 'parent_id',
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
	function beforeFind($queryData) {
		if (get_class($this) === 'Location' ) {
			if (!empty($queryData)){
				if (!isset($queryData['conditions']['Location.id'])) { //check if viewing item
					if (isset($queryData['fields'][0]) && $queryData['fields'][0] == 'Parent.id') {
						$queryData['conditions'][] = array ('OR' => array ('Parent.id IN (' . implode(",", Configure::read('authLocations')) . ')'));
					} else {
						$queryData['conditions'][] = array ('OR' => array ('Location.id IN (' . implode(",", Configure::read('authLocations')) . ')'));
					}
						
				}
			}
		}
		return $queryData;
	}

	function beforeDelete() {
		if (get_class($this) == 'Location') {
			$stat = $this->findById($this->id);
			$loc = $stat[get_class($this)]['id'];
				if (!in_array($loc, Configure::read('authLocations') )) {
					
					return false;
				}
		}
		//sof delete here
		$this->query('UPDATE locations set deleted = 1 WHERE id = ' . $this->id);
		$this->data['softDel'] = 1;
		return false;
	}
	
}
?>
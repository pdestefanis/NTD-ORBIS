<?php
class Alert extends AppModel {
	var $name = 'Alert';
	var $order = "Alert.created DESC";
	var $validate = array(
		'location_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select location',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'conditions' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select a condition',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),

		'item_id'=>array( 
			'unique'=>array( 
				'rule' => array('checkUnique', array('item_id', 'location_id')), 
				'message' => 'There is already an alert for this item and location.', 
			),
		), 
/* 		'item_id' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please select item',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		), */
		'threshold' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				'message' => 'Please enter threshold number',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
	);
	
	var $belongsTo = array(
		'Item' => array(
			'className' => 'Item',
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
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
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
		'Location' => array(
			'className' => 'Location',
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
		)
	);
	
	function checkUnique($data, $fields) {
	
		if (!is_array($fields)) {
			$fields = array($fields);
		}
		foreach($fields as $key) {
			$tmp[$key] = $this->data[$this->name][$key];
		}

		if (isset($this->data[$this->name][$this->primaryKey])) {
			$tmp[$this->primaryKey] = '<>'.$this->data[$this->name][$this->primaryKey];
		}

		return $this->isUnique($tmp, false);
	} 
	
	function beforeFind($queryData) {
		if (get_class($this) === 'Alert' ) {
			if (!empty($queryData))
			{
				//if ($sess->read("Auth.User.group_id") != 8){ // check if admin user
					if (!isset($queryData['conditions'][get_class($this) . '.id'])) { //check if viewing item
						$queryData['conditions'][] = array ('OR' => array (get_class($this) .'.location_id IN (' . implode(",", Configure::read('authLocations')) . ')', get_class($this) . '.location_id is null'));
					}
				//}
			}
		}
		return $queryData;
	}

	function beforeDelete(){
		if (get_class($this) == 'Alert') {
			$stat = $this->findById($this->id);
			$loc = $stat[get_class($this)]['location_id'];
			//if ($sess->read("Auth.User.group_id") != 8){ // check if admin user
				if (!in_array($loc, Configure::read('authLocations') ))
					return false;
			//}
		}
		return true;
	}
	
	
}
?>
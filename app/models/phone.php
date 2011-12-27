<?php
class Phone extends AppModel {
	var $name = 'Phone';
	var $order = "Phone.name ASC";
	var $displayField = 'name';
	
	var $validate = array(
		'phonenumber' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter phone number',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			'rule' =>  'isUnique',
			'message' => 'This phone has already been added.'
		),
		'active' => array(
			'numeric' => array(
				'rule' => array('numeric'),
				//'message' => 'Your custom message here',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
		),
		'name' => array(
				'notempty' => array(
					'rule' => array('notempty'),
					'message' => 'Please enter name',
					//'allowEmpty' => false,
					//'required' => false,
					//'last' => false, // Stop validation after this rule
					//'on' => 'create', // Limit validation to 'create' or 'update' operations
				),
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Messagereceived' => array(
			'className' => 'Messagereceived',
			'foreignKey' => 'phone_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '5',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Messagesent' => array(
			'className' => 'Messagesent',
			'foreignKey' => 'phone_id',
			'dependent' => false,
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'limit' => '5',
			'offset' => '',
			'exclusive' => '',
			'finderQuery' => '',
			'counterQuery' => ''
		),
		'Stat' => array(
			'className' => 'Stat',
			'foreignKey' => 'phone_id',
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
			'foreignKey' => 'phone_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function beforeFind($queryData) {
		if (get_class($this) === 'Phone' ) {
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

	function beforeDelete() {
		if (get_class($this) == 'Phone') {
			$stat = $this->findById($this->id);
			$loc = $stat[get_class($this)]['location_id'];
				if (!in_array($loc, Configure::read('authLocations') )) {
					
					return false;
				}
		}
		//sof delete here
		$this->query('UPDATE phones set deleted = 1 WHERE id = ' . $this->id);
		$this->data['softDel'] = 1;
		return false;
	}

}
?>
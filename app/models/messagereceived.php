<?php
class Messagereceived extends AppModel {
	var $name = 'Messagereceived';
	var $order = "Messagereceived.created DESC";
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Phone' => array(
			'className' => 'Phone',
			'foreignKey' => 'phone_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasMany = array(
		'Approval' => array(
			'className' => 'Approval',
			'foreignKey' => 'messagereceived_id',
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
		'Messagesent' => array(
			'className' => 'Messagesent',
			'foreignKey' => 'messagereceived_id',
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
		if (get_class($this) === 'Messagereceived' ) { 
			if (!empty($queryData))
			{
				//if ($sess->read("Auth.User.group_id") != 8){ // check if admin user
					if (!isset($queryData['conditions']['Messagereceived.id'])) { //check if viewing item
						//$queryData['conditions'][] = array ('Phone.location_id IN (' . implode(",", Configure::read('authLocations')). ')');
						$queryData['conditions'][] = array ('OR' => array ('Phone.location_id IN (' . implode(",", Configure::read('authLocations')). ')',  'phone_id = -1', 'phone_id is null'));
						//$queryData['conditions'][] = array ('Phone.id != -1');
					}
				//}
			}
		}
		return $queryData;
	} 
	function beforeDelete(){
		if ( get_class($this) == 'Messagereceived') {
			$stat = $this->findById($this->id);
			$loc = $stat['Phone']['location_id'];
			//if ($sess->read("Auth.User.group_id") != 8){ // check if admin user
				if (!in_array($loc, Configure::read('authLocations') ))
					return false;
			//}
		}
		return true;
	}

}
?>
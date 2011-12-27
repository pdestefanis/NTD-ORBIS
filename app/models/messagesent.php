<?php
class Messagesent extends AppModel {
	var $name = 'Messagesent';
	var $order = "Messagesent.created DESC";
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Messagereceived' => array(
			'className' => 'Messagereceived',
			'foreignKey' => 'messagereceived_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'Phone' => array(
			'className' => 'Phone',
			'foreignKey' => 'phone_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);
	
	function beforeFind($queryData) {
		if (get_class($this) === 'Messagesent' ) {
			if (!empty($queryData))
			{
				
				//if ($sess->read("Auth.User.group_id") != 8){ // check if admin user
					if (!isset($queryData['conditions'][get_class($this) . '.id'])) { //check if viewing item
						$queryData['conditions'][] = array ('Phone.location_id IN (' . implode(", ", Configure::read('authLocations')) . ')');
						print_r($queryData);
					}
				//}
			}
		}
		return $queryData;
	}

	function beforeDelete(){
		if (get_class($this) == 'Messagesent') {
			$stat = $this->findById($this->id);
			$loc = $stat['Phone']['location_id'];
			//if ($sess->read("Auth.User.group_id") != 8){ // check if admin user
				if (!in_array($loc, Configure::read('authLocations')))
					return false;
			//}
		}
		return true;
	}
}

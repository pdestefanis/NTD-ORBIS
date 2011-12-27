<?php
class Rawreport extends AppModel {
	var $name = 'Rawreport';
	var $displayField = 'raw_message';
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
		'Stat' => array(
			'className' => 'Stat',
			'foreignKey' => 'rawreport_id',
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
		if (get_class($this) === 'Rawreport' ) { 
			if (!empty($queryData))
			{
				//if ($sess->read("Auth.User.group_id") != 8){ // check if admin user
					if (!isset($queryData['conditions']['Rawreport.id'])) { //check if viewing item
						$queryData['conditions'][] = array ('Phone.location_id IN (' . implode(",", Configure::read('authLocations')). ')');
						//$queryData['conditions'][] = array ('Phone.id != -1');
					}
				//}
			}
		}
		return $queryData;
	} 
	function beforeDelete(){
		if ( get_class($this) == 'Rawreport') {
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
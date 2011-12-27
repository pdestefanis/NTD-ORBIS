<?php
class Approval extends AppModel {
	var $name = 'Approval';
	var $order = "Approval.created DESC";
	//The Associations below have been created with all possible keys, those that are not needed can be removed

	var $belongsTo = array(
		'Messagereceived' => array(
			'className' => 'Messagereceived',
			'foreignKey' => 'messagereceived_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		),
		'User' => array(
			'className' => 'User',
			'foreignKey' => 'user_id',
			'conditions' => '',
			'fields' => '',
			'order' => ''
		)
	);

	var $hasAndBelongsToMany = array(
		'Stat' => array(
			'className' => 'Stat',
			'joinTable' => 'approvals_stats',
			'foreignKey' => 'approval_id',
			'associationForeignKey' => 'stat_id',
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
	
	function beforeFind($queryData) {
		/* if (get_class($this) === 'Approval' ) {
			if (!empty($queryData))
			{
				//if ($sess->read("Auth.User.group_id") != 8){ // check if admin user
					if (!isset($queryData['conditions'][get_class($this) . '.id'])) { //check if viewing item
						//$queryData['conditions'][] = array ('Stat.location_id IN (' . implode(", ", Configure::read('authLocations')) . ')');
					}
				//}
			}
		}
		return $queryData; */
	}

	function beforeDelete(){
		if (get_class($this) == 'Approval') {
			$stat = $this->findById($this->id);
			$loc = $stat[get_class($this)]['location_id'];
			//if ($sess->read("Auth.User.group_id") != 8){ // check if admin user
				if (!in_array($loc, Configure::read('authLocations')))
					return false;
			//}
		}
		return true;
	}

}
?>
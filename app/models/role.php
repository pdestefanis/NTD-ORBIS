<?php
class Role extends AppModel {
	var $name   = 'Role'; 
	var $order = "Role.name ASC";
	var $actsAs = array('Acl' => array('type' => 'requester'));

	   
    var $hasMany = array('User' => array('className' => 'User',
		'foreignKey' => 'role_id',
		'conditions' => '',
		'fields' => '',
		'order' => '',
		'counterCache' => '')
    );
                        
    var $validate = array('name' => array('rule' => 'isUnique', 'message' => 'already exist'));
    
    
    function parentNode(){
        return null;
    }

}
?>
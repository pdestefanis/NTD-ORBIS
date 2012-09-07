<?php
class User extends AppModel {
	var $name = 'User';
	var $order = "User.name ASC";
	var $displayField = 'username';
	var $actsAs = array('Acl' => array('type' => 'requester'));

	var $validate = array(
	
		'role_id' => array(
			'rule' => 'notEmpty', 
			'message' => 'Please select role'
		),
         
        'active' => array(
			'rule' => 'notEmpty', 
			'message' => 'Please select Active',
			'required' => true,
		),              
		'username' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter username',
				//'allowEmpty' => false,
				//'required' => false,
				//'last' => false, // Stop validation after this rule
				//'on' => 'create', // Limit validation to 'create' or 'update' operations
			),
			//'between' => array(
			//	'rule' => array('between', 6, 16),
			//	'message' => 'Must be between 6 to 16 characters'
			//),
			'rule' =>  'isUnique',
			'message' => 'This username has already been taken.'


		),
		'password' => array(
					'identicalFieldValues' => array(
							'rule' => array('identicalFieldValues', 'confirm_passwd' ),
							'message' => 'Passwords did not match',
							//'allowEmpty' => false,
							//'required' => true,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations
					),

					/* 'notempty' => array(
							'rule' => array('notempty'),
							'message' => 'Passwords cannot be empty',
							'allowEmpty' => false,
							'required' => true,
							//'last' => false, // Stop validation after this rule
							//'on' => 'create', // Limit validation to 'create' or 'update' operations

					), */

					//'rule' => array('minLength', '6'),
					 //'message' => 'Mimimum 6 characters long'

		),

		  'confirm_passwd' => array(
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Passwords did not match',
				'allowEmpty' => false,
				'required' => true,
				//'last' => false, // Stop validation after this rule
				'on' => 'create', // Limit validation to 'create' or 'update' operations

			),
			//'rule' => array('minLength', '6'),
			//'message' => 'Mimimum 6 characters long'

		), 

		'phone_id' => array( //allow only one phone to one user
			'rule' =>  'isUnique',
			'message' => 'This phone is already assigned to a user.',
			'allowEmpty' => true,
			'required' => false,
		),
		'location_id' => array( //allow only one phone to one user
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Users must be asigned to a location.',
			)
		),
		'name' => array( //allow only one phone to one user
			'notempty' => array(
				'rule' => array('notempty'),
				'message' => 'Please enter full name.',
			)
		),
	);
	//The Associations below have been created with all possible keys, those that are not needed can be removed
	var $hasAndBelongsToMany = array(
			'Role' => array('className' => 'Role',
								'foreignKey'            => 'user_id',
								'associationForeignKey' => 'role_id',
                                'joinTable'             => 'user_roles',
                                'with'                  => 'UserRole',
                                'conditions' => '',
								'fields' => '',
								'order' => '',
								'counterCache' => ''),
	);

	var $belongsTo = array(
		'FirstRole' => array('className' => 'Role',
			'foreignKey'            => 'role_id',
			'conditions' => '',
			'fields' => '',
			'order' => '',
			'counterCache' => ''),
		'Phone' => array(
			'className' => 'Phone',
			'foreignKey' => 'phone_id',
			'conditions' => '',
		),
		'Location' => array(
			'className' => 'Location',
			'foreignKey' => 'location_id',
			'conditions' => '',
		),
	);                     
    
    function parentNode()
    {    
        if($this->id)
        {
            $data = $this->read();

            if($data['User']['role_id'])
                return array('model' => 'Role', 'foreign_key' => $data['User']['role_id']);
        }
        return null;        
    }
	
	var $hasMany = array (
		'Alert' => array(
			'className' => 'Alert',
			'foreignKey' => 'user_id',
			'conditions' => '',
		),
		'Stat' => array(
			'className' => 'Stat',
			'foreignKey' => 'user_id',
			'conditions' => '',
		),
		
	);
	   
	function identicalFieldValues( $field=array(), $compare_field=null )
	  {
	     foreach( $field as $key => $value ){
	          $v1 = $value;
	          $v2 = $this->data[$this->name][ $compare_field ];
	          if ($key == 'password') $v2 = AuthComponent::password($v2);
	          if($v1 !== $v2) {
	              return FALSE;
	          } else {
	              continue;
	          }
	      }
	      return TRUE;
	  }
	  
	  function beforeFind($queryData) {
		if (get_class($this) === 'User' ) {
			if (!empty($queryData))
			{
				//if ($sess->read("Auth.User.group_id") != 8){ // check if admin user
					if (!isset($queryData['conditions']['User.id']) && !isset($queryData['conditions']['User.username'])) { //check if viewing item
						if (Configure::read('authLocations'))
							$queryData['conditions'][] = array ('User.location_id IN (' . implode(",", Configure::read('authLocations')). ')');
						
						//$queryData['conditions'][] = array ('Phone.id != -1');
					}
				//}
			}
		}
		return $queryData;
	} 
	function beforeDelete(){
		if ( get_class($this) == 'User') {
			$stat = $this->findById($this->id);
			$loc = $stat['User']['location_id'];
				if (!in_array($loc, Configure::read('authLocations') ))
					return false;
		}
		return true;
	}
	  
	function beforeValidate(){ //don't change the password if left empty

			App::import('Core', 'Security'); // not sure whether this is necessary
			if($this->data['User']['password'] == Security::hash('', null, true) && $this->data['User']['confirm_passwd'] == ""){
					unset($this->data['User']['password']);
					unset($this->data['User']['confirm_passwd']);
			} 
			return true;

	}
	 
}
?>
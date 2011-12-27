<?php
/*
* Extend the Auth component
*
*/

App::import('component', 'Auth');

class AuthExtComponent extends AuthComponent
{
    var $parentModel = 'Role';
    var $fieldKey    = 'role_id';
    
    // override, to store the associated role
    
    function login($data = null)
    {
        if(!parent::login($data))
            return $this->_loggedIn;

        // fetch the assciated role
        
        $model = $this->getModel();
        
        if(isset($model->hasAndBelongsToMany[$this->parentModel]['with']))
        {   
            $with = $model->hasAndBelongsToMany[$this->parentModel]['with'];
            if(!isset($this->{$with}))
                $this->{$with} =& ClassRegistry::init($with);                

            // fetch the associated model
            $roles = $this->{$with}->find('all', array('conditions' => 'user_id = '.$this->user('id')));
            if(!empty($roles))
            {
                $primaryRole = $this->user($this->fieldKey);            
                // retrieve associated role that are not the primary one
                $roles = set::extract('/'.$with.'['.$this->fieldKey.'!='.$primaryRole.']/'.$this->fieldKey, $roles);

                // add the suplemental roles id under the Auth session key
                if(!empty($roles))
                {
                    $completeAuth = $this->user();
                    $completeAuth[$this->userModel][$this->parentModel] = $roles;
                    $this->Session->write($this->sessionKey, $completeAuth[$this->userModel]);
                }
            }
        }
        
        return $this->_loggedIn;        
    }
    
    // override this to find the right aro/aco
    
    function isAuthorized($type = null, $object = null, $user = null)
    {
        $valid = parent::isAuthorized($type, $object, $user);
        
        if(!$valid && $type == 'actions' && $this->user($this->parentModel))
        {
            // get the groups from the Session, and set the proper Aro path
            $otherRoles = $this->user($this->parentModel);
            $valid = $this->Acl->check(array($this->parentModel => array('id' => $otherRoles)), $this->action());            
		} 
        return $valid;
    }    
}
?>
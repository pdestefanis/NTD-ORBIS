<?php
class RolesController extends AppController {

	var $name = 'Roles';
	var $helpers = array('Html', 'Crumb', 'Javascript', 'Ajax');
	var $components = array('ControllerList');


	function index() {
		$this->Role->recursive = 0;
		$this->set('roles', $this->paginate());
		$users = $this->Role->User->find('list', array('callbacks' => false, 'fields' => array('User.id', 'User.role_id')) );
		$count = array();
		//get main roles
		foreach ($users as $u){
			if (isset($count[$u]))
				$count[$u] += 1;
			else
				$count[$u] = 1;
		}
		//get additional roles
		$users = $this->Role->User->UserRole->find('list', array('callbacks' => false, 'fields' => array('user_id', 'role_id')) );
		foreach ($users as $u){
			if (isset($count[$u]))
				$count[$u] += 1;
			else
				$count[$u] = 1;
		}
		$this->set('count', $count);
			
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid role', true));
			$this->redirect(array('action' => 'index'));
		}
		$this->set('role', $this->Role->read(null, $id));
	}

	function add() {
		if (!empty($this->data)) {
			$this->Role->create();
			if ($this->Role->save($this->data)) {
				$this->Session->setFlash('The role has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The role could not be saved. Please, try again.', true));
			}
		}
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid role', true));
			$this->redirect(array('action' => 'index'));
		}
		if (!empty($this->data)) {
			if ($this->Role->save($this->data)) {
				$this->Session->setFlash('The role has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash(__('The role could not be saved. Please, try again.', true));
			}
		}
		if (empty($this->data)) {
			$this->data = $this->Role->read(null, $id);
		}
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid id for role', true));
			$this->redirect(array('action'=>'index'));
		}
		if ($this->Role->delete($id)) {
			$this->Session->setFlash('Role deleted', 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash(__('Role was not deleted', true));
		$this->redirect(array('action' => 'index'));
	}
	
	function managePermissions()
    {
		$this->cleanupAcl();
        $avoidControllers   = array('Utils');
        $data               = $this->Role->find('all');
        $controllerList     = $this->ControllerList->get();  

        // we loop on all action for all roles
        $inidbg =  Configure::read( 'debug');

        //Configure::write( 'debug', '0' );       
				
		//$controllerList['App'][] = 'controllers';		
        foreach($controllerList as $controller => $actions )                
        {	
		
            if(in_array($controller, $avoidControllers))
            {
                unset($controllerList[$controller]);
                continue;
            }
            foreach($actions as $key => $action)
           	{
				
                $controllerList[$controller][$action] = array();          
                unset($controllerList[$controller][$key]);                    	  	
                foreach($data as $p)
                {
                    $controllerList[$controller][$action][$p['Role']['id']] = $this->Acl->check($p, $controller . '/'. $action, '*');             	
                }     
            }   
        } 

        //Configure::write( 'debug', $inidbg);          
        $this->set('ctlist', $controllerList);   
        $this->set('data', $data);            
    } 

    // we set unset the permission
    
	
	function allowDenyPermission($roleid, $controller, $action, $permission) {
        // we read the role again

        $role = $this->Role->read(null, $roleid);

        if($action == 'all') 
        {
		
            $controllerList = $this->ControllerList->get($controller);
			
            foreach($controllerList[$controller] as $action )
                $this->setPermissions($role, $controller, $action, $permission ); 
              
            $this->set('ctlist', $controllerList[$controller]);         
        } else {
            $this->setPermissions($role, $controller, $action, $permission );        
            $this->set('ctlist',     array($action));              
        }
          
        $this->set('controller', $controller);
        $this->set('permission', $permission);
        $this->set('roleid',     $roleid);       
    }
    
    // set the permission
        
    private function setPermissions($role, $controller, $action, $permission ) {
        // First check to make sure that the controller is already set up as an ACO
        $aco = new Aco(  );

        $rootAco = $aco->findByAlias( 'controllers' );

        // Set up $controllerAco if it's not present.
        $controllerAco = $aco->findByAlias( $controller );
		//$this->Administrator->query( 'SELECT Aco.* From acos AS Aco LEFT JOIN acos AS Aco0 ON Aco0.alias = "'.$controller.'" LEFT JOIN acos AS Aco1 ON Aco1.lft > Aco0.lft && Aco1.rght < Aco0.rght AND Aco1.alias = "controllers" WHERE Aco.lft <= Aco0.lft AND Aco.rght >= Aco0.rght ORDER BY Aco.lft DESC' ) );

        if( empty( $controllerAco ) )
        {
            $aco->create(  );
            $aco->save( array ('alias' => $controller, 'parent_id' => $rootAco['Aco']['id']));
            $controllerAco = $aco->findByAlias( $controller );
			//$this->Administrator->query( 'SELECT Aco.* From acos AS Aco LEFT JOIN acos AS Aco0 ON Aco0.alias = "'.$controller.'" LEFT JOIN acos AS Aco1 ON Aco1.lft > Aco0.lft && Aco1.rght < Aco0.rght AND Aco1.alias = "controllers" WHERE Aco.lft <= Aco0.lft AND Aco.rght >= Aco0.rght ORDER BY Aco.lft DESC' ) );
        }

        // Set up $actionAcoif it's not present.
        $actionAco = $aco->find( array( 'parent_id' => $controllerAco['Aco']['id'], 'alias' => $action ) );

        if ( empty( $actionAco ) )
        {
            $aco->create(  );
            $aco->save( array ('alias' => $action, 'parent_id' => $controllerAco['Aco']['id']));
            $actionAco = $aco->find( array( 'parent_id' => $controllerAco['Aco']['id'], 'alias' => $action ) );
        }

        // Set up perms now.

        if ( $permission == 'allow' )
            $this->Acl->allow( array( 'model' => 'Role', 'foreign_key' => $role['Role']['id'] ), $controller . '/' . $action );
        else
            $this->Acl->inherit( array( 'model' => 'Role', 'foreign_key' => $role['Role']['id'] ), $controller . '/' . $action );
    } 

	private function cleanupAcl()
    {
        // first we read all controllers/action
        $rootAco = $this->Acl->Aco->findByAlias('controllers');
        $roles   = $this->Role->find('all', array('recursive' => 0));
        if(empty($rootAco))
        {
            $this->set('str', "Error controllers ACO is not set, please create it with with console first");
            $this->render();
            return;
            
        }

        $str = "";
        $controllerList     = $this->ControllerList->get();
		//$controllerList['App'][] = 'controllers';
        // we read all aco's
        $acosActions        = $this->Acl->Aco->find('all', array('recursive' => 0, 'conditions' => array('model' => '', 'foreign_key' => null, 'id != '.$rootAco['Aco']['id'], 'parent_id != 1')));
        $acosControllers    = $this->Acl->Aco->find('all', array('recursive' => 0, 'conditions' => array('model' => '', 'foreign_key' => null, 'id != '.$rootAco['Aco']['id'], 'parent_id = 1')));
        //pr($acosActions);
        $controllerAcoIds   = set::combine($acosControllers, '{n}.Aco.id', '{n}.Aco.alias');
        $idsDel             = array();

        // delete the ACO for actions that do not exists anymore
        
        foreach($acosActions as $aco)
        {
            $todel  = false;
            $ctName = 'unknow';
            // check the paren
            if(!isset($controllerAcoIds[$aco['Aco']['parent_id']]))
                $todel = true;
            else
            {
                $ctName = $controllerAcoIds[$aco['Aco']['parent_id']];
                if(!isset($controllerList[$ctName]) || !in_array($aco['Aco']['alias'], $controllerList[$ctName]))
                    $todel = true;
            }
            
            if($todel)
            {
                $str .= "delete Aco id {$aco['Aco']['id']} - action {$ctName}/{$aco['Aco']['alias']}\n"; 
                $idsDel[] = $aco['Aco']['id'];
            }
        }
        
        if(!empty($idsDel))
            $this->Acl->Aco->deleteAll(array('id' => $idsDel));

        $idsDel = array();
        if(!empty($str))
            $str .= "\n\n";
        // delete controller acos not found
        foreach($acosControllers as $aco)
        {
            $todel  = false;
            if(!isset($controllerList[$ctName]))
                $todel = true;
            
            if($todel)
            {
                $str .= "delete Aco id {$aco['Aco']['id']} - controller {$aco['Aco']['alias']}\n"; 
                $idsDel[] = $aco['Aco']['id'];
            }
        }

        if(!empty($idsDel))
            $this->Acl->Aco->deleteAll(array('id' => $idsDel));
           
        if(empty($str))
            $str = "Controller/Action ACO already clean\n\n";
            
        foreach($controllerList as $key => $actions)
        {
            // try to find the aco
            $acoCt = $this->Acl->Aco->findByAlias($key);
            
            // create if not found
            if(empty($acoCt))
            {
                $this->Acl->Aco->create();
                $this->Acl->Aco->save( array ('alias' => $key, 'parent_id' => $rootAco['Aco']['id']));
                $acoCt = $this->Acl->Aco->findByAlias($key);
                $str .= "Aco id {$acoCt['Aco']['id']} created for controller {$key}\n";
            }
            // loop on the actions
            foreach($actions as $action)
            {
                // find the action aco
                $acoAct = $this->Acl->Aco->find(array('parent_id' => $acoCt['Aco']['id'], 'alias' => $action));
                if(empty($acoAct))
                {
                    // we create an aco for this action
                    $this->Acl->Aco->create();
                    $this->Acl->Aco->save( array ('alias' => $action, 'parent_id' => $acoCt['Aco']['id']));
                    $acoAct = $this->Acl->Aco->find(array('parent_id' => $acoCt['Aco']['id'], 'alias' => $action));                    
                    $str .= "Aco id {$acoAct['Aco']['id']} created for controller.action {$key}/{$action}\n";
                }
                /*
                    create default permisssion (inherit)
                */
                foreach($roles as $role)
                {
                    $z      = $this->Acl->_Instance->getAclLink($role, "{$key}/{$action}");
                    $lnk    = set::extract('/link/Permission', $z);
                    if(empty($lnk))
                    {
                        $this->Acl->inherit(array('model' => 'Role', 'foreign_key' => $role['Role']['id'] ), $key . '/' . $action);
                        $str .= "\t default permission inherit has been set for aro {$role['Role']['name']} action {$key}/{$action}.\n";
                    }
                }                
            }
        }

        $this->set('str', $str);            
    }
}
?>
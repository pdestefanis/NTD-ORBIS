<?php
class UsersController extends AppController {

	var $name = 'Users';
	var $helpers = array('Html', 'Crumb', 'Javascript', 'Ajax');
	var $components = array('AuthExt', 'RequestHandler', 'Access');

	function beforeRender() {

		if ($this->action == 'view'){
				if (!in_array($this->viewVars['user']['User']['location_id'], $this->Session->read("userLocations")) && $this->viewVars['user']['User']['location_id'] != "") { //view
					
					$this->Session->setFlash('You are not allowed to access this record.'  , 'flash_failure'); 
					$this->redirect( '/users/index', null, false);
				} 
		}
		if ($this->action == 'edit'){
				if (!in_array($this->data['User']['location_id'], $this->Session->read("userLocations") ) && $this->data['User']['location_id'] != "") { //edit
					$this->Session->setFlash('You are not allowed to access this record.' , 'flash_failure'); 
					$this->redirect( '/users/index', null, false);
				} 
		}
		
		
	}

	function login() {
		if ($this->AuthExt->user()) {
			
			//$this->Session->write("currentUser", $this->Session->read('Auth.User'));// $this->Auth->user());
	
			$u = $this->AuthExt->user();
			$g[] = $u['User']['role_id'];
			if (isset($u['User']['Role']))
			foreach ($u['User']['Role'] as $role) 
				$g[] = $role;
			$parents = NULL;
			
			$this->findLocationParent($u['User']['location_id'], $parents, $u['User']['reach'] );
			
			$children = $parents; //make sure all parents are included
			foreach ($parents as $p) 
				$this->findLocationChildren($p, $children);
			$children = array_unique($children);
			$locs[] = $u['User']['location_id']; //add current location
			
			if ($u['User']['role_id'] == 1)// (in_array(1,$g)) only primay admins have all locations
				$locs = array_keys($this->User->Location->find('list', array('callbacks' => 'false')));
			else
				$locs = array_values($children);
			
			//$locs = array_keys($locs);
			
			$this->Session->write("userLocations", $locs);
		
			$this->Session->setFlash( ucwords($u['User']['name']) . ', you are logged in!' , 'flash_success');
			$this->redirect($this->AuthExt->redirect());
			//$this->redirect('/', null, true);
		} 
	 }

	 

   function logout() {
		
		$this->Session->destroy();
		$this->Session->delete('currUser'); 
		$this->Session->delete('userLocations'); 
		$this->Session->setFlash('Good-Bye', 'flash_success');
		$this->AuthExt->logout();
		$this->redirect($this->AuthExt->redirect());

   }

   

	function index() {
		$this->User->recursive = 1;
		$search = (empty($this->data['Search']['search'])?(isset($this->passedArgs[0])?$this->passedArgs[0]:$this->data['Search']['search']):$this->data['Search']['search']);
		if (!empty($search) ) {
				$this->paginate['User'] = array('order' => 'User.name Asc',
										'conditions'=>array( 
											"OR" => array("User.username LIKE "=>"%".$search."%", 
													"FirstRole.name LIKE" => "%".$search."%", 
													"Location.name LIKE" => "%".$search."%", 
													)
									));
		} 
		$this->set('users', $this->paginate());
	}

	function view($id = null) {
		if (!$id) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		if (empty($this->data['Config']['limit'])) {
			$this->User->hasMany['Stat']['limit'] = 20;
			$this->User->hasMany['Stat']['order'] = 'created desc';
		}else {
			$this->layout = 'ajax';
			$this->User->hasMany['Stat']['limit'] = $this->data['Config']['limit'];
			$this->User->hasMany['Stat']['order'] = 'created desc';
		}
		$this->set('user', $this->User->read(null, $id));
		
		$this->set('locations', $this->User->Location->find('list', array ('conditions' => array('Location.deleted = 0'))));
		//$this->set('messagesents', $this->User->Messagesent->find('list', array ('fields' => array('messagereceived_id', 'rawmessage'), 'callbacks' => false)));
		$this->set('phones', $this->User->Phone->find('list', array ('conditions' => array('Phone.deleted = 0'), 'callbacks' => false)));
		$this->set('userLocations', $this->Session->read("userLocations"));
	}

	function add() {
	/*

		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash('The user has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->Session->setFlash('The user could not be saved. Please, try again.'flash_success');
			}
		}
	*/
		if (!empty($this->data)) {
			$this->User->create();
			if ($this->User->save($this->data)) {
				$this->Session->setFlash('The user has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->data['User']['password'] = null;
				$this->data['User']['confirm_passwd'] = null;
				$this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_failure');

			}

		}

		//only allow admins to select admin roles
		$u = $this->AuthExt->user();
		$g[] = $u['User']['role_id'];
		if (isset($u['User']['Role']))
			foreach ($u['User']['Role'] as $role) 
				$g[] = $role;
		if (in_array( 1, $g))
			$roles = $this->User->Role->find('list');
		else
		$roles = $this->User->Role->find('list', array('conditions' => array('id !='. 1) ));
		$phones = $this->User->Phone->find('list', array( 'conditions' => array('deleted' => 0)));
		$locations = $this->User->Location->find('list', array('conditions' => array('deleted' => 0)));
		$this->set(compact('roles', 'locations', 'phones'));
		
	}

	function edit($id = null) {
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {
			 $this->set('action', 'action');//set this dummy field for models empty passwords on edit user
			if ($this->User->save($this->data)) {
				$this->Session->setFlash('The user has been saved', 'flash_success');
				$this->redirect(array('action' => 'index'));
			} else {
				$this->data['User']['password'] = null;
				$this->data['User']['confirm_passwd'] = null;
				$this->Session->setFlash('The user could not be saved. Please, try again.', 'flash_failure');
			}
		} else {
			$this->data = $this->User->read(null, $id);
			$this->data['User']['password'] = null;
		}
		$u = $this->AuthExt->user();
		$g[] = $u['User']['role_id'];
		if (isset($u['User']['Role']))
			foreach ($u['User']['Role'] as $role) 
				$g[] = $role;
		if (in_array( 1, $g))
			$roles = $this->User->Role->find('list');
		else
			$roles = $this->User->Role->find('list', array('conditions' => array('id !='. 1) ));
		$phones = $this->User->Phone->find('list', array( 'conditions' => array('deleted' => 0)));
		$locations = $this->User->Location->find('list', array('conditions' => array('deleted' => 0)));
		$this->set(compact('roles', 'locations', 'phones'));
	}

	function delete($id = null) {
		if (!$id) {
			$this->Session->setFlash('Invalid id for user', 'flash_failure');
			$this->redirect(array('action'=>'index'));
		}
		if ($this->User->delete($id)) {
			$this->Session->setFlash('User deleted', 'flash_success');
			$this->redirect(array('action'=>'index'));
		}
		$this->Session->setFlash('User was not deleted', 'flash_failure');
		$this->redirect(array('action' => 'index'));
	}

	private function initDB() {
		$group =& $this->User->Group;
		
		/*
		 * Allow admins to everything
		 */
		$group->id = 8;
		$this->Acl->allow($group, 'controllers');
		$this->Acl->allow($group, 'controllers/Modifiers/view');
		$this->Acl->allow($group, 'controllers/Modifiers/index');
		 
		$this->Acl->deny($group, 'controllers/Modifiers');

		// Approvals
		$this->Acl->allow($group, 'controllers/Approvals/index');
		$this->Acl->allow($group, 'controllers/Approvals/pending');
		$this->Acl->allow($group, 'controllers/Approvals/add');


		/*
		 * moderators
		 */
		$group->id = 9;
		$this->Acl->allow($group, 'controllers');

		// Approvals
		$this->Acl->allow($group, 'controllers/Approvals/index');
		$this->Acl->allow($group, 'controllers/Approvals/pending');
		$this->Acl->allow($group, 'controllers/Approvals/add');

		$this->Acl->allow($group, 'controllers/updateJSONFile');
		$this->Acl->allow($group, 'controllers/Stats/sitems');
		$this->Acl->allow($group, 'controllers/Stats/ichart');
		$this->Acl->allow($group, 'controllers/Stats/facility');
		$this->Acl->allow($group, 'controllers/Stats/index');
		$this->Acl->allow($group, 'controllers/Stats/view');
		$this->Acl->allow($group, 'controllers/Stats/add');
		$this->Acl->allow($group, 'controllers/Stats/edit');
		$this->Acl->allow($group, 'controllers/Stats/update_select');
		$this->Acl->allow($group, 'controllers/Stats/delete');
		$this->Acl->allow($group, 'controllers/Items');
		$this->Acl->allow($group, 'controllers/Locations');
		$this->Acl->allow($group, 'controllers/Phones');
		$this->Acl->allow($group, 'controllers/Rawreports/index');
		$this->Acl->allow($group, 'controllers/Rawreports/view');
		$this->Acl->allow($group, 'controllers/Rawreports/edit');
		$this->Acl->allow($group, 'controllers/Rawreports/update_select');
		$this->Acl->allow($group, 'controllers/Rawreports/delete');
		$this->Acl->allow($group, 'controllers/Users/logout');
		$this->Acl->allow($group, 'controllers/Stats/options');
		$this->Acl->allow($group, 'controllers/Users/changePass');
		$this->Acl->allow($group, 'controllers/Users/findLocationChildren');
		$this->Acl->allow($group, 'controllers/Alerts');
		 
		$this->Acl->deny($group, 'controllers/Users');
		$this->Acl->deny($group, 'controllers/Groups');
		$this->Acl->deny($group, 'controllers/Users/initDB');
		$this->Acl->deny($group, 'controllers/Users/build_acl');
		$this->Acl->deny($group, 'controllers/Users/resetUsers');
		$this->Acl->deny($group, 'controllers/Stats');
		$this->Acl->deny($group, 'controllers/Rawreports');
		$this->Acl->deny($group, 'controllers/Modifiers');

		/*
		 * Users
		 */
		$group->id = 10;
		$this->Acl->allow($group, 'controllers');
		
		$this->Acl->allow($group, 'controllers/Approvals/index');
		$this->Acl->allow($group, 'controllers/Approvals/pending');
		$this->Acl->allow($group, 'controllers/Approvals/add');
		
		$this->Acl->allow($group, 'controllers/updateJSONFile');
		$this->Acl->allow($group, 'controllers/getReport');
		$this->Acl->allow($group, 'controllers/findTopParent');
		$this->Acl->allow($group, 'controllers/Stats/sitems');
		$this->Acl->allow($group, 'controllers/Stats/ichart');
		$this->Acl->allow($group, 'controllers/Stats/facility');
		$this->Acl->allow($group, 'controllers/Users/logout');
		$this->Acl->allow($group, 'controllers/Item/view');
		$this->Acl->allow($group, 'controllers/Locations/view');
		$this->Acl->allow($group, 'controllers/Users/changePass');
		$this->Acl->allow($group, 'controllers/findLocationChildren');
		$this->Acl->allow($group, 'controllers/findLocationParent');

		$this->Acl->deny($group, 'controllers/Users');
		$this->Acl->deny($group, 'controllers/Groups');
		$this->Acl->deny($group, 'controllers/Users/initDB');
		$this->Acl->deny($group, 'controllers/Users/build_acl');
		$this->Acl->deny($group, 'controllers/Users/resetUsers');
		$this->Acl->deny($group, 'controllers/Items');
		$this->Acl->deny($group, 'controllers/Locations');
		$this->Acl->deny($group, 'controllers/Phones');
		$this->Acl->deny($group, 'controllers/Stats');
		$this->Acl->deny($group, 'controllers/Rawreports');
		$this->Acl->deny($group, 'controllers/Stats/options');
		$this->Acl->deny($group, 'controllers/Modifiers');

		//echo "all done";
		$this->Session->setFlash('User acl reset success', 'flash_success');
		$this->setAction('login');
	}

	private function build_acl() {
  		if (!Configure::read('debug')) {
  			return $this->_stop();
  		}
  		$log = array();

  		$aco =& $this->Acl->Aco;
  		$root = $aco->node('controllers');
  		if (!$root) {
  			$aco->create(array('parent_id' => null, 'model' => null, 'alias' => 'controllers'));
  			$root = $aco->save();
  			$root['Aco']['id'] = $aco->id;
  			$log[] = 'Created Aco node for controllers';
  		} else {
  			$root = $root[0];
  		}

  		App::import('Core', 'File');
  		$Controllers = Configure::listObjects('controller');
  		$appIndex = array_search('App', $Controllers);
  		if ($appIndex !== false ) {
  			unset($Controllers[$appIndex]);
  		}
  		$baseMethods = get_class_methods('Controller');
  		$baseMethods[] = 'buildAcl';

  		$Plugins = $this->_getPluginControllerNames();
  		$Controllers = array_merge($Controllers, $Plugins);

  		// look at each controller in app/controllers
  		foreach ($Controllers as $ctrlName) {
  			$methods = $this->_getClassMethods($this->_getPluginControllerPath($ctrlName));

  			// Do all Plugins First
  			if ($this->_isPlugin($ctrlName)){
  				$pluginNode = $aco->node('controllers/'.$this->_getPluginName($ctrlName));
  				if (!$pluginNode) {
  					$aco->create(array('parent_id' => $root['Aco']['id'], 'model' =>  $this->_getPluginName($ctrlName), 'alias' => $this->_getPluginName($ctrlName)));
  					$pluginNode = $aco->save();
  					$pluginNode['Aco']['id'] = $aco->id;
  					$log[] = 'Created Aco node for ' . $this->_getPluginName($ctrlName) . ' Plugin';
  				}
  			}
  			// find / make controller node
  			$controllerNode = $aco->node('controllers/'.$ctrlName);
  			if (!$controllerNode) {
  				if ($this->_isPlugin($ctrlName)){
  					$pluginNode = $aco->node('controllers/' . $this->_getPluginName($ctrlName));
  					$aco->create(array('parent_id' => $pluginNode['0']['Aco']['id'], 'model' => $ctrlName, 'alias' => $this->_getPluginControllerName($ctrlName)));
  					$controllerNode = $aco->save();
  					$controllerNode['Aco']['id'] = $aco->id;
  					$log[] = 'Created Aco node for ' . $this->_getPluginControllerName($ctrlName) . ' ' . $this->_getPluginName($ctrlName) . ' Plugin Controller';
  				} else {
  					$aco->create(array('parent_id' => $root['Aco']['id'], 'model' => $ctrlName, 'alias' => $ctrlName));
  					$controllerNode = $aco->save();
  					$controllerNode['Aco']['id'] = $aco->id;
  					$log[] = 'Created Aco node for ' . $ctrlName;
  				}
  			} else {
  				$controllerNode = $controllerNode[0];
  			}

  			//clean the methods. to remove those in Controller and private actions.
  			foreach ($methods as $k => $method) {
  				if (strpos($method, '_', 0) === 0) {
  					unset($methods[$k]);
  					continue;
  				}
  				if (in_array($method, $baseMethods)) {
  					unset($methods[$k]);
  					continue;
  				}
  				$methodNode = $aco->node('controllers/'.$ctrlName.'/'.$method);
  				if (!$methodNode) {
  					$aco->create(array('parent_id' => $controllerNode['Aco']['id'], 'model' => $ctrlName, 'alias' => $method));
  					$methodNode = $aco->save();
  					$log[] = 'Created Aco node for '. $method;
  				}
  			}
  		}
  		if(count($log)>0) {
  			//debug($log);
			$this->setAction('initDB');
  		}
  	}

  	function _getClassMethods($ctrlName = null) {
  		App::import('Controller', $ctrlName);
  		if (strlen(strstr($ctrlName, '.')) > 0) {
  			// plugin's controller
  			$num = strpos($ctrlName, '.');
  			$ctrlName = substr($ctrlName, $num+1);
  		}
  		$ctrlclass = $ctrlName . 'Controller';
  		$methods = get_class_methods($ctrlclass);

  		// Add scaffold defaults if scaffolds are being used
  		$properties = get_class_vars($ctrlclass);
  		if (array_key_exists('scaffold',$properties)) {
  			if($properties['scaffold'] == 'admin') {
  				$methods = array_merge($methods, array('admin_add', 'admin_edit', 'admin_index', 'admin_view', 'admin_delete'));
  			} else {
  				$methods = array_merge($methods, array('add', 'edit', 'index', 'view', 'delete'));
  			}
  		}
  		return $methods;
  	}

  	function _isPlugin($ctrlName = null) {
  		$arr = String::tokenize($ctrlName, '/');
  		if (count($arr) > 1) {
  			return true;
  		} else {
  			return false;
  		}
  	}

  	function _getPluginControllerPath($ctrlName = null) {
  		$arr = String::tokenize($ctrlName, '/');
  		if (count($arr) == 2) {
  			return $arr[0] . '.' . $arr[1];
  		} else {
  			return $arr[0];
  		}
  	}

  	function _getPluginName($ctrlName = null) {
  		$arr = String::tokenize($ctrlName, '/');
  		if (count($arr) == 2) {
  			return $arr[0];
  		} else {
  			return false;
  		}
  	}

  	function _getPluginControllerName($ctrlName = null) {
  		$arr = String::tokenize($ctrlName, '/');
  		if (count($arr) == 2) {
  			return $arr[1];
  		} else {
  			return false;
  		}
  	}
  /**
   * Get the names of the plugin controllers ...
   *
   * This function will get an array of the plugin controller names, and
   * also makes sure the controllers are available for us to get the
   * method names by doing an App::import for each plugin controller.
   *
   * @return array of plugin names.
   *
   */
  	function _getPluginControllerNames() {
  		App::import('Core', 'File', 'Folder');
  		$paths = Configure::getInstance();
  		$folder =& new Folder();
  		$folder->cd(APP . 'plugins');

  		// Get the list of plugins
  		$Plugins = $folder->read();
  		$Plugins = $Plugins[0];
  		$arr = array();

  		// Loop through the plugins
  		foreach($Plugins as $pluginName) {
  			// Change directory to the plugin
  			$didCD = $folder->cd(APP . 'plugins'. DS . $pluginName . DS . 'controllers');
  			// Get a list of the files that have a file name that ends
  			// with controller.php
  			$files = $folder->findRecursive('.*_controller\.php');

  			// Loop through the controllers we found in the plugins directory
  			foreach($files as $fileName) {
  				// Get the base file name
  				$file = basename($fileName);

  				// Get the controller name
  				$file = Inflector::camelize(substr($file, 0, strlen($file)-strlen('_controller.php')));
  				if (!preg_match('/^'. Inflector::humanize($pluginName). 'App/', $file)) {
  					if (!App::import('Controller', $pluginName.'.'.$file)) {
  						debug('Error importing '.$file.' for plugin '.$pluginName);
  					} else {
  						/// Now prepend the Plugin name ...
  						// This is required to allow us to fetch the method names.
  						$arr[] = Inflector::humanize($pluginName) . "/" . $file;
  					}
  				}
  			}
  		}
  		return $arr;
  	}
	
	function changePass() {
		//only allow the currently logged in user to change his password
		$id = $this->AuthExt->User('id');
		if (!$id && empty($this->data)) {
			$this->Session->setFlash(__('Invalid user', true));
			$this->redirect(array('action' => 'index'));
		}
		
		if (!empty($this->data)) {
			//don't allow hidden variables tweaking get the group and username 
			//form the system in case an override occured from the hidden fields
			$this->data['User']['role_id'] = $this->AuthExt->User('role_id');
			$this->data['User']['username'] = $this->AuthExt->User('username');
			if ($this->User->save($this->data)) {
				$this->Session->setFlash('The password change has been saved', 'flash_success');
				$this->redirect(array('action' => 'index', 'controller' => ''));
			} else {
				$this->data = $this->User->read(null, $id);
				$this->data['User']['password'] = null;
				$this->data['User']['confirm_passwd'] = null;
				$this->Session->setFlash('The password could not be saved. Please, try again.', 'flash_failure');
			}
		}
		if (empty($this->data)) {
			$this->data = $this->User->read(null, $id);
			$this->data['User']['password'] = null;
		}
		$roles = $this->User->Role->find('list');
		$this->set(compact('roles'));
	}
	
	private function resetUsers() {
		$this->User->query('DELETE FROM ACOS');
		$this->User->query('DELETE FROM AROS_ACOS');
		$this->Auth->allowedActions = array('*');
		$this->setAction('build_acl');
	}
}
?>
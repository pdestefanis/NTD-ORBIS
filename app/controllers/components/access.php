<?php
class AccessComponent extends Object{
	var $components = array('Acl', 'AuthExt');
	var $user;
	function startup(){
		$this->user = $this->AuthExt->user();
	}
	function checkHelper($aro, $aco, $action = "index"){
		App::import('Component', 'Session');
		$sess = new SessionComponent();
		// $sess -> read("currentUser.User.location_id");
		
		App::import('Component', 'Acl');
		$acl = new AclComponent();
		
		//return $acl check plus the session perms
		return $acl->check($aro, $aco, $action);
	}
	
	function checkHtmlHelper ($aro, $aco, $type, $label, $path, $action = "index", $deleteName=''){
		App::import('Component', 'Session');
		$sess = new SessionComponent();
		// $sess -> read("currentUser.User.location_id");
		
		App::import('Component', 'Acl');
		$acl = new AclComponent();
			
		App::import('Helper', 'Html');
		$html = new HtmlHelper();
		//return $acl check plus the session perms
		
		if ( $acl->check($aro, $aco, $action)) {
			if ($type == "link" || $type == "text") {
				echo $html->link(__($label, true), $path); 
			}
			
			if ($type == "html") {
				echo $label; 
			}
			if ($type == "delete") {
				echo $html->link(__($label, true), $path, null, sprintf(__('Are you sure you want to delete %s?', true), $deleteName)); 
			}
			
		} else {
			if ($type == "text") { //if the items needs to be printed as text and link if allowed to see it
				echo $label; 
			}
		}
		
	}
}
?>
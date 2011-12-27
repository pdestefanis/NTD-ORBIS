<?php
class AccessHelper extends Helper{
    var $helpers = array('Session', 'Html');
    var $Access;
    var $AuthExt;
    var $user;

    function beforeRender(){
        App::import('Component', 'Access');
        $this->Access = new AccessComponent();

        App::import('Component', 'AuthExt');
        $this->AuthExt = new AuthComponent();
        $this->AuthExt->Session = $this->Session;

        $this->user = $this->AuthExt->user();
		
    }

    function check($aco, $action='*'){
        if(empty($this->user)) return false;
        return $this->Access->checkHelper($this->user, $aco, $action);
    }
	
	function checkHtml($aco, $type, $label, $path, $action='*', $deleteName=''){
        if(empty($this->user)) return false;
        return $this->Access->checkHtmlHelper($this->user, $aco, $type, $label, $path, $action, $deleteName);
    }

    function isLoggedin(){
        return !empty($this->user);
    }
}
?>

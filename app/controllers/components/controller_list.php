<?php
/*
 * List all method of all controllers
 *
 */
class ControllerListComponent extends Object
{
	var $components = array('Acl');
    function get($controller = null, $nomethod = false)
    {
        $controllers = array();
       // $conf = Configure::getInstance();

       // $paths      = $conf->controllerPaths;
       // $plugPaths  = $conf->pluginPaths;
	  
		$paths      = array();
		$plugPaths  = array();
		//App::objects('controller', &$paths);
		//$pluginClasses = App::objects('plugin', &$plugPaths);
        $pluglist   = Configure::listObjects('plugin');

       /*  foreach($plugPaths as $l)
        {
            foreach($pluglist as $v)
                $paths[] = $l.inflector::underscore($v).DS.'controllers';
        }  */

        $pluglist = array_merge(array(''), $pluglist);
        $controllerList = Configure::listObjects('controller', $paths, false);        

        if(!$controller)
        {
            foreach($controllerList as $file)
            {
                if(!$nomethod)
                    $controllers[$file] = $this->_getControllerMethods($file, $pluglist);
                else 
                    $controllers[] = $file; 
            }        
            
        }
        else
        {
            if(!$nomethod)
                $controllers[$controller] = $this->_getControllerMethods($controller, $pluglist);
            else
                $controllers[] = $controller;
        }
		
        
        return $controllers;
    }

    function _getControllerMethods($controllerName, $plugins)
    {
        $classMethodsCleaned = array();
        $found = false;
        
        foreach($plugins as $plugin)
        {
            if(App::import('Controller', empty($plugin) ? $controllerName : $plugin.'.'.$controllerName))
            {
                $found = true;
                break;
            }
        }
        
        if(!$found)
            return array();
            
        $parentClassMethods = get_class_methods(get_parent_class(Inflector::camelize($controllerName).'Controller'));
        $subClassMethods    = get_class_methods(Inflector::camelize($controllerName).'Controller');
        $classMethods       = array_diff($subClassMethods, $parentClassMethods);

        foreach($classMethods as $method)
        {
            if($method{0} <> "_")
            {
                $classMethodsCleaned[] = $method;
            }
    	}
        
        return $classMethodsCleaned;
    }
}
?>
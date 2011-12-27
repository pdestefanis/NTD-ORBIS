<?php
	foreach($ctlist as $action) {
		$updid = $controller.'_'.$action.'_'.$roleid;

		if($permission == 'allow') {
			$v = 'allowed ' . $ajax->link( 'deny?', '/roles/allowDenyPermission/'.$roleid.'/'.$controller.'/'.$action.'/deny', array('update' => 'updacl'));
			$st = 'style="color: #66CC00;"';
		} else {
			$v = 'denied ' . $ajax->link( 'allow?', '/roles/allowDenyPermission/'.$roleid.'/'.$controller.'/'.$action.'/allow', array('update' => 'updacl'));
			$st = 'style="color: #990000;"';
		}
		$z = '<td id="'.$controller.'_'.$action.'_'.$roleid.'" '.$st.'>'.$v.'</td>';
		$string=str_replace(array('%','/','<',"\\","\r","\n",'"'),
		array('%25','\/','%3C','\\','','\r\n','\"'), $z);
		$z = 'unescape("' . $string . '")';
		$js= "_elem = $('{$updid}'); Element.replace(_elem, {$z});";
		$this->log($javascript->codeBlock($js));
		echo $javascript->codeBlock($js);
	}
?>
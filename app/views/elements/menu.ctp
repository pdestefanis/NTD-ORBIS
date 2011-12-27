<?php 
	//loop thourgh menu and remove unauthorized
	foreach ($menus as $key => $value) {
		foreach ($value as $k => $v) {
			if (is_numeric($k)) {
				if(!$access->check($v['ACL']) ) 
					unset($menus[$key][$k]);
			}
		}
	}
	/* echo "<pre>";
	print_r($menus);
	echo "</pre>"; */
	echo "<div class='primary-menu'>";
	echo "<ul>";
	
	//build primary
	foreach ($menus as $key => $value) {
		$class = '';
		if (isset($value['url']) && isset($value[0])) {
			if ($this->name == 'Pages' && $value['url'] == '/' || (isset($value['ACL']) && strpos($this->name .  "/" . $this->action, $value['ACL'])) && (!empty($value['exclude']) && !in_array($this->name .  "/" . $this->action , $value['exclude']))) { //cater for homepage
				$class = 'active';
			} else if (in_array($this->name .  "/" . $this->action , $value['sub']) && (!empty($value['exclude']) && !in_array($this->name .  "/" . $this->action , $value['exclude']))) {
			//} else if ($value['url'] != '' && strpos($this->here, $value['url'])) {
				$class = 'active';
			}
			echo "<li class=$class>";
			echo $html->link($value['label'], $value['url']);
			echo "</li>";
		}
	}
	echo "</ul> </div>";
	
	
	//build secondary
	echo "<div class='secondary-menu'><ul>";
	foreach ($menus as $key => $value) {
		foreach ($value as $k => $v) {
			if (is_numeric($k)) {
				$class = '';
				if (in_array($this->name .  "/" . $this->action , $value['sub']) && (!empty($value['exclude']) && !in_array($this->name .  "/" . $this->action , $value['exclude']))) {
					$class = 'active';
					echo "<li class=$class>";
					echo $html->link($v['label'], $v['url']);
					echo "</li>";
					echo "<li>|</li>";
				}
			}
		} 
		/* $class = '';
		if (isset($value['url']) && isset($value[0])) {
			if ($this->name == 'Pages' && $value['url'] == '/' || (isset($value['ACL']) && strpos($this->name .  "/" . $this->action, $value['ACL']))) { //cater for homepage
				$class = 'active';
			} else if ($value['url'] != '' && strpos($this->here, $value['url'])) {
				$class = 'active';
			}
			echo "<li class=$class>";
			echo $html->link($value['label'], $value['url']);
			echo "</li>";
		} */
	}
	echo "</ul> </div>";

	/* $class = ($this->name == 'Pages' || ($this->action == 'aggregatedInventory' || $this->action == 'facilityInventory'
		|| $this->action == 'aggregatedChart' || $this->action == 'triggeredAlerts'))?'active':'';
	echo "<li class=$class>";
	echo $access->checkHtml('display', 'link', 'Main Menu','/' );
	echo "</li>";
	
	$class = (($this->name == 'Locations' || $this->name == 'Items' || $this->name == 'Phones' || $this->name == 'Users' || $this->name == 'Roles'
			|| $this->name == 'Alerts' || $this->name == 'Approvals') && $this->action != 'triggeredAlerts' && $this->action != 'managePermissions' && $this->action != 'changePass')?'active':'';
	echo "<li class=$class>";
	echo $access->checkHtml('Locations/index', 'link', 'System Management','/locations/index' );
	echo "</li>";
	
	$class = (($this->name == 'Stats' || $this->name == 'Messagereceiveds')&& !($this->action == 'aggregatedInventory' || $this->action == 'facilityInventory'
		|| $this->action == 'aggregatedChart' || $this->action == 'triggeredAlerts' || $this->action == 'options' ))?'active':'';
	echo "<li class=$class>";
	echo $access->checkHtml('Stats/index', 'link', 'Updates and Messages','/stats/index' );
	echo "</li>";
	
	$class = ($this->name == 'Users' && $this->action == 'changePass')?'active':'';
	echo "<li class=$class>";
	echo $access->checkHtml('Users/changePass', 'link', 'Account','/users/changePass' );
	echo "</li>";
	
	$class = ($this->name == 'Roles' && $this->action == 'managePermissions')?'active':'';
	echo "<li class=$class>";
	echo $access->checkHtml('Roles/managePermissions', 'link', 'Permissions','/roles/managePermissions' );
	echo "</li>";
	
	$class = ($this->name == 'Stats' && $this->action == 'options')?'active':'';
	echo "<li class=$class>";
	echo $access->checkHtml('Stats/options', 'link', 'Options ','/stats/options' );	 */
	
	
	/* if ($this->name == 'Pages' || ($this->action == 'aggregatedInventory' || $this->action == 'facilityInventory'
		|| $this->action == 'aggregatedChart' || $this->action == 'triggeredAlerts')) {
		echo $access->checkHtml('Stats/aggregatedInventory', 'html', "<div class='secondary-menu'><ul>",'' );
		echo "<li>";
		echo $access->checkHtml('stats/facilityInventory', 'link', 'Inventory by Facility','/stats/facilityInventory' );
		echo "</li>";
		echo "<li>|</li>";
		echo "<li>";
		echo $access->checkHtml('Stats/aggregatedInventory', 'link', 'Aggregated Inventory ','/stats/aggregatedInventory' );
		echo "</li>";
		echo "<li>|</li>";
		echo "<li>";
		echo $access->checkHtml('Stats/aggregatedChart', 'link', 'Aggregated Chart','/stats/aggregatedChart' );
		echo "</li>";
		echo "<li>|</li>";
		echo "<li>";
		echo $access->checkHtml('Alerts/triggeredAlerts', 'link', 'Triggered Alerts','/alerts/triggeredAlerts' );
		echo "</li>";

		echo $access->checkHtml('Stats/aggregatedInventory', 'html', '</ul></div>','' );
	}
	
	if (($this->name == 'Locations' || $this->name == 'Items' || $this->name == 'Phones' || $this->name == 'Users' || $this->name == 'Roles'
			|| $this->name == 'Alerts' || $this->name == 'Approvals') && $this->action != 'triggeredAlerts' && $this->action != 'managePermissions' && $this->action != 'changePass') {
		echo $access->checkHtml('Locations/index', 'html', "<div class='secondary-menu'><ul>",'' );
		echo "<li>";
		echo $access->checkHtml('Locations/index', 'link', 'Facilities ','/locations/index' );
		echo "</li>";
		echo "<li>|</li>";
		echo "<li>";
		echo $access->checkHtml('Items/index', 'link', 'Items ','/items/index' );
		echo "</li>";
		echo "<li>|</li>";
		echo "<li>";
		echo $access->checkHtml('Phones/index', 'link', 'Phones ','/phones/index' );
		echo "</li>";
		echo "<li>|</li>";
		echo "<li>";
		echo $access->checkHtml('Users/index', 'link', 'Users ','/users/index' );
		echo "</li>";
		echo "<li>|</li>";
		echo "<li>";
		echo $access->checkHtml('Roles/index', 'link', 'Roles ','/roles/index' );
		echo "</li>";
		echo "<li>|</li>";
		echo "<li>";
		echo $access->checkHtml('Alerts/index', 'link', 'Alerts ','/alerts/index' );	
		echo "</li>";
		echo "<li>|</li>";
		echo "<li>";
		echo $access->checkHtml('Approvals/index', 'link', 'Approvals ','/approvals/index' );	
		echo "</li>";
			
		echo $access->checkHtml('Locations/index', 'html', '</ul></div>','' );
	}
	if (($this->name == 'Stats' || $this->name == 'Messagereceiveds')&& !($this->action == 'aggregatedInventory' || $this->action == 'facilityInventory'
		|| $this->action == 'aggregatedChart' || $this->action == 'triggeredAlerts' || $this->action == 'options')) {
		
		echo $access->checkHtml('Stats/index', 'html', "<div class='secondary-menu'><ul>",'' );
		echo "<li>";
		echo $access->checkHtml('Stats/index', 'link', 'Updates ','/stats/index' );	
		echo "</li>";
		echo "<li>|</li>";
		echo "<li>";
		echo $access->checkHtml('Messagereceiveds/index', 'link', 'Raw messages ','/messagereceiveds/index' );		
		echo "</li>";
		echo $access->checkHtml('Stats/index', 'html', '</ul></div>','' );
	}  */
?> 



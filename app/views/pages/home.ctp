<?php 
	$javascript->link('jquery.min', false); 
	$javascript->link('common', false); 
	echo $this->Html->css('map');

?>
 
<?php
	echo $crumb->getHtml('Home', 'reset' ) ;
	echo '<br /><br />' ;
?>
 

<div class="actions">
<?php 
	echo $access->checkHtml('Stats/aggregatedInventory', 'html', '<h4>Main Menu</h4><ul>','' );
?>
<?php
if (Configure::read() > 0):
	Debugger::checkSecurityKeys();
endif;
?>

<?php
	
	echo "<li>";
	echo $access->checkHtml('Stats/facilityInventory', 'link', 'Inventory by Facility','/stats/facilityInventory' );
	echo "</li>";
	
	echo "<li>";
	echo $access->checkHtml('Stats/aggregatedInventory', 'link', 'Aggregated Inventory ','/stats/aggregatedInventory' );
	echo "</li>";
	
	echo "<li>";
	echo $access->checkHtml('Stats/aggregatedChart', 'link', 'Aggregated Chart','/stats/aggregatedChart' );
	echo "</li>";
	
	echo "<li>";
	echo $access->checkHtml('Alerts/triggeredAlerts', 'link', 'Triggered Alerts','/alerts/triggeredAlerts' );
	echo "</li>";

	echo $access->checkHtml('Stats/aggregatedInventory', 'html', '</ul>','' );
	echo $access->checkHtml('Locations/view', 'html', '<br/><h4>System Management</h4><ul>','' );
		

		echo "<li>";
		echo $access->checkHtml('Locations/index', 'link', 'Facilities ','/locations/index' );
		echo "</li>";

		echo "<li>";
		echo $access->checkHtml('Items/index', 'link', 'Items ','/items/index' );
		echo "</li>";
	

		echo "<li>";
		echo $access->checkHtml('Phones/index', 'link', 'Phones ','/phones/index' );
		echo "</li>";

		echo "<li>";
		echo $access->checkHtml('Users/index', 'link', 'Users ','/users/index' );
		echo "</li>";

		echo "<li>";
		echo $access->checkHtml('Roles/index', 'link', 'Roles ','/roles/index' );
		echo "</li>";
		
		echo "<li>";
		echo $access->checkHtml('Alerts/index', 'link', 'Alerts ','/alerts/index' );	
		echo "</li>";
		
		echo "<li>";
		echo $access->checkHtml('Approvals/index', 'link', 'Approvals ','/approvals/index' );	
		echo "</li>";
		
	echo $access->checkHtml('Locations/view', 'html', '</ul>','' );
	echo $access->checkHtml('Stats/index', 'html', '<br/><h4>Updates and Messages</h4><ul>','' );
	
		echo "<li>";
		echo $access->checkHtml('Stats/index', 'link', 'Updates ','/stats/index' );	
		echo "</li>";
		
		echo "<li>";
		echo $access->checkHtml('Messagereceiveds/index', 'link', 'Raw messages ','/messagereceiveds/index' );		
		echo "</li>";
		

		
	echo $access->checkHtml('Stats/index', 'html', '</ul>','' );
		echo "<ul><li>";
		echo $access->checkHtml('Stats/options', 'link', 'Options ','/stats/options' );	
		echo "</li></ul>";
		echo "<ul><li>";
		echo $access->checkHtml('Roles/managePermissions', 'link', 'Manage Permissions ','/roles/managePermissions' );	
		echo "</li></ul>";

?>

<?php 
	if($access->check('Stats/facilityInventory') ) {
		
		//echo $this->Html->link(__('Update Points', true), '/stats/updateJSONFile' ); 
			// echo $this->Form->create('Stat', array('action' => 'updateJSONFile')); 
			 echo "<div id='update'>";
			 echo $this->element('update_j_s_o_n');

			 echo "</div>";
	}
		echo "<ul>";
		echo "<li>";
		echo $access->checkHtml('Users/changePass', 'link', 'Change Password ','/users/changePass' );	
		echo "</li></ul>";
?> 
 </div>

 <div class="main index">

  <h2><?php 
 Configure::load('options');
 $appName = Configure::read('App.name');
 $showLive = Configure::read('App.displayMode');
			
  __($appName); ?></h2>

 <?php
	echo '<br/>';
	echo '<div class="cont">';
	echo $this->GoogleMapv3->map(array('div'=>array('height'=>'600', 'width'=>'100%'), 'content' => 'Loading'));
	echo $this->Html->script($this->GoogleMapv3->apiUrl());
	$pointsJson = json_decode($this->loaded['ajax']->Form->fields['Stat.JSONFile'], TRUE);
	foreach($pointsJson['markers'] as $k => $p)
	{
		$approval_update = isset($update_times['approved'][$p['location']]) ? $this->Time->timeAgoInWords(strtotime($update_times['approved'][$p['location']])) : "";
		$latest_update = isset($update_times['non_approved'][$p['location']]) ? $this->Time->timeAgoInWords(strtotime($update_times['non_approved'][$p['location']])) : "";
		$update_html = <<<EOL
<br>
<table>
	<tr>
		<td><small>Last approved</small></td>
		<td><small>$approval_update</small></td>
	</tr>
	<tr>
		<td><small>Late updated</small></td>
		<td><small>$latest_update</small></td>
	</tr>
</table>
EOL;
		$update_html = ($approval_update!=""||$latest_update!="") ? $update_html : "";
		$options = array(
			'lng' =>$p['point']['longitude'],
			'lat' =>$p['point']['latitude'], 
			'content'=>"<span id='infoWindow'>" . $p['html'] . "</span> $update_html",
			'icon'=>$p['markerImage']
		);
		$this->GoogleMapv3->addMarker($options);
		//$this->GoogleMapv3->addInfoWindow($options);
	}
	echo  $this->GoogleMapv3->script();
    
	echo '</div>';
	
	/* $default = array('type'=>'0','zoom'=>3,'lat'=>'1.683611', 'long'=>'39.717222' );
        $points = array();
        //$json =  file_get_contents('./points.json');
        //$json = str_replace(array("\n","\r"),"",$json);
    	//$json = preg_replace('/([{,])(\s*)([^"]+?)\s*:/','$1"$3":',$json);
    	
        //$pointsJson = json_decode(file_get_contents('./points.json'), TRUE);
		//get the json formatted file from the ajax form hidden field
		$pointsJson = json_decode($this->loaded['ajax']->Form->fields['Stat.JSONFile'], TRUE);
		
        $i = 0;
		/* echo "<pre>";
        print_r($report);
		echo "</pre>"; 
        foreach($pointsJson['markers'] as $p)
		{
			$points[$i]['Point'] = array(
					'longitude' =>$p['point']['longitude'],
					'latitude' =>$p['point']['latitude'], 
						'html'=>$p['html'],
						'markerImage'=>$p['markerImage']
						);
				$i++;
		}
		
        //$points[0]['Point'] = array('longitude' =>$default['long'],'latitude' =>$default['lat'], 
       // 			'html'=>$default['html']
       // 			);
        $key = $this->GoogleMap->key;
        echo $javascript->link($this->GoogleMap->url);
        echo $this->GoogleMap->map($default,'width: 800px; height:  600px');

        //echo $this->GoogleMap->addJsonMarkers();
        echo $this->GoogleMap->addMarkers($points);
       // echo $this->GoogleMap->closeMarkerOnClick();
       // echo $this->GoogleMap->moveMarkerOnClick('StructureLongitudine','StructureLatitudine');
	  
	   */
	   
?>



</div>
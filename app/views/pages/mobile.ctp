<?php 
	$javascript->link('jquery.min', false); $javascript->link('common', false); 
	echo $this->Html->css('map');

?>
<?php
	echo $crumb->getHtml('Home', 'reset' ) ;
echo '<br /><br />' ;
?>
<div class="actions">
<?php 
	if($access->check('Stats') ) 
		echo "<h4>Main Menu</h4>"; 
?>
<?php
if (Configure::read() > 0):
	Debugger::checkSecurityKeys();
endif;
?>
<ul>
<?php 
	if($access->check('Stats/sdrugs') ) {
		echo "<li>";
		echo $this->Html->link(__('Drug Stock', true), '/stats/sdrugs'); 
		echo "</li>";
	}
	
	if($access->check('Stats/sdrugs') ) {
		echo "<li>";
		echo $this->Html->link(__('Treatments', true), '/stats/streatments'); 
		echo "</li>";
	}
	
	if($access->check('Stats/index') ){
		echo "<br/><ul>";
		echo "<h4>System Management</h4>"; //echo $this->Html->link(__('Drugs ', true), '/drugs'); 
	}
		
	if($access->check('Locations') ) {
		echo "<li>";
		echo $this->Html->link(__('Locations ', true), '/locations'); 
		echo "</li>";
	}
	if($access->check('Drugs') ) {
		echo "<li>";
		echo $this->Html->link(__('Drugs ', true), '/drugs'); 
		echo "</li>";
	}
	if($access->check('Treatments') ) {
		echo "<li>";
		echo $this->Html->link(__('Treatments ', true), '/treatments'); 
		echo "</li>";
	}
	
	if($access->check('Phones') ) {
		echo "<li>";
		echo $this->Html->link(__('Phones ', true), '/phones'); 
		echo "</li>";
	}
	if($access->check('Users') ) {
		echo "<li>";
		echo $this->Html->link(__('Users ', true), '/users'); 
		echo "</li>";
	}
	if($access->check('Groups') ) {
		echo "<li>";
		echo $this->Html->link(__('Groups ', true), '/groups'); 
		echo "</li>";
	}
	
	if($access->check('Rawreports/add') ) {
		echo "<br/><hr><br/>";
		echo "<li>";
		echo $this->Html->link(__('Raw Report ', true), '/rawreports/index'); 
		echo "</li>";
	}
	if($access->check('Stats/add') ) {
		echo "<li>";
		echo $this->Html->link(__('Report ', true), '/stats/index'); 
		echo "</li>";
	}
	if($access->check('Stats/options') ) {
		echo "<li>";
		echo $this->Html->link(__('Options', true), '/stats/options'); 
		echo "</li>";
	}
	if($access->check('Stats/index') )	
			echo "</ul>";

?>

<?php 
	if($access->check('Stats/updateJSONFile') ) {
		echo "<li>";
		//echo $this->Html->link(__('Update Points', true), '/stats/updateJSONFile' ); 
			// echo $this->Form->create('Stat', array('action' => 'updateJSONFile')); 
			 echo "<div id='update'>";
			 echo $this->element('update_j_s_o_n');

			 echo "</div>";
				
		echo "</li>";
	}
	if($access->check('Users/changePass') ) {
		echo "<li>";
		echo $this->Html->link(__('Change Password', true), '/users/changePass'); 
		echo "</li>";
	}
?>
</ul>
 
 </div>
 <div class="main index">
 <h2><?php __('NTD Drug Stocks and Treatment Tracking'); ?></h2>
 <?php
	echo '<br/>';
	$default = array('type'=>'0','zoom'=>3,'lat'=>'1.683611', 'long'=>'39.717222' );
        $points = array();
        //$json =  file_get_contents('./points.json');
        //$json = str_replace(array("\n","\r"),"",$json);
    	//$json = preg_replace('/([{,])(\s*)([^"]+?)\s*:/','$1"$3":',$json);
    	
        //$pointsJson = json_decode(file_get_contents('./points.json'), TRUE);
		//get the json formatted file from the ajax form hidden field
		$pointsJson = json_decode($this->loaded['ajax']->Form->fields['Stat.JSONFile'], TRUE);
		
        $i = 0;
        
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
?>
</div>
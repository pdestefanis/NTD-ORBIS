	<?php
		
	$fileData = $this->UpdateFile->addFileHeader(); 	

	$i = 0;
	$date = date("Y-m-d");// current date
	foreach ($locations as $loc) :
		$alarm = false;
		$globalAlarm = false;
		$has_items = (!empty($listitems[$loc['locations']['id']]))? true:false;
		$items_no_report = false;
		$site_no_report = ($has_items && ($site_report_check == 1))? $color_options[$site_report_color]:false;//if items then they can trigger so start with true
		$empty = $site_report_color;
		
		$fileData .= $this->UpdateFile->addPointHeader($i, $loc['locations']); 
		if (empty($listitems[$loc['locations']['id']]) && empty($listtreatments[$loc['locations']['id']]) )
			$fileData .= $this->UpdateFile->addCloseQuote(); 
		//get items
		if ($has_items) {
			$fileData .= $this->UpdateFile->addDrugsHeader(); 
			for ($j = 0; $j < count($listitems[$loc['locations']['id']]); $j++) { 
					//	print_r($listitems[$loc['locations']['id']][$j]['Listitems']['st']['item_id']);
						$created = $listitems[$loc['locations']['id']][$j]['Listitems']['st']["created"];
						
						$created = strtotime($created);

						//1 within time frame so no flag
						
						if(($site_report_check === 1)&& (isset($site_report_days))){
							$date_to_check = strtotime(date("Y-m-d", strtotime($date)) . " -$site_report_days days");
							if($created > $date_to_check)$site_no_report = false;
						}
						
						//one outside timeframe so flag
						if(($item_report_check === 1) && (isset($item_report_days)) && (isset($item_report_color))){
							$date_to_check = strtotime(date("Y-m-d", strtotime($date)) . " -$item_report_days days");
							if($created < $date_to_check)$items_no_report = $color_options[$item_report_color];
						}	
						
						
						if ($listitems[$loc['locations']['id']][$j]['Listitems']['st']['threshold'] == 0 && $empty == true)
							$empty = false;
						foreach($alerts as $a) {
							if ($a['Alert']['location_id'] == $loc['locations']['id'] //location match
								&& $a['Alert']['item_id'] == $listitems[$loc['locations']['id']][$j]['Listitems']['st']['item_id'] //item match
								&& (isset($a['Alert']['Alarm']) && $a['Alert']['Alarm'] == 1)) { //alarm is set we have an alert
								$alarm = true;
								$globalAlarm = true;
							}
						}
						$fileData .= $this->UpdateFile->addDrugsData($listitems[$loc['locations']['id']][$j]['Listitems'], $alarm); 
						$alarm = false;
			} 	
			//$chart = $this->element('google_graph');
			if (isset($graphURL[$loc['locations']['id']]))
				$fileData .= $this->UpdateFile->addDrugsFooter($globalAlarm, $graphURL[$loc['locations']['id']]);
			else
				$fileData .= $this->UpdateFile->addDrugsFooter($globalAlarm);
			
			if (empty($listtreatments[$loc['locations']['id']]))
				$fileData .= $this->UpdateFile->addCloseQuote(); 
		}
		//get treatments
		/* if (!empty($listtreatments[$loc['locations']['id']])) {
			$fileData .= $this->UpdateFile->addTreatmentsHeader(); 
			for ($j = 0; $j < count($listtreatments[$loc['locations']['id']]); $j++) { 
				$fileData .= $this->UpdateFile->addTreatmentsData($listtreatments[$loc['locations']['id']][$j]['Listtreatments']); 
			} 
			
			$fileData .= $this->UpdateFile->addTreatmentsFooter(); 
			$fileData .= $this->UpdateFile->addCloseQuote(); 
		} */
		
		$fileData .= $this->UpdateFile->addPointFooter($globalAlarm, $empty, $site_no_report, $items_no_report);
		$i++;
		?>
	
<?php endforeach; 
	$fileData .= $this->UpdateFile->addFileFooter();
?>


<div class="stats">
<?php echo $this->Form->create('Stat', array('action' => 'updateJSONFile')); ?>

	<?php
		echo $form->hidden('JSONFile', array('value' => $fileData));	?>

<?php echo $this->Form->end(__('', true));?>
</div>

<?php
	//$this->data['JSONFile'] = $fileData;
	//echo $this->data['JSONFile'] ;//htmlentities($fileData);
	?>
	<?php

	$fileData = $this->UpdateFile->addFileHeader(); 	

	$i = 0;

	foreach ($locations as $loc) :
		$alarm = false;
		$globalAlarm = false;
		$empty = true;
		
		$fileData .= $this->UpdateFile->addPointHeader($i, $loc['locations']); 
		if (empty($listitems[$loc['locations']['id']]) && empty($listtreatments[$loc['locations']['id']]) )
			$fileData .= $this->UpdateFile->addCloseQuote(); 
		//get items
		if (!empty($listitems[$loc['locations']['id']])) {
			$fileData .= $this->UpdateFile->addDrugsHeader(); 
			for ($j = 0; $j < count($listitems[$loc['locations']['id']]); $j++) { 
					//	print_r($listitems[$loc['locations']['id']][$j]['Listitems']['st']['item_id']);
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
		
		$fileData .= $this->UpdateFile->addPointFooter($globalAlarm, $empty);
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
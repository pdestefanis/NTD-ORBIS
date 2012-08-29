<div class="title">
	<h2><?php __('Aggregated Inventory Chart');  ?></h2>
</div>
<?php
	$rows =0;
	foreach (array_keys($report) as $loc) {
		$rows++;
		$reportHtml = "<table class=\"small\">";
		$reportHtml .= "<tr>";
		$reportHtml .= "<th>Item</th>";
		$reportHtml .= "<th>Total Quantity</th>";
		$reportHtml .= "</tr>";
		foreach ($report[$loc] as $item_id => $r) {
			
			$total_quantity = isset($r['total']) ? $r['total'] : $r['quantity'];

			
			if (isset($report[$r['parent']]))
				$parent = $report[$r['parent']][$item_id]['lname'];
			else
				$parent = null;
			//$parent = $allLocations[$r['parent']];
			$reportHtml .= "<tr><td>" . $r['icode'] . "</td>";
			$reportHtml .= "<td>" . $total_quantity . "</td></tr>";
		}
		$locs[] = array($r['lname'], $parent, $r['lname'], $reportHtml); 
		
	}
 echo $this->GoogleChart->orgChart( $rows,  //rows
 array( array('type' => 'string', 'value'=>'Name'),
 array('type' => 'string', 'value'=>'Parent'),
 //array('type' => 'string', 'value'=>'Report'),
 array('type' => 'string', 'value'=>'ToolTip')

 ),  //columns
 $locs						//values
 , 600, 800, "Facility Chart Report", ''); 
 //orgChart($rows, $columns, $values, $width, $height, $title, $hAxis)
?>


	<div class="select_display_mode index">
		<?php /*
			$radioOptions = array(
				'type'  => 'radio',
				'legend' => false,
				'label' => 'Show all data',
				'options' => array('approved'=>'Approved data only', 'all'=>'Show all data')
			);
		
			if ($showAll) 
			{
				echo "<p>These data include data that have no yet been officially approved. These data shall not be published without official approval. You can change this setting in ";
				$access->checkHtml('Stats/options', 'link', 'Options ','/stats/options' );
				echo ".</p><br>";
			} else
			{
				$radioOptions['default'] = 'approved';
			}
			
			echo $this->Form->create('displayModeSelector', array('id'=>'displayModeSelector'));
			echo $this->Form->input('displayMode', $radioOptions);
			echo <<<EOF
<div class="submit">
	<input type="submit" value="Refresh" onclick="var appSuffix=document.getElementById('DisplayModeSelectorDisplayModeAll').checked?'/all':'';window.location.href='http://'+document.domain+'/stats/aggregatedChart'+appSuffix; event.returnValue = false; return false;">
</div>

EOF;
			//echo $ajax->submit('Refresh', array('url'=> '', 'update' => 'aggregated_chart', 'loading' => '$(\'LoadingDiv\').show()', 'loaded' => '$(\'LoadingDiv\').hide()' )); 
			echo $this->Form->end();
			
		*/ ?>
		
		<?php
		
			if ($showAll) 
			{
				echo "<p>These data include data that have no yet been officially approved. These data shall not be published without official approval. You can change this setting in ";
				$access->checkHtml('Stats/options', 'link', 'Options ','/stats/options' );
				echo ".</p><br>";
			}
		
		?>

		<form accept-charset="utf-8" method="post" id="displayModeSelector" action="/display_mode_selectors/aggregatedChart">
		  <div style="display:none;">
		    <input type="hidden" value="POST" name="_method">
		  </div>
		  <div class="input radio">
		    <input type="radio" <?php echo (!$showAll ? 'checked="checked"' : ''); ?> value="approved" id="DisplayModeSelectorDisplayModeApproved" name="data[displayModeSelector][displayMode]">
		    <label for="DisplayModeSelectorDisplayModeApproved">Approved data only</label>
    
		    <input type="radio" <?php echo ($showAll ? 'checked="checked"' : ''); ?>value="all" id="DisplayModeSelectorDisplayModeAll" name="data[displayModeSelector][displayMode]">
		    <label for="DisplayModeSelectorDisplayModeAll">Show all data</label>
		  </div>
		  <div class="submit">
		    <input type="submit" onclick="var appSuffix=document.getElementById('DisplayModeSelectorDisplayModeAll').checked ?'/all':'';window.location.href='http://'+document.domain+'/stats/aggregatedChart'+appSuffix; event.returnValue = false; return false;" value="Refresh">
		  </div>
		</form>

	</div>


	

	

<div class="search">
	<?php
		echo $this->Form->create('Search', array('default'=>false) );
		echo $this->Form->input('search', array('label' => '', 'value' => $this->Form->value('search')));

		$displayModeTrackerOptions = array( 'type' => 'hidden' );
		if ($showAll) {$displayModeTrackerOptions['value'] = 'all';
		} else { $displayModeTrackerOptions['value'] = 'approved'; }
		echo $this->Form->input('displayMode', $displayModeTrackerOptions);

		echo $ajax->submit('Filter', array('url'=> '', 'update' => 'aggregated_inventory', 'loading' => '$(\'LoadingDiv\').show()', 'loaded' => '$(\'LoadingDiv\').hide()' )); 
		echo $this->Form->end();
	?>
</div>
<div class="title">
	<h2><?php __('Aggregated Inventory');  ?></h2>
</div>

	<table cellpadding="0" cellspacing="0" class="norow">
	
		<tr>
			<th><?php echo "Facility";?></th>
			<th><?php echo "Level";?></th>
			<th><?php echo "Item";?></th>
			<th><?php echo "Aggregated Quantity";?></th>
			<th><?php echo "Own Quantity";?></th>
			<th><?php echo "Total";?></th>
		</tr>

	
	
	<?php	

	if (!empty($report)) {
	$i = 1;
	foreach (array_keys($report) as $loc) :


		if (!empty($report[$loc])) {
			foreach ($report[$loc] as $item_id => $r) { 

				$class = ($i++ % 2 != 0) ? ' class=\'altrow\'' : ' class=\'norow\'';

				$item_name  = isset($r['iname'])      ? $r['iname']      : $r['name'];
				$level      = isset($r['level'])      ? $r['level']      : intval($r['depth'])-1;
				$aggregated = isset($r['aggregated']) ? $r['aggregated'] : 0;
				$aggregated = isset($r['aggregate_items'][$item_id]) ? $r['aggregate_items'][$item_id]['quantity'] : $aggregated;


				$local_quantity = isset($r['own'])                   ? $r['own'] : 0;
				$local_quantity = isset($r['local_items'][$item_id]) ? $r['local_items'][$item_id]['quantity'] : $local_quantity;
				$total_quantity = isset($r['total'])                 ? $r['total'] : $r['quantity'];

				if ($this->Form->value('search') != ''  && (stripos($r['lname'], $this->Form->value('search')) === FALSE
						&& stripos($item_name, $this->Form->value('search')) === FALSE 
						&& stripos($r['icode'], $this->Form->value('search')) === FALSE 
						/* && $r['aggregated'] <= $this->Form->value('search')
						&& $r['own'] <= $this->Form->value('search')  */
						) )
					continue;
			?>
				<tr <?php echo $class;?>>
					
					<td><?php 
						echo $access->checkHtml('Locations/view', 'text', str_repeat("-", $level) . $r['lname'], '/locations/view/' . $loc);
						?>&nbsp;</td>
					<td><?php echo $level ?>&nbsp;</td>
					<td><?php 
						echo $access->checkHtml('Items/view', 'text', $item_name, '/items/view/' . $item_id); ?>&nbsp;</td>
					<td class='number'><?php echo $aggregated; ?>&nbsp;</td>
					<td class='number'><?php echo $local_quantity; ?>&nbsp;</td>
					<td class='number'><?php echo $total_quantity; ?>&nbsp;</td>
					
				</tr>
		<?php } 
		}
		
	endforeach;
	}	
		
	?> </table> 

<br>
<div class="select_display_mode">
	<?php
		$radioOptions = array(
			'type'  => 'radio',
			'legend' => false,
			'label' => 'Show all data',
			'options' => array('approved'=>'Approved data only', 'all'=>'Show all data')
		);
		
		if ($showAll) 
		{
			$radioOptions['default'] = 'all';
			echo '<p>These data include data that have no yet been officially approved. These data shall not be published without official approval.</p><br>';
		} else
		{
			$radioOptions['default'] = 'approved';
		}
		echo $this->Form->create('displayModeSelector', array('id'=>'displayModeSelector'));
		echo $this->Form->input('displayMode', $radioOptions);
		echo $ajax->submit('Refresh', array('url'=> '', 'update' => 'aggregated_inventory', 'loading' => '$(\'LoadingDiv\').show()', 'loaded' => '$(\'LoadingDiv\').hide()' )); 
		echo $this->Form->end();
	?>
</div>


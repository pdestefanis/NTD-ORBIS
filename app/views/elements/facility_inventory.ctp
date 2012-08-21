<div class="search">
	<?php
	
		echo $this->Form->create('Search', array('default'=>false) );
		echo $this->Form->input('search', array('label' => '', 'value' => $this->Form->value('search')));

		$displayModeTrackerOptions = array( 'type' => 'hidden' );
		if ($showAll) {$displayModeTrackerOptions['value'] = 'all';
		} else { $displayModeTrackerOptions['value'] = 'approved'; }
		echo $this->Form->input('displayMode', $displayModeTrackerOptions);

		echo $ajax->submit('Filter',  array('url'=> '', 'update' => 'facility_inventory', 'loading' => '$(\'LoadingDiv\').show()', 'loaded' => '$(\'LoadingDiv\').hide()' )); 
		echo $this->Form->end();
	?>
</div>

<div class="title">
	<h2><?php __('Inventory by Facility');  ?></h2>
</div>

	
<table cellpadding="0" cellspacing="0" class="norow">

	<tr>
		<th><?php echo "Facility";?></th>
		<th><?php echo "Upstream Facility";?></th>
		<th><?php echo "Item";?></th>
		<th><?php echo "Quantity";?></th>
		<th><?php echo "Last Report";?></th>
	</tr>



<?php	
$i = 1;
if (!empty($report)) {
foreach (array_keys($report) as $loc) :


	if (!empty($report[$loc])) {

		foreach ($report[$loc] as $k => $r) {

			$class = ($i++ % 2 != 0) ? ' class=\'altrow\'' :  ' class=\'norow\'';

			$item_name      = isset($r['iname'])    ? $r['iname']    : $r['name']; 
			$item_id        = isset($r['iid'])      ? $r['iid']      : $k;
			$local_quantity = isset($r['own'])      ? $r['own']      : $r['quantity'];

			if ($local_quantity == 0)
				continue;

			$when_updated   = isset($r['screated']) ? $r['screated'] : $r['last_updated'];
			$last_stat      = isset($r['sid'])      ? $r['sid']      : $r['last_stat'];
			

			?>
			<tr <?php echo $class;?>>
				
				<td><?php 
					echo $access->checkHtml('Locations/view', 'text', $r['lname'], '/locations/view/' . $loc );
					//echo $this->Html->link($r['lname'], array('controller' => 'locations', 'action' => 'view', $loc)); ?>&nbsp;</td>
				<td><?php 
					if ($r['parent'] != 0)
						echo $access->checkHtml('Locations/view', 'text', $allLocations[$r['parent']], '/locations/view/' . $r['parent'] );
						//echo $this->Html->link($allLocations[$r['parent']], array('controller' => 'locations', 'action' => 'view', $r['parent'])); ?>&nbsp;</td>
				<td><?php 
					echo $access->checkHtml('Items/view', 'text', $item_name, '/items/view/' . $item_id );
				?>&nbsp;</td>
				<td class='number'><?php echo $local_quantity; ?>&nbsp;</td>
				<td><?php echo $this->Html->link($when_updated, array('controller' => 'stats', 'action' => 'view', $last_stat)); ?>&nbsp;</td>
				
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
			'options' => array('all'=>'Show all data', 'approved'=>'Approved data only')
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
		echo $ajax->submit('Refresh', array('url'=> '', 'update' => 'facility_inventory', 'loading' => '$(\'LoadingDiv\').show()', 'loaded' => '$(\'LoadingDiv\').hide()' )); 
		echo $this->Form->end();
	?>
</div>


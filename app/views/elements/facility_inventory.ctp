	<div class="search">
	<?php	echo $this->Form->create('Search', array('default'=>false) );?>
		<?php
			echo $this->Form->input('search', array('label' => '', 'value' => $this->Form->value('search')));
		?>
	<?php  
		echo $ajax->submit('Filter', array('url'=> '', 'update' => 'facility_inventory', 'loading' => '$(\'LoadingDiv\').show()', 'loaded' => '$(\'LoadingDiv\').hide()' )); 
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
	
		$class = ' class=\'norow\'';
		if ($i++ % 2 != 0) {
			$class = ' class=\'altrow\'';
		} 
	
		if (!empty($report[$loc])) {

			foreach ($report[$loc] as $r) { 
				if ($r['own'] == 0)
					continue;
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
						echo $access->checkHtml('Items/view', 'text', $r['iname'], '/items/view/' . $r['iid'] );
					?>&nbsp;</td>
					<td class='number'><?php echo $r['own']; ?>&nbsp;</td>
					<td><?php echo $this->Html->link($r['screated'], array('controller' => 'stats', 'action' => 'view', $r['sid'])); ?>&nbsp;</td>
					
				</tr>
		<?php } 
		}
		
	endforeach;
		
	}
	?> </table> 
	<?php




	?>

<div class="search">
<?php	echo $this->Form->create('Search', array('default'=>false) );?>
	<?php
		echo $this->Form->input('search', array('label' => '', 'value' => $this->Form->value('search')));
	?>
<?php  
	echo $ajax->submit('Filter', array('url'=> '', 'update' => 'aggregated_inventory', 'loading' => '$(\'LoadingDiv\').show()', 'loaded' => '$(\'LoadingDiv\').hide()' )); 
?>
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
		
		$class = ' class=\'norow\'';
		if ($i++ % 2 != 0) {
			$class = ' class=\'altrow\'';
		} 
	
		if (!empty($report[$loc])) {
			foreach ($report[$loc] as $item_id => $r) { 
				$item_name  = isset($r['iname'])      ? $r['iname']      : $r['name'];
				$level      = isset($r['level'])      ? $r['level']      : $r['depth'];
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
						echo $access->checkHtml('Locations/view', 'text', str_pad("", $level, "-", STR_PAD_LEFT) . $r['lname'], '/locations/view/' . $loc);
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
	<?php




	?>
	</table>

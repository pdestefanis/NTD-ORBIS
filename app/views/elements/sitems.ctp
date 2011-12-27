	<!-- <div class="search"> -->
	<div class="title">
	<h2><?php __('Aggregated Inventory');  ?></h2>
	<?php	//echo $this->Form->create('Search');?>
	<?php
		//echo $this->Form->input('search', array('label' => ''));
	?>
<?php //echo $this->Form->end(__('Submit', true)); 
	//echo $ajax->submit('Filter', array('url' => '' , 'update' => 'sitems')); 
?>
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
	$i = 1;
	foreach (array_keys($report) as $loc) :
	
		$class = ' class=\'norow\'';
		if ($i++ % 2 != 0) {
			$class = ' class=\'altrow\'';
		} 
	
		if (!empty($report[$loc])) {

			foreach ($report[$loc] as $r) { ?>
				<tr <?php echo $class;?>>
					
					<td><?php 
						echo $access->checkHtml('Locations/view', 'text', str_pad("", $r['level'], "-", STR_PAD_LEFT) . $r['lname'], '/locations/view/' . $loc);
						?>&nbsp;</td>
					<td><?php echo $r['level'] ?>&nbsp;</td>
					<td><?php 
						echo $access->checkHtml('Items/view', 'text', $r['iname'], '/items/view/' . $r['iid']); ?>&nbsp;</td>
					<td class='number'><?php echo $r['aggregated']; ?>&nbsp;</td>
					<td class='number'><?php echo $r['own']; ?>&nbsp;</td>
					<td class='number'><?php echo $r['total']; ?>&nbsp;</td>
					
				</tr>
		<?php } 
		}
		
	endforeach;
		
		
	?> </table> 
	<?php




	?>
	</table>

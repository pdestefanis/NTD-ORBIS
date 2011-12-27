	<div class="search">
	<h2><?php __('Drug Stocks Status');  ?></h2>
	<?php	echo $this->Form->create('Search');?>
	<?php
		echo $this->Form->input('search', array('label' => ''));
	?>
<?php //echo $this->Form->end(__('Submit', true)); 
	echo $ajax->submit('Filter', array('url' => '' , 'update' => 'sdrug')); 
?>
</div>
<?php 
	if (empty($listdrugs)) {
		echo "Search didn't match any fields";
	} else {
?>
	
	<table cellpadding="0" cellspacing="0" class="norow">
	
		<tr>
			<th><?php echo "Location";?></th>
			<th><?php echo "Drug";?></th>
			<th><?php echo "Quantity";?></th>
			<th><?php echo "Report received on";?></th>
			<th><?php echo "Phone";?></th>
	</tr>

	
	
	<?php	

	$i = 1;
	foreach ($locations as $loc) :
	
		$class = ' class=\'norow\'';
		if ($i++ % 2 != 0) {
			$class = ' class=\'altrow\'';
		} 
	
		if (!empty($listdrugs[$loc['locations']['id']])) {

			for ($j = 0; $j < count($listdrugs[$loc['locations']['id']]); $j++) { ?>
				<tr <?php echo $class;?>>
					
					<td><?php 
						if ($loc['locations']['deleted'] == 0)
						echo $this->Html->link($loc['locations']['name'], array('controller' => 'locations', 'action' => 'view', $loc['locations']['id'])); 
						else
							echo 'Deleted: ' .  $loc['locations']['name'];
						?>&nbsp;</td>
					<td ><?php echo $this->Html->link($listdrugs[$loc['locations']['id']][$j]['drugs']['dname'], array('controller' => 'drugs', 'action' => 'view', $listdrugs[$loc['locations']['id']][$j]['drugs']['did'])); ?>&nbsp;</td>
					<td><?php 
						if($access->check('Rawreports/index') ) {
							echo $this->Html->link($listdrugs[$loc['locations']['id']][$j]['stat_drugs']['quantity'], array('controller' => 'rawreports', 'action' => 'view', $listdrugs[$loc['locations']['id']][$j]['stat_drugs']['rawreport_id']));
						} else {
							echo $listdrugs[$loc['locations']['id']][$j]['stat_drugs']['quantity'];
						}
						?>&nbsp;</td>
					<td><?php 
						if($access->check('Rawreports/index') ) {
							echo $this->Html->link($listdrugs[$loc['locations']['id']][$j]['stat_drugs']['created'], array('controller' => 'rawreports', 'action' => 'view', $listdrugs[$loc['locations']['id']][$j]['stat_drugs']['rawreport_id']));
						} else {
							echo $listdrugs[$loc['locations']['id']][$j]['stat_drugs']['created'];
						}
						?>&nbsp;</td>
					<td><?php 
						if($access->check('Phones/index') ) {
							if ($listdrugs[$loc['locations']['id']][$j]['phones']['pdeleted'] == 0)
							echo $this->Html->link($listdrugs[$loc['locations']['id']][$j]['phones']['pname'], array('controller' => 'phones', 'action' => 'view', $listdrugs[$loc['locations']['id']][$j]['stat_drugs']['pid'])); 
							else
								echo 'Deleted: ' .  $listdrugs[$loc['locations']['id']][$j]['phones']['pname'];
						} else {
							echo $listdrugs[$loc['locations']['id']][$j]['phones']['pname'];
						}
						?>&nbsp;</td>
				</tr>
		<?php } 
		}
		
	endforeach;
}
	?>
	</table>

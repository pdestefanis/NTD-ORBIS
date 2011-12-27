<?php
echo $crumb->getHtml('Triggered Alerts', null, '' ) ;
echo '<br /><br />' ;

?> 

<div class="alerts index">
	<h2><?php __('Triggered Alerts');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			
			<th>Facility</th>
			<th>Item</th>
			<th>Condition</th>
			<th>Quantity</th>
			<th>Date Triggered</th>
			
	</tr>
	<?php
	$i = 0;
	foreach ($alerts as $alert):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		if (isset($alert['Alert']['Alarm']) && $alert['Alert']['Alarm'] == 1) {
	?>
	<tr<?php echo $class;?>>
		
		<td><?php 
			$access->checkHtml('Locations/view', 'text', $alert['Location']['name'], '/locations/view/' . $alert['Location']['id'] );
			?>&nbsp;</td>
		<td><?php 
			$access->checkHtml('Items/view', 'text', $alert['Item']['name'], '/items/view/' . $alert['Item']['id'] );
			 ?>&nbsp;</td>
		<td><?php 
			if ($alert['Alert']['conditions'] == 1)
				echo $access->checkHtml('Alerts/view', 'text',  'Above', '/alerts/view/' .  $alert['Alert']['id']);
			if ($alert['Alert']['conditions'] == 2)
				echo $access->checkHtml('Alerts/view', 'text',  'Below', '/alerts/view/' .  $alert['Alert']['id']);
			if ($alert['Alert']['conditions'] == 3)
				 echo $access->checkHtml('Alerts/view', 'text',  'At', '/alerts/view/' .  $alert['Alert']['id']);
			?>&nbsp;</td>
		<td><?php echo $alert['Alert']['threshold']; ?>&nbsp;</td>
		<td><?php echo $access->checkHtml('Stats/view', 'text', $alert['Alert']['triggered'], '/stats/view/' . $alert['Alert']['sid'] ); ?>&nbsp;</td>
		
	</tr>
<?php 
		}
	endforeach; ?>
	</table>
	

</div>
<div class="actions">
	
</div>

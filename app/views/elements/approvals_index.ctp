
	
<h2><?php __('Approvals');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr><?php
	echo "
			<th>".__('Facility',1)."</th>
			<th>".__('Level',1)."</th>
			<th>".__('Approver',1)."</th>
			<th>".__('Item',1)."</th>
			<th>".__('Current Total Quantity',1)."</th>
			<th>".__('Total Approved Quantity',1)."</th>
			<th>".__('Last Update',1)."</th>
			<th>".__('Last Approval',1)."</th>
		";	?>
	</tr>
	<?php
	$i = 0;
	foreach ($approved as $location_id => $location):
		foreach ($location as $item_id => $item):

			$row_class = ($i++ % 2) ? ' class="altrow"' : ' class="norow"';

			$facility    = $item['lname'];
			$depth       = $item['depth'];
			$item_name   = $item['name'];

			$approved_quantity = $item['quantity'];
			$total_quantity    = $all[$location_id][$item_id]['quantity'];
			$approver          = isset($item['approver']) ? $item['approver'] : "";

			$last_updated      = $all[$location_id][$item_id]['last_updated'];
			$last_approval     = isset($approved[$location_id][$item_id]) ? $approved[$location_id][$item_id]['last_approval'] : "";

		?>
		<tr<?php echo $row_class;?>>
			<td><?php echo $facility; ?></td>
			<td><?php echo $depth; ?></td>
			<td><?php echo $approver; ?></td>
			<td><?php echo $item_name; ?></td>
			<td><?php echo $total_quantity; ?></td>
			<td><?php echo $approved_quantity; ?></td>
			<td><?php echo $last_updated; ?></td>
			<td><?php echo $last_approval; ?></td>

		</tr>
<?php endforeach; endforeach; ?>
	</table>

</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link("Pending", array("controller" => "approvals", "action" => "pending")); ?></li>
	</ul>
</div>

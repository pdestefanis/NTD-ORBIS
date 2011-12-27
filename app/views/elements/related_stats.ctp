	
	<?php 
	if($access->check('Stats/view') ) {
		?> <h3><?php __('Related Updates');?></h3> 
		<?php 
		if (!empty($item['Stat']) || !empty($messagereceived['Stat']) || !empty($phone['Stat']) || !empty($user['Stat'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Quantity'); ?></th>
		<th><?php __('Facility'); ?></th>
		<th><?php __('User'); ?></th>
		<th><?php __('Raw Message'); ?></th>

	</tr>
	<?php
		$i = 0;
	if (!empty($item['Stat'])) {
		foreach ($item['Stat'] as $stat) {
			if (!in_array($stat['location_id'], $userLocations ))
				continue;
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>

			<td><?php 
				echo $access->checkHtml('Stats/view', 'text', $stat['quantity'], '/stats/view/' . $stat['id'] );
				?></td>
			<td><?php if (!empty($locations[$stat['location_id']])) 
					echo $access->checkHtml('Locations/view', 'text', $locations[$stat['location_id']], '/locations/view/' . $stat['location_id'] );
				else echo 'Location deleted.'; ?></td>
			<td><?php 
			if (empty($stat['phone_id']))  //user
				echo $access->checkHtml('Users/view', 'text', $users[$stat['user_id']], '/users/view/' . $stat['user_id'] );
			else {
				if (!empty($phones[$stat['phone_id']])) 
					echo $access->checkHtml('Phones/view', 'text', $phones[$stat['phone_id']], '/phones/view/' . $stat['phone_id'] );
				else 
					echo 'Phone deleted.'; 
			}	
			?></td>
			<td><?php 
				echo $access->checkHtml('Messagereceiveds/view', 'text', $stat['messagereceived_id'], '/messagereceiveds/view/' . $stat['messagereceived_id'] );
				?>
		</tr>
<?php }
	}
	if (!empty($messagereceived['Stat'])) {
		foreach ($messagereceived['Stat'] as $stat) {
			if (!in_array($stat['location_id'], $userLocations ))
				continue;
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>

			<td><?php 
				echo $access->checkHtml('Stats/view', 'text', $stat['quantity'], '/stats/view/' . $stat['id'] );
				?></td>
			<td><?php if (!empty($locations[$stat['location_id']])) 
					echo $access->checkHtml('Locations/view', 'text', $locations[$stat['location_id']], '/locations/view/' . $stat['location_id'] );
				else echo 'Location deleted.'; ?></td>
			<td><?php 
			if (empty($stat['phone_id']))  //user
				echo $access->checkHtml('Users/view', 'text', $users[$stat['user_id']], '/users/view/' . $stat['user_id'] );
			else {
				if (!empty($phones[$stat['phone_id']])) 
					echo $access->checkHtml('Phones/view', 'text', $phones[$stat['phone_id']], '/phones/view/' . $stat['phone_id'] );
				else 
					echo 'Phone deleted.'; 
			}	
			?></td>
			<td><?php 
				echo $access->checkHtml('Messagereceiveds/view', 'text', $stat['messagereceived_id'], '/messagereceiveds/view/' . $stat['messagereceived_id'] );
				?>
		</tr>
	<?php }
	}
	
	if (!empty($phone['Stat'])) {
		foreach ($phone['Stat'] as $stat) {
			if (!in_array($stat['location_id'], $userLocations ))
				continue;
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		
		<tr<?php echo $class;?>>

			<td><?php 
				echo $access->checkHtml('Stats/view', 'text', $stat['quantity'], '/stats/view/' . $stat['id'] );
				?></td>
			<td><?php if (!empty($locations[$stat['location_id']])) 
					echo $access->checkHtml('Locations/view', 'text', $locations[$stat['location_id']], '/locations/view/' . $stat['location_id'] );
				else echo 'Location deleted.'; ?></td>
			<td><?php 
			if (empty($stat['phone_id']))  //user
				echo $access->checkHtml('Users/view', 'text', $users[$stat['user_id']], '/users/view/' . $stat['user_id'] );
			else {
				if (!empty($phones[$stat['phone_id']])) 
					echo $access->checkHtml('Phones/view', 'text', $phones[$stat['phone_id']], '/phones/view/' . $stat['phone_id'] );
				else 
					echo 'Phone deleted.'; 
			}	
			?></td>
			<td><?php 
				echo $access->checkHtml('Messagereceiveds/view', 'text', $stat['messagereceived_id'], '/messagereceiveds/view/' . $stat['messagereceived_id'] );
				?>
		</tr>
	<?php }
	}
	
	if (!empty($user['Stat'])) {
		
		foreach ($user['Stat'] as $stat) {
			if (!in_array($stat['location_id'], $userLocations ))
				continue;
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		
		<tr<?php echo $class;?>>

			<td><?php 
				echo $access->checkHtml('Stats/view', 'text', $stat['quantity'], '/stats/view/' . $stat['id'] );
				?></td>
			<td><?php if (!empty($locations[$stat['location_id']])) 
					echo $access->checkHtml('Locations/view', 'text', $locations[$stat['location_id']], '/locations/view/' . $stat['location_id'] );
				else echo 'Location deleted.'; ?></td>
			<td><?php 
				echo $access->checkHtml('Users/view', 'text', $user['User']['name'], '/users/view/' . $stat['user_id'] );
			?></td>
			<td><?php 
				echo "Site update";
				?>
		</tr>
	<?php }
	}?>
	</table>
<?php endif; 
}
?>
<?php
echo $crumb->getHtml('Viewing Approval', null, '' ) ;
echo '<br /><br />' ;
?> 
<div class="approvals view">
<h2><?php  __('Approval');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Message'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				echo $access->checkHtml('Messagereceiveds/view', 'text', $approval['Messagereceived']['rawmessage'], '/messagereceiveds/view/' . $approval['Messagereceived']['id'] );
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				echo $access->checkHtml('Users/view', 'text', $approval['User']['username'], '/users/view/' . $approval['User']['id'] );
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $approval['Approval']['created']; ?>
			&nbsp;
		</dd>
	</dl>
	<br/>
	<div class='help'>
		You can only view approval records for your facilities. If any of your facilities are present in this approval message they will be listed below
	</div>

	<?php //__('The following quantities have been approved:');?>
	<br/>
	
	<?php 
	if (!empty($approval['Stat'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		
		<th><?php __('Facility'); ?></th>
		<th class="actions"><?php __('Item');?></th>
		<th class="actions"><?php __('Quantity');?></th>
		<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($approval['Stat'] as $stat):
			if (!isset($locations[$stat['location_id']]))
				continue;
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			
			<td><?php echo $locations[$stat['location_id']];?></td>
			<td><?php echo $items[$stat['item_id']];?></td>
			<td><?php echo $stat['quantity_after'];?></td>
			
			<td class="actions">
				<?php echo $this->Html->link(__('View', true), array('controller' => 'stats', 'action' => 'view', $stat['id'])); ?>
				
			</td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>
</div>



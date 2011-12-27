<div class="messagereceiveds view">
<h2><?php  __('Received Message');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($messagereceived['Phone']['name'], array('controller' => 'phones', 'action' => 'view', $messagereceived['Phone']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $messagereceived['Messagereceived']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Rawmessage'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $messagereceived['Messagereceived']['rawmessage']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Approvals');?></h3>
	<?php if (!empty($messagereceived['Approval'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('User'); ?></th>
		<th><?php __('Created'); ?></th>
		
	</tr>
	<?php
		$i = 0;
		foreach ($messagereceived['Approval'] as $approval):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php 
			echo $approval['user_id'];?></td>
			<td><?php 
					echo $access->checkHtml('approvals/view', 'link', $approval['created'],'/approvals/view/' . $approval['id']  );
				//echo $approval['created'];
				?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>
<div class="related">
	<h3><?php __('Related Sent Messages');?></h3>
	<?php if (!empty($messagereceived['Messagesent'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Phone'); ?></th>
		<th><?php __('Created'); ?></th>
		<th><?php __('Message'); ?></th>
		<!-- <th class="actions"><?php __('Actions');?></th> -->
	</tr>
	<?php
		$i = 0;
		foreach ($messagereceived['Messagesent'] as $messagesent):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php echo $messagereceived['Phone']['name'];
			//echo $messagesent['phone_id'];?></td>
			<td><?php echo $messagesent['created'];?></td>
			<td><?php 
				echo $access->checkHtml('Messagesents/view', 'link', $messagesent['rawmessage'],'/messagesents/view/' . $messagesent['id'] );
				?></td>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>

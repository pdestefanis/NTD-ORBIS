<div class="messagesents index">
	<h2><?php __('Message Sent');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo 'Message Received';?></th>
			<th><?php echo $this->Paginator->sort('phone_id');?></th>
						<th><?php echo $this->Paginator->sort('rawmessage');?></th>
			<th><?php echo $this->Paginator->sort('created');?></th>


	</tr>
	<?php
	$i = 0;
	foreach ($messagesents as $messagesent):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php 
				echo $access->checkHtml('Messagereceiveds/view', 'text',  $messagesent['Messagereceived']['rawmessage'], '/messagereceiveds/view/' .  $messagesent['Messagereceived']['id']);
			?>
		</td>
		<td>
			<?php 
				echo $access->checkHtml('Phones/view', 'text',  $messagesent['Phone']['name'], '/phones/view/' .  $messagesent['Phone']['id']);
			?>
		</td>
		<td><?php 
				echo $access->checkHtml('Messagesents/view', 'text',  $messagesent['Messagesent']['rawmessage'], '/messagesents/view/' .  $messagesent['Messagesent']['id']);
			?>&nbsp;</td>
		
		<td><?php echo $messagesent['Messagesent']['created']; ?>&nbsp;</td>
		
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	
</div>
<div class="messagereceiveds form">
<?php echo $this->Form->create('Messagereceived');?>
	<fieldset>
 		<legend><?php __('Add Messagereceived'); ?></legend>
	<?php
		echo $this->Form->input('phone_id');
		echo $this->Form->input('rawmessage');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Messagereceiveds', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Phones', true), array('controller' => 'phones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phone', true), array('controller' => 'phones', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Approvals', true), array('controller' => 'approvals', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Approval', true), array('controller' => 'approvals', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Messagesents', true), array('controller' => 'messagesents', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Messagesent', true), array('controller' => 'messagesents', 'action' => 'add')); ?> </li>
	</ul>
</div>
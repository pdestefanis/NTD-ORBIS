<div class="messagesents form">
<?php echo $this->Form->create('Messagesent');?>
	<fieldset>
		<legend><?php __('Add Messagesent'); ?></legend>
	<?php
		echo $this->Form->input('messagereceived_id');
		echo $this->Form->input('phone_id');
		echo $this->Form->input('rawmessage');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Messagesents', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Messagereceiveds', true), array('controller' => 'messagereceiveds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Messagereceived', true), array('controller' => 'messagereceiveds', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Phones', true), array('controller' => 'phones', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Phone', true), array('controller' => 'phones', 'action' => 'add')); ?> </li>
	</ul>
</div>
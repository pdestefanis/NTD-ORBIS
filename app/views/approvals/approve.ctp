<?php
echo $crumb->getHtml('New Approval', null, '' ) ;
echo '<br /><br />' ;
?> 
<div class="approvals form">
<?php echo $this->Form->create('Approval');?>
	<fieldset>
 		<legend><?php __('Add Approval'); ?></legend>
	<?php
		echo $this->Form->input('messagereceived_id');
		echo $this->Form->input('user_id');
		echo $this->Form->input('Stat');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('List Approvals', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Messagereceiveds', true), array('controller' => 'messagereceiveds', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Messagereceived', true), array('controller' => 'messagereceiveds', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Users', true), array('controller' => 'users', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New User', true), array('controller' => 'users', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Stats', true), array('controller' => 'stats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Stat', true), array('controller' => 'stats', 'action' => 'add')); ?> </li>
	</ul>
</div>
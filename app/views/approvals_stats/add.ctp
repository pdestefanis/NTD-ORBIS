<div class="approvalsStats form">
<?php echo $this->Form->create('ApprovalsStat');?>
	<fieldset>
 		<legend><?php __('Add Approvals Stat'); ?></legend>
	<?php
		echo $this->Form->input('approval_id');
		echo $this->Form->input('stat_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>

		<li><?php echo $this->Html->link(__('List Approvals Stats', true), array('action' => 'index'));?></li>
		<li><?php echo $this->Html->link(__('List Approvals', true), array('controller' => 'approvals', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Approval', true), array('controller' => 'approvals', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Stats', true), array('controller' => 'stats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Stat', true), array('controller' => 'stats', 'action' => 'add')); ?> </li>
	</ul>
</div>
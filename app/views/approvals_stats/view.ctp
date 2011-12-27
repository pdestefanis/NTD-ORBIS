<div class="approvalsStats view">
<h2><?php  __('Approvals Stat');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $approvalsStat['ApprovalsStat']['id']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Approval'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($approvalsStat['Approval']['id'], array('controller' => 'approvals', 'action' => 'view', $approvalsStat['Approval']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Stat'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($approvalsStat['Stat']['id'], array('controller' => 'stats', 'action' => 'view', $approvalsStat['Stat']['id'])); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('Edit Approvals Stat', true), array('action' => 'edit', $approvalsStat['ApprovalsStat']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('Delete Approvals Stat', true), array('action' => 'delete', $approvalsStat['ApprovalsStat']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $approvalsStat['ApprovalsStat']['id'])); ?> </li>
		<li><?php echo $this->Html->link(__('List Approvals Stats', true), array('action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Approvals Stat', true), array('action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Approvals', true), array('controller' => 'approvals', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Approval', true), array('controller' => 'approvals', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Stats', true), array('controller' => 'stats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Stat', true), array('controller' => 'stats', 'action' => 'add')); ?> </li>
	</ul>
</div>

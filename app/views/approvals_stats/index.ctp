<div class="approvalsStats index">
	<h2><?php __('Approvals Stats');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('id');?></th>
			<th><?php echo $this->Paginator->sort('approval_id');?></th>
			<th><?php echo $this->Paginator->sort('stat_id');?></th>
			<th class="actions"><?php __('Actions');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($approvalsStats as $approvalsStat):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $approvalsStat['ApprovalsStat']['id']; ?>&nbsp;</td>
		<td>
			<?php echo $this->Html->link($approvalsStat['Approval']['id'], array('controller' => 'approvals', 'action' => 'view', $approvalsStat['Approval']['id'])); ?>
		</td>
		<td>
			<?php echo $this->Html->link($approvalsStat['Stat']['id'], array('controller' => 'stats', 'action' => 'view', $approvalsStat['Stat']['id'])); ?>
		</td>
		<td class="actions">
			<?php echo $this->Html->link(__('View', true), array('action' => 'view', $approvalsStat['ApprovalsStat']['id'])); ?>
			<?php echo $this->Html->link(__('Edit', true), array('action' => 'edit', $approvalsStat['ApprovalsStat']['id'])); ?>
			<?php echo $this->Html->link(__('Delete', true), array('action' => 'delete', $approvalsStat['ApprovalsStat']['id']), null, sprintf(__('Are you sure you want to delete # %s?', true), $approvalsStat['ApprovalsStat']['id'])); ?>
		</td>
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
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $this->Html->link(__('New Approvals Stat', true), array('action' => 'add')); ?></li>
		<li><?php echo $this->Html->link(__('List Approvals', true), array('controller' => 'approvals', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Approval', true), array('controller' => 'approvals', 'action' => 'add')); ?> </li>
		<li><?php echo $this->Html->link(__('List Stats', true), array('controller' => 'stats', 'action' => 'index')); ?> </li>
		<li><?php echo $this->Html->link(__('New Stat', true), array('controller' => 'stats', 'action' => 'add')); ?> </li>
	</ul>
</div>
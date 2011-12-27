<?php
	echo $crumb->getHtml('Roles', null, '' ) ;
	echo '<br /><br />' ;
?>
<div class="roles index">
	<h2><?php __('Roles');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<!--<th><?php echo $this->Paginator->sort('id');?></th>-->
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo 'Users';?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($roles as $role):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php echo $access->checkHtml('Roles/view', 'text', $role['Role']['name'], '/roles/view/' . $role['Role']['id'] ); ?>&nbsp;</td>
		<td><?php echo $count[$role['Role']['id']] ?>&nbsp;</td>
	
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
	<?php 
	echo $access->checkHtml('Roles/add', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php 
		$access->checkHtml('Roles/add', 'link', 'New Role','add/'  ); ?></li>
	</ul>
</div>

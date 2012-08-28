<?php
	echo $crumb->getHtml('Role Details', null, 'auto') ;
	echo '<br /><br />';
?>
<div class="roles view">
<h2><?php  __('Role Details');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<!--<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $role['Role']['id']; ?>
			&nbsp;
		</dd>
		-->
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $role['Role']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $role['Role']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $role['Role']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<?php 
	echo $access->checkHtml('Roles/edit', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php echo $access->checkHtml('Roles/edit', 'link', 'Edit','edit/' . $role['Role']['id'] ); ?></li>
		<li><?php echo $access->checkHtml('Roles/delete', 'delete', 'Delete','delete/' . $role['Role']['id'], 'delete', $role['Role']['name'] ); ?></li>
	</ul>
</div>
<div class="related">
	<h3><?php __('Related Users');?></h3>
	<?php if (!empty($role['User'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<th><?php __('Username'); ?></th>
		<th><?php __('Created'); ?></th>
	</tr>
	<?php
		$i = 0;
		foreach ($role['User'] as $user):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<td><?php 
				echo $access->checkHtml('Users/view', 'text', $user['username'], '/users/view/' . $user['id'] );
			?></td>	
			<td><?php 
				echo $user['created'];
			?></td>	
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

</div>

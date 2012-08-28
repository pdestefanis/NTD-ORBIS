<div id="main">
<?php echo $javascript->link('prototype', false); ?>
<?php
	echo $crumb->getHtml('User Details', null, 'auto') ;
	echo '<br /><br />';
?>
<div class="users view">
<h2><?php  __('User Details');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<!--<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['id']; ?>
			&nbsp;
		</dd>-->
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Username'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['username']; ?>
			&nbsp;
		</dd>
		<!--<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Password'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['password']; ?>
			&nbsp;
		</dd>-->
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Role'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				if (!empty($user['Role']))
					echo "Primary Role:</br>";
				echo $access->checkHtml('Roles/view', 'text', $user['FirstRole']['name'], '/roles/view/' . $user['FirstRole']['id'] ); 
				if (!empty($user['Role'])) {
					echo "</br></br>Other roles:</br>";
					foreach ($user['Role'] as $role) {
						echo $access->checkHtml('Roles/view', 'text', $role['name'], '/roles/view/' . $role['id']);
						echo "</br>";
					}
				}
			 ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Location'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				echo $access->checkHtml('Locations/view', 'text', $user['Location']['name'], '/locations/view/' . $user['Location']['id'] );
			 ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Modified'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $user['User']['modified']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<?php 
	echo $access->checkHtml('Users/edit', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php echo $access->checkHtml('Users/edit', 'link', 'Edit','edit/' . $user['User']['id']); ?> </li>
		<li><?php echo $access->checkHtml('Users/delete', 'delete', 'Delete','delete/' . $user['User']['id'], 'delete', $user['User']['username'] ); 
		?></li>

	</ul>
</div>
<div class="related">
<?php echo $this->Form->create('Config', array('action' => 'view/' . $user['User']['id']));
		$v = $ajax->remoteFunction(array('url' => 'view/' . $user['User']['id'], 'update' => 'main', 'with' => 'Form.serialize(this.form)')); 
		echo $this->Form->input('limit', array('label' => 'Display limit', 'options' => array('10' => 10,'20' => 20,'50' => 50, '100' => 100), 'default' => 20, 'onChange' => $v));
		echo $this->Form->end(__('', true));
	?>
</div>	

<div class="related">
<?php echo $this->element('related_stats'); ?>

</div>

</div>

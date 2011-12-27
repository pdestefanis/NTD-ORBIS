<?php
	echo $crumb->getHtml('Edit Role', null, 'auto') ;
	echo '<br /><br />';
?>
<div class="roles form">
<?php echo $this->Form->create('Role');?>
	<fieldset>
 		<legend><?php __('Edit Role'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<?php 
	echo $access->checkHtml('Roles/delete', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php echo $access->checkHtml('Roles/delete', 'delete', 'Delete','delete/' . $this->Form->value('Role.id'), 'delete', $this->Form->value('Role.name') ); ?></li>
	</ul>
</div>

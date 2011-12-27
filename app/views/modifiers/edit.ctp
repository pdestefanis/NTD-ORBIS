<?php
echo $crumb->getHtml('Edit Modifier', null, 'auto' ) ;
echo '<br /><br />' ;
?> 
<div class="locations form">
<?php echo $this->Form->create('Modifier');?>
	<fieldset>
 		<legend><?php __('Edit Modifier'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $access->checkHtml('Modifiers/delete', 'delete', 'Delete','delete/' . $this->Form->value('Modifier.id'), 'delete', $this->Form->value('Modifier.name') ); ?></li>
	</ul>
</div>

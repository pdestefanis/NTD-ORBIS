<?php
	echo $crumb->getHtml('Add Role', null, 'auto') ;
	echo '<br /><br />';
?>
<div class="groups form">
<?php echo $this->Form->create('Role');?>
	<fieldset>
 		<legend><?php __('Add Role'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

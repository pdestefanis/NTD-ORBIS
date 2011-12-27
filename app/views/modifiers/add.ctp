<?php
echo $crumb->getHtml('Add Modifier', null, 'auto' ) ;
echo '<br /><br />' ;
?> 

<div class="locations form">
<?php echo $this->Form->create('Modifier');?>
	<fieldset>
 		<legend><?php __('Add Modifier'); ?></legend>
	<?php
		echo $this->Form->input('name');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

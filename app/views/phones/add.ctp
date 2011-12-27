<?php
echo $crumb->getHtml('Add Phone',  null, 'auto' ) ;
echo '<br /><br />' ;
?>
<div class="phones form">
<?php echo $this->Form->create('Phone');?>
	<fieldset>
 		<legend><?php __('Add Phone'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('phonenumber');
		//echo $this->Form->input('active');
		echo $this->Form->radio('active', array('1' => 'Yes', '0' => 'No'), null, array('value' => '1'));
		echo $this->Form->input('location_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

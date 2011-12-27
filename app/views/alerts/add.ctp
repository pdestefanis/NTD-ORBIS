<?php
echo $crumb->getHtml('Add Alert', null, 'auto' ) ;
echo '<br /><br />' ;
?> 

<div class="alerts form">
<?php echo $this->Form->create('Alert');?>
	<fieldset>
 		<legend><?php __('Add Alert'); ?></legend>
	<?php
		echo $this->Form->input('location_id');
		echo $this->Form->input('item_id');
		echo $this->Form->input('threshold');
		echo $this->Form->input('conditions', array('label' => 'Condition', 'options' => array(1 => 'Above', 2 => 'Below', 3 => 'At') ));
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

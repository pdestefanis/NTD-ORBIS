<?php echo $javascript->link('prototype', false); ?>

<?php
	echo $crumb->getHtml('New Update', null, 'auto' ) ;
	echo '<br /><br />' ;
?> 

<div class="stats form">
<?php echo $this->Form->create('Stat');?>
	<fieldset>
 		<legend><?php __('New Update'); ?></legend>
	<?php
		echo $this->Form->input('modifier_id');
		echo $this->Form->input('quantity');
		echo $this->Form->input('item_id', array('empty' => '---Select---'));
		
		//echo $this->Form->input('rawreport_id');
		echo $this->Form->input('user_id', array('empty' => '---Select---'));
		echo $this->Form->input('location_id', array('empty' => 'Please select user above', 'label' => 'Facility') );
				
		$updatesel = 'update_facility_select' ;
		$options = array('url' => $updatesel, 'update' => 'StatLocationId');
		echo $ajax->observeField('StatUserId', $options);
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

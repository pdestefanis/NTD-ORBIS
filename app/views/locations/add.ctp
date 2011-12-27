<?php
echo $crumb->getHtml('Add Facility', null, 'auto' ) ;
echo '<br /><br />' ;
?> 

<div class="locations form">
<?php echo $this->Form->create('Location');?>
	<fieldset>
 		<legend><?php __('Add Facility'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('shortname');
		echo $this->Form->input('locationLatitude', array('label' => 'Latitude'));
		echo $this->Form->input('locationLongitude',  array('label' => 'Longitude'));
		echo $this->Form->input('parent_id', array('label' => 'Parent'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

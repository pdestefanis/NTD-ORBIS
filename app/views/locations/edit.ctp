<?php
echo $crumb->getHtml('Edit Facility', null, 'auto' ) ;
echo '<br /><br />' ;
?> 
<div class="locations form">
<?php echo $this->Form->create('Location');?>
	<fieldset>
 		<legend><?php __('Edit Facility'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('shortname');
		
		echo $this->Form->input('locationLatitude', array('label' => 'Latitude'));
		echo $this->Form->input('locationLongitude',  array('label' => 'Longitude'));
		echo $this->Form->input('parent_id', array('label' => 'Parent'));
		//print_r($this->Form);
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $access->checkHtml('Locations/delete', 'delete', 'Delete','delete/' . $this->Form->value('Location.id'), 'delete', $this->Form->value('Location.name') ); ?></li>
	</ul>
</div>

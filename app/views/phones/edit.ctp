<?php
echo $crumb->getHtml('Edit Phone',  null, 'auto' ) ;
echo '<br /><br />' ;
?>
<div class="phones form">
<?php echo $this->Form->create('Phone');?>
	<fieldset>
 		<legend><?php __('Edit Phone'); ?></legend>
	<?php
		//echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('phonenumber');
		//echo $this->Form->input('active');
		if (isset($this->passedArgs[1]) && $this->passedArgs[1] == 1)
			echo $this->Form->hidden('deleted');
		echo $this->Form->radio('active', array('1' => 'Active', '0' => 'Inactive'), null, array('value' => $this->Form->value('active')));
		echo $this->Form->input('location_id');
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<?php 
	echo $access->checkHtml('Phones/delete', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>

		<li>
		<?php echo $access->checkHtml('Phones/delete', 'delete', 'Delete','delete/' . $this->Form->value('Phone.id'), 'delete', $this->Form->value('Phone.name') ); ?></li>
		
	</ul>
</div>

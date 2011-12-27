<?php
	echo $crumb->getHtml('Add User', null, 'auto') ;
	echo '<br /><br />';
?>
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Add User'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('username');
		echo $this->Form->input('password');
		echo $form->input('confirm_passwd', array('type' => 'password', 'label' => 'Confirm Password'));
		echo $this->Form->radio('active', array('1' => 'Yes', '0' => 'No'),array('default' => '1'));
		
		//echo $form->label('User.confirm_passwd', 'Confirm password');
    		//echo $form->password('User.confirm_passwd', array('size' => '10') ); 
		echo $this->Form->input('reach', array('options' => array (0 => 'Current only', 1 => '1 up', 2 => '2 up', 3 => '3 up', 4 => '4 up')));
		echo $this->Form->input('location_id');
		echo $this->Form->input('phone_id', array('empty' => '---Select---'));
		echo $form->input('role_id', array('label' => 'Primary role'));
		echo $form->input('Role', array('label' => 'Other roles', 'empty' => '---None---'));
		
		
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

<?php
	echo $crumb->getHtml('Edit User', null, 'auto') ;
	echo '<br /><br />';
?>
<div class="users form">
<?php echo $this->Form->create('User');?>
	<fieldset>
 		<legend><?php __('Edit User'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('username');
		?><div class='help'>
<?php echo __("Only enter the password and password confirmation fields if you would like to change the password. Otherwise leave the fields empty",true);?>
</div>
<?php
		echo $this->Form->input('password');
		echo $form->input('confirm_passwd', array('type' => 'password', 'label' => 'Confirm Password'));
		echo $this->Form->radio('active', array('1' => 'Active', '0' => 'Inactive'), null, array('value' => $this->Form->value('active')));
		echo $this->Form->input('reach', array('options' => array (0 => 'Current only', 1 => '1 up', 2 => '2 up', 3 => '3 up', 4 => '4 up')));
		echo $this->Form->input('location_id');
		echo $this->Form->input('phone_id', array('empty' => '---Select---'));
		echo $form->input('role_id', array('label' => 'Primary role'));
		echo $form->input('Role', array('label' => 'Other roles', 'empty' => '---None---'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<?php 
	echo $access->checkHtml('Users/delete', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>

		<li><?php echo $access->checkHtml('Users/delete', 'delete', 'Delete','delete/' . $this->Form->value('User.id'), 'delete', $this->Form->value('User.username') ); 
		?></li>

	</ul>
</div>

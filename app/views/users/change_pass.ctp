<?php	
	echo $crumb->getHtml('Change Password', null, 'auto') ;	
	echo '<br /><br />';?><div class="users form">
	<?php 
		echo $this->Form->create('User');?>	
		<fieldset> 		<legend><?php __('Change password for: ' .  $this->Form->value('username')); ?></legend>	
		
		<?php		
			echo $this->Form->hidden('username');		
			echo $this->Form->input('password');		
			echo $form->input('confirm_passwd', array('type' => 'password', 'label' => 'Confirm Password'));			
			echo $this->Form->hidden('group_id');					
			
		?>	
		</fieldset>
		<?php echo $this->Form->end(__('Submit', true));?></div>
<div class="messagesents view">
<h2><?php  __('Message Sent');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Message received'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php  
				echo $access->checkHtml('Messagereceiveds/view', 'text',  $messagesent['Messagereceived']['rawmessage'], '/messagereceiveds/view/' .  $messagesent['Messagereceived']['id']);
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php  
				echo $access->checkHtml('Phones/view', 'text',  $messagesent['Phone']['name'], '/phones/view/' .  $messagesent['Phone']['id']);
				?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Rawmessage'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $messagesent['Messagesent']['rawmessage']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $messagesent['Messagesent']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>

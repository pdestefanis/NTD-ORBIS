<?php
echo $crumb->getHtml('Viewing alerts', null, 'auto' ) ;
echo '<br /><br />' ;

?> 
<div class="alerts view">
<h2><?php  __('Alert');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<!--
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $alert['Alert']['id']; ?>
			&nbsp;
		</dd>
		-->
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Facility'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $alert['Location']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Item'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $alert['Item']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Condition'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				if ($alert['Alert']['conditions'] == 1)
					echo 'Above';
				if ($alert['Alert']['conditions'] == 2)
					echo 'Below';
				if ($alert['Alert']['conditions'] == 3)
					 echo  'At';
				
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Threshold'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $alert['Alert']['threshold']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('User'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $alert['User']['username']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Created'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $alert['Alert']['created']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<?php 
	echo $access->checkHtml('Alerts/edit', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php echo $access->checkHtml('Alerts/edit', 'link', 'Edit Alert','edit/' . $alert['Alert']['id'] ); ?></li>
		<li><?php echo $access->checkHtml('Alerts/delete', 'delete', 'Delete','delete/' . $alert['Alert']['id'], 'delete', $alert['Alert']['item_id'] ); ?></li>
	</ul>
</div>


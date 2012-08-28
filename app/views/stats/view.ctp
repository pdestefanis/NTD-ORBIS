<?php
echo $crumb->getHtml('Update Details', null, 'auto' ) ;
echo '<br /><br />' ;

?> 
<div class="stats view">
<h2><?php  __('Update Details');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>>
			<?php if ($stat['Item']['id'] != 0 && $stat['Item']['id'] != null){ ?>
				<?php __('Quantity'); ?></dt>
				<?php } else  {?>
					<?php __('People'); ?></dt>
			<?php } ?>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $stat['Stat']['quantity']; ?>
			&nbsp;
		</dd>
		
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Report received on'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $stat['Stat']['created']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Item'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($stat['Item']['name'], array('controller' => 'items', 'action' => 'view', $stat['Item']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Message Received'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $this->Html->link($stat['Messagereceived']['rawmessage'], array('controller' => 'messagereceiveds', 'action' => 'view', $stat['Messagereceived']['id'])); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phone'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
		
			<?php
				if ($stat['Phone']['deleted'] == 0 )
					echo $this->Html->link($stat['Phone']['name'], array('controller' => 'phones', 'action' => 'view', $stat['Phone']['id']));
				else
					echo 'Deleted: ' .  $stat['Phone']['name'];
				?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Facility'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
	
			<?php
				if ($stat['Location']['deleted'] == 0 )
					echo $this->Html->link($stat['Location']['name'], array('controller' => 'phones', 'action' => 'view', $stat['Location']['id']));
				else
					echo 'Deleted: ' .  $stat['Location']['name'];
				?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<?php 
	echo $access->checkHtml('Stats/edit', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php echo $access->checkHtml('Stats/edit', 'link', 'Edit Update','edit/' . $stat['Stat']['id'] ); ?> </li>
		<li><?php echo $access->checkHtml('Stats/delete', 'delete', 'Delete','delete/' .  $stat['Stat']['id'], 'delete',  $stat['Stat']['quantity'] ); ?></li>	
	</ul>

</div>

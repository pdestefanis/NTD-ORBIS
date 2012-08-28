<?php
echo $crumb->getHtml('Modifier Details', null, 'auto' ) ;
echo '<br /><br />' ;

?> 
<div class="modifiers view">
<h2><?php  __('Modifier Details');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<!--
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $modifier['Modifier']['id']; ?>
			&nbsp;
		</dd>
		-->
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $modifier['Modifier']['name']; ?>
			&nbsp;
		</dd>
		
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $access->checkHtml('Modifiers/edit', 'link', 'Edit Modifier','edit/' . $modifier['Modifier']['id'] ); ?></li>
		<li><?php echo $access->checkHtml('Modifiers/delete', 'delete', 'Delete','delete/' . $modifier['Modifier']['id'], 'delete', $modifier['Modifier']['name'] ); ?></li>
	</ul>
</div>
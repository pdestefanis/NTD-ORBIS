<div id="main">
<?php echo $javascript->link('prototype', false); ?>
<?php
echo $crumb->getHtml('Viewing Item', null, 'auto' ) ;
echo '<br /><br />' ;

?> 

<div class="items view">
<h2><?php  __('Item');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<!--<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['id']; ?>
			&nbsp;
		</dd>
		-->
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Code'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['code']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Units'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Item']['units']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Category'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php 
				echo ($item['Item']['category'] == 1? 'Drug':($item['Item']['category'] == 2? 'Treatment': 'Not set')); 
			?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Default Modifier'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $item['Modifier']['name']; ?>
			&nbsp;
		</dd>
	</dl>
	<br/>
	

</div>
<div class="actions">
	<?php 
		echo $access->checkHtml('Items/edit', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php echo $access->checkHtml('Items/edit', 'link', 'Edit Item','edit/' . $item['Item']['id'] ); ?></li>
		<li><?php echo $access->checkHtml('Items/delete', 'delete', 'Delete','delete/' . $item['Item']['id'], 'delete', $item['Item']['code'] ); ?></li>
		
		
		
				
	</ul>
</div>

<div class="related">
<?php echo $this->Form->create('Config', array('action' => 'view/' . $item['Item']['id']));
		$v = $ajax->remoteFunction(array('url' => 'view/' . $item['Item']['id'], 'update' => 'main', 'with' => 'Form.serialize(this.form)')); 
		echo $this->Form->input('limit', array('label' => 'Display limit', 'options' => array('10' => 10,'20' => 20,'50' => 50, '100' => 100), 'default' => 20, 'onChange' => $v));
		echo $this->Form->end(__('', true));
	?>
<?php echo $this->element('related_stats'); ?>

</div>

</div>

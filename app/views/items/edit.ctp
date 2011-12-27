<?php
echo $crumb->getHtml('Editing item', null, 'auto' ) ;
echo '<br /><br />' ;
//echo $html->link('View Drug', 'view') ;
?> 
<div class="drugs form">
<?php echo $this->Form->create('Item');?>
	<fieldset>
 		<legend><?php __('Edit Item'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('name');
		echo $this->Form->input('code');
		echo $this->Form->input('units');
		echo $this->Form->input('category', array('options' => array('1' => 'Drug', '2' => 'Treatment'), 'empty' => '---Select---', 'label' => 'Category'));
		echo $this->Form->input('modifier_id', array('empty' => '---Select---'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	<?php 
		echo $access->checkHtml('Items/delete', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>

		<li><?php echo $access->checkHtml('Items/delete', 'delete', 'Delete','delete/' . $this->Form->value('Item.id'), 'delete', $this->Form->value('Item.code') ); ?></li>
		
				
	</ul>
</div>

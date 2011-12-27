<?php
echo $crumb->getHtml('Edit Alert', null, 'auto' ) ;
echo '<br /><br />' ;
?> 
<div class="alerts form">
<?php echo $this->Form->create('Alert');?>
	<fieldset>
 		<legend><?php __('Edit Alert'); ?></legend>
	<?php
		echo $this->Form->input('id');
		echo $this->Form->input('location_id');
		echo $this->Form->input('item_id');
		echo $this->Form->input('threshold');
		echo $this->Form->input('conditions', array('label' => 'Condition', 'options' => array(1 => 'Above', 2 => 'Below', 3 => 'At') ));

	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
		<?php 
	echo $access->checkHtml('Alerts/delete', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php echo $access->checkHtml('Alerts/delete', 'delete', 'Delete','delete/' . $this->Form->value('Alert.id'), 'delete', $this->Form->value('Item.name') ); ?></li>
	</ul>
</div>

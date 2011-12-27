<?php
echo $crumb->getHtml('Add Item', null, 'auto' ) ;
echo '<br /><br />' ;

?> 
<div class="drugs form">
<?php echo $this->Form->create('Item');?>
	<fieldset>
 		<legend><?php __('Add Item'); ?></legend>
	<?php
		echo $this->Form->input('name');
		echo $this->Form->input('code');
		echo $this->Form->input('units');
		echo $this->Form->input('category', array('options' => array('1' => 'Drug', '2' => 'Treatment'), 'empty' => '---Select---', 'label' => 'Category'));
		echo $this->Form->input('modifier_id', array('empty' => '---Select---'));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>

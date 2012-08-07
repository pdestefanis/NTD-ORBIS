<?php
echo $crumb->getHtml('Options',  null, 'auto' ) ;
echo '<br /><br />' ;
?>
<div class="phones form">
<?php echo $this->Form->create('Stat', array('action' => 'options'));?>
	<fieldset>
 		<legend><?php __('Options'); ?></legend>
	<?php
		echo $this->Form->input('ndigits', array('label' => 'Last n digits of phone number to consider', 
				'value' =>  $this->Form->value('ndigits') ));
		echo $this->Form->hidden('ndigitsOld', array('value' =>  $this->Form->value('ndigitsOld') ));
		echo $this->Form->input('limit', array('label' => 'Month limit on graph reports', 
				'value' =>  $this->Form->value('limit') ));
		echo $this->Form->input('threshold', array('label' => 'Report warning threshold', 
				'value' =>  $this->Form->value('threshold') ));
		echo $this->Form->input('appName', array('label' => 'Application Name', 
				'value' =>  $this->Form->value('appName') ));
		echo $this->Form->input('displayLive', array(
				'options' => array( "0" => "Approved", 
														"1" => "Live"),
				'legend' => 'Data Display Mode',
				'value'  => $this->Form->value('displayLive'),
				'type'   => 'radio'
		));
	?>
	</fieldset>
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	
</div>
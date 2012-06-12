<?php

echo $javascript->link(array('jquery','colorpicker', 'eye', 'utils'), false);	
echo $crumb->getHtml('Options',  null, 'auto' ) ;
echo '<br /><br />' ;
?>
<script type="text/javascript">
$(document).ready(function() {

});
</script>
<div class="phones form">
<?php echo $this->Form->create('Stat', array('action' => 'options'));?>
	<fieldset>
 		<legend><?php __('General Options'); ?></legend>
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
		echo $this->Form->input('seperators', array('label' => 'List of Seperators', 
				'value' =>  $this->Form->value('seperators') ));	
		echo $this->Form->input('avail_colors', array('label' => 'Available Map Icon Colors', 
				'value' =>  $this->Form->value('avail_colors') ));
	?>
	</fieldset>
	<fieldset>
 		<legend><?php __('Site Report Options'); ?></legend>
		<?php
			echo $this->Form->input('site_report_check', array('type' => 'checkbox', 'label' => 'Mark sites which have not sent reports for any item?','value' =>  $this->Form->value('site_report_check') ));
			echo $this->Form->input('site_report_days', array('label' => 'Number of days without reports', 
					'value' =>  $this->Form->value('site_num_days'), 'size' => 3 ));
			
			$attributes = array('label' => 'Mark site with color' );
			echo $this->Form->select('site_report_color', $color_options, $this->Form->value('site_report_color'), $attributes);
		?>
	</fieldset>	
	<fieldset>
 		<legend><?php __('Item Report Options'); ?></legend>
		<?php
			echo $this->Form->input('item_report_check', array('type' => 'checkbox', 'label' => 'Mark sites which have not sent reports for every item they track?','value' =>  $this->Form->value('item_report_check') ));
			echo $this->Form->input('item_report_days', array('label' => 'Number of days without reports', 
					'value' =>  $this->Form->value('item_report_days'), 'size' => 3 ));
			$attributes = array('label' => 'Mark site with color' );
			echo $this->Form->select('item_report_color', $color_options, $this->Form->value('item_report_color'), $attributes);		
		?>
	</fieldset>	
<?php echo $this->Form->end(__('Submit', true));?>
</div>
<div class="actions">
	
</div>
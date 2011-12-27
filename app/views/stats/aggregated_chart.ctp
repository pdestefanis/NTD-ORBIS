<div id="sitems">
<?php echo $javascript->link('prototype', false); ?>
<?php
	echo $crumb->getHtml('Aggregated Inventory Chart', null, '' ) ;
	echo '<br /><br />' ;
?> 
		
		
<div class="drugs index">
	<?php  echo $this->element('google_chart'); ?>
</div>
</div>
<div id="LoadingDiv" style="display:none;"><img src="../img/ajax-loader.gif" alt="" /></div>

<?php echo $javascript->link('prototype', false); ?>
<div id="aggregated_chart">
	<?php
		echo $crumb->getHtml('Aggregated Inventory Chart', null, '' ) ;
		echo '<br /><br />' ;
	?> 
		
	<div class="drugs index">
		<?php  echo $this->element('aggregated_chart'); ?>
	</div>

</div>

</div>
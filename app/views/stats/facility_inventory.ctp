<div id="LoadingDiv" style="display:none;">
		<img src="../img/ajax-loader.gif" alt="" /></div>
<div id="facility_inventory">
<?php echo $javascript->link('prototype', false); ?>
<?php
	echo $crumb->getHtml('Inventory by facility', null, '' ) ;
	echo '<br /><br />' ;
?> 
		
		
<div class="inventory index">
	<?php echo $this->element('facility_inventory'); ?>
</div>
</div>
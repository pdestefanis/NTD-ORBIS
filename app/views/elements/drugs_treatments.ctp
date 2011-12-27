<script type="text/javascript">
//<![CDATA[
    jQuery(document).ready(function($){
	$('.flash_success').animate({opacity: 1.0}, 3000).fadeOut();
});
//]]>
</script>
	<table cellpadding="0" cellspacing="0">
	<tr>
	<td><?php 
		//$drugstreatments = $this->requestAction('treatments/edit');
		$i = 0;
		if (!empty($drugstreatments[0]['Treatment']))
			echo "Drugs included in " . $drugstreatments[0]['Treatment']['code'];
		else 
			echo "This treatment does not contain any drugs.";
		?>&nbsp;</td> <td> </td> 
		
		<?php
		foreach ($drugstreatments as $drugstreatment):
			$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	</tr>
	<tr<?php echo $class;?>>
		<td><?php
		echo $this->Html->link($drugstreatment['Drug']['name'] . ", " . $drugstreatment['Drug']['presentation'], array('controller' => 'drugs', 'action' => 'view', $drugstreatment['Drug']['id']));	
		
		?>
		</td>
		<td class="actions">
			<?php 
			echo $ajax->link(__('Delete', true), array('controller' => 'drugs_treatments', 'action' => 'delete',$drugstreatment['DrugsTreatment']['id']), array('update' => 'drugList'), sprintf(__('Are you sure you want to delete %s?', true), $drugstreatment['Drug']['name'])); ?>
		</td>
	</tr>
<?php endforeach; ?>
	</table>
	

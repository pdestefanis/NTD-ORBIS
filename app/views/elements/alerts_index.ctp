<div class="search">
	<?php	echo $this->Form->create('Search', array('default'=>false) );?>
		<?php
			echo $this->Form->input('search', array('label' => '', 'value' => isset($this->passedArgs[0])?$this->passedArgs[0]:$this->Form->value('search')));
			$paginator->options(array('url' => 
					(($this->Form->value('search') =='')?
						(isset($this->passedArgs[0])?$this->passedArgs[0]:$this->Form->value('search'))
						:$this->Form->value('search'))
					)
				); 
		?>
	<?php  
		echo $ajax->submit('Filter', array('url'=> '', 'update' => 'update', 'loading' => '$(\'LoadingDiv\').show()', 'loaded' => '$(\'LoadingDiv\').hide()' ));  
	?>
</div>
	
<h2><?php __('Alerts');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			
			<th><?php echo $this->Paginator->sort('Facility', 'Location.name');?></th>
			<th><?php echo $this->Paginator->sort('Item', 'Item.name');?></th>
			<th><?php echo $this->Paginator->sort('conditions');?></th>
			<th><?php echo $this->Paginator->sort('threshold');?></th>

	</tr>
	<?php
	$i = 0;
	foreach ($alerts as $alert):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		
		<td><?php echo $access->checkHtml('Locations/view', 'text', $alert['Location']['name'], '/locations/view/' . $alert['Location']['id'] ); ?>&nbsp;</td>
		<td><?php echo $access->checkHtml('Items/view', 'text',  $alert['Item']['name'], '/items/view/' .  $alert['Item']['id'] ); ?>&nbsp;</td>
		<td><?php 
		
		if ($alert['Alert']['conditions'] == 1)
			echo $access->checkHtml('Alerts/view', 'text',  'Above', '/alerts/view/' .  $alert['Alert']['id']);
		if ($alert['Alert']['conditions'] == 2)
			echo $access->checkHtml('Alerts/view', 'text',  'Below', '/alerts/view/' .  $alert['Alert']['id']);
		if ($alert['Alert']['conditions'] == 3)
			 echo $access->checkHtml('Alerts/view', 'text',  'At', '/alerts/view/' .  $alert['Alert']['id']);
			 ?>&nbsp;</td>
		<td><?php echo $alert['Alert']['threshold']; ?>&nbsp;</td>
		
	</tr>
<?php endforeach; ?>
	</table>
	<p>
	<?php
	echo $this->Paginator->counter(array(
	'format' => __('Page %page% of %pages%, showing %current% records out of %count% total, starting on record %start%, ending on %end%', true)
	));
	?>	</p>

	<div class="paging">
		<?php echo $this->Paginator->prev('<< ' . __('previous', true), array(), null, array('class'=>'disabled'));?>
	 | 	<?php echo $this->Paginator->numbers();?>
 |
		<?php echo $this->Paginator->next(__('next', true) . ' >>', array(), null, array('class' => 'disabled'));?>
	</div>
</div>
<div class="actions">
	<?php 
	echo $access->checkHtml('Alerts/add', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php 
		$access->checkHtml('Alerts/add', 'link', 'New Alert','add/'  ); ?></li>
	</ul>
</div>

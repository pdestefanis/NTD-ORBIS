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
	
	<h2><?php __('Facilities');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<!--<th><?php echo $this->Paginator->sort('id');?></th>-->
			<th><?php echo $this->Paginator->sort('Facility','name');?></th>
			<th><?php echo 'Level';?></th>
			<th><?php echo $this->Paginator->sort('shortname');?></th>
			<th><?php echo $this->Paginator->sort('Upstream Facility', 'Parent.name');?></th>
			<th><?php echo 'Location';?></th>
	</tr>
	<?php
	$i = 0;
	
	foreach ($locations as $location):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<!--<td><?php echo $location['Location']['id']; ?>&nbsp;</td>-->
		<td><?php echo $access->checkHtml('Locations/view', 'text', $location['Location']['name'], '/locations/view/' . $location['Location']['id'] ); ?>&nbsp;</td>
		<td><?php echo $levels[$location['Location']['id']]; ?>&nbsp;</td>
		<td><?php echo $location['Location']['shortname']; ?>&nbsp;</td>
		<td><?php 
			if (isset($parents[$location['Location']['parent_id']]))
				echo $access->checkHtml('Locations/view', 'text', $parents[$location['Location']['parent_id']], '/locations/view/' . $location['Location']['parent_id'] );
			?>&nbsp;</td>
		<td><?php $access->checkHtml('Locations/view', 'text', $location['Location']['locationLatitude'] .", ". $location['Location']['locationLongitude'], '/locations/view/' . $location['Location']['id'] ); ?>&nbsp;</td>
		<td class="actions">
		</td>
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
	echo $access->checkHtml('Locations/add', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php 
		$access->checkHtml('Locations/add', 'link', 'New Facility','add/'  ); ?></li>
	</ul>
	
</div>

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
	
<h2><?php __('Phones');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<!--<th><?php echo $this->Paginator->sort('id');?></th>-->
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('phonenumber');?></th>
			<th><?php echo $this->Paginator->sort('Facility','Location.name');?></th>
			<th><?php echo $this->Paginator->sort('active');?></th>
			<th><?php echo 'Last Report';?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($phones as $phone):
		
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<!--<td><?php echo $phone['Phone']['id']; ?>&nbsp;</td>-->
		<td><?php $access->checkHtml('Phones/view', 'text', $phone['Phone']['name'], '/phones/view/' . $phone['Phone']['id'] ); ?>&nbsp;</td>
		<td><?php echo $phone['Phone']['phonenumber']; ?>&nbsp;</td>
		
		<td>
			<?php echo $access->checkHtml('Locations/view', 'text', $phone['Location']['name'], '/locations/view/' . $phone['Location']['id'] );  ?>
		</td>
		<td><?php echo ($phone['Phone']['active']?'Yes':'No'); ?>&nbsp;</td>
		<td><?php  $access->checkHtml('Stats/view', 'text', $stats[$phone['Phone']['id']]['created'], '/stats/view/' . $stats[$phone['Phone']['id']]['sid'] ); ; ?>&nbsp;</td>

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
	echo $access->checkHtml('Phones/add', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php 
		$access->checkHtml('Phones/add', 'link', 'New Phone','add/'  ); ?></li>
	</ul>
</div>
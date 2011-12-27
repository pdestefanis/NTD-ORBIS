<div class="search">
	<?php	echo $this->Form->create('Search', array('default'=>false) );?>
		<?php
			echo $this->Form->input('search', array('label' => '', 'value' => $this->Form->value('search')));
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
	
<h2><?php __('Raw Messages');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<!--<th><?php echo $this->Paginator->sort('id');?></th> -->
			<th><?php echo $this->Paginator->sort('Raw Message', 'rawmessage');?></th>
			<th><?php echo $this->Paginator->sort('User', 'phone_id');?></th>
			<th><?php echo $this->Paginator->sort('Date', 'created');?></th>
	</tr>
	<?php
	$i = 0;
	
	foreach ($messagereceiveds as $messagereceived):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td><?php 
			echo $access->checkHtml('Messagereceiveds/view', 'text',  $messagereceived['Messagereceived']['rawmessage'], '/messagereceiveds/view/' .  $messagereceived['Messagereceived']['id']);
		?>&nbsp;</td>
		<td>
			<?php
				if ($messagereceived['Phone']['deleted'] == 0 )
					echo $access->checkHtml('Phones/view', 'text',  $messagereceived['Phone']['name'], '/phones/view/' .  $messagereceived['Phone']['id']); 
				else
					echo 'Deleted: ' . ($messagereceived['Phone']['name']);
				?>
		</td>
		<td><?php 
			if (isset($stats[$messagereceived['Messagereceived']['id']]))
				echo $access->checkHtml('Stats/view', 'text',  $messagereceived['Messagereceived']['created'], '/stats/view/' .  $stats[$messagereceived['Messagereceived']['id']]);
			else if (isset($messagesents[$messagereceived['Messagereceived']['id']]))	
				echo $access->checkHtml('Messagesents/view', 'text',  $messagereceived['Messagereceived']['created'], '/messagesents/view/' .  $messagesents[$messagereceived['Messagereceived']['id']]);
			else 		
				echo $messagereceived['Messagereceived']['created'];
			
			?>&nbsp;</td>
			
		
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
	echo $access->checkHtml('Messagereceiveds/add', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php 
		$access->checkHtml('Messagereceiveds/add', 'link', 'New Raw Message','add/'  ); ?></li>
	</ul>
</div>

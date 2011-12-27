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
	
<h2><?php __('Approvals');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Message', 'rawmessage');?></th>
			<th><?php echo $this->Paginator->sort('User', 'User.name');?></th>
			<th><?php echo $this->Paginator->sort('Date', 'created');?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($approvals as $approval):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
		/* if (isset($prev) && $prev == $approval['Approval']['id'])
			continue;
		$prev = $approval['Approval']['id']; */
	?>
	<tr<?php echo $class;?>>
		
		<td>
			<?php 
				echo $access->checkHtml('Approvals/view', 'text', $approval['Messagereceived']['rawmessage'], '/approvals/view/' . $approval['Approval']['id'] );
			 ?>
		</td>
		<td>
			<?php 
				echo $access->checkHtml('Users/view', 'text', $approval['User']['name'], '/users/view/' . $approval['User']['id'] );
			?>
		</td>
		<td>
			<?php echo $approval['Approval']['created']; ?>
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
	<h3><?php //__('Actions'); ?></h3>
	<ul>
		
	</ul>
</div>
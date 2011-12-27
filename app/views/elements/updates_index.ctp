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
	<h2><?php __('Updates');?></h2>
	
	<table cellpadding="0" cellspacing="0">
	<tr>
			<th><?php echo $this->Paginator->sort('Facility', 'Location.name');?></th>
			<th><?php echo 'User';?></th>
			<th><?php echo $this->Paginator->sort('Item', 'Item.name');?></th>
			<th><?php echo $this->Paginator->sort('Update');?></th>
			<th><?php echo $this->Paginator->sort('Date','created');?></th>
			<th><?php echo 'Code';?></th>
	</tr>
	<?php
	$i = 0;
	foreach ($stats as $stat):
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php
				if ($stat['Location']['deleted'] == 0 )
					echo $access->checkHtml('Locations/view', 'text', $stat['Location']['name'], '/locations/view/' . $stat['Location']['id'] );
				else
					echo 'Deleted: ' . ($stat['Location']['name']);
				?>
		</td>
		<td>
			<?php
				if (empty($stat['Messagereceived']['id'])) //user
					echo $access->checkHtml('Users/view', 'text', $stat['User']['name'], '/users/view/' . $stat['User']['id'] );
				else {
					if ($stat['Phone']['deleted'] == 0 )
						echo $access->checkHtml('Phones/view', 'text', $stat['Phone']['name'], '/phones/view/' . $stat['Phone']['id'] );
					else
						echo 'Deleted: ' . ($stat['Phone']['name']);
				}
				?>
		
		</td>
		<td>
			<?php echo $access->checkHtml('Items/view', 'text', $stat['Item']['name'], '/items/view/' . $stat['Item']['id'] ); ?>
		</td>
		<td>
			<?php 
				if (!empty($stat['Messagereceived']['id'])) //user
					echo $access->checkHtml('Messagereceiveds/view', 'text', $stat['Modifier']['name'] . $stat['Stat']['quantity'], '/messagereceiveds/view/' . $stat['Messagereceived']['id'] );
				else
					echo  $stat['Modifier']['name'] . $stat['Stat']['quantity'];
				?>
			&nbsp;
		</td>
		<td>
		<?php
				echo $access->checkHtml('Stats/view', 'text', $stat['Stat']['created'], '/stats/view/' . $stat['Stat']['id'] ); 
		?>
		</td>
		<td>
			<?php
				if (isset ($stat['Messagereceived']['Messagesent'][0]['rawmessage']))
					echo $access->checkHtml('Messagesents/view', 'text', $stat['Messagereceived']['Messagesent'][0]['rawmessage'], '/messagesents/view/' . $stat['Messagereceived']['Messagesent'][0]['id'] ); 
				else
					echo "Site update";
			?>
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
	echo $access->checkHtml('Stats/add', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php echo $access->checkHtml('Stats/add', 'link', 'New Update','/stats/add' ); ?></li>
		
	</ul>
</div>
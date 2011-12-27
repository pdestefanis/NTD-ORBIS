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
	
<h2><?php __('Users');?></h2>
	<table cellpadding="0" cellspacing="0">
	<tr>
			<!--<th><?php echo $this->Paginator->sort('id');?></th> -->
			<th><?php echo $this->Paginator->sort('name');?></th>
			<th><?php echo $this->Paginator->sort('username');?></th>
			<!--<th><?php echo $this->Paginator->sort('password');?></th>-->
			<th><?php echo $this->Paginator->sort('location_id');?></th>
			<th><?php echo $this->Paginator->sort('Role','FirstRole.name');?></th>
	</tr>
	<?php
	
	$i = 0;
	foreach ($users as $user):
		
		$class = null;
		if ($i++ % 2 == 0) {
			$class = ' class="altrow"';
		}
	?>
	<tr<?php echo $class;?>>
		<td>
			<?php echo $access->checkHtml('Users/view', 'text', $user['User']['name'], '/users/view/' . $user['User']['id'] ); ?>
		</td>
		<td><?php echo $access->checkHtml('Users/view', 'text', $user['User']['username'], '/users/view/' . $user['User']['id'] );  ?>&nbsp;</td>
		<td>
			<?php echo $access->checkHtml('Locations/view', 'text', $user['Location']['name'], '/locations/view/' . $user['Location']['id'] ); ?>
		</td>
		
		<td>
			<?php 
				if (!empty($user['Role']))
					echo "Primary Role:</br>";
				echo $access->checkHtml('Roles/view', 'text', $user['FirstRole']['name'], '/roles/view/' . $user['FirstRole']['id'] ); 
				if (!empty($user['Role'])) {
					echo "</br></br>Other roles:</br>";
					foreach ($user['Role'] as $role) {
						echo $access->checkHtml('Roles/view', 'text', $role['name'], '/roles/view/' . $role['id']);
						echo "</br>";
					}
				}
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
	echo $access->checkHtml('Users/add', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php 
		$access->checkHtml('Users/add', 'link', 'New User','add/'  ); ?></li>
	</ul>
</div>

<?php
echo $crumb->getHtml('Viewing facility', null, 'auto' ) ;
echo '<br /><br />' ;
?> 
<div class="locations view">
<h2><?php  __('Facility');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<!--
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['id']; ?>
			&nbsp;
		</dd>
		-->
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Shortname'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['shortname']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Upstream Facility'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Parent']['name']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Latitude'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['locationLatitude']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Longitude'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $location['Location']['locationLongitude']; ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<h3><?php __('Actions'); ?></h3>
	<ul>
		<li><?php echo $access->checkHtml('Locations/edit', 'link', 'Edit Facility','edit/' . $location['Location']['id'] ); ?></li>
		<li><?php echo $access->checkHtml('Locations/delete', 'delete', 'Delete','delete/' . $location['Location']['id'], 'delete', $location['Location']['name'] ); ?></li>
	</ul>
</div>
<div class="related">
	<h3><?php 
		if($access->check('Phones/index') ) {
		__('Related Phones');?></h3>
	<?php if (!empty($location['Phone'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		 <th><?php __('Name'); ?></th> 
		<th><?php __('Phonenumber'); ?></th>
		<th><?php __('Active'); ?></th>

	</tr>
	<?php
		$i = 0;
		foreach ($location['Phone'] as $phone):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
		<?php if ($phone['deleted'] == 0)  {?>
			<td><?php 
				echo $access->checkHtml('Phones/view', 'link', $phone['name'],'/phones/view/' . $phone['id'] ); 
				?></td>
			<td><?php echo $phone['phonenumber'];?></td>
			<td><?php echo ($phone['active']?'Yes':'No');?></td>
			<!-- <td><?php echo $phone['location_id'];?></td> -->
			
			<?php } ?>
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; 

}?>

</div>

<div class="related">
	<h3><?php 
		if($access->check('Users/index') ) {
		__('Related Users');?></h3>
	<?php if (!empty($location['User'])):?>
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		 <th><?php __('Name'); ?></th> 
		<th><?php __('Role'); ?></th>

	</tr>
	<?php
		$i = 0;
		foreach ($location['User'] as $user):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>

			<td><?php 
				echo $access->checkHtml('Users/view', 'link', $user['name'],'/users/view/' . $user['id'] ); 
				?></td>
			<td><?php 
				echo $access->checkHtml('Roles/view', 'link', $roles[$user['role_id']],'/roles/view/' . $user['role_id'] ); 
			?></td>
			<!-- <td><?php echo $user['location_id'];?></td> -->
			
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; 

}?>

</div>


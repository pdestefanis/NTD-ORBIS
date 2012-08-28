<div id="main">
<?php echo $javascript->link('prototype', false); ?>
<?php
	echo $crumb->getHtml('Phone Details',  null, 'auto' ) ;
	echo '<br /><br />' ;
?>

<div class="phones view">
<h2><?php  __('Phone Details');?></h2>
	<dl><?php $i = 0; $class = ' class="altrow"';?>
		<!--<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Id'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phone['Phone']['id']; ?>
			&nbsp;
		</dd>
		-->
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Name'); ?></dt>
				<dd<?php if ($i++ % 2 == 0) echo $class;?>>
					<?php echo $phone['Phone']['name']; ?>
					&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Phonenumber'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $phone['Phone']['phonenumber']; ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Active'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo ($phone['Phone']['active']?'Active':'Inactive'); ?>
			&nbsp;
		</dd>
		<dt<?php if ($i % 2 == 0) echo $class;?>><?php __('Location'); ?></dt>
		<dd<?php if ($i++ % 2 == 0) echo $class;?>>
			<?php echo $access->checkHtml('Phones/view', 'text', $phone['Location']['name'],'/locations/view/' . $phone['Location']['id'] ); ?>
			&nbsp;
		</dd>
	</dl>
</div>
<div class="actions">
	<?php 
	echo $access->checkHtml('Phones/edit', 'html', '<h3>Actions</h3>','' ); ?>
	<ul>
		<li><?php echo $access->checkHtml('Phones/edit', 'link', 'Edit Phone','edit/' . $phone['Phone']['id'] ); ?></li>
		<li><?php echo $access->checkHtml('Phones/delete', 'delete', 'Delete','delete/' . $phone['Phone']['id'], 'delete', $phone['Phone']['name'] ); ?></li>
	</ul>
</div>
<div class="related">
<?php echo $this->Form->create('Config', array('action' => 'view/' . $phone['Phone']['id']));
		$v = $ajax->remoteFunction(array('url' => 'view/' . $phone['Phone']['id'], 'update' => 'main', 'with' => 'Form.serialize(this.form)')); 
		echo $this->Form->input('limit', array('label' => 'Display limit', 'options' => array('10' => 10,'20' => 20,'50' => 50, '100' => 100), 'default' => 20, 'onChange' => $v));
		echo $this->Form->end(__('', true));
	?>
	<h3><?php __('Related Raw Messages');?></h3>
	<?php if (!empty($phone['Messagereceived'])):?>
	
	<table cellpadding = "0" cellspacing = "0">
	<tr>
		<!--<th><?php __('Id'); ?></th>-->
		<th><?php __('Raw Message'); ?></th>
		<th><?php __('Message Code'); ?></th>
		<!--<th><?php __('Created'); ?></th>-->
		<!--<th><?php __('Phone Id'); ?></th>-->
	</tr>
	<?php
		$i = 0;
		foreach ($phone['Messagereceived'] as $messagereceived):
			$class = null;
			if ($i++ % 2 == 0) {
				$class = ' class="altrow"';
			}
		?>
		<tr<?php echo $class;?>>
			<!--<td><?php echo $messagereceived['id'];?></td>-->
			<td><?php echo $messagereceived['rawmessage'];?></td>
			<td><?php echo $messagesents[$messagereceived['id']];?></td>
			<!--<td><?php echo $messagereceived['created'];?></td>
			<td><?php echo $messagereceived['phone_id'];?></td>-->
		</tr>
	<?php endforeach; ?>
	</table>
<?php endif; ?>

	<div class="actions">
		
	</div>
</div>

<div class="related">
<?php echo $this->element('related_stats'); ?>

</div>


</div>

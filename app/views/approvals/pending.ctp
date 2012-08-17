<div id="LoadingDiv" style="display:none;">
		<img src="../img/ajax-loader.gif" alt="" /></div>

<div id='update'>

<?php 
	echo $javascript->link('prototype', false); ?>
<?php
	echo $crumb->getHtml('Pending Approvals', null, '' ) ;
	echo '<br /><br />' ;
?>

<div class="actions">
	<h3><?php __('Actions'); ?></h3>
		<?php echo $this->Form->create('Approval', array('action'=>'add')); ?>
	
	<ul>
		<input type='hidden' name='stat_ids' id='stat_ids' value="">
		<?php echo $this->Form->end('Approve Selected', array('confirm' => 'Are you sure?')); ?>
	</ul>
</div>


<div class="updates index" id="updates_index">
<?php echo $this->element('approvals_pending');?>

</div>

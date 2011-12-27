
<?php 
if (!empty($options )) {
	foreach($options AS $k=>$v) : ?>
<option value="<?php echo $k; ?>"><?php echo $v; ?></option>
<?php endforeach; 
}	//else 
	//echo "<option value=''>You are not assigned to a location! Cannot add updates</option>";
?>


<?php if (isset ($canhide)) { ?>
<style type="text/css">
<?php foreach($canhide AS $k=>$v) : ?>
	<?php echo "." . $k; ?> {<?php echo $v; ?>}
<?php endforeach; ?>
</style>

<?php } ?>
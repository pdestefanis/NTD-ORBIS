<div class="title">
	<h2><?php __('Aggregated Inventory Chart');  ?></h2>
</div>
<?php
	$rows =0;
	foreach (array_keys($report) as $loc) {
		$rows++;
		$reportHtml = "<table class=\"small\">";
		$reportHtml .= "<tr>";
		$reportHtml .= "<th>Item</th>";
		$reportHtml .= "<th>Total</th>";
		$reportHtml .= "</tr>";
		foreach ($report[$loc] as $r) {
				if (isset($report[$r['parent']]))
					$parent = $report[$r['parent']][$r['iid']]['lname'];
				else
					$parent = null;
				//$parent = $allLocations[$r['parent']];
			$reportHtml .= "<tr><td>" . $r['icode'] . "</td>";
			$reportHtml .= "<td>" . $r['total'] . "</td></tr>";
		}
		$locs[] = array($r['lname'], $parent, $r['lname'], $reportHtml); 
		
	}
 echo $this->GoogleChart->orgChart( $rows,  //rows
 array( array('type' => 'string', 'value'=>'Name'),
 array('type' => 'string', 'value'=>'Parent'),
 //array('type' => 'string', 'value'=>'Report'),
 array('type' => 'string', 'value'=>'ToolTip')

 ),  //columns
 $locs						//values
 , 600, 800, "Facility Chart Report", ''); 
 //orgChart($rows, $columns, $values, $width, $height, $title, $hAxis)
?>


	

	

<h2><?php __('Approvals pending');?></h2>
	<table cellpadding="0" cellspacing="0" id='approval_list'>
	<tr>
			<th colspan='2'>Facility</th>
			<th>Level</th>
			<th>Approver</th>
			<th>Item</th>
			<th>Current Total Count</th>
			<th>Approved Total Count</th>
			<th>Last Updated</th>
			<th>Last Approval</th>

	</tr>

	<?php 

	$row_class = "";

	$i=0;
	foreach ( $pending as $location_key => $location )
	{

		if (count($location) > 1)
		{
			$row_class = ($i++ % 2) ? ' class="altrow"' : ' class="norow"';
			echo <<<EOR
					<tr $row_class>
						<td><input class='approval_all' data-location='$location_key' type='checkbox'></td>
						<td colspan='8'><b>Select all</b></td>
					</tr>
EOR;

		}

		foreach ( $location as $item_key => $item )
		{

			$depth             = $item['depth'];
			$row_class         = ($i++ % 2) ? ' class="altrow"' : ' class="norow"';
			$stat_ids          = implode( $item['stat_ids'],",");
			$parent            = isset($item['parent']) ? $item['parent'] : "";
			$children_ids      = isset($item['children_ids']) ? implode( $item['children_ids'],",") : "";
			$depth_marker      = str_repeat("-", $depth-1);
			$location_name     = $item['lname'];
			$quantity          = $all[$location_key][$item_key]['quantity'];
			$approved_quantity = isset($approved[$location_key][$item_key]) ? $approved[$location_key][$item_key]['quantity'] : "0";
			$approver          = isset($item['approver']) ? $item['approver'] : "";
			$item_name         = $item['name'];
			$last_updated      = $item['last_updated'];
			$last_approval     = isset($approved[$location_key][$item_key]) ? $approved[$location_key][$item_key]['last_approval'] : "";

			echo <<<EOR
			<tr $row_class>
				<td><input name='stat_ids' class='approval' value='$stat_ids' data-stat_ids='$stat_ids' data-item_id='$item_key' data-location='$location_key' data-parent='$parent' data-children='$children_ids' type='checkbox'></td>
				<td>$depth_marker$location_name</td>
				<td>$depth</td>
				<td>$approver</td>
				<td>$item_name</td>
				<td>$quantity</td>
				<td>$approved_quantity</td>
				<td>$last_updated</td>
				<td>$last_approval</td>
			</tr>
EOR;

			

		}
	}
	?>

	</table>
	
	<script>
		$$("input[name='stat_ids']").each(function(a){
			Event.observe(a, "click", function(e){
				if (e.target.checked)
				{

					/*
					 * Update hidden stat id list
					 */

					var list = $$("input#stat_ids")[0].value || "";
					list = list.split(",").filter(function(a) { 
						if (typeof(a) == "string" && a != "") return true; 
						return false;
					});

					clicked_stats = e.target.value.split(",");

					for (var i in clicked_stats)
					{

						var clicked_stat = clicked_stats[i];
						if (typeof(clicked_stat) === "function") continue;
						var position = list.indexOf(clicked_stat);
						if (!~position)
						{
							list.push(clicked_stat);
						}
					}
					$$("input#stat_ids")[0].value = list.join(",");
				} else
				{

					/*
					 * Update hidden stat id list
					 */

					var list = $$("input#stat_ids")[0].value || "";
					list = list.split(",").filter(function(a) { 
						if (typeof(a) == "string" && a != "") return true; 
						return false;
					});
					clicked_stats = e.target.value.split(",");

					for (var i in clicked_stats)
					{
						var clicked_stat = clicked_stats[i];
						if (typeof(clicked_stat) === "function") continue;
						var position = list.indexOf(clicked_stat);
						if (~position)
						{
							list.splice(position,1);
						}
					}
					$$("input#stat_ids")[0].value = list.join(",");
				};
				
				/*
				 * Propagate checks to children
				 */
				
				

			});
		});
	</script>



</div>


<h2><?php __('Approvals pending');?></h2>
	<table cellpadding="0" cellspacing="0" id='approval_list'>
	<tr>
			<th colspan='2'>Facility</th>
			<th>Level</th>
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

		/*if (count(array_shift($location['children'])) != 0)
		{
			echo <<<EOR
				<tr>
					<td><input id='select_all' type='checkbox'></td>
					<td colspan='8'><b>Select all</b></td>
				</tr>
EOR;
		}
*/
		foreach ( $location as $item_key => $item )
		{
			$depth             = $item['depth'];
			$row_class         = ($i++ % 2) ? ' class="altrow"' : ' class="norow"';
			$stat_ids          = implode( $item['total_items'][$item_key]['stat_ids'],",");
			$parent            = isset($item['parent']) ? $item['parent'] : "";
			$children_ids      = isset($item['children_ids']) ? implode( $item['children_ids'],",") : "";
			$depth_marker      = str_repeat("-", $depth-1);
			$location_name     = $item['lname'];
			$quantity          = $all[$location_key][$item_key]['quantity'];
			$approved_quantity = isset($approved[$location_key][$item_key]) ? $approved[$location_key][$item_key]['quantity'] : "0";
			$item_name         = $item['name'];
			$last_updated      = $item['last_updated'];
			$last_approval     = isset($approved[$location_key][$item_key]) ? $approved[$location_key][$item_key]['last_approval'] : "";

			echo <<<EOR
			<tr $row_class>
				<td><input name='unapproved_stat_ids' class='approval' value='$stat_ids' data-stat_ids='$stat_ids' data-item_id='$item_key' data-location='$location_key' data-parent='$parent' data-children='$children_ids' type='checkbox'></td>
				<td>$depth_marker$location_name</td>
				<td>$depth</td>
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
	
	<script src='/js/jquery.min.js'></script>
	<script>$.noConflict();</script>

	
	<script>

		$$("input[name='unapproved_stat_ids']").each(function(a){
			Event.observe(a, "click", function(e){
				
				if (window.originalCheck != null || window.originalCheck != undefined) return;
				window.originalCheck = e;

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
 * handle parents and children
 */



  var checking, foundStats, idsChecked, input, jInput, ownStat, ownStatList, unchecking, x, _i, _j, _len, _len2, _ref, _results;
  checking = e.target.checked;
  unchecking = !checking;
  idsChecked = jQuery("input#stat_ids").val().split(",");
  idsChecked = (function() {
    var _i, _len, _results;
    _results = [];
    for (_i = 0, _len = idsChecked.length; _i < _len; _i++) {
      x = idsChecked[_i];
      _results.push(parseInt(x));
    }
    return _results;
  })();
  _ref = jQuery("input[name='unapproved_stat_ids']");
  _results = [];
  for (_i = 0, _len = _ref.length; _i < _len; _i++) {
    input = _ref[_i];
    jInput = jQuery(input);
    ownStatList = jInput.val().split(",");
    ownStatList = (function() {
      var _j, _len2, _results2;
      _results2 = [];
      for (_j = 0, _len2 = ownStatList.length; _j < _len2; _j++) {
        x = ownStatList[_j];
        _results2.push(parseInt(x));
      }
      return _results2;
    })();
    foundStats = 0;
    for (_j = 0, _len2 = ownStatList.length; _j < _len2; _j++) {
      ownStat = ownStatList[_j];
      if (~idsChecked.indexOf(ownStat)) foundStats++;
    }
    console.log("looking for " + (ownStatList.join(',')) + " in");
    console.log(idsChecked);
    console.log("found " + foundStats + " of " + ownStatList.length + ". checking:" + checking);
    if (foundStats === ownStatList.length && checking) {
      jInput.attr("checked", "checked");
    }
    if (foundStats !== ownStatList.length && unchecking) {
      _results.push(jInput.removeAttr("checked"));
    } else {
      _results.push(void 0);
    }
  }


				window.originalCheck = null;
			});
		});
	</script>

</div>


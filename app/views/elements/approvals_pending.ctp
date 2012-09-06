<h2><?php __('Pending Approvals');?></h2>
	<table cellpadding="0" cellspacing="0" id='approval_list'>
	<tr>
			<th>Item</th>
			<th>Facility</th>
			<th>Level</th>
			<th>Approve</th>
			<th>Change</th>
			<th>Approved<br>Quantity</th>
			<th>Reported<br>Total</th>
			<th>Last Updated</th>
			<th>Last Approval</th>

	</tr>

	<?php 



/* 
 * Generate Branch Symbols
 */
$branches = array();

$flat = array();
foreach ($pending as $item_key => $items)
	foreach ($items as $location_key => $item)
		array_push($flat, $item);

$sym_pipe = '<img class="tree_symbols" src="/img/sym_pipe.png">';
$sym_leaf = '<img class="tree_symbols" src="/img/sym_leaf.png">';
$sym_cont = '<img class="tree_symbols" src="/img/sym_cont.png">';

$continuing = 0;

for ($i=0; $i<count($flat); $i++) {
	$idepth = intval($flat[$i]['depth']);
	if ($idepth != 1)
	{
		for ($j=$i+1; $j<count($flat); $j++)
		{
			$jdepth = intval($flat[$j]['depth']);
			if ($jdepth <  $idepth) break;
			if ($jdepth == $idepth) $continuing++;
		}
		for ($j=$i-1; $j>0; $j--)
		{
			$jdepth = intval($flat[$j]['depth']);
			if ($jdepth <  $idepth) break;
			if ($jdepth == $idepth) $continuing--;
		}
	} else
	{
		$continuing = 0;
	}
	$continuingAdjusted = $continuing;
	if ( $i == count($flat) ) {
		$leaf = $sym_leaf;
	} else if ($idepth == 1)
	{
		$leaf = "";
	} else if (isset($flat[$i+1]) && $flat[$i]['depth'] > $flat[$i+1]['depth'] )
	{
		$leaf = $sym_leaf;
	} else if (!isset($flat[$i+1])) {
		$leaf = $sym_leaf;
	} else {
		$continuingAdjusted--;
		$leaf = $sym_cont;
	}
	
	$branches[$i] = str_repeat($sym_pipe, max($continuingAdjusted, 0)) . $leaf;

}





	$row_class = "";

	$i=0;
	foreach ( $pending as $item_key => $items )
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
		foreach ( $items as $location_key => $item )
		{
			$branchSymbols     = $branches[$i];
			$depth             = intval($item['depth']-1);
			$row_class         = ($i++ % 2) ? ' class="altrow"' : ' class="norow"';
			$stat_ids          = implode( $item['total_items'][$item_key]['stat_ids'],",");
			$parent            = isset($item['parent']) ? $item['parent'] : "";
			$children_ids      = isset($item['children_ids']) ? implode( $item['children_ids'],",") : "";
			$depth_marker      = str_repeat("-", $depth);
			$location_name     = $item['lname'];
			$quantity          = $all[$item_key][$location_key]['quantity'];
			$approved_quantity = isset($approved[$item_key][$location_key]) ? $approved[$item_key][$location_key]['quantity'] : "0";
			$item_name         = $item['name'];
			$last_updated      = $item['last_updated'];
			$last_approval     = isset($approved[$item_key][$location_key]) ? $approved[$item_key][$location_key]['last_approval'] : "";
			$change            = ($approved_quantity - $quantity) * -1;
			$signum            = ($change == 0) ? "" : ($change > 0) ? "+" : "-";

			echo <<<EOR
			<tr $row_class>
				<td>$item_name</td>
				<td class='pending_approva_branch'>$branchSymbols$location_name</td>
				<td>$depth</td>
				<td><input name='unapproved_stat_ids' class='approval' value='$stat_ids' data-stat_ids='$stat_ids' data-item_id='$item_key' data-location='$location_key' data-parent='$parent' data-children='$children_ids' type='checkbox'></td>
				<td class='number'>$signum$change</td>
				<td class='number'>$approved_quantity</td>
				<td class='number'>$quantity</td>
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


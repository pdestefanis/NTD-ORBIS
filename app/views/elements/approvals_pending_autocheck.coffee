(
  checking = e.target.checked
  unchecking = !checking
  idsChecked = jQuery("input#stat_ids").val().split(",")
  idsChecked = (parseInt(x) for x in idsChecked)
  for input in jQuery("input[name='unapproved_stat_ids']")
    jInput = jQuery(input)
    ownStatList = jInput.val().split(",")
    ownStatList = (parseInt(x) for x in ownStatList)
    foundStats = 0
    for ownStat in ownStatList
      if ~idsChecked.indexOf(ownStat)
        foundStats++
    if foundStats == ownStatList.length && checking then jInput.attr("checked", "checked")
    if foundStats != ownStatList.length && unchecking then jInput.removeAttr("checked")
)
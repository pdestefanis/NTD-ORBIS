<?php
class UpdateFileHelper extends Helper {
//public $json;
	function addFileHeader() {
		return "{\"markers\": [";
	}
	function addPointHeader ($num, $data) {
		$fileData = "";
		if ($num == 0)
			$fileData .=  "{" . "";
		else
			$fileData .=  ",{" . "";
		$fileData .=  "\"point\": {\"latitude\":\"" . $data['locationLatitude'] . "\",\"longitude\":\"" . $data['locationLongitude']. "\"},"  . "";
		$fileData .=  "\"html\": \"<p><strong><a href=locations/view/" .  $data['id'] . ">" . $data['name'] . "</a></strong></p><br/>";
	
		return $fileData;
    }

     public function addDrugsHeader() {
		//prepare header
		$fileData =  "";
		$fileData .=  "<div class=infowindow><p><table><tr><td>Item</td>";
		$fileData .=  "<th>Units Remaining</th>";
		$fileData .=  "</tr>";
		return $fileData;

    }
    public function addDrugsData($data, $alarm) {
		$class = "";
		if ($alarm)
			$class = "alert";			
		
		$fileData = "<tr>";
		$fileData .= "<th class=" .$class . ">" . $data['item']['dname'] . "</th>";
		$fileData .= "<td class=" .$class . ">" . $data['st']['quantity_after'] . "</td>";
		$fileData .= "</tr>";

		return $fileData;
	}

	public function addDrugsFooter($globalAlarm, $graphURL=null) {
		$html = "</table></p>";
		if ($globalAlarm)
			$html .= '<p><a href =alerts/triggeredAlerts class=alert>Alert</a></p><br/>';
			if ( $graphURL != null)
				$html .=  '<p><img src=' . $graphURL . ' width=350px height=175px ></p>' ;
			$html .=  '</div>';
		return $html;
    }
	public function addTreatmentsHeader() {
    	//prepare header
		$fileData = "<p><table><tr><td>Treatment</td> ";
		$fileData .= "<th># People</th>";
		$fileData .= "</tr> ";
		return $fileData;
    }
	public function addTreatmentsData($data) {
		$fileData =  "<tr><th>" . $data['treatments']['dname'] . "</th>";
		$fileData .=  "<td>" . $data['st']['quantity'] . "</td>";
		$fileData .=  "</tr>";
		return $fileData;

    }
    function addTreatmentsFooter() {
			return "</table></p> <p>&nbsp;</p>";
    }
	function addCloseQuote(){
		return "\",";
	}
	
    function addPointFooter($globalAlarm, $empty, $site_no_report=false, $items_no_report=false) {
		//all icons generated from 
		//http://gmaps-utility-library.googlecode.com/svn/trunk/mapiconmaker/1.1/examples/markericonoptions-wizard.html
		if ($globalAlarm)
			$html = "\"markerImage\":\"img/star-red.png\" }";
		else if ($site_no_report) // case where no item reported within timeframe 
			$html = "\"markerImage\":\"img/star-".trim($site_no_report).".png\" }";
		else if ($items_no_report) // case where at least 1 item was reported out of timeframe
			$html = "\"markerImage\":\"img/star-".trim($items_no_report).".png\" }";
		else if ($empty) // case where no items have been reported 
			$html = "\"markerImage\":\"img/star-grey.png\" }";
		else
			$html = "\"markerImage\":\"img/star-blue.png\" }";
		return $html;
    }
    function addFileFooter () {
	    return "] }";
    }
}
?>
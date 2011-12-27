<?php
    //require_once('updateFile.php');
	require_once('db_connect.php');
	require_once('config.php');

	$phoneId = -1;
	$phoneNum = -1;
	$locationId = -1;
	$formResponseId = 0;
	$drugTreatName = "";
    $quantity = 0;
	$locationId = 0;
    $currDate = date("Y-m-d H:i:s");
    $rawreportId = 0;
    $treatmentId = 0;
    $reportType = "";
	$lastProcessedId = getLastProcessedId ();
	$currLastProcessedId = 0;
	
	
	$responses = getFLFormResponses($lastProcessedId);
	
	if ($responses != -1) {
		$currLastProcessedId  = processResponses ($responses, $currDate);
		setUpdates($currLastProcessedId, $currDate);
	} else 
		exit;
		
	exit;
	function processResponses(&$responses, &$currDate){
		$currLastProcessedId = 0;
		$i = 0;
		foreach ($responses as $key => $formResponse) {
			$i++; //force a second difference to the time stamp for each rawreport record
			$currDate = date("Y-m-d H:i:s",mktime(date('H'),date('i'),date('s', $now)+$i,date('m'),date('d'),date('Y')));
			$locationId = -1;
			$formResponseId = 0;
			$drugTreatName = "";
			$quantity = 0;
			$locationId = 0;
			$rawreportId = 0;
			$treatmentId = 0;
	
			$phoneNum = $formResponse['senderMsisdn'];
			$phoneId = getPhoneId($phoneNum);
			$formResponseId = $formResponse['id'];
			$currLastProcessedId = $formResponse['id'];
			
			$results = getResultIds($formResponseId);
			$processRes = processResults($results, $drugTreatName, $reportType, $drugId, $treatmentId, $quantity, $currDate, $phoneId, $phoneNum  );
			if ($processRes == -1) { //error was encountered
				continue;
			}
			if ($phoneId == -1) {
				setPhone($phoneNum); //insert the not found phone in the database as inactive
				$phoneId = getPhoneId($phoneNum);
				setRawreport($phoneId, $phoneNum, $drugTreatName, $quantity, $currDate, "FLSMS: Phone number " . $phoneNum . " not found in database");
				continue;
			}

			$phoneStatus = getPhoneStatus($phoneId);

			if ($phoneStatus == 0) {
				$phoneId = getPhoneId($phoneNum);
				setRawreport($phoneId, $phoneNum, $drugTreatName, $quantity, $currDate, "FLSMS: Phone number " . $phoneNum . " not active in database");
				continue;
			}

			$locationId = getLocation($phoneNum, $phoneId, $long, $lat);

			if ($locationId == -1) {
				setRawreport($phoneId, $phoneNum, $drugTreatName, $quantity, $currDate, "FLSMS: Phone number " . $phoneNum . " not assigned to a location.");
				continue;
			}
			setRawreport($phoneId, $phoneNum, $drugTreatName, $quantity, $currDate, "FLSMS: OK");
			//insert the sms into stats.
			$rawreportId = getRawreportId($phoneId, $currDate);
	
			if ($rawreportId == -1) {
				continue;
			}
			setStats($reportType, $quantity, $currDate, $drugId, $treatmentId, $rawreportId, $phoneId, $locationId);
		}
		return $currLastProcessedId;
	}
	
	function processResults(&$results, &$drugTreatName, &$reportType, &$drugId, &$treatmentId, &$quantity, &$currDate, &$phoneId, &$phoneNum  ) {
		$errorText = "";
		if (count($results) == 2){
			foreach ($results as $key => $result) {
				$dt_or_value = getResponseValue($result['results_id']);
				if (!is_numeric($dt_or_value)) { //we have drug or treatment
					$drugTreatName = $dt_or_value;
					$strLength = strlen($drugTreatName);
					if ($strLength == 3) {  //we have a drug
						$reportType = "D";
						$drugId = getDrugId($drugTreatName);
						if ($drugId == -1) {
							$errorText = "FLSMS: Drug ID doesn\'t exist: " . $drugTreatName;
						}
					} else  if ($strLength == 4) {
						$reportType = "T"; //treatment
						$treatmentId = getTreatmentId($drugTreatName);
							if ($treatmentId == -1) {
							   $errorText = "FLSMS: Treatment ID doesn\'t exist: " . $drugTreatName;
							}
					} else {
							$errorText =  "FLSMS: Drug/Treatment ID incorrect.";
					}
				} else if (is_numeric($dt_or_value)) { //we have quantity
					$quantity = $dt_or_value;
				}
				
			}
			if ($errorText != "" ) {
					setRawreport($phoneId, $phoneNum, $drugTreatName, $quantity, $currDate, $errorText);
					return -1;
			}
		} else { //if we don't have two records that the drug/traetment or qunatity is missing
			setRawreport($phoneId, $phoneNum, $drugTreatName, $quantity, $currDate, "FLSMS: incomplete data: cannot import");
			return -1;
		}
		return 1;
	}
	
	function getResponseValue(&$responseId) {
		$responseValue = "";
		$query = "SELECT value from responsevalue WHERE id = " . $responseId;
		$result = runQueryFLSMS($query);

		while ($row = $result->fetch_assoc()) {
			$responseValue =  $row['value'] ;
		}
		if ($result->num_rows != 0) {
			$result->free();
			//echo "resid: " . $responseId . " val: " . $responseValue;
			return $responseValue;
		} else
			return -1;
	}
	
	function setUpdates(&$currLastProcessedId, $currDate) {
		$responseValue = "";
		$query = "INSERT INTO updates (last_processed_id, created) values (" . $currLastProcessedId . ", '" . $currDate . "')";
		$result = runQuery($query);
	}
	
	function getResultIds(&$formResponseId){
		$formResults = array();
		$query = "SELECT * from formresponse_responsevalue where formresponse_id =  " . $formResponseId;
		$result = runQueryFLSMS($query);
		
		while ($row = $result->fetch_assoc()) {
			$formResults[] =  $row;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $formResults;
		} else
			return -1;
	}
	function getLastProcessedId () {
		$query = "SELECT last_processed_id as id from updates where id = (select max(id) from updates)";
		$result = runQuery($query);

		while ($row = $result->fetch_assoc()) {
			$lastProcessedId =  $row['id'] ;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $lastProcessedId;
		} else
			return -1;
	}
	
	function getFLFormResponses (&$lastProcessedId) {
		$formResponses = array();
		
		$query = "SELECT * from formresponse where id > " . $lastProcessedId . " order by id";
		$result = runQueryFLSMS($query);
		
		while ($row = $result->fetch_assoc()) {
			$formResponses[] =  $row;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $formResponses;
		} else
			return -1;
	}
	

	function getPhoneId($phoneNum) {
		// Returns the phone ID if the phone is found in the database
        // otherwise returns 0
		//substring the phonenumber last N digist from DB
		$query = "SELECT phones.id as pid FROM phones WHERE substring(phones.phonenumber FROM -" . PHONE_NUMBER_LENGTH . ")=substring('" . $phoneNum ."' FROM -" . PHONE_NUMBER_LENGTH . ") limit 1";
		$result = runQuery($query);

		while ($row = $result->fetch_assoc()) {
			$phoneId =  $row['pid'] ;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $phoneId;
		} else
			return -1;
	}
    
    function getPhoneStatus($phoneId) {
		// Returns 1 if the phone is active in the database
        // otherwise returns 0

		$query = "SELECT phones.active as status FROM phones WHERE phones.id='" . $phoneId ."' limit 1";

		$result = runQuery($query);

		while ($row = $result->fetch_assoc()) {
            $phoneStatus = $row['status'];
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $phoneStatus;
		} else
			return -1;
	}

	function setPhone($phoneNum) {
		//insert the new phone and make it inactive
		$query = "INSERT INTO phones (phonenumber, active, name) VALUES ('" . $phoneNum . "', 0, 'Unknown') ";
		$result = runQuery($query);
	}

	function getLocation($phoneNum, &$phoneId, &$long, &$lat) {
		$query = "SELECT locationLongitude, locationLatitude, locations.id as lid, phones.id as pid " .
				"FROM locations, phones " .
				"WHERE location_id = locations.id and phones.id='" . $phoneId ."' limit 1";

		$result = runQuery($query);

		while ($row = $result->fetch_assoc()) {
			$long =  $row['locationLongitude'] ;
			$lat =  $row['locationLatitude'] ;
			$locationId =  $row['lid'] ;
			$phoneId =  $row['pid'] ;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $locationId;
		} else return -1;
	}

	function setRawreport($phoneId, $phoneNum, $drugTreatName = "", $quantity = 0, $currDate, $status = 0) {
		//insert the raw submitted sms to the database
		$query = "INSERT INTO rawreports (raw_message, created,  phone_id, message_code) " .
				 "VALUES ('". $drugTreatName . " " . $quantity . " " . $phoneNum .
				 "', '" . $currDate . "', " . $phoneId . ", '" . $status . "')";
		$result = runQuery($query);
	}

    function getRawreportId($phoneId, $currDate) {
			$query = "SELECT rawreports.id as rid FROM rawreports " .
					"WHERE rawreports.phone_id = " . $phoneId . " " .
					"AND rawreports.created = '" . $currDate .  "' limit 1";
			$result = runQuery($query);

			while ($row = $result->fetch_assoc()) {
				$rawreportId =  $row['rid'] ;
			}
			if ($result->num_rows != 0) {
				$result->free();
				return $rawreportId;
			}
			else return -1;
	}

	function getDrugId($drugTreatName) {
		$query = "SELECT drugs.id as did FROM drugs WHERE drugs.code = UPPER('" . $drugTreatName ."') limit 1";
		$result = runQuery($query);

		while ($row = $result->fetch_assoc()) {
			$drugId =  $row['did'] ;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $drugId;
		}
		else return -1;
	}

    function getTreatmentId($drugTreatName) {
			$query = "SELECT treatments.id as tid FROM treatments WHERE treatments.code = UPPER('".$drugTreatName."') limit 1";
			$result = runQuery($query);

			while ($row = $result->fetch_assoc()) {
				$treatmentId =  $row['tid'] ;
			}
			if ($result->num_rows != 0) {
				$result->free();
				return $treatmentId;
			}
			else return -1;
	}

	function setStats($reportType, $quantity, $currDate, $drugId, $treatmentId, $rawreportId, $phoneId, $locationId ) {
			//insert the raw submitted sms to the database
			$query = "INSERT INTO stats " .
				"(quantity, created, drug_id, treatment_id, rawreport_id, phone_id, location_id) ";
			if ($reportType == 'D')
				$query .= "VALUES (" . $quantity . ", '" . $currDate . "', " . $drugId . ", 0 , " . $rawreportId . ", " . $phoneId . ", " . $locationId . ")";
			else if ($reportType == 'T')
				$query .= "VALUES (" . $quantity . ", '" . $currDate . "', 0 , " . $treatmentId . ", " . $rawreportId . ", " . $phoneId . ", " . $locationId . ")";
            //echo $query;
			$result = runQuery($query);
	}

?>

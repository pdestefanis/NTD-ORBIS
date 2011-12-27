<?php

class databaseManipulation {
	
	private $db;
	
	function __construct(&$dbase) {
       $this->db = $dbase;
	}
	
	function getPhoneId($phoneNum) {
                // Returns the phone ID if the phone is found in the database
                // otherwise returns -1.
                // substring the phonenumber last N digist from DB
                $query = "SELECT phones.id as pid FROM phones WHERE substring(phones.phonenumber FROM -" . PHONE_NUMBER_LENGTH . ")=substring('" . $phoneNum ."' FROM -" . PHONE_NUMBER_LENGTH . ") limit 1";
	        $result = $this->db->query($query);

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
        // otherwise returns -1
		//modification return 0 if phones is deleted
		$query = "SELECT CASE WHEN phones.deleted = 1 THEN 0 ELSE phones.active END as status FROM phones WHERE phones.id='" . $phoneId ."' limit 1";
		$result = $this->db->query($query);

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
		$result = $this->db->query($query);
	}
	
	function regPhone($phoneNum, $phoneId, $facilityId, $pName) {
		if ($phoneId == -1)  { //phone doesn't exist yet
			if ($pName == "")
				$pName = 'Unknown';
			$query = "INSERT into phones (phonenumber, active, location_id, name) VALUES ($phoneNum, 1, $facilityId, '$pName')";
			$result = $this->db->query($query);
			return "registered";
		} else if ($phoneId != -1) {
			$query = "UPDATE phones SET location_id = $facilityId, active=1 WHERE id = $phoneId" ;
			$result = $this->db->query($query);
			return "updated";
		}
	}	
	
	function getLocationIdByShortn($shortname) {
		$query = "SELECT id as  lid from locations where shortname ='" . $shortname . "' limit 1";
		$result = $this->db->query($query);

		while ($row = $result->fetch_assoc()) {
			  $locationId =  $row['lid'] ;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $locationId;
		} else
			return -1;
	}
	
	function getLocationName($facilityId) {
		$query = "SELECT name as  lid from locations where id =$facilityId  limit 1";
		
		$result = $this->db->query($query);

		while ($row = $result->fetch_assoc()) {
			  $locationName =  $row['lid'] ;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $locationName;
		} else
			return -1;
	}
	
	function getLocation($phoneNum, &$phoneId) {
		$query = "SELECT locationLongitude, locationLatitude, locations.id as lid, phones.id as pid " .
				"FROM locations, phones " .
				"WHERE location_id = locations.id and phones.id='" . $phoneId ."' limit 1";

		$result = $this->db->query($query);

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

	function setRawreport($phoneId, $phoneNum, $item, $quantity, $currDate, $mod, $status = "error") {
		//insert the raw submitted sms to the database
		$query = "INSERT INTO rawreports (raw_message, created,  phone_id, message_code) " .
				 "VALUES ('". $item . " " . $mod . "" . $quantity . " " . $phoneNum .
				 "', '" . $currDate . "', " . $phoneId . ", '" . $status . "')";
		$result = $this->db->query($query);
	}

    function getRawreportId($phoneId, $currDate) {
			$query = "SELECT rawreports.id as rid FROM rawreports " .
					"WHERE rawreports.phone_id = " . $phoneId . " " .
					"AND rawreports.created = '" . $currDate . "'  limit 1";
			$result = $this->db->query($query);

			while ($row = $result->fetch_assoc()) {
				$rawreportId =  $row['rid'] ;
			}
			if ($result->num_rows != 0) {
				$result->free();
				return $rawreportId;
			}
			else return -1;
	}

	function getItemId($item) {
		$query = "SELECT items.id as did FROM items WHERE items.code = UPPER('" . $item ."') limit 1";
		$result = $this->db->query($query);

		while ($row = $result->fetch_assoc()) {
			$item =  $row['did'] ;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $item;
		}
		else return -1;
	}

    function getItemName($itemId) {
		$query = "SELECT items.name as name FROM items WHERE items.id = $itemId limit 1";
		$result = $this->db->query($query);

		while ($row = $result->fetch_assoc()) {
			$itemName =  $row['name'] ;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $itemName;
		}
		else return -1;
	}
	
	 function getItemCode($itemId) {
		$query = "SELECT items.code as code FROM items WHERE items.id = $itemId limit 1";
		$result = $this->db->query($query);

		while ($row = $result->fetch_assoc()) {
			$itemCode =  $row['code'] ;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $itemCode;
		}
		else return -1;
	}


	function setStats( $quantity, $currDate, $itemId, $rawreportId, $phoneId, $locationId, $qtyAfter, $modId, $mod ) {
			//insert the raw submitted sms to the database
			if ($mod == "=") 
				$qtyAfter = $quantity;
			else if ($mod == "-") 
				$qtyAfter -= $quantity;
			else if ($mod == "+") 
				$qtyAfter += $quantity;
				
			$query = "INSERT INTO stats " .
				"(quantity, quantity_after, created, modifier_id, item_id, messagereceived_id, phone_id, location_id) ";
			$query .= "VALUES (" . $quantity . ", " . $qtyAfter .  ", '" . $currDate . "', " . $modId . ", " . $itemId . ", " . $rawreportId . ", " . $phoneId . ", " . $locationId . ")";
			
			$result = $this->db->query($query);
	}
	
	//get the last quantity after for this
	function getQuantityAfter($itemId, $locationId) {
		$query = "SELECT quantity_after ";
		$query .= "FROM stats s ";
		$query .= "WHERE s.item_id = $itemId AND s.location_id = $locationId ";
		$query .= "AND s.id = (select max(st.id) from stats st where st.item_id = s.item_id  ";
		$query .= "AND location_id = $locationId ) ";
		$query .= "ORDER by created DESC ";
		
		$result = $this->db->query($query);

		while ($row = $result->fetch_assoc()) {
			$qty =  $row['quantity_after'] ;
		}

		if ($result->num_rows != 0 && $qty != NULL) {
			$result->free();
			return $qty;
		}
		else return -1;
	}
	
	function getLastStatId($itemId, $locationId) {
		$query = "SELECT id ";
		$query .= "FROM stats s ";
		$query .= "WHERE s.item_id = $itemId AND s.location_id = $locationId ";
		$query .= "AND s.id = (select max(st.id) from stats st where st.item_id = s.item_id  ";
		$query .= "AND location_id = $locationId ) ";
		$query .= "ORDER by created DESC ";
		
		$result = $this->db->query($query);

		while ($row = $result->fetch_assoc()) {
			$id =  $row['id'] ;
		}

		if ($result->num_rows != 0 ) {
			$result->free();
			return $id;
		}
		else return -1;
	}
	
	function getModifier($itemCode, $modName = null) {
		if ($modName) {
			$query = "SELECT id as mid, modifiers.name as mname ";
			$query .= "FROM modifiers ";
			$query .= "WHERE name LIKE '%" . $modName . "%'";
			
		} else {			
			$query = "SELECT modifier_id as mid, modifiers.name as mname ";
			$query .= "FROM items left join modifiers on modifiers.id = items.modifier_id ";
			$query .= "WHERE items.code = UPPER('" . $itemCode ."') limit 1";
		}
		$result = $this->db->query($query);
		
		while ($row = $result->fetch_assoc()) {
			$modifier =  $row ;
		}
		if ($result->num_rows != 0 && $modifier['mid'] != NULL) {
			$result->free();
			return $modifier;
		}
		else return -1;
	}
	
	function setReceived ($phoneId, $created, $raw) {
		$query = "INSERT INTO messagereceiveds (phone_id, created, rawmessage) VALUES (" . $phoneId . ", '" . $created . "', '" . addslashes ($raw ) . "') ";
		$result = $this->db->query($query);
		//get the id of this record and return it
		$query = "SELECT id ";
		$query .= "FROM messagereceiveds ";
		$query .= "WHERE phone_id=$phoneId  AND created ='" . $created . "'";
		$result = $this->db->query($query);
		
		while ($row = $result->fetch_assoc()) {
			$id =  $row['id'] ;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $id;
		}
		else return -1;
	}
	function setSent ($phoneId, $created, $raw, $receivedId) {
		$query = "INSERT INTO messagesents (phone_id, created, rawmessage, messagereceived_id) ";
		$query .= "VALUES (" . $phoneId . ", '" . $created . "', '" . addslashes ($raw ). "', " . $receivedId. ") ";
		$result = $this->db->query($query);
	}
	
	function getLocations() {
		$query = "SELECT id, parent_id ";
		$query .= "FROM locations WHERE deleted = 0";
		
		$result = $this->db->query($query);
		while ($row = $result->fetch_assoc()) {
			$locations[$row['id']] =  $row['parent_id'];
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $locations;
		}
		else return -1;
	}
	
	function getChildrenSum ($children, $itemId) {
		$query = "SELECT stat_items.id as sid, quantity_after, items.code as icode, items.name as dname, items.id as did, " .
			"created, phone_id as pid, stat_items.location_id, " .
			// "phones.phonenumber as pnumber, phones.name as pname, phones.deleted as pdeleted,  ".
			"locations.id as lid, locations.shortname as lcode,locations.name as lname, locations.parent_id parent ";
		$query .= "FROM stats stat_items, items, locations ";
		$query .= "WHERE stat_items.item_id = items.id ";
		//$query .= "AND stat_items.phone_id = phones.id ";
		$query .= "AND stat_items.location_id = locations.id ";
		$query .= "AND stat_items.id = (select max(sa.id) from stats sa where sa.item_id = stat_items.item_id  ";
		$query .= "AND location_id = stat_items.location_id) ";
		if ($itemId != -1)
			$query .= "AND items.id =" . $itemId . " ";
		$query .= "AND stat_items.location_id IN ( " . implode(",", $children) . ") ";
		$query .= "ORDER by locations.parent_id ";
		
		$result = $this->db->query($query);
		while ($row = $result->fetch_assoc()) {
			$listd[] = $row;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $listd;
		}
		return -1;
	}
	
	function getUser ($phoneId ) {
		$query = "SELECT id FROM users ";
		$query .= "WHERE phone_id = $phoneId ";
		
		$result = $this->db->query($query);
		while ($row = $result->fetch_assoc()) {
			$id = $row['id'];
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $id;
		}
		return -1;
	}
	
	function setApproval ($userId, $created, $receivedId) {
		$query = "INSERT INTO approvals ( user_id, created, messagereceived_id) ";
		$query .= "VALUES (" . $userId . ", '" . $created . "', " . $receivedId. ") ";
		$result = $this->db->query($query);
		
		//get the id of this record and return it
		$query = "SELECT id ";
		$query .= "FROM approvals ";
		$query .= "WHERE messagereceived_id=$receivedId";
		$result = $this->db->query($query);
		while ($row = $result->fetch_assoc()) {
			$id =  $row['id'] ;
		}
		if ($result->num_rows != 0) {
			$result->free();
			return $id;
		}
		else return -1;
	}
	
	function approveOne ($itemId, $sum, $approvalId) {
		foreach (array_keys($sum) as $s) {
			if ($s == $itemId){
				foreach ($sum[$s]['sid'] as $st) { //loop through stat ids
					$query = "INSERT INTO approvals_stats (approval_id, stat_id) ";
					$query .= "VALUES (" . $approvalId . ", " . $st .")" ;
					$result = $this->db->query($query);
				}
			}
		}
	}
	
	function approveAll ($sum, $approvalId) {
		foreach (array_keys($sum) as $s) {
			foreach ($sum[$s]['sid'] as $st) { //loop through stat ids
				$query = "INSERT INTO approvals_stats (approval_id, stat_id) ";
				$query .= "VALUES (" . $approvalId . ", " . $st .")" ;
				$result = $this->db->query($query);
			}
		}
	}
}

?>
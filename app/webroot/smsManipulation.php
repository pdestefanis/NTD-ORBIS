<?php

class smsManipulation {
	private $children;
	private $locations;
	private $listitems;
	private $dbManip;
	private $sms;
	private $phoneId;
	private $phoneStatus;
	private $phoneName;
	private $locationName;
	private $locationId;
	private $itemId;
	private $qtyAfter;
	private $currDate;
	private $receivedId;
	private $approvalId;
	private $userId;
	private $args;
	private $modifier;
	private $rawreportId;
	
	
	function __construct(&$dbManip, $args, $currDate) {
		$this->currDate = $currDate;
		$this->dbManip = $dbManip;
		$this->args = explode("|", trim(urldecode(implode("|", $args)))); //also remove space from begining and end
		//remove spaces from middle if more then one
		$arg2 = '';
		foreach (explode(' ', $this->args[1]) as $a) {
			if ($a == "") //spaces in array are nulls from explode
				continue;
			$arg2 .=  $a . ' ';
		} 
		$this->args[1] = trim($arg2);
		
		//error_log("[ ".date("Y-m-d H:i:s")." ]:  processSMS:". $this->args[1] .  " " .$this->args[2]."\n", 3, __ROOT__ . "/webroot/parser.log");
		//find the phone if present
		$this->phoneId = $this->dbManip->getPhoneId(end($this->args));
		if ($this->phoneId == -1 && substr(strtoupper($this->args[1]), 0, 3) != "MDA") {//EDIT MDA HERE
			$this->dbManip->setPhone(end($this->args)); //insert the not found phone in the database as inactive
			$this->phoneId = $this->dbManip->getPhoneId(end($this->args));
			$raw =  "Error: phone number " . end($this->args) . " not found in database. It has been added but you need to register it to a Kabele before you can send reports\n";
			$this->dbManip->setSent($this->phoneId, $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
		
		// check that there are arguments
		if (sizeof($this->args) == 1 || sizeof($this->args) == 2 || sizeof($this->args) > 3 /*|| (count(explode(" ",$this->args[1])) > 2)*/ && substr(strtoupper($this->args[1]), 0, 3) != "MDA") { //if empty message or more than necessary arguements
			$raw = "Incorrect arguments set. Please use Item-Code, a space, modfier (+,-,=), a space, and the quantity to report. Please send one report per SMS.";
			$this->dbManip->setSent($this->phoneId, $this->currDate, $raw . " " .end($this->args), $this->getReceivedId ());
			echo $raw;
			exit;
		}
		
		$this->locations = $this->dbManip->getLocations();
		
	}
		
	function initSms (&$sms) {
		$this->sms = $sms;
		
		$this->phoneStatus = $this->dbManip->getPhoneStatus($this->phoneId);
		if ($this->phoneStatus == 0 && substr(strtoupper($this->args[1]), 0, 3) != "MDA") {
			$this->phoneId = $this->dbManip->getPhoneId($this->sms->getPhone());
			$raw =  "Error: phone number " . $this->sms->getPhone() . " is not active. You won't be able to enter data until you register with a Kabele\n";;
			$this->dbManip->setSent($this->phoneId, $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
		$this->locationId = $this->dbManip->getLocation($this->sms->getPhone(), $this->phoneId);
		if ($this->locationId == -1  && substr(strtoupper($this->args[1]), 0, 3) != "MDA") { //EDIT MDA HERE
			$raw =  "This phone is not assigned to a facility. The update will not be processed. Please contact the central office.\n";
			$this->dbManip->setSent($this->phoneId, $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
		
		if ($this->sms->getAction() != "approve")
		{
			$this->itemId = $this->dbManip->getItemId($this->sms->getItem());
			if ($this->itemId == -1 && strtoupper($this->sms->getItem()) != "ALL"  && substr(strtoupper($this->args[1]), 0, 3) != "MDA") { //EDIT MDA HERE
				$raw =  "Cannot find an item with code '" . $this->sms->getItem() . "'. Items are identified by their code. Please verify and resend\n";
				$this->dbManip->setSent($this->phoneId, $this->currDate, $raw, $this->getReceivedId ());
				echo $raw;
				exit;
			}

			$this->qtyAfter = $this->dbManip->getQuantityAfter($this->itemId, $this->locationId);
			if ($this->qtyAfter == -1) 
				$this->qtyAfter = 0; //no quantity first submission set it to zero
		} else
		{ // action = "approve"


			// see if it picked up an item as a location
			if ($this->dbManip->getItemId($this->sms->getLocation()) != -1)
			{
				$this->sms->locationIsItem();
			}

			// Check item list for correct item codes
			$itemList = $this->sms->getItemList();

			$missingItems = array();
			foreach ($itemList as $oneItem) 
			{
				$oneItemId = $this->dbManip->getItemId($oneItem);
				if ($oneItemId == -1 && $oneItem != "ALL") 
				{ 
					array_push($missingItems, $oneItem);
				}
			}
			if (count($missingItems) > 0)
			{
				$itemPlural = (count($missingItems) == 1) ? "Item" : "Items";
				$raw = "$itemPlural not found: " . implode(", ", $missingItems) . ". Items are identified by their code. Please verify and resend.";
				$this->dbManip->setSent($this->phoneId, $this->currDate, $raw, $this->getReceivedId());
				echo $raw;
				exit;
			}
		}
	}
	
	function getChildren (){
		return $this->children;
	}
	
	function findChildren($loc) {
		$child = array_keys($this->locations, $loc);
		foreach (array_values($child) as $c) {
			if ($c == NULL)
				continue;
			$this->children[] = $c; 
			$this->findChildren($c);	
		}
	}
	
	function getChildrenSum() {
		if ($this->children == NULL){
			$raw =  "Your facility does not contain sub facilities. You can get a count for your facility by sending the item code\n";
			$this->dbManip->setSent($this->phoneId, $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
		$listd = $this->dbManip->getChildrenSum($this->children, $this->itemId);
		
		if ($listd == -1) {
			$raw =  "There are no quanities recorded for this item\n";
			$this->dbManip->setSent($this->phoneId, $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;

		}
		$sum = NULL;
		foreach ($listd as $l) {
			if (isset($sum[$l['did']])) { //sum up qty for each drug and cread a stat ids in sid array for each summed up drug
				$sum[$l['did']]['sum'] += $l['quantity_after'];
				$sum[$l['did']]['sid'][] = $l['sid'];
			} else {
				$sum[$l['did']]['sum'] = $l['quantity_after'];
				$sum[$l['did']]['sid'][] = $l['sid'];
			}
		}
		
		return $sum;
	}
	
	function getChildrenSumByLocation() {
		if ($this->children == NULL){
			$raw =  "Your facility does not contain sub facilities. You can get a count for your facility by sending the item code\n";
			$this->dbManip->setSent($this->phoneId, $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
		$listd = $this->dbManip->getChildrenSum($this->children, $this->itemId);
		
		if ($listd == -1) {
			$raw =  "There are no quanities recorded for this item\n";
			$this->dbManip->setSent($this->phoneId, $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;

		}
		$sum = NULL;
		foreach ($listd as $l) {
			if (isset($sum[$l['lcode']][$l['did']]) && isset($sum[$l['lcode']])) { //sum up qty for each drug and cread a stat ids in sid array for each summed up drug
				$sum[$l['lcode']][$l['did']]['sum'] += $l['quantity_after'];
				$sum[$l['lcode']][$l['did']]['sid'][] = $l['sid'];
			} else {
				$sum[$l['lcode']] = array();
				$sum[$l['lcode']][$l['did']]['sum'] = $l['quantity_after'];
				$sum[$l['lcode']][$l['did']]['sid'][] = $l['sid'];
			}
		}

		return $sum;
	}

	function getChildrenAndParentSum() {

		$this->children[] = $this->locationId;
		$listd = $this->dbManip->getChildrenSum($this->children, $this->itemId);
		
		if ($listd == -1) {
			$raw =  "There are no quanities recorded for this item\n";
			$this->dbManip->setSent($this->phoneId, $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
		$sum = NULL;
		foreach ($listd as $l) {
			if (isset($sum[$l['did']])) { //sum up qty for each drug and create a stat ids in sid array for each summed up drug
				$sum[$l['did']]['sum'] += $l['quantity_after'];
				$sum[$l['did']]['sid'][] = $l['sid'];
			} else {
				$sum[$l['did']]['sum'] = $l['quantity_after'];
				$sum[$l['did']]['sid'][] = $l['sid'];
			}
		}
		
		return $sum;
	}
	
	function getReceivedId () {
		if (empty($this->receivedId)) {
			$this->receivedId = $this->dbManip->setReceived ($this->phoneId, $this->currDate, $this->args[1] . " " . end($this->args));
			if ($this->receivedId == -1) {
				echo "There was an error processing your message (received id). Please resend\n";
				exit;
			}
		}
		return $this->receivedId;
	}
	
	function getApprovalId() {
		if (empty($this->approvalId)) {
			$this->approvalId = $this->dbManip->setApproval($this->userId, $this->currDate, $this->receivedId); //insert approval record
			if ($this->approvalId == -1) {
				$raw = "There was an error processing your message (approvalId). Please resend\n";
				$this->dbManip->setSent($this->getPhoneId(), $this->currDate, $raw, $this->getReceivedId ());
				echo $raw;
				exit;
			}
		}
		return $this->approvalId;
	}
	
	function setUserId() {
		$this->userId = $this->dbManip->getUser ($this->phoneId ); //confirm user is assigned to this phone
		if ($this->userId == -1) {
			$raw = "Phone number ". $this->sms->getPhone() . " is not assigned to a user. You cannot send approvals\n";
			$this->dbManip->setSent($this->getPhoneId(), $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
	}
	
	function setItemId ($item) {
		$this->itemId = $item;
	}

	function getPhoneId () {
		return $this->phoneId;
	}
	
	function getLocationId () {
		return $this->locationId;
	}
	
	function getLocationName () {
		return $this->locationName;
	}
	
	function getItemId () {
		return $this->itemId;
	}
	
	function getQtyAfter () {
		return $this->qtyAfter;
	}
	
	function getCurrDate () {
		return $this->currDate;
	}
	
	function getArgs () {
		return $this->args;
	}
	
	function setModifier () {
		//populate modifier array with mod id and name
		$this->modifier = $this->dbManip->getModifier($this->sms->getItem(), $this->sms->getModifier());
		if (isset($this->modifier['mname']))	
			$this->sms->setModifier($this->modifier['mname']);
		//}
	
		if ($this->modifier == -1 ) {
			$raw = "Default modifier for: " . $this->sms->getItem() . " is not set please include  a valid modifier in your report and re-send. Message not processed!" ;
			$this->dbManip->setSent($this->getPhoneId(), $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
	}
	
	function getLocationIdByShortn($shortname) {
		$this->locationId = $this->dbManip->getLocationIdByShortn( $shortname );
		if ($this->locationId == -1) {
			$raw = "That is not a valid ID for a Kebele ($shortname). Please check the list, or ask a supervisor\n\n";
			$this->dbManip->setSent($this->getPhoneId(), $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
		return $this->locationId;
	}
	
	function getLocationNameById($shortname) {
		$this->locationName = $this->dbManip->getLocationName ($this->locationId );
		if ($this->locationName == -1) {
			$raw = "Error: could not get location name. Please verify and re-send \n";
			$this->dbManip->setSent($this->getPhoneId(), $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
	}
	
	function regPhone() {
		$creUpd = $this->dbManip->regPhone ($this->sms->getPhone(), $this->getPhoneId(), $this->locationId, substr($this->sms->getItem(), 0, -3));
		$raw = "Thank you, ". substr($this->sms->getItem(), 0, -3) . " Your phone is $creUpd to " . $this->locationName;
		$this->dbManip->setSent($this->getPhoneId(), $this->currDate, $raw, $this->getReceivedId ());
		echo $raw;
		exit;
	}
	
	function checkArguments(){
		// If not complete set of arguments record the raw sms and exit
		// Also, check that the SMS contents only carry one value pair
		if (!$this->sms->check() || (sizeof($this->args) != 3) ) { 
			$raw = "Incorrect report format. Please use Item-Code, a space, modfier (+,-,=), a space, and the quantity to report. Please send one report per SMS.";
			$this->dbManip->setSent($this->getPhoneId(), $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
		
		if (!is_numeric($this->sms->getQty())) {
			$raw = "The quantity for the item must be numeric, but received ".$this->sms->getQty().". Please verify and resend\n";
			$this->dbManip->setSent($this->getPhoneId(), $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
	}
	
	function processSms() {
		

		if ($this->receivedId == -1) {
			$raw = "There was an error processing your message (raw report id). Please resend\n";
			$this->dbManip->setSent($this->getPhoneId(), $this->currDate, $raw, $this->getReceivedId ());
			echo $raw;
			exit;
		}
		$this->dbManip->setStats($this->sms->getQty(), $this->getCurrDate(), $this->getItemId(), $this->receivedId, $this->getPhoneId(), $this->locationId, $this->qtyAfter, $this->modifier['mid'], $this->sms->getModifier() );
		
		$raw = "Message processed successfully. Item: " . $this->dbManip->getItemName($this->getItemId()) . ", Quantity reported: " . $this->sms->getModifier() . $this->sms->getQty();
		$this->dbManip->setSent($this->getPhoneId(), $this->currDate, $raw, $this->getReceivedId ());
		echo $raw;
		exit;
	}
	
	
	
}

?>
<?php
	require_once('dataBase.php');
	require_once('databaseManipulation.php');
	require_once('sms.php');
	require_once('smsManipulation.php');
	define('__ROOT__', dirname(dirname(__FILE__))); //this is a workaround for the require
	require_once(__ROOT__ . '/config/options.php'); //use this configuration so that we can make use of App::Configure in cake for the form

	define ("PHONE_NUMBER_LENGTH", $config['Phone']['length']);

	//THIS MUST BE CHANGED FOR EACH PROJECTS' TIMEZONE
	//OTHERWISE PHP DATE AND MYSQL DATE FROM THE WEBAPP MAY BE DIFFERENT
	//THIS MAY BE A WINDOWS BUG
	date_default_timezone_set('Africa/Johannesburg');
	//date_default_timezone_set('America/New_York'); //for EDT current v08 timezone
	
    $currDate = date("Y-m-d H:i:s");
	
	$db = new dataBase();
	$dbManip = new databaseManipulation($db);
	$smsManip = new smsManipulation($dbManip, $argv, $currDate);
	$sms = new sms($smsManip->getArgs());
	$smsManip->initSms($sms);
	
	//insert received record and get id
	$smsManip->getReceivedId ();

	//decide if action was given or an update of an item
	if ($sms->getAction() != NULL) {
		if ($sms->getAction()  == 'query' ) {
			$raw = "The current quantity for: " . $sms->getItem() . " is: " . $smsManip->getQtyAfter();
			$dbManip->setSent($smsManip->getPhoneId(), $currDate, $raw, $smsManip->getReceivedId ());
			echo $raw;
			exit;
		} else if ($sms->getAction()  == 'count') {
			$smsManip->findChildren($smsManip->getLocationId());
			$sum = $smsManip->getChildrenSum();
			$raw = "The current summed up quantity for: " . $sms->getItem() . " is: " . $sum[$smsManip->getItemId()]['sum'];
			$dbManip->setSent ($smsManip->getPhoneId(), $smsManip->getCurrDate(), $raw, $smsManip->getReceivedId ());
			echo $raw;
			exit;
		} else if ($sms->getAction()  == 'xcount') {
			$smsManip->findChildren($smsManip->getLocationId());
			$sum = $smsManip->getChildrenSumByLocation();
			$raw = "";
			foreach ($sum as $lcode => $drug) {
				$raw .=  $lcode . ": " . $drug[$smsManip->getItemId()]['sum'] . ", ";
			}
			$raw = substr($raw, 0, -2); //remove trailing comma
			//$raw = "The current summed up quantity for: " . $sms->getItem() . " is: " . $sum[$smsManip->getItemId()]['sum'];
			$dbManip->setSent ($smsManip->getPhoneId(), $smsManip->getCurrDate(), $raw, $smsManip->getReceivedId ());
			echo  $raw;
			exit;
		} else if ($sms->getAction() == 'pending') {
			$pId = $smsManip->getPhoneId();
			$raw = file_get_contents("/approvals/rest/$pId");
			echo $raw;
			exit;
		} else if ($sms->getAction() == 'approve') {
			$smsManip->setUserId(); //check that user is associated with phone
			$smsManip->findChildren($smsManip->getLocationId()); //get all children for location
			$sum = $smsManip->getChildrenAndParentSum(); //sum children and the paret - parent is the users location

			$pId = $smsManip->getPhoneId();

			//two cases an item and all
			if (strtoupper($sms->getItem() ) == "ALL") {

				$raw = file_get_contents("/approvals/rest/$pId/ALL");
				echo $raw;
				exit;
				
				$dbManip->approveAll($sum, $smsManip->getApprovalId());
				$raw = "All quantities have been approved: ";
				foreach (array_keys($sum) as $s) {
					$raw .= $dbManip->getItemCode($s) . ": " . $sum[$s]['sum'] . ". ";
				}
				$dbManip->setSent($smsManip->getPhoneId(), $smsManip->getCurrDate(), $raw, $smsManip->getReceivedId() );
				echo $raw;
				exit;
			} else {
				$item = $sms->getItem();
				$raw = file_get_contents("/approvals/rest/$pId/$item";
				echo $raw;
				exit;

				$dbManip->approveOne($smsManip->getItemId(), $sum, $smsManip->getApprovalId());
				$raw = "The following quantities have been approved: ". $sms->getItem() . " quanitity: " . $sum[$smsManip->getItemId()]['sum'];
				$dbManip->setSent ($smsManip->getPhoneId(), $smsManip->getCurrDate(), $raw, $smsManip->getReceivedId ());
				echo $raw;
				exit;
			}
		} else if ($sms->getAction()  == 'register') {
			//get the facility by code
			$smsManip->getLocationIdByShortn(strtoupper(substr($sms->getItem(), -3) ));//item contains the shortcode if we get here.
			//get the facility name
			$smsManip->getLocationNameById($sms->getItem());
			//insert/update the phone
			$smsManip->regPhone();
			
			
		}
		
		
		
	} else { //we have an update
		$smsManip->setModifier(); //get default and id for modifier
		$smsManip->checkArguments(); //make sure all arguemnts are set for an update
		$smsManip->processSms(); //insert sucessfull rawreport and update
	} 
?>


<?php

//emulation of enum
class modifier {
    const EQUAL = '=';
    const MINUS = '-';
	const PLUS = '+';
}

class seperator {
    const DOT = '.';
    const COMMA = ',';
	const SPACE = ' ';
	const SEMICOLON = ';';
	const COLON = ':';
	const UNDERSCORE = '_';
}

class action{
	public $query =  array ('QUERY', 'Q', 'ITEM');
	public $approve = array ('APPROVE', 'A', 'OK');
	public $count = array ('COUNT', 'C');
	public $xcount = array ('XCOUNT', 'XC');
	//NB please read note below
	public $register = array ('MDA'); //NB please read note below
	//if you change this or add keywards please make sure to update the 
	//following lines in smsManipulation
	//Line 41,67, 75, 83. Also processSMS line 30
}

class sms {
	private $item;
	private $location;
	private $qty;
	private $phone;
	private $modifier;
	private $modifier_pos;
	private $action;
	private $seperator;
	
	function __construct($args) {
		// Forms are also being processed under the <None> keyword rules
		// This is a hack to skip the message processing if a form is received
		// I would like for this to report nothing back, but FLSMS will still report.
		// Requested to fix that in the forums: http://frontlinesms.ning.com/forum/topics/binary-forms-going-to-the

		if (substr($args[1],0,10) == "AAI+gCUAAA") {
			exit;
		}
		
		//an item code is sent

		array_shift($args);//remove filename
		$args = urldecode(implode($args));
		
		$raw_args = $args;
		//get number positions, if occurence of numbers < 2 then is action
		//find seperator if any
		//if first 3 = action then get action then item
		//if no numbers then whole thing is item
		$positions = $this->get_positions($raw_args);
		if($this->modifier_pos) $this->modifier = substr($raw_args, $this->modifier_pos, 1);
		
		$chars_to_skip = 0;//chars between group of chars... i.e is there a seperator and modifyer between
		
		$is_modified = $this->modifier_pos;
		$is_seperated = $this->seperator;
		
		$chars_to_skip = ($is_modified > 0)? $chars_to_skip+1:$chars_to_skip;//is_modified tells position of modifier
		$chars_to_skip = ($is_seperated > 0)? $chars_to_skip+1:$chars_to_skip;//is_seperated gives position of seperator
		
		//Lets see if we can extract the phone number
		if(count($positions) > 1){
			$num_in_grp = count($positions);
			$this->phone = substr($args, $positions[$num_in_grp-2], ($positions[$num_in_grp-1]-$positions[$num_in_grp-2]) + 1);//get last group of numbers
			$check_phone = substr($args, $positions[$num_in_grp-2]-1, ($positions[$num_in_grp-2] - $positions[$num_in_grp-2]-1) + 1);
			if($check_phone == "+"){//try verifying that this actually is the phone number
				$start = strlen($this->phone) - PHONE_NUMBER_LENGTH;
				$this->phone = substr($this->phone, $start, PHONE_NUMBER_LENGTH);//make sure we remove leading useless characters
			}else{
				//this is the future and we have another record so handle via recursion
			}
		}
		
		
		//if we know where the phone number is then remove it from further processing
		if($this->phone) $args = trim(substr($args, 0, (strlen($args) - (($positions[$num_in_grp-1]-$positions[$num_in_grp-2]) + 1))));

		//if the phone is caught by args[2] then we want to make sure we dont look for more than 2 positions.
		// = %3D
		
		if((substr(trim($raw_args), 0 ,3) == "MDA")){//handle MDA
			$mda_seperator = 4; //3 + 1 to jump over mda and seperator
			$count_seperated = ($positions[3] - $positions[0]);
			$count_seperated = strlen($raw_args) - $count_seperated;
			$count_seperated = $count_seperated  - 2 - $mda_seperator; //-2 since we jump whatever seperator is used and number 
			$this->action = "register";
			$this->item = ucfirst(substr(trim($raw_args), $mda_seperator , $count_seperated)); 
			if($is_seperated && ($this->seperator > 2) && ($this->seperator < $positions[0])){//capitalize names
				$sections = explode($raw_args{$this->seperator}, $this->item);
				$item_caps = "";
				foreach($sections as $section){
					$item_caps .= ucfirst($section)." ";
				}
				$this->item = trim($item_caps);
			}
			
			$this->location = substr(trim($raw_args), ($count_seperated + 1 + $mda_seperator) , 3); 
		}else if(count($positions) < 3){//handle action
			if(($is_seperated > 0)){
				if(@$args{$is_seperated})$parts = explode($args{$is_seperated}, $args); // explode on seperator if exists before phone number
				if(count(@$parts) > 1){//then this is an action with the item
					$this->action = $this->checkAction(strtolower($parts[0]));
					$this->item = ucfirst($parts[1]);
				}else{//then just the item
					$this->item = ucfirst($args);
					$this->action = "query";
				}
			}
		}else if(count($positions) > 3){//handle item
			//if positions > 2 then the second set of positions must be the phone number
			//if the phone number is already set then any following set of numbers is some saught of error
			$this->item = ucfirst(substr($args, 0, ($positions[0] - $chars_to_skip) + 1));
			$this->qty = substr($args, $positions[0], ($positions[1]-$positions[0]) + 1);
			$this->qty = (is_numeric($this->qty))? $this->qty:null;
		}else{
			$this->item = ucfirst($args);
		}
		
		
	}    
	
	//get the position for the first and last number for each group of numbers in string
	function get_positions($search_str){
		$positions = array();//positions where numbers are found, first and last position for each group
		$count_str = 0;//place in string count
		$in_group = false; //traversing group of numbers
		
		$mods = new modifier;
		$seps = new seperator;
		$chk_mods = new ReflectionObject($mods);
		$chk_seps = new ReflectionObject($seps);
		while($count_str < (strlen($search_str))){ //while we have chars to check
			if((!$in_group) && (is_numeric($search_str{$count_str})) && ($search_str{$count_str} != "e")){//first number in group
				$positions[] = $count_str; 
				$in_group = true; //set
			}else if(($in_group) && (!is_numeric($search_str{$count_str}) || ($search_str{$count_str} == " "))){//last number in group
				$positions[] = (is_numeric($search_str{$count_str + 1}))? $count_str + 1:$count_str - 1;//a number would have come before the current $count_str 
				$in_group = false; //clear
			}
			//get first seperator
			if(empty($this->seperator) && in_array($search_str{$count_str}, $chk_seps->getConstants()))$this->seperator = $count_str;
			
			//get first modifier
			if(empty($this->modifier_pos) && in_array($search_str{$count_str}, $chk_mods->getConstants()))$this->modifier_pos = $count_str;
			
			$count_str++;
		}
		
		if(is_numeric($search_str{$count_str - 1} )) $positions[] = $count_str - 1;
		
		return $positions;
	}
	
	
	function getPhone () {
		return $this->phone;
	}
	
	function getItem () {
		return $this->item;
	}
	
	function getLocation () {
		return $this->location;
	}
	
	function getQty () {
		return $this->qty;
	}
	
	function getModifier () {
		return $this->modifier;
	}
	
	function getAction () {
		return $this->action;
	}
	
	function setModifier ($mod) {
		$this->modifier = $mod;
	}
	
	function check() { //check all fields are set except modifier
		if ($this->item != NULL && ($this->qty !== NULL) && $this->phone != NULL)
			return TRUE;
		else 
			return FALSE;
	}
	
	function checkModifier() {
		$mods = new modifier;
		$enums = new ReflectionObject($mods);
		return in_array($this->modifier, $enums->getConstants());
	}
	
	function checkAction($a) {
		$act = new action;
		$r = new ReflectionObject($act);
		$props = $r->getProperties();
		foreach ($props as $p) {
			if (in_array(strtoupper($a), $p->getValue($act)))  {
				$this->action = $p->getName();
				return TRUE;
			}
		}
		return FALSE;
	}

}


?>
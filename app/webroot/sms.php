<?php
//emulation of enum
class modifier {
    const EQUAL = '=';
    const MINUS = '-';
	const PLUS = '+';
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
	private $qty;
	private $phone;
	private $modifier;
	private $action;
	
	function __construct($args) {
		// Forms are also being processed under the <None> keyword rules
		// This is a hack to skip the message processing if a form is received
		// I would like for this to report nothing back, but FLSMS will still report.
		// Requested to fix that in the forums: http://frontlinesms.ning.com/forum/topics/binary-forms-going-to-the

		if (substr($args[1],0,10) == "AAI+gCUAAA") {
			exit;
		}
		
		if (is_numeric($args[2]) )
			$this->phone = $args[2];
		else 
			$this->phone = NULL;
		
		//an item code is sent
		if (strpos($args[1], ' ') === FALSE )
			$action = "item";
		else
			$action = substr($args[1], 0, strpos($args[1], ' '));
		
		//action case
		if ($this->checkAction($action) ) { //action gets set in checkAction
			if (strpos($args[1], ' ') === FALSE) {
					$this->item = $args[1];
			} else
				$this->item = substr($args[1], strpos($args[1], ' ')+1, strlen($args[1]));
		} else { //update case	
			$this->item = substr($args[1], 0, strpos($args[1], ' '));
			$this->modifier = substr($args[1], strpos($args[1], ' ')+1, 1);
			if (is_numeric($this->modifier) ) { //no modifier given
				$this->qty = substr($args[1], strpos($args[1], $this->modifier), strlen($args[1])) +0; 
				if (!is_numeric($this->qty) )
					$this->qty = NULL;
				$this->modifier = NULL;
			} else {
				$this->qty = substr($args[1], strpos($args[1], $this->modifier) + 1, strlen($args[1])) +0; //+0 to remove sign if positive number
				if (!is_numeric($this->qty) )
					$this->qty = NULL;
			}
		}
		
	}    
	
	function getPhone () {
		return $this->phone;
	}
	
	function getItem () {
		return $this->item;
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
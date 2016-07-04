<?php
//XCMSPro: Web Service entity class
class ReferenceClass
{
    // PRIVATE PROPERTIES
	var $_DS;
	var $_controller;
	var $_config;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function ReferenceClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	// PUBLIC METHODS

	function updateReferenceOptionPositions($entityID,$referenceID)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$input = $SERVER->getInput();
		//set client side variables
		if(empty($entityID) || empty($referenceID))
		{
			return '';
		}
		$query = "SELECT ReferenceOptionID, OptionPosition FROM ReferenceOption WHERE ReferenceID='$referenceID' ORDER BY OptionPosition ASC";			
		$rs = $DS->query($query);
		$i=2;
		foreach($rs as $row)
		{
			$DS->query("UPDATE ReferenceOption SET OptionPosition='$i' WHERE ReferenceOptionID='".$row['ReferenceOptionID']."'");
			$i = $i+2;
		}
		//return $result;		
	}	
} // end of ViewServer
?>
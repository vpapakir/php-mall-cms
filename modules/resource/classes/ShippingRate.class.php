<?php
//XCMSPro: Web Service entity class
class ShippingRateClass
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
	function ShippingRateClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	// PUBLIC METHODS
    /**
    * gets entites
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */
	function getShippingRates($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ShippingRateClass.getShippingRates.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$searchWord = $input['searchWord'];
		
		$entityID = $input['ShippingRateTransport'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'ShippingRateserver.adminShippingRate');		
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM ShippingRate WHERE ShippingRateTransport = '$entityID' $filter ORDER BY ShippingRateDestination";
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ShippingRateClass.getShippingRates.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getShippingRate($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ShippingRateClass.getShippingRate.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ShippingRate'.DTR.'ShippingRateID'];
		if(empty($entityID)) {$entityID = $input['ShippingRateID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ShippingRate'];}
		if(empty($entityAlias)) {$entityAlias = $input['ShippingRateCode'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ShippingRate'.DTR.'ShippingRateCode'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ShippingRateserver.adminShippingRate');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ShippingRateCode='$entityAlias' "; 
		}
		else
		{
			$filter = " ShippingRateID='$entityID' ";
		}
		$query = "SELECT * FROM ShippingRate WHERE $filter"; 
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('ShippingRateClass.getShippingRate.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setShippingRate($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ShippingRateClass.setShippingRate.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ShippingRate'.DTR.'ShippingRateID'];
		if(empty($entityID)) {$entityID = $input['ShippingRateID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ShippingRateserver.adminShippingRate');
		//set queries	
		if(is_array($input['ShippingRate'.DTR.'ShippingRateID']))
		{
			
			foreach($input['ShippingRate'.DTR.'ShippingRateID'] as $id=>$code)
			{
				$inputSave['ShippingRate'.DTR.'ShippingRateID'] = $input['ShippingRate'.DTR.'ShippingRateID'][$id];
				$inputSave['ShippingRate'.DTR.'ShippingRateFee'] = $input['ShippingRate'.DTR.'ShippingRateFee'][$id];
				$inputSave['ShippingRate'.DTR.'ShippingRateExtraSize'] = $input['ShippingRate'.DTR.'ShippingRateExtraSize'][$id];
				$inputSave['ShippingRate'.DTR.'ShippingRateExtraWeight'] = $input['ShippingRate'.DTR.'ShippingRateExtraWeight'][$id];
				$inputSave['ShippingRate'.DTR.'ShippingRateDeliveryTime'] = $input['ShippingRate'.DTR.'ShippingRateDeliveryTime'][$id];
				$where['ShippingRate'] = "ShippingRateID = '".$inputSave['ShippingRate'.DTR.'ShippingRateID']."'";
				$inputSave['actionMode']='save';		
				$result = $DS->save($inputSave,$where);	
			}
		}
		else
		{		
			$where['ShippingRate'] = "ShippingRateID = '".$entityID."'".$filter;
	
			if(!empty($input['ShippingRate'.DTR.'ShippingRateTransport']) && $input['actionMode']=='add')
			{
				$checkRS=$DS->query("SELECT ShippingRateID FROM ShippingRate WHERE ShippingRateTransport='".$input['ShippingRate'.DTR.'ShippingRateTransport']."' AND  ShippingRateDestination='".$input['ShippingRate'.DTR.'ShippingRateDestination']."'");
			}
			if(count($checkRS)<1 && !empty($input['ShippingRate'.DTR.'ShippingRateTransport']) && !empty($input['ShippingRate'.DTR.'ShippingRateDestination']) )
			{		
				$input['actionMode']='save';					
				$result = $DS->save($input,$where);	
			}
			else
			{
				if(!empty($input['ShippingRate'.DTR.'ShippingRateTransport']))
				{
					$SERVER->setMessage('ShippingRateClass.setShippingRate.err.AlreadyExists');
				}
			}
			if(count($result['sql'])>0)	
			{
				$SERVER->setMessage('ShippingRateClass.setShippingRate.msg.DataSaved');
			}
		}
		$SERVER->setDebug('ShippingRateClass.setShippingRate.End','End');		
		return $result;		
	}

	function setShippingRateRate($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ShippingRateRateClass.setShippingRateRate.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ShippingRateRate'.DTR.'ShippingRateRateID'];
		if(empty($entityID)) {$entityID = $input['ShippingRateRateID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ShippingRateRateServer.adminShippingRateRate');
		//set queries	

		$SERVER->setDebug('ShippingRateRateClass.setShippingRateRate.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteShippingRate($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ShippingRateClass.deleteShippingRate.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ShippingRate'.DTR.'ShippingRateID'];
		//if(empty($entityID)) {$entityID = $input['ShippingRateID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ShippingRateserver.adminShippingRate');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ShippingRate WHERE ShippingRateID='$entityID'");
		}
		$SERVER->setMessage('ShippingRateClass.deleteShippingRate.msg.DataDeleted');
		$SERVER->setDebug('ShippingRateClass.deleteShippingRate.End','End');		
		return $result;		
	}	
	
	
} // end of ShippingRateserver
?>
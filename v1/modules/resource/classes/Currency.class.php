<?php
//XCMSPro: Web Service entity class
class CurrencyClass
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
	function CurrencyClass()
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
	function getCurrencies($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CurrencyClass.getCurrencies.Start','Start');
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
		//set filters
		//$filter = $DS->getAccessFilter($input,'Currencieserver.adminCurrency');
		if(!empty($searchWord))
		{
			$filter .= " AND (CurrencyName LIKE '{ls}%$searchWord%{le}' OR CurrencyName LIKE '%$searchWord%' OR CurrencyDescription LIKE '{ls}%$searchWord%{le}' OR CurrencyDescription LIKE '%$searchWord%')";
		}		
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM Currency WHERE CurrencyID>0 $filter ORDER BY CurrencyCode";
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('CurrencyClass.getCurrencies.End','End');
		return $result;
	}	
	
	function getCurrencyRates($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CurrencyClass.getCurrencyRates.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Currency'.DTR.'CurrencyCode'];
		if(empty($entityID)) {$entityID = $input['CurrencyCode'];}
		$searchWord = $input['searchWord'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'Currencieserver.adminCurrency');
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM CurrencyRate WHERE CurrencyFrom = '$entityID' ORDER BY CurrencyTo"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('CurrencyClass.getCurrencyRates.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getCurrency($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CurrencyClass.getCurrency.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Currency'.DTR.'CurrencyID'];
		if(empty($entityID)) {$entityID = $input['CurrencyID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['Currency'];}
		if(empty($entityAlias)) {$entityAlias = $input['CurrencyCode'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Currency'.DTR.'CurrencyCode'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'Currencieserver.adminCurrency');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " CurrencyCode='$entityAlias' "; 
		}
		else
		{
			$filter = " CurrencyID='$entityID' ";
		}
		$query = "SELECT * FROM Currency WHERE $filter"; 
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('CurrencyClass.getCurrency.End','End');		
		return $result;		
	}
	
	function getCurrencyRate($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CurrencyClass.getCurrencyRate.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['CurrencyRate'.DTR.'CurrencyRateID'];
		if(empty($entityID)) {$entityID = $input['CurrencyRateID'];}

		$entityAlias = $input['CurrencyRate'];
		if(empty($entityAlias)) {$entityAlias = $input['CurrencyRateAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['CurrencyRate'.DTR.'CurrencyRateAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'Currencieserver.adminCurrency');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			//$filter = " CurrencyRateAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " CurrencyRateID='$entityID' ";
		}
		$query = "SELECT * FROM CurrencyRate WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('CurrencyClass.getCurrencyRate.End','End');		
		return $result;		
	}

    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setCurrency($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CurrencyClass.setCurrency.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Currency'.DTR.'CurrencyID'];
		if(empty($entityID)) {$entityID = $input['CurrencyID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'Currencieserver.adminCurrency');
		//set queries	

		//if(is_array($input['Currency'.DTR.'AccessGroups'])) {$input['Currency'.DTR.'AccessGroups'] = '|'. implode("|",$input['Currency'.DTR.'AccessGroups']).'|'; }
		$where['Currency'] = "CurrencyID = '".$entityID."'".$filter;

		if(!empty($input['Currency'.DTR.'CurrencyCode']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT CurrencyCode FROM Currency WHERE CurrencyCode='".$input['Currency'.DTR.'CurrencyCode']."'");
		}
		if(count($checkRS)<1 && !empty($input['Currency'.DTR.'CurrencyCode']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		else
		{
			if(!empty($input['Currency'.DTR.'CurrencyCode']))
			{
				$SERVER->setMessage('CurrencyClass.setCurrency.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('CurrencyClass.setCurrency.msg.DataSaved');
		}
		$SERVER->setDebug('CurrencyClass.setCurrency.End','End');		
		return $result;		
	}

	function setCurrencyRate($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CurrencyRateClass.setCurrencyRate.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['CurrencyRate'.DTR.'CurrencyRateID'];
		if(empty($entityID)) {$entityID = $input['CurrencyRateID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'CurrencyRateServer.adminCurrencyRate');
		//set queries	
		if(is_array($input['CurrencyRate'.DTR.'CurrencyFrom']))
		{
			foreach($input['CurrencyRate'.DTR.'CurrencyFrom'] as $id=>$code)
			{
				$rateID = $input['CurrencyRate'.DTR.'CurrencyRateID'][$id];
				$rateTo = $input['CurrencyRate'.DTR.'CurrencyTo'][$id];
				$rateFrom = $input['CurrencyRate'.DTR.'CurrencyFrom'][$id];
				
				if(!empty($rateTo) && !empty($rateFrom))
				{
					if(empty($rateID))
					{
						$checkRS=$DS->query("SELECT CurrencyRateID FROM CurrencyRate WHERE CurrencyFrom='$rateFrom' AND CurrencyTo='$rateTo'");
					}
					if(count($checkRS)<1)
					{		
						$inputSave['CurrencyRate'.DTR.'CurrencyRateID'] = $rateID;
						$inputSave['CurrencyRate'.DTR.'CurrencyFrom'] = $rateFrom;
						$inputSave['CurrencyRate'.DTR.'CurrencyTo'] = $rateTo;
						$inputSave['CurrencyRate'.DTR.'CurrencyRateValue'] = $input['CurrencyRate'.DTR.'CurrencyRateValue'][$id];
						$where['CurrencyRate'] = "CurrencyRateID = '".$rateID."'";
						$inputSave['actionMode']='save';					
						$result = $DS->save($inputSave,$where);	
					}					
				}				
			}
		}
		$SERVER->setDebug('CurrencyRateClass.setCurrencyRate.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteCurrency($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CurrencyClass.deleteCurrency.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Currency'.DTR.'CurrencyID'];
		//if(empty($entityID)) {$entityID = $input['CurrencyID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'Currencieserver.adminCurrency');
		//set queries
		if(!empty($entityID))
		{
			$checkRS = $DS->query("SELECT CurrencyCode FROM Currency WHERE CurrencyID='$entityID'");
			$CurrencyCode = $checkRS[0]['CurrencyCode'];
			$DS->query("DELETE FROM Currency WHERE CurrencyID='$entityID'");
			if(!empty($CurrencyCode))
			{
				$DS->query("DELETE FROM CurrencyRate WHERE (CurrencyFrom='$CurrencyCode' OR CurrencyTo='$CurrencyCode')");
			}
		}
		$SERVER->setMessage('CurrencyClass.deleteCurrency.msg.DataDeleted');
		$SERVER->setDebug('CurrencyClass.deleteCurrency.End','End');		
		return $result;		
	}	
	
	function deleteCurrencyRate($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CurrencyClass.deleteCurrencyRate.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['CurrencyRate'.DTR.'CurrencyRateID'];
		//if(empty($entityID)) {$entityID = $input['CurrencyID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'Currencieserver.adminCurrency');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM CurrencyRate WHERE CurrencyRateID='$entityID'");
		}
		$SERVER->setMessage('CurrencyClass.deleteCurrencyRate.msg.DataDeleted');
		$SERVER->setDebug('CurrencyClass.deleteCurrencyRate.End','End');		
		return $result;		
	}	
} // end of Currencieserver
?>
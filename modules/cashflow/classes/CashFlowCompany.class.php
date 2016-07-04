<?php
//XCMSPro: Web Service entity class
class CashFlowCompanyClass
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
	function CashFlowCompanyClass()
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
	function getCashFlowCompanies($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CashFlowCompanyClass.getCashFlowCompanys.Start','Start');
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
		$manageMode = $input['manageMode'];
		$filterMode = $input['filterMode'];
		
		//set filters
		//$filter = $DS->getAccessFilter($input,'CashFlowCompanyServer.adminCashFlowCompany');
		if(!empty($searchWord))
		{
			$filter .= " AND (CashFlowCompanyName LIKE '%$searchWord%' OR CashFlowCompanyComments LIKE '%$searchWord%')";
		}
		
		if($clientType!='admin' && $manageMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}
		
		if(!empty($input['PermAll']))
		{
			$PermAll = $input['PermAll'];
			$filter .= " AND PermAll='$PermAll' ";
		}
		//echo 'manageMode='.$manageMode;
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		if($filterMode=='last')
		{
			$limit = " LIMIT 0,10";
		}
		
		$query = "SELECT * FROM CashFlowCompany WHERE CashFlowCompanyID>0 $filter ORDER BY CashFlowCompanyName ASC ".$limit;
		
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		//print_r($result);
		
		$query = "SELECT CashFlowAccountID FROM CashFlowAccount WHERE PermAll=1";
		//echo $query;
		//get the content
		$resultS = $DS->query($query); 
		if(is_array($result))
		{
			if(is_array($resultS))
			{
				$filterS .= " AND (";
				foreach($resultS as $key=>$value)
				{
					if($key==0)
						{
							$filterS .= "CashFlowAccountID='".$value['CashFlowAccountID']."'";
						}
							else{
									$filterS .= " OR CashFlowAccountID='".$value['CashFlowAccountID']."'";
								}
				}
				$filterS .= ")";
			}
		
		
			foreach($result as $key=>$value)
			{
				$CashFlowCompany = $value['CashFlowCompanyID'];
				$query = "SELECT SUM(CashFlowBillAmount) as CashFlowAccountAmount,SUM(CashFlowBillVAT) as CashFlowAccountVAT FROM CashFlowBill WHERE CashFlowCompanyID = '$CashFlowCompany' $filterS";
				//echo $query;
				//get the content
				$resultRS = $DS->query($query); 
				$result[$key]['CashFlowCompanyAmount'] = $resultRS[0]['CashFlowAccountAmount'];
				$result[$key]['CashFlowCompanyVAT'] = $resultRS[0]['CashFlowAccountVAT'];
			}
		}
		$SERVER->setDebug('CashFlowCompanyClass.getCashFlowCompanys.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getCashFlowCompany($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CashFlowCompanyClass.getCashFlowCompany.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$manageMode = $input['manageMode'];		
		//set client side variables
		$entityID = $input['CashFlowCompany'.DTR.'CashFlowCompanyID'];
		if(empty($entityID)) {$entityID = $input['CashFlowCompany'];}

		//set filters
		
		if(!empty($entityID))
		{
			$filter = " AND CashFlowCompanyID='$entityID' ";
		}
		
		if($manageMode=='user')
		{
			$filter = " AND UserID='$userID' ";
		}
		
		//set queries
		$query = "SELECT * FROM CashFlowCompany WHERE CashFlowCompanyID>0 $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	

		$SERVER->setDebug('CashFlowCompanyClass.getCashFlowCompany.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setCashFlowCompany($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CashFlowCompanyClass.setCashFlowCompany.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['CashFlowCompany'.DTR.'CashFlowCompanyID'];
		if(empty($entityID)) {$entityID = $input['CashFlowCompanyID'];}		
		if(empty($input['CashFlowCompany'.DTR.'PermAll'])) {$input['CashFlowCompany'.DTR.'PermAll']=4;}
		
		//get resource, section, category or location
		$resourceID = $input['ResourceID'];
		if(empty($resourceID)) $resourceID = $input['CashFlowCompany'.DTR.'ResourceID'];
		$input['CashFlowCompany'.DTR.'ResourceID'] = $resourceID;

		//set filters

		$where['CashFlowCompany'] = "CashFlowCompanyID = '".$entityID."'".$filter;

		if(!empty($input['CashFlowCompany'.DTR.'CashFlowCompanyName']) && $input['actionMode']=='add')
		{
			//$checkRS=$DS->query("SELECT CashFlowCompanyName FROM CashFlowCompany WHERE CashFlowCompanyName='".$input['CashFlowCompany'.DTR.'CashFlowCompanyName']."'");
		}
		if(!empty($input['CashFlowCompany'.DTR.'CashFlowCompanyName']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			$entityID = $result[0]['CashFlowCompanyID'];
		}
		else
		{
			if(!empty($input['CashFlowCompany'.DTR.'CashFlowCompanyName']))
			{
				$SERVER->setMessage('CashFlowCompanyClass.setCashFlowCompany.err.AlreadyExists');
			}
		}
		if(!empty($entityID))	
		{
			$SERVER->setMessage('CashFlowCompanyClass.setCashFlowCompany.msg.DataSaved');
		}

		$SERVER->setDebug('CashFlowCompanyClass.setCashFlowCompany.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteCashFlowCompany($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['CashFlowCompany'.DTR.'CashFlowCompanyID'];
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM CashFlowCompanyRecord WHERE CashFlowCompanyID='$entityID'");
			$DS->query("DELETE FROM CashFlowCompany WHERE CashFlowCompanyID='$entityID'");
		}
		//$SERVER->setMessage('CashFlowCompanyClass.deleteCashFlowCompany.msg.DataDeleted');
		return $result;		
	}	
} // end of CashFlowCompanyServer
?>
<?php
//XCMSPro: Web Service entity class
class CashFlowAccountClass
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
	function CashFlowAccountClass()
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
	function getCashFlowAccounts($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CashFlowAccountClass.getCashFlowAccounts.Start','Start');
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
		$CashFlowCompany = $input['CashFlowCompany'];
		
		//set filters
		//$filter = $DS->getAccessFilter($input,'CashFlowAccountServer.adminCashFlowAccount');
		if(!empty($searchWord))
		{
			$filter .= " AND CashFlowAccountComments LIKE '%$searchWord%'";
		}

		if(!empty($input['PermAll']))
		{
			$PermAll = $input['PermAll'];
			$filter .= " AND PermAll='$PermAll' ";
		}
		if($filterMode=='last')
		{
			$limit = " LIMIT 0,10";
		}
		
		if(!empty($CashFlowCompany))
		{
			$filter .= " AND CashFlowAccountCompany='$CashFlowCompany' ";
		}
		
		//echo 'manageMode='.$manageMode;
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		
			
		$query = "SELECT * FROM CashFlowAccount WHERE CashFlowAccountID>0 $filter ORDER BY CashFlowAccountName".$limit;
			
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		//print_r($result);
		if(is_array($result))
		{
			foreach($result as $key=>$value)
			{
				 $filterSUM = '';
				 if(!empty($CashFlowCompany))
				 {
					$filterSUM .= " AND CashFlowCompanyID = '".$CashFlowCompany."'";
				 }
				 $filterSUM .= " AND CashFlowAccountID = '".$value['CashFlowAccountID']."'";
				 $query = "SELECT SUM(CashFlowBillAmount) as CashFlowBillAmount, SUM(CashFlowBillVAT) as CashFlowBillVAT FROM CashFlowBill WHERE CashFlowBillID>0 $filterSUM ";
				 $resultRS = $DS->query($query);
				 //echo $query;
				 //print_r($resultRS);
				 $result[$key]['CashFlowAccountAmount'] = $resultRS[0]['CashFlowBillAmount'];
				 $result[$key]['CashFlowAccountVAT'] = $resultRS[0]['CashFlowBillVAT'];
				 //print_r($result);
			}
		}
		
		$SERVER->setDebug('CashFlowAccountClass.getCashFlowAccounts.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getCashFlowAccount($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CashFlowAccountClass.getCashFlowAccount.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$manageMode = $input['manageMode'];		
		//set client side variables
		$entityID = $input['CashFlowAccount'.DTR.'CashFlowAccountID'];
		if(empty($entityID)) {$entityID = $input['CashFlowAccountID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['CashFlowAccount'];}
		if(empty($entityAlias)) {$entityAlias = $input['CashFlowAccountAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['CashFlowAccount'.DTR.'CashFlowAccountAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'CashFlowAccountServer.adminCashFlowAccount');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " AND CashFlowAccountAlias='$entityAlias' "; 
		}
		elseif(!empty($entityID))
		{
			$filter = " AND CashFlowAccountID='$entityID' ";
		}
		
		if($manageMode=='user')
		{
			$filter = " AND UserID='$userID' ";
		}
		$query = "SELECT * FROM CashFlowAccount WHERE CashFlowAccountID>0 $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	

		$SERVER->setDebug('CashFlowAccountClass.getCashFlowAccount.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setCashFlowAccount($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CashFlowAccountClass.setCashFlowAccount.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['CashFlowAccount'.DTR.'CashFlowAccountID'];
		if(empty($entityID)) {$entityID = $input['CashFlowAccountID'];}		
		if(empty($input['CashFlowAccount'.DTR.'PermAll'])) {$input['CashFlowAccount'.DTR.'PermAll']=4;}
		//set filters
		
		$where['CashFlowAccount'] = "CashFlowAccountID = '".$entityID."'".$filter;

		if(!empty($input['CashFlowAccount'.DTR.'CashFlowAccountName']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT CashFlowAccountName FROM CashFlowAccount WHERE CashFlowAccountName='".$input['CashFlowAccount'.DTR.'CashFlowAccountName']."'");
		}
		if(!empty($input['CashFlowAccount'.DTR.'CashFlowAccountName']))
		{		
			$input['CashFlowAccount'.DTR.'CashFlowAccountName'] = str_replace(",",".",$input['CashFlowAccount'.DTR.'CashFlowAccountInitValue']);
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			$entityID = $result[0]['CashFlowAccountID'];
		}
		else
		{
			if(!empty($input['CashFlowAccount'.DTR.'CashFlowAccountName']))
			{
				$SERVER->setMessage('CashFlowAccountClass.setCashFlowAccount.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('CashFlowAccountClass.setCashFlowAccount.msg.DataSaved');
		}
		//if(!empty($input['CashFlowAccount'.DTR.'CashFlowAccountAlias']))
		//{
			//$this->updateEntityPositions($entityID,'CashFlowAccount');
		//}
		$SERVER->setDebug('CashFlowAccountClass.setCashFlowAccount.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteCashFlowAccount($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['CashFlowAccount'.DTR.'CashFlowAccountID'];
		if(!empty($entityID))
		{
			//$DS->query("DELETE FROM CashFlowAccountRecord WHERE CashFlowAccountID='$entityID'");
			$DS->query("DELETE FROM CashFlowAccount WHERE CashFlowAccountID='$entityID'");
		}
		//$SERVER->setMessage('CashFlowAccountClass.deleteCashFlowAccount.msg.DataDeleted');
		return $result;		
	}	
} // end of CashFlowAccountServer
?>
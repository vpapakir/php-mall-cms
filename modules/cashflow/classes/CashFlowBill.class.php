<?php
//XCMSPro: Web Service entity class
class CashFlowBillClass
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
	function CashFlowBillClass()
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
	function getCashFlowBills($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CashFlowBillClass.getCashFlowBills.Start','Start');
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
		$CashFlowAccountID = $input['CashFlowAccountID'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'CashFlowBillServer.adminCashFlowBill');
		if(!empty($searchWord))
		{
			$filter .= " AND CashFlowBillContent LIKE '%$searchWord%'";
		}
		
		if(!empty($input['CashFlowBillsDateFrom_Day']))
		{
			$CashFlowBillsDateFrom = date('Y-m-d H:m:s',mktime(0, 0, 0, $input['CashFlowBillsDateFrom_Month'], $input['CashFlowBillsDateFrom_Day'], $input['CashFlowBillsDateFrom_Year']));
			$CashFlowBillsDateTo = date('Y-m-d H:m:s',mktime(0, 0, 0, $input['CashFlowBillsDateTo_Month'], $input['CashFlowBillsDateTo_Day'], $input['CashFlowBillsDateTo_Year']));
			$filter .= " AND  CashFlowBillDate >= '$CashFlowBillsDateFrom' AND  CashFlowBillDate <= '$CashFlowBillsDateTo' ";
			$SERVER->setInputVar('CashFlowBillsDateFrom',$CashFlowBillsDateFrom);
			$SERVER->setInputVar('CashFlowBillsDateTo',$CashFlowBillsDateTo);
		}
		
		if(!empty($CashFlowCompany))
		{
			$filter .= " AND  CashFlowCompanyID = '$CashFlowCompany' ";
		}	
		
		if(!empty($CashFlowAccountID))
		{
			$filter .= " AND  CashFlowAccountID = '$CashFlowAccountID' ";
		}
		
		if(!empty($input['CashFlowBillStatus']))
		{
			$filter .= " AND  CashFlowBillStatus = '".$input['CashFlowBillStatus']."'";
		}
		
		if(!empty($input['CashFlowBillPurpose']))
		{
			$filter .= " AND  CashFlowBillPurpose = '".$input['CashFlowBillPurpose']."'";
		}
		//set queries
		if($filterMode=='last')
		{
			$limit = " LIMIT 0,10";
		}
		
		$query = "SELECT * FROM CashFlowBill WHERE CashFlowBillID>0 $filter ORDER BY CashFlowBillDate DESC ".$limit;
		
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('CashFlowBillClass.getCashFlowBills.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	
	function getCashFlowBill($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CashFlowBillClass.getCashFlowBill.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$manageMode = $input['manageMode'];		
		//set client side variables
		$entityID = $input['CashFlowBill'.DTR.'CashFlowBillID'];
		if(empty($entityID)) {$entityID = $input['CashFlowBillID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['CashFlowBill'];}
		if(empty($entityAlias)) {$entityAlias = $input['CashFlowBillAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['CashFlowBill'.DTR.'CashFlowBillAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'CashFlowBillServer.adminCashFlowBill');
		//set queries
		$query ='';
		if(!empty($entityAlias))
		{
			$filter = " AND CashFlowBillAlias='$entityAlias' "; 
		}
		elseif(!empty($entityID))
		{
			$filter = " AND CashFlowBillID='$entityID' ";
		}
		
		if($manageMode=='user')
		{
			$filter = " AND UserID='$userID' ";
		}
		$query = "SELECT * FROM CashFlowBill WHERE CashFlowBillID>0 $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	

		$SERVER->setDebug('CashFlowBillClass.getCashFlowBill.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setCashFlowBill($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CashFlowBillClass.setCashFlowBill.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['CashFlowBill'.DTR.'CashFlowBillID'];
		if(empty($entityID)) {$entityID = $input['CashFlowBillID'];}		
		if(empty($input['CashFlowBill'.DTR.'PermAll'])) {$input['CashFlowBill'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')) {$input['CashFlowBill'.DTR.'PermAll']=4;}
		if(empty($input['CashFlowBill'.DTR.'CashFlowBillVAT']))
			{
				$input['CashFlowBill'.DTR.'CashFlowBillVAT'] = $input['CashFlowBill'.DTR.'CashFlowBillAmount']*0.15;
			}
		//get resource, section, category or location
		$resourceID = $input['ResourceID'];
		if(empty($resourceID)) $resourceID = $input['CashFlowBill'.DTR.'ResourceID'];
		$input['CashFlowBill'.DTR.'ResourceID'] = $resourceID;
		
		$categoryID = $input['CategoryID'];
		if(empty($categoryID)) $input['CashFlowBill'.DTR.'ResourceCategoryID'];
		if(empty($categoryID))
		{
			$categoryAlias = $input['category'];
			if(!empty($categoryAlias))
			{
				$categoryIDRS = $DS->query("SELECT ResourceCategoryID FROM ResourceCategory WHERE ResourceCategoryAlias='$categoryAlias'");
				$categoryID = $categoryIDRS[0]['ResourceCategoryID'];
			}
		}
		$input['CashFlowBill'.DTR.'ResourceCategoryID'] = $categoryID;
		//set filters
		//$filter = $DS->getAccessFilter($input,'CashFlowBillServer.adminCashFlowBill');
		//set queries	
		//if(is_array($input['CashFlowBill'.DTR.'CashFlowBillLanguages'])) {$input['CashFlowBill'.DTR.'CashFlowBillLanguages'] = '|'. implode("|",$input['CashFlowBill'.DTR.'CashFlowBillLanguages']).'|'; }
		//if(is_array($input['CashFlowBill'.DTR.'CashFlowBillCategories'])) {$input['CashFlowBill'.DTR.'CashFlowBillCategories'] = '|'. implode("|",$input['CashFlowBill'.DTR.'CashFlowBillCategories']).'|'; }
			
		//if(is_array($input['CashFlowBill'.DTR.'AccessGroups'])) {$input['CashFlowBill'.DTR.'AccessGroups'] = '|'. implode("|",$input['CashFlowBill'.DTR.'AccessGroups']).'|'; }
		$where['CashFlowBill'] = "CashFlowBillID = '".$entityID."'".$filter;

		/*if(!empty($input['CashFlowBill'.DTR.'CashFlowBillTitle']) && $input['actionMode']=='add')
		{
			//$checkRS=$DS->query("SELECT CashFlowBillAlias FROM CashFlowBill WHERE CashFlowBillAlias='".$input['CashFlowBill'.DTR.'CashFlowBillAlias']."'");
		}
		if(!empty($input['CashFlowBill'.DTR.'CashFlowBillTitle']))
		{*/		
			$input['CashFlowBill'.DTR.'CashFlowBillAmount'] = str_replace(",",".",$input['CashFlowBill'.DTR.'CashFlowBillAmount']);
			$input['CashFlowBill'.DTR.'CashFlowBillVAT'] = str_replace(",",".",$input['CashFlowBill'.DTR.'CashFlowBillVAT']);
			$patterns = array ("/(\d{1,2})-(\d{1,2})-(19|20)(\d{2})/");
			$replace = array ("\\3\\4-\\2-\\1");
		
			$input['CashFlowBill'.DTR.'CashFlowBillDate'] = preg_replace($patterns, $replace,$input['CashFlowBill'.DTR.'CashFlowBillDate']);
			
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			$entityID = $result[0]['CashFlowBillID'];
		/*}
		else
		{
			if(!empty($input['CashFlowBill'.DTR.'CashFlowBillTitle']))
			{
				$SERVER->setMessage('CashFlowBillClass.setCashFlowBill.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('CashFlowBillClass.setCashFlowBill.msg.DataSaved');
		}*/
		//if(!empty($input['CashFlowBill'.DTR.'CashFlowBillAlias']))
		//{
			//$this->updateEntityPositions($entityID,'CashFlowBill');
		//}
		$SERVER->setDebug('CashFlowBillClass.setCashFlowBill.End','End');		
		return $result;		
	}
	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteCashFlowBill($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['CashFlowBill'.DTR.'CashFlowBillID'];
		if(!empty($entityID))
		{
			//$DS->query("DELETE FROM CashFlowBillRecord WHERE CashFlowBillID='$entityID'");
			$DS->query("DELETE FROM CashFlowBill WHERE CashFlowBillID='$entityID'");
		}
		//$SERVER->setMessage('CashFlowBillClass.deleteCashFlowBill.msg.DataDeleted');
		return $result;		
	}	


	function getSumCashFlowBills($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CashFlowBillClass.getSumCashFlowBills.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$manageMode = $input['manageMode'];
		$CashFlowCompany = $input['CashFlowCompany'];
		
		$query = "SELECT CashFlowAccountID FROM CashFlowAccount WHERE PermAll=1";
		//echo $query;
		//get the content
		$resultRS = $DS->query($query); 
		
		if(is_array($resultRS))
		{
			$filter .= " AND (";
			foreach($resultRS as $key=>$value)
			{
				if($key==0)
					{
						$filter .= "CashFlowAccountID='".$value['CashFlowAccountID']."'";
					}
						else{
								$filter .= " OR CashFlowAccountID='".$value['CashFlowAccountID']."'";
							}
			}
			$filter .= ")";
		}
				
		if(!empty($CashFlowCompany))
		{
			$filter .= " AND CashFlowCompanyID = '$CashFlowCompany'";
		}
		
		$query = "SELECT SUM(CashFlowBillAmount) as SumAmount, SUM(CashFlowBillVAT) as SumVAT FROM CashFlowBill WHERE CashFlowBillID>0".$filter;
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('CashFlowBillClass.getSumCashFlowBills.End','End');
		return $result;
	}
	
} // end of CashFlowBillServer
?>
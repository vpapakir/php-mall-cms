<?php
//XCMSPro: Web Service entity class

class ServiceServer
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
	function ServiceServer($controller,$ds)
	{
		$this->_controller = &$controller;
		$this->_DS = &$ds;
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
	function getServices($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CategoryServer.getCategories.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Service'.DTR.'ServiceID'];
		if(empty($entityID)) {$entityID = $input['ServiceID'];}
		$entityAlias = $input['Service'.DTR.'ServiceAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['ServiceAlias'];}
		
		if(empty($entityAlias)) {$entityAlias = $input['category'];}

		
		$categoryID = $input['Service'.DTR.'CategoryID'];
		if(empty($categoryID)) {$categoryID = $input['CategoryID'];}
		if( empty($categoryID) && !empty($entityAlias))
		{
			$catRS = $DS->query("SELECT CategoryID FROM {dbprefix}Category WHERE CategoryAlias='$entityAlias'");
			$categoryID = $catRS['sql'][0]['CategoryID'];
		}		
		$searchWord = $input['searchWord'];
		//set filters
		$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		if(!empty($searchWord))
		{
			$filter .= " AND (ServiceName LIKE '{ls}%$searchWord%{le}' OR ServiceName LIKE '%$searchWord%' OR ServiceDescription LIKE '{ls}%$searchWord%{le}' OR ServiceDescription LIKE '%$searchWord%' OR ServiceComments LIKE '%$searchWord%')";
		}
		if(!empty($categoryID))		
		{
			$filter .= " AND CategoryID = '$categoryID' ";
		}
		//set queries
		$query = "Service[1 $filter]/sortasc(Service.ServicePosition)"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ServiceServer.getServices.End','End');
		return $result;
	}	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getService($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ServiceServer.getService.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Service'.DTR.'ServiceID'];
		if(empty($entityID)) {$entityID = $input['ServiceID'];}
		$entityAlias = $input['Service'.DTR.'ServiceAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['ServiceAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['service'];}
		//set filters
		$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		$query =='';
		if(!empty($entityID))
		{
			$query = "Service[ServiceID='$entityID' $filter]/"; 
		}
		elseif(!empty($entityAlias))
		{
			$query = "Service[ServiceAlias='$entityAlias' $filter]/"; 
		}
		//get the content
		if(!empty($query))
		{
			$result = $DS->query($query); 		
		}
		else
		{
			$SERVER->setMessage('ServiceServer.getService.err.NoServiceID');
		}
		$SERVER->setDebug('ServiceServer.getService.End','End');		
		return $result;		
	}
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setService($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ServiceServer.setService.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Service'.DTR.'ServiceID'];
		if(empty($entityID)) {$entityID = $input['ServiceID'];}		
		//set filters
		$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		if(is_array($input['Service'.DTR.'ServiceID']))
		{
			while (list($fieldNimber,$fieldValue)= each($input['Service'.DTR.'ServiceID'])) 
			{
				$where['Service'][] = "ServiceID = '".$fieldValue."'".$filter;
			}
		}
		else
		{
			$where['Service'] = "ServiceID = '".$entityID."'".$filter;
		}		
		$result = $DS->save($input,$where);	
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ServiceServer.setService.msg.DataSaved');
		}
		$SERVER->setDebug('ServiceServer.setService.End','End');		
		return $result;		
	}
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteService($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ServiceServer.deleteService.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Service'.DTR.'ServiceID'];
		if(empty($entityID)) {$entityID = $input['ServiceID'];}		
		//set filters
		$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		$input['actionMode']='delete';
		$where['Service'] = "ServiceID = '".$entityID."'$filter";
		$result = $DS->save($input,$where);	
		$SERVER->setMessage('ServiceServer.deleteService.msg.DataDeleted');
		$SERVER->setDebug('ServiceServer.deleteService.End','End');		
		return $result;		
	}		

    /**
    * This method withdraw money from user's balance for selected service
    *
    * @param	array	$input		variables sent from the cleint
	*					service		service alias (can be ServiceID or ServiceAlias)
	*					Reason		reason description text
	*					ResourceID	ResourceID- required. For example ID of profile or of an ad post
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function buyService($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		//check rights
		if(!$SERVER->hasRights('user'))
		{
			$SERVER->setMessage('ServiceServer.buyService.err.NoRights');
			return false;
		}		
		$SERVER->setDebug('ServiceServer.buyService.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		if($SERVER->hasRights('ServiceServer.buyService.BuyAsAdmin') && !empty($input['UserID']))
		{
			$userID = $input['UserID'];
		}	
		else
		{
			$userID = $user['UserID'];
		}		
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Service'.DTR.'ServiceID'];
		if(empty($entityID)) {$entityID = $input['ServiceID'];}
		$entityAlias = $input['Service'.DTR.'ServiceAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['ServiceAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['service'];}
		$quantity = $input['Quantity'];
		//set filters
		$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		$query =='';
		if(!empty($entityID))
		{
			$query = "Service[ServiceID='$entityID' $filter]/"; 
		}
		elseif(!empty($entityAlias))
		{
			$query = "Service[ServiceAlias='$entityAlias' $filter]/"; 
		}

		//get the content
		if(!empty($query))
		{
			$result = $DS->query($query); 
			if(count($result['sql'])>0)		
			{
				if(!empty($input['ResourceID']))
				{
					$servicePrice = $result['sql'][0]['Service'.DTR.'ServicePrice'];
					if(!empty($quantity))
					{
						$servicePrice = $quantity * $servicePrice;
					}					
					$inBalance['UserID']=$userID;
					$balanceRS = $SERVER->callService('getBalance','billingServer',$inBalance,'array');
					$balance = $balanceRS['array']['ServiceResponse']['#']['Balance'][0]['#'];
					$resultBalance=$balance-$servicePrice;
					//echo 'ttttttttt='.$balance.'<hr>';
					if($config['PromoMode']=='active')
					{					
						//check for no bonus
						$inBalanceNoBonus['UserID']=$userID;
						$inBalanceNoBonus['BalanceType']='nobonus';
						$balanceNoBonusRS = $SERVER->callService('getBalance','billingServer',$inBalanceNoBonus,'array');
						$balanceNoBonus = $balanceNoBonusRS['array']['ServiceResponse']['#']['Balance'][0]['#'];
					}								
					
					if($resultBalance>=0)
					{
						$servicePeriod = $result['sql'][0]['Service'.DTR.'ServicePeriod'];
						if($servicePeriod>0)
						{
							$endTimeSTP = time() + ($servicePeriod*60*60*24);
							$endTime = date('Y-m-d H:i:s',$endTimeSTP);
						}
						$transactionInput ['BillingTransaction'.DTR.'UserID'] = $userID;
						$transactionInput ['BillingTransaction'.DTR.'TransactionReceiverID'] = $ownerID;
						$transactionInput ['BillingTransaction'.DTR.'TransactionSenderID'] = $userID;
						$transactionInput ['BillingTransaction'.DTR.'TransactionReason'] = 'buy';
						$transactionInput ['BillingTransaction'.DTR.'TransactionReasonDescription'] = $SERVER->getLanguageFieldValue($result['sql'][0]['Service'.DTR.'ServiceName']).':'.$input['Reason'];					
						$transactionInput ['BillingTransaction'.DTR.'TransactionType'] = 'system';
						$transactionInput ['BillingTransaction'.DTR.'TransactionAmount'] = $servicePrice;
						$transactionInput ['BillingTransaction'.DTR.'TransactionCreator'] = $input['ResourceID'];
						if(!empty($endTime)){$transactionInput ['BillingTransaction'.DTR.'TimeEnd'] = $endTime;}
						$transactionInput ['actionMode'] = 'save';
						//print_r($transactionInput);
						$addTransactionResult = $SERVER->callService('addTransaction','billingServer',$transactionInput,'array');
						//print_r($addTransactionResult['array']);
						//echo $addTransactionResult['xml'];
						$transactionIDRS = $addTransactionResult['array']['ServiceResponse']['#']['BillingTransaction'][0]['#']['BillingTransactionID'][0]['#'];
						if(empty($transactionIDRS))
						{
							$SERVER->setVars('PaymentResult','AlreadyPaid');	
							$SERVER->setVars('TransactionID',$transactionIDRS);	
						}
						else
						{
							$SERVER->setVars('PaymentResult','OK');
							$SERVER->setVars('TransactionID',$transactionIDRS);								
							if($config['PromoMode']=='active')
							{
								if($balanceNoBonus>=$servicePrice)
								{
									$promoInput ['PromoReferralUser'] = $userID;
									$promoInput ['PromoReferralSession'] = $input['XCMSPromoCode'];
									$promoInput ['PromoReferralIP'] = $input['RemoteIP'];
									$promoInput ['PromoResource'] = $config['ApplicationDomain'];
									$promoInput ['PromoReferralAction'] = 'pay';
									$promoInput ['PromoReferralActionDetails'] = $transactionInput ['BillingTransaction'.DTR.'TransactionReasonDescription'];
									$promoInput ['PromoReferralAmount'] = $servicePrice;		
									$promoInput ['TransactionKey'] = $input['ResourceID'];
									$promoResult = $SERVER->callService('setReferralAction','promoServer',$promoInput);
								}
							}							
						}
						$SERVER->setVars('Balance',$resultBalance);
					}
					else
					{
						$SERVER->setMessage('ServiceServer.buyService.err.NoMoney');
						$SERVER->setVars('PaymentResult','NoMoney');	
						$SERVER->setVars('Balance',$balance);
					}
				}
				else
				{
					$SERVER->setMessage('ServiceServer.buyService.err.NoResourceID');					
				}
			}
			else
			{
				$SERVER->setMessage('ServiceServer.buyService.err.WrongService');
			}
		}
		else
		{
			$SERVER->setMessage('ServiceServer.buyService.err.NoServiceID');
		}
		$SERVER->setDebug('ServiceServer.buyService.End','End');		
		return $result;		
	}
	
    /**
    * This method adds a transfer order from user's account to site owner account
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function orderService($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		//check rights
		if(!$SERVER->hasRights('user'))
		{
			$SERVER->setMessage('ServiceServer.orderService.err.NoRights');
			return false;
		}
		$SERVER->setDebug('ServiceServer.getService.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Service'.DTR.'ServiceID'];
		if(empty($entityID)) {$entityID = $input['ServiceID'];}
		$entityAlias = $input['Service'.DTR.'ServiceAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['ServiceAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['service'];}
		//set filters
		$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		$query =='';
		if(!empty($entityID))
		{
			$query = "Service[ServiceID='$entityID' $filter]/"; 
		}
		elseif(!empty($entityAlias))
		{
			$query = "Service[ServiceAlias='$entityAlias' $filter]/"; 
		}
		//get the content
		if(!empty($query))
		{
			$result = $DS->query($query); 		
		}
		else
		{
			$SERVER->setMessage('ServiceServer.orderService.err.NoServiceID');
		}
		$SERVER->setDebug('ServiceServer.orderService.End','End');		
		return $result;		
	}		

	// add a buy service order
	function requestService($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		//check rights
		if(!$SERVER->hasRights('user'))
		{
			$SERVER->setMessage('ServiceServer.buyService.err.NoRights');
			return false;
		}		
		$SERVER->setDebug('ServiceServer.buyService.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Service'.DTR.'ServiceID'];
		if(empty($entityID)) {$entityID = $input['ServiceID'];}
		$entityAlias = $input['Service'.DTR.'ServiceAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['ServiceAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['service'];}
		//set filters
		$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		$query =='';
		if(!empty($entityID))
		{
			$query = "Service[ServiceID='$entityID' $filter]/"; 
		}
		elseif(!empty($entityAlias))
		{
			$query = "Service[ServiceAlias='$entityAlias' $filter]/"; 
		}

		//get the content
		if(!empty($query))
		{
			$result = $DS->query($query); 
			if(count($result['sql'])>0)		
			{
				$servicePrice = $result['sql'][0]['Service'.DTR.'ServicePrice'];
				$balanceRS = $SERVER->callService('getBalance','billingServer','','array');
				$balance = $balanceRS['array']['ServiceResponse']['#']['Balance'][0]['#'];
				$resultBalance=$balance-$servicePrice;
				if($resultBalance>0)
				{
					$billingOrderIN['BillingOrder'.DTR.'OrderType'] = 'buyservice';
					$billingOrderIN['BillingOrder'.DTR.'OrderAmount'] = $servicePrice;
					$billingOrderIN['BillingOrder'.DTR.'OrderDescription'] = $SERVER->getLanguageFieldValue($result['sql'][0]['Service'.DTR.'ServiceName']).": ".$input['ServiceComments'];
					$billingOrderIN['BillingOrder'.DTR.'OrderPaymentDetails'] = $input['ServiceDetails'];
					
					$billingOrderIN['actionMode'] = 'save';
					$addBillingOrderResult = $SERVER->callService('manageOrder','billingServer',$billingOrderIN);

					$SERVER->setVars('Balance',$resultBalance);
					$SERVER->setVars('BuyResult','OK');
				}
				else
				{
					$SERVER->setMessage('ServiceServer.buyService.err.NoMoney');
					$SERVER->setVars('BuyResult','NoMoney');	
					$SERVER->setVars('Balance',$balance);
				}
			}
			else
			{
				$SERVER->setMessage('ServiceServer.buyService.err.WrongService');
			}
		}
		else
		{
			$SERVER->setMessage('ServiceServer.buyService.err.NoServiceID');
		}
		$SERVER->setDebug('ServiceServer.buyService.End','End');		
		return $result;		
	}
	
} // end of ServiceServer
?>
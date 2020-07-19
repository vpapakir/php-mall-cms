<?php
//XCMSPro: Web Service entity class
class ServiceClass
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
	function ServiceClass()
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
	function getServices($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ServiceClass.getServices.Start','Start');
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
		
		$categoryAlias = $input['ServiceCategory'];
		$categoryID = $input['CategoryID'];
		$sectionID = $input['SID'];
		
		$serviceType = $input['ServiceType'];
		$serviceFeaturedOption = $input['ServiceFeaturedOption'];
		$permAll = $input['PermAll'];
		$serviceStatus = $input['ServiceStatus'];
		$filterMode = $input['filterMode'];
		$featuredMode = $input['featuredMode'];
		
		$priceRange = $input['PriceRange'];
		
		//print_r($input);
		//set filters
		//$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		if(!empty($priceRange))
		{
			$filter = " AND ((ServicePriceRangeMin <= $priceRange AND ServicePriceRangeMax >= $priceRange) OR (ServicePriceRangeMin <= $priceRange AND ServicePriceRangeMax=0)) ";
			if(!empty($categoryID))
			{
				$filter .= " AND ServiceCategories LIKE '%|".$categoryID."|%'";
			}
		}		
		
		if(!empty($categoryAlias))
		{
			$categoryIDRS = $DS->query("SELECT ServiceCategoryID FROM ServiceCategory WHERE ServiceCategoryAlias='$categoryAlias'");
			$categoryID = $categoryIDRS[0]['ServiceCategoryID'];
		}

		
		if($filterMode=='last')
		{
			$filter .= " AND PermAll='4' ";
			$limit = " LIMIT 0,30";
		}
		if(!empty($categoryID))
		{
			$filter .= " AND ServiceCategories LIKE '%|$categoryID|%' ";
		}		
		/*if(!empty($serviceType))
		{
			$filter .= " AND ServiceType='$serviceType' ";
		}*/	
		if(!empty($serviceStatus))
		{
			//$filter .= " AND ServiceStatus='$serviceStatus' ";
		}			
		if(!empty($serviceFeaturedOption))
		{
			$filter .= " AND ServiceFeaturedOptions LIKE '%|$serviceFeaturedOption|%' ";
		}	
		if(!empty($permAll) && $SERVER->hasRights('content'))
		{
			$filter .= " AND PermAll='$permAll' ";
		}			
		if($clientType!='admin' && $manageMode=='user')
		{
			$filter .= " AND UserID='$userID' ";
		}
		if(!empty($searchWord))
		{
			$filter .= " AND (ServiceTitle LIKE '%$searchWord%' OR ServiceLink LIKE '%$searchWord%' OR ServiceReciprocalLink LIKE '%$searchWord%' OR ServiceIntro LIKE '%$searchWord%' OR ServiceContent LIKE '%$searchWord%' OR ServiceKeywords LIKE '%$searchWord%' OR ServiceAuthor LIKE '%$searchWord%' OR ServiceLocation LIKE '%$searchWord%')  ";
		}	
		if(!empty($featuredMode))
		{
			$filter .= " AND ServiceFeaturedOptions LIKE '%|$featuredMode|%' ";
		}		
		
		if(empty($filter))
		{
			$noRequest = 'Y';
		}
		
		if($clientType!='admin' && $manageMode!='user' && $filterMode!='last')
		{
			$filter .= " AND PermAll='1' ";
		}		
		//echo 'manageMode='.$manageMode;
		//$filter .= "OwnerID='$ownerID' ";
		if(empty($limit))
		{
			$pages = $DS->getPages('Service',"ServiceID>0 $filter",array('ItemsPerPage'=>$itemsPerPage));
			$limit = ' LIMIT '.$pages['begin'].','.$pages['step'];
		}
		//set queries
		if($noRequest != 'Y')
		{
			$query = "SELECT * FROM Service WHERE ServiceID>0 $filter ORDER BY ServicePosition";
			//get the content
			$result['result'] = $DS->query($query); 
			$result['pages'] = $pages['pages'];
			//echo 'query='.$query;
		}
		$SERVER->setDebug('ServiceClass.getServices.End','End');
		return $result;
	}	
	
	function getActiveServicesFilter()
	{
		
	}
	
	function getServiceFieldsStructureAndValues($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ServiceClass.getServiceFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$viewMode = $input['viewMode'];
		//set client side variables
		$entityType = $input['SourceType'];
		if(empty($entityType)) {$entityType = $input['ServiceType'];}
		
		$entityID = $input['Service'.DTR.'ServiceID'];
		if(empty($entityID)) {$entityID = $input['ServiceID'];}
		
		$entityAlias = $input['Service'];
		if(empty($entityAlias)) {$entityAlias = $input['ServiceAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Service'.DTR.'ServiceAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$ServiceIDRS = $DS->query("SELECT ServiceID FROM Service WHERE ServiceAlias='$entityAlias'");
			$entityID = $ServiceIDRS[0]['ServiceID'];
		}
		//$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//$filter .= "OwnerID='$ownerID' ";

		$ServiceTypeIDRS = $DS->query("SELECT ServiceTypeID FROM ServiceType WHERE ServiceTypeAlias='$entityType'");
		$ServiceTypeID = $ServiceTypeIDRS[0]['ServiceTypeID'];
		$query = "SELECT * FROM ServiceTypeField LEFT JOIN ServiceTypeOption ON ServiceTypeField.ServiceTypeFieldID = ServiceTypeOption.ServiceTypeFieldID WHERE ServiceTypeField.ServiceType = '$entityType' $filter ORDER BY ServiceTypeFieldPosition, ServiceTypeOptionPosition"; 
		//$query = "SELECT * FROM (ServiceField LEFT JOIN ServiceTypeField ON ServiceField.ServiceTypeFieldID = ServiceTypeField.ServiceTypeFieldID) LEFT JOIN ServiceTypeOption ON ServiceTypeField.ServiceTypeFieldID = ServiceTypeOption.ServiceTypeFieldID WHERE ServiceTypeField.ServiceType = '$entityType' AND ServiceID='$entityID' $filter ORDER BY ServiceTypeFieldPosition, ServiceTypeOptionPosition"; 		
		$rs = $DS->query($query);
		//echo 'rrrrrrrr='.$query;
		$i=0;
		if(is_array($rs))
		{
			foreach($rs as $row)
			{
				$fieldCode = $row['ServiceTypeFieldAlias'];
				$fieldName = $row['ServiceTypeFieldName'];
				$fieldType = $row['ServiceTypeFieldType'];
				$fieldMode = $row['ServiceTypeFieldMode'];
				$fieldPlaces = $row['ServiceTypeFieldHidenPlaces'];
				$fieldOptionID = $row['ServiceTypeOptionID'];
				$fieldOptionAlias = $row['ServiceTypeOptionAlias'];
				$fieldOptionValue = $row['ServiceTypeOptionName'];
				
				$fieldOptionPrice = $row['ServiceTypeOptionPrice'];
				$fieldOptionPriceAction = $row['ServiceTypeOptionPriceAction'];
				$fieldOptionWeight = $row['ServiceTypeOptionWeight'];
				$fieldOptionWeightAction = $row['ServiceTypeOptionWeightAction'];
				$fieldOptionPosition = $row['ServiceTypeOptionPosition'];
				
				$result['ServiceFieldTypes'][$fieldCode]['code'] = $fieldCode;
				$result['ServiceFieldTypes'][$fieldCode]['name'] = $fieldName;
				$result['ServiceFieldTypes'][$fieldCode]['type'] = $fieldType;
				$result['ServiceFieldTypes'][$fieldCode]['mode'] = $fieldMode;
				$result['ServiceFieldTypes'][$fieldCode]['places'] = $fieldPlaces;
				
				if(!empty($fieldOptionAlias))
				{
					//$result['ServiceFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionAlias;
					$result['ServiceFieldTypes'][$fieldCode]['options'][$i]['id'] = $fieldOptionID;				
					$result['ServiceFieldTypes'][$fieldCode]['options'][$i]['value'] = $fieldOptionValue;					
					$result['ServiceFieldTypes'][$fieldCode]['options'][$i]['position'] = $fieldOptionPosition;
					if($fieldMode=='option')
					{
						$result['ServiceFieldTypes'][$fieldCode]['options'][$i]['optionid'] = $fieldOptionID;
						//$result['ServiceFieldTypes'][$fieldCode]['options'][$i]['price'] = $fieldOptionPrice;
						//$result['ServiceFieldTypes'][$fieldCode]['options'][$i]['priceaction'] = $fieldOptionPriceAction;
						//$result['ServiceFieldTypes'][$fieldCode]['options'][$i]['weight'] = $fieldOptionWeight;
						//$result['ServiceFieldTypes'][$fieldCode]['options'][$i]['weightaction'] = $fieldOptionWeightAction;

						$result['ServiceOption'][$fieldOptionID]['ServiceOptionPrice'] = $fieldOptionPrice;
						$result['ServiceOption'][$fieldOptionID]['ServiceOptionPriceAction'] = $fieldOptionPriceAction;
						$result['ServiceOption'][$fieldOptionID]['ServiceOptionWeight'] = $fieldOptionWeight;
						$result['ServiceOption'][$fieldOptionID]['ServiceOptionWeightAction'] = $fieldOptionWeightAction;
						
					}
					$typeOptionsIDs[$fieldOptionID] = $fieldOptionID;
				}
				$i++;
			}
		}
		
		$query = "SELECT * FROM ServiceField LEFT JOIN ServiceOption ON ServiceField.ServiceFieldID = ServiceOption.ServiceFieldID WHERE ServiceID='$entityID' $filter ORDER BY ServiceFieldPosition, ServiceOptionPosition"; 
		//$query = "SELECT * FROM ServiceField WHERE ServiceID='$entityID' $filter ORDER BY ServiceFieldPosition"; 
		
		$rs = $DS->query($query);
		//print_r($rs);
		if(is_array($rs))
		{
			$languagesList = $SERVER->getLanguages();

			foreach($rs as $row)
			{
				$fieldCode = $row['ServiceFieldAlias'];
				$fieldType = $row['ServiceFieldType'];
				
				$serviceFieldID = $row['ServiceFieldID'];
				$fieldOptionID = $row['ServiceOptionID'];
				
				$fieldTypeOptionID = $row['ServiceTypeOptionID'];
				
				$fieldOptionStatus = $row['ServiceOptionStatus'];
				$fieldOptionPrice = $row['ServiceOptionPrice'];
				$fieldOptionPriceAction = $row['ServiceOptionPriceAction'];
				$fieldOptionWeight = $row['ServiceOptionWeight'];
				$fieldOptionWeightAction = $row['ServiceOptionWeightAction'];
				
	
				if($row['ServiceFieldValueTime']!='0000-00-00 00:00:00')
				{
					$fieldValue = $row['ServiceFieldValueTime'];
				}
				elseif($row['ServiceFieldValueNumber']>0)
				{
					$fieldValue = $row['ServiceFieldValueNumber'];
				}	
				else
				{
					$fieldValue = $row['ServiceFieldValue'];
				}									
				
				if(!empty($result['ServiceFieldTypes'][$fieldCode]['code']))
				{
					$result['ServiceFieldTypes'][$fieldCode]['status'] = $row['ServiceFieldStatus'];
				}
				$result['ServiceField'][0][$fieldCode] = $fieldValue;
				
				$result['ServiceOption'][$fieldTypeOptionID]['ServiceFieldID'] = $serviceFieldID;			
				
				if(!empty($fieldTypeOptionID))
				{
					$result['ServiceOption'][$fieldTypeOptionID]['ServiceOptionID'] = $fieldOptionID;
					$result['ServiceOption'][$fieldTypeOptionID]['ServiceOptionStatus'] = $fieldOptionStatus;	
					$result['ServiceOption'][$fieldTypeOptionID]['ServiceTypeOptionID'] = $fieldTypeOptionID;		
					$result['ServiceOption'][$fieldTypeOptionID]['ServiceOptionPrice'] = $fieldOptionPrice;
					$result['ServiceOption'][$fieldTypeOptionID]['ServiceOptionPriceAction'] = $fieldOptionPriceAction;
					$result['ServiceOption'][$fieldTypeOptionID]['ServiceOptionWeight'] = $fieldOptionWeight;
					$result['ServiceOption'][$fieldTypeOptionID]['ServiceOptionWeightAction'] = $fieldOptionWeightAction;
					//$result['ServiceOption'][$fieldTypeOptionID]['ServiceOptionWeightAction'] = $fieldOptionWeightAction;
				}
				
				if($viewMode=='viewservice' && $result['ServiceFieldTypes'][$fieldCode]['mode']=='option' && !empty($fieldTypeOptionID))
				{
					foreach($result['ServiceFieldTypes'][$fieldCode]['options'] as $redefinFieldValueIndex=>$redefinVieldValue)
					{
						if($fieldTypeOptionID==$result['ServiceFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['optionid'])
						{
							if($fieldOptionStatus==2)
							{
								$result['ServiceFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value'] = '';
								$result['ServiceFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['id'] = '';								
							}
							else
							{
								$result['ServiceFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value']='';
								foreach($languagesList['languageCodes'] as $langID=>$langCode) 
								{ 
									$result['ServiceFieldTypes'][$fieldCode]['options'][$redefinFieldValueIndex]['value'] .= '<'.$langCode.'>'.$SERVER->getValue($redefinVieldValue['value'],$langCode).' : '.$fieldOptionPriceAction.$fieldOptionPrice.' '.$config['currency'].'</'.$langCode.'>';
								}
							}
						}
					}
				}						
				
			}		
		}
		//print_r($result['ServiceOption']);
		//set queries
		//echo $query;
		//get the content

		$SERVER->setDebug('ServiceClass.getServiceFields.End','End');
		return $result;
	}	
	
	function getServiceFields($input)
	{
		$rs = $this->getServiceFieldsStructureAndValues($input);
		if(is_array($rs['ServiceFieldTypes']))
		{
			foreach($rs['ServiceFieldTypes'] as $ServiceFieldCode=>$ServiceFieldType)			
			{
				if(!empty($ServiceFieldType['code']))
				{
					$result['ServiceField'][$ServiceFieldCode]['code']=$ServiceFieldType['code'];
					$result['ServiceField'][$ServiceFieldCode]['name']=$ServiceFieldType['name'];
					$result['ServiceField'][$ServiceFieldCode]['type']=$ServiceFieldType['type'];
					$result['ServiceField'][$ServiceFieldCode]['mode']=$ServiceFieldType['mode'];
					$result['ServiceField'][$ServiceFieldCode]['status']=$ServiceFieldType['status'];
					$result['ServiceField'][$ServiceFieldCode]['places']=$ServiceFieldType['places'];
					
					$result['ServiceField'][$ServiceFieldCode]['value']=$rs['ServiceField'][0][$ServiceFieldCode];
					if(is_array($ServiceFieldType['options'])) {
						foreach($ServiceFieldType['options'] as $id=>$serviceFieldOptions) { 
							$optionsTypeID = $serviceFieldOptions['id'];
							$result['ServiceField'][$ServiceFieldCode]['options'][$id]['id']=$serviceFieldOptions['id'];
							$result['ServiceField'][$ServiceFieldCode]['options'][$id]['value']=$serviceFieldOptions['value'];
							$result['ServiceField'][$ServiceFieldCode]['options'][$id]['position']=$serviceFieldOptions['position'];
							$result['ServiceField'][$ServiceFieldCode]['options'][$id]['ServiceOptionID']=$rs['ServiceOption'][$optionsTypeID]['ServiceOptionID'];
							$result['ServiceField'][$ServiceFieldCode]['options'][$id]['ServiceFieldID']=$rs['ServiceOption'][$optionsTypeID]['ServiceFieldID'];
							$result['ServiceField'][$ServiceFieldCode]['options'][$id]['ServiceOptionStatus']=$rs['ServiceOption'][$optionsTypeID]['ServiceOptionStatus'];
							$result['ServiceField'][$ServiceFieldCode]['options'][$id]['ServiceTypeOptionID']=$rs['ServiceOption'][$optionsTypeID]['ServiceTypeOptionID'];
							$result['ServiceField'][$ServiceFieldCode]['options'][$id]['ServiceOptionPrice']=$rs['ServiceOption'][$optionsTypeID]['ServiceOptionPrice'];
							$result['ServiceField'][$ServiceFieldCode]['options'][$id]['ServiceOptionPriceAction']=$rs['ServiceOption'][$optionsTypeID]['ServiceOptionPriceAction'];
							$result['ServiceField'][$ServiceFieldCode]['options'][$id]['ServiceOptionWeight']=$rs['ServiceOption'][$optionsTypeID]['ServiceOptionWeight'];
							$result['ServiceField'][$ServiceFieldCode]['options'][$id]['ServiceOptionWeightAction']=$rs['ServiceOption'][$optionsTypeID]['ServiceOptionWeightAction'];
						}//end of foreach($ServiceFieldType['options'] as $id=>$serviceFieldOptions) 
					}//end of if(is_array($ServiceFieldType['options']))
				}//end of if(!empty($ServiceFieldType['code']) && !empty($rs['ServiceField'][0][$ServiceFieldCode]))
			}
		}
		//print_r($result);
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
		$SERVER->setDebug('ServiceClass.getService.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Service'.DTR.'ServiceID'];
		if(empty($entityID)) {$entityID = $input['ServiceID'];}

		//$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['Service'];}
		if(empty($entityAlias)) {$entityAlias = $input['ServiceAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Service'.DTR.'ServiceAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		$query ='';
		if(!empty($entityID) || !empty($entityAlias))
		{
			if(!empty($entityAlias))
			{
				$filter = " ServiceAlias='$entityAlias' "; 
			}
			else
			{
				$filter = " ServiceID='$entityID' ";
			}
			$query = "SELECT * FROM Service WHERE $filter"; 
			//get the content
			$result = $DS->query($query);	
		}		
		$SERVER->setDebug('ServiceClass.getService.End','End');		
		return $result;		
	}
	
	/*
		input data
		$input['TransactionCreator'] - required field!!! Unique ID that identifies the reason service is bought for
		$input['UserID'] - in case if admin makes transaction for an user (can be empty)
		$input['Service'] - service alias (can be empty if price range is selected)
		$input['ServiceCategory'] - service category (requires price range) (can be empty)
		$input['PriceRange'] - price range to find the service id by price range and category (can be empty)
		$input['Quantity'] - quantity of srvices to buy. can be emoty.
		$input['Account'] - balance account used to buy service. If empty 'main' account is used
		$input['Reason'] - extra information about reason
		
		Result data
		$result['PaymentResult']  - values: OK, AlreadyPaid, NoMoney
		$result['TransactionID'] - id of transaction in case of OK result.
		$result['Balance'] - current balance for selected account or main account by default
		
	*/
	function buyService($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		if(!$SERVER->hasRights('user'))
		{
			$SERVER->setMessage('ServiceClass.buyService.err.NoRights');
			return false;
		}		
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		if($SERVER->hasRights('ServiceClass.buyService.BuyAsAdmin') && !empty($input['UserID']))
		{
			$userID = $input['UserID'];
		}	
		else
		{
			$userID = $user['UserID'];
		}		
		$userID = $input['UserID'];
		if(empty($userID)) { $userID = $user['UserID']; }
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Service'.DTR.'ServiceID'];
		if(empty($entityID)) {$entityID = $input['ServiceID'];}

		$entityAlias = $input['Service'];
		if(empty($entityAlias)) {$entityAlias = $input['ServiceAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Service'.DTR.'ServiceAlias'];}

		$serviceCategory = $input['ServiceCategory'];
		$priceRange = $input['PriceRange'];
		$quantity = $input['Quantity'];
		$account = $input['Account'];
		$transactionReason = $input['Reason'];
		$transactionCreator = $input['TransactionCreator'];
		$billingOrderID = $input['BillingOrderID'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		
			
		$query ='';
		if(!empty($entityID) || !empty($entityAlias))
		{
			if(!empty($entityAlias))
			{
				$filter = " ServiceAlias='$entityAlias' "; 
			}
			else
			{
				$filter = " ServiceID='$entityID' ";
			}
		}	
		elseif(!empty($priceRange))
		{
			$filter = " ServicePriceRangeMin <= $priceRange AND ServicePriceRangeMax >= $priceRange ";
			if(!empty($serviceCategory))
			{
				$catRS = $DS->query("SELECT ServiceCategoryID FROM ServiceCategory WHERE ServiceCategoryAlias='$serviceCategory'");
				$filter .= " AND ServiceCategories LIKE '%|".$catRS[0]['ServiceCategoryID']."|%'";
			}
		}
 
		if(!empty($filter))
		{
			$query = "SELECT * FROM Service WHERE $filter"; 
			//get the content
			//echo $query;
			$rs = $DS->query($query);	
			//print_r($rs);
			if(!empty($billingOrderID))
			{
				$billingOrderRS = $DS->query("SELECT * FROM BillingOrder WHERE BillingOrderID='$billingOrderID'");
				$billingOrderPaymentStatus = $billingOrderRS[0]['OrderPaymentStatus'];
			}
			if(count($rs)>0)		
			{
				$servicePrice = $rs[0]['ServicePrice'];
				$servicePeriod = $rs[0]['ServicePeriod'];
				if($servicePeriod>0)
				{
					$endTimeSTP = time() + ($servicePeriod*60*60*24);
					$endTime = date('Y-m-d H:i:s',$endTimeSTP);
				}				
				if(!empty($quantity))
				{
					$servicePrice = $quantity * $servicePrice;
				}				
				if($billingOrderPaymentStatus=='waiting')
				{
					$result['PaymentResult']='OK';
					$result['PaymentStatus']='waiting';
					$result['PaymentTimeEnd']=$endTime;					
				}
				elseif(!empty($input['TransactionCreator']))
				{
					$inBalance['UserID']=$userID;
					$inBalance['Account']=$account;
					$BillingTransaction = new BillingTransactionServer();
					$balance = $BillingTransaction->getBalance($inBalance);
					//$balance = $balanceRS;
					$servicePrice = (int) $servicePrice;
					//echo 'balance='.$balance.'<br>';
					//echo 'servicePrice='.$servicePrice.'<br>';
					$resultBalance=round($balance- (int) $servicePrice,2);
					//echo 'resultBalance='.$resultBalance.'<hr>';					
					if($config['PromoMode']=='active')
					{					
						//check for no bonus
						$inBalanceNoBonus['UserID']=$userID;
						$inBalanceNoBonus['Account']='nobonus';
						$balanceNoBonusRS = $BillingTransaction->getBalance($inBalanceNoBonus);
						$balanceNoBonus = $balanceNoBonusRS['Balance'];
					}								
					
					if($resultBalance>=0)
					{
						//print_r($rs);
						$transactionInput ['BillingTransaction'.DTR.'UserID'] = $userID;
						$transactionInput ['BillingTransaction'.DTR.'TransactionReceiverID'] = $ownerID;
						$transactionInput ['BillingTransaction'.DTR.'TransactionSenderID'] = $userID;
						$transactionInput ['BillingTransaction'.DTR.'TransactionReason'] = 'buy';
						$transactionInput ['BillingTransaction'.DTR.'TransactionReasonDescription'] = $SERVER->getValue($rs[0]['ServiceTitle']).':'.$transactionReason;					
						$transactionInput ['BillingTransaction'.DTR.'TransactionType'] = 'system';
						$transactionInput ['BillingTransaction'.DTR.'TransactionAmount'] = $servicePrice;
						$transactionInput ['BillingTransaction'.DTR.'TransactionCreator'] = $transactionCreator;
						if(!empty($endTime)){$transactionInput ['BillingTransaction'.DTR.'TimeEnd'] = $endTime;}
						$transactionInput ['actionMode'] = 'save';
						//print_r($transactionInput);
						$addTransactionResult = $BillingTransaction->addTransaction($transactionInput);
						//print_r($addTransactionResult['array']);
						//echo $addTransactionResult['xml'];
						$transactionIDRS = $addTransactionResult[0]['BillingTransactionID'];
						if(empty($transactionIDRS))
						{
							$result['PaymentResult']='AlreadyPaid';
							$result['TransactionID']=$transactionIDRS;
							$result['PaymentTimeEnd']=$endTime;
						}
						else
						{
							$result['PaymentResult']='OK';
							$result['PaymentStatus']='paid';
							$result['TransactionID']=$transactionIDRS;
							$result['PaymentTimeEnd']=$endTime;
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
						$result['Balance']=$resultBalance;
					}
					else
					{
						$SERVER->setMessage('ServiceClass.buyService.err.NoMoney');
						$result['PaymentResult']='NoMoney';
						$result['Balance']=$balance;
					}
				}
				else
				{
					$SERVER->setMessage('ServiceClass.buyService.err.NoTransactionCreator');					
				}
			}
			else //if(count($rs)>0)	
			{
				$SERVER->setMessage('ServiceClass.buyService.err.WrongService');
			}
		}
		else //if(!empty($filter))
		{
			$SERVER->setMessage('ServiceClass.buyService.err.NoServiceAttributes');
		}

		return $result;		
	}	
	
	function getServiceField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ServiceClass.getServiceField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ServiceField'.DTR.'ServiceFieldID'];
		if(empty($entityID)) {$entityID = $input['ServiceFieldID'];}

		$entityAlias = $input['ServiceField'];
		if(empty($entityAlias)) {$entityAlias = $input['ServiceFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ServiceField'.DTR.'ServiceFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ServiceFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ServiceFieldID='$entityID' ";
		}
		$query = "SELECT * FROM ServiceField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('ServiceClass.getServiceField.End','End');		
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
		$SERVER->setDebug('ServiceClass.setService.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Service'.DTR.'ServiceID'];
		if(empty($entityID)) {$entityID = $input['ServiceID'];}		
		if(empty($input['Service'.DTR.'PermAll'])) {$input['Service'.DTR.'PermAll']=4;}
		if(!$SERVER->hasRights('admin')) {$input['Service'.DTR.'PermAll']=4;}
		if($SERVER->hasRights('admin') && $input['Service'.DTR.'PermAll']==1 && empty($input['Service'.DTR.'ServiceStatus'])) {$input['Service'.DTR.'ServiceStatus']='active';}
		if(empty($input['Service'.DTR.'ServiceStatus'])) {$input['Service'.DTR.'ServiceStatus']='new';}
		if(empty($input['Service'.DTR.'ServiceAuthor'])  && $clientType!='admin') {$input['Service'.DTR.'ServiceAuthor']=$user['FirstName'].' '.$user['LastName'];}
		if(empty($input['Service'.DTR.'ServiceLink']) && $clientType!='admin') {$input['Service'.DTR.'ServiceLink']=$user['UserLink'];}		

		$where['Service'] = "ServiceID = '".$entityID."'".$filter;

		if(!empty($input['Service'.DTR.'ServiceAlias']) && $input['actionMode']=='add')
		{
			//$checkRS=$DS->query("SELECT ServiceAlias FROM Service WHERE ServiceAlias='".$input['Service'.DTR.'ServiceAlias']."'");
		}
		if(!empty($entityID))
		{
			$oldRS=$DS->query("SELECT PermAll FROM Service WHERE ServiceID='".$entityID."'");
		}		
		//set visibility mode status	
		if(!empty($input['Service'.DTR.'ServiceTitle']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			if(empty($entityID)) {$entityID=$DS->dbLastID();}
			/*$this->updateSerializedServiceFields($entityID,$input['Service'.DTR.'ServiceType']);
			$this->updateServiceCategoryStats($entityID);*/
		}
		else
		{
			if(!empty($input['Service'.DTR.'ServiceAlias']))
			{
				$SERVER->setMessage('ServiceClass.setService.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ServiceClass.setService.msg.DataSaved');
		}
		//if(!empty($input['Service'.DTR.'ServiceAlias']))
		//{
			//$this->updateEntityPositions($entityID,'Service');
		//}
		$SERVER->setDebug('ServiceClass.setService.End','End');		
		return $result;		
	}
	
	function updateServiceCategoryStats($serviceID)
	{
		$DS = &$this->_DS;	
		if(!empty($serviceID))
		{
			$catsObject = new ServiceCategoryClass();	
			$mode='';
			$rs = $DS->query("SELECT ServiceType, ServiceCategories, PermAll FROM Service WHERE ServiceID='$serviceID'");
			$serviceCategoriesArray = explode("|",$rs[0]['ServiceCategories']);
			if(is_array($serviceCategoriesArray))
			{
				foreach($serviceCategoriesArray as $categoryID)
				{
					if(!empty($categoryID))
					{
						$countTotal = $this->getServicesNumberInCategory($categoryID);
						$countType = $this->getServicesNumberInCategory($categoryID,$rs[0]['ServiceType']);
						$catsObject->updateServiceCategoryStat($categoryID,$rs[0]['ServiceType'],$countTotal,$countType);
					}
				}
			}
		}
	}
	
	function getServicesNumberInCategory($categoryID,$serviceType='')
	{
		$DS = &$this->_DS;	
		if(!empty($serviceType)) {$filter = " AND ServiceType='$serviceType' ";}
		$rs = $DS->query("SELECT COUNT(ServiceID) AS ServiceCount FROM Service WHERE PermAll=1  AND ServiceCategories LIKE '%|$categoryID|%' $filter ");
		$result = $rs[0]['ServiceCount'];
		return $result;
	}
	
	function updateSerializedServiceFields($serviceID,$serviceType)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		if(!empty($serviceID))
		{
			$input['ServiceID'] = $serviceID;
			$input['ServiceType'] = $serviceType;
			$rs = $this->getServiceFields($input);
			$serviceFields = serialize($rs);
			$serviceFields = $SERVER->cleanString($serviceFields,'noquotes');
			$DS->query("UPDATE Service SET ServiceFields = '$serviceFields' WHERE ServiceID='$serviceID'");
		}
	}

	function setServiceField($input,$uploadRS)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ServiceFieldClass.setServiceField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		$entityID = $input['Service'.DTR.'ServiceID'];
		if(empty($entityID)) {$entityID = $input['ServiceID'];}	
			
		$entityType = $input['ServiceType'];
		if(empty($entityType)) {$entityType = $input['SourceType'];}					
		if(empty($entityType)) {$entityType = $input['Service'.DTR.'ServiceType'];}			
		//set filters
		//$filter = $DS->getAccessFilter($input,'ServiceFieldServer.adminServiceField');
		//set queries	
		foreach($input as $fieldName=>$fieldVale)
		{
			if(eregi('ServiceField'.DTR,$fieldName))
			{
				//process servicefield saving
				$fieldCode = str_replace('ServiceField'.DTR,'',$fieldName);
				//get the field type
				//$entityType
				
				$fieldInfoRS = $DS->query("SELECT ServiceTypeFieldID, ServiceTypeFieldType, ServiceTypeFieldPosition, ServiceTypeFieldName, ServiceTypeFieldAlias, ServiceTypeFieldMode, ServiceTypeFieldMode FROM ServiceTypeField WHERE ServiceTypeFieldAlias = '$fieldCode' AND ServiceType='$entityType' ");
				$fieldType = $fieldInfoRS[0]['ServiceTypeFieldType'];
				$fieldTypeID = $fieldInfoRS[0]['ServiceTypeFieldID'];
				$fieldTypePosition = $fieldInfoRS[0]['ServiceTypeFieldPosition'];
				$fieldTypeMode = $fieldInfoRS[0]['ServiceTypeFieldMode'];
				$fieldTypeName = $fieldInfoRS[0]['ServiceTypeFieldName'];
				$fieldTypeMode = $fieldInfoRS[0]['ServiceTypeFieldMode'];
				


				//format the field for respective field type
				if(is_array($fieldVale))
				{
					//transfrom for checkboxes or language field
					$k=1;
					$fieldValeResult='';
					foreach($fieldVale as $itemCode=>$itemValue)
					{
						if($fieldType=='checkboxes')
						{
							if($k==1)
							{
								$fieldValeResult .= "|$itemValue|";
								$k++;
							}
							else
							{
								$fieldValeResult .= "$itemValue|";
							}
						}
						elseif($fieldType=='text' || $fieldType=='input')
						{
							$fieldValeResult .= "<$itemCode>".$itemValue."</$itemCode>";
						}
					}
					$fieldVale = $fieldValeResult;
				}
				//check if there is a value
				$checkRS = $DS->query("SELECT ServiceFieldID FROM ServiceField WHERE ServiceID='$entityID' AND ServiceFieldAlias='$fieldCode'");
				$serviceFieldID = $checkRS[0]['ServiceFieldID'];

				if($fieldType=='number' || $fieldType=='money')
				{
					$valueFieldName = 'ServiceFieldValueNumber';
				}
				elseif($fieldType=='time' || $fieldType=='date')
				{
					$valueFieldName = 'ServiceFieldValueTime';
				}
				else
				{
					$valueFieldName = 'ServiceFieldValue';
				}

				if($fieldVale=='image' || $fieldVale=='file')
				{
					if(!empty($uploadRS[$fieldCode]['file']))
					{
						$fieldVale= $uploadRS[$fieldCode]['file'];
					}		
					else
					{
						$fileFieldRS = $DS->query("SELECT ServiceFieldValue FROM ServiceField WHERE ServiceFieldID='$serviceFieldID'");
						$fieldVale=$fileFieldRS[0][$valueFieldName];
					}				
				}
				
				if($fieldVale=='deletefieldfile')
				{
					if(!empty($serviceFieldID))
					{
						$FM = new FilesManager();
						//$fileField =$input['fileField'];
						$fileFieldRS = $DS->query("SELECT ServiceFieldValue FROM ServiceField WHERE ServiceFieldID='$serviceFieldID'");
						$SERVER->setInputVar('actionMode','deletefile');
						$FM->deleteFile($fileFieldRS[0][$valueFieldName]);
						$fieldVale='';
						$input['ServiceFieldStatus'][$fieldCode] = 1;
					}
				}				
				
				if($input['ServiceFieldStatus'][$fieldCode]!=1)
				{
					$fieldStatus = 2;
				}
				else
				{
					$fieldStatus = 1;
				}
				//echo 'ServiceFieldStatus = '.$fieldStatus.' code='.$fieldCode.'<br>';

				if(!empty($serviceFieldID))
				{
					//udpate
					$query = "UPDATE ServiceField SET ServiceID='$entityID',ServiceFieldAlias='$fieldCode', ServiceTypeFieldID='$fieldTypeID',ServiceFieldType='$fieldType',ServiceFieldPosition='$fieldTypePosition', $valueFieldName = '$fieldVale', ServiceFieldStatus='$fieldStatus' WHERE ServiceFieldID='$serviceFieldID'";
				}
				else
				{
					//insert
					$query = "INSERT INTO ServiceField (ServiceID,ServiceFieldAlias,ServiceTypeFieldID,ServiceFieldType,ServiceFieldPosition,$valueFieldName,ServiceFieldStatus) VALUES ('$entityID','$fieldCode','$fieldTypeID','$fieldType','$fieldTypePosition','$fieldVale','$fieldStatus')";					
				}
				
				//echo $query.'<br>';
				$DS->query($query);
				if(empty($serviceFieldID))
				{
					$serviceFieldID = $DS->dbLastID();	
				}
				
				if(is_array($input['ServiceOption'.DTR.'ServiceTypeOptionID']) && $fieldTypeMode=='option')
				{
					foreach($input['ServiceOption'.DTR.'ServiceTypeOptionID'] as $i=>$ServiceTypeOptionID)
					{
						$inputSave['ServiceOption'.DTR.'ServiceTypeOptionID'] = $ServiceTypeOptionID;
						$inputSave['ServiceOption'.DTR.'ServiceFieldID'] = $serviceFieldID;
						$inputSave['ServiceOption'.DTR.'ServiceOptionID'] = $input['ServiceOption'.DTR.'ServiceOptionID'][$i];
						$inputSave['ServiceOption'.DTR.'ServiceOptionPosition'] = $input['ServiceOption'.DTR.'ServiceOptionPosition'][$i];
						$inputSave['ServiceOption'.DTR.'ServiceOptionPrice'] = $input['ServiceOption'.DTR.'ServiceOptionPrice'][$i];
						$inputSave['ServiceOption'.DTR.'ServiceOptionPriceAction'] = $input['ServiceOption'.DTR.'ServiceOptionPriceAction'][$i];
						$inputSave['ServiceOption'.DTR.'ServiceOptionWeight'] = $input['ServiceOption'.DTR.'ServiceOptionWeight'][$i];
						$inputSave['ServiceOption'.DTR.'ServiceOptionWeightAction'] = $input['ServiceOption'.DTR.'ServiceOptionWeightAction'][$i];
						
						$inputSave['ServiceOption'.DTR.'ServiceOptionStatus'] = $input['ServiceOption'.DTR.'ServiceOptionStatus'][$i];
						
						if($inputSave['ServiceOption'.DTR.'ServiceOptionStatus']!=1)
						{
							$inputSave['ServiceOption'.DTR.'ServiceOptionStatus']=2;
						}
						else
						{
							$inputSave['ServiceOption'.DTR.'ServiceOptionStatus']=1;
						}
						//echo 'status='.$inputSave['ServiceOption'.DTR.'ServiceOptionStatus'];
						$inputSave['actionMode']='save';
	
						$where['ServiceOption'] = "ServiceOptionID = '".$inputSave['ServiceOption'.DTR.'ServiceOptionID']."'";
						$DS->save($inputSave,$where);	
					}
				}				
			}
		}
		//if(!empty($input['ServiceField'.DTR.'ServiceFieldAlias']))
		//{
			//$this->updateEntityPositions($entityID,'ServiceField',$input['ServiceField'.DTR.'ServiceID'],'Service');
		//}		
		$SERVER->setDebug('ServiceFieldClass.setServiceField.End','End');		
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
		$SERVER->setDebug('ServiceClass.deleteService.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Service'.DTR.'ServiceID'];

		if(!empty($entityID))
		{
			$DS->query("DELETE FROM Service WHERE ServiceID='$entityID'");
		}
		//$SERVER->setMessage('ServiceClass.deleteService.msg.DataDeleted');
		$SERVER->setDebug('ServiceClass.deleteService.End','End');		
		return $result;		
	}	
	
	function deleteServiceField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ServiceClass.deleteServiceField.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ServiceField'.DTR.'ServiceFieldID'];
		//if(empty($entityID)) {$entityID = $input['ServiceID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM ServiceField WHERE ServiceID='$entityID'");
			$DS->query("DELETE FROM ServiceOption WHERE ServiceFieldID='$entityID'");
		}
		$SERVER->setMessage('ServiceClass.deleteServiceField.msg.DataDeleted');
		$SERVER->setDebug('ServiceClass.deleteServiceField.End','End');		
		return $result;		
	}	
	
	function copyService($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('SectionServer.setSection.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	

		$ownerID = $config['OwnerID'];
		$ownerRootID = $config['OwnerRootID'];
		$ServiceTemplateID = $input['selectedServiceID'];
		$ServiceID = $input['ServiceID'];
		if($ServiceID==$ServiceTemplateID) {return false;}
		//set client side variables
		if(!empty($ServiceTemplateID) && !empty($ServiceID))
		{
			//make Service link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM ServiceField WHERE ServiceID='$ServiceTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['ServiceField'] = "ServiceFieldID = ''";
			$inputNew['ServiceField'.DTR.'ServiceFieldID']='';
			$inputNew['ServiceField'.DTR.'OwnerID']=$ownerID;
			$inputNew['ServiceField'.DTR.'UserID']=$userID;
			$inputNew['ServiceField'.DTR.'ServiceID']=$ServiceID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['ServiceField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['ServiceField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['ServiceField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM ServiceField WHERE BoxID='".$inputNew['ServiceField'.DTR.'BoxID']."' AND ServiceID='".$ServiceID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new Service
					$newRS = $DS->save($inputNew,$where);	
				}
			}
		}
		//if(count($result['sql'])>0)	
		//{
			//$SERVER->setMessage('SectionServer.setSection.msg.DataSaved');
		//}
		$SERVER->setDebug('SectionServer.setSection.End','End');		
		return $result;		
	}

	function updateEntityPositions($entityID,$entityName,$entityParentID='',$entityParentName='')
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
		if(empty($entityID))
		{
			return '';
		}

		if(!empty($entityParentID))
		{
			$query = "SELECT ".$entityName."ID, ".$entityName."Position FROM $entityName WHERE ".$entityParentName."ID='$entityParentID' ORDER BY ".$entityName."Position ASC";			
		}
		else
		{
			$query = "SELECT ".$entityName."ID, ".$entityName."Position FROM $entityName ORDER BY ".$entityName."Position ASC";			
		}
		$rs = $DS->query($query);
		$i=2;
		
		foreach($rs as $row)
		{
			$DS->query("UPDATE $entityName SET ".$entityName."Position='$i' WHERE ".$entityName."ID='".$row[$entityName.'ID']."'");
			//echo "UPDATE $entityName SET ".$entityName."Position='$i' WHERE ".$entityName."ID='".$row[$entityName.'ID']."'<br>";
			$i = $i+2;
		}
		//return $result;		
	}	
	

} // end of ServiceServer
?>
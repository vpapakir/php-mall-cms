<?php
//XCMSPro: Web Service entity class
class TourCartItemClass
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
	function TourCartItemClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
		$this->_session = $this->_controller->getSessionData();
		$this->_sessionID = $this->_controller->getCurrentSessionID();
	}
	// PUBLIC METHODS
    /**
    * gets entites
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */
	function getTourCartItems($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourCartItemClass.getTourCartItems.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;		
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//print_r($input);
		//set client side variables
		if(empty($entityAlias)) {$entityAlias = $input['TourCartItem'.DTR.'TourCartItemAlias'];}	
		
		/*if(!empty($input['TourOrder'.DTR.'TourOrderType']))
		{
			$filter = " AND TourCartItemType='".$input['TourOrder'.DTR.'TourOrderType']."'"; 
		}
		
		if(!empty($input['TourCartItemType']))
		{
			$filter = " AND TourCartItemType='".$input['TourCartItemType']."'"; 
		}*/
		
		$sessionFilter = " UserID='".$userID."' OR  SessionID='".$sessionID."' ";		
		
		$sessionFilter .= $filter;
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourCartItemServer.adminTourCartItem');
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		//$query = "SELECT * FROM TourCartItem LEFT JOIN TourCartItemField ON TourCartItem.TourCartItemID = TourCartItemField.TourCartItemID  WHERE $sessionFilter ORDER BY TourCartItem.TourCartItemID";
		$query = "SELECT * FROM TourCartItem WHERE $sessionFilter ORDER BY TourCartItem.TourCartItemID";
		//get the content
		$rs = $DS->query($query); 
		if(is_array($rs))
		{
			foreach ($rs as $row)
			{
				$tourID = $row['TourID'];
				$tourCartItemID = $row['TourCartItemID'];
				$tourFieldAlias = $row['TourFieldAlias'];
				foreach($row as $fieldName=>$fieldValue)
				{
					if($fieldName=='TourFields')
					{
						$result[$tourCartItemID][$fieldName] = $fieldValue;
					}
					elseif(eregi("TourField",$fieldName) || $fieldName=='TourTypeFieldID' || $fieldName=='TourCartItemFieldID')
					{
						$result[$tourCartItemID]['TourCartItemFields'][$tourFieldAlias][$fieldName] = $fieldValue;
					}
					else
					{
						$result[$tourCartItemID][$fieldName] = $fieldValue;
					}
				}
			}
		}
		$SERVER->setDebug('TourCartItemClass.getTourCartItems.End','End');
		
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
	function getTourCartItem($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourCartItemClass.getTourCartItem.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['TourCartItem'.DTR.'TourCartItemID'];
		if(empty($entityID)) {$entityID = $input['TourCartItemID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['TourCartItem'];}
		if(empty($entityAlias)) {$entityAlias = $input['TourCartItemAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourCartItem'.DTR.'TourCartItemAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TourCartItemServer.adminTourCartItem');
		//set queries
		$query =='';
		//if(!empty($entityAlias))
		//{
			//$filter = " TourCartItemAlias='$entityAlias' "; 
		//}
		//else
		//{
			
		//}
		$filter = " TourCartItemID='$entityID' ";
		$query = "SELECT * FROM TourCartItem WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('TourCartItemClass.getTourCartItem.End','End');		
		return $result;		
	}


	function addTourCartItem($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourCartItemClass.setTourCartItem.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;
		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
//echo "id ".$input['TourCartItemID'];
		$entityID = $input['TourCartItem'.DTR.'TourCartItemID'];
		if(empty($entityID)) {$entityID = $input['TourCartItemID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourCartItemServer.adminTourCartItem');
		//set queries	
		
		$sessionFilter = " AND (UserID='".$userID."' OR  SessionID='".$sessionID."') ";			
		$tourID = $input['Tour'.DTR.'TourID'];
		$input['TourCartItemQuantity'] =1;
		if(!empty($tourID) && !empty($input['TourCartItemQuantity']) && !empty($sessionID))
		{
			//check if the product is in the cart or not
			$extraOptionsQuery= '';
			
			foreach($input as $fieldName=>$fieldVale)
			{
				if(eregi('TourField'.DTR,$fieldName))
				{
					$fieldCode = str_replace('TourField'.DTR,"",$fieldName);
					if(!empty($input[$fieldName]))
					{
						$extraOptionsQuery .= " AND TourFieldAlias='$fieldCode' AND TourFieldValue='".$input[$fieldName]."'";
					}
				}
			}
			
			if(!empty($extraOptionsQuery))
			{
				$cartQuery = "SELECT TourCartItem.TourCartItemID AS TourCartItemID, TourCartItemQuantity  FROM TourCartItem, TourCartItemField WHERE TourCartItem.TourCartItemID=TourCartItemField.TourCartItemID AND TourID='$tourID' $sessionFilter $extraOptionsQuery ";			
			}
			else
			{
				$cartQuery = "SELECT TourCartItemID, TourCartItemQuantity  FROM TourCartItem WHERE TourID='$tourID' $sessionFilter ";
			}
			$cartRS = $DS->query($cartQuery);

			if(!empty($cartRS[0]['TourCartItemID']))
			{
				$input['TourCartItemQuantity'] = abs($input['TourCartItemQuantity']) + $cartRS[0]['TourCartItemQuantity'];
				$entityID = $cartRS[0]['TourCartItemID'];
				
			}	
			else
			{
				$input['TourCartItemQuantity'] = abs($input['TourCartItemQuantity']);
			}
			//get tour info 
			$tourQuery = "SELECT * FROM Tour WHERE TourID='$tourID'";
			$tourRS = $DS->query($tourQuery);
			foreach ($tourRS[0] as $fieldName=>$fieldValue)
			{
				$input['TourCartItem'.DTR.$fieldName] = addslashes($fieldValue);
			}
			//make price
			$tourCartItemPrice = $tourRS[0]['TourPrice'];
			$tourCartItemWeight = $tourRS[0]['TourWeight'];
			
			$input['TourCartItem'.DTR.'TourCartItemID'] = $entityID;

			$input['TourCartItem'.DTR.'TourCartItemQuantity'] = $input['TourCartItemQuantity'];
			$input['TourCartItem'.DTR.'TourCartItemPrice'] = $tourCartItemPrice;
			$input['TourCartItem'.DTR.'TourCartItemWeight'] = $tourCartItemWeight;
			$input['TourCartItem'.DTR.'SessionID'] = $sessionID;
			if($tourCartItemPrice>0)
			{
				$input['TourCartItem'.DTR.'TourCartItemType'] = 'order';
			}
			else
			{
				$input['TourCartItem'.DTR.'TourCartItemType'] = 'request';
			}

			$where['TourCartItem'] = "TourCartItemID = '".$entityID."'";
			$input['actionMode']='save';		
			//print_r($input);			
			$result = $DS->save($input,$where,'update');				
			//print_r($result);
			$lastID = $result[0]['TourID'];
			$input['TourCartItemField'.DTR.'TourCartItemID']=$lastID;
			$optionsRS = $this->addTourCartItemFields($input);
			$this->countTourCartItemPrice($lastID,$tourRS[0]['TourPrice'],$optionsRS['price']);
			$this->countTourCartItemWeightAndVolume($lastID,$tourRS[0]['TourWeight'],$optionsRS['weight'],$tourRS[0]['TourVolume'],$optionsRS['volume']);
		}
		$SERVER->setDebug('TourCartItemClass.setTourCartItem.End','End');	
		$this->emptyExpiredCarts();	
		return $result;		
	}

	function addTourCartItemFields($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourCartItemClass.setTourCartItem.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;
		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TourCartItemField'.DTR.'TourCartItemFieldID'];
		if(empty($entityID)) {$entityID = $input['TourCartItemFieldID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourCartItemServer.adminTourCartItem');
		//set queries	
		
		$sessionFilter = " UserID='".$userID."' OR  SessionID='".$sessionID."' ";			
		$tourCartItemID = $input['TourCartItem'.DTR.'TourCartItemID'];
		$tourID = $input['Tour'.DTR.'TourID'];
		if(!empty($tourID) && !empty($input['TourCartItemField'.DTR.'TourCartItemID']))
		{
			//check if the product is in the cart or not
			$cartQuery = "SELECT TourCartItemID FROM TourCartItemField WHERE TourCartItemID='$tourCartItemID' ";
		//echo "query ".$cartQuery;
			$cartFiledRS = $DS->query($cartQuery);
//echo "cart Fields: ".count($cartFiledRS);
			if(count($cartFiledRS)<1)
			{
				$optionsPrice=0;
				$optionsWeight = 0;
				//get tour fields  values
				$tourFieldQuery = "SELECT * FROM TourField WHERE TourID='$tourID' AND TourFieldStatus!='2'";
				$tourFieldRS = $DS->query($tourFieldQuery);
				//echo "q ".$tourFieldQuery;
				if (is_array($tourFieldQuery))
				foreach($tourFieldRS as $row)
				{
					//get tour field info
					$tourTypeFieldQuery = "SELECT TourTypeFieldName, TourTypeFieldMode, TourTypeFieldType FROM TourTypeField WHERE TourTypeFieldID='".$row['TourTypeFieldID']."'";
					$tourTypeFieldRS = $DS->query($tourTypeFieldQuery);
					
					$row2 = $tourTypeFieldRS[0];
					$input['TourCartItemField'.DTR.'TourTypeFieldID'] = $row['TourTypeFieldID'];
					$extraFieldName = $row['TourFieldAlias'];
					$input['TourCartItemField'.DTR.'TourFieldAlias'] = $row['TourFieldAlias'];
					$input['TourCartItemField'.DTR.'TourFieldType'] = $row2['TourTypeFieldType'];
					$input['TourCartItemField'.DTR.'TourFieldMode'] = $row2['TourTypeFieldMode'];
					$input['TourCartItemField'.DTR.'TourFieldName'] = addslashes($row2['TourTypeFieldName']);
					$input['TourCartItemField'.DTR.'TourFieldPosition'] = $row2['TourTypeFieldPosition'];
										
					$input['TourCartItemField'.DTR.'TourFieldValueNumber'] = $row['TourFieldValueNumber'];
					$input['TourCartItemField'.DTR.'TourFieldValueTime'] = $row['TourFieldValueTime'];
					
					if($row2['TourTypeFieldMode']=='option')
					{
						$input['TourCartItemField'.DTR.'TourFieldValue'] = $input['TourField'.DTR.$extraFieldName];
						//if(is_array($input['TourField'.DTR.$extraFieldName]))
						//{
							//$input['TourCartItemField'.DTR.'TourFieldValue'] = '|'. implode("|",$input['TourField'.DTR.$extraFieldName]).'|';
						//}
						//else
						//{
							$tourTypeOptionQuery = "SELECT TourTypeOptionName FROM TourTypeOption WHERE TourTypeOptionID='".$input['TourCartItemField'.DTR.'TourFieldValue']."'";
							$tourTypeOptionRS = $DS->query($tourTypeOptionQuery);
							$input['TourCartItemField'.DTR.'TourFieldValueOptions'] = addslashes($tourTypeOptionRS[0]['TourTypeOptionName']);
						//}
						
							//get the option data
							$tourOptionQuery = "SELECT TourOptionPrice, TourOptionPriceAction, TourOptionWeight, TourOptionWeightAction FROM TourOption WHERE TourTypeOptionID='".$input['TourCartItemField'.DTR.'TourFieldValue']."' AND TourFieldID='".$row['TourFieldID']."'";
							$tourOptionRS = $DS->query($tourOptionQuery);
							if($tourOptionRS[0]['TourOptionPriceAction']=='+')
							{
								$optionsPrice = $optionsPrice + $tourOptionRS[0]['TourOptionPrice'];
							}
							else
							{
								$optionsPrice = $optionsPrice - $tourOptionRS[0]['TourOptionPrice'];
							}
							
							if($tourOptionRS[0]['TourOptionWeightAction']=='+')
							{
								$optionsWeight = $optionsWeight + $tourOptionRS[0]['TourOptionWeight'];
							}
							else
							{
								$optionsWeight = $optionsWeight - $tourOptionRS[0]['TourOptionWeight'];
							}							
					}
					else
					{
						$input['TourCartItemField'.DTR.'TourFieldValue'] = addslashes($row['TourFieldValue']);
						if($row2['TourTypeFieldType'] == 'dropdown' || $row2['TourTypeFieldType'] == 'radioboxes')
						{
							$tourTypeOptionQuery = "SELECT TourTypeOptionName FROM TourTypeOption WHERE TourTypeOptionID='".$input['TourCartItemField'.DTR.'TourFieldValue']."'";
							$tourTypeOptionRS = $DS->query($tourTypeOptionQuery);
							$input['TourCartItemField'.DTR.'TourFieldValueOptions'] = addslashes($tourTypeOptionRS[0]['TourTypeOptionName']);
						}
						elseif($row2['TourTypeFieldType'] == 'checkboxes' || $row2['TourTypeFieldType'] == 'multiple')
						{
							
						}
					}
		
					$where['TourCartItemField'] = "TourCartItemFieldID = '".$entityID."'";
					$input['actionMode']='save';	
//print_r($input);				
					$DS->save($input,$where,'insert');	
				}			
			}	
		}
		 $result['price'] = $optionsPrice;
		 $result['weight'] = $optionsWeight;
		//$SERVER->setDebug('TourCartItemClass.setTourCartItem.End','End');		
		return $result;		
	}
	
	function countTourCartItemPrice($itemID,$tourPrice,$optionsTotal)
	{
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		if(!empty($itemID))
		{
			$price = $tourPrice + $optionsTotal;
			$query = "UPDATE TourCartItem SET TourCartItemPrice=$price WHERE TourCartItemID='$itemID'";
			$DS->query($query);
		}
	}	
	
	function countTourCartItemWeightAndVolume($itemID,$tourWeight,$optionsWeight,$tourVolume,$optionsVolume)
	{
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;	
		
		if(!empty($itemID))
		{
			$weight = $tourWeight + $tourWeight;
			$volume = $tourVolume + $optionsVolume;
			$query = "UPDATE TourCartItem SET TourCartItemWeight=$weight, TourCartItemVolume=$volume WHERE TourCartItemID='$itemID'";
			$DS->query($query);
		}			
	}
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setTourCartItem($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourCartItemClass.setTourCartItem.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TourCartItem'.DTR.'TourCartItemID'];
		if(empty($entityID)) {$entityID = $input['TourCartItemID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourCartItemServer.adminTourCartItem');
		//set queries	
		//if(is_array($input['TourCartItem'.DTR.'AccessGroups'])) {$input['TourCartItem'.DTR.'AccessGroups'] = '|'. implode("|",$input['TourCartItem'.DTR.'AccessGroups']).'|';}
		if(is_array($input['TourCartItem'.DTR.'TourCartItemID']))
		{
			foreach($input['TourCartItem'.DTR.'TourCartItemID'] as $id=>$tourCartItemID)
			{
				$inputSave['TourCartItem'.DTR.'TourCartItemID'] = $tourCartItemID; 
				$inputSave['TourCartItem'.DTR.'TourCartItemQuantity'] = $input['TourCartItem'.DTR.'TourCartItemQuantity'][$id]; 
				
				if(!empty($inputSave['TourCartItem'.DTR.'TourCartItemQuantity']))
				{
					$inputSave['actionMode']='save';					
					$where['TourCartItem'] = "TourCartItemID = '".$tourCartItemID."'";
					$result = $DS->save($inputSave,$where,'update');					
				}
				elseif(!empty($tourCartItemID))
				{
					$this->deleteTourCartItem($tourCartItemID);
				}
			}
		}
		$this->emptyExpiredCarts();
		return $result;		
	}
	
	function emptyCart($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourCartItemClass.setTourCartItem.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$filter =  " AND TourCartItemType='".$input['TourOrder'.DTR.'TourOrderType']."'";
		$sessionFilter = " UserID='".$userID."' OR  SessionID='".$sessionID."' ";	
		//$sessionFilter .= $filter;
		
		$tourCartItemsRS = $DS->query("SELECT TourCartItemID FROM TourCartItem WHERE $sessionFilter ");
		if(is_array($tourCartItemsRS))
		{
			foreach($tourCartItemsRS as $row)
			{
				$this->deleteTourCartItem($row['TourCartItemID']);
			}
		}			
				
	}
	
	function emptyExpiredCarts ()
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourCartItemClass.setTourCartItem.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;
		
		$expirytimeSmp = (string) (time() - $config['CookieTimeout']);
		$expirytime = date("Y-m-d H:i:s",$expirytimeSmp);
		$expiredTourCartItemsQuery = "SELECT TourCartItemID FROM TourCartItem WHERE TimeCreated < '$expirytime'";
		$expiredTourCartItemsRS = $DS->query($expiredTourCartItemsQuery);
		if(is_array($expiredTourCartItemsRS))
		{
			foreach($expiredTourCartItemsRS as $row)
			{
				$this->deleteTourCartItem($row['TourCartItemID']);
			}
		}		
				
	}
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteTourCartItem($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		//set client side variables
		if(is_array($input))
		{
			$entityID = $input['TourCartItem'.DTR.'TourCartItemID'];
		}
		else
		{
			$entityID = $input;
		}
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM TourCartItem WHERE TourCartItemID='$entityID'");
			$DS->query("DELETE FROM TourCartItemField WHERE TourCartItemID='$entityID'");
		}
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
} // end of TourCartItemServer
?>
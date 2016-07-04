<?php
//XCMSPro: Web Service entity class
class ReservedPropertyCartItemClass
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
	function ReservedPropertyCartItemClass()
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
	function getCartItemsReservedProperty($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CartItemClass.getCartItemsReservedProperty.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;		
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		if(empty($entityAlias)) {$entityAlias = $input['CartItem'.DTR.'CartItemAlias'];}	
		
		if(!empty($input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderType']))
		{
			$filter = " AND CartItemType='".$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderType']."'"; 
		}
		
		if(!empty($input['CartItemType']))
		{
			$filter = " AND CartItemType='".$input['CartItemType']."'"; 
		}
		
		$sessionFilter = " (UserID='".$userID."' OR  SessionID='".$sessionID."') ";		
		
		$sessionFilter .= $filter;
		//set filters
		//$filter = $DS->getAccessFilter($input,'CartItemServer.adminCartItem');
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT *,CartItem.CartItemID AS CartItemID FROM CartItem LEFT JOIN CartItemField ON CartItem.CartItemID = CartItemField.CartItemID  WHERE $sessionFilter ORDER BY CartItem.CartItemID";
		//get the content
		$rs = $DS->query($query); 
		if(is_array($rs))
		{
			foreach ($rs as $row)
			{
				$reservedPropertyID = $row['ReservedPropertyID'];
				$cartItemID = $row['CartItemID'];
				$reservedPropertyFieldAlias = $row['ReservedPropertyFieldAlias'];
				foreach($row as $fieldName=>$fieldValue)
				{
					if($fieldName=='ReservedPropertyFields')
					{
						$result[$cartItemID][$fieldName] = $fieldValue;
					}
					elseif(eregi("ReservedPropertyField",$fieldName) || $fieldName=='ReservedPropertyTypeFieldID' || $fieldName=='CartItemFieldID')
					{
						$result[$cartItemID]['CartItemFields'][$reservedPropertyFieldAlias][$fieldName] = $fieldValue;
					}
					else
					{
						$result[$cartItemID][$fieldName] = $fieldValue;
					}
				}
			}
		}
		$SERVER->setDebug('CartItemClass.getCartItemsReservedProperty.End','End');
		
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
	function getCartItem($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CartItemClass.getCartItem.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['CartItem'.DTR.'CartItemID'];
		if(empty($entityID)) {$entityID = $input['CartItemID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['CartItem'];}
		if(empty($entityAlias)) {$entityAlias = $input['CartItemAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['CartItem'.DTR.'CartItemAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'CartItemServer.adminCartItem');
		//set queries
		$query =='';
		//if(!empty($entityAlias))
		//{
			//$filter = " CartItemAlias='$entityAlias' "; 
		//}
		//else
		//{
			
		//}
		$filter = " CartItemID='$entityID' ";
		$query = "SELECT * FROM CartItem WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('CartItemClass.getCartItem.End','End');		
		return $result;		
	}


	function addCartItem($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CartItemClass.setCartItem.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;
		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['CartItem'.DTR.'CartItemID'];
		if(empty($entityID)) {$entityID = $input['CartItemID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'CartItemServer.adminCartItem');
		//set queries	
		$sessionFilter = " AND (UserID='".$userID."' OR  SessionID='".$sessionID."') ";			
		$reservedPropertyID = $input['ReservedProperty'.DTR.'ReservedPropertyID'];
		if(!empty($reservedPropertyID) && !empty($input['CartItemQuantity']) && !empty($sessionID))
		{
			//check if the product is in the cart or not
			$extraOptionsQuery= '';
			
			foreach($input as $fieldName=>$fieldVale)
			{
				if(eregi('ReservedPropertyField'.DTR,$fieldName))
				{
					$fieldCode = str_replace('ReservedPropertyField'.DTR,"",$fieldName);
					if(!empty($input[$fieldName]))
					{
						$extraOptionsQuery .= " AND ReservedPropertyFieldAlias='$fieldCode' AND ReservedPropertyFieldValue='".$input[$fieldName]."'";
					}
				}
			}
			
			if(!empty($extraOptionsQuery))
			{
				$cartQuery = "SELECT CartItem.CartItemID AS CartItemID, CartItemQuantity  FROM CartItem, CartItemField WHERE CartItem.CartItemID=CartItemField.CartItemID AND ReservedPropertyID='$reservedPropertyID' $sessionFilter $extraOptionsQuery ";			
			}
			else
			{
				$cartQuery = "SELECT CartItemID, CartItemQuantity  FROM CartItem WHERE ReservedPropertyID='$reservedPropertyID' $sessionFilter ";
			}
				$cartRS = $DS->query($cartQuery);
			if(!empty($cartRS[0]['CartItemID']))
			{
				$input['CartItemQuantity'] = abs($input['CartItemQuantity']) + $cartRS[0]['CartItemQuantity'];
				$entityID = $cartRS[0]['CartItemID'];
				
			}	
			else
			{
				$input['CartItemQuantity'] = abs($input['CartItemQuantity']);
			}
			
			
			//get reservedProperty info 
			$reservedPropertyQuery = "SELECT * FROM ReservedProperty WHERE ReservedPropertyID='$reservedPropertyID'";
			$reservedPropertyRS = $DS->query($reservedPropertyQuery);
			foreach ($reservedPropertyRS[0] as $fieldName=>$fieldValue)
			{
				$input['CartItem'.DTR.$fieldName] = addslashes($fieldValue);
			}
			//make price
			$cartItemPrice = $reservedPropertyRS[0]['ReservedPropertyPrice'];
			$cartItemWeight = $reservedPropertyRS[0]['ReservedPropertyWeight'];
			
			$input['CartItem'.DTR.'CartItemID'] = $entityID;

			$input['CartItem'.DTR.'CartItemQuantity'] = $input['CartItemQuantity'];
			$input['CartItem'.DTR.'CartItemPrice'] = $cartItemPrice;
			$input['CartItem'.DTR.'CartItemWeight'] = $cartItemWeight;
			$input['CartItem'.DTR.'SessionID'] = $sessionID;
			if($cartItemPrice>0)
			{
				$input['CartItem'.DTR.'CartItemType'] = 'order';
			}
			else
			{
				$input['CartItem'.DTR.'CartItemType'] = 'request';
			}

			$where['CartItem'] = "CartItemID = '".$entityID."'";
			$input['actionMode']='save';		
			//print_r($input);			
			$result = $DS->save($input,$where,'update');				
			$lastID = $result[0]['CartItemID'];
			$input['CartItemField'.DTR.'CartItemID']=$lastID;
			$optionsRS = $this->addCartItemFields($input);
			$this->countCartItemPrice($lastID,$reservedPropertyRS[0]['ReservedPropertyPrice'],$optionsRS['price']);
			$this->countCartItemWeightAndVolume($lastID,$reservedPropertyRS[0]['ReservedPropertyWeight'],$optionsRS['weight'],$reservedPropertyRS[0]['ReservedPropertyVolume'],$optionsRS['volume']);
		}
		$SERVER->setDebug('CartItemClass.setCartItem.End','End');	
		$this->emptyExpiredCarts();	
		return $result;		
	}

	function addCartItemFields($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CartItemClass.setCartItem.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;
		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['CartItemField'.DTR.'CartItemFieldID'];
		if(empty($entityID)) {$entityID = $input['CartItemFieldID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'CartItemServer.adminCartItem');
		//set queries	
		
		$sessionFilter = " UserID='".$userID."' OR  SessionID='".$sessionID."' ";			
		$cartItemID = $input['CartItem'.DTR.'CartItemID'];
		$reservedPropertyID = $input['ReservedProperty'.DTR.'ReservedPropertyID'];
		if(!empty($reservedPropertyID) && !empty($input['CartItemField'.DTR.'CartItemID']))
		{
			//check if the product is in the cart or not
			$cartQuery = "SELECT CartItemID FROM CartItemField WHERE CartItemID='$cartItemID' ";
			$cartFiledRS = $DS->query($cartQuery);
			if(count($cartFiledRS)<1)
			{
				$optionsPrice=0;
				$optionsWeight = 0;
				//get reservedProperty fields  values
				$reservedPropertyFieldQuery = "SELECT * FROM ReservedPropertyField WHERE ReservedPropertyID='$reservedPropertyID' AND ReservedPropertyFieldStatus!='2'";
				$reservedPropertyFieldRS = $DS->query($reservedPropertyFieldQuery);
				if(is_array($reservedPropertyFieldRS))
				{
				foreach($reservedPropertyFieldRS as $row)
				{
					//get reservedProperty field info
					$reservedPropertyTypeFieldQuery = "SELECT ReservedPropertyTypeFieldName, ReservedPropertyTypeFieldMode, ReservedPropertyTypeFieldType FROM ReservedPropertyTypeField WHERE ReservedPropertyTypeFieldID='".$row['ReservedPropertyTypeFieldID']."'";
					$reservedPropertyTypeFieldRS = $DS->query($reservedPropertyTypeFieldQuery);
					
					$row2 = $reservedPropertyTypeFieldRS[0];
					$input['CartItemField'.DTR.'ReservedPropertyTypeFieldID'] = $row['ReservedPropertyTypeFieldID'];
					$extraFieldName = $row['ReservedPropertyFieldAlias'];
					$input['CartItemField'.DTR.'ReservedPropertyFieldAlias'] = $row['ReservedPropertyFieldAlias'];
					$input['CartItemField'.DTR.'ReservedPropertyFieldType'] = $row2['ReservedPropertyTypeFieldType'];
					$input['CartItemField'.DTR.'ReservedPropertyFieldMode'] = $row2['ReservedPropertyTypeFieldMode'];
					$input['CartItemField'.DTR.'ReservedPropertyFieldName'] = addslashes($row2['ReservedPropertyTypeFieldName']);
					$input['CartItemField'.DTR.'ReservedPropertyFieldPosition'] = $row2['ReservedPropertyTypeFieldPosition'];
										
					$input['CartItemField'.DTR.'ReservedPropertyFieldValueNumber'] = $row['ReservedPropertyFieldValueNumber'];
					$input['CartItemField'.DTR.'ReservedPropertyFieldValueTime'] = $row['ReservedPropertyFieldValueTime'];
					
					if($row2['ReservedPropertyTypeFieldMode']=='option')
					{
						$input['CartItemField'.DTR.'ReservedPropertyFieldValue'] = $input['ReservedPropertyField'.DTR.$extraFieldName];
						//if(is_array($input['ReservedPropertyField'.DTR.$extraFieldName]))
						//{
							//$input['CartItemField'.DTR.'ReservedPropertyFieldValue'] = '|'. implode("|",$input['ReservedPropertyField'.DTR.$extraFieldName]).'|';
						//}
						//else
						//{
							$reservedPropertyTypeOptionQuery = "SELECT ReservedPropertyTypeOptionName FROM ReservedPropertyTypeOption WHERE ReservedPropertyTypeOptionID='".$input['CartItemField'.DTR.'ReservedPropertyFieldValue']."'";
							$reservedPropertyTypeOptionRS = $DS->query($reservedPropertyTypeOptionQuery);
							$input['CartItemField'.DTR.'ReservedPropertyFieldValueOptions'] = addslashes($reservedPropertyTypeOptionRS[0]['ReservedPropertyTypeOptionName']);
						//}
						
							//get the option data
							$reservedPropertyOptionQuery = "SELECT ReservedPropertyOptionPrice, ReservedPropertyOptionPriceAction, ReservedPropertyOptionWeight, ReservedPropertyOptionWeightAction FROM ReservedPropertyOption WHERE ReservedPropertyTypeOptionID='".$input['CartItemField'.DTR.'ReservedPropertyFieldValue']."' AND ReservedPropertyFieldID='".$row['ReservedPropertyFieldID']."'";
							$reservedPropertyOptionRS = $DS->query($reservedPropertyOptionQuery);
							if($reservedPropertyOptionRS[0]['ReservedPropertyOptionPriceAction']=='+')
							{
								$optionsPrice = $optionsPrice + $reservedPropertyOptionRS[0]['ReservedPropertyOptionPrice'];
							}
							else
							{
								$optionsPrice = $optionsPrice - $reservedPropertyOptionRS[0]['ReservedPropertyOptionPrice'];
							}
							
							if($reservedPropertyOptionRS[0]['ReservedPropertyOptionWeightAction']=='+')
							{
								$optionsWeight = $optionsWeight + $reservedPropertyOptionRS[0]['ReservedPropertyOptionWeight'];
							}
							else
							{
								$optionsWeight = $optionsWeight - $reservedPropertyOptionRS[0]['ReservedPropertyOptionWeight'];
							}							
					}
					else
					{
						$input['CartItemField'.DTR.'ReservedPropertyFieldValue'] = addslashes($row['ReservedPropertyFieldValue']);
						if($row2['ReservedPropertyTypeFieldType'] == 'dropdown' || $row2['ReservedPropertyTypeFieldType'] == 'radioboxes')
						{
							$reservedPropertyTypeOptionQuery = "SELECT ReservedPropertyTypeOptionName FROM ReservedPropertyTypeOption WHERE ReservedPropertyTypeOptionID='".$input['CartItemField'.DTR.'ReservedPropertyFieldValue']."'";
							$reservedPropertyTypeOptionRS = $DS->query($reservedPropertyTypeOptionQuery);
							$input['CartItemField'.DTR.'ReservedPropertyFieldValueOptions'] = addslashes($reservedPropertyTypeOptionRS[0]['ReservedPropertyTypeOptionName']);
						}
						elseif($row2['ReservedPropertyTypeFieldType'] == 'checkboxes' || $row2['ReservedPropertyTypeFieldType'] == 'multiple')
						{
							
						}
					}
		
					$where['CartItemField'] = "CartItemFieldID = '".$entityID."'";
					$input['actionMode']='save';					
					$DS->save($input,$where,'insert');	
				}		
				}	
			}	
		}
		 $result['price'] = $optionsPrice;
		 $result['weight'] = $optionsWeight;
		//$SERVER->setDebug('CartItemClass.setCartItem.End','End');		
		return $result;		
	}
	
	function countCartItemPrice($itemID,$reservedPropertyPrice,$optionsTotal)
	{
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		if(!empty($itemID))
		{
			$price = $reservedPropertyPrice + $optionsTotal;
			$query = "UPDATE CartItem SET CartItemPrice=$price WHERE CartItemID='$itemID'";
			$DS->query($query);
		}
	}	
	
	function countCartItemWeightAndVolume($itemID,$reservedPropertyWeight,$optionsWeight,$reservedPropertyVolume,$optionsVolume)
	{
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;	
		
		if(!empty($itemID))
		{
			$weight = $reservedPropertyWeight + $reservedPropertyWeight;
			$volume = $reservedPropertyVolume + $optionsVolume;
			$query = "UPDATE CartItem SET CartItemWeight=$weight, CartItemVolume=$volume WHERE CartItemID='$itemID'";
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
	function setCartItem($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CartItemClass.setCartItem.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['CartItem'.DTR.'CartItemID'];
		if(empty($entityID)) {$entityID = $input['CartItemID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'CartItemServer.adminCartItem');
		//set queries	
		//if(is_array($input['CartItem'.DTR.'AccessGroups'])) {$input['CartItem'.DTR.'AccessGroups'] = '|'. implode("|",$input['CartItem'.DTR.'AccessGroups']).'|';}
		if(is_array($input['CartItem'.DTR.'CartItemID']))
		{
			foreach($input['CartItem'.DTR.'CartItemID'] as $id=>$cartItemID)
			{
				$inputSave['CartItem'.DTR.'CartItemID'] = $cartItemID; 
				$inputSave['CartItem'.DTR.'CartItemQuantity'] = $input['CartItem'.DTR.'CartItemQuantity'][$id]; 
				
				if(!empty($inputSave['CartItem'.DTR.'CartItemQuantity']))
				{
					$inputSave['actionMode']='save';					
					$where['CartItem'] = "CartItemID = '".$cartItemID."'";
					$result = $DS->save($inputSave,$where,'update');					
				}
				elseif(!empty($cartItemID))
				{
					$this->deleteCartItem($cartItemID);
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
		$SERVER->setDebug('CartItemClass.setCartItem.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;
		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$filter =  " AND CartItemType='".$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderType']."'";
		$sessionFilter = " (UserID='".$userID."' OR  SessionID='".$sessionID."') ";	
		$sessionFilter .= $filter;
		
		$cartItemsRS = $DS->query("SELECT CartItemID FROM CartItem WHERE $sessionFilter ");
		if(is_array($cartItemsRS))
		{
			foreach($cartItemsRS as $row)
			{
				$this->deleteCartItem($row['CartItemID']);
			}
		}			
				
	}
	
	function emptyExpiredCarts ()
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CartItemClass.setCartItem.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$sessionID = $this->_sessionID;
		
		$expirytimeSmp = (string) (time() - $config['CookieTimeout']);
		$expirytime = date("Y-m-d H:i:s",$expirytimeSmp);
		$expiredCartItemsQuery = "SELECT CartItemID FROM CartItem WHERE TimeCreated < '$expirytime'";
		$expiredCartItemsRS = $DS->query($expiredCartItemsQuery);
		if(is_array($expiredCartItemsRS))
		{
			foreach($expiredCartItemsRS as $row)
			{
				$this->deleteCartItem($row['CartItemID']);
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
	function deleteCartItem($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		//set client side variables
		if(is_array($input))
		{
			$entityID = $input['CartItem'.DTR.'CartItemID'];
		}
		else
		{
			$entityID = $input;
		}
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM CartItem WHERE CartItemID='$entityID'");
			$DS->query("DELETE FROM CartItemField WHERE CartItemID='$entityID'");
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
} // end of CartItemServer
?>
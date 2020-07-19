<?php
//XCMSPro: Web Service entity class
class PropertyCartItemClass
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
	function PropertyCartItemClass()
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
	function getCartItemsProperty($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CartItemClass.getCartItemsProperty.Start','Start');
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
		
		if(!empty($input['PropertyOrder'.DTR.'PropertyOrderType']))
		{
			$filter = " AND CartItemType='".$input['PropertyOrder'.DTR.'PropertyOrderType']."'"; 
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
				$propertyID = $row['PropertyID'];
				$cartItemID = $row['CartItemID'];
				$propertyFieldAlias = $row['PropertyFieldAlias'];
				foreach($row as $fieldName=>$fieldValue)
				{
					if($fieldName=='PropertyFields')
					{
						$result[$cartItemID][$fieldName] = $fieldValue;
					}
					elseif(eregi("PropertyField",$fieldName) || $fieldName=='PropertyTypeFieldID' || $fieldName=='CartItemFieldID')
					{
						$result[$cartItemID]['CartItemFields'][$propertyFieldAlias][$fieldName] = $fieldValue;
					}
					else
					{
						$result[$cartItemID][$fieldName] = $fieldValue;
					}
				}
			}
		}
		$SERVER->setDebug('CartItemClass.getCartItemsProperty.End','End');
		
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
		$propertyID = $input['Property'.DTR.'PropertyID'];
		if(!empty($propertyID) && !empty($input['CartItemQuantity']) && !empty($sessionID))
		{
			//check if the product is in the cart or not
			$extraOptionsQuery= '';
			
			foreach($input as $fieldName=>$fieldVale)
			{
				if(eregi('PropertyField'.DTR,$fieldName))
				{
					$fieldCode = str_replace('PropertyField'.DTR,"",$fieldName);
					if(!empty($input[$fieldName]))
					{
						$extraOptionsQuery .= " AND PropertyFieldAlias='$fieldCode' AND PropertyFieldValue='".$input[$fieldName]."'";
					}
				}
			}
			
			if(!empty($extraOptionsQuery))
			{
				$cartQuery = "SELECT CartItem.CartItemID AS CartItemID, CartItemQuantity  FROM CartItem, CartItemField WHERE CartItem.CartItemID=CartItemField.CartItemID AND PropertyID='$propertyID' $sessionFilter $extraOptionsQuery ";			
			}
			else
			{
				$cartQuery = "SELECT CartItemID, CartItemQuantity  FROM CartItem WHERE PropertyID='$propertyID' $sessionFilter ";
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
			
			
			//get property info 
			$propertyQuery = "SELECT * FROM Property WHERE PropertyID='$propertyID'";
			$propertyRS = $DS->query($propertyQuery);
			foreach ($propertyRS[0] as $fieldName=>$fieldValue)
			{
				$input['CartItem'.DTR.$fieldName] = addslashes($fieldValue);
			}
			//make price
			$cartItemPrice = $propertyRS[0]['PropertyPrice'];
			$cartItemWeight = $propertyRS[0]['PropertyWeight'];
			
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
			$this->countCartItemPrice($lastID,$propertyRS[0]['PropertyPrice'],$optionsRS['price']);
			$this->countCartItemWeightAndVolume($lastID,$propertyRS[0]['PropertyWeight'],$optionsRS['weight'],$propertyRS[0]['PropertyVolume'],$optionsRS['volume']);
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
		$propertyID = $input['Property'.DTR.'PropertyID'];
		if(!empty($propertyID) && !empty($input['CartItemField'.DTR.'CartItemID']))
		{
			//check if the product is in the cart or not
			$cartQuery = "SELECT CartItemID FROM CartItemField WHERE CartItemID='$cartItemID' ";
			$cartFiledRS = $DS->query($cartQuery);
			if(count($cartFiledRS)<1)
			{
				$optionsPrice=0;
				$optionsWeight = 0;
				//get property fields  values
				$propertyFieldQuery = "SELECT * FROM PropertyField WHERE PropertyID='$propertyID' AND PropertyFieldStatus!='2'";
				$propertyFieldRS = $DS->query($propertyFieldQuery);
				if(is_array($propertyFieldRS))
				{
				foreach($propertyFieldRS as $row)
				{
					//get property field info
					$propertyTypeFieldQuery = "SELECT PropertyTypeFieldName, PropertyTypeFieldMode, PropertyTypeFieldType FROM PropertyTypeField WHERE PropertyTypeFieldID='".$row['PropertyTypeFieldID']."'";
					$propertyTypeFieldRS = $DS->query($propertyTypeFieldQuery);
					
					$row2 = $propertyTypeFieldRS[0];
					$input['CartItemField'.DTR.'PropertyTypeFieldID'] = $row['PropertyTypeFieldID'];
					$extraFieldName = $row['PropertyFieldAlias'];
					$input['CartItemField'.DTR.'PropertyFieldAlias'] = $row['PropertyFieldAlias'];
					$input['CartItemField'.DTR.'PropertyFieldType'] = $row2['PropertyTypeFieldType'];
					$input['CartItemField'.DTR.'PropertyFieldMode'] = $row2['PropertyTypeFieldMode'];
					$input['CartItemField'.DTR.'PropertyFieldName'] = addslashes($row2['PropertyTypeFieldName']);
					$input['CartItemField'.DTR.'PropertyFieldPosition'] = $row2['PropertyTypeFieldPosition'];
										
					$input['CartItemField'.DTR.'PropertyFieldValueNumber'] = $row['PropertyFieldValueNumber'];
					$input['CartItemField'.DTR.'PropertyFieldValueTime'] = $row['PropertyFieldValueTime'];
					
					if($row2['PropertyTypeFieldMode']=='option')
					{
						$input['CartItemField'.DTR.'PropertyFieldValue'] = $input['PropertyField'.DTR.$extraFieldName];
						//if(is_array($input['PropertyField'.DTR.$extraFieldName]))
						//{
							//$input['CartItemField'.DTR.'PropertyFieldValue'] = '|'. implode("|",$input['PropertyField'.DTR.$extraFieldName]).'|';
						//}
						//else
						//{
							$propertyTypeOptionQuery = "SELECT PropertyTypeOptionName FROM PropertyTypeOption WHERE PropertyTypeOptionID='".$input['CartItemField'.DTR.'PropertyFieldValue']."'";
							$propertyTypeOptionRS = $DS->query($propertyTypeOptionQuery);
							$input['CartItemField'.DTR.'PropertyFieldValueOptions'] = addslashes($propertyTypeOptionRS[0]['PropertyTypeOptionName']);
						//}
						
							//get the option data
							$propertyOptionQuery = "SELECT PropertyOptionPrice, PropertyOptionPriceAction, PropertyOptionWeight, PropertyOptionWeightAction FROM PropertyOption WHERE PropertyTypeOptionID='".$input['CartItemField'.DTR.'PropertyFieldValue']."' AND PropertyFieldID='".$row['PropertyFieldID']."'";
							$propertyOptionRS = $DS->query($propertyOptionQuery);
							if($propertyOptionRS[0]['PropertyOptionPriceAction']=='+')
							{
								$optionsPrice = $optionsPrice + $propertyOptionRS[0]['PropertyOptionPrice'];
							}
							else
							{
								$optionsPrice = $optionsPrice - $propertyOptionRS[0]['PropertyOptionPrice'];
							}
							
							if($propertyOptionRS[0]['PropertyOptionWeightAction']=='+')
							{
								$optionsWeight = $optionsWeight + $propertyOptionRS[0]['PropertyOptionWeight'];
							}
							else
							{
								$optionsWeight = $optionsWeight - $propertyOptionRS[0]['PropertyOptionWeight'];
							}							
					}
					else
					{
						$input['CartItemField'.DTR.'PropertyFieldValue'] = addslashes($row['PropertyFieldValue']);
						if($row2['PropertyTypeFieldType'] == 'dropdown' || $row2['PropertyTypeFieldType'] == 'radioboxes')
						{
							$propertyTypeOptionQuery = "SELECT PropertyTypeOptionName FROM PropertyTypeOption WHERE PropertyTypeOptionID='".$input['CartItemField'.DTR.'PropertyFieldValue']."'";
							$propertyTypeOptionRS = $DS->query($propertyTypeOptionQuery);
							$input['CartItemField'.DTR.'PropertyFieldValueOptions'] = addslashes($propertyTypeOptionRS[0]['PropertyTypeOptionName']);
						}
						elseif($row2['PropertyTypeFieldType'] == 'checkboxes' || $row2['PropertyTypeFieldType'] == 'multiple')
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
	
	function countCartItemPrice($itemID,$propertyPrice,$optionsTotal)
	{
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		if(!empty($itemID))
		{
			$price = $propertyPrice + $optionsTotal;
			$query = "UPDATE CartItem SET CartItemPrice=$price WHERE CartItemID='$itemID'";
			$DS->query($query);
		}
	}	
	
	function countCartItemWeightAndVolume($itemID,$propertyWeight,$optionsWeight,$propertyVolume,$optionsVolume)
	{
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;	
		
		if(!empty($itemID))
		{
			$weight = $propertyWeight + $propertyWeight;
			$volume = $propertyVolume + $optionsVolume;
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
		$filter =  " AND CartItemType='".$input['PropertyOrder'.DTR.'PropertyOrderType']."'";
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
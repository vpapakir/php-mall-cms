<?php  
//XCMSPro: Web Service entity class
class CartItemClass
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
	function CartItemClass()
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
	function getCartItems($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CartItemClass.getCartItems.Start','Start');
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
		
		if(!empty($input['ResourceOrder'.DTR.'ResourceOrderType']))
		{
			$filter = " AND CartItemType='".$input['ResourceOrder'.DTR.'ResourceOrderType']."'"; 
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
				$resourceID = $row['ResourceID'];
				$cartItemID = $row['CartItemID'];
				$resourceFieldAlias = $row['ResourceFieldAlias'];
				foreach($row as $fieldName=>$fieldValue)
				{
					if($fieldName=='ResourceFields')
					{
						$result[$cartItemID][$fieldName] = $fieldValue;
					}
					elseif(eregi("ResourceField",$fieldName) || $fieldName=='ResourceTypeFieldID' || $fieldName=='CartItemFieldID')
					{
						$result[$cartItemID]['CartItemFields'][$resourceFieldAlias][$fieldName] = $fieldValue;
					}
					else
					{
						$result[$cartItemID][$fieldName] = $fieldValue;
					}
				}
			}
		}
		$SERVER->setDebug('CartItemClass.getCartItems.End','End');
		
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
		$resourceID = $input['Resource'.DTR.'ResourceID'];
		if(!empty($resourceID) && !empty($input['CartItemQuantity']) && !empty($sessionID))
		{
			//check if the product is in the cart or not
			$extraOptionsQuery= '';
			
			foreach($input as $fieldName=>$fieldVale)
			{
				if(eregi('ResourceField'.DTR,$fieldName))
				{
					$fieldCode = str_replace('ResourceField'.DTR,"",$fieldName);
					if(!empty($input[$fieldName]))
					{
						$extraOptionsQuery .= " AND ResourceFieldAlias='$fieldCode' AND ResourceFieldValue='".$input[$fieldName]."'";
					}
				}
			}
			
			if(!empty($extraOptionsQuery))
			{
				$cartQuery = "SELECT CartItem.CartItemID AS CartItemID, CartItemQuantity  FROM CartItem, CartItemField WHERE CartItem.CartItemID=CartItemField.CartItemID AND ResourceID='$resourceID' $sessionFilter $extraOptionsQuery ";			
			}
			else
			{
				$cartQuery = "SELECT CartItemID, CartItemQuantity  FROM CartItem WHERE ResourceID='$resourceID' $sessionFilter ";
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
			
			
			//get resource info 
			$resourceQuery = "SELECT * FROM Resource WHERE ResourceID='$resourceID'";
			$resourceRS = $DS->query($resourceQuery);
			foreach ($resourceRS[0] as $fieldName=>$fieldValue)
			{
				$input['CartItem'.DTR.$fieldName] = addslashes($fieldValue);
			}
			//make price
			$cartItemPrice = $resourceRS[0]['ResourcePrice'];
			$cartItemWeight = $resourceRS[0]['ResourceWeight'];
			
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
			
			$input['CartItem'.DTR.'TimeCreated'] = ''; 
            $input['CartItem'.DTR.'TimeSaved'] = '';
			
			$where['CartItem'] = "CartItemID = '".$entityID."'";
			$input['actionMode']='save';		
			//print_r($input);			

      $result = $DS->save($input,$where,'update');				

			$lastID = $result[0]['CartItemID'];
			$input['CartItemField'.DTR.'CartItemID']=$lastID;
			$optionsRS = $this->addCartItemFields($input);
			$this->countCartItemPrice($lastID,$resourceRS[0]['ResourcePrice'],$optionsRS['price']);
			$this->countCartItemWeightAndVolume($lastID,$resourceRS[0]['ResourceWeight'],$optionsRS['weight'],$resourceRS[0]['ResourceVolume'],$optionsRS['volume']);
		}
		$SERVER->setDebug('CartItemClass.setCartItem.End','End');	
	//	$this->emptyExpiredCarts();
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
		$resourceID = $input['Resource'.DTR.'ResourceID'];
		if(!empty($resourceID) && !empty($input['CartItemField'.DTR.'CartItemID']))
		{
			//check if the product is in the cart or not
			$cartQuery = "SELECT CartItemID FROM CartItemField WHERE CartItemID='$cartItemID' ";
			$cartFiledRS = $DS->query($cartQuery);
			if(count($cartFiledRS)<1)
			{
				$optionsPrice=0;
				$optionsWeight = 0;
				//get resource fields  values
				$resourceFieldQuery = "SELECT * FROM ResourceField WHERE ResourceID='$resourceID' AND ResourceFieldStatus!='2'";
				$resourceFieldRS = $DS->query($resourceFieldQuery);
				if(is_array($resourceFieldRS))
				{
				foreach($resourceFieldRS as $row)
				{
					//get resource field info
					$resourceTypeFieldQuery = "SELECT ResourceTypeFieldName, ResourceTypeFieldMode, ResourceTypeFieldType FROM ResourceTypeField WHERE ResourceTypeFieldID='".$row['ResourceTypeFieldID']."'";
					$resourceTypeFieldRS = $DS->query($resourceTypeFieldQuery);
					
					$row2 = $resourceTypeFieldRS[0];
					$input['CartItemField'.DTR.'ResourceTypeFieldID'] = $row['ResourceTypeFieldID'];
					$extraFieldName = $row['ResourceFieldAlias'];
					$input['CartItemField'.DTR.'ResourceFieldAlias'] = $row['ResourceFieldAlias'];
					$input['CartItemField'.DTR.'ResourceFieldType'] = $row2['ResourceTypeFieldType'];
					$input['CartItemField'.DTR.'ResourceFieldMode'] = $row2['ResourceTypeFieldMode'];
					$input['CartItemField'.DTR.'ResourceFieldName'] = addslashes($row2['ResourceTypeFieldName']);
					$input['CartItemField'.DTR.'ResourceFieldPosition'] = $row2['ResourceTypeFieldPosition'];
										
					$input['CartItemField'.DTR.'ResourceFieldValueNumber'] = $row['ResourceFieldValueNumber'];
					$input['CartItemField'.DTR.'ResourceFieldValueTime'] = $row['ResourceFieldValueTime'];
					
					if($row2['ResourceTypeFieldMode']=='option')
					{
						$input['CartItemField'.DTR.'ResourceFieldValue'] = $input['ResourceField'.DTR.$extraFieldName];
						//if(is_array($input['ResourceField'.DTR.$extraFieldName]))
						//{
							//$input['CartItemField'.DTR.'ResourceFieldValue'] = '|'. implode("|",$input['ResourceField'.DTR.$extraFieldName]).'|';
						//}
						//else
						//{
							$resourceTypeOptionQuery = "SELECT ResourceTypeOptionName FROM ResourceTypeOption WHERE ResourceTypeOptionID='".$input['CartItemField'.DTR.'ResourceFieldValue']."'";
							$resourceTypeOptionRS = $DS->query($resourceTypeOptionQuery);
							$input['CartItemField'.DTR.'ResourceFieldValueOptions'] = addslashes($resourceTypeOptionRS[0]['ResourceTypeOptionName']);
						//}
						
							//get the option data
							$resourceOptionQuery = "SELECT ResourceOptionPrice, ResourceOptionPriceAction, ResourceOptionWeight, ResourceOptionWeightAction FROM ResourceOption WHERE ResourceTypeOptionID='".$input['CartItemField'.DTR.'ResourceFieldValue']."' AND ResourceFieldID='".$row['ResourceFieldID']."'";
							$resourceOptionRS = $DS->query($resourceOptionQuery);
							if($resourceOptionRS[0]['ResourceOptionPriceAction']=='+')
							{
								$optionsPrice = $optionsPrice + $resourceOptionRS[0]['ResourceOptionPrice'];
							}
							else
							{
								$optionsPrice = $optionsPrice - $resourceOptionRS[0]['ResourceOptionPrice'];
							}
							
							if($resourceOptionRS[0]['ResourceOptionWeightAction']=='+')
							{
								$optionsWeight = $optionsWeight + $resourceOptionRS[0]['ResourceOptionWeight'];
							}
							else
							{
								$optionsWeight = $optionsWeight - $resourceOptionRS[0]['ResourceOptionWeight'];
							}							
					}
					else
					{
						$input['CartItemField'.DTR.'ResourceFieldValue'] = addslashes($row['ResourceFieldValue']);
						if($row2['ResourceTypeFieldType'] == 'dropdown' || $row2['ResourceTypeFieldType'] == 'radioboxes')
						{
							$resourceTypeOptionQuery = "SELECT ResourceTypeOptionName FROM ResourceTypeOption WHERE ResourceTypeOptionID='".$input['CartItemField'.DTR.'ResourceFieldValue']."'";
							$resourceTypeOptionRS = $DS->query($resourceTypeOptionQuery);
							$input['CartItemField'.DTR.'ResourceFieldValueOptions'] = addslashes($resourceTypeOptionRS[0]['ResourceTypeOptionName']);
						}
						elseif($row2['ResourceTypeFieldType'] == 'checkboxes' || $row2['ResourceTypeFieldType'] == 'multiple')
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

	function countCartItemPrice($itemID,$resourcePrice,$optionsTotal)
	{  
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		if(!empty($itemID))
		{
			$price = $resourcePrice + $optionsTotal;
			$query = "UPDATE CartItem SET CartItemPrice=$price WHERE CartItemID='$itemID'";
			$DS->query($query);
		}
  
  }	
	
	function countCartItemWeightAndVolume($itemID,$resourceWeight,$optionsWeight,$resourceVolume,$optionsVolume)
	{
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;	
		
		if(!empty($itemID))
		{
			$weight = $resourceWeight + $resourceWeight;
			$volume = $resourceVolume + $optionsVolume;
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
		//$this->emptyExpiredCarts();
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
		$filter =  " AND CartItemType='".$input['ResourceOrder'.DTR.'ResourceOrderType']."'";
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

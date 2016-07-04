<?php
//XCMSPro: Web Service entity class
class ResourceOrderClass
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
	function ResourceOrderClass()
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
	function getResourceOrders($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceOrderClass.getResourceOrders.Start','Start');
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
		$filterUser = $input['filterUser'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceOrderServer.adminResourceOrder');
		if(!empty($searchWord))
		{
			$filter .= " AND ( ResourceOrderFirstName LIKE '{ls}%$searchWord%{le}' OR  ResourceOrderFirstName LIKE '%$searchWord%' OR  ResourceOrderLastName LIKE '{ls}%$searchWord%{le}' OR  ResourceOrderLastName LIKE '%$searchWord%' OR  ResourceOrderEmail LIKE '{ls}%$searchWord%{le}' OR  ResourceOrderEmail LIKE '%$searchWord%')";
			$filter .= " AND ( ResourceOrderID LIKE '{ls}%$searchWord%{le}' OR  ResourceOrderID LIKE '%$searchWord%')";
		}
		
		if(!empty($input['ResourceOrderStatus']))
		{
			$ResourceOrderStatus = $input['ResourceOrderStatus'];
			$filter .= " AND ResourceOrderStatus = '$ResourceOrderStatus' ";
		}
		
		if(!empty($input['ResourceOrderPaymentStatus']))
		{
			$ResourceOrderPaymentStatus = $input['ResourceOrderPaymentStatus'];
			$filter .= " AND ResourceOrderPaymentStatus = '$ResourceOrderPaymentStatus' ";
		}
		
		if(($userID != 'admin' && $userID != 'root') || $filterUser=='User')
		{
			$filter .= " AND UserID = '$userID' ";
		}
		
		if($filterMode=='last')
		{
			$limit = " LIMIT 0,10";
		}		
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		//$query = "SELECT * FROM ResourceOrder WHERE ResourceOrderID>0 $filter ORDER BY ResourceOrderPosition";
		$query = "SELECT * FROM ResourceOrder WHERE ResourceOrderID>0 $filter ORDER BY TimeCreated DESC".$limit;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ResourceOrderClass.getResourceOrders.End','End');
		return $result;
	}	
	
	function getResourceOrderFields($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceOrderClass.getResourceOrderFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceOrder'.DTR.'ResourceOrderID'];
		if(empty($entityID)) {$entityID = $input['ResourceOrderID'];}
		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceOrder'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceOrderAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceOrder'.DTR.'ResourceOrderAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$ResourceOrderIDRS = $DS->query("SELECT ResourceOrderID FROM ResourceOrder WHERE ResourceOrderAlias='$entityAlias'");
			$entityID = $ResourceOrderIDRS[0]['ResourceOrderID'];
		}
		//$filter = $DS->getAccessFilter($input,'ResourceOrderServer.adminResourceOrder');
		if(!empty($entityID))		
		{
			$filter .= " AND ResourceOrderID='$entityID'";
		}
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM ResourceOrderField WHERE ResourceOrderFieldID>0 $filter ORDER BY ResourceOrderFieldPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ResourceOrderClass.getResourceOrderFields.End','End');
		return $result;
	}	
	
	function getResourceOrderOptions($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceOrderClass.getResourceOrderFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceOrderField'.DTR.'ResourceOrderFieldID'];
		if(empty($entityID)) {$entityID = $input['ResourceOrderFieldID'];}
		
		$entityAlias = $input['ResourceField'];		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceOrderFieldAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceOrderField'.DTR.'ResourceOrderFieldAlias'];}
		
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$ResourceOrderIDRS = $DS->query("SELECT ResourceOrderFieldID FROM ResourceOrderField WHERE ResourceOrderFieldAlias='$entityAlias'");
			$entityID = $ResourceOrderIDRS[0]['ResourceOrderFieldID'];
		}
		//$filter = $DS->getAccessFilter($input,'ResourceOrderServer.adminResourceOrder');
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM ResourceOrderOption WHERE ResourceOrderFieldID='$entityID' $filter ORDER BY ResourceOrderOptionPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ResourceOrderClass.getResourceOrderFields.End','End');
		return $result;
	}	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getResourceOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceOrderClass.getResourceOrder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ResourceOrder'.DTR.'ResourceOrderID'];
		if(empty($entityID)) {$entityID = $input['ResourceOrderID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceOrder'];}
		if(empty($entityAlias)) {$entityAlias = $input['ResourceOrderAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceOrder'.DTR.'ResourceOrderAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceOrderServer.adminResourceOrder');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ResourceOrderAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ResourceOrderID='$entityID' ";
		}
		$query = "SELECT * FROM ResourceOrder WHERE $filter"; 
		//echo $query;
		//get the content
		
		$result = $DS->query($query);	

		$SERVER->setDebug('ResourceOrderClass.getResourceOrder.End','End');		
		return $result;		
	}
	
	function getResourceOrderField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceOrderClass.getResourceOrderField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ResourceOrderField'.DTR.'ResourceOrderFieldID'];
		if(empty($entityID)) {$entityID = $input['ResourceOrderFieldID'];}

		$entityAlias = $input['ResourceOrderField'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceOrderFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceOrderField'.DTR.'ResourceOrderFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceOrderServer.adminResourceOrder');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ResourceOrderFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ResourceOrderFieldID='$entityID' ";
		}
		$query = "SELECT * FROM ResourceOrderField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('ResourceOrderClass.getResourceOrderField.End','End');		
		return $result;		
	}

	function getResourceOrderOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceOrderClass.getResourceOrderOption.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ResourceOrderOption'.DTR.'ResourceOrderOptionID'];
		if(empty($entityID)) {$entityID = $input['ResourceOrderOptionID'];}

		$entityAlias = $input['ResourceOrderOption'];
		if(empty($entityAlias)) {$entityAlias = $input['ResourceOrderOptionAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ResourceOrderOption'.DTR.'ResourceOrderOptionAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceOrderServer.adminResourceOrder');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ResourceOrderOptionAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ResourceOrderOptionID='$entityID' ";
		}
		$query = "SELECT * FROM ResourceOrderOption WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('ResourceOrderClass.getResourceOrderOption.End','End');		
		return $result;		
	}
	
	function getResourceOrderItem($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$orderID = $input['ResourceOrderID'];
		//set client side variables
		//set queries
		if(!empty($orderID))
		{
			$filter .= " AND ResourceOrderID='$orderID' ";
		}
			
		$query = "SELECT * FROM ResourceOrderItem WHERE  ResourceOrderItemID>0 $filter"; 
		//get the content
		$result = $DS->query($query);
		
		return $result;		
	}
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	
	function setResourceOrders($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceOrderClass.setResourceOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		foreach($input['ResourceOrder'.DTR.'ResourceOrderPaymentStatus'] as $id=>$value)
		{
			$ResourceOrderPaymentStatus = $value;
			$ResourceOrderStatus = $input['ResourceOrder'.DTR.'ResourceOrderStatus'][$id];
			$entityID = $input['ResourceOrderID'][$id];
			
			if(!empty($entityID))
			{
				$oldRS = $DS->query("SELECT ResourceOrderPaymentStatus, ResourceOrderStatus FROM ResourceOrder WHERE  ResourceOrderID = '$entityID'");
				$oldPaymentStatus = $oldRS[0]['ResourceOrderPaymentStatus'];
				$oldOrderStatus = $oldRS[0]['ResourceOrderStatus'];
				if(!empty($oldPaymentStatus) && !empty($ResourceOrderPaymentStatus) && $oldPaymentStatus!=$ResourceOrderPaymentStatus)
				{
					$this->sendEmailRemind($entityID,$ResourceOrderPaymentStatus);
				}
				if(!empty($oldOrderStatus) && !empty($ResourceOrderStatus) && $oldOrderStatus!=$ResourceOrderStatus)
				{
					$this->sendEmailRemind($entityID,$ResourceOrderStatus);
				}				
				$query = "UPDATE  ResourceOrder SET ResourceOrderPaymentStatus = '$ResourceOrderPaymentStatus', ResourceOrderStatus ='$ResourceOrderStatus' WHERE ResourceOrderID = '$entityID'";
				$DS->query($query);
			}
			/*$result = $DS->save($inValue,$where);*/
		}
	}
	
	function updateResourceOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceOrderClass.setResourceOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//print_r($input);
		$entityID = $input['ResourceOrderID'];
		$ResourceOrderPaymentStatus = $input['ResourceOrder'.DTR.'ResourceOrderPaymentStatus'];
		$ResourceOrderStatus = $input['ResourceOrder'.DTR.'ResourceOrderStatus'];
		
		$query = "UPDATE  ResourceOrder SET ResourceOrderPaymentStatus = '$ResourceOrderPaymentStatus', ResourceOrderStatus ='$ResourceOrderStatus' WHERE ResourceOrderID = '$entityID'";
		$DS->query($query);
		
		return $result;
	}
	
	function setResourceOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceOrderClass.setResourceOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ResourceOrder'.DTR.'ResourceOrderID'];
		if(empty($entityID)) {$entityID = $input['ResourceOrderID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceOrderServer.adminResourceOrder');
		//set queries	
		//if(is_array($input['ResourceOrder'.DTR.'AccessGroups'])) {$input['ResourceOrder'.DTR.'AccessGroups'] = '|'. implode("|",$input['ResourceOrder'.DTR.'AccessGroups']).'|'; }
		$where['ResourceOrder'] = "ResourceOrderID = '".$entityID."'".$filter;

		if(!empty($input['ResourceOrder'.DTR.'ResourceOrderAlias']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT ResourceOrderAlias FROM ResourceOrder WHERE ResourceOrderAlias='".$input['ResourceOrder'.DTR.'ResourceOrderAlias']."'");
		}
		if(count($checkRS)<1 && !empty($input['ResourceOrder'.DTR.'ResourceOrderAlias']) && !empty($input['ResourceOrder'.DTR.'ResourceOrderName']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);

			$oldRS = $DS->query("SELECT ResourceOrderPaymentStatus, ResourceOrderStatus WHERE  ResourceOrderID = '$entityID'");
			$oldPaymentStatus = $oldRS[0]['ResourceOrderPaymentStatus'];
			$oldOrderStatus = $oldRS[0]['ResourceOrderStatus'];
			if(!empty($oldPaymentStatus) && !empty($input['ResourceOrder'.DTR.'ResourceOrderPaymentStatus']) && $oldPaymentStatus!=$input['ResourceOrder'.DTR.'ResourceOrderPaymentStatus'])
			{
				$this->sendEmailRemind($entityID,$input['ResourceOrder'.DTR.'ResourceOrderPaymentStatus']);
			}
			if(!empty($oldOrderStatus) && !empty($input['ResourceOrder'.DTR.'ResourceOrderStatus']) && $oldOrderStatus!=$input['ResourceOrder'.DTR.'ResourceOrderStatus'])
			{
				$this->sendEmailRemind($entityID,$input['ResourceOrder'.DTR.'ResourceOrderStatus']);
			}				
		}
		else
		{
			if(!empty($input['ResourceOrder'.DTR.'ResourceOrderAlias']))
			{
				$SERVER->setMessage('ResourceOrderClass.setResourceOrder.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ResourceOrderClass.setResourceOrder.msg.DataSaved');
		}
		if(!empty($input['ResourceOrder'.DTR.'ResourceOrderAlias']) && !empty($entityID))
		{
			$this->updateEntityPositions($entityID,'ResourceOrder');
			$DS->query("UPDATE ResourceOrderField SET ResourceOrder='".$input['ResourceOrder'.DTR.'ResourceOrderAlias']."' WHERE ResourceOrderID='$entityID'");
		}
		$SERVER->setDebug('ResourceOrderClass.setResourceOrder.End','End');		
		return $result;		
	}
	
	function addResourceOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		//set queries	
		$orderMode = $input['orderMode'];
		//print_r($input);
		if(empty($userID))
		{
			//try to get user my his email
			$userRS = $DS->query("SELECT UserID FROM User WHERE Email='".$input['ResourceOrder'.DTR.'ResourceOrderEmail']."'");
			$userID = $userRS[0]['UserID'];
			$input['ResourceOrder'.DTR.'UserID'] = $userID;
		}
		
		$CartItem = new CartItemClass();
		$cartItemsRS = $CartItem->getCartItems($input);
		if(count($cartItemsRS)>0 || $orderMode=='direct' || $orderMode=='enquiry' || $orderMode=='directorder')			
		{		
			if(!empty($userID))
			{
				if(empty($input['ResourceOrder'.DTR.'ResourceOrderStatus'])) {$input['ResourceOrder'.DTR.'ResourceOrderStatus']='new';}
				if(empty($input['ResourceOrder'.DTR.'ResourceOrderPaymentStatus'])) {$input['ResourceOrder'.DTR.'ResourceOrderPaymentStatus']='notpaid';}
				if(empty($input['ResourceOrder'.DTR.'ResourceOrderType'])) {$input['ResourceOrder'.DTR.'ResourceOrderType']='order';}
				
				$where['ResourceOrder'] = "ResourceOrderID = ''";
				//block doubled insert
				$blockTime = time()-30;//30 seconds limit
				$endTime = $SERVER->getNow($blockTime);
				$checkRS=$DS->query("SELECT ResourceOrderID FROM ResourceOrder WHERE UserID='$userID' AND TimeCreated > '$endTime'");
				if(count($checkRS)<1 && !empty($input['ResourceOrder'.DTR.'ResourceOrderFirstName']))
				{		
					$input['actionMode']='save';					
					$result = $DS->save($input,$where,'insert');	
					$input['ResourceOrderID'] = $result[0]['ResourceOrderID'];
					
					$this->addResourceOrderItem($input,$cartItemsRS);
					$this->updateOrderTotals($input['ResourceOrderID'],$input);
					$this->sendEmailRemind($input['ResourceOrderID'],'new');
				}
				else
				{
					$SERVER->setMessage('resource.ResourceOrderClass.setResourceOrder.err.AlreadyExists');
				}
				if(count($result)>0)	
				{
					$SERVER->setMessage('resource.ResourceOrderClass.setResourceOrder.msg.DataSaved');
				}
				if($orderMode!='direct' && $orderMode!='directorder' && $orderMode!='enquiry')
				{
					$CartItem->emptyCart($input);
				}
			}
		}
		
		$result['ResourceOrderID'] = $input['ResourceOrderID'];
		return $result;		
	}	

	function addResourceOrderItem($input,$cartItemsRS)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$orderID = $input['ResourceOrderID'];
		$orderMode = $input['orderMode'];
		//set client side variables
		//set queries	
		if(empty($userID))
		{
			//try to get user my his email
			$userRS = $DS->query("SELECT UserID FROM User WHERE Email='".$input['ResourceOrder'.DTR.'ResourceOrderEmail']."'");
			$userID = $userRS[0]['UserID'];
			$input['ResourceOrderItem'.DTR.'UserID'] = $userID;
		}		
		if(!empty($userID) && !empty($orderID))
		{
			//$CartItem = new CartItemClass();
			//$cartItemsRS = $CartItem->getCartItems($input);
			//echo '<textarea cols=50 rows=10>';
			//print_r($cartItemsRS);
			//echo '</textarea><br>';
			if(is_array($cartItemsRS))			
			{
				foreach($cartItemsRS as $row)
				{
					$inputItem['ResourceOrderItem'.DTR.'ResourceOrderID']=$orderID;
					$inputItem['ResourceOrderItem'.DTR.'ResourceOrderItemPrice']=$row['CartItemPrice'];
					$inputItem['ResourceOrderItem'.DTR.'ResourceOrderItemDiscountAmount']=$this->getOrderItemDiscountAmount('');
					$inputItem['ResourceOrderItem'.DTR.'ResourceOrderItemWeight']=$row['CartItemWeight'];
					$inputItem['ResourceOrderItem'.DTR.'ResourceOrderItemVolume']=$row['CartItemVolume'];
					$inputItem['ResourceOrderItem'.DTR.'ResourceOrderItemQuantity']=$row['CartItemQuantity'];
					
					foreach($row as $rowFieldName=>$rowFieldValue)
					{
						if($rowFieldName!='UserID' && $rowFieldName!='SessionID' && $rowFieldName!='TimeCreated' && $rowFieldName!='TimeSaved' && $rowFieldName!='CartItemFields'  && $rowFieldName!='CartItemWeight' )
						{
							$inputItem['ResourceOrderItem'.DTR.$rowFieldName] = addslashes($rowFieldValue);
						}
					}
					$whereItem['ResourceOrderItem'] = "ResourceOrderItemID = ''";
					$inputItem['actionMode']='save';					
					$result = $DS->save($inputItem,$whereItem,'insert');	
					$itemID = $result[0]['ResourceOrderItemID'];

					//echo '<textarea cols=50 rows=10>';
					//print_r($inputItem);
					//echo '</textarea><br>';
					
					if(is_array($row['CartItemFields']))
					{
						$inputField['ResourceOrderItemField'.DTR.'ResourceOrderItemID'] = $itemID;
						foreach($row['CartItemFields'] as $fieldCode=>$fieldRow)
						{
							foreach($fieldRow as $fieldRowName=>$fieldRowValue)
							{
								$inputField['ResourceOrderItemField'.DTR.$fieldRowName] = $fieldRowValue;
							}		
							$whereField['ResourceOrderItemField'] = "ResourceOrderItemFieldID = ''";
							$inputField['actionMode']='save';					
							$result = $DS->save($inputField,$whereField,'insert');		
							//echo '<textarea cols=50 rows=10>';
							//print_r($inputField);
							//echo '</textarea><br>';														
						}
					}
				}
			}
			elseif($orderMode=='direct')
			{
				$input['ResourceOrderItem'.DTR.'ResourceOrderID']=$orderID;
				$where['ResourceOrderItem'] = "ResourceOrderItemID = ''";
				$input['actionMode']='save';					
				$result = $DS->save($input,$where,'insert');				
			}
			elseif($orderMode=='directorder' || $orderMode=='enquiry')
			{
				if(!empty($input['ResourceOrderItem'.DTR.'ResourceID']))
				{
					$resourceID = $input['ResourceOrderItem'.DTR.'ResourceID'];
					//get resource info 
					$resourceQuery = "SELECT * FROM Resource WHERE ResourceID='$resourceID'";
					$resourceRS = $DS->query($resourceQuery);
					foreach ($resourceRS[0] as $fieldName=>$fieldValue)
					{
						$input['ResourceOrderItem'.DTR.$fieldName] = addslashes($fieldValue);
					}
					//make price
					$orderItemPrice = $resourceRS[0]['ResourcePrice'];
					$orderItemWeight = $resourceRS[0]['ResourceWeight'];
		
					$input['ResourceOrderItem'.DTR.'ResourceOrderItemPrice'] = $orderItemPrice;
					$input['ResourceOrderItem'.DTR.'ResourceOrderItemWeight'] = $orderItemWeight;
				}
				$input['ResourceOrderItem'.DTR.'ResourceOrderID']=$orderID;
				$where['ResourceOrderItem'] = "ResourceOrderItemID = ''";
				$input['actionMode']='save';					
				$result = $DS->save($input,$where,'insert');				
			}			
		}
		return $result;		
	}	

	function updateOrderTotals($orderID,$input)
	{
		$DS = &$this->_DS;
		if(!empty($orderID))
		{		
			$result = $this->getOrderTotals($input);

			$query = "UPDATE ResourceOrder SET ResourceOrderWeight=".$result['weight'].", ResourceOrderVolume=".$result['volume'].", ResourceOrderAmount=".$result['price'].", ResourceOrderShippingAmount=".$result['shipping'].", ResourceOrderDiscountAmount=".$result['discounts'].", ResourceOrderTaxesAmount=".$result['taxes'].", ResourceOrderTotalAmount=".$result['total']." WHERE ResourceOrderID='$orderID'";
			$DS->query($query);
			//echo $query ;
		}
	}

	function getOrderTotals($input,$orderID='')
	{
		
		$orderMode= $input['orderMode'];
		$DS = &$this->_DS;
		$volume = 0;
		$count = 0;
		$weight = 0;
		$quantity = 0;
		
		if(!empty($orderID))
		{
			//get order from DB
		}
		elseif(!empty($orderMode))
		{
			$quantity = $input['ResourceOrderItem'.DTR.'ResourceOrderItemQuantity'];
			$price = $input['ResourceOrderItem'.DTR.'ResourceOrderItemPrice']*$quantity;
		}		
		else
		{
			//get info from shoping cart
			$CartItem = new CartItemClass();
			$cartItemsRS = $CartItem->getCartItems($input);		
			if(count($cartItemsRS)>0)			
			{	
				foreach($cartItemsRS as $row)
				{
					$price = $price + $row['CartItemPrice']*$row['CartItemQuantity'];
					$weight = $weight + $row['CartItemWeight']*$row['CartItemQuantity'];
					$volume = $volume + $row['CartItemVolume']*$row['CartItemQuantity'];
					$count++;
					$quantity = $quantity + $row['CartItemQuantity'];
					
				}					
			}				
		}

		$result['price'] = $price;
		$result['weight'] = $weight;
		$result['volume'] = $volume;
		$result['positions'] = $count;
		$result['quantity'] = $quantity;
		$result['discounts'] = $this->getOrderTotalDiscounts($result);
		$result['shipping'] = $this->getOrderTotalShippingFee($result);
		$result['taxes'] = $this->getOrderTotalTaxes($result);
		$result['total'] = $result['price'] + $result['shipping'] - $result['discounts'];
		
		//print_r($result);
		return 	$result;
	}

	function getOrderTotalShippingFee($orderInfo)
	{
		return 0;
	}
	
	function getOrderTotalDiscounts($orderInfo)
	{
		return 0;
	}	
	
	function getOrderTotalTaxes($orderInfo)
	{
		$price = $orderInfo['price'];
		$result = $price/1.2;
		return $result;
	}		
		
	function getOrderItemDiscountAmount($input)
	{
		return 0;
	}


    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteResourceOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ResourceOrderClass.deleteResourceOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ResourceOrder'.DTR.'ResourceOrderID'];
		//if(empty($entityID)) {$entityID = $input['ResourceOrderID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceOrderServer.adminResourceOrder');
		//set queries
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT ResourceOrderFieldID FROM ResourceOrderField WHERE ResourceOrderID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['ResourceOrderFieldID'];
			$DS->query("DELETE FROM ResourceOrder WHERE ResourceOrderID='$entityID'");
			$DS->query("DELETE FROM ResourceOrderItem WHERE ResourceOrderID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM ResourceOrderItemField WHERE ResourceOrderItemFieldID='$typeFieldID'");
			}
		}
		$SERVER->setMessage('ResourceOrderClass.deleteResourceOrder.msg.DataDeleted');
		$SERVER->setDebug('ResourceOrderClass.deleteResourceOrder.End','End');		
		return $result;		
	}	
	
	function sendEmailRemind($orderID,$status,$mode='',$template='')
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		
		//mode: default - send to user and admin, user - send only to user, admin - send only to admin
		if(empty($mode)) {$mode='useradmin';}
		if(!empty($orderID))
		{
			$orderRS = $DS->query("SELECT * FROM ResourceOrder WHERE ResourceOrderID='$orderID'");
			$order =$orderRS[0];
			//get order items
			$orderItemsRS = $DS->query("SELECT * FROM ResourceOrderItem WHERE ResourceOrderID='$orderID'");
			$orderItems = $orderItemsRS;
			if($mode=='user')
			{
				if(!empty($template))
				{
					$emailInput['MailTemplate']	= $template;
				}
				else
				{
					$emailInput['MailTemplate']	= $status.'ResourceOrderUser.resource';
				}			
				$emailInput['MailFrom'] = $config['SiteMail'];
				$emailInput['MailFromName'] = $config['SiteName'];
				$emailInput['MailTo']	= $order['ResourceOrderEmail'];
				$emailInput['MailToName']	= $order['ResourceOrderFirstName'].' '.$order['ResourceOrderLastName'];
			}
			else
			{
				if(!empty($template))
				{
					$emailInput['MailTemplate']	= $template;
				}
				else
				{
					$emailInput['MailTemplate']	= $status.'ResourceOrderAdmin.resource';
				}			
				$emailInput['MailTo'] = $config['SiteMail'];
				$emailInput['MailToName'] = $config['SiteName'];
				$emailInput['MailFrom']	= $order['ResourceOrderEmail'];
				$emailInput['MailFromName']	= $order['ResourceOrderFirstName'].' '.$order['ResourceOrderLastName'];
			}
			
			foreach($config as $confVarName=>$confVarValue)
			{
				$emailInput['MailData'][$confVarName] = $confVarValue;
			}
			foreach($order as $variableName=>$variableValue)
			{
				/*
				if(is_array($variableValue))
				{
					$valueStr='';
					foreach($variableValue as $variableName2=>$variableValue2)
					{
						$valueStr .= $variableValue2.', ';
					}
					if(!empty($valueStr))
					{
						$variableValue = $valueStr;
					}
				}
				*/
				if(!empty($variableName))
				{
					$emailInput['MailData'][$variableName] = $variableValue;
				}
			}
			//print_r($orderItemsRS);
			$emailInput['MailData']['ResourceOrderItems'] = $orderItems;
			$SERVER->callService('sendMail','mailServer',$emailInput);
			
			if($mode=='useradmin')
			{
				$emailInput['MailTemplate']	= $status.'ResourceOrderUser.resource';
				$emailInput['MailFrom'] = $config['SiteMail'];
				$emailInput['MailFromName'] = $config['SiteName'];
				$emailInput['MailTo']	= $order['ResourceOrderEmail'];
				$emailInput['MailToName']	= $order['ResourceOrderFirstName'].' '.$order['ResourceOrderLastName'];
				$SERVER->callService('sendMail','mailServer',$emailInput);
			}
		
		}			
	}
	
} // end of ResourceOrderServer
?>
<?php
//XCMSPro: Web Service entity class
class PropertyOrderClass
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
	function PropertyOrderClass()
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
	function getPropertyOrders($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyOrderClass.getPropertyOrders.Start','Start');
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
		//$filter = $DS->getAccessFilter($input,'PropertyOrderServer.adminPropertyOrder');
		if(!empty($searchWord))
		{
			$filter .= " AND ( PropertyOrderFirstName LIKE '{ls}%$searchWord%{le}' OR  PropertyOrderFirstName LIKE '%$searchWord%' OR  PropertyOrderLastName LIKE '{ls}%$searchWord%{le}' OR  PropertyOrderLastName LIKE '%$searchWord%' OR  PropertyOrderEmail LIKE '{ls}%$searchWord%{le}' OR  PropertyOrderEmail LIKE '%$searchWord%')";
			$filter .= " AND ( PropertyOrderID LIKE '{ls}%$searchWord%{le}' OR  PropertyOrderID LIKE '%$searchWord%')";
		}
		
		if(!empty($input['PropertyOrderStatus']))
		{
			$PropertyOrderStatus = $input['PropertyOrderStatus'];
			$filter .= " AND PropertyOrderStatus = '$PropertyOrderStatus' ";
		}
		
		if(!empty($input['PropertyOrderPaymentStatus']))
		{
			$PropertyOrderPaymentStatus = $input['PropertyOrderPaymentStatus'];
			$filter .= " AND PropertyOrderPaymentStatus = '$PropertyOrderPaymentStatus' ";
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
		//$query = "SELECT * FROM PropertyOrder WHERE PropertyOrderID>0 $filter ORDER BY PropertyOrderPosition";
		if($config['UseMutliplePropertiesPerOrder']=='N')
		{
			$query = "SELECT * FROM PropertyOrder WHERE PropertyOrderID>0 $filter ORDER BY TimeCreated DESC".$limit;
		}
		else
		{
			if(empty($limit))
			{
				$pages = $DS->getPages('PropertyOrder, PropertyOrderItem',"PropertyOrder.PropertyOrderID=PropertyOrderItem.PropertyOrderID $filter",array('ItemsPerPage'=>$itemsPerPage));
				$limit = ' LIMIT '.$pages['begin'].','.$pages['step'];
			}
			
			$query = "SELECT * FROM PropertyOrder, PropertyOrderItem WHERE PropertyOrder.PropertyOrderID=PropertyOrderItem.PropertyOrderID $filter ORDER BY PropertyOrder.TimeCreated DESC".$limit;
		}
		//get the content
		//echo $query;
		$result['result'] = $DS->query($query); 
		$result['pages'] = $pages['pages']; 
		$SERVER->setDebug('PropertyOrderClass.getPropertyOrders.End','End');
		return $result;
	}	
	
	function getPropertyOrderFields($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyOrderClass.getPropertyOrderFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['PropertyOrder'.DTR.'PropertyOrderID'];
		if(empty($entityID)) {$entityID = $input['PropertyOrderID'];}
		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['PropertyOrder'];}
		if(empty($entityAlias)) {$entityAlias = $input['PropertyOrderAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PropertyOrder'.DTR.'PropertyOrderAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$PropertyOrderIDRS = $DS->query("SELECT PropertyOrderID FROM PropertyOrder WHERE PropertyOrderAlias='$entityAlias'");
			$entityID = $PropertyOrderIDRS[0]['PropertyOrderID'];
		}
		//$filter = $DS->getAccessFilter($input,'PropertyOrderServer.adminPropertyOrder');
		if(!empty($entityID))		
		{
			$filter .= " AND PropertyOrderID='$entityID'";
		}
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM PropertyOrderField WHERE PropertyOrderFieldID>0 $filter ORDER BY PropertyOrderFieldPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('PropertyOrderClass.getPropertyOrderFields.End','End');
		return $result;
	}	
	
	function getPropertyOrderOptions($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyOrderClass.getPropertyOrderFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['PropertyOrderField'.DTR.'PropertyOrderFieldID'];
		if(empty($entityID)) {$entityID = $input['PropertyOrderFieldID'];}
		
		$entityAlias = $input['PropertyField'];		
		if(empty($entityAlias)) {$entityAlias = $input['PropertyOrderFieldAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['PropertyOrderField'.DTR.'PropertyOrderFieldAlias'];}
		
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$PropertyOrderIDRS = $DS->query("SELECT PropertyOrderFieldID FROM PropertyOrderField WHERE PropertyOrderFieldAlias='$entityAlias'");
			$entityID = $PropertyOrderIDRS[0]['PropertyOrderFieldID'];
		}
		//$filter = $DS->getAccessFilter($input,'PropertyOrderServer.adminPropertyOrder');
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM PropertyOrderOption WHERE PropertyOrderFieldID='$entityID' $filter ORDER BY PropertyOrderOptionPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('PropertyOrderClass.getPropertyOrderFields.End','End');
		return $result;
	}	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getPropertyOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyOrderClass.getPropertyOrder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['PropertyOrder'.DTR.'PropertyOrderID'];
		if(empty($entityID)) {$entityID = $input['PropertyOrderID'];}
		if(empty($entityID)) {$entityID = $input['OrderID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['PropertyOrder'];}
		if(empty($entityAlias)) {$entityAlias = $input['PropertyOrderAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PropertyOrder'.DTR.'PropertyOrderAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyOrderServer.adminPropertyOrder');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " PropertyOrderAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " PropertyOrderID='$entityID' ";
		}
		$query = "SELECT * FROM PropertyOrder WHERE $filter"; 
		//echo $query;
		//get the content
		
		$result = $DS->query($query);	

		$SERVER->setDebug('PropertyOrderClass.getPropertyOrder.End','End');		
		return $result;		
	}
	
	function getPropertyOrderField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyOrderClass.getPropertyOrderField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['PropertyOrderField'.DTR.'PropertyOrderFieldID'];
		if(empty($entityID)) {$entityID = $input['PropertyOrderFieldID'];}

		$entityAlias = $input['PropertyOrderField'];
		if(empty($entityAlias)) {$entityAlias = $input['PropertyOrderFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PropertyOrderField'.DTR.'PropertyOrderFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyOrderServer.adminPropertyOrder');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " PropertyOrderFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " PropertyOrderFieldID='$entityID' ";
		}
		$query = "SELECT * FROM PropertyOrderField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('PropertyOrderClass.getPropertyOrderField.End','End');		
		return $result;		
	}

	function getPropertyOrderOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyOrderClass.getPropertyOrderOption.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['PropertyOrderOption'.DTR.'PropertyOrderOptionID'];
		if(empty($entityID)) {$entityID = $input['PropertyOrderOptionID'];}

		$entityAlias = $input['PropertyOrderOption'];
		if(empty($entityAlias)) {$entityAlias = $input['PropertyOrderOptionAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PropertyOrderOption'.DTR.'PropertyOrderOptionAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyOrderServer.adminPropertyOrder');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " PropertyOrderOptionAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " PropertyOrderOptionID='$entityID' ";
		}
		$query = "SELECT * FROM PropertyOrderOption WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('PropertyOrderClass.getPropertyOrderOption.End','End');		
		return $result;		
	}
	
	function getPropertyOrderItem($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$orderID = $input['PropertyOrderID'];
		if(empty($orderID)) $orderID = $input['OrderID'];
		
		//set client side variables
		//set queries
		if(!empty($orderID))
		{
			$filter .= " AND PropertyOrderID='$orderID' ";
		}
			
		$query = "SELECT * FROM PropertyOrderItem WHERE  PropertyOrderItemID>0 $filter"; 
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
	
	function setPropertyOrders($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyOrderClass.setPropertyOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		foreach($input['PropertyOrder'.DTR.'PropertyOrderPaymentStatus'] as $id=>$value)
		{
			$PropertyOrderPaymentStatus = $value;
			$PropertyOrderStatus = $input['PropertyOrder'.DTR.'PropertyOrderStatus'][$id];
			$entityID = $input['PropertyOrderID'][$id];
			
			if(!empty($entityID))
			{
				$oldRS = $DS->query("SELECT PropertyOrderPaymentStatus, PropertyOrderStatus FROM PropertyOrder WHERE  PropertyOrderID = '$entityID'");
				$oldPaymentStatus = $oldRS[0]['PropertyOrderPaymentStatus'];
				$oldOrderStatus = $oldRS[0]['PropertyOrderStatus'];
				if(!empty($oldPaymentStatus) && !empty($PropertyOrderPaymentStatus) && $oldPaymentStatus!=$PropertyOrderPaymentStatus)
				{
					$this->sendEmailRemind($entityID,$PropertyOrderPaymentStatus);
				}
				if(!empty($oldOrderStatus) && !empty($PropertyOrderStatus) && $oldOrderStatus!=$PropertyOrderStatus)
				{
					$this->sendEmailRemind($entityID,$PropertyOrderStatus);
				}				
				$query = "UPDATE  PropertyOrder SET PropertyOrderPaymentStatus = '$PropertyOrderPaymentStatus', PropertyOrderStatus ='$PropertyOrderStatus' WHERE PropertyOrderID = '$entityID'";
				$DS->query($query);
			}
			/*$result = $DS->save($inValue,$where);*/
		}
	}
	
	function updatePropertyOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyOrderClass.setPropertyOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//print_r($input);
		$entityID = $input['PropertyOrderID'];
		$PropertyOrderPaymentStatus = $input['PropertyOrder'.DTR.'PropertyOrderPaymentStatus'];
		$PropertyOrderStatus = $input['PropertyOrder'.DTR.'PropertyOrderStatus'];
		
		$query = "UPDATE  PropertyOrder SET PropertyOrderPaymentStatus = '$PropertyOrderPaymentStatus', PropertyOrderStatus ='$PropertyOrderStatus' WHERE PropertyOrderID = '$entityID'";
		$DS->query($query);
		
		return $result;
	}
	
	function setPropertyOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyOrderClass.setPropertyOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['PropertyOrder'.DTR.'PropertyOrderID'];
		if(empty($entityID)) {$entityID = $input['PropertyOrderID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyOrderServer.adminPropertyOrder');
		//set queries	
		//if(is_array($input['PropertyOrder'.DTR.'AccessGroups'])) {$input['PropertyOrder'.DTR.'AccessGroups'] = '|'. implode("|",$input['PropertyOrder'.DTR.'AccessGroups']).'|'; }
		$where['PropertyOrder'] = "PropertyOrderID = '".$entityID."'".$filter;

		if(!empty($input['PropertyOrder'.DTR.'PropertyOrderAlias']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT PropertyOrderAlias FROM PropertyOrder WHERE PropertyOrderAlias='".$input['PropertyOrder'.DTR.'PropertyOrderAlias']."'");
		}
		if(count($checkRS)<1 && !empty($input['PropertyOrder'.DTR.'PropertyOrderAlias']) && !empty($input['PropertyOrder'.DTR.'PropertyOrderName']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);

			$oldRS = $DS->query("SELECT PropertyOrderPaymentStatus, PropertyOrderStatus WHERE  PropertyOrderID = '$entityID'");
			$oldPaymentStatus = $oldRS[0]['PropertyOrderPaymentStatus'];
			$oldOrderStatus = $oldRS[0]['PropertyOrderStatus'];
			if(!empty($oldPaymentStatus) && !empty($input['PropertyOrder'.DTR.'PropertyOrderPaymentStatus']) && $oldPaymentStatus!=$input['PropertyOrder'.DTR.'PropertyOrderPaymentStatus'])
			{
				$this->sendEmailRemind($entityID,$input['PropertyOrder'.DTR.'PropertyOrderPaymentStatus']);
			}
			if(!empty($oldOrderStatus) && !empty($input['PropertyOrder'.DTR.'PropertyOrderStatus']) && $oldOrderStatus!=$input['PropertyOrder'.DTR.'PropertyOrderStatus'])
			{
				$this->sendEmailRemind($entityID,$input['PropertyOrder'.DTR.'PropertyOrderStatus']);
			}				
		}
		else
		{
			if(!empty($input['PropertyOrder'.DTR.'PropertyOrderAlias']))
			{
				$SERVER->setMessage('PropertyOrderClass.setPropertyOrder.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('PropertyOrderClass.setPropertyOrder.msg.DataSaved');
		}
		$SERVER->setDebug('PropertyOrderClass.setPropertyOrder.End','End');		
		return $result;		
	}
	
	function addPropertyOrder($input)
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
			$userRS = $DS->query("SELECT UserID FROM User WHERE Email='".$input['PropertyOrder'.DTR.'PropertyOrderEmail']."'");
			$userID = $userRS[0]['UserID'];
			$input['PropertyOrder'.DTR.'UserID'] = $userID;
		}
		
		$CartItem = new CartItemClass();
		$cartItemsRS = $CartItem->getCartItems($input);
		if(count($cartItemsRS)>0 || $orderMode=='direct' || $orderMode=='enquiry' || $orderMode=='directorder')			
		{		
			if(!empty($userID))
			{
				if(empty($input['PropertyOrder'.DTR.'PropertyOrderStatus'])) {$input['PropertyOrder'.DTR.'PropertyOrderStatus']='new';}
				if(empty($input['PropertyOrder'.DTR.'PropertyOrderPaymentStatus'])) {$input['PropertyOrder'.DTR.'PropertyOrderPaymentStatus']='notpaid';}
				if(empty($input['PropertyOrder'.DTR.'PropertyOrderType'])) {$input['PropertyOrder'.DTR.'PropertyOrderType']='order';}
				
				$where['PropertyOrder'] = "PropertyOrderID = ''";
				//block doubled insert
				$blockTime = time()-30;//30 seconds limit
				$endTime = $SERVER->getNow($blockTime);
				$checkRS=$DS->query("SELECT PropertyOrderID FROM PropertyOrder WHERE UserID='$userID' AND TimeCreated > '$endTime'");
				if(count($checkRS)<1 && !empty($input['PropertyOrder'.DTR.'PropertyOrderFirstName']))
				{		
					//generate property order index
					$maxIndexRS = $DS->query("SELECT PropertyOrderIndex FROM PropertyOrder WHERE OwnerID='$ownerID' ORDER BY PropertyOrderIndex DESC LIMIT 0,1 ");
					$input['PropertyOrder'.DTR.'PropertyOrderIndex'] = $maxIndexRS[0]['PropertyOrderIndex'] + 1;
				
					$input['actionMode']='save';					
					$result = $DS->save($input,$where,'insert');	
					$input['PropertyOrderID'] = $result[0]['PropertyOrderID'];
					
					$this->addPropertyOrderItem($input,$cartItemsRS);
					$this->updateOrderTotals($input['PropertyOrderID'],$input);
					$this->sendEmailRemind($input['PropertyOrderID'],'new');
				}
				else
				{
					$SERVER->setMessage('property.PropertyOrderClass.setPropertyOrder.err.AlreadyExists');
				}
				if(count($result)>0)	
				{
					$SERVER->setMessage('property.PropertyOrderClass.setPropertyOrder.msg.DataSaved');
				}
				if($orderMode!='direct' && $orderMode!='directorder' && $orderMode!='enquiry')
				{
					$CartItem->emptyCart($input);
				}
			}
		}
		
		$result['PropertyOrderID'] = $input['PropertyOrderID'];
		return $result;		
	}	

	function addPropertyOrderItem($input,$cartItemsRS)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$orderID = $input['PropertyOrderID'];
		$orderMode = $input['orderMode'];
		//set client side variables
		//set queries	
		if(empty($userID))
		{
			//try to get user my his email
			$userRS = $DS->query("SELECT UserID FROM User WHERE Email='".$input['PropertyOrder'.DTR.'PropertyOrderEmail']."'");
			$userID = $userRS[0]['UserID'];
			$input['PropertyOrderItem'.DTR.'UserID'] = $userID;
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
					$inputItem['PropertyOrderItem'.DTR.'PropertyOrderID']=$orderID;
					$inputItem['PropertyOrderItem'.DTR.'PropertyOrderItemPrice']=$row['CartItemPrice'];
					$inputItem['PropertyOrderItem'.DTR.'PropertyOrderItemDiscountAmount']=$this->getOrderItemDiscountAmount('');
					$inputItem['PropertyOrderItem'.DTR.'PropertyOrderItemQuantity']=$row['CartItemQuantity'];
					
					foreach($row as $rowFieldName=>$rowFieldValue)
					{
						if($rowFieldName!='UserID' && $rowFieldName!='SessionID' && $rowFieldName!='TimeCreated' && $rowFieldName!='TimeSaved' && $rowFieldName!='CartItemFields'  && $rowFieldName!='CartItemWeight' )
						{
							$inputItem['PropertyOrderItem'.DTR.$rowFieldName] = addslashes($rowFieldValue);
						}
					}
					$whereItem['PropertyOrderItem'] = "PropertyOrderItemID = ''";
					$inputItem['actionMode']='save';					
					$result = $DS->save($inputItem,$whereItem,'insert');	
					$itemID = $result[0]['PropertyOrderItemID'];

					//echo '<textarea cols=50 rows=10>';
					//print_r($inputItem);
					//echo '</textarea><br>';
					
					if(is_array($row['CartItemFields']))
					{
						$inputField['PropertyOrderItemField'.DTR.'PropertyOrderItemID'] = $itemID;
						foreach($row['CartItemFields'] as $fieldCode=>$fieldRow)
						{
							foreach($fieldRow as $fieldRowName=>$fieldRowValue)
							{
								$inputField['PropertyOrderItemField'.DTR.$fieldRowName] = $fieldRowValue;
							}		
							$whereField['PropertyOrderItemField'] = "PropertyOrderItemFieldID = ''";
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
				$input['PropertyOrderItem'.DTR.'PropertyOrderID']=$orderID;
				$where['PropertyOrderItem'] = "PropertyOrderItemID = ''";
				$input['actionMode']='save';					
				$result = $DS->save($input,$where,'insert');				
			}
			elseif($orderMode=='directorder' || $orderMode=='enquiry')
			{
				if(!empty($input['PropertyOrderItem'.DTR.'PropertyID']))
				{
					$propertyID = $input['PropertyOrderItem'.DTR.'PropertyID'];
					//get property info 
					$propertyQuery = "SELECT * FROM Property WHERE PropertyID='$propertyID'";
					$propertyRS = $DS->query($propertyQuery);
					foreach ($propertyRS[0] as $fieldName=>$fieldValue)
					{
						$input['PropertyOrderItem'.DTR.$fieldName] = addslashes($fieldValue);
					}
					//make price
					$orderItemPrice = $propertyRS[0]['PropertyPrice'];
		
					$input['PropertyOrderItem'.DTR.'PropertyOrderItemPrice'] = $orderItemPrice;
				}
				$input['PropertyOrderItem'.DTR.'PropertyOrderID']=$orderID;
				$where['PropertyOrderItem'] = "PropertyOrderItemID = ''";
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
			$result = $this->getOrderTotals($input,$orderID);

			$query = "UPDATE PropertyOrder SET PropertyOrderAmount='".$result['price']."', PropertyOrderDiscountAmount='".$result['discounts']."', PropertyOrderTaxesAmount='".$result['taxes']."', PropertyOrderTotalAmount=".$result['total']." WHERE PropertyOrderID='$orderID'";
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
			if(!empty($orderMode))
			{
				$itmesRS = $DS->query("SELECT PropertyOrderItemQuantity, PropertyOrderItemPrice FROM PropertyOrderItem WHERE PropertyOrderID='$orderID'");
				if(is_array($itmesRS))
				{
					foreach ($itmesRS as $row)
					{
						$quantityCurrent = $row['PropertyOrderItemQuantity'];
						if(empty($quantityCurrent)) {$quantityCurrent=1;}
						$quantity = $quantity+$quantityCurrent;
						$price = $price + $row['PropertyOrderItemPrice']*$quantityCurrent;					
					}
				}
	
			}
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
		$result['positions'] = $count;
		$result['quantity'] = $quantity;
		$result['discounts'] = $this->getOrderTotalDiscounts($result);
		$result['taxes'] = $this->getOrderTotalTaxes($result);
		$result['total'] = $result['price'] - $result['discounts'];
		
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
	function deletePropertyOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PropertyOrderClass.deletePropertyOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['PropertyOrder'.DTR.'PropertyOrderID'];
		//if(empty($entityID)) {$entityID = $input['PropertyOrderID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PropertyOrderServer.adminPropertyOrder');
		//set queries
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT PropertyOrderFieldID FROM PropertyOrderField WHERE PropertyOrderID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['PropertyOrderFieldID'];
			$DS->query("DELETE FROM PropertyOrder WHERE PropertyOrderID='$entityID'");
			$DS->query("DELETE FROM PropertyOrderItem WHERE PropertyOrderID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM PropertyOrderItemField WHERE PropertyOrderItemFieldID='$typeFieldID'");
			}
		}
		$SERVER->setMessage('PropertyOrderClass.deletePropertyOrder.msg.DataDeleted');
		$SERVER->setDebug('PropertyOrderClass.deletePropertyOrder.End','End');		
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
			$orderRS = $DS->query("SELECT * FROM PropertyOrder WHERE PropertyOrderID='$orderID'");
			$order =$orderRS[0];
			//get order items
			$orderItemsRS = $DS->query("SELECT * FROM PropertyOrderItem WHERE PropertyOrderID='$orderID'");
			$orderItems = $orderItemsRS;
			if($mode=='user')
			{
				if(!empty($template))
				{
					$emailInput['MailTemplate']	= $template;
				}
				else
				{
					$emailInput['MailTemplate']	= $status.'PropertyOrderUser.property';
				}			
				$emailInput['MailFrom'] = $config['SiteMail'];
				$emailInput['MailFromName'] = $config['SiteName'];
				$emailInput['MailTo']	= $order['PropertyOrderEmail'];
				$emailInput['MailToName']	= $order['PropertyOrderFirstName'].' '.$order['PropertyOrderLastName'];
			}
			else
			{
				if(!empty($template))
				{
					$emailInput['MailTemplate']	= $template;
				}
				else
				{
					$emailInput['MailTemplate']	= $status.'PropertyOrderAdmin.property';
				}			
				$emailInput['MailTo'] = $config['SiteMail'];
				$emailInput['MailToName'] = $config['SiteName'];
				$emailInput['MailFrom']	= $order['PropertyOrderEmail'];
				$emailInput['MailFromName']	= $order['PropertyOrderFirstName'].' '.$order['PropertyOrderLastName'];
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
			$emailInput['MailData']['PropertyOrderItems'] = $orderItems;
			$SERVER->callService('sendMail','mailServer',$emailInput);
			
			if($mode=='useradmin')
			{
				$emailInput['MailTemplate']	= $status.'PropertyOrderUser.property';
				$emailInput['MailFrom'] = $config['SiteMail'];
				$emailInput['MailFromName'] = $config['SiteName'];
				$emailInput['MailTo']	= $order['PropertyOrderEmail'];
				$emailInput['MailToName']	= $order['PropertyOrderFirstName'].' '.$order['PropertyOrderLastName'];
				$SERVER->callService('sendMail','mailServer',$emailInput);
			}
		
		}			
	}
	
} // end of PropertyOrderServer
?>
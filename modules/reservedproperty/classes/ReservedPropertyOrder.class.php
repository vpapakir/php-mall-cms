<?php
//XCMSPro: Web Service entity class
class ReservedPropertyOrderClass
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
	function ReservedPropertyOrderClass()
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
	function getReservedPropertyOrders($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyOrderClass.getReservedPropertyOrders.Start','Start');
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
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyOrderServer.adminReservedPropertyOrder');
		if(!empty($searchWord))
		{
			$filter .= " AND ( ReservedPropertyOrderFirstName LIKE '{ls}%$searchWord%{le}' OR  ReservedPropertyOrderFirstName LIKE '%$searchWord%' OR  ReservedPropertyOrderLastName LIKE '{ls}%$searchWord%{le}' OR  ReservedPropertyOrderLastName LIKE '%$searchWord%' OR  ReservedPropertyOrderEmail LIKE '{ls}%$searchWord%{le}' OR  ReservedPropertyOrderEmail LIKE '%$searchWord%')";
			$filter .= " AND ( ReservedPropertyOrderID LIKE '{ls}%$searchWord%{le}' OR  ReservedPropertyOrderID LIKE '%$searchWord%')";
		}
		
		if(!empty($input['ReservedPropertyOrderStatus']))
		{
			$ReservedPropertyOrderStatus = $input['ReservedPropertyOrderStatus'];
			$filter .= " AND ReservedPropertyOrder.ReservedPropertyOrderStatus = '$ReservedPropertyOrderStatus' ";
		}
		
		if(!empty($input['ReservedPropertyOrderPaymentStatus']))
		{
			$ReservedPropertyOrderPaymentStatus = $input['ReservedPropertyOrderPaymentStatus'];
			$filter .= " AND ReservedPropertyOrder.ReservedPropertyOrderPaymentStatus = '$ReservedPropertyOrderPaymentStatus' ";
		}
		
		if(($userID != 'admin' && $userID != 'root') || $filterUser=='User')
		{
			$filter .= " AND ReservedPropertyOrder.UserID = '$userID' ";
		}
		
		if($filterMode=='last')
		{
			$limit = " LIMIT 0,10";
		}		
		
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		//$query = "SELECT * FROM ReservedPropertyOrder WHERE ReservedPropertyOrderID>0 $filter ORDER BY ReservedPropertyOrderPosition";
		if($config['UseMutlipleReservedPropertiesPerOrder']=='Y')
		{
			$query = "SELECT * FROM ReservedPropertyOrder WHERE ReservedPropertyOrderID>0 $filter ORDER BY TimeCreated DESC".$limit;
		}
		else
		{
			if(empty($limit))
			{
				$pages = $DS->getPages('ReservedPropertyOrder, ReservedPropertyOrderItem',"ReservedPropertyOrder.ReservedPropertyOrderID=ReservedPropertyOrderItem.ReservedPropertyOrderID $filter",array('ItemsPerPage'=>$itemsPerPage));
				$limit = ' LIMIT '.$pages['begin'].','.$pages['step'];
			}
			
			$query = "SELECT * FROM ReservedPropertyOrder, ReservedPropertyOrderItem WHERE ReservedPropertyOrder.ReservedPropertyOrderID=ReservedPropertyOrderItem.ReservedPropertyOrderID $filter ORDER BY ReservedPropertyOrder.TimeCreated DESC".$limit;
		}
		//get the content
		$result['result'] = $DS->query($query); 
		$result['pages'] = $pages['pages']; 
		$SERVER->setDebug('ReservedPropertyOrderClass.getReservedPropertyOrders.End','End');
		return $result;
	}	
	
	function getReservedPropertyOrderFields($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyOrderClass.getReservedPropertyOrderFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyOrderID'];}
		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyOrder'];}
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyOrderAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$ReservedPropertyOrderIDRS = $DS->query("SELECT ReservedPropertyOrderID FROM ReservedPropertyOrder WHERE ReservedPropertyOrderAlias='$entityAlias'");
			$entityID = $ReservedPropertyOrderIDRS[0]['ReservedPropertyOrderID'];
		}
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyOrderServer.adminReservedPropertyOrder');
		if(!empty($entityID))		
		{
			$filter .= " AND ReservedPropertyOrderID='$entityID'";
		}
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM ReservedPropertyOrderField WHERE ReservedPropertyOrderFieldID>0 $filter ORDER BY ReservedPropertyOrderFieldPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ReservedPropertyOrderClass.getReservedPropertyOrderFields.End','End');
		return $result;
	}	
	
	function getReservedPropertyOrderOptions($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyOrderClass.getReservedPropertyOrderFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservedPropertyOrderField'.DTR.'ReservedPropertyOrderFieldID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyOrderFieldID'];}
		
		$entityAlias = $input['ReservedPropertyField'];		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyOrderFieldAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyOrderField'.DTR.'ReservedPropertyOrderFieldAlias'];}
		
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$ReservedPropertyOrderIDRS = $DS->query("SELECT ReservedPropertyOrderFieldID FROM ReservedPropertyOrderField WHERE ReservedPropertyOrderFieldAlias='$entityAlias'");
			$entityID = $ReservedPropertyOrderIDRS[0]['ReservedPropertyOrderFieldID'];
		}
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyOrderServer.adminReservedPropertyOrder');
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM ReservedPropertyOrderOption WHERE ReservedPropertyOrderFieldID='$entityID' $filter ORDER BY ReservedPropertyOrderOptionPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ReservedPropertyOrderClass.getReservedPropertyOrderFields.End','End');
		return $result;
	}	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getReservedPropertyOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyOrderClass.getReservedPropertyOrder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyOrderID'];}
		if(empty($entityID)) {$entityID = $input['OrderID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyOrder'];}
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyOrderAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyOrderServer.adminReservedPropertyOrder');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ReservedPropertyOrderAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ReservedPropertyOrderID='$entityID' ";
		}
		$query = "SELECT * FROM ReservedPropertyOrder WHERE $filter"; 
		//echo $query;
		//get the content
		
		$result = $DS->query($query);	

		$SERVER->setDebug('ReservedPropertyOrderClass.getReservedPropertyOrder.End','End');		
		return $result;		
	}
	
	function getReservedPropertyOrderField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyOrderClass.getReservedPropertyOrderField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ReservedPropertyOrderField'.DTR.'ReservedPropertyOrderFieldID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyOrderFieldID'];}

		$entityAlias = $input['ReservedPropertyOrderField'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyOrderFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyOrderField'.DTR.'ReservedPropertyOrderFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyOrderServer.adminReservedPropertyOrder');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ReservedPropertyOrderFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ReservedPropertyOrderFieldID='$entityID' ";
		}
		$query = "SELECT * FROM ReservedPropertyOrderField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('ReservedPropertyOrderClass.getReservedPropertyOrderField.End','End');		
		return $result;		
	}

	function getReservedPropertyOrderOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyOrderClass.getReservedPropertyOrderOption.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ReservedPropertyOrderOption'.DTR.'ReservedPropertyOrderOptionID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyOrderOptionID'];}

		$entityAlias = $input['ReservedPropertyOrderOption'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyOrderOptionAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservedPropertyOrderOption'.DTR.'ReservedPropertyOrderOptionAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyOrderServer.adminReservedPropertyOrder');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " ReservedPropertyOrderOptionAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " ReservedPropertyOrderOptionID='$entityID' ";
		}
		$query = "SELECT * FROM ReservedPropertyOrderOption WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('ReservedPropertyOrderClass.getReservedPropertyOrderOption.End','End');		
		return $result;		
	}
	
	function getReservedPropertyOrderItem($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$orderID = $input['ReservedPropertyOrderID'];
		if(empty($orderID)) $orderID = $input['OrderID'];
		
		//set client side variables
		//set queries
		if(!empty($orderID))
		{
			$filter .= " AND ReservedPropertyOrderID='$orderID' ";
		}
			
		$query = "SELECT * FROM ReservedPropertyOrderItem WHERE  ReservedPropertyOrderItemID>0 $filter"; 
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
	
	function setReservedPropertyOrders($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyOrderClass.setReservedPropertyOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		foreach($input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderPaymentStatus'] as $id=>$value)
		{
			$ReservedPropertyOrderPaymentStatus = $value;
			$ReservedPropertyOrderStatus = $input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderStatus'][$id];
			$entityID = $input['ReservedPropertyOrderID'][$id];
			
			if(!empty($entityID))
			{
				$oldRS = $DS->query("SELECT ReservedPropertyOrderPaymentStatus, ReservedPropertyOrderStatus FROM ReservedPropertyOrder WHERE  ReservedPropertyOrderID = '$entityID'");
				$oldPaymentStatus = $oldRS[0]['ReservedPropertyOrderPaymentStatus'];
				$oldOrderStatus = $oldRS[0]['ReservedPropertyOrderStatus'];
				if(!empty($oldPaymentStatus) && !empty($ReservedPropertyOrderPaymentStatus) && $oldPaymentStatus!=$ReservedPropertyOrderPaymentStatus)
				{
					$this->sendEmailRemind($entityID,$ReservedPropertyOrderPaymentStatus);
				}
				if(!empty($oldOrderStatus) && !empty($ReservedPropertyOrderStatus) && $oldOrderStatus!=$ReservedPropertyOrderStatus)
				{
					$this->sendEmailRemind($entityID,$ReservedPropertyOrderStatus);
				}				
				$query = "UPDATE  ReservedPropertyOrder SET ReservedPropertyOrderPaymentStatus = '$ReservedPropertyOrderPaymentStatus', ReservedPropertyOrderStatus ='$ReservedPropertyOrderStatus' WHERE ReservedPropertyOrderID = '$entityID'";
				$DS->query($query);
			}
			/*$result = $DS->save($inValue,$where);*/
		}
	}
	
	function updateReservedPropertyOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyOrderClass.setReservedPropertyOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//print_r($input);
		$entityID = $input['ReservedPropertyOrderID'];
		$ReservedPropertyOrderPaymentStatus = $input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderPaymentStatus'];
		$ReservedPropertyOrderStatus = $input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderStatus'];
		
		$query = "UPDATE  ReservedPropertyOrder SET ReservedPropertyOrderPaymentStatus = '$ReservedPropertyOrderPaymentStatus', ReservedPropertyOrderStatus ='$ReservedPropertyOrderStatus' WHERE ReservedPropertyOrderID = '$entityID'";
		$DS->query($query);
		
		return $result;
	}
	
	function setReservedPropertyOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyOrderClass.setReservedPropertyOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderID'];
		if(empty($entityID)) {$entityID = $input['ReservedPropertyOrderID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyOrderServer.adminReservedPropertyOrder');
		//set queries	
		//if(is_array($input['ReservedPropertyOrder'.DTR.'AccessGroups'])) {$input['ReservedPropertyOrder'.DTR.'AccessGroups'] = '|'. implode("|",$input['ReservedPropertyOrder'.DTR.'AccessGroups']).'|'; }
		$where['ReservedPropertyOrder'] = "ReservedPropertyOrderID = '".$entityID."'".$filter;

		if(!empty($input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderAlias']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT ReservedPropertyOrderAlias FROM ReservedPropertyOrder WHERE ReservedPropertyOrderAlias='".$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderAlias']."'");
		}
		if(count($checkRS)<1 && !empty($input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderAlias']) && !empty($input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderName']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);

			$oldRS = $DS->query("SELECT ReservedPropertyOrderPaymentStatus, ReservedPropertyOrderStatus WHERE  ReservedPropertyOrderID = '$entityID'");
			$oldPaymentStatus = $oldRS[0]['ReservedPropertyOrderPaymentStatus'];
			$oldOrderStatus = $oldRS[0]['ReservedPropertyOrderStatus'];
			if(!empty($oldPaymentStatus) && !empty($input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderPaymentStatus']) && $oldPaymentStatus!=$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderPaymentStatus'])
			{
				$this->sendEmailRemind($entityID,$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderPaymentStatus']);
			}
			if(!empty($oldOrderStatus) && !empty($input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderStatus']) && $oldOrderStatus!=$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderStatus'])
			{
				$this->sendEmailRemind($entityID,$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderStatus']);
			}				
		}
		else
		{
			if(!empty($input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderAlias']))
			{
				$SERVER->setMessage('ReservedPropertyOrderClass.setReservedPropertyOrder.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ReservedPropertyOrderClass.setReservedPropertyOrder.msg.DataSaved');
		}
		$SERVER->setDebug('ReservedPropertyOrderClass.setReservedPropertyOrder.End','End');		
		return $result;		
	}
	
	function addReservedPropertyOrder($input)
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
			$userRS = $DS->query("SELECT UserID FROM User WHERE Email='".$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderEmail']."'");
			$userID = $userRS[0]['UserID'];
			$input['ReservedPropertyOrder'.DTR.'UserID'] = $userID;
		}
		
		//$CartItem = new CartItemClass();
		//$cartItemsRS = $CartItem->getCartItems($input);
		if(count($cartItemsRS)>0 || $orderMode=='direct' || $orderMode=='enquiry' || $orderMode=='directorder')			
		{		
			if(!empty($userID))
			{
				if(empty($input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderStatus'])) {$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderStatus']='new';}
				if(empty($input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderPaymentStatus'])) {$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderPaymentStatus']='notpaid';}
				if(empty($input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderType'])) {$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderType']='order';}
				
				$where['ReservedPropertyOrder'] = "ReservedPropertyOrderID = ''";
				//block doubled insert
				$blockTime = time()-30;//30 seconds limit
				$endTime = $SERVER->getNow($blockTime);
				$checkRS=$DS->query("SELECT ReservedPropertyOrderID FROM ReservedPropertyOrder WHERE UserID='$userID' AND TimeCreated > '$endTime'");
				if(count($checkRS)<1 && !empty($input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderFirstName']))
				{		
					//generate reservedProperty order index
					$maxIndexRS = $DS->query("SELECT ReservedPropertyOrderIndex FROM ReservedPropertyOrder WHERE OwnerID='$ownerID' ORDER BY ReservedPropertyOrderIndex DESC LIMIT 0,1 ");
					$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderIndex'] = $maxIndexRS[0]['ReservedPropertyOrderIndex'] + 1;
				
					$input['actionMode']='save';					
					$result = $DS->save($input,$where,'insert');	
					$input['ReservedPropertyOrderID'] = $result[0]['ReservedPropertyOrderID'];
					
					$this->addReservedPropertyOrderItem($input,$cartItemsRS);
					$this->updateOrderTotals($input['ReservedPropertyOrderID'],$input);
					$this->sendEmailRemind($input['ReservedPropertyOrderID'],'new');
				}
				else
				{
					$SERVER->setMessage('reservedProperty.ReservedPropertyOrderClass.setReservedPropertyOrder.err.AlreadyExists');
				}
				if(count($result)>0)	
				{
					$SERVER->setMessage('reservedProperty.ReservedPropertyOrderClass.setReservedPropertyOrder.msg.DataSaved');
				}
				if($orderMode!='direct' && $orderMode!='directorder' && $orderMode!='enquiry')
				{
					$CartItem->emptyCart($input);
				}
			}
		}
		
		$result['ReservedPropertyOrderID'] = $input['ReservedPropertyOrderID'];
		return $result;		
	}	

	function addReservedPropertyOrderItem($input,$cartItemsRS)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$orderID = $input['ReservedPropertyOrderID'];
		$orderMode = $input['orderMode'];
		//set client side variables
		//set queries	
		if(empty($userID))
		{
			//try to get user my his email
			$userRS = $DS->query("SELECT UserID FROM User WHERE Email='".$input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderEmail']."'");
			$userID = $userRS[0]['UserID'];
			$input['ReservedPropertyOrderItem'.DTR.'UserID'] = $userID;
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
					$inputItem['ReservedPropertyOrderItem'.DTR.'ReservedPropertyOrderID']=$orderID;
					$inputItem['ReservedPropertyOrderItem'.DTR.'ReservedPropertyOrderItemPrice']=$row['CartItemPrice'];
					$inputItem['ReservedPropertyOrderItem'.DTR.'ReservedPropertyOrderItemDiscountAmount']=$this->getOrderItemDiscountAmount('');
					$inputItem['ReservedPropertyOrderItem'.DTR.'ReservedPropertyOrderItemQuantity']=$row['CartItemQuantity'];
					
					foreach($row as $rowFieldName=>$rowFieldValue)
					{
						if($rowFieldName!='SessionID' && $rowFieldName!='TimeCreated' && $rowFieldName!='TimeSaved' && $rowFieldName!='CartItemFields' )
						{
							$inputItem['ReservedPropertyOrderItem'.DTR.$rowFieldName] = addslashes($rowFieldValue);
						}
					}
					$whereItem['ReservedPropertyOrderItem'] = "ReservedPropertyOrderItemID = ''";
					$inputItem['actionMode']='save';					
					$result = $DS->save($inputItem,$whereItem,'insert');	
					$itemID = $result[0]['ReservedPropertyOrderItemID'];

					//echo '<textarea cols=50 rows=10>';
					//print_r($inputItem);
					//echo '</textarea><br>';
					
					if(is_array($row['CartItemFields']))
					{
						$inputField['ReservedPropertyOrderItemField'.DTR.'ReservedPropertyOrderItemID'] = $itemID;
						foreach($row['CartItemFields'] as $fieldCode=>$fieldRow)
						{
							foreach($fieldRow as $fieldRowName=>$fieldRowValue)
							{
								$inputField['ReservedPropertyOrderItemField'.DTR.$fieldRowName] = $fieldRowValue;
							}		
							$whereField['ReservedPropertyOrderItemField'] = "ReservedPropertyOrderItemFieldID = ''";
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
				$input['ReservedPropertyOrderItem'.DTR.'ReservedPropertyOrderID']=$orderID;
				$where['ReservedPropertyOrderItem'] = "ReservedPropertyOrderItemID = ''";
				$input['actionMode']='save';					
				$result = $DS->save($input,$where,'insert');				
			}
			elseif($orderMode=='directorder' || $orderMode=='enquiry')
			{
				if(!empty($input['ReservedPropertyOrderItem'.DTR.'ReservedPropertyID']))
				{
					$reservedPropertyID = $input['ReservedPropertyOrderItem'.DTR.'ReservedPropertyID'];
					//get reservedProperty info 
					$reservedPropertyQuery = "SELECT * FROM ReservedProperty WHERE ReservedPropertyID='$reservedPropertyID'";
					$reservedPropertyRS = $DS->query($reservedPropertyQuery);
					foreach ($reservedPropertyRS[0] as $fieldName=>$fieldValue)
					{
						$input['ReservedPropertyOrderItem'.DTR.$fieldName] = addslashes($fieldValue);
					}
					//make price
					$orderItemPrice = $reservedPropertyRS[0]['ReservedPropertyPrice'];
		
					$input['ReservedPropertyOrderItem'.DTR.'ReservedPropertyOrderItemPrice'] = $orderItemPrice;
				}
				$input['ReservedPropertyOrderItem'.DTR.'ReservedPropertyOrderID']=$orderID;
				$where['ReservedPropertyOrderItem'] = "ReservedPropertyOrderItemID = ''";
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

			$query = "UPDATE ReservedPropertyOrder SET ReservedPropertyOrderAmount='".$result['price']."', ReservedPropertyOrderDiscountAmount='".$result['discounts']."', ReservedPropertyOrderTaxesAmount='".$result['taxes']."', ReservedPropertyOrderTotalAmount=".$result['total']." WHERE ReservedPropertyOrderID='$orderID'";
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
				$itmesRS = $DS->query("SELECT ReservedPropertyOrderItemQuantity, ReservedPropertyOrderItemPrice FROM ReservedPropertyOrderItem WHERE ReservedPropertyOrderID='$orderID'");
				if(is_array($itmesRS))
				{
					foreach ($itmesRS as $row)
					{
						$quantityCurrent = $row['ReservedPropertyOrderItemQuantity'];
						if(empty($quantityCurrent)) {$quantityCurrent=1;}
						$quantity = $quantity+$quantityCurrent;
						$price = $price + $row['ReservedPropertyOrderItemPrice']*$quantityCurrent;					
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
	function deleteReservedPropertyOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservedPropertyOrderClass.deleteReservedPropertyOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ReservedPropertyOrder'.DTR.'ReservedPropertyOrderID'];
		//if(empty($entityID)) {$entityID = $input['ReservedPropertyOrderID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservedPropertyOrderServer.adminReservedPropertyOrder');
		//set queries
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT ReservedPropertyOrderFieldID FROM ReservedPropertyOrderField WHERE ReservedPropertyOrderID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['ReservedPropertyOrderFieldID'];
			$DS->query("DELETE FROM ReservedPropertyOrder WHERE ReservedPropertyOrderID='$entityID'");
			$DS->query("DELETE FROM ReservedPropertyOrderItem WHERE ReservedPropertyOrderID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM ReservedPropertyOrderItemField WHERE ReservedPropertyOrderItemFieldID='$typeFieldID'");
			}
		}
		$SERVER->setMessage('ReservedPropertyOrderClass.deleteReservedPropertyOrder.msg.DataDeleted');
		$SERVER->setDebug('ReservedPropertyOrderClass.deleteReservedPropertyOrder.End','End');		
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
			$orderRS = $DS->query("SELECT * FROM ReservedPropertyOrder WHERE ReservedPropertyOrderID='$orderID'");
			$order =$orderRS[0];
			//get order items
			$orderItemsRS = $DS->query("SELECT * FROM ReservedPropertyOrderItem WHERE ReservedPropertyOrderID='$orderID'");
			$orderItems = $orderItemsRS;
			if($mode=='user')
			{
				if(!empty($template))
				{
					$emailInput['MailTemplate']	= $template;
				}
				else
				{
					$emailInput['MailTemplate']	= $status.'ReservedPropertyOrderUser.reservedProperty';
				}			
				$emailInput['MailFrom'] = $config['SiteMail'];
				$emailInput['MailFromName'] = $config['SiteName'];
				$emailInput['MailTo']	= $order['ReservedPropertyOrderEmail'];
				$emailInput['MailToName']	= $order['ReservedPropertyOrderFirstName'].' '.$order['ReservedPropertyOrderLastName'];
			}
			else
			{
				if(!empty($template))
				{
					$emailInput['MailTemplate']	= $template;
				}
				else
				{
					$emailInput['MailTemplate']	= $status.'ReservedPropertyOrderAdmin.reservedProperty';
				}			
				$emailInput['MailTo'] = $config['SiteMail'];
				$emailInput['MailToName'] = $config['SiteName'];
				$emailInput['MailFrom']	= $order['ReservedPropertyOrderEmail'];
				$emailInput['MailFromName']	= $order['ReservedPropertyOrderFirstName'].' '.$order['ReservedPropertyOrderLastName'];
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
			$emailInput['MailData']['ReservedPropertyOrderItems'] = $orderItems;
			$SERVER->callService('sendMail','mailServer',$emailInput);
			
			if($mode=='useradmin')
			{
				$emailInput['MailTemplate']	= $status.'ReservedPropertyOrderUser.reservedProperty';
				$emailInput['MailFrom'] = $config['SiteMail'];
				$emailInput['MailFromName'] = $config['SiteName'];
				$emailInput['MailTo']	= $order['ReservedPropertyOrderEmail'];
				$emailInput['MailToName']	= $order['ReservedPropertyOrderFirstName'].' '.$order['ReservedPropertyOrderLastName'];
				$SERVER->callService('sendMail','mailServer',$emailInput);
			}
		
		}			
	}
	
} // end of ReservedPropertyOrderServer
?>
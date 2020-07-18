<?php
//XCMSPro: Web Service entity class
class TourOrderClass
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
	function TourOrderClass()
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
	function getTourOrders($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.getTourOrders.Start','Start');
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
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourOrderServer.adminTourOrder');
		if(!empty($searchWord))
		{
			$filter .= " AND ( TourOrderFirstName LIKE '{ls}%$searchWord%{le}' OR  TourOrderFirstName LIKE '%$searchWord%' OR  TourOrderLastName LIKE '{ls}%$searchWord%{le}' OR  TourOrderLastName LIKE '%$searchWord%' OR  TourOrderEmail LIKE '{ls}%$searchWord%{le}' OR  TourOrderEmail LIKE '%$searchWord%')";
			$filter .= " AND ( TourOrderID LIKE '{ls}%$searchWord%{le}' OR  TourOrderID LIKE '%$searchWord%')";
		}
		if(!empty($input['TourOrderStatus']) && $input['TourOrderStatus'] != 'all')
		{
			$TourOrderStatus = $input['TourOrderStatus'];
			$filter .= " AND TourOrderStatus = '$TourOrderStatus' ";
		}
		
		if(!empty($input['TourOrderSort']))
		{
			$TourOrderSort = $input['TourOrderSort'];
			$sort = "$TourOrderSort DESC";
		}
		else
			{
				$sort = "TimeCreated DESC";
			}
		if(!empty($input['TourOrderPaymentStatus']))
		{
			$TourOrderPaymentStatus = $input['TourOrderPaymentStatus'];
			$filter .= " AND TourOrderPaymentStatus = '$TourOrderPaymentStatus' ";
		}
		
		if($userID != 'admin' && $userID != 'root')
		{
			$filter .= " AND UserID = '$userID' ";
		}
		
		
		if($input['SID'] == 'myhome' || $input['SID'] == 'viewOrder')
		{
			$filter .= " AND UserID = '$userID' ";
		}
		
		if($filterMode=='last')
		{
			$limit = " LIMIT 0,10";
		}		
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		//$query = "SELECT * FROM TourOrder WHERE TourOrderID>0 $filter ORDER BY TourOrderPosition";
		$query = "SELECT * FROM TourOrder WHERE TourOrderID>0 $filter ORDER BY $sort".$limit;
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('TourOrderClass.getTourOrders.End','End');
		return $result;
	}	
	
	function getTourOrderFields($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.getTourOrderFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TourOrder'.DTR.'TourOrderID'];
		if(empty($entityID)) {$entityID = $input['TourOrderID'];}
		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['TourOrder'];}
		if(empty($entityAlias)) {$entityAlias = $input['TourOrderAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourOrder'.DTR.'TourOrderAlias'];}
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$TourOrderIDRS = $DS->query("SELECT TourOrderID FROM TourOrder WHERE TourOrderAlias='$entityAlias'");
			$entityID = $TourOrderIDRS[0]['TourOrderID'];
		}
		//$filter = $DS->getAccessFilter($input,'TourOrderServer.adminTourOrder');
		if(!empty($entityID))		
		{
			$filter .= " AND TourOrderID='$entityID'";
		}
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM TourOrderField WHERE TourOrderFieldID>0 $filter ORDER BY TourOrderFieldPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('TourOrderClass.getTourOrderFields.End','End');
		return $result;
	}	
	
	function getTourOrderOptions($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.getTourOrderFields.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TourOrderField'.DTR.'TourOrderFieldID'];
		if(empty($entityID)) {$entityID = $input['TourOrderFieldID'];}
		
		$entityAlias = $input['TourField'];		
		if(empty($entityAlias)) {$entityAlias = $input['TourOrderFieldAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['TourOrderField'.DTR.'TourOrderFieldAlias'];}
		
		$searchWord = $input['searchWord'];
		//set filters
		if(empty($entityID) && !empty($entityAlias))
		{
			$TourOrderIDRS = $DS->query("SELECT TourOrderFieldID FROM TourOrderField WHERE TourOrderFieldAlias='$entityAlias'");
			$entityID = $TourOrderIDRS[0]['TourOrderFieldID'];
		}
		//$filter = $DS->getAccessFilter($input,'TourOrderServer.adminTourOrder');
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM TourOrderOption WHERE TourOrderFieldID='$entityID' $filter ORDER BY TourOrderOptionPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('TourOrderClass.getTourOrderFields.End','End');
		return $result;
	}	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getTourOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.getTourOrder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		
//		print_r($input);
//		echo 'entityID='.$entityID.'\\\\';
		if(empty($entityID)) {$entityID = $input['TourOrderID'];}
		if(empty($entityID)) {$entityID = $input['TourOrder'.DTR.'TourOrderID'];}
		if(empty($entityID)) {$entityID = $input['TourOrder'];}
		
		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['TourOrder'];}
		if(empty($entityAlias)) {$entityAlias = $input['TourOrderAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourOrder'.DTR.'TourOrderAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TourOrderServer.adminTourOrder');
		//set queries
		$query =='';
		/* if(!empty($entityAlias))
		{
			$filter = " TourOrderAlias='$entityAlias' "; 
		}
		else */
		{
			$filter = " TourOrderID='$entityID' ";
		}
		$query = "SELECT * FROM TourOrder WHERE $filter"; 
//		echo $query;
		//get the content
		
		$result = $DS->query($query);	

		$SERVER->setDebug('TourOrderClass.getTourOrder.End','End');		
		return $result;		
	}
	
	function getTourOrderField($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.getTourOrderField.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['TourOrderField'.DTR.'TourOrderFieldID'];
		if(empty($entityID)) {$entityID = $input['TourOrderFieldID'];}

		$entityAlias = $input['TourOrderField'];
		if(empty($entityAlias)) {$entityAlias = $input['TourOrderFieldAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourOrderField'.DTR.'TourOrderFieldAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TourOrderServer.adminTourOrder');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " TourOrderFieldAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " TourOrderFieldID='$entityID' ";
		}
		$query = "SELECT * FROM TourOrderField WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('TourOrderClass.getTourOrderField.End','End');		
		return $result;		
	}

	function getTourOrderOption($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.getTourOrderOption.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['TourOrderOption'.DTR.'TourOrderOptionID'];
		if(empty($entityID)) {$entityID = $input['TourOrderOptionID'];}

		$entityAlias = $input['TourOrderOption'];
		if(empty($entityAlias)) {$entityAlias = $input['TourOrderOptionAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['TourOrderOption'.DTR.'TourOrderOptionAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'TourOrderServer.adminTourOrder');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " TourOrderOptionAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " TourOrderOptionID='$entityID' ";
		}
		$query = "SELECT * FROM TourOrderOption WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('TourOrderClass.getTourOrderOption.End','End');		
		return $result;		
	}
	
	function getTourOrderItem($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$orderID = $input['TourOrderID'];
		//set client side variables
		//set queries
		if(!empty($orderID))
		{
			$filter .= " AND TourOrderID='$orderID' ";
		}
			
		$query = "SELECT * FROM TourOrderItem WHERE  TourOrderItemID>0 $filter"; 
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
	
	function setTourOrders($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.setTourOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		foreach($input['TourOrder'.DTR.'TourOrderPaymentStatus'] as $id=>$value)
		{
			$TourOrderPaymentStatus = $value;
			$TourOrderStatus = $input['TourOrder'.DTR.'TourOrderStatus'][$id];
			$entityID = $input['TourOrderID'][$id];
			$query = "UPDATE  TourOrder SET TourOrderPaymentStatus = '$TourOrderPaymentStatus', TourOrderStatus ='$TourOrderStatus' WHERE TourOrderID = '$entityID'";
			$DS->query($query);
			/*$result = $DS->save($inValue,$where);*/
		}
	}
	
	function updateTourOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.setTourOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//print_r($input);
		$entityID = $input['TourOrderID'];
		$TourOrderPaymentStatus = $input['TourOrder'.DTR.'TourOrderPaymentStatus'];
		$TourOrderStatus = $input['TourOrder'.DTR.'TourOrderStatus'];
		
		$query = "UPDATE  TourOrder SET TourOrderPaymentStatus = '$TourOrderPaymentStatus', TourOrderStatus ='$TourOrderStatus' WHERE TourOrderID = '$entityID'";
		$DS->query($query);
		
		return $result;
	}
	
	function setTourOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.setTourOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['TourOrder'.DTR.'TourOrderID'];
		if(empty($entityID)) {$entityID = $input['TourOrderID'];}		
		//set queries
		
		if(!empty($input['TourOrder'.DTR.'TourOrderID']))
		{
			$where['TourOrder'] = "TourOrderID = '".$entityID."'".$filter;
			//print_r($input);
			$input['TourOrder'.DTR.'TourOrderProgramStart'] = date('Y-m-d H:m:s',mktime(0, 0, 0, $input['TourOrder'.DTR.'TourOrderProgramStart_Month'], $input['TourOrder'.DTR.'TourOrderProgramStart_Day'], $input['TourOrder'.DTR.'TourOrderProgramStart_Year']));
			$input['TourOrder'.DTR.'TourOrderProgramEnd'] = date('Y-m-d H:m:s',mktime(0, 0, 0, $input['TourOrder'.DTR.'TourOrderProgramEnd_Month'], $input['TourOrder'.DTR.'TourOrderProgramEnd_Day'], $input['TourOrder'.DTR.'TourOrderProgramEnd_Year']));
			$input['TourOrder'.DTR.'TourOrderNextPresentation'] = date('Y-m-d H:m:s',mktime(0, 0, 0, $input['TourOrder'.DTR.'TourOrderNextPresentation_Month'], $input['TourOrder'.DTR.'TourOrderNextPresentation_Day'], $input['TourOrder'.DTR.'TourOrderNextPresentation_Year']));
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
	
			//$this->updateEntityPositions($entityID,'TourOrder');
			//$DS->query("UPDATE TourOrderField SET TourOrder='".$input['TourOrder'.DTR.'TourOrderAlias']."' WHERE TourOrderID='$entityID'");
		}
		
		
		
		$SERVER->setDebug('TourOrderClass.setTourOrder.End','End');		
		return $result;		
	}
	
	function addTourOrder($input)
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

		$CartItem = new TourCartItemClass();
		$cartItemsRS = $CartItem->getTourCartItems($input);
		if(count($cartItemsRS)>0)			
		{		
			if(!empty($userID))
			{
				if(empty($input['TourOrder'.DTR.'TourOrderStatus'])) {$input['TourOrder'.DTR.'TourOrderStatus']='active';}
				if(empty($input['TourOrder'.DTR.'TourOrderPaymentStatus'])) {$input['TourOrder'.DTR.'TourOrderPaymentStatus']='notpaid';}
				if(empty($input['TourOrder'.DTR.'TourOrderType'])) {$input['TourOrder'.DTR.'TourOrderType']='order';}
				
				
				$input['TourOrder'.DTR.'TourOrderDeparture']= date('Y-m-d H:m:s',mktime(0, 0, 0, $input['TourOrder'.DTR.'TourOrderDepartureMonth'], $input['TourOrder'.DTR.'TourOrderDepartureDay'], $input['TourOrder'.DTR.'TourOrderDepartureYear']));
				$input['TourOrder'.DTR.'TourOrderReturn']= date('Y-m-d H:m:s',mktime(0, 0, 0, $input['TourOrder'.DTR.'TourOrderReturnMonth'], $input['TourOrder'.DTR.'TourOrderReturnDay'], $input['TourOrder'.DTR.'TourOrderReturnYear']));
				
				$where['TourOrder'] = "TourOrderID = ''";
				//block doubled insert
				$blockTime = time()-30;//30 seconds limit
				$endTime = $SERVER->getNow($blockTime);
				$checkRS=$DS->query("SELECT TourOrderID FROM TourOrder WHERE UserID='$userID' AND TimeCreated > '$endTime'");
				if(count($checkRS)<1 && !empty($input['TourOrder'.DTR.'TourOrderFullName']))
				{
					$input['actionMode']='save';
					//print_r($input);				
					$result = $DS->save($input,$where,'insert');
					$input['TourOrderID'] = $DS->dbLastID();
					$this->addTourOrderItem($input,$cartItemsRS);
					//$this->updateOrderTotals($input['TourOrderID'],$input);
				}
				else
				{
					$SERVER->setMessage('tour.TourOrderClass.setTourOrder.err.AlreadyExists');
				}
				if(count($result['sql'])>0)	
				{
					$SERVER->setMessage('tour.TourOrderClass.setTourOrder.msg.DataSaved');
				}
				
				$CartItem->emptyCart($input);
			}
		}
		
		$result['TourOrderID'] = $input['TourOrderID'];
		return $result;		
	}	

	function addTourOrderItem($input,$cartItemsRS)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$orderID = $input['TourOrderID'];
		//set client side variables
		//set queries
		if ($orderID==0){$orderID=1;}	
		if(!empty($userID) && !empty($orderID))
		{
			//$CartItem = new CartItemClass();
			//$cartItemsRS = $CartItem->getCartItems($input);
			//echo '<textarea cols=50 rows=10>';
			//print_r($cartItemsRS);
			//echo '</textarea><br>';
			if(is_array($cartItemsRS))			
			{
				$i=0;
				foreach($cartItemsRS as $key=>$row)
				{
					$inputItem['TourOrderItem'.DTR.'TourOrderID']=$orderID;
					$inputItem['TourOrderItem'.DTR.'TourOrderItemPrice']=$row['CartItemPrice'];
					$inputItem['TourOrderItem'.DTR.'TourOrderItemDiscountAmount']=$this->getOrderItemDiscountAmount('');
					$inputItem['TourOrderItem'.DTR.'TourOrderItemWeight']=$row['CartItemWeight'];
					$inputItem['TourOrderItem'.DTR.'TourOrderItemVolume']=$row['CartItemVolume'];
					$inputItem['TourOrderItem'.DTR.'TourOrderItemQuantity']=$row['CartItemQuantity'];
					$inputItem['TourOrderItem'.DTR.'TourOrderItemDeparture']= date('Y-m-d H:m:s',mktime(0, 0, 0, $input['TourOrderItem'.DTR.'TourOrderItemDepartureMonth'][$i], $input['TourOrderItem'.DTR.'TourOrderItemDepartureDay'][$i], $input['TourOrderItem'.DTR.'TourOrderItemDepartureYear'][$i]));
					$inputItem['TourOrderItem'.DTR.'TourOrderItemMessage'] = $input['TourOrderItem'.DTR.'TourOrderItemMessage'][$i];
					$inputItem['TourOrderItem'.DTR.'TourAvailableRoomsValue1'] = $input['TourOrderItem'.DTR.'TourAvailableRoomsValue1_'.$i];
					$inputItem['TourOrderItem'.DTR.'TourAvailableBoardValue1'] = $input['TourOrderItem'.DTR.'TourAvailableBoardValue1_'.$i];
					$i++;
					
				
					foreach($row as $rowFieldName=>$rowFieldValue)
					{
						if($rowFieldName!='UserID' && $rowFieldName!='SessionID' && $rowFieldName!='TimeCreated' && $rowFieldName!='TimeSaved' && $rowFieldName!='CartItemFields'  && $rowFieldName!='CartItemWeight' )
						{
							$inputItem['TourOrderItem'.DTR.$rowFieldName] = $rowFieldValue;
						}
					}
					$whereItem['TourOrderItem'] = "TourOrderItemID = ''";
					$inputItem['actionMode']='save';					
					$result = $DS->save($inputItem,$whereItem,'insert');	
					$itemID = $DS->dbLastID();//echo "item ".$itemID;
					//echo '<textarea cols=50 rows=10>';
					//print_r($inputItem);
					//echo '</textarea><br>';
					
					if(is_array($row['CartItemFields']))
					{
						$inputField['TourOrderItemField'.DTR.'TourOrderItemID'] = $itemID;
						foreach($row['CartItemFields'] as $fieldCode=>$fieldRow)
						{
							foreach($fieldRow as $fieldRowName=>$fieldRowValue)
							{
								$inputField['TourOrderItemField'.DTR.$fieldRowName] = $fieldRowValue;
							}		
							$whereField['TourOrderItemField'] = "TourOrderItemFieldID = ''";
							$inputField['actionMode']='save';					
							$result = $DS->save($inputField,$whereField,'insert');		
							//echo '<textarea cols=50 rows=10>';
							//print_r($inputField);
							//echo '</textarea><br>';														
						}
					}
				}
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

			$query = "UPDATE TourOrder SET TourOrderWeight=".$result['weight'].", TourOrderVolume=".$result['volume'].", TourOrderAmount=".$result['price'].", TourOrderShippingAmount=".$result['shipping'].", TourOrderDiscountAmount=".$result['discounts'].", TourOrderTaxesAmount=".$result['taxes'].", TourOrderTotalAmount=".$result['total']." WHERE TourOrderID='$orderID'";
			$DS->query($query);
			//echo $query ;
		}
	}

	function getOrderTotals($input,$orderID='')
	{
		$DS = &$this->_DS;
		if(!empty($orderID))
		{
			//get order from DB
		}
		else
		{
			//get info from shoping cart
			$CartItem = new TourCartItemClass();
			$cartItemsRS = $CartItem->getTourCartItems($input);		
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
		return 12;
	}
	
	function getOrderTotalDiscounts($orderInfo)
	{
		return 11;
	}	
	
	function getOrderTotalTaxes($orderInfo)
	{
		$price = $orderInfo['price'];
		$result = $price/1.2;
		return $result;
	}		
		
	function getOrderItemDiscountAmount($input)
	{
		
	}


    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteTourOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.deleteTourOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['TourOrder'.DTR.'TourOrderID'];
		//if(empty($entityID)) {$entityID = $input['TourOrderID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourOrderServer.adminTourOrder');
		//set queries
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT TourOrderFieldID FROM TourOrderField WHERE TourOrderID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['TourOrderFieldID'];
			$DS->query("DELETE FROM TourOrder WHERE TourOrderID='$entityID'");
			$DS->query("DELETE FROM TourOrderItem WHERE TourOrderID='$entityID'");
			if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM TourOrderItemField WHERE TourOrderItemFieldID='$typeFieldID'");
			}
		}
		$SERVER->setMessage('TourOrderClass.deleteTourOrder.msg.DataDeleted');
		$SERVER->setDebug('TourOrderClass.deleteTourOrder.End','End');		
		return $result;		
	}	
	
	function getTourParticipants($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.getTourParticipants.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$entityID = $input['TourOrderID'];
		if(empty($entityID)) {$entityID = $input['TourOrder'.DTR.'TourOrderID'];}
		
		//set queries
		$query = "SELECT * FROM  TourParticipant WHERE TourOrderID='$entityID'";
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('TourOrderClass.getTourParticipants.End','End');
		return $result;
	}
	
	
	function addTourParticipants($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$entityID = $input['TourOrder'.DTR.'TourOrderID'];
		if(empty($entityID)) {$entityID = $input['TourOrderID'];}
		//set client side variables
		//set queries	
		
		if(!empty($entityID))
		{
			$count = $input['AddTourParticipant'][0];
			
			if($count>0)
			{
				$filter = "AND TourOrderID = '".$entityID."'";
				$where['TourParticipant'] = "TourParticipantID = '".$input['TourParticipant'.DTR.'TourParticipantID']."'".$filter;
				$inValue['TourParticipant'.DTR.'TourOrderID'] = $entityID;
				$inValue['TourParticipant'.DTR.'TourParticipantName'] = " ";
				$inValue['actionMode']='save';					
				$result = $DS->save($inValue,$where);
			}
		}		
		return $result;		
	}
	
	function setTourParticipants($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];

		foreach($input['TourParticipant'.DTR.'TourParticipantID'] as $key=>$value)
		{
			$TourParticipantID = $input['TourParticipant'.DTR.'TourParticipantID'][$key];
			$TourParticipantName = $input['TourParticipant'.DTR.'TourParticipantName'][$key];
			$TourParticipantDate = $input['TourParticipant'.DTR.'TourParticipantDate_'.$key];
			$TourParticipantPassport = $input['TourParticipant'.DTR.'TourParticipantPassport'][$key];
			
			$query = "UPDATE  TourParticipant SET TourParticipantName = '$TourParticipantName', TourParticipantDate = '$TourParticipantDate', TourParticipantPassport = '$TourParticipantPassport' WHERE TourParticipantID = '$TourParticipantID'";
			$DS->query($query);
		}
		
	}
	
	function setTourParticipant($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		$entityID = $input['TourOrder'.DTR.'TourOrderID'];
		if(empty($entityID)) {$entityID = $input['TourOrderID'];}
		
		$filter = "AND TourOrderID = '".$entityID."'";
		$where['TourParticipant'] = "TourParticipantID = '".$input['TourParticipant'.DTR.'TourParticipantID']."'".$filter;
		$inValue['TourParticipant'.DTR.'TourOrderID'] = $entityID;
		$inValue['TourParticipant'.DTR.'TourParticipantName'] = $input['TourParticipant'.DTR.'TourParticipantName'];
		$inValue['TourParticipant'.DTR.'TourParticipantDate'] = $input['TourParticipant'.DTR.'TourParticipantDate'];
		$inValue['TourParticipant'.DTR.'TourParticipantPassport'] = $input['TourParticipant'.DTR.'TourParticipantPassport'];
		$inValue['actionMode']='save';					
		$result = $DS->save($inValue,$where);		
	}
	
	function deleteTourParticipant($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.deleteTourParticipant.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['TourParticipant'.DTR.'TourParticipantID'];
		//if(empty($entityID)) {$entityID = $input['TourOrderID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'TourOrderServer.adminTourOrder');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM TourParticipant WHERE TourParticipantID='$entityID'");
		}
		$SERVER->setMessage('TourOrderClass.deleteTourParticipant.msg.DataDeleted');
		$SERVER->setDebug('TourOrderClass.deleteTourParticipant.End','End');		
		return $result;		
	}
	
	
	function date2Days($_timestamp) 
	{
		  $_year=(int) date('Y',$_timestamp);
		  $_month=(int) date('m',$_timestamp);
		  $_day=(int) date('j',$_timestamp);
		  $_century = substr($_year,0,2);
		  $_year = substr($_year,2,2);
		  if($_month>2) $_month -= 3;
		  else {
				$_month += 9;
				if($_year) $_year--;
				else {
				 $_year=99;
				 $_century --;
				}
		  }
		  return (floor((146097*$_century)/4)+floor((1461*$_year)/4)+floor((153*$_month+2)/5)+$_day+1721119);
	 }
	
	function addTourOrderProgram($input)
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
		
		$entityID = $input['TourOrder'.DTR.'TourOrderID'];
		if(empty($entityID)) {$entityID = $input['TourOrderID'];}
		
		//set queries	
		if($input['TourOrder'.DTR.'TourOrderProgramStart_Day'] && $input['TourOrder'.DTR.'TourOrderProgramStart_Month'] && $input['TourOrder'.DTR.'TourOrderProgramStart_Month'])
		{
			$t1 = mktime(0, 0, 0, $input['TourOrder'.DTR.'TourOrderProgramStart_Month'], $input['TourOrder'.DTR.'TourOrderProgramStart_Day'], $input['TourOrder'.DTR.'TourOrderProgramStart_Year']);
			$t2 = mktime(0, 0, 0, $input['TourOrder'.DTR.'TourOrderProgramEnd_Month'], $input['TourOrder'.DTR.'TourOrderProgramEnd_Day'], $input['TourOrder'.DTR.'TourOrderProgramEnd_Year']);
			$daysDiff=$this->date2Days($t2)-$this->date2Days($t1);	
			
			$query = "SELECT  TourProgramDate FROM TourProgram WHERE TourOrderID = $entityID";
			$resultRS = $DS->query($query);
			$count_program = count($resultRS);
			
			$days = $daysDiff - $count_program;
			if($daysDiff>0)
			{
				for($i=0;$i<$days;$i++)
				{
					$inProgram['TourProgram'.DTR.'TourProgramDate'] = date('Y-m-d H:m:s',mktime(0, 0, 0, $input['TourOrder'.DTR.'TourOrderProgramStart_Month'], $input['TourOrder'.DTR.'TourOrderProgramStart_Day'] + $i, $input['TourOrder'.DTR.'TourOrderProgramStart_Year']));
					$inProgram['TourProgram'.DTR.'TourOrderID'] = $entityID;
					$inProgram['actionMode'] = 'save';
					$where['TourProgram'] = "TourProgramID = '".$input['TourProgram'.DTR.'TourProgramID']."'";
					//print_r($inProgram);
					$DS->save($inProgram,$where);
				}
			}
		}
	}
	
	function setTourPrograms($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];

		foreach($input['TourProgram'.DTR.'TourProgramID'] as $key=>$value)
		{
			$TourProgramID = $input['TourProgram'.DTR.'TourProgramID'][$key];
			$TourProgramMessage = $input['TourProgram'.DTR.'TourProgramMessage'][$key];
			
			$query = "UPDATE  TourProgram SET TourProgramMessage = '$TourProgramMessage' WHERE TourProgramID = '$TourProgramID'";
			$DS->query($query);
		}
		
	}
	
	function getTourOrderPrograms($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('TourOrderClass.getTourOrderPrograms.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$entityID = $input['TourOrderID'];
		if(empty($entityID)) {$entityID = $input['TourOrder'.DTR.'TourOrderID'];}
		
		//set queries
		$query = "SELECT * FROM  TourProgram WHERE TourOrderID='$entityID'";
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('TourOrderClass.getTourOrderPrograms.End','End');
		return $result;
	}
} // end of TourOrderServer
?>
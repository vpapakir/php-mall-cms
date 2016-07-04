<?php
class BillingOrderServer
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
	function BillingOrderServer()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	
	// PUBLIC METHODS
	function setOrder($input)
	{
//	echo 'asdf';
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$user= $SERVER->getUser();
		$config = $SERVER->getConfig();
		$BillingTransaction = new BillingTransactionServer(&$SERVER,&$DS);
		$clientType = $config['clientType'];
		if($input['actionMode']=='save')
		{
			if($SERVER->hasRights('BillingOrderServer.Order.adminOrders') && $clientType=='admin')
			{
				$sql = "SELECT OrderStatus as BillingOrder".DTR."OrderStatus, OrderPaymentStatus as BillingOrder".DTR."OrderPaymentStatus, UserID as BillingOrder".DTR."UserID, OrderAmount as BillingOrder".DTR."OrderAmount,BillingOrderID as BillingOrder".DTR."BillingOrderID, OrderType as BillingOrder".DTR."OrderType FROM  BillingOrder WHERE BillingOrderID='".$input['BillingOrder'.DTR.'BillingOrderID']."'";
				$dsResult = $DS->query($sql);
				$orderStatus = $dsResult['sql'][0]['BillingOrder'.DTR.'OrderStatus'];		
				$paymentStatus = $dsResult['sql'][0]['BillingOrder'.DTR.'OrderPaymentStatus'];
				$orderUserID = $dsResult['sql'][0]['BillingOrder'.DTR.'UserID'];
				$orderAmount =  $dsResult['sql'][0]['BillingOrder'.DTR.'OrderAmount'];
				$orderID =  $dsResult['sql'][0]['BillingOrder'.DTR.'BillingOrderID'];
				$orderType =  $dsResult['sql'][0]['BillingOrder'.DTR.'OrderType'];
				$orderPaymentDetails =  $dsResult['sql'][0]['BillingOrder'.DTR.'OrderPaymentDetails'];
				
				//the case for changing to payment status paid 
				if($input['BillingOrder'.DTR.'OrderPaymentStatus']=='paid' and $paymentStatus<>$input['BillingOrder'.DTR.'OrderPaymentStatus'])
				{
					//order is paid .. so add a transaction
					$transactionInput ['BillingTransaction'.DTR.'TransactionType'] = 'order';
					if($orderType == 'withdraw' or $orderType == 'buyservice')
					{
						$balanceIN['UserID']=$orderUserID;
						$transactionInput ['BillingTransaction'.DTR.'UserID'] = $orderUserID;
						$transactionInput ['BillingTransaction'.DTR.'TransactionReason'] = $orderType;
						$transactionInput ['BillingTransaction'.DTR.'TransactionReceiverID'] = $config['OwnerID'];
						$transactionInput ['BillingTransaction'.DTR.'TransactionSenderID'] = $orderUserID;
						$transactionInput ['BillingTransaction'.DTR.'TransactionAmount'] = $orderAmount;
						//$transactionInput ['BillingTransaction'.DTR.'TransactionAction'] = 'minus';
						if($orderType == 'withdraw')
						{
							$transactionInput ['BillingTransaction'.DTR.'TransactionReasonDescription'] = 'Withdraw money';										
						}
						elseif($orderType == 'buyservice')
						{
							$transactionInput ['BillingTransaction'.DTR.'TransactionReasonDescription'] = 'Buy service';																	
						}
					}
					else
					{
						$transactionInput ['BillingTransaction'.DTR.'UserID'] = $config['OwnerID'];
						$transactionInput ['BillingTransaction'.DTR.'TransactionReason'] = 'buy';
						$transactionInput ['BillingTransaction'.DTR.'TransactionReceiverID'] = $orderUserID;
						$transactionInput ['BillingTransaction'.DTR.'TransactionSenderID'] = $config['OwnerID'];
						//$transactionInput ['BillingTransaction'.DTR.'TransactionAction'] = 'plus';
						$depositedAmount = $orderAmount;
						//$systemAmount = $orderAmount - $sponsorAmount;
						$transactionInput ['BillingTransaction'.DTR.'TransactionAmount'] = $depositedAmount;
						$transactionInput ['BillingTransaction'.DTR.'TransactionReasonDescription'] = 'Deposit money';
																
					}
					$transactionInput ['BillingTransaction'.DTR.'TransactionCreator'] = $orderID;
					$BillingTransaction->addTransaction($transactionInput);
										
					//end to add the new transaction
					//torefact0: send email remind here			
				}
			}
			else
			{
				//block save function if a user is trying to change the order statuses himself and without respective rights
				if(!empty($input['BillingOrder'.DTR.'OrderPaymentStatus']) and !empty($input['BillingOrder'.DTR.'OrderStatus']) and !empty($input['BillingOrder'.DTR.'OrderPaymentDate'])  and !empty($input['BillingOrder'.DTR.'OrderStatusDate']))
				{
					$err=1;
					$SERVER->setMessage('billing.Order.err.NoRightsForOrderAdministration');
				}
			}
			if($input['BillingOrder'.DTR.'OrderType'] == 'withdraw')
			{
				//check users balance .. it is impossible to withdraw more balance of the user
				$balance = $BillingTransaction->getBalance($balanceIN);
				$diference = $balance - $input['BillingOrder'.DTR.'OrderAmount'];
				if($diference <=0)
				{
					$SERVER->setMessage('billing.Order.err.NegativeBalance');
					$negativeBalance = $balance;
					$SERVER->setVars('maxAmount',$balance);
					$SERVER->setVars('viewMode','edit');
					$err=1;
				}
				
				if($input['BillingOrder'.DTR.'OrderAmount']<1)
				{
					$SERVER->setMessage('billing.Order.err.TooSmallAmount');
					$SERVER->setVars('viewMode','edit');
					$err=1;
				}
			}
			if($input['BillingOrder'.DTR.'OrderType'] == 'buyservice')
			{
				//check users balance .. it is impossible to buy a service if the user does not have enough money in the balance
				$balanceIN['UserID']=$orderUserID;
				$balance = $BillingTransaction->getBalance($balanceIN);
				$diference = $balance - $input['BillingOrder'.DTR.'OrderAmount'];
				if($diference <=0)
				{
					$SERVER->setMessage('billing.Order.err.NegativeBalanceService');
					$negativeBalance = $balance;
					$SERVER->setVars('maxAmount',$balance);
					$SERVER->setVars('viewMode','edit');
					$err=1;
				}
			}			
		}

		if($input['actionMode']=='delete'){$input['actionMode']='';}//block any possibility to delete orders records
		if(empty($input['BillingOrder'.DTR.'BillingOrderID']))
		{
			$input['BillingOrder'.DTR.'OrderStatus'] = 'new';
			$input['BillingOrder'.DTR.'OrderStatusDate'] = date('Y:m:d H:i:s');
			$input['BillingOrder'.DTR.'OrderPaymentStatus'] = 'notpaid';
			$input['BillingOrder'.DTR.'OrderPaymentDate'] = date('Y:m:d H:i:s');			
		}
		if(empty($err))
		{
			//print_r($input);
			//die('');
			$where['BillingOrder'] = "BillingOrderID = '".$input['BillingOrder'.DTR.'BillingOrderID']."'";
			$saveResult = $DS->save($input,$where);
			$result = $saveResult;
		}
		
		return $result;		
	}
	
	function setOrders($input)
	{
//		echo 'asdf';
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('BillingOrderServer.Orders.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
//		print_r($input);
		foreach($input['BillingOrder'.DTR.'OrderPaymentStatus'] as $id=>$value)
		{
			$ResourceOrderPaymentStatus = $value;
			$ResourceOrderStatus = $input['BillingOrder'.DTR.'OrderStatus'][$id];
			$entityID = $input['BillingOrderID'][$id];
			
			if(!empty($entityID))
			{
				$oldRS = $DS->query("SELECT OrderPaymentStatus, OrderStatus FROM BillingOrder WHERE  BillingOrderID = '$entityID'");
				$oldPaymentStatus = $oldRS[0]['OrderPaymentStatus'];
				$oldOrderStatus = $oldRS[0]['OrderStatus'];
				/*
				if(!empty($oldPaymentStatus) && !empty($ResourceOrderPaymentStatus) && $oldPaymentStatus!=$ResourceOrderPaymentStatus)
				{
					$this->sendEmailRemind($entityID,$ResourceOrderPaymentStatus);
				}
				*/
				/* if(!empty($oldOrderStatus) && !empty($ResourceOrderStatus) && $oldOrderStatus!=$ResourceOrderStatus)
				{
					$this->sendEmailRemind($entityID,$ResourceOrderStatus);
				}
				*/
				$query = "UPDATE  BillingOrder SET OrderPaymentStatus = '$ResourceOrderPaymentStatus', OrderStatus ='$ResourceOrderStatus' WHERE BillingOrderID = '$entityID'";
//				echo $query;
				$DS->query($query);
			}
			/*$result = $DS->save($inValue,$where);*/
		}
	}
	
	function getOrder($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;

		$OrderID = $input['BillingOrder'.DTR.'BillingOrderID'];
		$OrderCreatorID = $input['OrderCreatorID'];
		if(!empty($OrderCreatorID))
		{
			$filter = " OrderCreatorID='$OrderCreatorID' ";
		}
		else
		{
			$filter = " BillingOrderID='$OrderID' ";
		}
		
		$query = "SELECT * FROM BillingOrder WHERE $filter ";
		$dsResult = $DS->query($query);
		return $dsResult;		
	}
	
	function getOrders($input)
	{
//	echo 'awcr';
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$user = $SERVER->getUser();
		$orderStatus = $input['ResourceOrderStatus'];
//		print_r($input);
		$OrderPaymentStatus = $input['OrderPaymentStatus'];
		if(empty($orderStatus)) {$orderStatus =$input['BillingOrder'.DTR.'OrderStatus']; }
		if(empty($orderStatus)) {$orderStatus = 'new';}
		$orderType = $input['BillingOrder'.DTR.'OrderType'];
		if(empty($orderType)) {$orderType=$input['OrderType'];}
//		if(empty($orderType)) {$orderType = 'buy';}
		
		$filter='';
		if(!empty($input['BillingOrder'.DTR.'OrderPaymentStatus']))
		{
			$filter = " AND OrderPaymentStatus='".$input['BillingOrder'.DTR.'OrderPaymentStatus']."'";// AND OrderType = '$orderType' ";
		}
		else
		if(!empty($OrderPaymentStatus))
		{
			$filter .= " AND OrderPaymentStatus='".$OrderPaymentStatus."' ";
		}
		if(!empty($orderStatus))
		{
			$filter .= " AND OrderStatus='".$orderStatus."' AND OrderType = '$orderType' ";		
		}
		if($SERVER->hasRights('billing.Orders.adminOrders'))
		{
			if ($input['BillingOrder'.DTR.'UserID'])
			{
				//$xcmsq = "BillingOrder[UserID='".$input['BillingOrder'.DTR.'UserID']."'".$filter."]/sortdesc(BillingOrder.TimeCreated)";
				$xcmsq = "select * from BillingOrder where UserID='".$input['BillingOrder'.DTR.'UserID']."'".$filter." order by BillingOrder.TimeCreated desc";
			}
			else
			{
				//$xcmsq = "BillingOrder[1 ".$filter."]/sortdesc(BillingOrder.TimeCreated)";
				$xcmsq = "select * from BillingOrder where 1=1 ".$filter." order by BillingOrder.TimeCreated desc";
			}
		}
		else
		{
			//$xcmsq = "BillingOrder[UserID='".$user['UserID']."'".$filter."]/sortdesc(BillingOrder.TimeCreated)";
			$xcmsq = "select * from BillingOrder where UserID='".$user['UserID']."'".$filter." order by BillingOrder.TimeCreated desc";
		}
		//echo $xcmsq;
		$mode['pagesMode'] = 20;
		//echo $xcmsq;
		$dsResult = $DS->query($xcmsq,$mode);
		$retval = $dsResult;//['xml'];
	
		return $retval;		
	}	

	function doOrderPayment($input,$mode='')
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$user = $SERVER->getUser();
		$config = $SERVER->getConfig();

		$ownerID = $config['OwnerID'];

		$orderID = $input['OrderID'];
		$orderAmount = $input['OrderAmount'];
		$orderReasonDescription = addslashes($input['OrderReasonDescription']);
		$orderPaymentDetails = addslashes($input['OrderPaymentDetails']);
		
		$paymentStatus = $input['OrderPaymentStatus'];
		if(empty($paymentStatus)) {$paymentStatus='paid';}
		$redirectionMode = $input['redirectionMode'];
		

		//$req = '$orderID='.$orderID.'$orderAmount='.$orderAmount.'$orderReasonDescription'.$orderReasonDescription.'$orderPaymentDetails='.$orderPaymentDetails;
		//$fp = fopen('ipntest.txt','a+');
		//fwrite($fp,'do order payment='.$req."\n");
		//fclose($fp);		
		//print_r($input);
		//$extraFilter = " AND OrderAmount='$orderAmount' ";

		if($paymentStatus=='waiting')
		{
			$checkOrderRS = $DS->query("SELECT BillingOrderID, UserID, OrderAmount FROM BillingOrder WHERE BillingOrderID='$orderID' AND OrderPaymentStatus!='waiting'  $extraFilter ");
		} 
		else 
		{
			$checkOrderRS = $DS->query("SELECT BillingOrderID, UserID, OrderAmount FROM BillingOrder WHERE BillingOrderID='$orderID' AND OrderPaymentStatus!='paid' $extraFilter ");
		}
		
		if(!empty($checkOrderRS[0]['BillingOrderID']))
		{
			$userID = $checkOrderRS[0]['UserID'];
			$orderAmount = $checkOrderRS[0]['OrderAmount'];
			$now = $SERVER->getNow();
			if(!empty($orderPaymentDetails)) {$update = ", OrderPaymentDetails='$orderPaymentDetails'";}

			if(!empty($mode))
			{
				$DS->query("UPDATE BillingOrder SET OrderStatus='$mode', OrderPaymentStatus='notpaid', OrderStatusDate='$now'$update  WHERE BillingOrderID='".$checkOrderRS[0]['BillingOrderID']."'");
				$systemMessages = 'BillinOrderServer.doOrderPayment.err.Payment'.$orderPaymentDetails;
			}
			else
			{
				if($paymentStatus=='paid') {$orderStatus='completed';} else {$orderStatus='processing';}
				$DS->query("UPDATE BillingOrder SET OrderStatus='$orderStatus', OrderPaymentStatus='$paymentStatus', OrderStatusDate='$now', OrderPaymentDate='$now'$update  WHERE BillingOrderID='".$checkOrderRS[0]['BillingOrderID']."'");
				
				if($paymentStatus=='paid')
				{
					$BillingTransaction = new BillingTransactionServer();
					$transactionInput ['BillingTransaction'.DTR.'UserID'] = $userID;
					$transactionInput ['BillingTransaction'.DTR.'TransactionReceiverID'] = $userID;
					$transactionInput ['BillingTransaction'.DTR.'TransactionSenderID'] = $ownerID;
					$transactionInput ['BillingTransaction'.DTR.'TransactionReason'] = 'deposit';
					$transactionInput ['BillingTransaction'.DTR.'TransactionReasonDescription'] = $orderReasonDescription;					
					$transactionInput ['BillingTransaction'.DTR.'TransactionType'] = 'system';
					$transactionInput ['BillingTransaction'.DTR.'TransactionAmount'] = $orderAmount;
					$transactionInput ['BillingTransaction'.DTR.'TransactionCreator'] = $orderID;
					//if(!empty($endTime)){$transactionInput ['BillingTransaction'.DTR.'TimeEnd'] = $endTime;}
					//$transactionInput ['actionMode'] = 'save';
					//print_r($transactionInput);
					$transactionRS = $BillingTransaction->addTransaction($transactionInput);
					
					$transactionID = $transactionRS[0]['BillingTransactionID'];
					if(!empty($transactionID ))
					{
						$systemMessages = 'BillingOrderServer.doOrderPayment.msg.PaymentDone';
					}
					else
					{
						$systemMessages = 'BillingOrderServer.doOrderPayment.err.PaymentTransactionError';
					}
					$doubledMoneyMode = $config['DoubledMoneyMode'];
					if($doubledMoneyMode=='Y')
					{
						$transactionInput ['BillingTransaction'.DTR.'TransactionReason'] = 'bonus';
						$transactionRS = $BillingTransaction->addTransaction($transactionInput);			
					}				
				}
				elseif($paymentStatus=='waiting')
				{
					$systemMessages = 'BillingOrderServer.doOrderPayment.msg.PaymentRegistered';
				}
			}
		}
		
		if($redirectionMode=='redirect')
		{
			$checkOrderRS = $DS->query("SELECT BillingOrderID, UserID, OrderAmount, OrderReturnURL FROM BillingOrder WHERE BillingOrderID='$orderID' ");
			$BillingOrderID = $checkOrderRS[0]['BillingOrderID'];
			$url = $config['url'].$checkOrderRS[0]['OrderReturnURL'].'BillingOrderID/'.$BillingOrderID.'/SystemMessages/'.$systemMessages.'/';
			header("Location: $url");
			die('');			
		}
		return $retval;		
	}	
	
	function getOrderPaymentResult($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$orderID = $input['OrderID'];
		$config = $SERVER->getConfig();
		if(!empty($orderID))
		{
			$query = "SELECT * FROM BillingOrder WHERE BillingOrderID='$orderID'";
			$rs = $DS->query($query);
			if(!empty($rs[0]['OrderReturnURL']))
			{
				$url = $config['url'].$rs[0]['OrderReturnURL'];
				//echo 'url='.$url;
				header("Location: $url");
				die('');			
			}
		}
		return $rs;		
	}
	
} // end of UserSession

?>
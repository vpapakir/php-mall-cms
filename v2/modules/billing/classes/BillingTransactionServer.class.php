<?php
class BillingTransactionServer
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
	function BillingTransactionServer()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	
	// PUBLIC METHODS
	/*
		Input data:
		$input['Account'] - account id, 'main' by default
		$input['UserID'] - for admin to see user's balance
		
	*/
	function getBalance($input='')
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$user= $SERVER->getUser();
		//echo 'getBalance input <hr>';
		//print_r($input);
		//echo '<br>end getBalance input <hr>';
		$account = $input['Account'];
		if(empty($account)) {$account='main';}
		
		if(!$SERVER->hasRights('BillingTransactionServer.adminTransactions'))
		{
			$input['UserID']='';
		}
		$userID = $input['UserID'];
		if(empty($userID)){$userID = $user['UserID'];}	
		$accountFilter = '';
		
		if(!empty($userID))
		{
			if($account=='all') {$accountFilter = "";}
			elseif($account=='nobonus'){$accountFilter = " AND TransactionReceiverAccount!='bonus' ";}
			else{$accountFilter = " AND TransactionReceiverAccount='$account' ";}
			$sql = "SELECT SUM(TransactionAmount) as TransactionAmount FROM BillingTransaction WHERE TransactionReceiverID='".$userID."' $accountFilter GROUP BY TransactionReceiverID";
			$dsResult = $DS->query($sql);
			$plusAmount = $dsResult[0]['TransactionAmount'];
			//echo 'plus= '.$sql." - ".$plusAmount.'<hr>';
			if($account=='all') {$accountFilter = "";}
			elseif($account=='nobonus'){$accountFilter = " AND TransactionSenderAccount!='bonus' ";}
			else{$accountFilter = " AND TransactionSenderAccount='$account' ";}
			$sql = "SELECT SUM(TransactionAmount) as TransactionAmount FROM  BillingTransaction WHERE TransactionSenderID='".$userID."' GROUP BY TransactionSenderID";
			$dsResult = $DS->query($sql);
			$minusAmount = $dsResult[0]['TransactionAmount'];
			$balance = $plusAmount-$minusAmount;
			//echo 'minus= '.$sql." - ".$minusAmount.'<hr>';
			//echo 'balancein='.$balance.'<hr>';			
		}
		if(empty($balance)){$balance='0';}
		$retval =$balance;
		$SERVER->setDebug('BillingTransactionServer.getBalance.End','End');
		return $retval;
	}
	
	function getTransactions($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$user= $SERVER->getUser();
		$config= $SERVER->getConfig();
		$itemsPerPage = $config['ItemsPerPage'];
		//if($SERVER->hasRights('billing.Transactions.adminTransactions'))
		$userID = $input['UserID'];
		if(empty($userID)) {$userID = $user['UserID'];}
		if(!empty($input['BillingTransaction'.DTR.'TransactionCreator']))
		{
			if(empty($input['BillingTransaction'.DTR.'TransactionReason']))
			{
				$SERVER->setMessage('billing.Transactions.err.noTransactionReason');
			}
			$filter = "TransactionCreator ='".$input['BillingTransaction'.DTR.'TransactionCreator']."' AND TransactionReason='".$input['BillingTransaction'.DTR.'TransactionReason']."' ";
		}
		elseif (!empty($input['BillingTransaction'.DTR.'TransactionSenderID']))
		{
			$filter = "TransactionSenderID='".$input['BillingTransaction'.DTR.'TransactionSenderID']."'";
		}
		elseif (!empty($input['BillingTransaction'.DTR.'TransactionReceiverID']))
		{
			$filter = "TransactionReceiverID='".$input['BillingTransaction'.DTR.'TransactionReceiverID']."'";
		}
		else
		{
			$filter = "TransactionReceiverID='".$userID."' OR TransactionSenderID='".$userID."' ";
		}

		$query = "SELECT * FROM BillingTransaction WHERE $filter ORDER BY BillingTransaction.TimeCreated DESC";
		$pages = $DS->getPages('BillingTransaction',$filter,array('ItemsPerPage'=>$itemsPerPage));
		$limit = ' LIMIT '.$pages['begin'].','.$pages['step'];

		//echo $query;
		$dsResult = $DS->query($query);
		$retval['Result'] = $dsResult;
		$retval['Pages'] = $pages['pages'];
		
		$balanceIn['UserID'] = $userID;
		$retval['Balance'] = $this->getBalance($balanceIn);
		return $retval;
	}
	
	function addTransaction($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		//print_r($input);
		//echo '<br>end addTransaction input <hr>';
		if(empty($input['BillingTransaction'.DTR.'TransactionAmount']))
		{
			$SERVER->setMessage('BillingTransactionServer.addTransaction.err.NoAmount');
			return false;
		}
		if(empty($input['BillingTransaction'.DTR.'TransactionSenderAccount'])) {$input['BillingTransaction'.DTR.'TransactionSenderAccount']='main';}
		if(empty($input['BillingTransaction'.DTR.'TransactionReceiverAccount'])) {$input['BillingTransaction'.DTR.'TransactionReceiverAccount']='main';}
		if($input['BillingTransaction'.DTR.'TransactionSenderAccount']==$input['BillingTransaction'.DTR.'TransactionReceiverAccount'] && $input['BillingTransaction'.DTR.'TransactionSenderID']==$input['BillingTransaction'.DTR.'TransactionReceiverID'])
		{
			$SERVER->setMessage('BillingTransactionServer.addTransaction.err.SelfTransaction');
			return false;
		}
		if(!empty($input['BillingTransaction'.DTR.'TransactionReceiverID']) && !empty($input['BillingTransaction'.DTR.'TransactionCreator']))
		{
			//echo 'inAddTransaction3';
			//check to avoid doubled transactions
			$now = date('Y-m-d H:i:s', time());
			$query = " SELECT * FROM BillingTransaction WHERE TransactionCreator ='".$input['BillingTransaction'.DTR.'TransactionCreator']."' AND TransactionReason='".$input['BillingTransaction'.DTR.'TransactionReason']."' AND TransactionReceiverID='".$input['BillingTransaction'.DTR.'TransactionReceiverID']."' AND (TimeEnd > '$now' OR TimeEnd='0000-00-00 00:00:00')";
			//echo $query;
			$transactionsResult = $DS->query($query);		
			if(count($transactionsResult)<1)
			{
				//echo '<br>addding transaction<br/>';
				$input['actionMode']='save';
				//print_r($input);
				$where['BillingTransaction'] = "TransactionCreator = '".$input['BillingTransaction'.DTR.'TransactionCreator']."'";
				$saveResult = $DS->save($input,$where,'insert');
			}
			else
			{
				$SERVER->setMessage('BillingTransactionServer.addTransaction.err.TransactionAlreadyExists');		
			}
		}
		else
		{
			$SERVER->setMessage('BillingTransactionServer.addTransaction.err.EmptyRequiredFields');		
		}
		$retval = $saveResult;
		return $retval;
	}	

	function transferMoney($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$user = $SERVER->getUser();
		$userID = $user['UserID'];
		$input['TransferAmount'] = abs($input['TransferAmount']);
		if(empty($user['UserID']))
		{
			$SERVER->setMessage('BillingTransactionServer.transferMoney.err.NoRights');		
			$retval = $SERVER->getOutput();
			return $retval;
		}
		
		$inBalanceNoBonus['BalanceType']='nobonus';
		$balance = $this->getBalance($inBalanceNoBonus);
		$SERVER->setVars('Balance',$balance);
		if($input['actionMode']=='save')
		{
			//first of all try to find the receiver in registered users table
			$userIN['UserName'] = $input['TransferUser'];
			$usersRS = $SERVER->callService('getUserData','sessionServer',$userIN,'array');
			if(is_array($usersRS['array']['ServiceResponse']['#']['User']))
			{
				foreach ($usersRS['array']['ServiceResponse']['#']['User'] as $row)
				{
					$receiverUserID = $row['#']['UserID'][0]['#'];
				}
			}	
			if(empty($receiverUserID))
			{
				$SERVER->setMessage('BillingTransactionServer.transferMoney.err.WrongUser');
			}
			else
			{
				if($balance > $input['TransferAmount'] or $SERVER->hasRights('root'))
				{
					$endTimeStamp = time() + (60*2);//to avoid doubled transactions ... 1 transaction in 2 minutes
					$endTime = date('Y-m-d H:i:s',$endTimeStamp);
					$transactionInput ['BillingTransaction'.DTR.'UserID'] = $userID;
					$transactionInput ['BillingTransaction'.DTR.'TransactionReceiverID'] = $receiverUserID;
					$transactionInput ['BillingTransaction'.DTR.'TransactionSenderID'] = $userID;
					$transactionInput ['BillingTransaction'.DTR.'TransactionReason'] = 'transfer';
					$transactionInput ['BillingTransaction'.DTR.'TransactionReasonDescription'] = "Transfer from: ".$user['UserName']." to ".$input['TransferUser'];					
					$transactionInput ['BillingTransaction'.DTR.'TransactionType'] = 'system';
					$transactionInput ['BillingTransaction'.DTR.'TransactionAmount'] = $input['TransferAmount'];
					$transactionInput ['BillingTransaction'.DTR.'TransactionCreator'] = $userID.':'.$receiverUserID;
					$transactionInput ['BillingTransaction'.DTR.'TransactionComments'] = $input['TransferComments'];
					if(!empty($endTime)){$transactionInput ['BillingTransaction'.DTR.'TimeEnd'] = $endTime;}
					$transactionInput ['actionMode'] = 'save';
					$saveResult = $this->addTransaction($transactionInput);
					if(!empty($saveResult['sql']))
					{
						$SERVER->setVars('TransferResult','OK');
						$balance = $this->getBalance();
						$SERVER->setVars('Balance',$balance);						
					}
					else
					{
						$SERVER->setMessage('BillingTransactionServer.transferMoney.err.TimeLimit');
					}
				}
				else
				{
					$SERVER->setMessage('BillingTransactionServer.transferMoney.err.NoMoney');					
				}
			}
		}
		$retval = $saveResult['xml'];
		return $retval;
	}	


	function doBillingPayment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		if(!$SERVER->hasRights('user'))
		{
			$SERVER->setMessage('BillingTransactionServer.doBillingPayment.err.NoRights');
			return false;
		}		
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;

		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$BillingOrderID = $input['BillingOrderID'];
		$billingOrderRS = $DS->query("SELECT BillingOrderID, UserID, OrderAmount, OrderReturnURL, OrderPaymentStatus FROM BillingOrder WHERE BillingOrderID='$BillingOrderID' ");
		$billingOrderPaymentStatus = $billingOrderRS[0]['OrderPaymentStatus'];
		
		//print_r($billingOrderRS);
		$orderAmount = $billingOrderRS[0]['OrderAmount'];
		$userID = $billingOrderRS[0]['UserID'];

		$transactionReason = $input['Reason'];
		$input['TransactionCreator'] = $BillingOrderID;
		$transactionCreator = $input['TransactionCreator'];
		$account = 'main';
		//set filters
		//$filter = $DS->getAccessFilter($input,'ServiceServer.adminService');
		//set queries
		$query ='';
		//echo 'ttttt';
		if(!empty($orderAmount))
		{
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
				$resultBalance=$balance-$orderAmount;
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
					$endTimeSTP = time() + 3;
					$endTime = date('Y-m-d H:i:s',$endTimeSTP);
					$transactionInput ['BillingTransaction'.DTR.'UserID'] = $userID;
					$transactionInput ['BillingTransaction'.DTR.'TransactionReceiverID'] = $ownerID;
					$transactionInput ['BillingTransaction'.DTR.'TransactionSenderID'] = $userID;
					$transactionInput ['BillingTransaction'.DTR.'TransactionReason'] = 'buy';
					$transactionInput ['BillingTransaction'.DTR.'TransactionReasonDescription'] = $SERVER->getValue($rs[0]['ServiceTitle']).':'.$transactionReason;					
					$transactionInput ['BillingTransaction'.DTR.'TransactionType'] = 'system';
					$transactionInput ['BillingTransaction'.DTR.'TransactionAmount'] = $orderAmount;
					$transactionInput ['BillingTransaction'.DTR.'TransactionCreator'] = $transactionCreator;
					if(!empty($endTime)){$transactionInput ['BillingTransaction'.DTR.'TimeEnd'] = $endTime;}
					$transactionInput ['actionMode'] = 'save';
					//print_r($transactionInput);
					$addTransactionResult = $BillingTransaction->addTransaction($transactionInput);
					//print_r($addTransactionResult['array']);
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
						$result['TransactionID']=$transactionIDRS;
						$result['PaymentTimeEnd']=$endTime;
						if($config['PromoMode']=='active')
						{
							if($balanceNoBonus>=$orderAmount)
							{
								$promoInput ['PromoReferralUser'] = $userID;
								$promoInput ['PromoReferralSession'] = $input['XCMSPromoCode'];
								$promoInput ['PromoReferralIP'] = $input['RemoteIP'];
								$promoInput ['PromoResource'] = $config['ApplicationDomain'];
								$promoInput ['PromoReferralAction'] = 'pay';
								$promoInput ['PromoReferralActionDetails'] = $transactionInput ['BillingTransaction'.DTR.'TransactionReasonDescription'];
								$promoInput ['PromoReferralAmount'] = $orderAmount;		
								$promoInput ['TransactionKey'] = $input['ResourceID'];
								$promoResult = $SERVER->callService('setReferralAction','promoServer',$promoInput);
							}
						}							
					}
					$result['Balance']=$resultBalance;
				}
				else
				{
					$SERVER->setMessage('BillingTransactionServer.doBillingPayment.err.NoMoney');
					$result['PaymentResult']='NoMoney';
					$result['Balance']=$balance;
				}
			}
			else
			{
				$SERVER->setMessage('BillingTransactionServer.doBillingPayment.err.NoTransactionCreator');					
			}
		}
		else //if(!empty($filter))
		{
			$SERVER->setMessage('BillingTransactionServer.doBillingPayment.err.NoAmount');
		}

		return $result;		
	}

} // end of BillingTransactionServer

?>
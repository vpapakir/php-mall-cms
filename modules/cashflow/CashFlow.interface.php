<?php

function manageCashFlowBills()
{ 
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$manageMode = $input['manageMode'];
	$clientType = $config['ClientType'];
	$entityID = $input['CashFlowBillID'];
	$CashFlowBillObject = new CashFlowBillClass();
	$CashFlowCompanyObject = new CashFlowCompanyClass();
	$CashFlowAccountObject = new CashFlowAccountClass();
	//$sectionsObject = new ResourceCategoryClass();
	//$section = new CashFlowBillClass();
	//delete item
	if($input['actionMode']=='delete')
	{
		$CashFlowBillObject->deleteCashFlowBill($input);
	}
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['CashFlowBill'.DTR.'CashFlowBillID']))
		{
			foreach($input['CashFlowBill'.DTR.'CashFlowBillID'] as $id=>$value)
			{
				if($input['CashFlowBill'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['CashFlowBill'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['CashFlowBill'.DTR.'PermAll'] = 1;
				}			
				$inputSave['CashFlowBill'.DTR.'CashFlowBillID'] = $input['CashFlowBill'.DTR.'CashFlowBillID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['CashFlowBill'] = "CashFlowBillID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['CashFlowBill'.DTR.'CashFlowBillID'].' perm='.$inputSave['CashFlowBill'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);			
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
			
		if(!empty($uploadRS['CashFlowBillImage']['preview']))
		{
			$input['CashFlowBill'.DTR.'CashFlowBillImage']= $uploadRS['CashFlowBillImage']['preview'];
		}
		//print_r($input);
		$saveRS = $CashFlowBillObject->setCashFlowBill($input);			
		$CORE->setInputVar('actionMode','add1');
		//$entityID = $saveRS[0]['CashFlowBillID'];
		//$input['CashFlowBill'.DTR.'CashFlowBillID'] = $entityID;			
	}		
	//get 1 item details
	if(!empty($entityID))
	{
		$commentRS = $CashFlowBillObject->getCashFlowBill($input);
		$result['DB']['CashFlowBill'] = $commentRS;
	}	
	
	$result['DB']['CashFlowBills'] = $CashFlowBillObject->getCashFlowBills($input);
	
	$result['DB']['CashFlowAccounts'] = $CashFlowAccountObject->getCashFlowAccounts($input);
	$result['DB']['Companies'] = $CashFlowCompanyObject->getCashFlowCompanies($input);
	
	$entityRS = $CashFlowBillObject->getSumCashFlowBills($input);
	$result['DB']['Overall'] = $entityRS[0];
	
	return $result;
}

function manageCashFlowAccounts()
{ 
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$manageMode = $input['manageMode'];
	$clientType = $config['ClientType'];
	$entityID = $input['CashFlowAccountID'];
	$CashFlowAccountObject = new CashFlowAccountClass();
	$CashFlowCompanyObject = new CashFlowCompanyClass();
	$CashFlowBillObject = new CashFlowBillClass();
	//$sectionsObject = new ResourceCategoryClass();
	//$section = new CashFlowAccountClass();
	//delete item
	if($input['actionMode']=='delete')
	{
		$CashFlowAccountObject->deleteCashFlowAccount($input);
	}
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['CashFlowAccount'.DTR.'CashFlowAccountID']))
		{
			foreach($input['CashFlowAccount'.DTR.'CashFlowAccountID'] as $id=>$value)
			{
				if($input['CashFlowAccount'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['CashFlowAccount'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['CashFlowAccount'.DTR.'PermAll'] = 1;
				}			
				$inputSave['CashFlowAccount'.DTR.'CashFlowAccountID'] = $input['CashFlowAccount'.DTR.'CashFlowAccountID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['CashFlowAccount'] = "CashFlowAccountID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['CashFlowAccount'.DTR.'CashFlowAccountID'].' perm='.$inputSave['CashFlowAccount'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);			
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
			
		if(!empty($uploadRS['CashFlowAccountImage']['preview']))
		{
			$input['CashFlowAccount'.DTR.'CashFlowAccountImage']= $uploadRS['CashFlowAccountImage']['preview'];
		}
		$saveRS = $CashFlowAccountObject->setCashFlowAccount($input);			
		$CORE->setInputVar('actionMode','add1');
		//$entityID = $saveRS[0]['CashFlowAccountID'];
		//$input['CashFlowAccount'.DTR.'CashFlowAccountID'] = $entityID;			
	}		
	//get 1 item details
	if(!empty($entityID))
	{
		$commentRS = $CashFlowAccountObject->getCashFlowAccount($input);
		$result['DB']['CashFlowAccount'] = $commentRS;
	}	
	
	$entityRS = $CashFlowAccountObject->getCashFlowAccounts($input);
	$result['DB']['CashFlowAccounts'] = $entityRS;
	
	$result['DB']['Companies'] = $CashFlowCompanyObject->getCashFlowCompanies($input);
	
	$entityRS = $CashFlowBillObject->getSumCashFlowBills($input);
	$result['DB']['Overall'] = $entityRS[0];
	//print_r($result['DB']['Overall']);
	return $result;
}

function manageCashFlowCompany()
{ 
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$manageMode = $input['manageMode'];
	$clientType = $config['ClientType'];
	$entityID = $input['CashFlowCompanyID'];
	if(empty($entityID)){$entityID = $input['CashFlowCompany'];}
	
	$CashFlowAccountObject = new CashFlowAccountClass();
	$CashFlowCompanyObject = new CashFlowCompanyClass();
	$CashFlowBillObject = new CashFlowBillClass();
	//$sectionsObject = new ResourceCategoryClass();
	//$section = new CashFlowCompanyClass();
	//delete item
	if($input['actionMode']=='delete1')
	{
		$CashFlowCompanyObject->deleteCashFlowCompany($input);
	}
	elseif($input['actionMode']=='add1' || $input['actionMode']=='save1')
	{
		$saveRS = $CashFlowCompanyObject->setCashFlowCompany($input);			
		$entityID = $saveRS[0]['CashFlowCompanyID'];
		$input['CashFlowCompany'.DTR.'CashFlowCompanyID'] = $entityID;			
	}		
	//get 1 item details
	if(!empty($entityID))
	{
		$commentRS = $CashFlowCompanyObject->getCashFlowCompany($input);
		$result['DB']['CashFlowCompany'] = $commentRS;
	}	
	
	$input['Groups'] = 'root,admin';
	$CORE->setInputVar('Groups','root,admin');
	$userRS = $CORE->callService('getUsersByGroup','sessionServer');
	$result['DB']['Users'] = $userRS['DB']['Users']; 
	$result['DB']['UserGroups'] = $userRS['DB']['UserGroups']; 
	$result['DB']['Companies'] = $CashFlowCompanyObject->getCashFlowCompanies($input);
	
	$entityRS = $CashFlowAccountObject->getCashFlowAccounts($input);
	$result['DB']['CashFlowAccounts'] = $entityRS;
	
	return $result;
}

?>
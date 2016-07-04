<?php
//Section entity WebService public methods
$SERVER_SOAP->register('synchronizationServer');
function synchronizationServer($input='')
{
	global $CORE;
	//get input
	if(empty($input))
	{
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$service = $input['SynchronizationService'];
	$method = $input['SynchronizationMethod'];
	$in =  $input['Fields'];
	$result = $CORE->callService($method,$service,$in);
	return $result;
}

function synchronizationManager($input='')
{
	global $CORE;
	//get input
	if(empty($input))
	{
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$entityID = $input['OwnerID'];
	if($input['actionMode']=='delete')
	{
		if(!empty($input['SynchronizationItem'.DTR.'SynchronizationItemID']))
		{
			$DS->query("DELETE FROM SynchronizationItem WHERE SynchronizationItemID='".$input['SynchronizationItem'.DTR.'SynchronizationItemID']."'");
		}
	}	
	elseif($input['actionMode']=='cleandatabase')
	{
		if($user['UserName']=='superadmin')
		{
			synchronizationSuperAdminDatabaseClean();
		}
	}		
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
		if(is_array($input['SynchronizationItem'.DTR.'SynchronizationItemID']))
		{
			foreach($input['SynchronizationItem'.DTR.'SynchronizationItemID'] as $id=>$value)
			{
				if($input['SynchronizationItem'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['SynchronizationItem'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['SynchronizationItem'.DTR.'PermAll'] = 1;
				}
				$inputSave['SynchronizationItem'.DTR.'SynchronizationItemID'] = $input['SynchronizationItem'.DTR.'SynchronizationItemID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['SynchronizationItem'] = "SynchronizationItemID='".$value."'";
				$DS->save($inputSave,$whereSave);	
			}	
		}	
	}

	//scynhronize boxes
	$boxes = $CORE->getBoxesDefinition();
	if(is_array($boxes))
	{
		$inputSave = '';
		foreach($boxes as $code=>$boxInfo)
		{
			if($boxInfo['type']=='synchronization')
			{
				if(!empty($code))
				{
					$rs = $DS->query("SELECT SynchronizationItemBox FROM SynchronizationItem WHERE SynchronizationItemBox='".$code."' ");
					if(empty($rs[0]['SynchronizationItemBox']))
					{
						$inputSave['actionMode']='save';
						$inputSave['SynchronizationItem'.DTR.'SynchronizationItemBox'] = $code;
						$inputSave['SynchronizationItem'.DTR.'SynchronizationItemName'] = addslashes($boxInfo['name']);
						$inputSave['SynchronizationItem'.DTR.'SynchronizationItemType'] = 'all';
						$inputSave['SynchronizationItem'.DTR.'SynchronizationItemStatus'] = 'old';
						$inputSave['SynchronizationItem'.DTR.'SynchronizationItemLastTime'] = $CORE->getNow();
						$inputSave['SynchronizationItem'.DTR.'PermAll'] = '1';
						$where1['SynchronizationItem'] = "SynchronizationItemID=''";
						$saveResult = $DS->save($inputSave,$where1);
					}
				}
			}
		}
	}

	//if(empty($input['actionMode']))
	//{
		$rs = $DS->query("SELECT * FROM SynchronizationItem WHERE PermAll='1' ");
		if(is_array($rs))
		{
			foreach($rs as $row)
			{
				$synchroBoxID = $row['SynchronizationItemBox'];
				$boxToGo = $boxes[$synchroBoxID];
				$in['LastTime'] = $row['SynchronizationItemLastTime'];
				$in['SynchronizationType'] = $input['SynchronizationType'];
				$callRS = $CORE->callService($boxToGo['method'].'CheckStatus',$boxToGo['module'].'Server',$in);
				//print_r($callRS);
				if(!empty($callRS['Result']))
				{
					if($callRS['Result']=='N')
					{
						$inputSave['SynchronizationItem'.DTR.'SynchronizationItemStatus'] = 'ok';
					}			
					else
					{
						$inputSave['SynchronizationItem'.DTR.'SynchronizationItemStatus'] = 'old';
					}
					$itemID = $row['SynchronizationItemID'];
					if(!empty($itemID))
					{
						$DS = new DataSource('main');
						$inputSave['actionMode']='save';
						$inputSave['SynchronizationItem'.DTR.'SynchronizationItemID'] = $itemID;
						$where['SynchronizationItem'] = "SynchronizationItemID='".$itemID."'";
						$DS->save($inputSave,$where);	
					}
				}
			}		
		}
	//}

	$result['DB']['SynchronizationItems'] = $DS->query("SELECT * FROM SynchronizationItem");


	if($input['actionMode']=='synchronize')
	{
		$synchroBoxID = $input['synchroBoxID'];
		if(!empty($synchroBoxID))
		{
			$boxToGo = $boxes[$synchroBoxID];
			$in['LastTime'] = $row['SynchronizationItemLastTime'];
			$in['SynchronizationType'] = $input['SynchronizationType'];
			$callRS = $CORE->callService($boxToGo['method'],$boxToGo['module'].'Server',$in);
			$result['Results'][$synchroBoxID] = $callRS;
			if($callRS['Result']=='Y')
			{
				updateSynchronizationItem($row['SynchronizationItemID']);
			}
		}
		else
		{
			if(is_array($result['DB']['SynchronizationItems']))
			{
				foreach($result['DB']['SynchronizationItems'] as $row)
				{
					if($row['PermAll']=='1')
					{
						$synchroBoxID = $row['SynchronizationItemBox'];
						$boxToGo = $boxes[$synchroBoxID];
						$in['LastTime'] = $row['SynchronizationItemLastTime'];
						$in['SynchronizationType'] = $input['SynchronizationType'];
						$callRS = $CORE->callService($boxToGo['method'],$boxToGo['module'].'Server',$in);
						if($callRS['Result']=='Y')
						{
							updateSynchronizationItem($row['SynchronizationItemID']);
						}					
						$result['Results'][$synchroBoxID]['Result'] = $callRS;
						$result['Results'][$synchroBoxID]['Name'] = $row['SynchronizationItemName'];
					}
				}
			}
		}
		
		$result['DB']['SynchronizationItems'] = $DS->query("SELECT * FROM SynchronizationItem");
	}

	
	//print_r($result);
	return $result;
}

function updateSynchronizationItem($itemID)
{
	global $CORE;
	
	if(!empty($itemID))
	{
		$DS = new DataSource('main');
		$inputSave['actionMode']='save';
		$inputSave['SynchronizationItem'.DTR.'SynchronizationItemID'] = $itemID;
		$inputSave['SynchronizationItem'.DTR.'SynchronizationItemLastTime'] = $CORE->getNow();
		$inputSave['SynchronizationItem'.DTR.'SynchronizationItemStatus'] = 'ok';
		$where['SynchronizationItem'] = "SynchronizationItemID='".$itemID."'";
		$saveResult = $DS->save($inputSave,$where);	
	}
}

function synchronizationSuperAdminDatabaseClean()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	
	if($user['UserName']=='superadmin')
	{
		$tables[] = 'ResourceComment';
		$tables[] = 'Resource';
		$tables[] = 'ResourceAuthor';
		$tables[] = 'ResourceBid';
		$tables[] = 'ResourceBidItem';
		$tables[] = 'ResourceCategory';
		$tables[] = 'ResourceCategoryStat';
		$tables[] = 'ResourceComment';
		$tables[] = 'ResourceFavorite';
		$tables[] = 'ResourceField';
		$tables[] = 'ResourceLink';
		$tables[] = 'ResourceOption';
		$tables[] = 'ResourceOrder';
		$tables[] = 'ResourceOrderItem';
		$tables[] = 'ResourceOrderItemField';
		$tables[] = 'ResourceRelation';
		$tables[] = 'Property';
		$tables[] = 'PropertyComment';
		$tables[] = 'PropertyFavorite';
		$tables[] = 'PropertyField';
		$tables[] = 'PropertyOption';
		$tables[] = 'PropertyOrder';
		$tables[] = 'PropertyOrderItem';
		$tables[] = 'PropertyOrderItemField';
		$tables[] = 'PropertyRelation';
		$tables[] = 'PropertyResource';
		$tables[] = 'Service';
		$tables[] = 'ServiceCategory';
		$tables[] = 'Banner';
		$tables[] = 'BillingOrder';
		$tables[] = 'BillingTransaction';
		$tables[] = 'Blog';
		$tables[] = 'BlogRecord';
		$tables[] = 'Cache';
		$tables[] = 'CartItem';
		$tables[] = 'CartItemField';
		$tables[] = 'Mail';
		$tables[] = 'MailLog';
		$tables[] = 'Message';
		$tables[] = 'MessageAttachment';
		$tables[] = 'Newsletter';
		$tables[] = 'NewsletterList';
		$tables[] = 'NewsletterSubscriber';
		$tables[] = 'Tour';
		$tables[] = 'TourCategory';
		$tables[] = 'TourComment';
		$tables[] = 'TourField';
		$tables[] = 'TourLink';
		$tables[] = 'TourOption';
		$tables[] = 'ComboardMessage';
		$tables[] = 'CashFlowAccount';
		$tables[] = 'CashFlowBill';
		$tables[] = 'CashFlowCompany';
		$tables[] = 'Domain';
		$tables[] = 'DomainField';
		$tables[] = 'DomainOption';
		$tables[] = 'DomainType';
		$tables[] = 'DomainTypeField';
		$tables[] = 'DomainTypeOption';
		
		foreach($tables as $table)
		{
			$DS->query("DELETE FROM ".$table);
		}
		
		 $DS->query("UPDATE Section Set SectionDescription = '', SectionDescription = '' WHERE  SectionType ='front' ");
		
	}
}
?>
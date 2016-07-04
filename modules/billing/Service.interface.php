<?php
function manageServices()
{ 
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$categoryID = $input['CategoryID'];
	$clientType = $config['ClientType'];
	//if(empty($categoryID)){$categoryID=1;}
	$entityID = $input['ServiceID'];
	if(empty($entityID)){$entityID = $input['Service'.DTR.'ServiceID'];}
	
	$ServiceCategory = new ServiceCategoryClass();
	$serviceObject = new ServiceClass();

	//delete item
	if($input['actionMode']=='delete')
	{
		$serviceObject->deleteService($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['ServiceID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Service WHERE ServiceID='".$input['ServiceID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE Service SET ".$fileField."='' WHERE ServiceID='".$input['ServiceID']."'");
			}
		}
	}	
	elseif($input['actionMode']=='save')
	{
		//update list of items
	    if(is_array($input['Service'.DTR.'ServiceID']))
		{
			foreach($input['Service'.DTR.'ServiceID'] as $id=>$value)
			{
				$updateCats='N';
				if($clientType=='admin')
				{
					if($input['Service'.DTR.'PermAll'][$id]!='1')
					{
						$inputSave['Service'.DTR.'PermAll'] = 4;
					}
					else
					{
						$inputSave['Service'.DTR.'PermAll'] = 1;
					}
					$oldRS = $DS->query("SELECT PermAll FROM Service WHERE ServiceID='".$input['Service'.DTR.'ServiceID'][$id]."'");
					if($oldRS[0]['PermAll']!=$inputSave['Resource'.DTR.'PermAll']) {$updateCats='Y';}
				}
				else
				{
					if($input['Service'.DTR.'ServiceStatus'][$id]!='active')
					{
						$inputSave['Service'.DTR.'ServiceStatus'] = 'hidden';
					}
					else
					{
						$inputSave['Service'.DTR.'ServiceStatus'] = 'active';
					}	
					$oldRS = $DS->query("SELECT ServiceStatus FROM Service WHERE ServiceID='".$input['Service'.DTR.'ServiceID'][$id]."'");
					if($oldRS[0]['ServiceStatus']!=$inputSave['Service'.DTR.'ServiceStatus']) {$updateCats='Y';}
				}			
				$inputSave['Service'.DTR.'ServiceID'] = $input['Service'.DTR.'ServiceID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['Service'] = "ServiceID='".$value."'";

				$DS->save($inputSave,$whereSave);
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save1')
	{
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		
		if(!empty($uploadRS['ServiceIcon']['file']))
		{
			$input['Service'.DTR.'ServiceIcon']= $uploadRS['ServiceIcon']['icon'];
		}	
		//$CORE->setConfigVar($config['UseImagePreview'],'N');	
		$serviceObject->setService($input);
		
		if($input['actionMode']=='add')
		{
			$entityID = $DS->dbLastID();	
			$input['Service'.DTR.'ServiceID'] = $entityID;		
		}			
		//$serviceObject->setServiceField($input,$uploadRS);	
	}		
	//get 1 item details
	if(!empty($entityID))
	{
		$ServiceRS = $serviceObject->getService($input);
		$result['DB']['Service'] = $ServiceRS;
	}	
	
	
	
	if(!empty($input['CategoryID']))
	{
		$categoryID = $input['CategoryID'];
		
		$ServicesRS = $serviceObject->getServices($input);
		//$ServicesRS = $DS->query("SELECT * FROM Service WHERE  ServiceCategories LIKE '%|$categoryID|%'");
		$result['DB']['Services'] = $ServicesRS['result'];
	}
	
	$input['treeType']='all';
	$input['downLevels']='all';
	//$input['ServiceCategoryGroup'] = $groupID;
	$entityRS = $ServiceCategory->getServiceCategoriesTree($input);

	$k=1;		
	foreach($entityRS as $id=>$row)
	{
		if($lastLevel != $row['ServiceCategoryLevel'])
		{
			$lastLevel = $row['ServiceCategoryLevel'];
			$treeString='';
			if($row['ServiceCategoryLevel']!=1)
			{
				for($i=2;$i<=$row['ServiceCategoryLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
			}
		}
		if($row['ServiceCategoryID']!=$input['ServiceCategoryID'])
		{
			$inputValues[$k]['id']=$row['ServiceCategoryID'];	
			$inputValues[$k]['value']=$treeString.getValue($row['ServiceCategoryTitle']);
			$k++;		
		}
		//echo 'i= '.$i.' id= '.$row['ResourceCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
	}
	
	$result['DB']['ServiceCategories'] = $inputValues;
		
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;

	//return result array
	return $result;
}
?>
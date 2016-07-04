<?php
function manageResourceLinks()
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
	$entityID = $input['ResourceLinkID'];
	$ResourceLinkObject = new ResourceLinkClass();
	//$section = new ResourceLinkClass();
	//delete item
	if($input['actionMode']=='delete')
	{
		$ResourceLinkObject->deleteResourceLink($input);
		//$ResourceLinkType->deleteResourceLinkField($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['ResourceLinkID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ResourceLink WHERE ResourceLinkID='".$input['ResourceLinkID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE ResourceLink SET ".$fileField."='' WHERE ResourceLinkID='".$input['ResourceLinkID']."'");
			}
		}
	}	
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['ResourceLink'.DTR.'ResourceLinkID']))
		{
			foreach($input['ResourceLink'.DTR.'ResourceLinkID'] as $id=>$value)
			{
				if($input['ResourceLink'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['ResourceLink'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['ResourceLink'.DTR.'PermAll'] = 1;
				}			
				$inputSave['ResourceLink'.DTR.'ResourceLinkID'] = $input['ResourceLink'.DTR.'ResourceLinkID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['ResourceLink'] = "ResourceLinkID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['ResourceLink'.DTR.'ResourceLinkID'].' perm='.$inputSave['ResourceLink'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);			
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{
		$saveRS = $ResourceLinkObject->setResourceLink($input);			
		$entityID = $saveRS[0]['ResourceLinkID'];
		$input['ResourceLink'.DTR.'ResourceLinkID'] = $entityID;			
	}		
	//get 1 item details
	if(!empty($entityID))
	{
		$commentRS = $ResourceLinkObject->getResourceLink($input);
		$result['DB']['ResourceLink'] = $commentRS;
	}	
	if(!empty($commentRS[0]['ResourceID']))
	{
		$resourceObject = new ResourceClass();
		$inputResource['ResourceID']=$commentRS[0]['ResourceID'];
		$rs = $resourceObject->getResource($inputResource);
		$result['DB']['Resource'] = $rs;
	}

	if($clientType=='admin' || $manageMode=='user')
	{		
		//get ResourceLinks 
		
		$oldTimeStmap = time()-4*24*60*60;
		$DS->query("DELETE FROM ResourceLink WHERE PermAll=4 AND TimeCreated<'".date("Y-m-d",$oldTimeStmap)."'");
		
		$entityRS = $ResourceLinkObject->getResourceLinks($input);
		$result['DB']['ResourceLinks'] = $entityRS;
	}
	
	if($clientType=='admin')
	{		
		//get categories reference
		$input['treeType']='all';
		$input['downLevels']='all';
		$categoriesRS = getResourceCategoriesTree();
		$result['DB']['ResourceCategories'] = $categoriesRS['DB']['ResourceCategoriesList'];
	
		$input['treeType']='all';
		$input['downLevels']='all';
		//$input['SectionGroupCode'] = 'main';
		$input['SectionType'] = 'front';
		$sectionsRS = $CORE->callService('getSectionsTreeList','coreServer',$input);
		$result['DB']['SectionsList'] = $sectionsRS['DB']['SectionsList'];
	}
	//return result array
	return $result;
}

function getResourceLinks()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects
	$ResourceLinkObject = new ResourceLinkClass();
	$result['DB']['ResourceLinks'] = $ResourceLinkObject->getResourceLinks($input);
	
	$sectionsObject = new ResourceCategoryClass();
	//get categories reference
	$input['treeType']='all';
	$input['downLevels']='all';
	$categoriesRS = $sectionsObject->getResourceCategoriesTree($input);
	
	//$inputValues[0]['id']='';	
	//$inputValues[0]['value']=lang('-top');	
	$k=1;		
	if(is_array($categoriesRS))
	{
		foreach($categoriesRS as $id=>$row)
		{
			if($lastLevel != $row['ResourceCategoryLevel'])
			{
				$lastLevel = $row['ResourceCategoryLevel'];
				$treeString='';
				if($row['ResourceCategoryLevel']!=1)
				{
					for($i=2;$i<=$row['ResourceCategoryLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
				}
			}
			if($row['ResourceCategoryID']!=$input['ResourceCategoryID'])
			{
				$inputValues[$k]['id']=$row['ResourceCategoryID'];	
				$inputValues[$k]['value']=$treeString.getValue($row['ResourceCategoryTitle']);
				$k++;		
			}
			//echo 'i= '.$i.' id= '.$row['ResourceCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
		}
	}
	$result['DB']['ResourceCategories'] = $inputValues;
	return $result;
}

function getResourceLink()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$ResourceLinkObject = new ResourceLinkClass();
	
	$rs = $ResourceLinkObject->getResourceLink($input);
	$result['DB']['ResourceLink'] = $rs[0];
		
	return $result;
}

?>
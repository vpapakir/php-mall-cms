<?php
function manageResourceRelations()
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
	$resourceID = $input['ResourceID'];
	$resourceRelatedID = $input['ResourceRelatedID'];
	$actionMode = $input['actionMode'];
	
	$ResourceRelationObject = new ResourceRelationClass();
	$sectionsObject = new ResourceCategoryClass();	
	$resourceTypeObject = new ResourceTypeClass();	
	//$section = new ResourceRelationClass();
	//delete item
	if($input['actionMode']=='addrelated')
	{
		//update list of items
	    if(is_array($input['ResourceRelatedID']))
		{
			foreach($input['ResourceRelatedID'] as $id=>$value)
			{
				$inputSave['ResourceRelatedID'] = $value;
				$inputSave['ResourceID'] = $resourceID;
				$ResourceRelationObject->setResourceRelation($inputSave);
			}	
		}
		else
		{
			$ResourceRelationObject->setResourceRelation($input);
		}
	}	
	//get 1 item details

	if($actionMode=='search' || $actionMode=='addrelated')
	{
		$resourcesRS = $ResourceRelationObject->searchResourceRelations($input);
		$result['DB']['Resources'] = $resourcesRS;
	}	
	
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
	
	$result['DB']['ResourceTypes']= $resourceTypeObject->getResourceTypes($input);	
	//return result array
	return $result;
}

function getResourceRelations()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects
	$ResourceRelationObject = new ResourceRelationClass();
	$result['DB']['ResourceRelations'] = $ResourceRelationObject->getResourceRelations($input);
	
	//$sectionsObject = new ResourceCategoryClass();
	//get categories reference
	//$input['treeType']='all';
	//$input['downLevels']='all';
	//$categoriesRS = $sectionsObject->getResourceCategoriesTree($input);
	
	return $result;
}

function getResourceRelation()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$resourceObject = new ResourceClass();
	$input['ResourceID']=$input['RelatedResourceID'];
	$rs = $resourceObject->getResource($input);
	$result['DB']['Resource'] = $rs[0];
	$input['ResourceType'] = $rs[0]['ResourceType'];
	if(!empty($input['ResourceType']))
	{
		$input['viewMode']='viewresource';
		$fieldsRS = $resourceObject->getResourceFields($input);
		$result['DB']['ResourceFieldTypes'] = $fieldsRS['ResourceFieldTypes'];
		$result['DB']['ResourceField'] = $fieldsRS['ResourceField'];
		$result['DB']['ResourceOption'] = $fieldsRS['ResourceOption'];
	}
	
	$resourceCategory = new ResourceCategoryClass();
	$CORE->setInputVar('ResourceType',$rs[0]['ResourceType']);	
	$CORE->setInputVar('type',$rs[0]['ResourceType']);
	//$typesRS = $resourceCategory->getResourceCategoryTypes($input);	
	//$result['DB']['ResourceCategoryTypes'] = $typesRS;		
	
	//print_r($result);	
	return $result;
}


?>
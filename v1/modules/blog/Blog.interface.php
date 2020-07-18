<?php

function manageBlog()
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
	$entityID = $input['BlogID'];
	$BlogObject = new BlogClass();
	$BlogRecordObject = new BlogRecordClass();
	//$sectionsObject = new ResourceCategoryClass();
	//$section = new BlogClass();
	//delete item
	
	
	
	//echo "PRIHODIT='".$input['actionMode']."'PRIHODIT";
	
	
	
	
	if($input['actionMode']=='delete')
	{
		if(!empty($input['BlogRecord'.DTR.'BlogRecordID']))
		{
			$BlogRecordObject->deleteBlogRecord($input);
		}
		else{
				$BlogObject->deleteBlog($input);
			}
		//$BlogType->deleteBlogField($input);
	}
	
	elseif($input['actionMode']=='deletefile' ||  $user['UserId']  )
	{
			
		if(!empty($input['Blog'.DTR.'BlogID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Blog WHERE BlogID='".$input['Blog'.DTR.'BlogID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]) ||  $fileFieldRS[0][$fileField] )
			{
				$DS->query("UPDATE Blog SET ".$fileField."='' WHERE BlogID='".$input['Blog'.DTR.'BlogID']."'");
			}
		}
			elseif(!empty($input['BlogRecord'.DTR.'BlogRecordID']) && !empty($input['fileField']))
			{
					
					$FM = new FilesManager();
					$fileField =$input['fileField'];
					$fileFieldRS = $DS->query("SELECT ".$fileField." FROM BlogRecord WHERE BlogRecordID='".$input['BlogRecord'.DTR.'BlogRecordID']."'");
					if($FM->deleteFile($fileFieldRS[0][$fileField]) || $fileFieldRS[0][$fileField])
					{
						$DS->query("UPDATE BlogRecord SET ".$fileField."='' WHERE BlogRecordID='".$input['BlogRecord'.DTR.'BlogRecordID']."'");
					}
			}
	}	
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['Blog'.DTR.'BlogID']))
		{
			foreach($input['Blog'.DTR.'BlogID'] as $id=>$value)
			{
				if($input['Blog'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['Blog'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['Blog'.DTR.'PermAll'] = 1;
				}			
				$inputSave['Blog'.DTR.'BlogID'] = $input['Blog'.DTR.'BlogID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['Blog'] = "BlogID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['Blog'.DTR.'BlogID'].' perm='.$inputSave['Blog'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);			
			}	
		}
		elseif(is_array($input['BlogRecord'.DTR.'BlogRecordID']))
			{
				foreach($input['BlogRecord'.DTR.'BlogRecordID'] as $id=>$value)
				{
					if($input['BlogRecord'.DTR.'PermAll'][$id]!='1')
					{
						$inputSave['BlogRecord'.DTR.'PermAll'] = 4;
					}
					else
					{
						$inputSave['BlogRecord'.DTR.'PermAll'] = 1;
					}			
					$inputSave['BlogRecord'.DTR.'BlogRecordID'] = $input['BlogRecord'.DTR.'BlogRecordID'][$id];
					$inputSave['actionMode']='save';
					$whereSave['BlogRecord'] = "BlogRecordID='".$value."'";
					//echo 'id='.$id. ' sid='.$inputSave['Blog'.DTR.'BlogID'].' perm='.$inputSave['Blog'.DTR.'PermAll'].'<hr>' ;
					$DS->save($inputSave,$whereSave);			
				}
			}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{
		if(!empty($input['BlogRecord'.DTR.'BlogRecordTitle']))
		{
			$FM = new FilesManager();
			$uploadRS = $FM->uploadFile();
			
			if(!empty($uploadRS['BlogRecordImage']['preview']))
			{
				$input['BlogRecord'.DTR.'BlogRecordImage']= $uploadRS['BlogRecordImage']['preview'];
			}
			
			/*$FM = new FilesManager();
			$input = $FM->getUploadedFields($input,'BlogRecord',array('previewFieldName'=>'BlogRecordImagePreview','fullFieldName'=>'BlogRecordImage'));
			*/
			$saveRS = $BlogRecordObject->setBlogRecord($input);			
			$entityID = $saveRS[0]['BlogRecordID'];
			$input['BlogRecord'.DTR.'BlogRecordID'] = $entityID;
		}else
			{
				/*$FM = new FilesManager();
				$input = $FM->getUploadedFields($input,'Blog',array('previewFieldName'=>'BlogImagePreview','fullFieldName'=>'BlogImage'));
				*/
				$FM = new FilesManager();
				$uploadRS = $FM->uploadFile();
			
				if(!empty($uploadRS['BlogImage']['preview']))
				{
					$input['Blog'.DTR.'BlogImage']= $uploadRS['BlogImage']['preview'];
				}
				$saveRS = $BlogObject->setBlog($input);			
				$entityID = $saveRS[0]['BlogID'];
				$input['Blog'.DTR.'BlogID'] = $entityID;			
			}
	}		
	//get 1 item details
	//if(!empty($entityID))
	//{
		$commentRS = $BlogObject->getBlog($input);
		$result['DB']['Blog'] = $commentRS;
		
		if(!empty($input['BlogRecordID']) || $input['BlogRecord'.DTR.'BlogRecordID'])
		{
			//get BlogRecords 
			$BlogRecordRS = $BlogRecordObject->getBlogRecord($input);
			$result['DB']['BlogRecord'] = $BlogRecordRS;
		}
		//get BlogRecords 
		$BlogRecordsRS = $BlogRecordObject->getBlogRecords($input);
		$result['DB']['BlogRecords'] = $BlogRecordsRS;
		
	//}	
	if(!empty($commentRS[0]['ResourceID']))
	{
		$resourceObject = new ResourceClass();
		$inputResource['ResourceID']=$commentRS[0]['ResourceID'];
		$rs = $resourceObject->getResource($inputResource);
		$result['DB']['Resource'] = $rs;
	}
	
	
	if($clientType=='admin' || $manageMode=='user')
	{				
		//get Blogs 
		$entityRS = $BlogObject->getBlogs($input);
		$result['DB']['Blogs'] = $entityRS;
	}
	
	if($clientType=='admin')
	{		
		//get categories reference
		$input['treeType']='all';
		$input['downLevels']='all';
		//$categoriesRS = $sectionsObject->getResourceCategoriesTree($input);
		$categoriesRS = $CORE->callService('getResourceCategoriesTree','resourceServer',$input);
		$result['DB']['ResourceCategories'] = $categoriesRS['DB']['ResourceCategoriesList'];
		
		$input['treeType']='all';
		$input['downLevels']='all';
		//$input['SectionGroupCode'] = 'main';
		$input['SectionType'] = 'front';
		$sectionsRS = $CORE->callService('getSectionsTreeList','coreServer',$input);
		$result['DB']['SectionsList'] = $sectionsRS['DB']['SectionsList'];
	}
	else
		{
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
	}
	//return result array
	return $result;
}

function manageBlogs()
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
	$entityID = $input['BlogID'];
	$BlogObject = new BlogClass();
	//$sectionsObject = new ResourceCategoryClass();
	//$section = new BlogClass();
	
	
		
	
	//delete item
	if($input['actionMode']=='delete')
		{
		$BlogObject->deleteBlog($input);
		//$BlogType->deleteBlogField($input);
	}
	
	elseif($input['actionMode']=='deletefile')
		{
		if(!empty($input['Blog'.DTR.'BlogID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Blog WHERE BlogID='".$input['Blog'.DTR.'BlogID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE Blog SET ".$fileField."='' WHERE BlogID='".$input['Blog'.DTR.'BlogID']."'");
			}
		}
			elseif(!empty($input['BlogRecord'.DTR.'BlogRecordID']) && !empty($input['fileField']))
			{
					$FM = new FilesManager();
					$fileField =$input['fileField'];
					$fileFieldRS = $DS->query("SELECT ".$fileField." FROM BlogRecord WHERE BlogRecordID='".$input['BlogRecord'.DTR.'BlogRecordID']."'");
					
					if($FM->deleteFile($fileFieldRS[0][$fileField]))
					{
						$DS->query("UPDATE BlogRecord SET ".$fileField."='' WHERE BlogRecordID='".$input['BlogRecord'.DTR.'BlogRecordID']."'");
					}
			}
	}	
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['Blog'.DTR.'BlogID']))
		{
			foreach($input['Blog'.DTR.'BlogID'] as $id=>$value)
			{
				if($input['Blog'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['Blog'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['Blog'.DTR.'PermAll'] = 1;
				}			
				$inputSave['Blog'.DTR.'BlogID'] = $input['Blog'.DTR.'BlogID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['Blog'] = "BlogID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['Blog'.DTR.'BlogID'].' perm='.$inputSave['Blog'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);			
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
			
		if(!empty($uploadRS['BlogImage']['preview']))
		{
			$input['Blog'.DTR.'BlogImage']= $uploadRS['BlogImage']['preview'];
		}
		
		$saveRS = $BlogObject->setBlog($input);			
		$entityID = $saveRS[0]['BlogID'];
		$input['Blog'.DTR.'BlogID'] = $entityID;			
	}		
	//get 1 item details
	if(!empty($entityID))
	{
		$commentRS = $BlogObject->getBlog($input);
		$result['DB']['Blog'] = $commentRS;
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
		//get Blogs 
		$entityRS = $BlogObject->getBlogs($input);
		$result['DB']['Blogs'] = $entityRS;
	}
	
	if($clientType=='admin')
	{		
			//get categories reference
			$input['treeType']='all';
			$input['downLevels']='all';
			//$categoriesRS = $sectionsObject->getResourceCategoriesTree($input);
			$categoriesRS = $CORE->callService('getResourceCategoriesTree','resourceServer',$input);
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

function getBlogs()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects
	$BlogObject = new BlogClass();
	$result['DB']['Blogs'] = $BlogObject->getBlogs($input);
	
	$sectionsObject = new ResourceCategoryClass();
	//get categories reference
	$input['treeType']='all';
	$input['downLevels']='all';
	$categoriesRS = $sectionsObject->getResourceCategoriesTree($input);
	
	//$inputValues[0]['id']='';	
	//$inputValues[0]['value']=lang('-top');	
	$k=1;		
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
	$result['DB']['ResourceCategories'] = $inputValues;
	return $result;
}

function getBlog()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$BlogObject = new BlogClass();
	$BlogRecordObject = new BlogRecordClass();
	
	$rs = $BlogObject->getBlog($input);
	$result['DB']['Blog'] = $rs[0];
	
	$input['BlogID'] = $rs[0]['BlogID'];
	$BlogRecordsRS = $BlogRecordObject->getBlogRecords($input);
	$result['DB']['BlogRecords'] = $BlogRecordsRS;
	return $result;
}
?>
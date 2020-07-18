<?php
function managePropertyComments()
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
	$entityID = $input['PropertyCommentID'];
	$PropertyCommentObject = new PropertyCommentClass();
	//$section = new PropertyCommentClass();
	//delete item
	if($input['actionMode']=='delete')
	{
		$PropertyCommentObject->deletePropertyComment($input);
		//$PropertyCommentType->deletePropertyCommentField($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['PropertyCommentID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM PropertyComment WHERE PropertyCommentID='".$input['PropertyCommentID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE PropertyComment SET ".$fileField."='' WHERE PropertyCommentID='".$input['PropertyCommentID']."'");
			}
		}
	}	
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['PropertyComment'.DTR.'PropertyCommentID']))
		{
			foreach($input['PropertyComment'.DTR.'PropertyCommentID'] as $id=>$value)
			{
				if($input['PropertyComment'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['PropertyComment'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['PropertyComment'.DTR.'PermAll'] = 1;
				}			
				$inputSave['PropertyComment'.DTR.'PropertyCommentID'] = $input['PropertyComment'.DTR.'PropertyCommentID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['PropertyComment'] = "PropertyCommentID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['PropertyComment'.DTR.'PropertyCommentID'].' perm='.$inputSave['PropertyComment'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);			
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{
		if(empty($userID))
		{
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	
			$input['PropertyComment'.DTR.'PropertyCommentAuthor'] = $input['UserField'.DTR.'FirstName'].' '.$input['UserField'.DTR.'LastName'];	
			$input['PropertyComment'.DTR.'PropertyCommentEmail'] = $input['User'.DTR.'Email'];
			$input['PropertyComment'.DTR.'PropertyCommentLink'] = $input['UserField'.DTR.'UserLink'];
		}
		//print_r($input);	
		$saveRS = $PropertyCommentObject->setPropertyComment($input);
		$entityID = $saveRS[0]['PropertyCommentID'];
		$input['PropertyComment'.DTR.'PropertyCommentID'] = $entityID;					
	}

	if(empty($userID))
	{
		$CORE->setInputVar('redirectionMode','N');
		$CORE->callService('doLogin','sessionServer');
	}			
	//get 1 item details
	if(!empty($entityID))
	{
		$commentRS = $PropertyCommentObject->getPropertyComment($input);
		$result['DB']['PropertyComment'] = $commentRS;
	}	
	if(!empty($commentRS[0]['PropertyID']))
	{
		$propertyObject = new PropertyClass();
		$inputProperty['PropertyID']=$commentRS[0]['PropertyID'];
		$rs = $propertyObject->getProperty($inputProperty);
		$result['DB']['Property'] = $rs;
	}

	if($clientType=='admin' || $manageMode=='user' || !empty($input['PropertyID']))
	{		
		//get PropertyComments 
		$entityRS = $PropertyCommentObject->getPropertyComments($input);
		$result['DB']['PropertyComments'] = $entityRS;
	}
	
	if($clientType=='admin')
	{		
		//get categories reference
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

function getPropertyComments()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects
	$PropertyCommentObject = new PropertyCommentClass();
	$result['DB']['PropertyComments'] = $PropertyCommentObject->getPropertyComments($input);

	return $result;
}

function getPropertyComment()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$PropertyCommentObject = new PropertyCommentClass();
	
	$rs = $PropertyCommentObject->getPropertyComment($input);
	$result['DB']['PropertyComment'] = $rs[0];
		
	return $result;
}

?>
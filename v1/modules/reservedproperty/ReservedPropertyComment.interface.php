<?php
function manageReservedPropertyComments()
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
	$entityID = $input['ReservedPropertyCommentID'];
	$ReservedPropertyCommentObject = new ReservedPropertyCommentClass();
	//$section = new ReservedPropertyCommentClass();
	//delete item
	if($input['actionMode']=='delete')
	{
		$ReservedPropertyCommentObject->deleteReservedPropertyComment($input);
		//$ReservedPropertyCommentType->deleteReservedPropertyCommentField($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['ReservedPropertyCommentID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ReservedPropertyComment WHERE ReservedPropertyCommentID='".$input['ReservedPropertyCommentID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE ReservedPropertyComment SET ".$fileField."='' WHERE ReservedPropertyCommentID='".$input['ReservedPropertyCommentID']."'");
			}
		}
	}	
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentID']))
		{
			foreach($input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentID'] as $id=>$value)
			{
				if($input['ReservedPropertyComment'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['ReservedPropertyComment'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['ReservedPropertyComment'.DTR.'PermAll'] = 1;
				}			
				$inputSave['ReservedPropertyComment'.DTR.'ReservedPropertyCommentID'] = $input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['ReservedPropertyComment'] = "ReservedPropertyCommentID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['ReservedPropertyComment'.DTR.'ReservedPropertyCommentID'].' perm='.$inputSave['ReservedPropertyComment'.DTR.'PermAll'].'<hr>' ;
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
			$input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentAuthor'] = $input['UserField'.DTR.'FirstName'].' '.$input['UserField'.DTR.'LastName'];	
			$input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentEmail'] = $input['User'.DTR.'Email'];
			$input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentLink'] = $input['UserField'.DTR.'UserLink'];
		}
		//print_r($input);	
		$saveRS = $ReservedPropertyCommentObject->setReservedPropertyComment($input);
		$entityID = $saveRS[0]['ReservedPropertyCommentID'];
		$input['ReservedPropertyComment'.DTR.'ReservedPropertyCommentID'] = $entityID;					
	}

	if(empty($userID))
	{
		$CORE->setInputVar('redirectionMode','N');
		$CORE->callService('doLogin','sessionServer');
	}			
	//get 1 item details
	if(!empty($entityID))
	{
		$commentRS = $ReservedPropertyCommentObject->getReservedPropertyComment($input);
		$result['DB']['ReservedPropertyComment'] = $commentRS;
	}	
	if(!empty($commentRS[0]['ReservedPropertyID']))
	{
		$reservedPropertyObject = new ReservedPropertyClass();
		$inputReservedProperty['ReservedPropertyID']=$commentRS[0]['ReservedPropertyID'];
		$rs = $reservedPropertyObject->getReservedProperty($inputReservedProperty);
		$result['DB']['ReservedProperty'] = $rs;
	}

	if($clientType=='admin' || $manageMode=='user' || !empty($input['ReservedPropertyID']))
	{		
		//get ReservedPropertyComments 
		$entityRS = $ReservedPropertyCommentObject->getReservedPropertyComments($input);
		$result['DB']['ReservedPropertyComments'] = $entityRS;
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

function getReservedPropertyComments()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects
	$ReservedPropertyCommentObject = new ReservedPropertyCommentClass();
	$result['DB']['ReservedPropertyComments'] = $ReservedPropertyCommentObject->getReservedPropertyComments($input);

	return $result;
}

function getReservedPropertyComment()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$ReservedPropertyCommentObject = new ReservedPropertyCommentClass();
	
	$rs = $ReservedPropertyCommentObject->getReservedPropertyComment($input);
	$result['DB']['ReservedPropertyComment'] = $rs[0];
		
	return $result;
}

?>
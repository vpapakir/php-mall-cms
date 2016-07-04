<?php
function manageResourceComments()
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
	$entityID = $input['ResourceCommentID'];
	$userID = $user['UserID'];
	$ResourceCommentObject = new ResourceCommentClass();
	//$section = new ResourceCommentClass();
	//delete item

			if($input['UseCAPTCHA']==1)
			{
				$CAPTCHA = $CORE->callService("validateCaptchaCode", "antispamServer", $input);
				if(!$CAPTCHA) 
				{
					$parentID=$input['ParentSID'];
					$input='';
					$CORE->setInputVar('actionMode','');
					$CORE->setInputVar('SID',$parentID);
					$input['SID']=$parentID;
					$CORE->setInputVar('CAPTCHA','-CAPTCHA_wrong_Code');
					$input['CAPTCHA']='-CAPTCHA_wrong_Code';
				}
			}

	
	if($input['actionMode']=='delete')
	{
		$ResourceCommentObject->deleteResourceComment($input);
		//$ResourceCommentType->deleteResourceCommentField($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['ResourceCommentID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ResourceComment WHERE ResourceCommentID='".$input['ResourceCommentID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE ResourceComment SET ".$fileField."='' WHERE ResourceCommentID='".$input['ResourceCommentID']."'");
			}
		}
	}	
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['ResourceComment'.DTR.'ResourceCommentID']))
		{
			foreach($input['ResourceComment'.DTR.'ResourceCommentID'] as $id=>$value)
			{
				if($input['ResourceComment'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['ResourceComment'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['ResourceComment'.DTR.'PermAll'] = 1;
				}			
				$inputSave['ResourceComment'.DTR.'ResourceCommentID'] = $input['ResourceComment'.DTR.'ResourceCommentID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['ResourceComment'] = "ResourceCommentID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['ResourceComment'.DTR.'ResourceCommentID'].' perm='.$inputSave['ResourceComment'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);			
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{

		if(empty($userID))
		{
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('UserField'.DTR.'FirstName',$input['ResourceComment'.DTR.'ResourceCommentAuthor']);
			$CORE->setInputVar('UserField'.DTR.'UserLink',$input['ResourceComment'.DTR.'ResourceCommentLink']);
			$CORE->setInputVar('User'.DTR.'Email',$input['ResourceComment'.DTR.'ResourceCommentEmail']);
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	
			
			$user = $CORE->getUser();
			$userID = $user['UserID'];
			if(empty($userID)){
				$userRS = $CORE->callService('getUserByEmail','sessionServer');	
				$input['ResourceComment'.DTR.'UserID'] = $userRS[0]['UserID']; 
				$input['insert'] = 'insert';
			}
		}
		$saveRS = $ResourceCommentObject->setResourceComment($input);
		$entityID = $saveRS[0]['ResourceCommentID'];
		$input['ResourceComment'.DTR.'ResourceCommentID'] = $entityID;					
	}

	if(empty($userID))
	{
		$CORE->setInputVar('redirectionMode','N');
		$CORE->callService('doLogin','sessionServer');
	}			
	//get 1 item details
	if(!empty($entityID))
	{
		$commentRS = $ResourceCommentObject->getResourceComment($input);
		$result['DB']['ResourceComment'] = $commentRS;
	}	
	if(!empty($commentRS[0]['ResourceID']))
	{
		$resourceObject = new ResourceClass();
		$inputResource['ResourceID']=$commentRS[0]['ResourceID'];
		$rs = $resourceObject->getResource($inputResource);
		$result['DB']['Resource'] = $rs;
	}

	if($clientType=='admin' || $manageMode=='user' || !empty($input['ResourceID']))
	{		
		//get ResourceComments 
		$entityRS = $ResourceCommentObject->getResourceComments($input);
		$result['DB']['ResourceComments'] = $entityRS;
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

function getResourceComments($input='')
{
	global $CORE;
	//get input
	if(empty($input))
		$input = $CORE->getInput();
		
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects
	$ResourceCommentObject = new ResourceCommentClass();
	$result['DB']['ResourceComments'] = $ResourceCommentObject->getResourceComments($input);

	return $result;
}

function getResourceComment()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$ResourceCommentObject = new ResourceCommentClass();
	
	$rs = $ResourceCommentObject->getResourceComment($input);
	$result['DB']['ResourceComment'] = $rs[0];
		
	return $result;
}

?>
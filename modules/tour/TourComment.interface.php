<?php
function manageTourComments()
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
	$entityID = $input['TourCommentID'];
	$TourCommentObject = new TourCommentClass();
//	print_r($input);
	//$section = new TourCommentClass();
	//delete item
	if($input['actionMode']=='delete')
	{
		$TourCommentObject->deleteTourComment($input);
		//$TourCommentType->deleteTourCommentField($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['TourCommentID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM TourComment WHERE TourCommentID='".$input['TourCommentID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE TourComment SET ".$fileField."='' WHERE TourCommentID='".$input['TourCommentID']."'");
			}
		}
	}	
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['TourComment'.DTR.'TourCommentID']))
		{
			foreach($input['TourComment'.DTR.'TourCommentID'] as $id=>$value)
			{
				if($input['TourComment'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['TourComment'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['TourComment'.DTR.'PermAll'] = 1;
				}			
				$inputSave['TourComment'.DTR.'TourCommentID'] = $input['TourComment'.DTR.'TourCommentID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['TourComment'] = "TourCommentID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['TourComment'.DTR.'TourCommentID'].' perm='.$inputSave['TourComment'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);			
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{
//	 print_r($input);
		if(empty($userID))
		{
			$CORE->setInputVar('User'.DTR.'GroupID','user');
/*			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	//*/
			if(($input['UserField'.DTR.'FirstName']!='')and($input['UserField'.DTR.'LastName']!=''))
			{
			 $input['TourComment'.DTR.'TourCommentAuthor'] = $input['UserField'.DTR.'FirstName'].' '.$input['UserField'.DTR.'LastName'];
			}
			if($input['User'.DTR.'Email']!='')
			{
//			 echo 'email';
			 $input['TourComment'.DTR.'TourCommentEmail']=$input['User'.DTR.'Email'];
			}
			if ($input['UserField'.DTR.'UserLink']!='')
			{
			 $input['TourComment'.DTR.'TourCommentLink'] = $input['UserField'.DTR.'UserLink'];
			}
			if($input['UserField'.DTR.'FirstName']!='')
			{
				$input['TourComment'.DTR.'TourCommentAuthor'] = $input['UserField'.DTR.'FirstName'].' '.$input['UserField'.DTR.'LastName'];	
			}
			if($input['User'.DTR.'Email']!='')
			{
				$input['TourComment'.DTR.'TourCommentEmail'] = $input['User'.DTR.'Email'];
			}
			//$input['TourComment'.DTR.'TourCommentLink'] = $input['UserField'.DTR.'UserLink'];//*/
		}
//		print_r($input);	
		$TourCommentObject->setTourComment($input);
		if($input['actionMode']=='add')
		{
			$entityID = $DS->dbLastID();
				
			$input['TourComment'.DTR.'TourCommentID'] = $entityID;		
		}
//		print_r($input); 
//		header('Location: '.setting('url').'product/TourID/'.$input['TourComment'.DTR.'TourID'].'/windowMode/popup/');
	}

	if(empty($userID))
	{
		$CORE->setInputVar('redirectionMode','N');
		$CORE->callService('doLogin','sessionServer');
	}			
	//get 1 item details
	if(!empty($entityID))
	{
		$commentRS = $TourCommentObject->getTourComment($input);
		$result['DB']['TourComment'] = $commentRS;
	}	
	if(!empty($commentRS[0]['TourID']))
	{
		$tourObject = new TourClass();
		$inputTour['TourID']=$commentRS[0]['TourID'];
		$rs = $tourObject->getTour($inputTour);
		$result['DB']['Tour'] = $rs;
	}

	if($clientType=='admin' || $manageMode=='user' || !empty($input['TourID']))
	{		
		//get TourComments 
		$entityRS = $TourCommentObject->getTourComments($input);
		$result['DB']['TourComments'] = $entityRS;
	}
	
	if($clientType=='admin')
	{		
		//get categories reference
		$input['treeType']='all';
		$input['downLevels']='all';
		$categoriesRS = getTourCategoriesTree();
		$result['DB']['TourCategories'] = $categoriesRS['DB']['TourCategoriesList'];
	
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

function getTourComments()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects
	$TourCommentObject = new TourCommentClass();
//	$input['filterMode'] = 'last';  //if want to see the all comments
	$result['DB']['TourComments'] = $TourCommentObject->getTourComments($input);

	return $result;
}

function getTourComment()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$TourCommentObject = new TourCommentClass();
	
	$rs = $TourCommentObject->getTourComment($input);
	$result['DB']['TourComment'] = $rs[0];
		
	return $result;
}

?>
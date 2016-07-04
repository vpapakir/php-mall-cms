<?php
//XCMSPro: ReservationRoomTask entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageReservationRoomTasks()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservationRoomTaskID'];
	//creat objects			
	$ReservationRoomTask = new ReservationRoomTaskClass();

	//get content
	
	if($input['actionMode']=='delete')
	{
		$ReservationRoomTask->deleteReservationRoomTask($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['ReservationRoomTask'.DTR.'ReservationRoomTaskID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ReservationRoomTask WHERE ReservationRoomTaskID='".$input['ReservationRoomTask'.DTR.'ReservationRoomTaskID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			$input['ReservationRoomTask'.DTR.$fileField]=' ';
			$input['actionMode']='save';
			$resourceObject->setReservationRoomTask($input);
		}
	}	
	elseif($input['actionMode']=='save' || $input['actionMode']=='add' || $input['actionMode']=='save1')
	{
		//$CORE->setConfigVar("UseImageResize",'Y');
		$CORE->setConfigVar("UseImagePreview",'N');
		$CORE->setConfigVar("UseImageIcon",'Y');		
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		
		if(!empty($uploadRS['ReservationRoomTaskImage']['icon']))
		{
			$input['ReservationRoomTask'.DTR.'ReservationRoomTaskImage']= $uploadRS['ReservationRoomTaskImage']['file'];
			$input['ReservationRoomTask'.DTR.'ReservationRoomTaskIcon']= $uploadRS['ReservationRoomTaskImage']['icon'];
		}
		$ReservationRoomTask->setReservationRoomTask($input);
	}
	
	if(!empty($entityID) || !empty($input['TipSection']) || !empty($input['TipCode']))
	{
		$ReservationRoomTaskRS = $ReservationRoomTask->getReservationRoomTask($input);
		$result['DB']['ReservationRoomTask'] = $ReservationRoomTaskRS;	
	}
	$ReservationRoomTasksRS = $ReservationRoomTask->getReservationRoomTasks($input);
	$result['DB']['ReservationRoomTasks'] = $ReservationRoomTasksRS;
	
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

function manageReservationRoomTask()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservationRoomTaskID'];
	
	//creat objects			
	$ReservationRoomTask = new ReservationRoomTaskClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$ReservationRoomTask->deleteReservationRoomTask($input);
	
	}	
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['ReservationRoomTask'.DTR.'ReservationRoomTaskID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ReservationRoomTask WHERE ReservationRoomTaskID='".$input['ReservationRoomTask'.DTR.'ReservationRoomTaskID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			$input['ReservationRoomTask'.DTR.$fileField]=' ';
			$input['actionMode']='save';
			$resourceObject->setReservationRoomTask($input);
		}
	}	
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		//$CORE->setConfigVar("UseImageResize",'Y');
		$CORE->setConfigVar("UseImagePreview",'N');
		//$CORE->setConfigVar("UseImageIcon",'Y');		
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		if(!empty($uploadRS['ReservationRoomTaskImage']['file']))
		{
			$input['ReservationRoomTask'.DTR.'ReservationRoomTaskImage']= $uploadRS['ReservationRoomTaskImage']['file'];
			$input['ReservationRoomTask'.DTR.'ReservationRoomTaskIcon']= $uploadRS['ReservationRoomTaskImage']['icon'];
		}		
		$ReservationRoomTask->setReservationRoomTask($input);
	}	

	if(!empty($entityID) || !empty($input['TipSection']) || !empty($input['TipCode']))
	{
		$ReservationRoomTaskRS = $ReservationRoomTask->getReservationRoomTask($input);
		$result['DB']['ReservationRoomTask'] = $ReservationRoomTaskRS;	
	}
	
	$ReservationRoomTasksRS = $ReservationRoomTask->getReservationRoomTasks($input);
	$result['DB']['ReservationRoomTasks'] = $ReservationRoomTasksRS;
	
	$input['treeType']='all';
	$input['downLevels']='all';
	//$input['ReservationRoomTaskCategoryGroup'] = $groupID;
	$categoriesRS = $sectionsObject->getReservationRoomTaskCategoriesTree($input);
	//
	
	$k=1;		
	if(is_array($categoriesRS))
	{
		foreach($categoriesRS as $id=>$row)
		{
			if($lastLevel != $row['ReservationRoomTaskCategoryLevel'])
			{
				$lastLevel = $row['ReservationRoomTaskCategoryLevel'];
				$treeString='';
				if($row['ReservationRoomTaskCategoryLevel']!=1)
				{
					for($i=2;$i<=$row['ReservationRoomTaskCategoryLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
				}
			}
			//if($row['ReservationRoomTaskCategoryID']!=$input['ReservationRoomTaskCategoryID'])
			//{
				$inputValues[$k]['id']=$row['ReservationRoomTaskCategoryID'];	
				$inputValues[$k]['value']=$treeString.getValue($row['ReservationRoomTaskCategoryTitle']);
				$k++;		
			//}
			//echo 'i= '.$i.' id= '.$row['ResourceCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
		}
	}
	$result['DB']['ReservationRoomTaskCategories'] = $inputValues;
	//$input['treeType']='all';
	//$input['downLevels']='all';
	//$input['SectionGroup'] = 'main';
	//$sectionsRS = $CORE->callService('getSectionsTreeList','coreServer',$input);
	//$result['DB']['SectionsList'] = $sectionsRS['DB']['SectionsList'];

	//print_r($result['DB']['SectionsList']);
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

function getReservationRoomTask()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$ReservationRoomTaskObject = new ReservationRoomTaskClass();
	$rs = $ReservationRoomTaskObject->getReservationRoomTask($input);
	$result['DB']['ReservationRoomTask'] = $rs[0];
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	/*
	$ReservationRoomTaskCategory = new ReservationRoomTaskCategoryClass();
	$CORE->setInputVar('ReservationRoomTaskType',$rs[0]['ReservationRoomTaskType']);	
	$CORE->setInputVar('type',$rs[0]['ReservationRoomTaskType']);
	$typesRS = $ReservationRoomTaskCategory->getReservationRoomTaskCategoryTypes($input);	
	$result['DB']['ReservationRoomTaskCategoryTypes'] = $typesRS;		
	*/
	//print_r($result);	
	return $result;
}

?>
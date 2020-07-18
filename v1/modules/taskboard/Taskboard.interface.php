<?php



	function getVisibleBy($input){
		global $CORE;

		$CORE->setInputVar('Groups','root,admin,content,owner');
		$resultRS = $CORE->callService('getUsersByGroup','sessionServer');

		foreach($resultRS['DB']['Users'] as $groupID=>$group){
			foreach($resultRS['DB']['UserGroups'] as $ug)
				if($ug['GroupID']==$groupID){
					$result['Groups'][] = $ug;
					break;
				}			
			if(is_array($group) and count($group))
				foreach($group as $user)
					$result['Users'][] = $user;
		}
		return $result;
	}


function manageTaskboard()
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
	$TaskboardObject = new TaskboardClass();
	$TaskboardRecordObject = new TaskboardRecordClass();
	
	
	if($input['actionMode']=='delete'){
		$TaskboardObject->deleteTaskboard($input);
	}elseif($input['actionMode']=='deleteRecord'){
		$TaskboardRecordObject->deleteTaskboardRecord($input);
	}elseif($input['actionMode']=='deletefile' ||  $user['UserId']){
			
		if(!empty($input['Taskboard'.DTR.'TaskboardID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Taskboard WHERE TaskboardID='".$input['Taskboard'.DTR.'TaskboardID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]) ||  $fileFieldRS[0][$fileField] )
			{
				$DS->query("UPDATE Taskboard SET ".$fileField."='' WHERE TaskboardID='".$input['Taskboard'.DTR.'TaskboardID']."'");
			}
		}
			elseif(!empty($input['TaskboardRecord'.DTR.'TaskboardRecordID']) && !empty($input['fileField']))
			{
					
					$FM = new FilesManager();
					$fileField =$input['fileField'];
					$fileFieldRS = $DS->query("SELECT ".$fileField." FROM TaskboardRecord WHERE TaskboardRecordID='".$input['TaskboardRecord'.DTR.'TaskboardRecordID']."'");
					if($FM->deleteFile($fileFieldRS[0][$fileField]) || $fileFieldRS[0][$fileField])
					{
						$DS->query("UPDATE TaskboardRecord SET ".$fileField."='' WHERE TaskboardRecordID='".$input['TaskboardRecord'.DTR.'TaskboardRecordID']."'");
					}
			}
	}	
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['Taskboard'.DTR.'TaskboardID']))
		{
			foreach($input['Taskboard'.DTR.'TaskboardID'] as $id=>$value)
			{
				if($input['Taskboard'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['Taskboard'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['Taskboard'.DTR.'PermAll'] = 1;
				}			
				$inputSave['Taskboard'.DTR.'TaskboardID'] = $input['Taskboard'.DTR.'TaskboardID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['Taskboard'] = "TaskboardID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['Taskboard'.DTR.'TaskboardID'].' perm='.$inputSave['Taskboard'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);			
			}	
		}
		elseif(is_array($input['TaskboardRecord'.DTR.'TaskboardRecordID']))
			{
				foreach($input['TaskboardRecord'.DTR.'TaskboardRecordID'] as $id=>$value)
				{
					if($input['TaskboardRecord'.DTR.'PermAll'][$id]!='1')
					{
						$inputSave['TaskboardRecord'.DTR.'PermAll'] = 4;
					}
					else
					{
						$inputSave['TaskboardRecord'.DTR.'PermAll'] = 1;
					}			
					$inputSave['TaskboardRecord'.DTR.'TaskboardRecordID'] = $input['TaskboardRecord'.DTR.'TaskboardRecordID'][$id];
					$inputSave['actionMode']='save';
					$whereSave['TaskboardRecord'] = "TaskboardRecordID='".$value."'";
					//echo 'id='.$id. ' sid='.$inputSave['Taskboard'.DTR.'TaskboardID'].' perm='.$inputSave['Taskboard'.DTR.'PermAll'].'<hr>' ;
					$DS->save($inputSave,$whereSave);			
				}
			}
	}elseif($input['actionMode']=='add' || $input['actionMode']=='save'){
		if(!empty($input['Taskboard'.DTR.'TaskboardTitle'])){

//			$saveRS = $TaskboardObject->setTaskboard($input);			
			$entityID = $saveRS[0]['TaskboardID'];
			$input['Taskboard'.DTR.'TaskboardID'] = $entityID;			
		}

	}elseif($input['actionMode']=='addRecord' || $input['actionMode']=='saveRecord'){

		if($input['TaskboardRecord'.DTR.'TaskboardRecordTimestamp'] || !empty($input['TaskboardRecord'.DTR.'TaskboardRecordContent'])){
			$saveRS = $TaskboardRecordObject->setTaskboardRecord($input);			

			$entityID = $saveRS[0]['TaskboardRecordID'];
			$input['TaskboardRecord'.DTR.'TaskboardRecordID'] = $entityID;
		}
	}elseif($input['actionMode']=='markAllRead'){
//die('asdf');
		$saveRS = $TaskboardRecordObject->setTaskboardRecordsRead($input);			

		$entityID = $saveRS[0]['TaskboardRecordID'];
		$input['TaskboardRecord'.DTR.'TaskboardRecordID'] = $entityID;
	}		

	if($input['actionMode']=='addRecord' || $input['actionMode']=='saveRecord' || $input['actionMode']=='deleteRecord'){
//die('Location: '.setting('url').'manageTaskboards/TaskboardID/'.$input['TaskboardID']);
		header('Location: '.setting('url').'manageTaskboards/TaskboardID/'.$input['TaskboardID']);

	}
//print_r($input);
//die();

		$commentRS = $TaskboardObject->getTaskboard($input);
		$result['DB']['Taskboard'] = $commentRS;
		
		if(!empty($input['TaskboardRecordID']) || $input['TaskboardRecord'.DTR.'TaskboardRecordID'])
		{
			//get TaskboardRecords 
			$TaskboardRecordRS = $TaskboardRecordObject->getTaskboardRecord($input);
			$result['DB']['TaskboardRecord'] = $TaskboardRecordRS;
		}
		$TaskboardRecordsRS = $TaskboardRecordObject->getTaskboardRecords($input);
		$result['DB']['TaskboardRecords'] = $TaskboardRecordsRS;
		
	if(!empty($commentRS[0]['ResourceID']))
	{
		$resourceObject = new ResourceClass();
		$inputResource['ResourceID']=$commentRS[0]['ResourceID'];
		$rs = $resourceObject->getResource($inputResource);
		$result['DB']['Resource'] = $rs;
	}
	
	
	$entityRS = $TaskboardObject->getTaskboards($input);
	$result['DB']['Taskboards'] = $entityRS;
	
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


function manageProjects()
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
	$entityID = $input['TaskboardID'];
	$TaskboardObject = new TaskboardClass();

	if($input['actionMode']=='deleteProject'){
		$TaskboardObject->deleteProject($input);
	}elseif($input['actionMode']=='addProject' || $input['actionMode']=='saveProject'){
		if($input['TaskboardProject'.DTR.'TaskboardProjectTitle']){
			$saveRS = $TaskboardObject->setProject($input);
			$ProjectID = $saveRS[0]['TaskboardProjectID'];
			$input['TaskboardProject'.DTR.'TaskboardProjectID'] = $entityID;			
		}
	}

	if($input['actionMode']){
		if($saveRS[0]['TaskboardProjectExists'])
			echo '<script language="javascript">window.alert("'.lang('ProjectExists.taskbard.err').'")</script>';
		else
			header('Location: '.setting('url').'manageTaskboards/Taskboard'.DTR.'TaskboardProject/'.$ProjectID);
	}



	$result['DB']['Project'] = $TaskboardObject->getProject($input);


		$result['DB']['Taskboards'][] = array('ID'=>'ProjectID/0','Title'=>'---'.lang('AddProject.taskboard.tip').'---',);
		$result['DB']['Taskboards'][] = array('ID'=>'TaskboardID/0','Title'=>'---'.lang('AddTaskboard.taskboard.tip').'---',);
		$resultRS = $TaskboardObject->getProjects($input);
		if(is_array($resultRS) and count($resultRS))
			foreach($resultRS as $value){
				$value['ID'] = 'ProjectID/'.$value['TaskboardProjectID'];
				$value['Title'] = $value['TaskboardProjectTitle'];
				$result['DB']['Taskboards'][] = $value;	
			}


	return $result;
}

function manageTaskboards()
{ 
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();

	$DS = new DataSource('main');
	$manageMode = $input['manageMode'];
	$clientType = $config['ClientType'];
	$entityID = $input['TaskboardID'];
	$TaskboardObject = new TaskboardClass();
	$TaskboardRecordObject = new TaskboardRecordClass();

	if($input['actionMode']=='delete')
		{
		$TaskboardObject->deleteTaskboard($input);
	}
	
	elseif($input['actionMode']=='deletefile')
		{
		if(!empty($input['Taskboard'.DTR.'TaskboardID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Taskboard WHERE TaskboardID='".$input['Taskboard'.DTR.'TaskboardID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE Taskboard SET ".$fileField."='' WHERE TaskboardID='".$input['Taskboard'.DTR.'TaskboardID']."'");
			}
		}
			elseif(!empty($input['TaskboardRecord'.DTR.'TaskboardRecordID']) && !empty($input['fileField']))
			{
					$FM = new FilesManager();
					$fileField =$input['fileField'];
					$fileFieldRS = $DS->query("SELECT ".$fileField." FROM TaskboardRecord WHERE TaskboardRecordID='".$input['TaskboardRecord'.DTR.'TaskboardRecordID']."'");
					
					if($FM->deleteFile($fileFieldRS[0][$fileField]))
					{
						$DS->query("UPDATE TaskboardRecord SET ".$fileField."='' WHERE TaskboardRecordID='".$input['TaskboardRecord'.DTR.'TaskboardRecordID']."'");
					}
			}
	}	
	elseif($input['actionMode']=='savelist')
	{
		//update list of items
	    if(is_array($input['Taskboard'.DTR.'TaskboardID']))
		{
			foreach($input['Taskboard'.DTR.'TaskboardID'] as $id=>$value)
			{
				if($input['Taskboard'.DTR.'PermAll'][$id]!='1')
				{
					$inputSave['Taskboard'.DTR.'PermAll'] = 4;
				}
				else
				{
					$inputSave['Taskboard'.DTR.'PermAll'] = 1;
				}			
				$inputSave['Taskboard'.DTR.'TaskboardID'] = $input['Taskboard'.DTR.'TaskboardID'][$id];
				$inputSave['actionMode']='save';
				$whereSave['Taskboard'] = "TaskboardID='".$value."'";
				//echo 'id='.$id. ' sid='.$inputSave['Taskboard'.DTR.'TaskboardID'].' perm='.$inputSave['Taskboard'.DTR.'PermAll'].'<hr>' ;
				$DS->save($inputSave,$whereSave);			
			}	
		}
	}	
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{


    	if($input['actionMode']=='save'){
			$old_val=getTaskboard();
			$old_val=$old_val['DB']['Taskboard'];
		}
//echo ("asf1");
		$saveRS = $TaskboardObject->setTaskboard($input);			
		$entityID = $saveRS[0]['TaskboardID'];
		$input['Taskboard'.DTR.'TaskboardID'] = $entityID;
		$input['TaskboardRecord'.DTR.'TaskboardID'] = $entityID;
//die($entityID);

			$mess='';
			if(AddSlashes(StripSlashes($input['Taskboard'.DTR.'TaskboardTitle']))!=AddSlashes(StripSlashes($old_val['TaskboardTitle'])))
				$mess.='Title: set to "'.$input['Taskboard'.DTR.'TaskboardTitle']."\"\n";

			if(AddSlashes(StripSlashes($input['Taskboard'.DTR.'TaskboardContent']))!=AddSlashes(StripSlashes($old_val['TaskboardContent'])))
				$mess.='Description: set to "'.$input['Taskboard'.DTR.'TaskboardContent']."\"\n";

			if(AddSlashes(StripSlashes($input['Taskboard'.DTR.'TaskboardProject']))!=AddSlashes(StripSlashes($old_val['TaskboardProject']))){
				$p = $TaskboardObject->getProject(array('ProjectID'=>$input['Taskboard'.DTR.'TaskboardProject']));
				$mess.='Project: set to "'.$p[0]['TaskboardProjectTitle']."\"\n";
			}
			if(AddSlashes(StripSlashes($input['Taskboard'.DTR.'TaskboardResponsable']))!=AddSlashes(StripSlashes($old_val['TaskboardResponsable']))){
				$resultRS = $CORE->callService('getUserData','sessionServer',array('UserID'=>$input['Taskboard'.DTR.'TaskboardResponsable']));
				$mess.='Responsable: set to "'.$resultRS['DB']['User'][0]['UserName']."\"\n";
			}
			if(AddSlashes(StripSlashes($input['Taskboard'.DTR.'TaskboardType']))!=AddSlashes(StripSlashes($old_val['TaskboardType']))){
				$mess.='Type: set to "'.getReferenceValue('Taskboard.TaskboardType',$input['Taskboard'.DTR.'TaskboardType'])."\"\n";
			}
			if(AddSlashes(StripSlashes($input['Taskboard'.DTR.'TaskboardStatus']))!=AddSlashes(StripSlashes($old_val['TaskboardStatus']))){
				$mess.='Status: set to "'.getReferenceValue('Taskboard.TaskboardStatus',$input['Taskboard'.DTR.'TaskboardStatus'])."\"\n";
			}
			if(AddSlashes(StripSlashes($input['Taskboard'.DTR.'TaskboardFlag']))!=AddSlashes(StripSlashes($old_val['TaskboardFlag']))){
				$mess.='Priority: set to "'.getReferenceValue('Taskboard.TaskboardFlag',$input['Taskboard'.DTR.'TaskboardFlag'])."\"\n";
			}
			if(AddSlashes(StripSlashes(trim($input['Taskboard'.DTR.'TaskboardSign'])))!=AddSlashes(StripSlashes($old_val['TaskboardSign']))){
				$mess.='Sign: set to "'.getReferenceValue('Taskboard.TaskboardSign',$input['Taskboard'.DTR.'TaskboardSign'])."\"\n";
			}
			if(AddSlashes(StripSlashes($input['Taskboard'.DTR.'TaskboardDeadline']))!=AddSlashes(StripSlashes($old_val['TaskboardDeadline']))){
				$mess.='Deadline: set to "'.$input['Taskboard'.DTR.'TaskboardDeadline']."\"\n";
			}
			$oldusr=preg_split('/\|/',$old_val['TaskboardUsers'],-1,PREG_SPLIT_NO_EMPTY);
			$oldgrp=preg_split('/\|/',$old_val['TaskboardGroups'],-1,PREG_SPLIT_NO_EMPTY);
			$newusr=$input['Taskboard'.DTR.'TaskboardUsers'];
			$newgrp=$input['Taskboard'.DTR.'TaskboardGroups'];
//echo "<pre>";
//print_r($oldusr);
//print_r($oldgrp);
//print_r($newusr);
//print_r($newgrp);
			if(	(is_array($newgrp) and count($newgrp) and !is_array($oldgrp))or
				(!is_array($newgrp)and count($oldgrp) and is_array($oldgrp))or
				(is_array($newusr) and count($newusr) and !is_array($oldusr))or
				(!is_array($newusr)and count(oldusr) and is_array($oldusr))or(
					is_array($newgrp)and is_array($newusr)and is_array($oldgrp)and is_array($oldusr)and (
						count($newusr)!=count($oldusr)or
						count($newgrp)!=count($oldgrp)or
						array_intersect($oldusr,$newusr)!=$oldusr or
						array_intersect($oldgrp,$newgrp)!=$oldgrp))){
				$asdf=array();
				if(is_array($newusr) and count($newusr))
					foreach($newusr as $usr){
						$resultRS = $CORE->callService('getUserData','sessionServer',array('UserID'=>$usr));
						$asdf[]=$resultRS['DB']['User'][0]['UserName'];
					}
				if(is_array($newgrp) and count($newgrp))
					foreach($newgrp as $grp){
						$CORE->setInputVar('GroupID',$grp);
						$resultRS = $CORE->callService('manageUserGroups','sessionServer');
						$asdf[]=$resultRS['DB']['UserGroup'][0]['GroupName'];
					}
				$mess.='Visible by: set to "'.join(', ',$asdf).'"';
			}
//die($mess);


			if($mess){
				$input['actionMode']='addRecord';
		
				$input['TaskboardRecord'.DTR.'TaskboardRecordContent']=$mess;

				$TaskboardRecordObject->setTaskboardRecord($input);
				$input['actionMode']='save';
			}
//		}
	}		


	if($input['actionMode'] && $input['actionMode']!='addRecord' && $input['actionMode']!='saveRecord' && $input['actionMode']!='deleteRecord' && $input['actionMode']!='addProject' && $input['actionMode']!='saveProject' && $input['actionMode']!='deleteProject'){
		header('Location: '.setting('url').'manageTaskboards/Taskboard'.DTR.'TaskboardProject/'.$input['Taskboard'.DTR.'TaskboardProject']);
	}



	//get 1 item details
	if(!empty($entityID)){
		$commentRS = $TaskboardObject->getTaskboard($input);
		$result['DB']['Taskboard'] = $commentRS;
	}
	$visibleBy = getVisibleBy($input);
	$result['DB']['Taskboard']['Users'] = $visibleBy['Users'];
	$result['DB']['Taskboard']['Groups'] = $visibleBy['Groups'];



	$result['DB']['Taskboards'][] = array('ID'=>'TaskboardID/0','Title'=>'---'.lang('AddTaskboard.taskboard.tip').'---',);
	$result['DB']['Taskboards'][] = array('ID'=>'ProjectID/0','Title'=>'---'.lang('AddProject.taskboard.tip').'---',);
	$resultRS = $TaskboardObject->getTaskboards($input);
	if(is_array($resultRS) and count($resultRS))
		foreach($resultRS as $value){
			$value['ID'] = 'TaskboardID/'.$value['TaskboardID'];
			$value['Title'] = $value['TaskboardTitle'];
			$result['DB']['Taskboards'][] = $value;	
		}




	$result['DB']['Projects'] = $TaskboardObject->getProjects($input);
	$result['UserID'] = $user['UserID'];

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

function getTaskboards($in='')
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects
	$TaskboardObject = new TaskboardClass();
	$input=arrayMerge($input,$in);
	$result['DB']['Taskboards'] = $TaskboardObject->getTaskboards($input);
	$result['DB']['LastTaskboardRecords'] = $TaskboardObject->getTaskboards($input);
	return $result;
}

function getTaskboard()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$TaskboardObject = new TaskboardClass();
	$TaskboardRecordObject = new TaskboardRecordClass();
	
	$rs = $TaskboardObject->getTaskboard($input);
	$result['DB']['Taskboard'] = $rs[0];
	$input['TaskboardID'] = $rs[0]['TaskboardID'];
	

	$TaskboardRecordsRS = $TaskboardRecordObject->getTaskboardRecords($input);
	$result['DB']['TaskboardRecords'] = $TaskboardRecordsRS;
	return $result;
}


?>
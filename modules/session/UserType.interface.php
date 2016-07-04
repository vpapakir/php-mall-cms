<?php
//XCMSPro: UserType entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageUserTypes()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['UserGroupID'];
	$entityFieldID = $input['UserTypeFieldID'];
	$entityOptionID = $input['UserTypeOptionID'];
	//creat objects			
	$UserType = new UserTypeClass();
	$DS = new DataSource('main');
	//get content
	if($input['actionMode']=='delete')
	{
		$UserType->deleteUserTypeField($input);
		$UserType->deleteUserTypeOption($input);		
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$UserType->setUserTypeField($input);		
		$UserType->setUserTypeOption($input);
		//$UserType->updateBoxPositions($input['UserTypeBox'.DTR.'UserTypeBoxID']);		
	}
	elseif($input['actionMode']=='copyUserType')
	{
		$UserType->copyUserType($input);
	}	

	$UserGroup = new UserGroupClass();
	$UserGroupsRS = $UserGroup->getUserGroups($input);
	$result['DB']['UserGroups'] = $UserGroupsRS;

	if(!empty($entityID))
	{
		$result['DB']['UserTypeFields'] = $UserType->getUserTypeFields($input);
		if(!empty($entityFieldID))
		{
			$result['DB']['UserTypeField'] = $UserType->getUserTypeField($input);
			$result['DB']['UserTypeOptions'] = $UserType->getUserTypeOptions($input);
			if(!empty($entityOptionID))
			{
				$result['DB']['UserTypeOption'] = $UserType->getUserTypeOption($input);
			}			
		}
	}
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	//script insert users field from table UserField to UserFields
	$query = "SELECT * FROM UserField";
	$dsResult = $DS->query($query);
	
	//print_r($dsResult);
	/*foreach($dsResult as $key=>$value){
		$dsCheckRow = $DS->query("SELECT * FROM UserFields WHERE UserID = '".$value['UserID']."'");
		if(count($dsCheckRow)<1){
			$id = $CORE->getUniqueID();
			//$DS->query("INSERT INTO UserFields (UserFieldsID,UserID,".$value['UserFieldAlias'].") VALUES ('".$id."','".$value['UserID']."','".$value['UserFieldValue']."')");
			$DS->query("INSERT INTO UserFields (UserFieldsID,UserID,".$value['UserFieldAlias'].") VALUES ('".$value['UserID']."','".$value['UserID']."','".addslashes(stripslashes($value['UserFieldValue']))."')");
			//sleep(1);
		}else{
			$k=0;
			foreach($dsCheckRow[0] as $id=>$row){
				if($value['UserFieldAlias']==$id)
					$k = 1;
			}
			
			if($k==1){
				$dsCheckField = $DS->query("SELECT * FROM UserFields WHERE UserID = '".$value['UserID']."' AND `".$value['UserFieldAlias']."`!= ''");
			
				if(count($dsCheckField)<1){
					$DS->query("UPDATE UserFields SET ".$value['UserFieldAlias']." = '".addslashes(stripslashes($value['UserFieldValue']))."' WHERE UserID = '".$value['UserID']."'");
				}
			}
		}
	}*/
	//script insert users field from table UserField to UserFields
	
	return $result;
}

?>
<?	
	$databaseDefinition['t']['UserGroup']='GroupID,OwnerID,UserID,AdminID,TimeCreated,TimeSaved,GroupName,GroupRights,GroupDescription,GroupPosition,GroupStatus,GroupType';
	$databaseDefinition['k']['UserGroup']='GroupID';	
	$databaseDefinition['langs']['UserGroup']['GroupDescription']='infield';

	$databaseDefinition['t']['User']='UserID,OwnerID,AdminID,TimeCreated,TimeSaved,TimeStart,TimeEnd,IPCreated,IPSaved,PermUser,PermOwner,PermAll,Type,GroupID,Email,UserName,Password,PasswordEnabled,Deleted,TimeDeleted,Status,OwnerParentID,Owners,LastVisit,UserLanguage,UserFields,CreatorID,CreatorCode';
	$databaseDefinition['k']['User']='UserID';	
	
	$databaseDefinition['t']['UserTypeField']='UserTypeFieldID,UserTypeFieldAlias,UserID,OwnerID,PermAll,UserGroupID,UserTypeFieldName,UserTypeFieldPosition,UserTypeFieldType,UserTypeFieldHidenPlaces,UserTypeFieldGroups';
	$databaseDefinition['k']['UserTypeField']='UserTypeFieldID';		
	$databaseDefinition['langs']['UserTypeField']['UserTypeFieldName']='infield';

	$databaseDefinition['t']['UserTypeOption']='UserTypeOptionID,UserTypeOptionAlias,UserID,OwnerID,PermAll,UserTypeFieldID,UserTypeOptionName,UserTypeOptionPosition';
	$databaseDefinition['k']['UserTypeOption']='UserTypeOptionID';	
	$databaseDefinition['langs']['UserTypeOption']['UserTypeOptionName']='infield';

	$databaseDefinition['t']['UserField']='UserFieldID,UserFieldAlias,UserID,UserTypeFieldID,UserFieldValue,UserFieldValueNumber,UserFieldValueTime';
	$databaseDefinition['k']['UserField']='UserFieldID';	

?>

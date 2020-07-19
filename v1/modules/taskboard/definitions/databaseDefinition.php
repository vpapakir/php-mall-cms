<?
	$databaseDefinition['t']['Taskboard']='TaskboardID,UserID,OwnerID,PermAll,TimeCreated,IPCreated,TaskboardCategoryID,TaskboardLocationID,TaskboardTitle,TaskboardAuthor,TaskboardGroups,TaskboardResponsable,TaskboardUsers,TaskboardURL,TaskboardEmail,TaskboardContent,TaskboardImage,TaskboardType,TaskboardProject,TaskboardSign,TaskboardFlag,TaskboardDeadline,TaskboardStatus';
	$databaseDefinition['k']['Taskboard']='TaskboardID';	
	
	$databaseDefinition['t']['TaskboardRecord']='TaskboardRecordID,UserID,OwnerID,PermAll,TimeCreated,TaskboardID,TaskboardRecordTimestamp,TaskboardRecordContent';
	$databaseDefinition['k']['TaskboardRecord']='TaskboardRecordID';

	$databaseDefinition['t']['TaskboardProject']='TaskboardProjectID,UserID,OwnerID,PermAll,TimeCreated,TaskboardProjectTitle,TaskboardProjectContent';
	$databaseDefinition['k']['TaskboardProject']='TaskboardProjectID';
?>

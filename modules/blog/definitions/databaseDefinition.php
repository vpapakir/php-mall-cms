<?
	$databaseDefinition['t']['Blog']='BlogID,UserID,OwnerID,PermAll,TimeCreated,IPCreated,BlogCategoryID,BlogLocationID,BlogTitle,BlogAuthor,BlogURL,BlogEmail,BlogContent,BlogImage,BlogStatus';
	$databaseDefinition['k']['Blog']='BlogID';	
	
	$databaseDefinition['t']['BlogRecord']='BlogRecordID,UserID,OwnerID,PermAll,TimeCreated,IPCreated,BlogID,BlogRecordTitle,BlogRecordAuthor,BlogRecordURL,BlogRecordEmail,BlogRecordContent,BlogRecordImage,BlogRecordStatus';
	$databaseDefinition['k']['BlogRecord']='BlogRecordID';
?>

<?
	$databaseDefinition['t']['Message']='MessageID,UserID,OwnerID,PermAll,IPCreated,IPSaved,TimeCreated,TimeSaved,MessageSenderNickName,MessageSenderGroup,MessageReceiverID,MessageReceiverNickName,MessageReceiverGroup,MessageSubject,MessageText,MessageType,MessageFolderAlias,MessageStatus,OrderID';
	$databaseDefinition['k']['Message']='MessageID';

	$databaseDefinition['t']['MessageFolder']='MessageFolderID,UserID,OwnerID,PermAll,IPCreated,TimeCreated,TimeSaved,MessageFolderAlias,MessageFolderName';
	$databaseDefinition['k']['MessageFolder']='MessageFolderID';
	
	$databaseDefinition['t']['Mail']='MailID,UserID,OwnerID,AdminID,TimeCreated,TimeSaved,TimeStart,MailSession,MailIndex,MailTo,MailToName,MailFrom,MailFromName,MailSubject,MailData,MailTemplate,MailFormat,MailLanguage,MailAttachment';
	$databaseDefinition['k']['Mail']='MailID';
	
	$databaseDefinition['t']['MailLog']='MailLogID,UserID,OwnerID,AdminID,TimeCreated,TimeSaved,TimeStart,MailTo,MailToName,MailFrom,MailFromName,MailSubject,MailData,MailTemplate,MailLanguage,MailSessionID';
	$databaseDefinition['k']['MailLog']='MailLogID';
	
	$databaseDefinition['t']['MailThread']='MailThreadID,UserID,OwnerID,AdminID,TimeCreated,TimeSaved,MailStart,MailEnd,MailListSession';
	$databaseDefinition['k']['MailThread']='MailThreadID';
	
	$databaseDefinition['t']['MessageAttachment']='MessageAttachmentID,UserID,OwnerID,TimeCreated,IPCreated,MessageID,MessageAttachmentName,MessageFile';
	$databaseDefinition['k']['MessageAttachment']='MessageAttachmentID';
	/*
	$databaseDefinition['t']['MailTemplate']='MailTemplateID,UserID,OwnerID,MailTemplateCode,MailTemplateGroup,MailTemplateName,MailTemplateBody,MailTemplateBodyText,MailTemplateSubject,MailTemplateDescription,MailTemplateNoHeader';
	$databaseDefinition['k']['MailTemplate']='MailTemplateID';	
	$databaseDefinition['langs']['MailTemplate']['MailTemplateName']='infield';
	$databaseDefinition['langs']['MailTemplate']['MailTemplateBody']='infield';
	$databaseDefinition['langs']['MailTemplate']['MailTemplateBodyText']='infield';
	$databaseDefinition['langs']['MailTemplate']['MailTemplateSubject']='infield';
	$databaseDefinition['langs']['MailTemplate']['MailTemplateDescription']='infield';		
	
	$databaseDefinition['t']['MailTemplateGroup']='MailTemplateGroupID,MailTemplateGroupCode,MailTemplateGroupName,MailTemplateGroupDescription';
	$databaseDefinition['k']['MailTemplateGroup']='MailTemplateGroupID';
	*/		
?>

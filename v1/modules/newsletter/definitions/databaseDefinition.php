<?	
	$databaseDefinition['t']['Newsletter']='NewsletterID,UserID,OwnerID,AdminID,PermUser,PermOwner,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,IPCreated,IPSaved,NewsletterType,NewsletterStatus,NewsletterTitle,NewsletterContent,NewsletterContentText,NewsletterTemplate,NewsletterIsTemplate,NewsletterSubscriberGroup,NewsletterFrom,NewsletterFromName,NewsletterFilter,NewsletterTrackClicks,NewsletterClicks,NewsletterTrackReads,NewsletterReads,NewsletterUnsubscribeLink,NewsletterUnsubscribers,NewsletterComments';
	$databaseDefinition['k']['Newsletter']='NewsletterID';	
	$databaseDefinition['langs']['Newsletter']['NewsletterTitle']='infield';
	$databaseDefinition['langs']['Newsletter']['NewsletterContent']='infield';
	$databaseDefinition['langs']['Newsletter']['NewsletterContentText']='infield';

	$databaseDefinition['t']['NewsletterList']='NewsletterListID,UserID,OwnerID,AdminID,PermUser,PermOwner,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,ListType,ListParentID,ListName,ListDescription,ListPosition,ListComments';
	$databaseDefinition['k']['NewsletterList']='NewsletterListID';
	
	$databaseDefinition['t']['NewsletterSubscriber']='NewsletterSubscriberID,UserID,OwnerID,AdminID,PermUser,PermOwner,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,SubscriberType,SubscriberSource,SubscriberSourceKey,SubscriberStatus,SubscriberEmail,SubscriberFirstName,SubscriberLastName,SubscriberGender,SubscriberCompany,SubscriberStreet,SubscriberCity,SubscriberPostCode,SubscriberRegion,SubscriberCountry,SubscriberPhone,SubscriberFax,SubscriberDescription,SubscriberComments,SubscriberIsConfirmed,SubscriberLanguage,SubscriberNewsletters';
	$databaseDefinition['k']['NewsletterSubscriber']='NewsletterSubscriberID';
?>

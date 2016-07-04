<?
	$databaseDefinition['t']['Domain']='DomainID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,IPCreated,IPSaved,DomainStatus,DomainType,DomainName,DomainClientID,DomainProfileID,DomainClientNumber,DomainTitle,DomainIntro,DomainContent,DomainKeywords,DomainIcon,DomainImage,DomainImagePreview,DomainLanguages,DomainFields';
	$databaseDefinition['k']['Domain']='DomainID';
	$databaseDefinition['langs']['Domain']['DomainIntro']='infield';
	$databaseDefinition['langs']['Domain']['DomainContent']='infield';
	$databaseDefinition['langs']['Domain']['DomainKeywords']='infield';
		
	$databaseDefinition['t']['DomainField']='DomainFieldID,DomainFieldStatus,DomainFieldName,DomainID,DomainTypeFieldID,DomainFieldType,DomainFieldPosition,DomainFieldValue,DomainFieldValueNumber,DomainFieldValueTime';
	$databaseDefinition['k']['DomainField']='DomainFieldID';

	$databaseDefinition['t']['DomainOption']='DomainOptionID,DomainOptionStatus,DomainFieldID,DomainTypeOptionID,DomainOptionPosition,DomainOptionPrice,DomainOptionPriceAction,DomainOptionWeight,DomainOptionWeightAction';
	$databaseDefinition['k']['DomainOption']='DomainOptionID';	

	$databaseDefinition['t']['DomainType']='DomainTypeID,DomainTypeAlias,UserID,OwnerID,PermAll,DomainTemplate,DomainTypeName,DomainTypePosition,DomainTypeDescription,DomainTypeHiddenPlaces';
	$databaseDefinition['k']['DomainType']='DomainTypeID';	
	$databaseDefinition['langs']['DomainType']['DomainTypeName']='infield';
	$databaseDefinition['langs']['DomainType']['DomainTypeDescription']='infield';	
	$databaseDefinition['types']['DomainType']['DomainTypeAlias']='Alias';

	$databaseDefinition['t']['DomainTypeField']='DomainTypeFieldID,DomainTypeFieldAlias,UserID,OwnerID,PermAll,DomainTypeID,DomainType,DomainTypeFieldName,DomainTypeFieldPosition,DomainTypeFieldType,DomainTypeFieldMode,DomainTypeFieldGroups';
	$databaseDefinition['k']['DomainTypeField']='DomainTypeFieldID';	
	$databaseDefinition['langs']['DomainTypeField']['DomainTypeFieldName']='infield';
	$databaseDefinition['langs']['DomainTypeField']['DomainTypeFieldDescription']='infield';	
	$databaseDefinition['types']['DomainTypeField']['DomainTypeFieldAlias']='Alias';

	$databaseDefinition['t']['DomainTypeOption']='DomainTypeOptionID,DomainTypeOptionAlias,UserID,OwnerID,PermAll,DomainTypeFieldID,DomainTypeOptionName,DomainTypeOptionPosition,DomainTypeOptionPrice,DomainTypeOptionPriceAction,DomainTypeOptionWeight,DomainTypeOptionWeightAction';
	$databaseDefinition['k']['DomainTypeOption']='DomainTypeOptionID';	
	$databaseDefinition['langs']['DomainTypeOption']['DomainTypeOptionName']='infield';
	$databaseDefinition['langs']['DomainTypeOption']['DomainTypeOptionDescription']='infield';	
	$databaseDefinition['types']['DomainTypeOption']['DomainTypeOptionAlias']='Alias';

?>

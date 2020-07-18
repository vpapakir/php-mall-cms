<?
	$databaseDefinition['t']['Section']='SectionID,SectionAlias,OwnerID,UserID,TimeCreated,TimeSaved,PermAll,SectionType,SectionLanguages,SectionParentID,SectionGroupID,SectionLayout,SectionBox,SectionBoxStyle,SectionActionType,SectionModule,AccessGroups,AccessEditUsers,SectionArguments,SectionLink,SectionTarget,SectionName,SectionTitle,SectionDescription,SectionListingText,SectionKeywords,SectionHidden,SectionPosition,SectionButton,SectionButtonCurrent,SectionButtonHover,SectionTitleImage,SectionIcon,SectionImage,SectionSound,SectionItemImage,SectionItemImageCurrent,SectionContent,SectionIntroContent,SectionManagementLink,SectionClicks,SectionViewOptions,SectionActionOptions,SectionCommentsOptions,SectionIsHiddenInMenu,SectionViewType,SectionResourceType,SectionShowInSearch';
	$databaseDefinition['k']['Section']='SectionID';
	$databaseDefinition['ktype']['Section']='unique';
	$databaseDefinition['langs']['Section']['SectionName']='infield';
	$databaseDefinition['langs']['Section']['SectionTitle']='infield';
	$databaseDefinition['langs']['Section']['SectionKeywords']='infield';
	$databaseDefinition['langs']['Section']['SectionDescription']='infield';
	$databaseDefinition['langs']['Section']['SectionHidden']='infield';
	$databaseDefinition['langs']['Section']['SectionButton']='infield';
	$databaseDefinition['langs']['Section']['SectionButtonCurrent']='infield';		
	$databaseDefinition['langs']['Section']['SectionButtonHover']='infield';
	$databaseDefinition['langs']['Section']['SectionTitleImage']='infield';
	$databaseDefinition['langs']['Section']['SectionContent']='infield';	
	$databaseDefinition['langs']['Section']['SectionIntroContent']='infield';	
	$databaseDefinition['langs']['Section']['SectionListingText']='infield';	
	$databaseDefinition['types']['Section']['SectionAlias']='Alias';
	
	$databaseDefinition['t']['SectionGroup']='SectionGroupID,SectionGroupCode,OwnerID,UserID,PermAll,TimeCreated,TimeSaved,SectionGroupName,AccessGroups,SectionGroupType,SectionGroupPosition,SectionGroupModule,SectionGroupViewOptions';
	$databaseDefinition['k']['SectionGroup']='SectionGroupID';
	$databaseDefinition['ktype']['SectionGroup']='unique';
	$databaseDefinition['langs']['SectionGroup']['SectionGroupName']='infield';
	$databaseDefinition['langs']['SectionGroup']['SectionGroupName']='infield';
	$databaseDefinition['types']['SectionGroup']['SectionGroupCode']='Alias';
		
	$databaseDefinition['t']['TabLink']='TabLinkID,TabLinkAlias,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,AccessGroups,TabLinkName,TabLinkPosition,TabLinkValue,TabLinkTarget';
	$databaseDefinition['k']['TabLink']='TabLinkID';
	$databaseDefinition['ktype']['TabLink']='unique';
	$databaseDefinition['langs']['TabLink']['TabLinkName']='infield';
	$databaseDefinition['types']['TabLink']['TabLinkAlias']='Alias';
	
	$databaseDefinition['t']['Module']='ModuleID,ModuleAlias,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,ModuleName,ModulePosition,ModuleDescription';
	$databaseDefinition['k']['Module']='ModuleID';	
	$databaseDefinition['ktype']['Module']='unique';
	$databaseDefinition['langs']['Module']['ModuleName']='infield';
	$databaseDefinition['langs']['Module']['ModuleDescription']='infield';
	$databaseDefinition['types']['Module']['ModuleAlias']='Alias';
	
	$databaseDefinition['t']['Language']='LanguageID,LanguageCode,LanguageName,PermAll,LanguageIsDefault,LanguageIcon,LanguageIconActive,LanguagePosition,LanguageTranslationType';
	$databaseDefinition['k']['Language']='LanguageID';	
	$databaseDefinition['langs']['Language']['LanguageName']='infield';
	$databaseDefinition['types']['Language']['LanguageCode']='Alias';
	
	$databaseDefinition['t']['LangField']='LangFieldID,TimeSaved,Code,UserID,OwnerID,PermAll,Value,FileValue,PutLanguages,LockMode';
	$databaseDefinition['k']['LangField']='LangFieldID';	
	$databaseDefinition['langs']['LangField']['Value']='infield';
	$databaseDefinition['langs']['LangField']['FileValue']='infield';
	$databaseDefinition['types']['LangField']['Code']='Alias';

	/*$databaseDefinition['t']['Region']='RegionID,RegionParentID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,RegionGlobalParentID,RegionName,RegionCode,RegionZIP,RegionDescription,RegionType,RegionImportCode,RegionFlag,RegionLogo';
	$databaseDefinition['k']['Region']='RegionID';	
	$databaseDefinition['ktype']['Region']='unique';
	$databaseDefinition['langs']['Region']['RegionName']='infield';
	$databaseDefinition['langs']['Region']['RegionDescription']='infield';
	$databaseDefinition['types']['Region']['RegionCode']='LocationAlias';
	*/
	
	$databaseDefinition['t']['Region']='RegionID,RegionParentID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,RegionGlobalParentID,RegionName,RegionCode,RegionZIP,RegionDescription,RegionType,RegionActionType,RegionImportCode,RegionFlag,RegionLogo';
	$databaseDefinition['k']['Region']='RegionID';	
	$databaseDefinition['ktype']['Region']='unique';
	$databaseDefinition['langs']['Region']['RegionName']='infield';
	$databaseDefinition['langs']['Region']['RegionDescription']='infield';
	$databaseDefinition['types']['Region']['RegionCode']='LocationAlias';
	
	$databaseDefinition['t']['Reference']='ReferenceID,ReferenceCode,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,ReferenceName,ReferenceType,ReferenceModules,ReferenceModule,AccessGroups';
	$databaseDefinition['k']['Reference']='ReferenceID';	
	$databaseDefinition['ktype']['Reference']='unique';
	$databaseDefinition['langs']['Reference']['ReferenceName']='infield';
	$databaseDefinition['types']['Reference']['ReferenceCode']='Alias';
	
	$databaseDefinition['t']['ReferenceOption']='ReferenceOptionID,OptionCode,UserID,OwnerID,TimeCreated,TimeSaved,ReferenceID,OptionName,OptionIcon,OptionPosition';
	$databaseDefinition['k']['ReferenceOption']='ReferenceOptionID';
	$databaseDefinition['ktype']['ReferenceOption']='unique';
	$databaseDefinition['langs']['ReferenceOption']['OptionName']='infield';
	$databaseDefinition['types']['ReferenceOption']['OptionCode']='Alias';
	
	$databaseDefinition['t']['Setting']='SettingID,UserID,OwnerID,TimeCreated,TimeSaved,SettingModule,SettingGroup,SettingVariableName,SettingValue,SettingName,SettingValueType,SettingValueOptions,SettingType,SettingReference,SettingPosition,SettingDescription,SettingSectionID,SettingBoxID';
	$databaseDefinition['k']['Setting']='SettingID';	
	$databaseDefinition['ktype']['Setting']='unique';
	$databaseDefinition['langs']['Setting']['SettingName']='infield';
	$databaseDefinition['langs']['Setting']['SettingDescription']='infield';
		
	$databaseDefinition['t']['SettingGroup']='SettingGroupID,SettingGroupCode,OwnerID,UserID,TimeCreated,TimeSaved,SettingGroupParentID,SettingGroupModule,SettingGroupName,SettingGroupDescription,AccessGroups';
	$databaseDefinition['k']['SettingGroup']='SettingGroupID';
	$databaseDefinition['ktype']['SettingGroup']='unique';
	$databaseDefinition['langs']['SettingGroup']['SettingGroupName']='infield';
	$databaseDefinition['langs']['SettingGroup']['SettingGroupDescription']='infield';
	$databaseDefinition['types']['SettingGroup']['SettingGroupCode']='Alias';
				
	$databaseDefinition['t']['MailTemplate']='MailTemplateID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,MailTemplateCode,MailTemplateGroup,MailTemplateName,MailTemplateBody,MailTemplateBodyText,MailTemplateSubject,MailTemplateDescription,MailTemplateNoHeader,MailTemplateModule';
	$databaseDefinition['k']['MailTemplate']='MailTemplateID';
	$databaseDefinition['ktype']['MailTemplate']='unique';
	$databaseDefinition['langs']['MailTemplate']['MailTemplateName']='infield';
	$databaseDefinition['langs']['MailTemplate']['MailTemplateBody']='infield';
	$databaseDefinition['langs']['MailTemplate']['MailTemplateBodyText']='infield';
	$databaseDefinition['langs']['MailTemplate']['MailTemplateSubject']='infield';
	$databaseDefinition['langs']['MailTemplate']['MailTemplateDescription']='infield';		
	$databaseDefinition['types']['MailTemplate']['MailTemplateCode']='Alias';
	
	$databaseDefinition['t']['MailTemplateGroup']='MailTemplateGroupID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,MailTemplateGroupCode,MailTemplateGroupName,MailTemplateGroupDescription,MailTemplateGroupModule';
	$databaseDefinition['k']['MailTemplateGroup']='MailTemplateGroupID';		
	$databaseDefinition['ktype']['MailTemplateGroup']='unique';
	$databaseDefinition['types']['MailTemplateGroup']['MailTemplateGroupCode']='Alias';
	$databaseDefinition['langs']['MailTemplateGroup']['MailTemplateGroupName']='infield';
	$databaseDefinition['langs']['MailTemplateGroup']['MailTemplateGroupDescription']='infield';
	
	$databaseDefinition['t']['Owner']='OwnerID,UserID,OwnerCode,PermAll,OwnerType,OwnerParentCode,OwnerGroup,OwnerDomain,OwnerName,OwnerIsDefault,OwnerStyle';
	$databaseDefinition['k']['Owner']='OwnerID';	
	$databaseDefinition['langs']['Owner']['OwnerName']='infield';
	$databaseDefinition['types']['Owner']['OwnerCode']='Alias';
	
	$databaseDefinition['t']['View']='ViewID,ViewAlias,OwnerID,UserID,PermAll,TimeCreated,TimeSaved,ViewName,AccessGroups,ViewType,ViewArguments,ViewDescription,ViewTemplateID,ViewIsTemplate';
	$databaseDefinition['k']['View']='ViewID';
	$databaseDefinition['ktype']['View']='unique';	
	$databaseDefinition['langs']['View']['ViewName']='infield';
	$databaseDefinition['langs']['View']['ViewDescription']='infield';
	$databaseDefinition['types']['View']['ViewAlias']='Alias';
	
	$databaseDefinition['t']['ViewBox']='ViewBoxID,OwnerID,UserID,ViewID,BoxID,BoxStyle,BoxSide,BoxPosition';
	$databaseDefinition['k']['ViewBox']='ViewBoxID';		

	$databaseDefinition['t']['SynchronizationItem']='SynchronizationItemID,UserID,OwnerID,SynchronizationItemBox,PermAll,SynchronizationItemLastTime,SynchronizationItemName,SynchronizationItemType,SynchronizationItemStatus';
	$databaseDefinition['k']['SynchronizationItem']='SynchronizationItemID';		
	
	$databaseDefinition['t']['ReferenceCode']='ReferenceCodeID,ReferenceCode,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,ReferenceCodeName,ReferenceCodeType,ReferenceGroupID';
	$databaseDefinition['k']['ReferenceCode']='ReferenceCodeID';	
	$databaseDefinition['ktype']['ReferenceCode']='unique';
	$databaseDefinition['langs']['ReferenceCode']['ReferenceCodeName']='infield';
	$databaseDefinition['types']['ReferenceCode']['ReferenceCode']='Alias';		
	
	$databaseDefinition['t']['ReferenceGenerator']='ReferenceGeneratorID,ReferenceGeneratorCode,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,ReferenceGeneratorName,ReferenceGeneratorType,ReferenceGeneratorGroupID';
	$databaseDefinition['k']['ReferenceGenerator']='ReferenceGeneratorID';	
	$databaseDefinition['ktype']['ReferenceGenerator']='unique';
	$databaseDefinition['langs']['ReferenceGenerator']['ReferenceGeneratorName']='infield';
	$databaseDefinition['types']['ReferenceGenerator']['ReferenceGeneratorCode']='Alias';
?>

<?
	$databaseDefinition['t']['Resource']='ResourceID,ResourceAlias,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,IPCreated,IPSaved,ResourceStatus,ResourceType,ResourceCategories,ResourceLocation,ResourceLocationID,ResourceTitle,ResourceLink,ResourceReciprocalLink,ResourceEmail,ResourceIntro,ResourceIntroText,ResourceContent,ResourceContentText,ResourceKeywords,ResourceMinPrice,ResourcePrice,ResourceMaxPrice,ResourceCurrency,ResourceWeight,ResourceIcon,ResourceImage,ResourceImagePreview,ResourceIcon1,ResourceImage1,ResourceIcon2,ResourceImage2,ResourceIcon3,ResourceImage3,ResourceIcon4,ResourceImage4,ResourceIcon5,ResourceImage5,ResourcePosition,ResourceFeaturedOptions,ResourceAccessType,ResourcePaymentType,ResourcePaymentStatus,ResourcePaymentTime,ResourceRating,ResourceRates,ResourceActivityRate,ResourcePaidRate,ResourceClicks,ResourcePrints,ResourceReviews,ResourceReviewsRate,ResourceDownloads,ResourceComments,ResourceLanguages,ResourceAuthorID,ResourceAuthor,ResourceSites,ResourceFields';
	$databaseDefinition['k']['Resource']='ResourceID';

  $databaseDefinition['t']['ImageText']='id, fullText, iconText, previewText, UserID, OwnerID, PermAll, TimeSaved';
	$databaseDefinition['k']['ImageText']='id';
	
	//$databaseDefinition['ktype']['Resource']='unique';
	$databaseDefinition['langs']['Resource']['ResourceTitle']='infield';
	$databaseDefinition['langs']['Resource']['ResourceIntro']='infield';
	$databaseDefinition['langs']['Resource']['ResourceIntroText']='infield';
	$databaseDefinition['langs']['Resource']['ResourceContent']='infield';
	$databaseDefinition['langs']['Resource']['ResourceContentText']='infield';
	$databaseDefinition['langs']['Resource']['ResourceKeywords']='infield';
	$databaseDefinition['types']['Resource']['ResourceAlias']='Alias';
		
	$databaseDefinition['t']['ResourceField']='ResourceFieldID,ResourceFieldStatus,ResourceFieldName,ResourceID,ResourceTypeFieldID,ResourceFieldType,ResourceFieldPosition,ResourceFieldValue,ResourceFieldValueNumber,ResourceFieldValueTime';
	$databaseDefinition['k']['ResourceField']='ResourceFieldID';

	$databaseDefinition['t']['ResourceOption']='ResourceOptionID,ResourceOptionStatus,ResourceFieldID,ResourceTypeOptionID,ResourceOptionPosition,ResourceOptionPrice,ResourceOptionPriceAction,ResourceOptionWeight,ResourceOptionWeightAction';
	$databaseDefinition['k']['ResourceOption']='ResourceOptionID';	

	$databaseDefinition['t']['ResourceCategory']='ResourceCategoryID,ResourceCategoryAlias,UserID,OwnerID,PermAll,ResourceCategoryParentID,ResourceCategoryStatus,ResourceCategoryTypes,ResourceCategoryPosition,ResourceCategoryTitle,ResourceCategoryDescription,ResourceCategoryKeywords,ResourceCategoryIcon,ResourceCategoryImage,ResourceCategoryImagePreview,ResourceCategoryImageTitle,ResourceCategoryImageButton,ResourceCategoryImageButtonHover,ResourceCategoryImageButtonCurrent,ResourceCategoryAccessType,ResourceCategoryComments,ResourceCategoryItems,ResourceCategoryChildren,ResourceType,ResourceCategoryHiddenPlaces,ResourceCategoryViewOptions,ResouceCategoryActionOptions,ResourceCategoryCommentsOptions,ResourceCategoryIntroContent';
	$databaseDefinition['k']['ResourceCategory']='ResourceCategoryID';
	$databaseDefinition['langs']['ResourceCategory']['ResourceCategoryTitle']='infield';
	$databaseDefinition['langs']['ResourceCategory']['ResourceCategoryKeywords']='infield';
	$databaseDefinition['langs']['ResourceCategory']['ResourceCategoryDescription']='infield';
	$databaseDefinition['langs']['ResourceCategory']['ResourceCategoryIntroContent']='infield';	
	$databaseDefinition['langs']['ResourceCategory']['ResourceCategoryImageTitle']='infield';
	$databaseDefinition['langs']['ResourceCategory']['ResourceCategoryImageButton']='infield';
	$databaseDefinition['langs']['ResourceCategory']['ResourceCategoryImageButtonHover']='infield';
	$databaseDefinition['langs']['ResourceCategory']['ResourceCategoryImageButtonCurrent']='infield';
	$databaseDefinition['types']['ResourceCategory']['ResourceCategoryAlias']='Alias';
	
	$databaseDefinition['t']['ResourceCategoryStat']='ResourceCategoryStatID,UserID,OwnerID,ResourceCategoryID,ResourceType,ResourceCategoryStatItems,ResourceCategoryStatChildren';
	$databaseDefinition['k']['ResourceCategoryStat']='ResourceCategoryStatID';

	$databaseDefinition['t']['ResourceType']='ResourceTypeID,ResourceTypeAlias,UserID,OwnerID,PermAll,ResourceTemplate,ResourceTypeName,ResourceTypePosition,ResourceTypeDescription,ResourceTypeHiddenPlaces,ResourceTypeAction';
	$databaseDefinition['k']['ResourceType']='ResourceTypeID';	
	$databaseDefinition['langs']['ResourceType']['ResourceTypeName']='infield';
	$databaseDefinition['langs']['ResourceType']['ResourceTypeDescription']='infield';	
	$databaseDefinition['types']['ResourceType']['ResourceTypeAlias']='Alias';

	$databaseDefinition['t']['ResourceTypeField']='ResourceTypeFieldID,ResourceTypeFieldAlias,UserID,OwnerID,PermAll,ResourceTypeID,ResourceType,ResourceTypeFieldName,ResourceTypeFieldPosition,ResourceTypeFieldType,ResourceTypeFieldMode,ResourceTypeFieldHidenPlaces';
	$databaseDefinition['k']['ResourceTypeField']='ResourceTypeFieldID';	
	$databaseDefinition['langs']['ResourceTypeField']['ResourceTypeFieldName']='infield';
	$databaseDefinition['langs']['ResourceTypeField']['ResourceTypeFieldDescription']='infield';	
	$databaseDefinition['types']['ResourceTypeField']['ResourceTypeFieldAlias']='Alias';

	$databaseDefinition['t']['ResourceTypeOption']='ResourceTypeOptionID,ResourceTypeOptionAlias,UserID,OwnerID,PermAll,ResourceTypeFieldID,ResourceTypeOptionName,ResourceTypeOptionPosition,ResourceTypeOptionPrice,ResourceTypeOptionPriceAction,ResourceTypeOptionWeight,ResourceTypeOptionWeightAction';
	$databaseDefinition['k']['ResourceTypeOption']='ResourceTypeOptionID';	
	$databaseDefinition['langs']['ResourceTypeOption']['ResourceTypeOptionName']='infield';
	$databaseDefinition['langs']['ResourceTypeOption']['ResourceTypeOptionDescription']='infield';	
	$databaseDefinition['types']['ResourceTypeOption']['ResourceTypeOptionAlias']='Alias';

	$databaseDefinition['t']['Currency']='CurrencyID,CurrencyCode,UserID,OwnerID,PermAll,CurrencyName,CurrencyIsMain';
	$databaseDefinition['k']['Currency']='CurrencyID';	
	$databaseDefinition['langs']['Currency']['CurrencyName']='infield';
	$databaseDefinition['types']['Currency']['CurrencyCode']='Alias';
	
	$databaseDefinition['t']['CurrencyRate']='CurrencyRateID,UserID,OwnerID,CurrencyFrom,CurrencyTo,CurrencyRateValue';
	$databaseDefinition['k']['CurrencyRate']='CurrencyRateID';	

	$databaseDefinition['t']['CartItem']='CartItemID,UserID,OwnerID,SessionID,TimeCreated,TimeSaved,IPCreated,IPSaved,CartItemType,ResourceID,ResourceAlias,ResourceType,ResourceCategories,ResourceTitle,ResourceIntro,ResourceIcon,ResourceLocation,ResourceLocationID,ResourceAuthor,ResourceAuthorID,ResourceFields,CartItemPrice,ResourceCurrency,CartItemWeight,CartItemQuantity';
	$databaseDefinition['k']['CartItem']='CartItemID';	
	
	$databaseDefinition['t']['CartItemField']='CartItemFieldID,CartItemID,ResourceFieldAlias,ResourceTypeFieldID,ResourceFieldType,ResourceFieldMode,ResourceFieldName,ResourceFieldPosition,ResourceFieldValue,ResourceFieldValueNumber,ResourceFieldValueTime,ResourceFieldValueOptions';
	$databaseDefinition['k']['CartItemField']='CartItemFieldID';	
	
	$databaseDefinition['t']['ResourceComment']='ResourceCommentID,UserID,OwnerID,PermAll,TimeCreated,IPCreated,ResourceID,SectionID,ResourceCategoryID,ResourceCommentLocationID,ResourceCommentTitle,ResourceCommentAuthor,ResourceCommentLink,ResourceCommentEmail,ResourceCommentContent,ResourceCommentKeywords,ResourceCommentContactType,ResourceCommentImage';
	$databaseDefinition['k']['ResourceComment']='ResourceCommentID';	

	$databaseDefinition['t']['ResourceLink']='ResourceLinkID,UserID,OwnerID,PermAll,TimeCreated,IPCreated,ResourceID,SectionID,ResourceCategoryID,ResourceLinkLocationID,ResourceLinkTitle,ResourceLinkAuthor,ResourceLinkURL,ResourceLinkEmail,ResourceLinkContent,ResourceLinkImage';
	$databaseDefinition['k']['ResourceLink']='ResourceLinkID';	
	
	$databaseDefinition['t']['ResourceOrder']='ResourceOrderID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,IPCreated,IPSaved,ResourceOrderType,ResourceOrderStatus,ResourceOrderPaymentStatus,ResourceOrderPaymentTime,ResourceOrderPaymentMethod,ResourceOrderDeliveryDate,ResourceOrderDeliveryMethod,ResourceOrderLocation,ResourceOrderFirstName,ResourceOrderLastName,ResourceOrderEmail,ResourceOrderPhone,ResourceOrderCompanyName,ResourceOrderAddress1,ResourceOrderAddress2,ResourceOrderCity,ResourceOrderRegionID,ResourceOrderRegion,ResourceOrderCountryID,ResourceOrderCountry,ResourceOrderPostCode,ResourceOrderBillingFirstName,ResourceOrderBillingLastName,ResourceOrderBillingAddress1,ResourceOrderBillingAddress2,ResourceOrderBillingCity,ResourceOrderBillingRegionID,ResourceOrderBillingRegion,ResourceOrderBillingCountryID,ResourceOrderBillingCountry,ResourceOrderBillingPostCode,ResourceOrderMessage,ResourceOrderWeight,ResourceOrderVolume,ResourceOrderAmount,ResourceOrderShippingAmount,ResourceOrderDiscountAmount,ResourceOrderTaxesAmount,ResourceOrderTotalAmount';
	$databaseDefinition['k']['ResourceOrder']='ResourceOrderID';	

	$databaseDefinition['t']['ResourceOrderItem']='ResourceOrderItemID,UserID,OwnerID,TimeCreated,TimeSaved,ResourceOrderID,ResourceID,ResourceAlias,ResourceType,ResourceCategories,ResourceTitle,ResourceLink,ResourceIntro,ResourceIcon,ResourceLocation,ResourceLocationID,ResourceAuthor,ResourceAuthorID,ResourceFields,ResourceOrderItemPrice,ResourceOrderItemDiscountAmount,ResourceOrderItemWeight,ResourceOrderItemVolume,ResourceOrderItemQuantity';
	$databaseDefinition['k']['ResourceOrderItem']='ResourceOrderItemID';	
	
	$databaseDefinition['t']['ResourceOrderItemField']='ResourceOrderItemFieldID,ResourceOrderItemID,ResourceFieldAlias,ResourceTypeFieldID,ResourceFieldType,ResourceFieldMode,ResourceFieldName,ResourceFieldPosition,ResourceFieldValue,ResourceFieldValueNumber,ResourceFieldValueTime,ResourceFieldValueOptions';
	$databaseDefinition['k']['ResourceOrderItemField']='ResourceOrderItemFieldID';	
	
	$databaseDefinition['t']['ResourceBid']='ResourceBidID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,IPCreated,IPSaved,ResourceID,ResourceBidAuthor,ResourceBidStatus,ResourceBidType,ResourceBidTitle,ResourceBidDescription,ResourceBidPrice,ResourceBidCurrency,ResourceBidLocation,ResourceBidFirstName,ResourceBidLastName,ResourceBidEmail,ResourceBidPhone,ResourceBidCompanyNamem,ResourceBidAddress1,ResourceBidAddress2,ResourceBidCity,ResourceBidCountry,ResourceBidPostCode,ResourceBidComments';
	$databaseDefinition['k']['ResourceBid']='ResourceBidID';		

	$databaseDefinition['t']['ResourceRelation']='ResourceRelationID,UserID,OwnerID,PermAll,TimeCreated,ResourceID,ResourceRelatedID,ResourceRelationPosition';
	$databaseDefinition['k']['ResourceRelation']='ResourceRelationID';	

?>

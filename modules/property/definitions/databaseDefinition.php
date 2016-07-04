<?
	$databaseDefinition['t']['Property']='PropertyID,PropertyAlias,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,IPCreated,IPSaved,PropertyStatus,PropertyType,PropertyActionType,PropertyLocation,PropertyAddress,PropertyLocationID,PropertyTitle,PropertyIntro,PropertyContent,PropertyKeywords,PropertyMinPrice,PropertyPrice,PropertyMaxPrice,PropertyCurrency,PropertyIcon,PropertyImage,PropertyImagePreview,PropertyPosition,PropertyFeaturedOptions,PropertyAccessType,PropertyPaymentType,PropertyPaymentStatus,PropertyPaymentTime,PropertyRating,PropertyRates,PropertyActivityRate,PropertyPaidRate,PropertyClicks,PropertyPrints,PropertyReviews,PropertyReviewsRate,PropertyDownloads,PropertyComments,PropertyLanguages,PropertyFields';
	$databaseDefinition['k']['Property']='PropertyID';
	$databaseDefinition['ktype']['Property']='unique';
	$databaseDefinition['langs']['Property']['PropertyTitle']='infield';
	$databaseDefinition['langs']['Property']['PropertyIntro']='infield';
	$databaseDefinition['langs']['Property']['PropertyContent']='infield';
	$databaseDefinition['langs']['Property']['PropertyKeywords']='infield';
	$databaseDefinition['langs']['Property']['PropertyAddress']='infield';
	$databaseDefinition['types']['Property']['PropertyAlias']='Alias';
		
	$databaseDefinition['t']['PropertyField']='PropertyFieldID,PropertyFieldStatus,PropertyFieldName,PropertyID,PropertyTypeFieldID,PropertyFieldType,PropertyFieldPosition,PropertyFieldValue,PropertyFieldValueNumber,PropertyFieldValueTime';
	$databaseDefinition['ktype']['PropertyField']='unique';
	$databaseDefinition['k']['PropertyField']='PropertyFieldID';

	$databaseDefinition['t']['PropertyOption']='PropertyOptionID,PropertyOptionStatus,PropertyFieldID,PropertyTypeOptionID,PropertyOptionPosition,PropertyOptionPrice,PropertyOptionPriceAction,PropertyOptionWeight,PropertyOptionWeightAction';
	$databaseDefinition['ktype']['PropertyOption']='unique';
	$databaseDefinition['k']['PropertyOption']='PropertyOptionID';	

	$databaseDefinition['t']['PropertyType']='PropertyTypeID,PropertyTypeAlias,UserID,OwnerID,PermAll,PropertyTemplate,PropertyTypeName,PropertyTypePosition,PropertyTypeDescription,PropertyTypeHiddenPlaces';
	$databaseDefinition['k']['PropertyType']='PropertyTypeID';	
	$databaseDefinition['ktype']['PropertyType']='unique';
	$databaseDefinition['langs']['PropertyType']['PropertyTypeName']='infield';
	$databaseDefinition['langs']['PropertyType']['PropertyTypeDescription']='infield';	
	$databaseDefinition['types']['PropertyType']['PropertyTypeAlias']='Alias';

	$databaseDefinition['t']['PropertyTypeField']='PropertyTypeFieldID,PropertyTypeFieldAlias,UserID,OwnerID,PermAll,PropertyTypeID,PropertyType,PropertyTypeFieldName,PropertyTypeFieldPosition,PropertyTypeFieldType,PropertyTypeFieldMode,PropertyTypeFieldHidenPlaces,PropertyTypeFieldParts';
	$databaseDefinition['k']['PropertyTypeField']='PropertyTypeFieldID';
	$databaseDefinition['ktype']['PropertyTypeField']='unique';	
	$databaseDefinition['langs']['PropertyTypeField']['PropertyTypeFieldName']='infield';
	$databaseDefinition['langs']['PropertyTypeField']['PropertyTypeFieldDescription']='infield';	
	$databaseDefinition['types']['PropertyTypeField']['PropertyTypeFieldAlias']='Alias';

	$databaseDefinition['t']['PropertyTypeOption']='PropertyTypeOptionID,PropertyTypeOptionAlias,UserID,OwnerID,PermAll,PropertyTypeFieldID,PropertyTypeOptionName,PropertyTypeOptionPosition,PropertyTypeOptionPrice,PropertyTypeOptionPriceAction,PropertyTypeOptionWeight,PropertyTypeOptionWeightAction';
	$databaseDefinition['k']['PropertyTypeOption']='PropertyTypeOptionID';
	$databaseDefinition['ktype']['PropertyTypeOption']='unique';	
	$databaseDefinition['langs']['PropertyTypeOption']['PropertyTypeOptionName']='infield';
	$databaseDefinition['langs']['PropertyTypeOption']['PropertyTypeOptionDescription']='infield';	
	$databaseDefinition['types']['PropertyTypeOption']['PropertyTypeOptionAlias']='Alias';

	$databaseDefinition['t']['PropertyResource']='PropertyResourceID,PropertyResourceCode,UserID,OwnerID,PermAll,PropertyResourceParentID,PropertyID,PropertyResourceType,PropertyResourceName,PropertyResourceDescription,PropertyResourcePosition,PropertyResourceArea,PropertyResourcePreviewImage,PropertyResourceImage,PropertyResourceIcon';
	$databaseDefinition['k']['PropertyResource']='PropertyResourceID';
	$databaseDefinition['ktype']['PropertyResource']='unique';
	$databaseDefinition['langs']['PropertyResource']['PropertyResourceName']='infield';
	$databaseDefinition['langs']['PropertyResource']['PropertyResourceDescription']='infield';
	
	$databaseDefinition['t']['PropertyCartItem']='CartItemID,UserID,OwnerID,SessionID,TimeCreated,TimeSaved,IPCreated,IPSaved,CartItemType,PropertyID,PropertyAlias,PropertyType,PropertyTitle,PropertyIntro,PropertyIcon,PropertyLocation,PropertyLocationID,PropertyAuthor,PropertyAuthorID,PropertyFields,CartItemPrice,PropertyCurrency,CartItemWeight,CartItemQuantity';
	$databaseDefinition['k']['PropertyCartItem']='CartItemID';	
	
	$databaseDefinition['t']['PropertyCartItemField']='CartItemFieldID,CartItemID,PropertyFieldAlias,PropertyTypeFieldID,PropertyFieldType,PropertyFieldMode,PropertyFieldName,PropertyFieldPosition,PropertyFieldValue,PropertyFieldValueNumber,PropertyFieldValueTime,PropertyFieldValueOptions';
	$databaseDefinition['k']['PropertyCartItemField']='CartItemFieldID';	
	
	$databaseDefinition['t']['PropertyComment']='PropertyCommentID,UserID,OwnerID,PermAll,TimeCreated,IPCreated,PropertyID,SectionID,PropertyCommentLocationID,PropertyCommentTitle,PropertyCommentAuthor,PropertyCommentLink,PropertyCommentEmail,PropertyCommentContent,PropertyCommentKeywords,PropertyCommentContactType,PropertyCommentImage';
	$databaseDefinition['ktype']['PropertyComment']='unique';
	$databaseDefinition['k']['PropertyComment']='PropertyCommentID';	

	$databaseDefinition['t']['PropertyOrder']='PropertyOrderID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,IPCreated,IPSaved,PropertyOrderIndex,PropertyOrderIndexPrefix,PropertyOrderType,PropertyOrderStatus,PropertyOrderPaymentStatus,PropertyOrderPaymentTime,PropertyOrderPaymentMethod,PropertyOrderDeliveryDate,PropertyOrderDeliveryMethod,PropertyOrderLocation,PropertyOrderFirstName,PropertyOrderLastName,PropertyOrderEmail,PropertyOrderPhone,PropertyOrderCompanyName,PropertyOrderAddress1,PropertyOrderAddress2,PropertyOrderPostCode,PropertyOrderBillingFirstName,PropertyOrderBillingLastName,PropertyOrderBillingLocation,PropertyOrderBillingAddress1,PropertyOrderBillingAddress2,PropertyOrderBillingPostCode,PropertyOrderMessage,PropertyOrderCurrency,PropertyOrderAmount,PropertyOrderDiscountAmount,PropertyOrderTaxesAmount,PropertyOrderTotalAmount';
	$databaseDefinition['ktype']['PropertyOrder']='unique';
	$databaseDefinition['k']['PropertyOrder']='PropertyOrderID';	

	$databaseDefinition['t']['PropertyOrderItem']='PropertyOrderItemID,UserID,OwnerID,TimeCreated,TimeSaved,PropertyOrderID,PropertyID,PropertyAlias,PropertyType,PropertyActionType,PropertyLocation,PropertyAddress,PropertyLocationID,PropertyTitle,PropertyIntro,PropertyContent,PropertyIcon,PropertyImage,PropertyImagePreview,PropertyComments,PropertyFields,PropertyCurrency,PropertyOrderItemPrice,PropertyOrderItemDiscountAmount,PropertyOrderItemQuantity';
	$databaseDefinition['ktype']['PropertyOrderItem']='unique';
	$databaseDefinition['k']['PropertyOrderItem']='PropertyOrderItemID';	
	
	$databaseDefinition['t']['PropertyOrderItemField']='PropertyOrderItemFieldID,PropertyOrderItemID,PropertyFieldAlias,PropertyTypeFieldID,PropertyFieldType,PropertyFieldMode,PropertyFieldName,PropertyFieldPosition,PropertyFieldValue,PropertyFieldValueNumber,PropertyFieldValueTime,PropertyFieldValueOptions';
	$databaseDefinition['ktype']['PropertyOrderItemField']='unique';
	$databaseDefinition['k']['PropertyOrderItemField']='PropertyOrderItemFieldID';	

	//$databaseDefinition['t']['PropertyRelation']='PropertyRelationID,UserID,OwnerID,PermAll,TimeCreated,PropertyID,PropertyRelatedID,PropertyRelationPosition';
	//$databaseDefinition['k']['PropertyRelation']='PropertyRelationID';	

?>

<?
	$databaseDefinition['t']['ReservedProperty']='ReservedPropertyID,ReservedPropertyAlias,ReservedPropertyIndex,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,IPCreated,IPSaved,ReservedPropertyStatus,ReservedPropertyType,ReservedPropertyActionType,ReservedPropertyLocation,ReservedPropertyPostCode,ReservedPropertyAddress,ReservedPropertyLocationID,ReservedPropertyTitle,ReservedPropertyIntro,ReservedPropertyContent,ReservedPropertyKeywords,ReservedPropertyMinPrice,ReservedPropertyPrice,ReservedPropertyMaxPrice,ReservedPropertyCurrency,ReservedPropertyPriceComments,ReservedPropertyIcon,ReservedPropertyImage,ReservedPropertyImagePreview,ReservedPropertyPosition,ReservedPropertyFeaturedOptions,ReservedPropertyAccessType,ReservedPropertyPaymentType,ReservedPropertyPaymentStatus,ReservedPropertyPaymentTime,ReservedPropertyRating,ReservedPropertyRates,ReservedPropertyActivityRate,ReservedPropertyPaidRate,ReservedPropertyClicks,ReservedPropertyPrints,ReservedPropertyReviews,ReservedPropertyReviewsRate,ReservedPropertyDownloads,ReservedPropertyComments,ReservedPropertyLanguages,ReservedPropertyFields';
	$databaseDefinition['k']['ReservedProperty']='ReservedPropertyID';
	$databaseDefinition['ktype']['ReservedProperty']='unique';
	$databaseDefinition['langs']['ReservedProperty']['ReservedPropertyTitle']='infield';
	$databaseDefinition['langs']['ReservedProperty']['ReservedPropertyIntro']='infield';
	$databaseDefinition['langs']['ReservedProperty']['ReservedPropertyContent']='infield';
	$databaseDefinition['langs']['ReservedProperty']['ReservedPropertyKeywords']='infield';
	$databaseDefinition['langs']['ReservedProperty']['ReservedPropertyAddress']='infield';
	$databaseDefinition['types']['ReservedProperty']['ReservedPropertyAlias']='Alias';
	$databaseDefinition['types']['ReservedProperty']['ReservedPropertyLocation']='Location';
		
	$databaseDefinition['t']['ReservedPropertyField']='ReservedPropertyFieldID,ReservedPropertyFieldStatus,ReservedPropertyFieldName,ReservedPropertyID,ReservedPropertyTypeFieldID,ReservedPropertyFieldType,ReservedPropertyFieldPosition,ReservedPropertyFieldValue,ReservedPropertyFieldValueNumber,ReservedPropertyFieldValueTime';
	$databaseDefinition['ktype']['ReservedPropertyField']='unique';
	$databaseDefinition['k']['ReservedPropertyField']='ReservedPropertyFieldID';

	$databaseDefinition['t']['ReservedPropertyOption']='ReservedPropertyOptionID,ReservedPropertyOptionStatus,ReservedPropertyFieldID,ReservedPropertyTypeOptionID,ReservedPropertyOptionPosition,ReservedPropertyOptionPrice,ReservedPropertyOptionPriceAction,ReservedPropertyOptionWeight,ReservedPropertyOptionWeightAction';
	$databaseDefinition['ktype']['ReservedPropertyOption']='unique';
	$databaseDefinition['k']['ReservedPropertyOption']='ReservedPropertyOptionID';	

	$databaseDefinition['t']['ReservedPropertyType']='ReservedPropertyTypeID,ReservedPropertyTypeAlias,UserID,OwnerID,PermAll,ReservedPropertyTemplate,ReservedPropertyTypeName,ReservedPropertyTypePosition,ReservedPropertyTypeDescription,ReservedPropertyTypeHiddenPlaces';
	$databaseDefinition['k']['ReservedPropertyType']='ReservedPropertyTypeID';	
	$databaseDefinition['ktype']['ReservedPropertyType']='unique';
	$databaseDefinition['langs']['ReservedPropertyType']['ReservedPropertyTypeName']='infield';
	$databaseDefinition['langs']['ReservedPropertyType']['ReservedPropertyTypeDescription']='infield';	
	$databaseDefinition['types']['ReservedPropertyType']['ReservedPropertyTypeAlias']='Alias';

	$databaseDefinition['t']['ReservedPropertyTypeField']='ReservedPropertyTypeFieldID,ReservedPropertyTypeFieldAlias,UserID,OwnerID,PermAll,ReservedPropertyTypeID,ReservedPropertyType,ReservedPropertyTypeFieldName,ReservedPropertyTypeFieldPosition,ReservedPropertyTypeFieldType,ReservedPropertyTypeFieldMode,ReservedPropertyTypeFieldHidenPlaces,ReservedPropertyTypeFieldParts';
	$databaseDefinition['k']['ReservedPropertyTypeField']='ReservedPropertyTypeFieldID';
	$databaseDefinition['ktype']['ReservedPropertyTypeField']='unique';	
	$databaseDefinition['langs']['ReservedPropertyTypeField']['ReservedPropertyTypeFieldName']='infield';
	$databaseDefinition['langs']['ReservedPropertyTypeField']['ReservedPropertyTypeFieldDescription']='infield';	
	$databaseDefinition['types']['ReservedPropertyTypeField']['ReservedPropertyTypeFieldAlias']='Alias';

	$databaseDefinition['t']['ReservedPropertyTypeOption']='ReservedPropertyTypeOptionID,ReservedPropertyTypeOptionAlias,UserID,OwnerID,PermAll,ReservedPropertyTypeFieldID,ReservedPropertyTypeOptionName,ReservedPropertyTypeOptionPosition,ReservedPropertyTypeOptionPrice,ReservedPropertyTypeOptionPriceAction,ReservedPropertyTypeOptionWeight,ReservedPropertyTypeOptionWeightAction';
	$databaseDefinition['k']['ReservedPropertyTypeOption']='ReservedPropertyTypeOptionID';
	$databaseDefinition['ktype']['ReservedPropertyTypeOption']='unique';	
	$databaseDefinition['langs']['ReservedPropertyTypeOption']['ReservedPropertyTypeOptionName']='infield';
	$databaseDefinition['langs']['ReservedPropertyTypeOption']['ReservedPropertyTypeOptionDescription']='infield';	
	$databaseDefinition['types']['ReservedPropertyTypeOption']['ReservedPropertyTypeOptionAlias']='Alias';

	$databaseDefinition['t']['ReservedPropertyResource']='ReservedPropertyResourceID,ReservedPropertyResourceCode,UserID,OwnerID,PermAll,ReservedPropertyResourceParentID,ReservedPropertyID,ReservedPropertyResourceType,ReservedPropertyResourceName,ReservedPropertyResourceDescription,ReservedPropertyResourcePosition,ReservedPropertyResourceArea,ReservedPropertyResourcePreviewImage,ReservedPropertyResourceImage,ReservedPropertyResourceIcon';
	$databaseDefinition['k']['ReservedPropertyResource']='ReservedPropertyResourceID';
	$databaseDefinition['ktype']['ReservedPropertyResource']='unique';
	$databaseDefinition['langs']['ReservedPropertyResource']['ReservedPropertyResourceName']='infield';
	$databaseDefinition['langs']['ReservedPropertyResource']['ReservedPropertyResourceDescription']='infield';
	
	$databaseDefinition['t']['ReservedPropertyCartItem']='CartItemID,UserID,OwnerID,SessionID,TimeCreated,TimeSaved,IPCreated,IPSaved,CartItemType,ReservedPropertyID,ReservedPropertyAlias,ReservedPropertyType,ReservedPropertyTitle,ReservedPropertyIntro,ReservedPropertyIcon,ReservedPropertyLocation,ReservedPropertyLocationID,ReservedPropertyAuthor,ReservedPropertyAuthorID,ReservedPropertyFields,CartItemPrice,ReservedPropertyCurrency,CartItemWeight,CartItemQuantity';
	$databaseDefinition['k']['ReservedPropertyCartItem']='CartItemID';	
	
	$databaseDefinition['t']['ReservedPropertyCartItemField']='CartItemFieldID,CartItemID,ReservedPropertyFieldAlias,ReservedPropertyTypeFieldID,ReservedPropertyFieldType,ReservedPropertyFieldMode,ReservedPropertyFieldName,ReservedPropertyFieldPosition,ReservedPropertyFieldValue,ReservedPropertyFieldValueNumber,ReservedPropertyFieldValueTime,ReservedPropertyFieldValueOptions';
	$databaseDefinition['k']['ReservedPropertyCartItemField']='CartItemFieldID';	
	
	$databaseDefinition['t']['ReservedPropertyComment']='ReservedPropertyCommentID,UserID,OwnerID,PermAll,TimeCreated,IPCreated,ReservedPropertyID,SectionID,ReservedPropertyCommentLocationID,ReservedPropertyCommentTitle,ReservedPropertyCommentAuthor,ReservedPropertyCommentLink,ReservedPropertyCommentEmail,ReservedPropertyCommentContent,ReservedPropertyCommentKeywords,ReservedPropertyCommentContactType,ReservedPropertyCommentImage';
	$databaseDefinition['ktype']['ReservedPropertyComment']='unique';
	$databaseDefinition['k']['ReservedPropertyComment']='ReservedPropertyCommentID';	

	$databaseDefinition['t']['ReservedPropertyOrder']='ReservedPropertyOrderID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,IPCreated,IPSaved,ReservedPropertyOrderIndex,ReservedPropertyOrderIndexPrefix,ReservedPropertyOrderType,ReservedPropertyOrderStatus,ReservedPropertyOrderPaymentStatus,ReservedPropertyOrderPaymentTime,ReservedPropertyOrderPaymentMethod,ReservedPropertyOrderDeliveryDate,ReservedPropertyOrderDeliveryMethod,ReservedPropertyOrderLocation,ReservedPropertyOrderFirstName,ReservedPropertyOrderLastName,ReservedPropertyOrderEmail,ReservedPropertyOrderPhone,ReservedPropertyOrderCompanyName,ReservedPropertyOrderAddress1,ReservedPropertyOrderAddress2,ReservedPropertyOrderPostCode,ReservedPropertyOrderBillingFirstName,ReservedPropertyOrderBillingLastName,ReservedPropertyOrderBillingLocation,ReservedPropertyOrderBillingAddress1,ReservedPropertyOrderBillingAddress2,ReservedPropertyOrderBillingPostCode,ReservedPropertyOrderMessage,ReservedPropertyOrderCurrency,ReservedPropertyOrderAmount,ReservedPropertyOrderDiscountAmount,ReservedPropertyOrderTaxesAmount,ReservedPropertyOrderTotalAmount';
	$databaseDefinition['ktype']['ReservedPropertyOrder']='unique';
	$databaseDefinition['k']['ReservedPropertyOrder']='ReservedPropertyOrderID';	

	$databaseDefinition['t']['ReservedPropertyOrderItem']='ReservedPropertyOrderItemID,UserID,OwnerID,TimeCreated,TimeSaved,ReservedPropertyOrderID,ReservedPropertyID,ReservedPropertyAlias,ReservedPropertyType,ReservedPropertyActionType,ReservedPropertyLocation,ReservedPropertyAddress,ReservedPropertyLocationID,ReservedPropertyTitle,ReservedPropertyIntro,ReservedPropertyContent,ReservedPropertyIcon,ReservedPropertyImage,ReservedPropertyImagePreview,ReservedPropertyComments,ReservedPropertyFields,ReservedPropertyCurrency,ReservedPropertyOrderItemPrice,ReservedPropertyOrderItemDiscountAmount,ReservedPropertyOrderItemQuantity';
	$databaseDefinition['ktype']['ReservedPropertyOrderItem']='unique';
	$databaseDefinition['k']['ReservedPropertyOrderItem']='ReservedPropertyOrderItemID';	
	
	$databaseDefinition['t']['ReservedPropertyOrderItemField']='ReservedPropertyOrderItemFieldID,ReservedPropertyOrderItemID,ReservedPropertyFieldAlias,ReservedPropertyTypeFieldID,ReservedPropertyFieldType,ReservedPropertyFieldMode,ReservedPropertyFieldName,ReservedPropertyFieldPosition,ReservedPropertyFieldValue,ReservedPropertyFieldValueNumber,ReservedPropertyFieldValueTime,ReservedPropertyFieldValueOptions';
	$databaseDefinition['ktype']['ReservedPropertyOrderItemField']='unique';
	$databaseDefinition['k']['ReservedPropertyOrderItemField']='ReservedPropertyOrderItemFieldID';	

	//$databaseDefinition['t']['ReservedPropertyRelation']='ReservedPropertyRelationID,UserID,OwnerID,PermAll,TimeCreated,ReservedPropertyID,ReservedPropertyRelatedID,ReservedPropertyRelationPosition';
	//$databaseDefinition['k']['ReservedPropertyRelation']='ReservedPropertyRelationID';	

?>

<?
	$databaseDefinition['t']['Tour']='TourID,TourAlias,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,IPCreated,IPSaved,TourStatus,TourType,TourCategories,TourContactFirstName,TourContactLastName,TourContactAddress,TourContactCity,TourContactPostalCode,TourContactRegionID,TourContactRegion,TourContactCountryID,TourContactPhone,TourContactFax,TourContactEmail,TourContactWebsite,TourContactICQ,TourContactSkype,TourContactAccessOptions,TourContactComments,TourActionOptions,TourLocation,TourCountryID,TourRegionID,TourRegion,TourCityID,TourCity,TourTitle,TourLink,TourReciprocalLink,TourEmail,TourIntro,TourIntroText,TourContent,TourContentText,TourKeywords,TourMinPrice,TourPrice,TourMaxPrice,TourCurrency,TourWeight,TourIcon,TourImage,TourImagePreview,TourIcon1,TourImage1,TourIcon2,TourImage2,TourIcon3,TourImage3,TourIcon4,TourImage4,TourIcon5,TourImage5,TourPosition,TourFeaturedOptions,TourAccessType,TourPaymentType,TourPaymentStatus,TourPaymentTime,TourRating,TourRates,TourActivityRate,TourPaidRate,TourClicks,TourPrints,TourReviews,TourReviewsRate,TourDownloads,TourComments,TourLanguages,TourAuthorID,TourAuthor,TourSites,TourFields,TourTown,UserComments';
	$databaseDefinition['k']['Tour']='TourID';
	$databaseDefinition['langs']['Tour']['TourTitle']='infield';
	$databaseDefinition['langs']['Tour']['TourIntro']='infield';
	$databaseDefinition['langs']['Tour']['TourIntroText']='infield';
	$databaseDefinition['langs']['Tour']['TourContent']='infield';
	$databaseDefinition['langs']['Tour']['TourContentText']='infield';
	$databaseDefinition['langs']['Tour']['TourKeywords']='infield';
	$databaseDefinition['types']['Tour']['TourAlias']='Alias';
		
	$databaseDefinition['t']['TourField']='TourFieldID,TourFieldStatus,TourFieldName,TourID,TourTypeFieldID,TourFieldType,TourFieldPosition,TourFieldValue,TourFieldValueNumber,TourFieldValueTime';
	$databaseDefinition['k']['TourField']='TourFieldID';

	$databaseDefinition['t']['TourOption']='TourOptionID,TourOptionStatus,TourFieldID,TourTypeOptionID,TourOptionPosition,TourOptionValue1,TourOptionValue2,TourOptionValue3,TourOptionValue4';
	$databaseDefinition['k']['TourOption']='TourOptionID';	

	$databaseDefinition['t']['TourCategory']='TourCategoryID,TourCategoryAlias,UserID,OwnerID,PermAll,TourCategoryParentID,TourCategoryStatus,TourCategoryTypes,TourCategoryPosition,TourCategoryTitle,TourCategoryDescription,TourCategoryKeywords,TourCategoryIcon,TourCategoryImage,TourCategoryImagePreview,TourCategoryAccessType,TourCategoryComments,TourCategoryItems,TourCategoryChildren';
	$databaseDefinition['k']['TourCategory']='TourCategoryID';
	$databaseDefinition['langs']['TourCategory']['TourCategoryTitle']='infield';
	$databaseDefinition['langs']['TourCategory']['TourCategoryKeywords']='infield';
	$databaseDefinition['langs']['TourCategory']['TourCategoryDescription']='infield';
	
	$databaseDefinition['t']['TourCategoryStat']='TourCategoryStatID,UserID,OwnerID,TourCategoryID,TourType,TourCategoryStatItems,TourCategoryStatChildren';
	$databaseDefinition['k']['TourCategoryStat']='TourCategoryStatID';

	$databaseDefinition['t']['TourType']='TourTypeID,TourTypeAlias,UserID,OwnerID,PermAll,TourTemplate,TourTypeName,TourTypePosition,TourTypeDescription,TourTypeHiddenPlaces';
	$databaseDefinition['k']['TourType']='TourTypeID';	
	$databaseDefinition['langs']['TourType']['TourTypeName']='infield';
	$databaseDefinition['langs']['TourType']['TourTypeDescription']='infield';	
	$databaseDefinition['types']['TourType']['TourTypeAlias']='Alias';

	$databaseDefinition['t']['TourTypeField']='TourTypeFieldID,TourTypeFieldAlias,UserID,OwnerID,PermAll,TourTypeID,TourType,TourTypeFieldName,TourTypeFieldPosition,TourTypeFieldType,TourTypeFieldMode,TourTypeFieldHidenPlaces';
	$databaseDefinition['k']['TourTypeField']='TourTypeFieldID';	
	$databaseDefinition['langs']['TourTypeField']['TourTypeFieldName']='infield';
	$databaseDefinition['langs']['TourTypeField']['TourTypeFieldDescription']='infield';	
	$databaseDefinition['types']['TourTypeField']['TourTypeFieldAlias']='Alias';

	$databaseDefinition['t']['TourTypeOption']='TourTypeOptionID,TourTypeOptionAlias,UserID,OwnerID,PermAll,TourTypeFieldID,TourTypeOptionName,TourTypeOptionPosition,TourTypeOptionPrice,TourTypeOptionPriceAction,TourTypeOptionWeight,TourTypeOptionWeightAction';
	$databaseDefinition['k']['TourTypeOption']='TourTypeOptionID';	
	$databaseDefinition['langs']['TourTypeOption']['TourTypeOptionName']='infield';
	$databaseDefinition['langs']['TourTypeOption']['TourTypeOptionDescription']='infield';	
	$databaseDefinition['types']['TourTypeOption']['TourTypeOptionAlias']='Alias';

	$databaseDefinition['t']['TourComment']='TourCommentID,UserID,OwnerID,PermAll,TimeCreated,IPCreated,TourID,SectionID,TourCategoryID,TourCommentLocationID,TourCommentTitle,TourCommentAuthor,TourCommentLink,TourCommentEmail,TourCommentContent,TourCommentKeywords,TourCommentContactType,TourCommentImage';
	$databaseDefinition['k']['TourComment']='TourCommentID';	

	$databaseDefinition['t']['TourRate']='TourRateID,UserID,OwnerID,PermAll,TimeCreated,IPCreated,TourID,ServiceType,RoomType,SeasonType,TourRatePrice,TourRatePricePerPerson,TourRateMinimumNights,TourRateComments';
	$databaseDefinition['k']['TourRate']='TourRateID';	

	$databaseDefinition['t']['TourCartItem']='TourCartItemID,UserID,OwnerID,SessionID,TimeCreated,TimeSaved,IPCreated,IPSaved,TourCartItemType,TourID,TourAlias,TourType,TourCategories,TourTitle,TourIntro,TourIcon,TourLocation,TourLocationID,TourCountryID,TourRegionID,TourCityID,TourAuthor,TourAuthorID,TourFields,TourCartItemPrice,TourCurrency,TourCartItemWeight,TourCartItemQuantity';
	$databaseDefinition['k']['TourCartItem']='TourCartItemID';	
	
	$databaseDefinition['t']['TourCartItemField']='TourCartItemFieldID,TourCartItemID,TourFieldAlias,TourTypeFieldID,TourFieldType,TourFieldMode,TourFieldName,TourFieldPosition,TourFieldValue,TourFieldValueNumber,TourFieldValueTime,TourFieldValueOptions';
	$databaseDefinition['k']['TourCartItemField']='TourCartItemFieldID';	
	
	$databaseDefinition['t']['TourOrder']='TourOrderID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,IPCreated,IPSaved,TourOrderType,TourOrderStatus,TourOrderLanguage,TourOrderDestimation,TourOrderPaymentStatus,TourOrderPaymentTime,TourOrderPaymentMethod,TourOrderDeliveryDate,TourOrderDeliveryMethod,TourOrderLocation,TourOrderFullName,TourOrderEmail,TourOrderPhone,TourOrderCompanyName,TourOrderAddress,TourOrderCity,TourOrderRegionID,TourOrderRegion,TourOrderCountryID,TourOrderCountry,TourOrderPostCode,TourOrderICQ,TourOrderSkype,TourOrderMessage,TourOrderFlightFromTo,TourOrderTransfers,TourOrderNumberOfAdults,TourOrderNumberOfChildren,TourOrderAgeOfChildren,TourOrderAmount,TourOrderDiscountAmount,TourOrderTaxesAmount,TourOrderTotalAmount,TourOrderFlightAmount,TourOrderFlightAmountComment,TourOrderTransferAmount,TourOrderTransferAmountComment,TourOrderAssistanceAmount,TourOrderAssistanceAmountComment,TourOrderAccommodationAmount,TourOrderAccommodationAmountComment,TourOrderCarRentalAmount,TourOrderCarRentalAmountComment,TourOrderExcursionsAmount,TourOrderExcursionsAmountComment,TourOrderOtherServicesAmount,TourOrderOtherServicesAmountComment,TourOrderInsuranceAmount,TourOrderInsuranceAmountComment,TourOrderConfidentialInfo,TourOrderRemarksForClient,TourOrderAmountComment,TourOrderDeparture,TourOrderReturn,TourOrderProgramStart,TourOrderProgramEnd,TourOrderNextPresentation,TourOrderAgents,TourOrderAgentsComment,TourOrderTransfers,TourOrderPayment,TourOrderPaymentComment,TourOrderDueDate,TourOrderDueDateComment';
	$databaseDefinition['k']['TourOrder']='TourOrderID';	

	$databaseDefinition['t']['TourOrderItem']='TourOrderItemID,UserID,OwnerID,TimeCreated,TimeSaved,TourOrderID,TourID,TourAlias,TourType,TourCategories,TourTitle,TourIntro,TourIcon,TourOrderItemDeparture,TourCountryID,TourLocation,TourLocationID,TourAuthor,TourAuthorID,TourFields,TourOrderItemPrice,TourOrderItemDiscountAmount,TourOrderItemWeight,TourOrderItemVolume,TourOrderItemQuantity,TourOrderItemMessage,TourAvailableRoomsValue1,TourAvailableBoardValue1';
	$databaseDefinition['k']['TourOrderItem']='TourOrderItemID';	
	
	$databaseDefinition['t']['TourOrderItemField']='TourOrderItemFieldID,TourOrderItemID,TourFieldAlias,TourTypeFieldID,TourFieldType,TourFieldMode,TourFieldName,TourFieldPosition,TourFieldValue,TourFieldValueNumber,TourFieldValueTime,TourFieldValueOptions';
	$databaseDefinition['k']['TourOrderItemField']='TourOrderItemFieldID';	
	
	$databaseDefinition['t']['TourParticipant']='TourParticipantID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TourOrderID,TourParticipantDate,TourParticipantName,TourParticipantPassport';
	$databaseDefinition['k']['TourParticipant']='TourParticipantID';	
	
	$databaseDefinition['t']['TourProgram']='TourProgramID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TourOrderID,TourProgramDate,TourProgramMessage,TourProgramConfidentialMessage';
	$databaseDefinition['k']['TourProgram']='TourProgramID';		
?>

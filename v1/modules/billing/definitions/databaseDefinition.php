<?
	$databaseDefinition['t']['BillingOrder']='BillingOrderID,UserID,OwnerID,PermAll,IPCreated,IPSaved,TimeCreated,TimeSaved,TimeStart,TimeEnd,OrderType,OrderResultService,OrderResultMethod,OrderResultRequest,OrderAmount,OrderCommissionsAmount,OrderTaxAmount,OrderDiscountAmount,OrderAmountToPay,OrderCurrency,OrderStatus,OrderStatusDate,OrderPaymentStatus,OrderPaymentDate,OrderPaymentMethod,OrderPaymentDetails,OrderDescription,OrderReturnURL,OrderComments,OrderCreatorID';
	$databaseDefinition['k']['BillingOrder']='BillingOrderID';
	
	$databaseDefinition['t']['BillingTransaction']='BillingTransactionID,UserID,OwnerID,PermAll,IPCreated,IPSaved,TimeCreated,TimeSaved,TimeStart,TimeEnd,TransactionType,TransactionCreator,TransactionSenderID,TransactionSenderAccount,TransactionReceiverID,TransactionReceiverAccount,TransactionOrderID,TransactionReason,TransactionReasonDescription,TransactionAmount,TransactionComments';
	$databaseDefinition['k']['BillingTransaction']='BillingTransactionID';
	
	$databaseDefinition['t']['PaymentMethod']='PaymentMethodID,PaymentMethodAlias,UserID,OwnerID,PermAll,PaymentMethodName,PaymentMethodPosition,PaymentMethodDescription';
	$databaseDefinition['k']['PaymentMethod']='PaymentMethodID';
	$databaseDefinition['langs']['PaymentMethod']['PaymentMethodName']='infield';	
	$databaseDefinition['langs']['PaymentMethod']['PaymentMethodDescription']='infield';	

	$databaseDefinition['t']['PaymentMethodSetting']='PaymentMethodSettingID,UserID,OwnerID,PaymentMethodID,SettingVariableName,SettingValue,SettingName,SettingValueType,SettingValueOptions,SettingType,SettingDescription';
	$databaseDefinition['k']['PaymentMethodSetting']='PaymentMethodSettingID';
	$databaseDefinition['langs']['PaymentMethodSetting']['SettingName']='infield';	
	$databaseDefinition['langs']['PaymentMethodSetting']['SettingDescription']='infield';

	$databaseDefinition['t']['Service']='ServiceID,UserID,OwnerID,PermAll,TimeCreated,TimeSaved,TimeStart,TimeEnd,ServiceAlias,ServiceCategories,ServiceTitle,ServiceDescription,ServiceIcon,ServicePosition,ServicePeriod,ServicePriceRangeMin,ServicePriceRangeMax,ServicePrice,ServiceCommission,ServiceCurrency,ServiceComments';
	$databaseDefinition['k']['Service']='ServiceID';
	$databaseDefinition['langs']['Service']['ServiceTitle']='infield';	
	$databaseDefinition['langs']['Service']['ServiceDescription']='infield';
	$databaseDefinition['langs']['Service']['ServiceComments']='infield';

	$databaseDefinition['t']['ServiceCategory']='ServiceCategoryID,ServiceCategoryAlias,UserID,OwnerID,PermAll,ServiceCategoryParentID,ServiceCategoryStatus,ServiceCategoryTypes,ServiceCategoryPosition,ServiceCategoryTitle,ServiceCategoryDescription,ServiceCategoryKeywords,ServiceCategoryIcon,ServiceCategoryImage,ServiceCategoryImagePreview,ServiceCategoryImageTitle,ServiceCategoryImageButton,ServiceCategoryImageButtonHover,ServiceCategoryImageButtonCurrent,ServiceCategoryAccessType,ServiceCategoryComments,ServiceCategoryItems,ServiceCategoryChildren';
	$databaseDefinition['k']['ServiceCategory']='ServiceCategoryID';
	$databaseDefinition['langs']['ServiceCategory']['ServiceCategoryTitle']='infield';
	$databaseDefinition['langs']['ServiceCategory']['ServiceCategoryKeywords']='infield';
	$databaseDefinition['langs']['ServiceCategory']['ServiceCategoryDescription']='infield';
		
	
?>

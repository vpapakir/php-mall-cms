<?
	$databaseDefinition['t']['CashFlowCompany']='CashFlowCompanyID,UserID,OwnerID,PermAll,TimeCreated,CashFlowCompanyStatus,CashFlowCompanyName,CashFlowCompanyPref1,CashFlowCompanyPref2,CashFlowCompanyAccounts,CashFlowCompanyUsers,CashFlowCompanyComments';
	$databaseDefinition['k']['CashFlowCompany']='CashFlowCompanyID';	
	
	$databaseDefinition['t']['CashFlowBill']='CashFlowBillID,UserID,OwnerID,PermAll,TimeCreated,CashFlowCompanyID,CashFlowAccountID,CashFlowBillStatus,CashFlowBillDate,CashFlowBillAmount,CashFlowBillVAT,CashFlowBillPurpose,CashFlowBillComments';
	$databaseDefinition['k']['CashFlowBill']='CashFlowBillID';

	$databaseDefinition['t']['CashFlowAccount']='CashFlowAccountID,UserID,OwnerID,PermAll,TimeCreated,CashFlowAccountName,CashFlowAccountNumber,CashFlowAccountInitValue,CashFlowAccountCompany,CashFlowAccountComments';
	$databaseDefinition['k']['CashFlowAccount']='CashFlowAccountID';
	
?>

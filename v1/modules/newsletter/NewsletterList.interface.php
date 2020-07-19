<?php
//XCMSPro: Newsletter entity WebService public methods
function manageNewsletterLists()
{
	global $CORE;
	//get input
	$CORE->setDebug('newsletterList.manageNewsletterLists.Start','Start');	
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	$entityID = $input['NewsletterList'.DTR.'NewsletterListID'];
	if(empty($entityID)) {$entityID = $input['NewsletterListID'];}
	
	$actionMode = $input['actionMode'];
	$viewMode = $input['viewMode'];
	
	//creat objects	
	$NewsletterList = new NewsletterListClass();
	//set NewsletterList
	if($actionMode=='delete')
	{
		$NewsletterList->setNewsletterList($input);
	}
	elseif($actionMode=='save')
	{
		$NewsletterList->setNewsletterList($input);
	}
	
	//get Lists
	$result['DB']['NewsletterLists'] = $NewsletterList->getNewsletterLists($input);
		
	//get List
	if(!empty($entityID))
	{
		$result['DB']['NewsletterList'] = $NewsletterList->getNewsletterList($input);
	}
	
	//get result 
	$CORE->setDebug('newsletterList.manageNewsletterLists.End','End');
	return $result;
}


/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
/*
function manageCurrencies()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['CurrencyID'];
	$entityFieldID = $input['CurrencyRateID'];
	//creat objects			
	$Currency = new CurrencyClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$Currency->deleteCurrency($input);
		$Currency->deleteCurrencyRate($input);
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		$Currency->setCurrency($input);
		$Currency->setCurrencyRate($input);		
	}

	$CurrenciesRS = $Currency->getCurrencies($input);
	$result['DB']['Currencies'] = $CurrenciesRS;

	if(!empty($entityID))
	{
		$result['DB']['Currency'] = $Currency->getCurrency($input);
		$input['CurrencyCode'] = $result['DB']['Currency'][0]['CurrencyCode'];
		$result['DB']['CurrencyRates'] = $Currency->getCurrencyRates($input);
	}
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

*/
?>
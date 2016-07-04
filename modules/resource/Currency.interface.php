<?php
//XCMSPro: Currency entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
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

/**
* Gets Currencies. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getCurrencies($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('Currency.getCurrencies.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$Currency = new Currencieserver(&$SERVER,&$DS);
	//get content
	$CurrenciesRS = $Currency->getCurrencies($input);
	$SERVER->setOutput($CurrenciesRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('Currency.getCurrencies.End','End');
	return $returnValue;
}
/**
* Gets Currency. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getCurrency($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('Currency.getCurrency.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('core','server');
	$Currency = new Currencieserver(&$SERVER,&$DS);
	//get content
	$CurrencyRS = $Currency->getCurrency($input);
	$SERVER->setOutput($CurrencyRS['xml']);	
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('Currency.getCurrency.End','End');
	return $returnValue;
}

/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageCurrency($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('Currency.manageCurrency.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$Currency = new Currencieserver(&$SERVER,&$DS);
	$Box = new BoxServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$Currency->setCurrency($input);
		$Currency->setCurrencyBox($input);
	}
	if($input['actionMode']=='delete')
	{
		$Currency->deleteCurrency($input);
	}
	if($input['actionMode']=='deletebox')
	{
		$Currency->deleteCurrencyBox($input);
	}	
		
	if($input['actionMode']=='addBox')
	{	
		$input['actionMode']='save';
		$Currency->setCurrencyBox($input);
	}	

	if($input['actionMode']=='copyCurrency')
	{	
		$Currency->copyCurrency($input);
	}		
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$contentRS = $Currency->setCurrency($input);
	}
	else
	{
		$contentRS = $Currency->getCurrency($input);
	}
	$SERVER->setOutput($contentRS['xml']);

	$boxesRS = $Currency->getCurrencyBoxes($input);
	$SERVER->setOutput($boxesRS['xml']);
	//get refs
	$refsResult = $DS->query('YesNo',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	$refsResult = $DS->query('PermAll',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);		
	
	$refsResult = $DS->query('CurrencyType',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('BoxSide',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	
	$Currency->getCurrenciesRef($input);

	$Box->getBoxesRef($input);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('Currency.manageCurrency.End','End');
	return $returnValue;
}

/**
* Get the references used in Currency. This can be used for navigation in front end.
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getCurrencyRefs($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('datingProfile.getCurrencyRefs.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('core','server');
	$DatingProfile = new DatingProfileServer(&$SERVER,&$DS);
	$refName = $input['RefName'];
	//get refs
	$refsResult = $DS->query($refName,$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('datingProfile.getCurrencyRefs.End','End');
	return $returnValue;
}
?>
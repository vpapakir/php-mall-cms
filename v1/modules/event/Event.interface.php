<?
//XCMSPro: Event entity WebService public methods
//jb 19.11.05 need to refact all module!!!

//jb 21.11.05 refactored,updated
function runEvents($input='')
{
	global $CORE;
	$CORE->setDebug('event.runEvents.End','End');
	
	if(empty($input)) {
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects	
	$EVENT = new EventClass();
	
	$retval = $EVENT->runEvents($input);

	$CORE->setDebug('event.runEvents.End','End');
	return $retval;
}

//jb 21.11.05 refactored,updated
function getEvent($input='')
{
	global $CORE;
	$CORE->setDebug('event.getEvent.End','End');
	if(empty($input)) {
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects	
	$EVENT = new EventClass();

	$retval = $EVENT->getEvent($input);
	$CORE->setDebug('event.getEvent.End','End');
	return $retval;
}

function manageEvent()
{
	global $CORE;
	$CORE->setDebug('event.getEvent.End','End');
	
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects	
	$EVENT = new EventClass();
	
	$retval = $EVENT->getEvent($input);
	if($input['actionMode']=='save')
	{
		$retval = $EVENT->setEvent($input);
	}
	else
	{
		$retval = $EVENT->getEvent($input); 
	}	
	$CORE->setOutput($retval['xml']);
	$refsResult = $DS->query('EventType','','localRefs');
	$CORE->setRefs($refsResult['sql']);
		
	$retval = $CORE->getOutput();
	$CORE->setDebug('event.getEvent.End','End');
	return $retval;
}

function manageEvents()
{
	global $CORE;
	$CORE->setDebug('event.manageEvents.End','End');
	
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects	
	$EVENT = new EventClass();
	
	if($input['actionMode']=='delete')
	{
		$EVENT->setEvent($input);
	}	
	$retval = $EVENT->getEvents($input);
	$CORE->setOutput($retval['xml']);
	$retval = $CORE->getOutput();
	$CORE->setDebug('event.manageEvents.End','End');
	return $retval;
}

//jb 19.11.05 refactored,updated
function addEvent($input='')
{
	global $CORE;
	$CORE->setDebug('event.addEvent.End','End');
	
	//if empty input from callService(), get current input from post/get
	if(empty($input)) {
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects	
	$EVENT = new EventClass();
	
	$result['addEventResult'] = $EVENT->addEvent($input);

	$CORE->setDebug('event.addEvent.End','End');
	return $result;
}

?>
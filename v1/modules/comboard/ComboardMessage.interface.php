<?php
//XCMSPro: ComboardMessage entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
/*
ComboardMessages statuses
- new
- read
- deleted
- archived
*/
function manageComboardMessages(){
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$ComboardMessage = new ComboardMessageClass();


//echo "<hr>";
//print_r($input);
//echo "<hr>";
	
	if($input['actionMode']=='hide') $ComboardMessage->setComboardMessageAsRead($input);
	elseif($input['actionMode']=='delete'||$input['actionMode']=='complete')
		$ComboardMessage->deleteComboardMessage($input);
	elseif($input['actionMode']=='save'){

		if(!empty($input['ComboardMessage'.DTR.'ComboardMessageStartTime_calendar']))
			$input['ComboardMessage'.DTR.'ComboardMessageStartTime']=$input['ComboardMessage'.DTR.'ComboardMessageStartTime_calendar'];
		elseif(!empty($input['ComboardMessage'.DTR.'ComboardMessageStartTime_task']))
			$input['ComboardMessage'.DTR.'ComboardMessageStartTime']=$input['ComboardMessage'.DTR.'ComboardMessageStartTime_task'];
		elseif(!empty($input['ComboardMessage'.DTR.'ComboardMessageStartTime_event']))
			$input['ComboardMessage'.DTR.'ComboardMessageStartTime']=$input['ComboardMessage'.DTR.'ComboardMessageStartTime_event'];
		
		$ComboardMessage->setComboardMessage($input);
	}

	if(input('cal_day'))
		$dates = date("Y-m-d",mktime(0,0,0,input('cal_month'),input('cal_day'),input('cal_year')));

	$CORE->setInputVar('chosenDate',$dates);

	/*
	$input['filterMode']='memo';
	$result['DB']['MemoComboardMessages'] = $ComboardMessage->getComboardMessages($input);
	*/
	$input['filterMode']='message';
	$result['DB']['MessComboardMessages'] = $ComboardMessage->getComboardMessages($input);
	$input['filterMode']='answer';
	$result['DB']['AnswerComboardMessages'] = $ComboardMessage->getComboardMessages($input);

	$result['DB']['MessageComboardMessages'] = array();
	if (is_array($result['DB']['MessComboardMessages']))
	{
		foreach($result['DB']['MessComboardMessages'] as $m){
			$result['DB']['MessageComboardMessages'][] = $m;
			foreach($result['DB']['AnswerComboardMessages'] as $a){
				if($a['ComboardMessageParentID']==$m['ComboardMessageID'])
				$result['DB']['MessageComboardMessages'][] = $a;
			}
		}
 	}


	/*
	$input['filterMode']='read';
	$result['DB']['ComboardMessages'] = $ComboardMessage->getComboardMessages($input);

	$input['filterMode']='new';
	$result['DB']['NewComboardMessages'] = $ComboardMessage->getComboardMessages($input);

	if(input('MessageID')){
		$input['filterMode']='thread';
		$result['DB']['ThreadComboardMessages'] = $ComboardMessage->getComboardMessages($input);
	}
	*/

	/*
	$CORE->setInputVar('Groups','root,admin,content');
	$resultRS = $CORE->callService('getUsersByGroup','sessionServer');
	$result['DB']['Users'] = $resultRS['DB']['Users'];
	*/
	if(!$input['ComboardMessageStartTime'])
		$CORE->setInputVar('ComboardMessageStartTime',getFormated(input('chosenDate'),'dateTime'));

	$secondDate=getdate(strtotime(input('chosenDate')));
	if(input('viewMode')=='week')
		$secondDate['mday']+=7;
	elseif(input('viewMode')=='month')
		$secondDate['mon']++;

	$secondDate=date("Y-m-d",mktime(0,0,0,$secondDate['mon'],$secondDate['mday'],$secondDate['year']));

	if(!$input['ComboardMessageEndTime'])
		$CORE->setInputVar('ComboardMessageEndTime',getFormated($secondDate,'dateTime'));

	/*
	if(!empty($input['ComboardMessageID']) || !empty($input['MessageID']))
		$result['DB']['ComboardMessage'] = $ComboardMessage->getComboardMessage($input);
	*/
	$input['filterMode']='';
	$result['DB']['FullComboardMessages'] = $ComboardMessage->getComboardMessages($input);
	//print_r($result['DB']['FullComboardMessages']);
	$result['DB']['ComboardMessageType'] = $ComboardMessage->getComboardMessageType($input);
	/*
	if(!empty($input['MessageID'])){
		$input['ComboardMessageID'] = $input['MessageID'];
		$result['DB']['ParentComboardMessage'] = $ComboardMessage->getComboardMessage($input);
		
	}
	*/
	$DS = new DataSource('main');
	$result['DB']['Administrators'] = $DS->query("SELECT UserID, UserName FROM User WHERE PermAll=1 AND (GroupID='root' OR GroupID='admin' OR GroupID='content') ");
	
	return $result;
}


function manageComboardMessage(){
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$ComboardMessage = new ComboardMessageClass();

	if($input['actionMode']=='delete'||$input['actionMode']=='complete')
		$ComboardMessage->deleteComboardMessage($input);
	elseif($input['actionMode']=='save'){

		if(!empty($input['ComboardMessage'.DTR.'ComboardMessageStartTime_calendar']))
			$input['ComboardMessage'.DTR.'ComboardMessageStartTime']=$input['ComboardMessage'.DTR.'ComboardMessageStartTime_calendar'];
		elseif(!empty($input['ComboardMessage'.DTR.'ComboardMessageStartTime_task']))
			$input['ComboardMessage'.DTR.'ComboardMessageStartTime']=$input['ComboardMessage'.DTR.'ComboardMessageStartTime_task'];
		elseif(!empty($input['ComboardMessage'.DTR.'ComboardMessageStartTime_event']))
			$input['ComboardMessage'.DTR.'ComboardMessageStartTime']=$input['ComboardMessage'.DTR.'ComboardMessageStartTime_event'];
		
		$ComboardMessage->setComboardMessage($input);
	}

	$CORE->setInputVar('Groups','root,admin,content');
	$resultRS = $CORE->callService('getUsersByGroup','sessionServer');
	$result['DB']['Users'] = $resultRS['DB']['Users'];

	if(!$input['ComboardMessageStartTime'])
		$CORE->setInputVar('ComboardMessageStartTime',getFormated(input('chosenDate'),'dateTime'));

	$secondDate=getdate(strtotime(input('chosenDate')));
	if(input('viewMode')=='week')
		$secondDate['mday']+=7;
	elseif(input('viewMode')=='month')
		$secondDate['mon']++;

	$secondDate=date("Y-m-d",mktime(0,0,0,$secondDate['mon'],$secondDate['mday'],$secondDate['year']));

	if(!$input['ComboardMessageEndTime'])
		$CORE->setInputVar('ComboardMessageEndTime',getFormated($secondDate,'dateTime'));

	if($input['actionMode']=='edit')
	{
		if(!empty($input['ComboardMessageID']) || !empty($input['MessageID']))
		$result['DB']['ComboardMessage'] = $ComboardMessage->getComboardMessage($input);
	}
	
	$result['DB']['ComboardMessageType'] = $ComboardMessage->getComboardMessageType($input);
	
	
	if(!empty($input['MessageID'])){
		$input['ComboardMessageID'] = $input['MessageID'];
		$result['DB']['ParentComboardMessage'] = $ComboardMessage->getComboardMessage($input);

		$input['filterMode']='thread';
		$result['DB']['ThreadComboardMessages'] = $ComboardMessage->getComboardMessages($input);
	
	}


		$DS = new DataSource('main');
		$result['DB']['Administrators'] = $DS->query("SELECT UserID, UserName FROM User WHERE PermAll=1 AND (GroupID='root' OR GroupID='admin' OR GroupID='content') ORDER BY UserName ");

	return $result;
}

function remindComboardMessage(){
	global $CORE;

	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$ComboardMessage = new ComboardMessageClass();
		
	$DS = new CoreDataSource('comboardMessage','server');

	$comboardMessageRS = $ComboardMessage->getComboardMessage($input);

	$refsResult = $DS->query('ComboardMessageStatus',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	

	$returnValue = $SERVER->getOutput();

	return $returnValue;
}




/**
* Gets comboardMessages. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/

function getComboardMessages($input='')
{
	global $CORE;
	//get input

	$CORE->setDebug('comboardMessage.getComboardMessages.Start','Start');	
	if(empty($input)) $input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$ComboardMessage = new ComboardMessageClass();
	//print_r($input);
	//get result
	if($input['actionMode']=='hide') $ComboardMessage->setComboardMessageAsRead($input);
	
	if(input('cal_day'))
		$dates = date("Y-m-d",mktime(0,0,0,input('cal_month'),input('cal_day'),input('cal_year')));

	$CORE->setInputVar('chosenDate',$dates);
	$input['chosenDate'] = $dates;
	
	if(!$input['ComboardMessageStartTime']){
		$input['ComboardMessageStartTime'] = getFormated($input['chosenDate'],'dateTime');
		$CORE->setInputVar('ComboardMessageStartTime',getFormated(input('chosenDate'),'dateTime'));
	}

	$secondDate=getdate(strtotime(input('chosenDate')));
	if(input('viewMode')=='week')
		$secondDate['mday']+=7;
	elseif(input('viewMode')=='month')
		$secondDate['mon']++;

	$secondDate=date("Y-m-d",mktime(0,0,0,$secondDate['mon'],$secondDate['mday'],$secondDate['year']));

	if(!$input['ComboardMessageEndTime']){
		$input['ComboardMessageEndTime'] = getFormated($secondDate,'dateTime');
		$CORE->setInputVar('ComboardMessageEndTime',getFormated($secondDate,'dateTime'));
	}
//======================		
	
	$result['DB']['ComboardMessageType'] = $ComboardMessage->getComboardMessageType($input);
	
	foreach($result['DB']['ComboardMessageType'] as $row){
		$input['ComboardMessageType'] = $row['Name'];
		$result['DB']['ComboardMessagesByType'][$row['Name']] = $ComboardMessage->getComboardMessages($input);
	}
	
	/*$input['filterMode']='';
	$result['DB']['FullComboardMessages'] = $ComboardMessage->getComboardMessages($input);
	*/	
		
	$DS = new DataSource('main');
	$result['DB']['Administrators'] = $DS->query("SELECT UserID, UserName FROM User WHERE PermAll=1 AND (GroupID='root' OR GroupID='admin' OR GroupID='content') ORDER BY UserName ");
	
	$CORE->setDebug('comboardMessage.getComboardMessages.End','End');
	return $result;
}
/**
* Gets comboardMessage. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getComboardMessage($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('comboardMessage.getComboardMessage.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('comboardMessage','server');
	$ComboardMessage = new ComboardMessageServer(&$SERVER,&$DS);
	//get content
	$comboardMessageRS = $ComboardMessage->getComboardMessage($input);
	$SERVER->setOutput($comboardMessageRS['xml']);	
	//get refs
	$refsResult = $DS->query('ComboardMessageStatus',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	
	//get result
	$returnValue = $SERVER->getOutput();

	$SERVER->setDebug('comboardMessage.getComboardMessage.End','End');
	return $returnValue;
}

?>

<?php
//XCMSPro: Message entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
/*
Messages statuses
- new
- read
- replied
- draft - prepared text and attachements
- archived - archived
*/
function manageMessages($input='')
{
	global $CORE;
	$DS = new DataSource('main');
	//get input
	if(empty($input))
	{
		$input = $CORE->getInput();
	}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$Message = new MessageClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$Message->deleteMessage($input);
	}
	elseif($input['actionMode']=='send')
	{
		//print_r($input);
		$Message->setMessage($input);
	}
	elseif($input['actionMode']=='sendclients')
	{
		$Message->setMessages($input);
	}
	elseif($input['actionMode']=='replayed')
	{
		//print_r($input);
		if(!empty($input['MessageID']))
			$DS->query("UPDATE Message SET MessageStatus='replied' WHERE MessageID='".$input['MessageID']."'");
	}
	elseif($input['actionMode']=='updateNew')
	{
		$input['Message'.DTR.'MessageID']= $input['MessageAddedID'];
		$Message->setMessage($input);
	}
	elseif($input['actionMode']=='attach' || $input['actionMode']=='attach2')
	{
				
		$CORE->setConfigVar('UseImageResize', 'N');
		$CORE->setConfigVar('UseImagePreview', 'N');
		$CORE->setConfigVar('UseImageIcon', 'N');
		$config = $CORE->getConfig();
		
		//print_r($input);
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		//print_r($uploadRS);

		if(!empty($uploadRS['MessageAttachment']['file']))
		{
			$input['MessageAttachment'.DTR.'MessageFile']= $uploadRS['MessageAttachment']['file'];
			//print_r($input['MessageAttachment'.DTR.'MessageAttachment']);
			$input['MessageAttachment'.DTR.'MessageID']= $input['MessageAddedID'];
		}
		//print_r($input);
		$result['att']=$Message->setMessage($input);
		//print_r($result['att']);
		$result['attachments']=$Message->getMessageAttachment($result['att']);
	}
	
//echo "AMode(func): ".$input['actionMode']."<br>";

	$input['filterMode']='new';
	$result['DB']['NewMessages'] = $Message->getMessages($input);
	$result['DB']['NewMessagesAtt'] = $Message->getMessagesAttachments($input);
	$input['filterMode']='history';
	$result['DB']['Messages'] = $Message->getMessages($input);
	$result['DB']['MessagesAtt'] = $Message->getMessagesAttachments($input);
	if(!empty($input['MessageID']))
	{
		$result['DB']['Message'] = $Message->getMessage($input);
//		print_r($result['DB']['Message']);
		$result['attachments']=$Message->getMessageAttachment($input);
	}
	else
	{
		if($config['ClientType']=='admin' && !empty($input['ReceiverID']))
		{
			$DS = new DataSource('main');
			$userInfoRS = $DS->query("SELECT * FROM User WHERE UserID='".$input['ReceiverID']."'");
			$result['DB']['User'] = $userInfoRS;
			//print_r($userInfoRS);
		}
	}
	
	if(is_array($input['SendMessageUserID'])){
		$DS = new DataSource('main');
		$filter = '';
		$i = 0;
		foreach($input['SendMessageUserID'] as $value){
			if($i==0)
				$filter .= " UserID='".$value."'";
			else
				$filter .= " OR UserID='".$value."'";
			$i++;
		}
		$usersInfoRS = $DS->query("SELECT * FROM User WHERE 1 AND ($filter)");
		$result['DB']['Users'] = $usersInfoRS;
	}
	
	//print_r($result);
	//get refs
	//get result
	return $result;
}


/**
* Gets messages. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/

function getMessages($in='')
{


	global $SERVER,$CORE;
	//get input
	$SERVER->setDebug('message.getMessages.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
//	$input = $CORE->getInput($in);
//	$user = $CORE->getUser();
//	$config = $CORE->getConfig();
	//creat objects			
	$DS = new CoreDataSource('message','server');
	$Message = new MessageServer(&$SERVER,&$DS);
	//get content
	$messagesRS = $Message->getMessages($input);
	$SERVER->setOutput($messagesRS['xml']);	
	//get refs
	$refsResult = $DS->query('MessageFolderAlias',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('MessageStatus',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
		
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('message.getMessages.End','End');
	return $returnValue;
}

function getClientMessages($in='')
{


	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$Message = new MessageClass();

	$result['DB']['ClientMessages'] = $Message->getClientMessages($input);
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	return $result;
}

/**
* Gets message. For front-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function getMessage($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('message.getMessage.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();
	//creat objects			
	$DS = new CoreDataSource('message','server');
	$Message = new MessageServer(&$SERVER,&$DS);
	//get content
	$messageRS = $Message->getMessage($input);
	$SERVER->setOutput($messageRS['xml']);	
	//get refs
	$refsResult = $DS->query('MessageStatus',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);	
	
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('message.getMessage.End','End');
	return $returnValue;
}

/**
* Add, Edit and delete entity. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
/*function manageMessage($in)
{
	global $SERVER;
	//get input
	$SERVER->setDebug('message.manageMessage.Start','Start');	
	$input = $SERVER->setInput($in);
	$user = $SERVER->getUser();
	$config = $SERVER->getConfig();			
	$DS = new CoreDataSource('message','server');
	$Message = new MessageServer(&$SERVER,&$DS);
	if($input['actionMode']=='save')
	{
		$Message->setMessage($input);
	}
	if($input['actionMode']=='delete')
	{
		$Message->deleteMessage($input);
	}
	if($input['actionMode']=='read')
	{
		$Message->messageIsRead($input['MessageID']);
	}
	
	//get content
	if($input['actionMode']=='add')
	{	
		$input['actionMode']='save';
		$input['Message'.DTR.'MessageStatus']='new';
		$contentRS = $Message->setMessage($input);
	}
	else
	{
		$contentRS = $Message->getMessage($input);
	}
	$SERVER->setOutput($contentRS['xml']);
	//get refs
	$refsResult = $DS->query('MessageFolderAlias',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);
	$refsResult = $DS->query('MessageStatus',$in,'localRefs');
	$SERVER->setRefs($refsResult['sql']);			
	//get result
	$returnValue = $SERVER->getOutput();
	$SERVER->setDebug('message.manageMessage.End','End');
	return $returnValue;
}*/



function getClients()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$Message = new MessageClass();
	$DS = new DataSource('main');
	//get content

	$RS = $Message->getClients($input);
	
	$result['DB']['Clients'] = $RS['result'];
	$result['pages']['Clients']=$RS['pages'];
	
	
	$filter .= " AND (GroupID='root' OR GroupID='admin' OR GroupID='content') ";
	$query = "SELECT * FROM User, UserFields WHERE User.UserID = UserFields.UserID $filter ORDER BY UserFields.LastName";
	$result['DB']['Managers'] = $DS->query($query);

	//get refs
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	//get result
	return $result;
}

function getLastAdminMessages()
{
	global $CORE;
	//get input
	//$CORE->setDebug('message.getLastAdminMessages.Start','Start');	
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$Message = new MessageClass();

	$result['DB']['LastMessages'] = $Message->getLastAdminMessages($input);

	//creat objects			
	//$DS = new CoreDataSource('message','server');
	//$Message = new MessageServer(&$SERVER,&$DS);
	//get content
	//$messagesRS = $Message->getLastAdminMessages($input);
	//$CORE->setOutput($messagesRS['xml']);	
	//get refs
	//$refsResult = $DS->query('MessageFolderAlias',$in,'localRefs');
	//$CORE->setRefs($refsResult['sql']);
	//$refsResult = $DS->query('MessageStatus',$in,'localRefs');
	//$CORE->setRefs($refsResult['sql']);	
		
	//get result
	//$returnValue = $SERVER->getOutput();
	//$CORE->setDebug('message.getLastAdminMessages.End','End');
	return $result;
}

function manageMessage($input='')
{
	
	
	global $CORE;
	$DS = new DataSource('main');
	//get input
	if(empty($input))	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$userID = $user['UserID'];
	
	//die('ddddddfff');
	//echo "1";
			if($input['actionMode']=='send'){
				$CAPTCHA = $CORE->callService("validateCaptchaCode", "antispamServer", $input);
				if(!$CAPTCHA) 
				{
					$parentID=$input['ParentSID'];
					$input='';
					$CORE->setInputVar('actionMode','');
					$CORE->setInputVar('SID',$parentID);
					$input['SID']=$parentID;
					$CORE->setInputVar('CAPTCHA','-CAPTCHA_wrong_Code');
					$input['CAPTCHA']='-CAPTCHA_wrong_Code';
				}
			}


	if(eregi("http",$input['MessageTextEmail'])) return false;
	if(eregi("http",$input['MessageTextFirstName'])) return false;
	if(eregi("http",$input['MessageTextTitle'])) return false;
	if(eregi("http",$input['MessageTextFirstName'])) return false;
	if(eregi("http",$input['MessageTextLastName'])) return false;
	if(eregi("http",$input['MessageTextAddress'])) return false;
	if(eregi("http",$input['MessageTextCompany'])) return false;
	if(eregi("http",$input['MessageTextZip'])) return false;
	if(eregi("http",$input['MessageTextCountry'])) return false;
	if(eregi("http",$input['MessageTextPhone'])) return false;
	if(eregi("http",$input['MessageTextFax'])) return false;
	if(eregi("http",$input['MessageTextMobile'])) return false;
	if(eregi("http",$input['MessageTextTown'])) return false;
	if(eregi("http",$input['MessageTextNumberPersons'])) return false;
	if(eregi("http",$input['MessageTextNumberChildren'])) return false;
	if(eregi("http",$input['MessageTextObservations'])) return false;
	if(eregi("http",$input['MessageTextYourComments'])) return false;
	if(eregi("http",$input['MessageTextFidelityCardNumber'])) return false;
	if(eregi("http",$input['MessageTextSesameCardNumber'])) return false;
	if(eregi("http",$input['MessageTextWhoProposed'])) return false;
	//creat objects			
	$Message = new MessageClass();
	//get content
//echo 'ddddddddd';
	if($input['actionMode']=='send'){
		//$input['Message'.DTR.'MessageText'] = ;
		//echo $userID;
		if(empty($userID))
		{
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->setInputVar('User'.DTR.'Email',$input['MessageTextEmail']);
			$CORE->setInputVar('User'.DTR.'UserName',$input['MessageTextFirstName']);
			$CORE->setInputVar('UserField'.DTR.'Title',$input['MessageTextTitle']);
			$CORE->setInputVar('UserField'.DTR.'FirstName',$input['MessageTextFirstName']);
			$CORE->setInputVar('UserField'.DTR.'LastName',$input['MessageTextLastName']);
			$CORE->setInputVar('UserField'.DTR.'Address',$input['MessageTextAddress']);
			$CORE->setInputVar('UserField'.DTR.'CompanyName',$input['MessageTextCompany']);
			$CORE->setInputVar('UserField'.DTR.'PostalCode',$input['MessageTextZip']);
			$CORE->setInputVar('UserField'.DTR.'Country',$input['MessageTextCountry']);
			$CORE->setInputVar('UserField'.DTR.'Phone',$input['MessageTextPhone']);
			$CORE->setInputVar('UserField'.DTR.'Fax',$input['MessageTextFax']);
			$CORE->setInputVar('UserField'.DTR.'Mobile',$input['MessageTextMobile']);
			$CORE->setInputVar('UserField'.DTR.'City',$input['MessageTextTown']);
			$CORE->callService('doLogin','sessionServer');	

			$user = $CORE->getUser();
			$userID = $user['UserID'];
			$input['Message'.DTR.'UserID'] = $userID;
			//echo "#".$userID."#";
		}
		
		//print_r($input);
		//echo '<hr>';
		if(empty($userID) || $userID==1)
		{
			$userRS = $DS->query("SELECT UserID FROM User WHERE Email ='".$input['MessageTextEmail']."'");
			$userID = $userRS[0]['UserID'];
			$input['Message'.DTR.'UserID'] = $userID;
			$CORE->setInputVar('Message'.DTR.'UserID',$userID);
		}		
		
		$input['DateArrival'] = date('d-m-Y',mktime(0, 0, 0, $input['DateArrivalMonth'], $input['DateArrivalDay'], $input['DateArrivalYear']));
		$input['DateDeparture'] = date('d-m-Y',mktime(0, 0, 0, $input['DateDepartureMonth'], $input['DateDepartureDay'], $input['DateDepartureYear']));

		foreach($input as $key=>$value){
			if(eregi('MessageText',$key)){
				$key = str_replace("MessageText","",$key);
				if(is_array($value)){
					foreach($value as $row){
						$varray .= $row."\n";
					}
					$value = $varray;
				}
					
				//$input['Message'.DTR.'MessageText'] .= $key.": ".$value."\n";
				if(trim($value) && $key!='Message'.DTR)
				{
					$input['Message'.DTR.'MessageText'] .= lang('Requested'.$key.'.reservation.tip').": ".$value."\n";
				}
								
				if($key=='Appartement'){
					$input['Message'.DTR.'MessageText'] .= lang('RequestedDateArrival.reservation.tip').": ".$input['DateArrival']."\n";
					$input['Message'.DTR.'MessageText'] .= lang('RequestedDateDeparture.reservation.tip').": ".$input['DateDeparture']."\n";
				}
			}
		}
		//print_r($input);
		//die('ddd');
		
		//send email to admin
		$emailIN['MailTo'] = $config['SiteMail'];
		$emailIN['MailToName'] = $config['SiteName'];
		$emailIN['MailFrom'] =$input['MessageTextEmail'];
		$emailIN['MailFromName'] =$input['MessageTextFirstName'].' '.$input['MessageTextLastName'];
		$emailIN['MailData']['SenderName'] = $emailIN['MailFrom'];
		$emailIN['MailData']['UserID'] = $input['Message'.DTR.'UserID'];
		$emailIN['MailData']['Message'] = nl2br($input['Message'.DTR.'MessageText']);
		$emailIN['MailTemplate'] = 'reservationNewRequest.admin';
		$CORE->callService('sendMail','mailServer',$emailIN);					

		
		$Message->setMessage($input);
		
		
		
	}
	
	//$ReservationOrder = new ReservationOrderClass();
	//$result['DB']['ReservationRooms'] = $ReservationOrder->getReservationRooms($input);
	
	
	return $result;
}


?>
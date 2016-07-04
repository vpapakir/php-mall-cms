<?
//XCMSPro: Web Service Server
/*
Mail input data:

$input['MailTo'] - required (if it is not dfined the e-mail will be sent to administrator)
$input['MailToName'] - optional 
$input['MailFrom'] - optional - default is site configuration
$input['MailFromName'] - optional
$input['MailSubject'] - optional - if it is not defined TemplateName.txt is used
$input['MailContent'] - optional - the string of the content to be sent .. will apeare in <Body><Content>....</Content></Body> in XML
$input['MailData'] - optional - the XML data to be sent .. will apeare in <Body>...</Body>
$input['MailTemplate'] - required - the e-mail is not sent without definition of this field
$input['MailLanguage'] - optional - current sender language is used by default
$input['MailLog'] - optional - values 'yes' - log is added , empty - no log added
$input['MailFormat'] - optional - the format of e-mail. Values: mime, html, text . Default is html
$input['MailAttachment'] - optional - the atacchement file or files. Can be a string or an array

those fields can be placed in an array
like this:
$emailIN[$i]['MailTo']

*/
//sends 1 email at once
//$SERVER_SOAP->register('sendMail');
function sendMail($input)
{
	/*
		The format of input XML
		<Mails>
			<Mail>
				<MailTo></MailTo>
				<MailToName></MailToName>
			</Mail>
		</Mails>
		$in[0]['MailTo'] =
		$in[0]['MailToName'] =		
	*/
	global $CORE;
	//$input = $CORE->getInput($in);	
	//$DS = new DataSource('main');	
	$MAIL_SERVER = new MailServer();		
	$CORE->setDebug('mail.sendMail.Start','Start');
	$MAIL_SERVER->sendMail($input,'log');
	return $retval;
}

//$SERVER_SOAP->register('queueMail');
function queueMail($input)
{
	global $SERVER;
	//$input = $SERVER->setInput($in);	
	//$DS = new CoreDataSource('mail','server');
	//print_r($input);	
	$MAIL_SERVER = new MailServer();
	$MAIL_SERVER->queueMail($input);
	return $retval;		
}
//sends all queued e-mails
//$SERVER_SOAP->register('sendMailQueue');
function sendMailQueue()
{
	global $SERVER;
	//$input = $SERVER->setInput($in);	
	//$DS = new CoreDataSource('mail','server');	
	$MAIL_SERVER = new MailServer();

	$MAIL_SERVER->sendMailQueue();

	return $retval;		
}//$SERVER_SOAP->register('sendToFriend');
function sendToFriend($input)
{
	global $SERVER;
	//$input = $SERVER->setInput($in);	
	$MAIL_SERVER = new MailServer();		
	//$SERVER->setDebug('mail.sendMail.Start','Start');
	$input['MailTemplate'] ='SendToFriend';
	$input['MailLog']='yes';
	if($MAIL_SERVER->sendMail($input))
	{
		$SERVER->setMessage('mail.sendMail.msg.MailIsSent');
	}
	return $retval;
}

//$SERVER_SOAP->register('testEmailTemplate');
function testEmailTemplate($in)
{
	global $SERVER;
	$input = $SERVER->setInput($in);
	$DS = new CoreDataSource('mail','server');	
	$MAIL_SERVER = new MailServer(&$SERVER,&$DS);		
	$SERVER->setDebug('mail.sendMail.Start','Start');
	
	$retval = $MAIL_SERVER->testEmailTemplate($input);

	$SERVER->setOutput($retval);
	$retval = $SERVER->getOutput();
	$SERVER->setDebug('mail.sendMail.End','End');
	return $retval;
}

//$SERVER_SOAP->register('manageCompanies');
function getMailQueue($in)
{
	global $CORE;
	//$input = $CORE->setInput($in);
	//$DS = new CoreDataSource('mail','server');
	$SERVER->setDebug('mail.getMailQueue.Start','Start');
	$COMPANY = new MailServer();	
	
	if($input['actionMode']=='delete')
	{
		$COMPANY->deleteMail($input['MailID']);
	}
	$result = $COMPANY->getMailQueue($input);	
	return $retval;
}

//$SERVER_SOAP->register('getBounceAddresses');
function getBounceAddresses($in)
{
	global $CORE;
	$input = $CORE->setInput($in);	
	$DS = new DataSource('main');	
	$MAIL_SERVER = new MailServer(&$SERVER,&$DS);

	$MAIL_SERVER->getBounceAddresses($input);

	$retval = $SERVER->getOutput();
	$SERVER->setDebug('mail.sendMail.End','End');
	return $retval;
}


//Mail interface functions
function contactF()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$userID = $user['UserID'];
	$DS = new DataSource('main');


	if($input['contact_email']!="") 
	{
	
	//if($input['UseCAPTCHA']==1)
	//{
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
		else
		{
	//}
	

	
		//@mail($config[SiteMail],"from site",$input['ihre'],"");
		//echo $userID;
		if(empty($userID))
		{
			$CORE->setInputVar('User'.DTR.'Email',$input['contact_email']);
			$CORE->setInputVar('UserField'.DTR.'FirstName',$input['FirstName']);
			$CORE->setInputVar('UserField'.DTR.'LastName',$input['LastName']);
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');	
			$user = $CORE->getUser();
			$userID = $user['UserID'];
			
		}
		
		if(empty($userID))
		{
			$userRS = $DS->query("SELECT UserID FROM User WHERE Email ='".$input['contact_email']."'");
			$userID = $userRS[0]['UserID'];
			$CORE->setInputVar('Message'.DTR.'UserID',$userID);
		}		
		
		if($userID!='root')
		{ 
			$CORE->setInputVar('actionMode','send');
			$CORE->setInputVar('Message'.DTR.'MessageSenderNickName',$input['FirstName']." ".$input['LastName']);
			$CORE->setInputVar('Message'.DTR.'MessageSenderGroup','user');
			$CORE->setInputVar('Message'.DTR.'MessageReceiverGroup','admin');
			$CORE->setInputVar('Message'.DTR.'MessageStatus','new');
//			$CORE->setInputVar('Message'.DTR.'MessageReceiverID',$userID);
//			$CORE->setInputVar('Message'.DTR.'MessageSubject','contact us');
			$CORE->setInputVar('Message'.DTR.'MessageSubject','Message from contact form');
			
			$messageContent = $input['FirstName']." ".$input['LastName']." - ".$input['contact_email'];
			$messageContent .='<hr size="1">'.$input['contact_content'];
			$CORE->setInputVar('Message'.DTR.'MessageText',$messageContent);
			$CORE->callService('manageMessages','mailServer');	
		}
		
		$EMAIL=array();
		$EMAIL['MailTemplate']	= 'contactFormAdmin';
		$EMAIL['MailTo'] 		= $config['SiteMail'];
		$EMAIL['MailFrom']		= $input['contact_email'];
		//$EMAIL['MailSubject']	= 'amil subject';
		$EMAIL['MailContent']	= $input['contact_content'];

		foreach($config as $confVarName=>$confVarValue)
		{
			$EMAIL['MailData'][$confVarName] = $confVarValue;
		}
		$EMAIL['MailData']['SenderEmail']  	= $input['contact_email'];
		$EMAIL['MailData']['SenderName']  	= $input['contact_name'];
		$EMAIL['MailData']['SenderMessage']	= nl2br($input['contact_content']);
		$EMAIL['MailData']['send_copy']	= $input['send_copy'];
		/*$EMAIL['MailData']['plz']  		= $input['plz'];
		$EMAIL['MailData']['land']  	= $input['land'];
		$EMAIL['MailData']['email']  	= $input['email'];
		$EMAIL['MailData']['telefon']  	= $input['telefon'];
		$EMAIL['MailData']['ihre']  	= $input['ihre'];
		*/

		$MAIL_SERVER = new MailServer();
		$MAIL_SERVER->sendMail($EMAIL);
		
		if($EMAIL['MailData']['send_copy']=="on")
		{
			$EMAIL2=$EMAIL;
			$EMAIL2['MailTemplate']	= 'contactForm';
			$EMAIL2['MailTo'] 		= $input['contact_email'];
			$EMAIL2['MailFrom']		= $config['SiteMail'];
			$MAIL_SERVER->sendMail($EMAIL2);
		}
		}
		
		return $EMAIL;
	}
	return false;
}


function sendContactForm()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	if(!empty($input['ContactEmail'])) 
	{
		//print_r($config);
		//@mail($config[SiteMail],"from site",$input['ihre'],"");
		$EMAIL=array();
		if(!empty($input['MailTemplate']))
		{
			$EMAIL['MailTemplate']	= $input['MailTemplate'];
		}
		else
		{
			$EMAIL['MailTemplate']	= 'contactForm';
		}
		$EMAIL['MailTo'] 		= $config['SiteMail'];
		$EMAIL['MailFrom']		= $input['ContactEmail'];
		//$EMAIL['MailSubject']	= 'amil subject';
		//$EMAIL['MailContent']	= $input['contact_content'];
		foreach($config as $confVarName=>$confVarValue)
		{
			$EMAIL['MailData'][$confVarName] = $confVarValue;
		}
		foreach($input as $variableName=>$variableValue)
		{
			if(is_array($variableValue))
			{
				$valueStr='';
				foreach($variableValue as $variableName2=>$variableValue2)
				{
					$valueStr .= $variableValue2.', ';
				}
				if(!empty($valueStr))
				{
					$variableValue = $valueStr;
				}
			}
			$EMAIL['MailData'][$variableName] = $variableValue;
		}
		$MAIL_SERVER = new MailServer();
		$MAIL_SERVER->sendMail($EMAIL);
		
		$EMAIL['MailTemplate'] = $EMAIL['MailTemplate'].'.user';
		$EMAIL['MailTo'] 		= $input['ContactEmail'];
		$EMAIL['MailFrom']		= $config['SiteMail'];

		$MAIL_SERVER->sendMail($EMAIL);
		
		//if($EMAIL['MailData']['send_copy']=="on")
		//{
			//$EMAIL2=$EMAIL;
			//$EMAIL2['MailTo'] 		= $input['contact_email'];
			//$EMAIL2['MailFrom']		= $config['SiteMail'];
			//$MAIL_SERVER->sendMail($EMAIL2);
		//}

		return $EMAIL;
	}
	return false;
}
?>

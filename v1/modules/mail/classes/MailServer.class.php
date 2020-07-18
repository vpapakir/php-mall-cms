<?
class MailServer
{
    // PRIVATE PROPERTIES
	var $_DS;
	var $_user = array();
	var $_session = array();
	var $_controller;
	var $_config;
	var $_DBX;
	var $_sessionID;
	var $_currentTime;
	var $_testMode;
	var $_templates = array();//the array of current templates .. this is used for optimization
	// PRIVATE METHODS
	function _mailLog($str)
	{
		$config = $this->_config;
		$logPath = $config['LogPath'];
		if(!is_dir($logPath)){mkdir($logPath, 0755);}
		$logFilePath = $logPath.'maillog.txt';
		$fp = fopen($logFilePath,'a');
		$logResult = '['.date('Y-m-d h:i:s').'] '.$str . LB;
		fwrite($fp,$logResult);
		fclose($fp);		
	}
	
	function _getTemplate ($in,$type='')
	{
		global $showmode;
		$config = $this->_config;
		//$input = $this->_controller->getInput();
		$templates = $this->_templates;
		$lang = $in['MailLanguage'];
		if(empty($lang)) {$lang = $config['SiteLang'];}
		$mailFormat = $in['MailFormat'];
		
		$templateID = $in['MailTemplate'];
		$templateRS = $this->_DS->query("SELECT MailTemplateBody, MailTemplateBodyText, MailTemplateSubject, MailTemplateNoHeader FROM MailTemplate WHERE MailTemplateCode='$templateID' AND PermAll!='4'");
		if(count($templateRS)>0)
		{
			if($templateRS[0]['MailTemplateNoHeader']!='Y')
			{
				//echo "1111111111111111111111111111111111111111111111111111111";
				
				$templateHeaderRS = $this->_DS->query("SELECT MailTemplateBody, MailTemplateBodyText FROM MailTemplate WHERE MailTemplateCode='header'");
				$templateHeaderContentHTML = $this->_controller->getValue($templateHeaderRS[0]['MailTemplateBody'],$lang);
				$templateHeaderContentTEXT = $this->_controller->getValue($templateHeaderRS[0]['MailTemplateBodyText'],$lang);
				//print_r($templateHeaderRS);
				$templateHeaderContentHTML = str_replace("{MailEncoding}",$config['MailEncoding'],$templateHeaderContentHTML);
				$templateHeaderContentHTML = str_replace("{url}",$config['url'],$templateHeaderContentHTML);
				$templateHeaderContentHTML = str_replace("{SiteName}",$config['SiteName'],$templateHeaderContentHTML);
				
				$templateHeaderContentTEXT = str_replace("{MailEncoding}",$config['MailEncoding'],$templateHeaderContentTEXT);
				$templateHeaderContentTEXT = str_replace("{url}",$config['url'],$templateHeaderContentTEXT);
				$templateHeaderContentTEXT = str_replace("{SiteName}",$config['SiteName'],$templateHeaderContentTEXT);
				
			}	
			
			$templateContent = $this->_controller->getValue($templateRS[0]['MailTemplateBody'],$lang);
			$templateContent = str_replace("{SiteName}",$config['SiteName'],$templateContent);
			$templateContent = str_replace("{ContactEmail}",$in['MailTo'],$templateContent);
			$templateContent = str_replace("{ContactName}",$in['MailData']['senderName'],$templateContent);
			$templateContent = str_replace("{url}",$config['rooturl']."go/".$config['lang']."/",$templateContent);
			$templateContent = str_replace("{adminurl}",$config['adminurl'],$templateContent);
			if(!empty($templateContent))
			{
				//print_r($in['MailData']);
				if(is_array($in['MailData']))
				{
					$templateContent = $this->_parseMailData($in['MailData'],$templateContent);
				}
				else
				{
					$templateContent = str_replace("{MailContent}",$in['MailContent'],$templateContent);
				}
				
				if(!empty($templateHeaderContentHTML)) {$retval['html'] =  str_replace("{body}",$templateContent,$templateHeaderContentHTML);} else { $retval['html'] = $templateContent; }
				$retval['html'] = stripslashes($retval['html']);
				$retval['html'] =  str_replace("&quot;","\"",$retval['html']);
			}
			
			$templateContent = $this->_controller->getValue($templateRS[0]['MailTemplateBodyText'],$lang);
			if(!empty($templateContent))
			{
				if(is_array($in['MailData']))
				{
					$templateContent = $this->_parseMailData($in['MailData'],$templateContent);	
				}
				else
				{
					$templateContent = str_replace("{MailContent}",$in['MailContent'],$templateContent);
				}
				if(!empty($templateHeaderContentTEXT)) {$retval['text'] =  str_replace("{body}",$templateContent,$templateHeaderContentTEXT);} else {$retval['text'] = $templateContent;}
				$retval['text'] = stripslashes($retval['text']);
				$retval['text'] =  str_replace("&quot;","\"",$retval['text']);
			}		
			//get XML
			//echo 'content='.$retval['html'];
			
			$templateContent = $this->_controller->getValue($templateRS[0]['MailTemplateSubject'],$lang);
			if(!empty($templateContent))
			{
				if(is_array($in['MailData']))
				{
					$templateContent = $this->_parseMailData($in['MailData'],$templateContent);	
				}
				else
				{
					$templateContent = str_replace("{MailContent}",$in['MailContent'],$templateContent);
				}
				$retval['subject'] = stripslashes($templateContent);		
				$retval['subject'] =  str_replace("&quot;","\"",$retval['subject']);
			}	
		}	
		return $retval;
	}
	
	function _parseMailData($mailData,$templateContent,$mode='')
	{
		if(is_array($mailData))
		{
			foreach($mailData as $code=>$value)
			{
				if(is_array($value))
				{
					$rowContent = str_replace("\n","||NL||",$templateContent);
					//echo 'rowContent='.$rowContent.' code='.$code.'<hr>';
					//echo "/\{".$code."\}(.*)\{\/".$code."\}/i<hr>";
					preg_match ("/\{".$code."\}(.*)\{\/".$code."\}/i", $rowContent, $resultRowContent);
					//print_r($resultRowContent);
					//echo 'rowContentMatched='.$resultRowContent[1].' code='.$code.'<hr>';
					if(!empty($resultRowContent[1]))
					{
						$rowContentOriginal = str_replace("||NL||","\n",$resultRowContent[1]);
						$rowContentResult = '';
						foreach($value as $row)
						{
							if(is_array($row))
							{
								$rowContent = $rowContentOriginal;
								foreach($row as $rowFieldCode=>$rowFieldValue)
								{
									$rowContent = str_replace("{".$code."/".$rowFieldCode."}",$rowFieldValue,$rowContent);
								}
							}
							//echo 'rowContentParsed='.$rowContent.' code='.$code."/".$rowFieldCode.'<hr>';
							$rowContentResult .= $rowContent;
						}		
						
						$templateContent = str_replace("{".$code."}",$rowContentResult,$templateContent);
						$templateContent = str_replace("{/".$code."}",'',$templateContent);		
						$templateContent = str_replace($rowContentOriginal,'',$templateContent);					
					}
				}
				else
				{
					$templateContent = str_replace("{".$code."}",$value,$templateContent);
				}
			}
		}		
		
		return $templateContent;		
	}
	
	/**
	*	Sends emails from templates
	*
	*/
	function _sendTemplate($in)
	{

		$config = $this->_config;
		$lang = $in['MailLanguage'];
		if(empty($lang)) {$lang = $config['SiteLang'];}
		$mailEncoding = $this->_getMailEncoding($lang);
		$mailFormat = $in['MailFormat'];
		if(empty($mailFormat)) {$mailFormat = 'html';}
		$mailAttachement=$in['MailAttachement'];
		
		if($in['MailTo'])
		{
			
			if ($in['MailFrom'])
			{
				
				if($in['MailFromName'])
				{
					$mailFrom = '"'.$in['MailFromName'].'"'.'<'.$in['MailFrom'].'>';
					$inLog['MailLog'.DTR.'MailFrom'] = $in['MailFrom'];	
					$inLog['MailLog'.DTR.'MailFromName'] = $in['MailFromName'];
				}
				else
				{
					$mailFrom = '"'.$in['MailFrom'].'"'.'<'.$in['MailFrom'].'>';
					$inLog['MailLog'.DTR.'MailFrom'] = $in['MailFrom'];	
					$inLog['MailLog'.DTR.'MailFromName'] = $in['MailFrom'];								
				}
			}
			else
			{
				//torefact0: need to get default settings from user's specific settings. Possible this can be done globally by changing of config
				$mailFrom = '"'.$config['SiteName'].'"'.'<'.$config['SiteMail'].'>';
				$inLog['MailLog'.DTR.'MailFrom'] = $config['SiteMail'];	
				$inLog['MailLog'.DTR.'MailFromName'] = $config['SiteName'];
			}
			if($in['MailToName'])
			{
				$mailTo = '"'.$in['MailToName'].'"'.'<'.$in['MailTo'].'>';
				$inLog['MailLog'.DTR.'MailTo'] = $in['MailTo'];
				$inLog['MailLog'.DTR.'MailToName'] = $in['MailToName'];				
			}
			else
			{
				if(empty($in['MailTo']))
				{
					$mailTo = '"'.$config['SiteName'].'"'.'<'.$config['SiteMail'].'>';
					$inLog['MailLog'.DTR.'MailTo'] = $config['SiteMail'];
					$inLog['MailLog'.DTR.'MailToName'] = $config['SiteName'];							
				}
				else
				{
					$mailTo = '"'.$in['MailTo'].'"'.'<'.$in['MailTo'].'>';
					$inLog['MailLog'.DTR.'MailTo'] = $in['MailTo'];
					$inLog['MailLog'.DTR.'MailToName'] = $in['MailTo'];							
				}
			}			

			$inText = $this->_getTemplate($in);
			//print_r($inText);
			if(!empty($inText))
			{
				
				if($in['MailSubject'])
				{
					$subject = $in['MailSubject'];
				}
				else
				{
					$subject = $inText['subject'];
				}
				//echo $xml;
				//$xml = $inText['xml'];
				//$xsl = $inText['xsl'];
				//$xslTXT = $inText['xslTXT'];			
				//die($inText['xml']);
				///echo 'tttttt<br>';
				//if(!empty($xsl))
				//{
					//$mailHtml = $this->_controller->xslt($xml,$xsl);
					//die($mailHtml);
				//}
				//if(!empty($xslTXT))
				//{
					//$mailText = $this->_controller->xslt($xml,$xslTXT);
					//die($xslTXT);
				//}
				//$mailText = 'tesst';
				//echo $mailtext;
				$mailHtml = $inText['html'];
				$mailText = $inText['text'];
				
				if($in['MailLog'] == 'yes')
				{
					$inLog['MailLog'.DTR.'MailTemplate'] = $in['MailTemplate'];			
					$inLog['MailLog'.DTR.'MailSubject'] = $subject;
					if(!empty($in['MailContent']))
					{
						$inLog['MailLog'.DTR.'MailData'] = '<'.'Content'.'><![CDATA['.$in['MailContent'].']]></'.'Content'.'>';
					}
					else
					{
						$inLog['MailLog'.DTR.'MailData'] = $in['MailData'];
					}
					$this->addMailLog($inLog);
				}
				$this->_sendMail ($mailTo,$subject,$mailHtml,$mailText,$mailFrom,$mailFormat,$mailEncoding,$mailAttachement);
				//echo $mailTo;
				//$this->deleteMail($in['MailID']);
			}
			
		}
		else
		{
			
			$this->_controller->setDebug('mailServer._sendTemplate.err.NoMailTo','MailID: '.$in['MailID']);
			$this->_controller->setMessage('mailServer._sendTemplate.err.NoMailTo','MailID: '.$in['MailID']);
			return false;
		}
	}
	
	/**
	*	Sends emails prepared by sendTemplate method
	*
	*/
	function _sendMail ($toEmail,$subject,$mailHtml,$mailText,$mailFrom,$mailFormat='',$mailEncoding='',$mailAttachement='')
	{
			global $showmode;
			
			//$showmode = 'mail';
			$config = $this->_config;
			//elseif($mailFormat == 'html'){$mailFormat = 'text/html';}
			//else {$mailFormat = 'text/html';}
			//$toemail = 'ac@krasa.com.ua';
			//$input['showmode'] = 'mail';
			//$this->_testMode = 'show';
			//split in lines not more then 1024
			
			//$NewEncoding = new ConvertCharset();
			if(!empty($subject))
			{
				if($mailEncoding!='utf-8')
				{				
					//$newSubject = $NewEncoding->Convert($subject, "utf-8", $mailEncoding);
				}
				//$subject = $newSubject;
				$subject = str_replace("\\","",$subject);
			}
			if(!empty($mailText))
			{
				if($mailEncoding!='utf-8')
				{	
					//$newMailText = $NewEncoding->Convert($mailText, "utf-8", $mailEncoding);
				}
				//$mailText = $newMailText;
				//$mailText = eregi_replace("charset=UTF-8", "charset=".$mailEncoding."",$mailText);
				//$mailText = eregi_replace(">",">\n",$mailText);
				//$mailText = str_replace("\n\n","\n",$mailText);
				//$mailText = str_replace("\\","",$mailText);
				//$xmlTopString = '<'.'?xml version="1.0" encoding="UTF-8"?'.'>';
				//$mailText = str_replace($xmlTopString,"",$mailText);				
			}
			if(!empty($mailHtml))
			{
				if($mailEncoding!='utf-8')
				{	
					//$newMailHtml = $NewEncoding->Convert($mailHtml, "utf-8", $mailEncoding);
				}
				//$mailHtml = $newMailHtml;
				//$mailHtml = eregi_replace("charset=UTF-8", "charset=".$mailEncoding."",$mailHtml);
				//$mailHtml = eregi_replace(">",">\n",$mailHtml);
				//$mailHtml = str_replace("\\","",$mailHtml);
			}		
			if(!empty($toEmail))
			{
				if($mailEncoding!='utf-8')
				{			
					//$toEmail = $NewEncoding->Convert($toEmail, "utf-8", $mailEncoding);
				}
			}
			if(!empty($mailFrom))
			{
				if($mailEncoding!='utf-8')
				{
					//$mailFrom = $NewEncoding->Convert($mailFrom, "utf-8", $mailEncoding);
				}
			}
			//echo "<textarea><b>toEmail: $toEmail,subject: $subject,mailText: $mailText,From: $mailFrom \nContent-Type: $mailFormat;charset=\"$mailEncoding\nX-Mailer: XCMSPro</b><br></textarea>";
			if($showmode == 'mail')
			{
				die("<b>toEmail: $toEmail,subject: $subject,mailText: $mailText,From: $mailFrom \nContent-Type: $mailFormat;charset=\"$mailEncoding\nX-Mailer: XCMSPro</b><br>");
			}
			else
			{
				if($this->_testMode=='show')
				{
					$toEmailShow = eregi_replace("<", "&lt;", $toEmail);
					$toEmailShow = eregi_replace(">", "&gt;", $toEmailShow);
					$mailFromShow = eregi_replace("<", "&lt;", $mailFrom);
					$mailFromShow = eregi_replace(">", "&gt;", $mailFromShow);
					$print = "<b>EmailTo: $toEmailShow | EmailSubject: $subject | EmailFrom: $mailFromShow | MailFormat: $mailFormat | MailCharSet: $mailEncoding<br><hr>";
					$print .= $mailText;
					die($print);
				}
				elseif($this->_testMode=='send')
				{
					//mail($toEmail,$subject,$mailText,"From: ".$mailFrom."\nContent-Type: ".$mailFormat.";charset=\"".$config['MailEncoding']."\"\nX-Mailer: XCMSPro");					
					$toEmailShow = eregi_replace("<", "&lt;", $toEmail);
					$toEmailShow = eregi_replace(">", "&gt;", $toEmailShow);
					$mailFromShow = eregi_replace("<", "&lt;", $mailFrom);
					$mailFromShow = eregi_replace(">", "&gt;", $mailFromShow);					
					$print = "<b>EmailTo: $toEmailShow | EmailSubject: $subject | EmailFrom: $mailFromShow | MailFormat: $mailFormat | MailCharSet: $mailEncoding<br><hr>";
					$print .= "<center><h3>E-mail is sent</h3></center>";
					die($print);
				}
				else
				{
					//sleep(10);
					//echo $toEmail.'<br>';
					//$log = "<b>EmailTo: $toEmail | EmailSubject: $subject | EmailFrom: $mailFrom | MailFormat: $mailFormat | MailCharSet: $config[MailEncoding]<br><hr>";
					//echo $mailText;
					//die($log);
					//$this->_mailLog($log);
					if($config['MailMode'] =='local')
					{
						//die($mailText);
						$log = "<b>EmailTo: $toEmail | EmailSubject: $subject | EmailFrom: $mailFrom | MailFormat: $mailFormat | MailCharSet: $mailEncoding<br>MailContent:<br>$mailHtml<br><hr>";
						$this->_mailLog($log);
						$returnPath = $config['SiteMail'];
						$this->_mail($toEmail,$subject,$mailHtml,$mailText,$mailFrom,$mailFormat,$mailEncoding,$returnPath,$mailAttachement);
					}
					else
					{
						$returnPath = $config['SiteMail'];
						if(eregi($config['SiteMail'],$toEmail) && $config['SMSRemindStatus']=='Y' && !empty($config['SMSRemindEmail']))
						{
							$this->_mail($config['SMSRemindEmail'],$subject,$subject,$subject,$mailFrom,'txt',$mailEncoding,$returnPath);
						}
						$this->_mail($toEmail,$subject,$mailHtml,$mailText,$mailFrom,$mailFormat,$mailEncoding,$returnPath,$mailAttachement);
					}
				}
			}
	}
	
	function _getMailEncoding($lang)
	{
		//$langEncoding
		return 'utf-8';
		
		$config = $this->_config;
		$langEncoding = array(
			'en'=>'iso-8859-1',
			'ru'=>'windows-1251',
			'fr'=>'iso-8859-2',
			'de'=>'iso-8859-2',
			'nl'=>'iso-8859-2'
		);
		$mailEncoding = $langEncoding[$lang];
		if(empty($mailEncoding))
		{
			$mailEncoding = $config['MailEncoding'];
		}
		
		return $mailEncoding;
	}

	//build and send the email via mail or SMTP
	function _mail($toEmail,$subject,$mailHTML,$mailTEXT='',$fromEmail='',$mailFormat='',$mailEncoding='',$returnPath='',$mailAttachement='')
	{
//echo "asdf_blin";
			$config = $this->_config;
			/**
	        * Build and send the email
	        */	//echo "MEME";		
			$mail = new htmlMimeMail();
			$text = $mailTEXT;
			$html = $mailHTML;
			//echo '$html='.$html;
			//echo '$text='.$text.'<br>';
			
			$mail->setTextCharset($mailEncoding);
			$mail->setHtmlCharset($mailEncoding);
			$mail->setHeadCharset($mailEncoding);
			
			if ($mailFormat == 'mime') {
				$mail->setHtml($html, $text, './');
			} elseif ($mailFormat == 'txt' or $mailFormat == 'sms') {
				$mail->setText($text);
			} else {
				$mail->setHtml($html);
			}
			
			$mail->setFrom($fromEmail);
			$mail->setSubject($subject);
			if (empty($returnPath))
			{
				$mail->setReturnPath($from);
			}
			else 
			{
				$mail->setReturnPath($returnPath);
			}
			if ($mailAttachement != ""){
				$locattach = "attach/$mailAttachement";
				$attachment = $mail->getFile($locattach);
      			$mail->addAttachment($attachment, $link1n, $link1t);
			}	
			$em_xmid=base64_encode($toEmail);
			$mail->setHeader('X-mid', $em_xmid);
			
			if($config['MailMode']=='smtp')
			{
				if(!empty($config['MailUser']))
				{
					$auth = true;
				}
				else
				{
					$auth = false;
				}
				//echo 'ttt host='.$config['MailHost'];
				$mail->setSMTPParams($config['MailHost'],$config['MailPort'],$config['MailHello'],$auth,$config['MailUser'],$config['MailPassword']);
//echo "smtp|";
//print_r($toEmail);
				$sendResult = $mail->send(array($toEmail),'smtp');
//echo $sendResult;
			}
			else
			{
//echo "common|";
//print_r($toEmail);
//echo "|";
				$sendResult = $mail->send(array($toEmail));
//echo $sendResult;
			}				
	}
	
	function _getTime($mode='')
	{
		if($mode == 'now')
		{
			return date('Y-m-d H:i:s');
		}
		else
		{
			return $this->_currentTime;
		}
	}
	
	function _cleanUpStrings($value)
	{
		return addslashes(stripslashes($value));
	}
	
	function _queueMail($in)
	{
		$where['Mail'] = "MailID=''";
		//echo 'MailData='.$in['MailData'].'<br>';
		$input['Mail'.DTR.'MailTo'] = $this->_cleanUpStrings($in['MailTo']);
		$input['Mail'.DTR.'MailToName'] = $this->_cleanUpStrings($in['MailToName']);
		$input['Mail'.DTR.'MailFrom'] = $this->_cleanUpStrings($in['MailFrom']);
		$input['Mail'.DTR.'MailFromName'] = $this->_cleanUpStrings($in['MailFromName']);
		$input['Mail'.DTR.'MailSubject'] = $this->_cleanUpStrings($in['MailSubject']);
		if(empty($in['MailFormat']))
		{
			$input['Mail'.DTR.'MailFormat'] = 'html';
		}
		else
		{
			$input['Mail'.DTR.'MailFormat'] = $in['MailFormat'];					
		}
		
		if(!empty($in['MailContent']))
		{
			$in['MailData']['MailContent'] = $in['MailContent'];
			$input['Mail'.DTR.'MailData'] = serialize($in['MailData']);
		}
		else
		{
			$input['Mail'.DTR.'MailData'] = serialize($in['MailData']);
		}
		$input['Mail'.DTR.'MailSubject'] = $this->_cleanUpStrings($in['MailSubject']);
		$input['Mail'.DTR.'MailTemplate'] = $in['MailTemplate'];
		if(empty($in['MailStart']) or $in['MailStart'] == 'now')
		{
			$input['Mail'.DTR.'TimeStart'] = $this->_getTime();
		}
		else
		{
			$input['Mail'.DTR.'TimeStart'] = $in['MailStart'];
		}
		$input['Mail'.DTR.'MailIndex'] = $in['Mail'.DTR.'MailIndex'];
		$input['Mail'.DTR.'MailSession'] = $in['Mail'.DTR.'MailSession'];
		$input['Mail'.DTR.'MailLanguage'] = $in['MailLanguage'];		
		$input['actionMode'] = 'save';
		$saveResult = $this->_DS->save($input,$where,'insert');
		//$retval = $saveResult;
		$retval = '';
		return $retval;
	}	
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function MailServer()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$DS = new DataSource('main');
		$this->_DS = &$DS;
		$this->_config = $this->_controller->getConfig();
		$this->_mailsInThread = 1;
		$this->_threadPeriod = 60*2;//2 minutes		
		//$dsDef = $this->_DS->getSourceDefinition('mail');
		$this->_DBX = '';
		$this->_currentTime = date('Y:m:d H:i:s');
		$config = $this->_config;
		if(!empty($config['RemoteOwnerID']))
		{
			$clientIN['langMode'] = 'nolanguage';	
			$clientIN['PromoProfileUserID'] = $config['RemoteOwnerID'];		
			$result = $SERVER->callService('getPromoProfileSettings','promoServer',$clientIN,'array');
			$clientRS = $result['array']['ServiceResponse']['#']['PromoProfile'][0]['#'];	
			//echo '<hr>PromoProfileEmail='.$clientRS['PromoProfileEmail']['0']['#'].'<hr>';			
			$CORE->setConfigVar('SiteMail',$clientRS['PromoProfileEmail']['0']['#']);
			$CORE->setConfigVar('SiteName',$clientRS['PromoProfileSiteName']['0']['#']);
			$CORE->setConfigVar('SiteSlogan',$clientRS['PromoProfileSiteSlogan']['0']['#']);
			$CORE->setConfigVar('URLSE',$clientRS['PromoProfileRemoteURL']['0']['#'].'?');
			$this->_config = $this->_controller->getConfig();
			//print_r($clientRS);
		}
		else
		{
			$CORE->setConfigVar('URLSE',$config['RootURL'].$config['URLSearchEngine']);
		}
	}
	// PUBLIC METHODS
	function newMailSession()
	{
		$mailSession = $this->_controller->getUniqueID();
		$this->_mailSession = $mailSession;
		return $mailSession;
	}
	function queueMail($input)
	{
		$this->_controller->setDebug('mailServer.queueMail.Start','Start');
		//$input = $this->_controller->getInput();
		//print_r($input);
		$mailSession = $this->newMailSession();	
		if(!empty($input['MailTo']) or !empty($input[0]['MailTo']) )
		{
			if(is_array($input[0]))
			{
				$i=0;
				foreach ($input as $rowNumber=>$mailRow)
				{
					if($rowNumber == $i)
					{
						$i++;
						if(!empty($input['MailData']))
						{
							$mailRow['MailData'] = $input['MailData'];
						}
						if(!empty($input['MailTemplate']))
						{
							$mailRow['MailTemplate'] = $input['MailTemplate'];
						}
						if(!empty($input['MailFrom']))
						{
							$mailRow['MailFrom'] = $input['MailFrom'];
						}
						if(!empty($input['MailFromName']))
						{
							$mailRow['MailFromName'] = $input['MailFromName'];
						}
						if(!empty($input['MailSubject']))
						{
							$mailRow['MailSubject'] = $input['MailSubject'];
						}
						if(!empty($input['MailContent']))
						{
							$mailRow['MailContent'] = $input['MailContent'];
						}
						if(!empty($input['MailLanguage']))
						{
							$mailRow['MailLanguage'] = $input['MailLanguage'];
						}
						$mailRow['Mail'.DTR.'MailSession']=$mailSession;
						$mailRow['Mail'.DTR.'MailIndex'] = $i;
						$retval = $this->_queueMail($mailRow);
					}
				}
			}
			else
			{
				$input['Mail'.DTR.'MailSession']=$mailSession;
				$input['Mail'.DTR.'MailIndex'] = 1;
				$retval = $this->_queueMail($input);
				//echo 'queued='.$retval;
				return $retval;
			}
		}
		else
		{
			return '';
		}
		$this->_controller->setDebug('mailServer.queueMail.Enf','End');
		//$retval = $dsResult['xml'];	
	}
	
	//sends 1 e-mail without queue
	function sendMail($in)
	{
		//print_r($in);
		if(!empty($in['MailTo']))
		{
			$this->_sendTemplate($in);
			return true;
		}
		else
		{
			return false;
		}
	}
	//sends 1 queued session of emails
	function sendMailSession($mailSession)
	{
		//$this->_controller->setDebug('mailServer.sendMail.Start','Start');
		$mailsInThread = $this->_mailsInThread;
		//generate and send a thread of emails
		$mailThreadLastIndex = $this->getLastMailThread($mailSession);
		$mailEndIndex = $mailThreadLastIndex + $mailsInThread;
		//$sql = "SELECT * FROM {dbprefix}Mail WHERE TimeStart <= '".$this->_getTime('now')."' AND MailSession='".$mailSession."' AND MailIndex > $mailThreadLastIndex AND  MailIndex <= $mailEndIndex";
		$sql = "SELECT * FROM Mail WHERE TimeStart <= '".$this->_getTime('now')."' AND MailSession='".$mailSession."' AND MailIndex >= $mailThreadLastIndex";
		$dsResult = $this->_DS->query($sql);
		//echo $sql.'<br>';
		$threadSent='';
		//echo $sql.'<br>';
		
		if(is_array($dsResult))
		{
			//echo $sql.'<br>';
			$mailThreadID = $this->addMailThread($mailSession,$mailThreadLastIndex,$mailEndIndex);
			
			while (list($rowNumber,$row)= each($dsResult)) 
			{
				while (list($fieldName,$fieldValue)= each($row)) 
				{
					$toSend[$fieldName] = $fieldValue;
				}
				if($mode=='log')
				{
					$toSend['MailLog']='yes';
				}
				//$toSend['MailLog']='yes';//jb 6.12.05 temp
				
				//echo 'mailID: '.$row['MailID'].' : sendSession'.$mailSession.' : thredID='.$mailThreadID.'<br>';
				//$this->_mailLog('mailID: '.$row['MailID'].' MailIndex:'.$row['MailIndex'].LB);
				$toSend['MailData'] = unserialize($toSend['MailData']);
				$this->deleteMail($row['MailID']);
				$this->_sendTemplate($toSend);
			}
			//delete thread here
			$this->deleteMailThreads($mailThreadID);
			//delete mails from the thread here
			//$this->deleteMailSession($mailSession,$mailThreadLastIndex,$mailThreadLastIndex+$mailsInThread);
			//$this->deleteThread($mailSession,$mailStat,$mailEnd);
			$threadSent =1;
		}
		/*!!!
		if($threadSent==1) 
		{
			//session is not finishes ... send next thread
			$this->sendMailSession($mailSession);
		}
		else 
		{
			//the whole session was sent ... go to next session
			return true;
		}
		!!!*/
		//$this->_controller->setDebug('mailServer.sendMail.End','End');	
	}
	
	//sends all queued emails
	function sendMailQueue($mode='')
	{
		$this->_controller->setDebug('mailServer.sendMailQueue.Start','Start');
		//get all sessions
		$sessionsSQL = "SELECT DISTINCT(MailSession) FROM Mail WHERE TimeStart <= '".$this->_getTime('now')."'";
		$sessionsRS = $this->_DS->query($sessionsSQL);
		if(is_array($sessionsRS))
		{
			//$this->_controller->setLog('mailServer.sendMailQueue.msg.StartToSendMailQueue','Start to send the whole mail queue');
			foreach($sessionsRS as $row)
			{
				//send e-mail for each session
				$this->sendMailSession($row['MailSession']);
				
				//die here to avoid timeout ... sendMailQueue must be run from outside for each mail thread
				//becouse of die() a new session can not be sent untill current session is sent
				//$this->_controller->setLog('mailServer.sendMailQueue.msg.MailSassionIsSent','Mail session in current queue is sent. SessionID:'.$row['MailSession']);
				//die('');
			}
			//$this->_controller->setLog('mailServer.sendMailQueue.msg.EndToSendMailQueue','End to send the whole mail queue');			
		}
		else
		{
			//no mail to send in queue
			//echo 'no mail to send in queue';
		}
		$this->_controller->setDebug('mailServer.sendMailQueue.End','End');
	}
	
	function addMailLog($inLog)
	{
		$user = $this->_controller->getUser();
		$inLog['actionMode'] = 'save';
		$inLog['MailLog'.DTR.'MailSessionID'] = $user['SessionID'];
		$where['MailLog'] = "MailLogID=''";
		$this->_DS->save($inLog,$where,'insert');
	}
	function getLastMailThread($mailSession)
	{
		$sql = "SELECT MAX(MailEnd) as lastIndex FROM MailThread WHERE MailListSession = '$mailSession'";

		$dsResult = $this->_DS->query($sql);
		//print_r($dsResult);
		$mailThreadLastIndex = $dsResult[0]['lastIndex'];
		//echo $mailThreadLastIndex.'<br/>';
		if(empty($mailThreadLastIndex)) 
		{
			//no mail threads for this session: 2 cases 1. session is sending the first time 2. old mailthreads were deleted
			$sql = "SELECT MIN(MailIndex) as startMailIndex FROM Mail WHERE MailSession='$mailSession'";
			$dsResult = $this->_DS->query($sql);
			$mailSessionFirstIndex = $dsResult[0]['startMailIndex'];			
			if(!empty($mailSessionFirstIndex))
			{
				//case2
				$mailThreadLastIndex = $mailSessionFirstIndex;
			}
			else
			{
				//case1
				$mailThreadLastIndex=1;
			}
		}
		return $mailThreadLastIndex;
	}
	//jb 6.12.05 refactored
	function addMailThread($mailSession,$mailStart,$mailEnd,$UserID='')
	{	
		$in['MailThread'.DTR.'MailStart'] = $mailStart;
		//$in['MailThread'.DTR.'UserID'] = $UserID;
		$in['MailThread'.DTR.'MailEnd'] = $mailEnd;
		$in['MailThread'.DTR.'MailListSession'] = $mailSession;
		$in['actionMode'] = 'save';
		$where['MailThread'] = "MailThreadID=''";
		$this->_DS->save($in,$where,'insert');
		
		//get just created MailThreadID;
		$sql = "SELECT MailThreadID FROM MailThread WHERE MailStart='$mailStart' AND MailEnd='$mailEnd' AND MailListSession='$mailSession' ORDER BY TimeCreated DESC LIMIT 1";
		$rs = $this->_DS->query($sql);
		$newMailThreadID = $rs[0]['MailThreadID'];
		return $newMailThreadID;
	}
	
	//jb 5.12.05 refactored
	function deleteMailSession($sessionID,$mailStart,$mailEnd)
	{
		if(!empty($sessionID) and !empty($mailStart) and !empty($mailEnd))
		{
			$sql = "DELETE FROM Mail WHERE MailSession = '$sessionID' AND MailIndex>='$mailStart' AND MailIndex<'$mailEnd'";
			//echo 'deleteMailSession'.$sql.'<br>';
			$this->_DS->query($sql);
		}
	}
	
	//jb 5.12.05 refactored
	function deleteMailThreads($mailThreadID)
	{
		if(!empty($mailThreadID))
		{
			$sql = "DELETE FROM MailThread WHERE MailThreadID='$mailThreadID'";
			//echo 'deleteMailThreads'.$sql.'<br>';
			$this->_DS->query($sql);
		}
	}
	
	//jb 5.12.05 refactored
	function deleteMail($mailID)
	{
		$this->_controller->setDebug('mailServer.queueMail.Start','Start');
		if(!empty($mailID))
		{
			/*
			$input = $this->_controller->getInput();
			$where['Mail'] = "MailID = '".$mailID."'";		
			$input['actionMode'] = 'delete';
			$input['Mail'.DTR.'MailID'] = $mailID;
			//echo 'MailID'.$mailID;
			$saveResult = $this->_DS->save($input,$where,'delete');
			$this->_controller->setDebug('mailServer.queueMail.Enf','End');
			return true;	
			*/
			$sql = "DELETE FROM Mail WHERE MailID='$mailID'";
			//echo 'deleteMailThreads'.$sql.'<br>';
			$this->_DS->query($sql);			
			
		}
		else
		{
			return false;
		}
	}
	
	function testEmailTemplate($input)
	{
		$config = $this->_controller->getConfig();
		$inMail['MailTemplate'] = $input['MailTemplate'];
		$inMail['MailTemplate'] = eregi_replace("\.xml", "", $inMail['MailTemplate']);
		$inMail['MailTemplate'] = eregi_replace("\.xsl", "", $inMail['MailTemplate']);
		$inMail['MailTemplate'] = eregi_replace("\.txt", "", $inMail['MailTemplate']);
		
		$inMail['MailFrom'] = $input['MailFrom'];
		$inMail['MailFromName'] = $input['MailFromName'];
		$inMail['MailSubject'] = $input['MailSubject'];
		$inMail['MailContent'] = $input['MailContent'];
		
		$inMail['MailTo'] = $config['SiteMail'];
		if($input['testMode']=='send')
		{
			$this->_testMode = 'send';
		}
		else
		{
			$this->_testMode = 'show';
		}
		$this->_sendTemplate($inMail);
	}
	
	function getMailQueue($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MailServer.getMailQueue.Start','Start');	
		$DS = &$this->_DS;
		$user = $SERVER->getUser();
		$userID = $user['UserID'];
		//$search = $DS->makeSearchQuery($input);
	
		if($SERVER->hasRights('MailServer.adminMails'))
		{
			$xcmsq = "Mail/sortdesc(Mail.TimeCreated)";
			$mode['pagesMode']=20;
			$getRS = $DS->query($xcmsq,$mode);
			$SERVER->setDebug('MailServer.getMailQueue.End','End');
			return $getRS;		
		}
		else
		{
			$SERVER->setMessage('MailServer.getMailQueue.err.NoRights');
			return false;			
		}
	}
	
	//used for bounced emails parser
	function getMailFromSTDIN()
	{
		$return = '';
		if ($fp = fopen('php://stdin', 'rb')) {
			while ($line = fread($fp, 1024)) {
				$return .= $line;
			}
			fclose($fp);
			return array($return);
		}
		return false;
	}

	//used for bounced emails parser
	function getMailFromPOP3()
	{
		//require_once(dirname(__FILE__) . '/POP3.php');
		$pop3 = new Net_POP3();
		$pop3->connect($pop_ho, $pop_po);
		$result = $pop3->login($pop_us, $pop_pa, false) OR DIE ("Invalid POP account information.  Unable to connect.  Check your POP account information in the bounced email configuration.");
		if ($result === true) {
			$numMsg = $pop3->numMsg();
			for ($i=1; $i<=$numMsg; $i++) {
			if ($i <= 125){
				$activdelete = $pop3->getMsg($i);
			if (preg_match('/^X-mid: (.*)\s*$/im', $activdelete, $matchesD)) {
				$return[] = $pop3->getMsg($i);
				$pop3->deleteMsg($i);
			}
			}
			}
			$pop3->disconnect();
			return $return;
		}
		return false;
	}

	//used for bounced emails parser	
	function getBounceAddresses($input)
	{
		$method=$input['Method'];
		if(empty($method))
		{
			$method = 'pop3';
		}
		$return = array();
		$messages = ( $method == 'stdin' ? getMailFromSTDIN() : getMailFromPOP3() );
		if ($messages != ""){
		foreach ($messages as $msg) {
			if (preg_match('/^X-mid: (.*)\s*$/im', $msg, $matches)) {
				$return[] = $matches[1];
			}
		}
		}
		return $return;
	}	
}// end of MailServer

?>
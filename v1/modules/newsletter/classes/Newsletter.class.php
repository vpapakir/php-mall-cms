<?php
//XCMSPro: Web Service entity class
class NewsletterServerClass
{
    // PRIVATE PROPERTIES
	var $_DS;
	var $_controller;
	var $_config;
	// PRIVATE METHODS
	function _getNewsletterFormat($newsletterFormat,$subscriberFormat)
	{
		if($newsletterFormat=='mime')
		{
			if($subscriberFormat=='html')
			{
				return 'html';
			}
			elseif($subscriberFormat=='txt')
			{
				return 'txt';
			}
			else
			{
				return 'mime';
			}
		}
		elseif($newsletterFormat=='html')
		{
			if($subscriberFormat=='txt')
			{
				return 'txt';
			}
			else
			{
				return 'html';
			}			
		}
		else
		{
			return 'txt';
		}
	}
	
	
	
	
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function NewsletterServerClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	
	// PUBLIC METHODS
	
	function getNewsletters($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterServerClass.getNewsletters.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//print_r($input);
		//set client side variables
		$entityStatus = $input['NewsletterStatus'];
		$entitySubscribersGroup = $input['NewsletterSubscribersGroup'];
		$newsletterIsTemplate = $input['NewsletterIsTemplate'];
		$searchWord = $input['searchWord'];
		//set filters
		//jb 14.11.05 tmp coment $filter = $DS->getAccessFilter($input,'NewsletterServerClass.adminNewsletter');
		//if($SERVER->hasRights('NewsletterServer.adminCompanies')) {
			if(!empty($searchWord))
			{
				$filter .= " AND (NewsletterTitle LIKE '{ls}%$searchWord%{le}' OR NewsletterTitle LIKE '%$searchWord%' OR NewsletterContent LIKE '{ls}%$searchWord%{le}' OR NewsletterContent LIKE '%$searchWord%' OR NewsletterContentText LIKE '{ls}%$searchWord%{le}' OR NewsletterContentText LIKE '%$searchWord%')";
			}
			if(!empty($entityStatus))
			{
				$filter .= " AND NewsletterStatus='$entityStatus' ";
			}
			if(!empty($entitySubscribersGroup))
			{
				$filter .= " AND NewsletterSubscriberGroup='$entitySubscribersGroup' ";
			}
			if($newsletterIsTemplate=='Y')
			{
				$filter .= " AND NewsletterIsTemplate='Y' ";
			}
			else
			{
				$filter .= " AND NewsletterIsTemplate!='Y' ";
			}
			//set queries
			$query = "SELECT * FROM Newsletter WHERE 1 $filter ORDER BY Newsletter.TimeCreated DESC";
			//jb 14.11.05 tmp coment because method empty $mode['pagesMode']=100;
			//echo $query;
			//get the content
			$result = $DS->query($query,$mode);
			//print_r($result);
			$SERVER->setDebug('NewsletterServerClass.getNewsletters.End','End');
			return $result;
		//}
	}
	
	function setNewsletter($input)
	{
		//print_r($input);
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterServerClass.setNewsletter.Start','Start');	
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		/*jb 14.11.05 tmp commented
		if($SERVER->hasRights('NewsletterServer.adminCompanies'))
		{
			$filter = "";
		}
		else
		{
			$filter = " AND UserID='$userID'";			
		}*/
		$NewsletterID = $input['Newsletter'.DTR.'NewsletterID'];
		if(!empty($NewsletterID))
		{
			$where['Newsletter'] = "NewsletterID = '".$NewsletterID."'".$filter;
		} else {
			$where['Newsletter'] = '';
		  }
		
		$saveRS = $DS->save($input,$where);
		$SERVER->setDebug('NewsletterServerClass.setNewsletter.End','End');
		return $saveRS;		
	}
	
	function getNewsletter($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterServerClass.getNewsletter.Start','Start');	
		$DS = &$this->_DS;
		$user = $SERVER->getUser();
		$userID = $user['UserID'];
		//print_r($user);
		$entityID = $input['Newsletter'.DTR.'NewsletterID'];
		if(empty($entityID)) {$entityID = $input['NewsletterID'];}
		//jb 14.11.05 tmp commented
		//if($SERVER->hasRights('NewsletterServer.adminNewsletters'))
		//{
			$query = "SELECT * FROM Newsletter WHERE NewsletterID='$entityID'";
			$NewsletterRS = $DS->query($query);
			$result = $NewsletterRS;
		//}
		$SERVER->setDebug('NewsletterServerClass.getNewsletter.End','End');
		return $result;		
	}
	
	function sendTestNewsletter($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterServerClass.sendTestNewsletter.Start','Start');
		$DS = &$this->_DS;
		$newsletterID =$input['NewsletterID'];
		$config = $SERVER->getConfig(); 
		if(!empty($newsletterID))
		{
			$sql = "SELECT * FROM Newsletter WHERE NewsletterID='$newsletterID'";
			$newsletterRS = $DS->query($sql);
			
			//tmp jb 18.11.05 to see test email in log
			$emailIN['MailLog'] = 'yes';
			
			$emailIN['MailTo'] = $input['Test'.DTR.'MailTo'];
			if(empty($emailIN['MailTo'])) {$emailIN['MailTo'] = $config['SiteMail'];}
			$emailIN['MailToName'] = $config['SiteName'];
			$emailIN['MailLanguage'] = $config['SiteLang'];
			
			if(empty($newsletterRS[0]['NewsletterTemplate']))
			{
				$emailIN['MailTemplate'] ='newsletter/newsletter';
			} else {
				 $emailIN['MailTemplate'] = 'newsletter/'.$newsletterRS[0]['NewsletterTemplate'];
			  }
			  
			$emailIN['MailFrom'] = $newsletterRS[0]['NewsletterFrom'];
			$emailIN['MailFromName'] = $newsletterRS[0]['NewsletterFromName'];
			$emailIN['MailSubject'] = $SERVER->getValue($newsletterRS[0]['NewsletterTitle'],$config['lang']);					
			$emailIN['MailFormat'] = $input['Test'.DTR.'MailFormat'];
			if(empty($emailIN['MailFormat'])) {$emailIN['MailFormat'] = 'html';}
			
			if($emailIN['MailFormat']=='html' or $emailIN['MailFormat']=='mime')
			{
				$emailIN['MailData']['NewsletterContent'] = $SERVER->getValue($newsletterRS[0]['NewsletterContent'],$config['lang']);
			}
			if($emailIN['MailFormat']=='txt' or $emailIN['MailFormat']=='mime')
			{
				$emailIN['MailData']['NewsletterContentText'] = $SERVER->getValue($newsletterRS[0]['NewsletterContentText'],$config['lang']);
			}	
			
			$SERVER->callService('sendMail','mailServer',$emailIN);	
			
			//update newsletter status to sent
			$DS->query("UPDATE Newsletter SET NewsletterStatus='sent' WHERE NewsletterID='".$newsletterID."'");
		}//end of if(!empty($newsletterID))
		
		$SERVER->setDebug('NewsletterServerClass.sendTestNewsletter.End','End');	
	}
	
	function sendNewsletterToSubscribers($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterServerClass.sendNewsletterToSubscribers.Start','Start');
		$DS = &$this->_DS;
		$newsletterID =$input['NewsletterID']; 
		if(!empty($newsletterID))
		{
			$sql = "SELECT * FROM Newsletter WHERE NewsletterID='$newsletterID'";
			$newsletterRS = $DS->query($sql);
			
			//get subscribers
			$newsletterGroup = $newsletterRS[0]['NewsletterSubscriberGroup'];
			$sql = "SELECT SubscriberEmail, SubscriberFirstName, SubscriberLastName, SubscriberLanguage FROM NewsletterSubscriber WHERE SubscriberStatus='active' AND SubscriberIsConfirmed='Y' AND SubscriberNewsletters LIKE '%|$newsletterGroup|%'";
			$subscribersRS = $DS->query($sql);
			if(is_array($subscribersRS))
			{
				//tmp jb 18.11.05 to see test email in log
				$emailIN['MailLog'] = 'yes';
				
				$emailIN['MailFrom'] = $newsletterRS[0]['NewsletterFrom'];
				$emailIN['MailFromName'] = $newsletterRS[0]['NewsletterFromName'];
				$newsletterFormat = $newsletterRS[0]['NewsletterType'];
				
				$emailIN['MailTemplate'] ='newsletter';
  				
				foreach ($subscribersRS as $row)
				{
					$emailIN['MailFromName'] = $newsletterRS[0]['NewsletterFromName'];
					$emailIN['MailSubject'] = $SERVER->getValue($newsletterRS[0]['NewsletterTitle'],$row['SubscriberLanguage']);					
					$emailIN['MailTo'] = $row['SubscriberEmail'];
					/*jb 18.11.05 SubscriberFirstName and SubscriberLastName are not multi lang now
					$emailIN['MailToName'] = $SERVER->getValue($row['SubscriberFirstName']).' '.$SERVER->getValue($row['SubscriberLastName']);*/
					$emailIN['MailToName'] = $row['SubscriberFirstName'].' '.$row['SubscriberLastName'];
					$emailIN['MailLanguage'] = $row['SubscriberLanguage'];
					$emailIN['MailFormat'] = $this->_getNewsletterFormat($newsletterFormat,$row['SubscriberType']);
					
					if($emailIN['MailFormat']=='html' or $emailIN['MailFormat']=='mime')
					{
						$emailIN['MailData']['NewsletterContent'] = $SERVER->getValue($newsletterRS[0]['NewsletterContent'],$emailIN['MailLanguage']);
					}
					if($emailIN['MailFormat']=='txt' or $emailIN['MailFormat']=='mime')
					{
						$emailIN['MailData']['NewsletterContentText'] = $SERVER->getValue($newsletterRS[0]['NewsletterContentText'],$emailIN['MailLanguage']);
					}
					
					if($input['actionMode']=='send')
					{//send now
						$SERVER->callService('queueMail','mailServer',$emailIN);
					}
					else
					{//send by queue
						$SERVER->callService('sendMail','mailServer',$emailIN);
					}
				}
				//update newsletter status to sent
				$DS->query("UPDATE Newsletter SET NewsletterStatus='sent' WHERE NewsletterID='".$newsletterID."'");
			}//end of 	if(count($subscribersRS['sql'])>0)		
		}
			
		$SERVER->setDebug('NewsletterServerClass.sendNewsletterToSubscribers.End','End');	
	}
	
	function queueNewsletter($input)
	{
		$SERVER = &$this->_controller;
		$config = $SERVER->getConfig();
		$DS = &$this->_DS;
		$SERVER->setDebug('NewsletterServerClass.queueNewsletter.Start','Start');
		if($SERVER->hasRights('admin'))
		{
			if(!empty($input['NewsletterID']))
			{
				$eventIN['EvenetInput']['actionMode']='send'; //for runnning sendNewsletterToSubscribers()
				$eventIN['EvenetInput']['NewsletterID'] = $input['NewsletterID'];
				$eventIN['EventMethod'] = 'sendNewsletter';
				$eventIN['EventService'] = 'newsletter';
				$eventIN['EventServer'] = 'newsletterServer';		
				$eventIN['EventType'] = 'onetime';
				$dateTime = new DateTimeDataType(&$this->_controller);
				$startTime = $dateTime->setDataType($input['Event'.DTR.'TimeStart'],'Event','TimeStart');
				$eventIN['EventStart'] = $startTime;
				$SERVER->callService('addEvent','eventServer',$eventIN);
				//tmp commented $SERVER->setMessage('NewsletterServer.queueNewsletter.msg.NewsletterIsAddedToQueue');
				
				//update newsletter status to queued
				$DS->query("UPDATE Newsletter SET NewsletterStatus='queued' WHERE NewsletterID='".$newsletterID."'");
			}
			else
			{			
				//tmp commented $SERVER->setMessage('NewslettrServer.queueNewsletter.err.WrongInputParameters');
			}
		}
		else
		{
			//tmp commented$SERVER->setMessage('NewslettrServer.queueNewsletter.err.NoRights');
		}
		$SERVER->setDebug('NewsletterServerClass.queueNewsletter.End','End');		
	}
} // end of NewsletterListClass
?>
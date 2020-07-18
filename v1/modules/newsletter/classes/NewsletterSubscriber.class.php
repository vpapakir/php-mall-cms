<?php
//XCMSPro: Web Service entity class
class NewsletterSubscriberClass
{
    // PRIVATE PROPERTIES
	var $_DS;
	var $_controller;
	var $_config;
	// PRIVATE METHODS
	// CONSTRUCTOR
    /**
    * Constructor
    *
    * Initializes the object
    *
    */	
	function NewsletterSubscriberClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	
	// PUBLIC METHODS
	function getNewsletterSubscribers($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterSubscriberClass.getNewsletterSubscribers.Start','Start');
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
		$entityStatus = $input['SubscriberStatus'];
		$entitySubscribersGroup = $input['NewsletterSubscribersGroup'];
		$searchWord = $input['searchWord'];
		//set filters
		//jb 14.11.05 tmp coment $filter = $DS->getAccessFilter($input,'NewsletterServerClass.adminNewsletter');
		//if($SERVER->hasRights('NewsletterServer.adminCompanies')) {
			if(!empty($searchWord))
			{
				$filter .= " AND (SubscriberFirstName LIKE '{ls}%$searchWord%{le}' OR SubscriberFirstName LIKE '%$searchWord%' OR SubscriberLastName  LIKE '{ls}%$searchWord%{le}' OR SubscriberLastName  LIKE '%$searchWord%' OR SubscriberEmail  LIKE '{ls}%$searchWord%{le}' OR SubscriberEmail  LIKE '%$searchWord%')";
			}
			if(!empty($entityStatus))
			{
				$filter .= " AND SubscriberStatus='$entityStatus' ";
			}
			if(!empty($entitySubscribersGroup))
			{
				$filter .= " AND SubscriberNewsletters LIKE '%|$entitySubscribersGroup|%' ";
			}
			//set queries
			$query = "SELECT * FROM NewsletterSubscriber WHERE 1 $filter ORDER BY NewsletterSubscriber.TimeCreated DESC";
			//jb 14.11.05 tmp coment because method empty $mode['pagesMode']=100;
			//echo $query;
			//get the content
			$result = $DS->query($query,$mode);
			//print_r($result);
			$SERVER->setDebug('NewsletterSubscriberClass.getNewsletterSubscribers.End','End');
			return $result;
		//}
	}
	
	function setNewsletterSubscriber($input)
	{
		//print_r($input);
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterSubscriberClass.setNewsletterSubscriber.Start','Start');	
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
		$NewsletterSubscriberID = $input['NewsletterSubscriber'.DTR.'NewsletterSubscriberID'];
		if(!empty($NewsletterSubscriberID))
		{
			$where['NewsletterSubscriber'] = "NewsletterSubscriberID = '".$NewsletterSubscriberID."'".$filter;
		} else {
			$where['NewsletterSubscriber'] = '';
		  }
		
		$saveRS = $DS->save($input,$where);
		$SERVER->setDebug('NewsletterSubscriberClass.setNewsletterSubscriber.End','End');
		return $saveRS;		
	}
	
	function getNewsletterSubscriber($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterSubscriberClass.getNewsletterSubscriber.Start','Start');	
		$DS = &$this->_DS;
		$user = $SERVER->getUser();
		$userID = $user['UserID'];
		$entityID = $input['NewsletterSubscriber'.DTR.'NewsletterSubscriberID'];
		if(empty($entityID)) {$entityID = $input['NewsletterSubscriberID'];}
		//jb 14.11.05 tmp commented
		//if($SERVER->hasRights('NewsletterServer.adminNewsletters'))
		//{
			$query = "SELECT * FROM NewsletterSubscriber WHERE NewsletterSubscriberID='$entityID'";
			$NewsletterRS = $DS->query($query);
			$result = $NewsletterRS;
		//}
		$SERVER->setDebug('NewsletterSubscriberClass.getNewsletterSubscriber.End','End');
		return $result;		
	}
	
	function importSubscribers($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterSubscriberClass.setSubscriber.Start','Start');	
		$DS = &$this->_DS;
		$user = $SERVER->getUser();
		$config = $SERVER->getConfig();
		$userID = $user['UserID'];
		$filename = $input['FileName'];
		$delimiter = $input['ColumnDelimiter'];

		$updateMode = $input['updateMode'];
		
		if($SERVER->hasRights('admin'))
		{
			$input['actionMode']='save';
			
			if(empty($filename))
			{
				$filename = 'posted';
				$subscribers = explode("\n",$input['Subscribers']);
			}
			else
			{
				$FM = new FilesManager($SERVER);
				//$fileIN['OwnerID'] = $config['OwnerID'];
				$fileIN['File'.DTR.'FilePath'] = 'files';
				$fileIN['File'.DTR.'FileName'] = $filename;
				$subscribers = $FM->getFile($fileIN);
			}			
			$input['NewsletterSubscriber'.DTR.'SubscriberSource']='imported';
			$input['NewsletterSubscriber'.DTR.'SubscriberSourceKey']=date('Y-m-d-H-i-s').'-'.$filename;
			$logFileName = 'ImportSubscribers'.$input['NewsletterSubscriber'.DTR.'SubscriberSourceKey'].'.xml';
			$result = 'error';
			foreach($subscribers as $subscriberRow)
			{
				$subscriberData = explode($delimiter,$subscriberRow);
				$email = $subscriberData[0];
				$email = ereg_replace ("[\r]", "", $email);
				$email = ereg_replace (" ", "", $email);
				@$email = ereg_replace ("&nbsp\;", "", $email);
				$email = ereg_replace ("  ", "", $email);				
				$firstName = $subscriberData[1];
				$lastName = $subscriberData[2];
				//jb 17.11.05 not needed $subscriberGender = $subscriberData[3];
				//print_r($subscriberData);
				if($this->isEmail($email))
				{
					//check if this this email is in subscribers list
					$testQuery = "SELECT NewsletterSubscriberID FROM NewsletterSubscriber WHERE SubscriberEmail='$email'";
					$testRS = $DS->query($testQuery);
					$input['NewsletterSubscriber'.DTR.'SubscriberEmail'] = $email;
					$input['NewsletterSubscriber'.DTR.'SubscriberFirstName'] = $firstName;
					$input['NewsletterSubscriber'.DTR.'SubscriberLastName'] = $lastName;
					//jb 17.11.05 not needed $input['NewsletterSubscriber'.DTR.'SubscriberGender'] = $subscriberGender;
					
					//$input['NewsletterSubscriber'.DTR.'SubscriberLastName'] = $firstName;				
					if(empty($testRS['sql'][0]['NewsletterSubscriberID']))
					{//insert a new subscriber
						$where['NewsletterSubscriber'] = "NewsletterSubscriberID = ''";
						$saveRS = $DS->save($input,$where);
						$SERVER->setLog('Added',$email.' - '.$firstName.' '.$lastName,$logFileName);
					}
					else
					{
						if($updateMode == 'update')
						{//update an existed subscriber
							$where['NewsletterSubscriber'] = "NewsletterSubscriberID = '".$testRS['sql'][0]['NewsletterSubscriberID']."'";
							$input['NewsletterSubscriber'.DTR.'NewsletterSubscriberID'] = $testRS['sql'][0]['NewsletterSubscriberID'];
							$saveRS = $DS->save($input,$where);
							$SERVER->setLog('Updated',$email.' - '.$firstName.' '.$lastName,$logFileName);
						}
						else
						{
							$SERVER->setLog('Exists',$email.' - '.$firstName.' '.$lastName,$logFileName);							
						}
					}
				}
				else
				{
					$SERVER->setLog('WrongEmailFormat',$email.' - '.$firstName.' '.$lastName,$logFileName);					
				}
				$result = 'ok';
			}
		}
		$importRS['ImportResult'] = $result;
		$importRS['ImportSourceKey'] = $input['NewsletterSubscriber'.DTR.'SubscriberSourceKey'];
		$importRS['ImportLogFile'] = $logFileName;
		$SERVER->setDebug('NewsletterSubscriberClass.setSubscriber.End','End');
		return $importRS;		
	}	
	
	function isEmail($value)
	{
		/*
		if(eregi('^(?:[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+\.)*[\w\!\#\$\%\&\'\*\+\-\/\=\?\^\`\{\|\}\~]+@(?:(?:(?:[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!\.)){0,61}[a-zA-Z0-9]?\.)+[a-zA-Z0-9](?:[a-zA-Z0-9\-](?!$)){0,61}[a-zA-Z0-9]?)|(?:\[(?:(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\.){3}(?:[01]?\d{1,2}|2[0-4]\d|25[0-5])\]))$',$value))
		{
			return true;
		}
		else
		{
			return false;
		}
		*/
		return true;
	}
	
	function importSetSubscribers($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterSubscriberClass.importSetSubscribers.Start','Start');	
		$DS = &$this->_DS;
		$user = $SERVER->getUser();
		$config = $SERVER->getConfig();
		//$filename = $input['FileName'];
		//print_r($config);
		//print_r($input);
		if($SERVER->hasRights('admin'))
		{
			//SiteAdminRootURL
			$LogPath = $config['LogPath'];
			$logFileName = 'ImportSubscribers'.$input['ImportSourceKey'].'.xml';
			$logFilePath = $LogPath.$logFileName;
			if(is_file($logFilePath))
			{
				$content = file($logFilePath);
				//print_r($content);
				foreach($content as $key=>$value)
				{
					if(strstr($content[$key],'<Message>'))
					{
						//echo $content[$key];
						$content[$key] = str_replace("<Message>","",$content[$key]);
						$content[$key] = str_replace("</Message>","",$content[$key]);
						//echo $content[$key];
						$subscribers = explode(" - ",$content[$key]);
						
						$email = $subscribers[0];
						
						$email=str_replace("	", "", $email);
						
						$subscribersData = explode(" ",$subscribers[1]);
						$FirstName = $subscribersData[0];
						$LastName = $subscribersData[1];
						
						if($input['actionMode']=='blockImported')
						{
							$DS->query("UPDATE NewsletterSubscriber SET SubscriberStatus='blocked' WHERE SubscriberEmail='$email'");
						}
						elseif($input['actionMode']=='deleteImported')
						{
							$testQuery = "DELETE FROM NewsletterSubscriber WHERE SubscriberEmail='$email'";
							$testRS = $DS->query($testQuery);
						}
					}
				}
			}
		}
		$SERVER->setDebug('NewsletterSubscriberClass.importSetSubscribers.End','End');
		
	}
	
	function exportSubscribers($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterSubscriberClass.exportSubscribers.Start','Start');	
		$DS = &$this->_DS;
		$user = $SERVER->getUser();
		$config = $SERVER->getConfig();
		$LB = '\n';
		$newsletterSubscribers = $this->getNewsletterSubscribers($input);
		if(is_array($newsletterSubscribers)) {
			if($input['exportType']=='csv') {
				foreach($newsletterSubscribers as $subscriber) {
					$resultCSV .= $subscriber['SubscriberEmail'].';'.$subscriber['SubscriberFirstName'].';'.$subscriber['SubscriberLastName'].'
'; 
				}
				$result = $resultCSV;
			} elseif($input['exportType']=='email') {
				foreach($newsletterSubscribers as $subscriber) {
					$resultEmail .= $subscriber['SubscriberFirstName'].' '.$subscriber['SubscriberLastName'].'<'.$subscriber['SubscriberEmail'].'>
';
				}
				$result = $resultEmail;
			  }
		}
		
		$SERVER->setDebug('NewsletterSubscriberClass.exportSubscribers.End','End');

		return $result;
	}
} // end of NewsletterListClass
?>
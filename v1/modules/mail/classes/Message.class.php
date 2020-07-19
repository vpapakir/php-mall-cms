<?php
//XCMSPro: Web Service entity class
class MessageClass
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
	function MessageClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	// PUBLIC METHODS
    /**
    * gets entites
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */
	function getMessages($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageClass.getMessages.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Message'.DTR.'MessageID'];
		if(empty($entityID)) {$entityID = $input['MessageID'];}
		$searchWord = $input['searchWordMessage'];
		$folder = $input['folder'];
		if (empty($folder)) {$folder = 'inbox';}
		
		$filterMode = $input['filterMode'];
		$messagesFilterMode = $input['messagesFilterMode'];
		$groupID = $user['GroupID'];
		$mailBoxID = $input['MailBoxID'];
		$orderID = $input['OrderID'];
		$ReceiverID = $input['ReceiverID'];
		
		$messageStatus = $input['MessageStatus'];
		
		$orderID =  $input['OrderID'];
		if(empty($orderID)) {$orderID =  $input['PropertyOrderID'];}
		
		//set filters
		//$filter = $DS->getAccessFilter($input,'MessageClass.adminMessage');
		if($SERVER->hasRights('root'))
		{
			$filterGroups = " MessageReceiverGroup='root' OR  MessageReceiverGroup='admin' OR  MessageReceiverGroup='content' ";
		}
		elseif($SERVER->hasRights('admin'))
		{
			$filterGroups = " MessageReceiverGroup='admin' OR  MessageReceiverGroup='content' ";
		}			
		else
		{
			$filterGroups = " MessageReceiverGroup='".$user['GroupID']."' ";
		}
		
		if($filterMode=='new')
		{
			$filter .= " AND (MessageReceiverID='$userID' OR $filterGroups) AND MessageStatus='new' ";
		}
		elseif($filterMode=='draft')
		{
			$filter .= " AND UserID='$userID' AND MessageStatus='draft' ";
		}
		else
		{
			if($messagesFilterMode=='clientmessages')
			{
				if(!empty($ReceiverID))
				{
					$filter .= " AND (UserID='$ReceiverID') ";
				}
			}
			elseif(!empty($ReceiverID))
			{
				if($clientType=='admin')
				{
					$filter .= " AND ( (UserID='$ReceiverID' AND ($filterGroups)) OR (MessageReceiverID='$ReceiverID' AND ($filterGroups)) ) AND MessageStatus!='draft' AND MessageStatus!='archived' ";
				}
				else
				{
					$filter .= " AND ( (UserID='$userID' AND MessageReceiverID='$ReceiverID') OR (UserID='$ReceiverID' AND MessageReceiverID='$UserID') ) AND MessageStatus!='draft' AND MessageStatus!='archived' ";
				}
			}
			else
			{
				$filter .= " AND (UserID='$userID' AND MessageStatus!='draft' AND MessageStatus!='archived' OR ((MessageReceiverID='$userID' OR $filterGroups) AND MessageStatus!='new')) ";
			}
		}		
		
		if(!empty($orderID)  && $messagesFilterMode!='clientmessages')
		{
			$filter .= " AND OrderID='$orderID'";
		}

		if(!empty($messageStatus))
		{
			$filter .= " AND MessageStatus='$messageStatus' ";
			if(empty($ReceiverID) && $messagesFilterMode=='clientmessages')
			{
				$filter .= " AND MessageSenderGroup='user' ";
			}
			
		}
		
		if(!empty($mailBoxID))
		{
			$filter .= " AND (UserID='$mailBoxID' OR MessageReceiverID='$mailBoxID') ";
		}
		if($input['actionMode']=='sent')
		{
			//$filter = " AND  UserID='$userID'  ";
		}
		else
		{
			//$filter = " AND  (MessageReceiverID='$userID' OR MessageReceiverGroup='$groupID') AND MessageFolderAlias='$folder' ";			
		}
		if(!empty($searchWord))
		{
			$filter .= " AND (MessageSubject LIKE '%$searchWord%' OR MessageText LIKE '%$searchWord%' OR MessageSenderNickName LIKE '%$searchWord%' OR MessageReceiverNickName LIKE '%$searchWord%' )";
		}		


		$orderBy = 'TimeCreated DESC';
		if(input('OrderNewMessages')=='Subject')
			$orderBy = 'MessageSubject';

		//set queries
		$query = "SELECT * FROM Message WHERE MessageFolderAlias='$folder' $filter ORDER BY $orderBy "; 
		//get the content
//echo $query;
		//$mode['pagesMode']=100;
		$result = $DS->query($query,$mode); 
		$SERVER->setDebug('MessageClass.getMessages.End','End');
		return $result;
	}	









	function getClientMessages($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageClass.getLastAdminMessages.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Message'.DTR.'MessageID'];
		if(empty($entityID)) {$entityID = $input['MessageID'];}
		$searchWord = $input['searchWord'];
		$folder = $input['folder'];
		if (empty($folder)) {$folder = 'inbox';}
		
		$ReceiverID = $input['ReceiverID'];
		
//		$filterMode = $input['filterMode'];
//		$groupID = $user['GroupID'];
//		$mailBoxID = $input['MailBoxID'];
//		$orderID = $input['OrderID'];
		$orderLastSent = input('OrderLastSent');
		if(input('ReceiverID')){
			//$filter .= " AND ( UserID='$ReceiverID' OR MessageReceiverID='$ReceiverID') AND MessageStatus!='draft' AND MessageStatus!='archived' ";
			$filter .= " AND ( Message.UserID='$ReceiverID' OR MessageReceiverID='$ReceiverID')  ";

		}
		$filter .= " AND MessageStatus='new' AND (MessageSenderGroup ='user' OR MessageSenderGroup ='')";
		
		//set filters
		//$filter = $DS->getAccessFilter($input,'MessageClass.adminMessage');
//		if($SERVER->hasRights('root')){
//			$filterGroups = " MessageReceiverGroup='root' OR  MessageReceiverGroup='admin' OR  MessageReceiverGroup='content' ";
//		}elseif($SERVER->hasRights('admin')){
//			$filterGroups = " MessageReceiverGroup='admin' OR  MessageReceiverGroup='content' ";
//		}			
		
//		$filter .= " AND (UserID='$userID') ";

//		$order = 'TimeCreated desc';
//		if($orderLastSent=='Subject')
//			$order = 'MessageSubject';
//		elseif($orderLastSent=='Client')
//			$order = 'UserID';
//		elseif($orderLastSent=='LastWeek')
//			$filter .= " AND (to_days(now())-to_days(TimeCreated)<7) ";
//		elseif($orderLastSent=='LastMonth')
//			$filter .= " AND (to_days(now())-to_days(TimeCreated)<30) ";
	

		
		//$query = "SELECT * FROM Message WHERE MessageFolderAlias='$folder' $filter ORDER BY TimeCreated DESC "; 
		//$query = "SELECT * FROM User, UserFields, Message WHERE User.UserID = Message.UserID AND User.UserID = UserFields.UserID AND MessageFolderAlias='$folder' $filter ORDER BY Message.TimeCreated DESC "; 
		$query = "SELECT * FROM User, Message WHERE User.UserID = Message.UserID AND MessageFolderAlias='$folder' $filter ORDER BY Message.TimeCreated DESC "; 
//echo $query;
		$result = $DS->query($query,$mode); 
		$SERVER->setDebug('MessageClass.getLastAdminMessages.End','End');
		return $result;
	}	

	function getLastAdminMessages($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageClass.getLastAdminMessages.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Message'.DTR.'MessageID'];
		if(empty($entityID)) {$entityID = $input['MessageID'];}
		$searchWord = $input['searchWord'];
		$folder = $input['folder'];
		if (empty($folder)) {$folder = 'inbox';}
		
//		$filterMode = $input['filterMode'];
//		$groupID = $user['GroupID'];
//		$mailBoxID = $input['MailBoxID'];
//		$orderID = $input['OrderID'];
		$orderLastSent = input('OrderLastSent');
		if(input('ReceiverID')){
			$filter .= " AND  MessageReceiverID='".input('ReceiverID')."' ";
		}
		
		//set filters
		//$filter = $DS->getAccessFilter($input,'MessageClass.adminMessage');
//		if($SERVER->hasRights('root')){
//			$filterGroups = " MessageReceiverGroup='root' OR  MessageReceiverGroup='admin' OR  MessageReceiverGroup='content' ";
//		}elseif($SERVER->hasRights('admin')){
//			$filterGroups = " MessageReceiverGroup='admin' OR  MessageReceiverGroup='content' ";
//		}			
		
		$filter .= " AND (UserID='$userID') ";

		$order = 'TimeCreated desc';
		if($orderLastSent=='Subject')
			$order = 'MessageSubject';
		elseif($orderLastSent=='Client')
			$order = 'UserID';
		elseif($orderLastSent=='LastWeek')
			$filter .= " AND (to_days(now())-to_days(TimeCreated)<7) ";
		elseif($orderLastSent=='LastMonth')
			$filter .= " AND (to_days(now())-to_days(TimeCreated)<30) ";
	

		
		$query = "SELECT * FROM Message WHERE MessageFolderAlias='$folder' $filter ORDER BY $order limit 20"; 
//echo $query;
		$result = $DS->query($query,$mode); 
		$SERVER->setDebug('MessageClass.getLastAdminMessages.End','End');
		return $result;
	}	






    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getMessage($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageClass.getMessage.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Message'.DTR.'MessageID'];
		if(empty($entityID)) {$entityID = $input['MessageID'];}
		$entityAlias = $input['Message'.DTR.'MessageAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['MessageAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['message'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'MessageClass.adminMessage');
		//set queries
		
		$input['Message'.DTR.'MessageSenderGroup'] = $user['GroupID'];
		$query =='';
		if(!empty($entityID))
		{
			$query = "SELECT * FROM Message WHERE MessageID='$entityID' $filter"; 
		}
		elseif(!empty($entityAlias))
		{
			$query = "SELECT * FROM Message WHERE MessageAlias='$entityAlias' $filter"; 
		}
		//get the content
		//echo $query;
		if(!empty($query))
		{
			$result = $DS->query($query); 		
		}
		else
		{
			//$SERVER->setMessage('MessageClass.getMessage.err.NoMessageID');
		}
		$SERVER->setDebug('MessageClass.getMessage.End','End');		
		return $result;		
	}
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setMessage($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageClass.setMessage.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		//echo "#".$userID."#";
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Message'.DTR.'MessageID'];
		//if(empty($entityID)) {$entityID = $input['MessageID'];}
		$messageToReplyID = $input['MessageID'];
		$folder = $input['folder'];
		if (empty($folder)) {$folder = 'inbox';}	
		//set filters
		//$filter = $DS->getAccessFilter($input,'MessageClass.adminMessage');
		//set queries
		if(is_array($input['Message'.DTR.'MessageID']))
		{
			while (list($fieldNimber,$fieldValue)= each($input['Message'.DTR.'MessageID'])) 
			{
				$where['Message'][] = "MessageID = '".$fieldValue."'".$filter;
			}
		}
		else
		{
			$where['Message'] = "MessageID = '".$entityID."'".$filter;
		}
		
		if(empty($input['Message'.DTR.'MessageStatus'])) {$input['Message'.DTR.'MessageStatus']='new';}
		if(empty($input['Message'.DTR.'MessageFolderAlias'])) {$input['Message'.DTR.'MessageFolderAlias']='inbox';}
		if(empty($input['Message'.DTR.'MessageSenderNickName'])) {$input['Message'.DTR.'MessageSenderNickName']=$user['FirstName'].' '.$user['LastName'];}
		
		if(!$SERVER->hasRights('adminMessages')) {
			//a user can not send messages to all groups of users
			if($input['Message'.DTR.'MessageReceiverGroup']!='root' && $input['Message'.DTR.'MessageReceiverGroup']!='admin' && $input['Message'.DTR.'MessageReceiverGroup']!='content')
			{
				$input['Message'.DTR.'MessageReceiverGroup']=''; 
			}
		}
		
		$input['Message'.DTR.'MessageSenderGroup'] = $user['GroupID'];
		


		if(!empty($input['Message'.DTR.'MessageReceiverNickName']) && empty($input['Message'.DTR.'MessageReceiverID']))
		{
			//get reseiver info
			
		}
		if(!empty($input['Message'.DTR.'MessageReceiverID']) || !empty($input['Message'.DTR.'MessageReceiverGroup']))
		{
			if(eregi('@',$input['Message'.DTR.'MessageReceiverNickName']))
			{
				//send email in case if the receiver's nickname is an email address;
				$emailIN['MailTo'] = $input['Message'.DTR.'MessageReceiverNickName'];
				//$emailIN['MailToName'] = $userName;
				$emailIN['MailFrom'] =$user['UserName'];
				$emailIN['MailFromName'] =$user['Email'];
				$emailIN['MailData'] ='<Content><Message><![CDATA['.$input['Message'.DTR.'MessageText'].']]></Message><SenderName><![CDATA['.$user['UserName'].']]></SenderName></Content>';
				$emailIN['MailTemplate'] = 'messageSendEmail';
				$SERVER->callService('sendMail','mailServer',$emailIN);	
			}
			else
			{
				//first of all try to find the receiver in registered users table
				//$userIN['UserID'] = $input['Message'.DTR.'MessageReceiverID'];
				//$usersRS = $SERVER->callService('getUserData','sessionServer',$userIN);
				
				//$receiverUserID = $usersRS['DB']['User'][0]['UserID'];

				if($input['ReceiverID'])
					$receiverUserID = $input['ReceiverID'];

				$isActive='Y';
				if($isActive=='Y')	
				{
					//print_r($input);
					if($input['actionMode']=='attach')
					{
						$input['actionMode']='save';
						$result = $DS->save($input,$where,'insert');	
						$result['MessageAddedID'] = $result[0]['MessageID'];
						//$result['MessageAddedID'] = $DS->dbLastID();

						$input['MessageAttachment'.DTR.'MessageID'] = $result['MessageAddedID'];
						$where='';
						$where['MessageAttachment'] = "MessageAttachmentID = '".$input['MessageAttachment'.DTR.'MessageAttachmentID']."'";

						//print_r($input);
						$resAttach = $DS->save($input,$where,'insert');	
						//print_r($resAttach);
						
						$input['actionMode']='attach';
						$SERVER->setMessage('MessageClass.setMessage.msg.DataSaved');
					}
					if($input['actionMode']=='attach2')
					{
						$input['actionMode']='save';
						//$result = $DS->save($input,$where,'insert');	
						$result['MessageAddedID']=$input['MessageAddedID'];

						$where='';
						$where['MessageAttachment']='MessageID="'.$result['MessageAddedID'].'"';

						$DS->save($input,$where,'insert');	
						$input['actionMode']='attach2';
						$SERVER->setMessage('MessageClass.setMessage.msg.DataSaved');
					}
					if($input['actionMode']=='updateNew')
					{
						$where='';
						$where['Message'] = "MessageID = '".$entityID."'".$filter;
						$input['actionMode']='save';
						$result = $DS->save($input,$where,'update');
						$SERVER->setMessage('MessageClass.setMessage.msg.DataSaved');
					}

					if($input['actionMode']=='send')
					{
						
						$input['actionMode']='save';
//print_r($input);
						if(!empty($input['Message'.DTR.'UserID']) || !empty($user['UserID']))
						{
							//echo 'sentddddddddddd';
							$result = $DS->save($input,$where,'insert');	
							$SERVER->setMessage('MessageClass.setMessage.msg.DataSaved');
						}
					}
					
					if($input['notSendEmail']=="Y"){
						$messageToReplyID = $result[0]['MessageID'];
					}
					
					if(!empty($messageToReplyID))
					{
						$DS->query("UPDATE Message SET MessageStatus='replied' WHERE MessageID='$messageToReplyID'");
					}

					if($input['notSendEmail']!="Y" && !empty($receiverUserID)){
						$this->sendEmailRemind($input,$result,$receiverUserID);
					}
				}
				else
				{
					$SERVER->setMessage('MessageClass.setMessage.err.NoReceiverFound');
				}
			}
		}
		else
		{
			$SERVER->setMessage('MessageClass.setMessage.err.NoSenderName');
		}
		$SERVER->setDebug('MessageClass.setMessage.End','End');		
		return $result;		
	}
	
	function setMessages($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageClass.setMessage.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Message'.DTR.'MessageID'];
		//if(empty($entityID)) {$entityID = $input['MessageID'];}
		$messageToReplyID = $input['MessageID'];
		$folder = $input['folder'];
		if (empty($folder)) {$folder = 'inbox';}	
		//set filters
		//$filter = $DS->getAccessFilter($input,'MessageClass.adminMessage');
		//set queries

		if(empty($input['Message'.DTR.'MessageStatus'])) {$input['Message'.DTR.'MessageStatus']='new';}
		if(empty($input['Message'.DTR.'MessageFolderAlias'])) {$input['Message'.DTR.'MessageFolderAlias']='inbox';}
		if(empty($input['Message'.DTR.'MessageSenderNickName'])) {$input['Message'.DTR.'MessageSenderNickName']=$user['FirstName'].' '.$user['LastName'];}
		
		$input['Message'.DTR.'MessageSenderGroup'] = $user['GroupID'];
		
		if(!$SERVER->hasRights('adminMessages')) {
			//a user can not send messages to all groups of users
			if($input['Message'.DTR.'MessageReceiverGroup']!='root' && $input['Message'.DTR.'MessageReceiverGroup']!='admin' && $input['Message'.DTR.'MessageReceiverGroup']!='content')
			{
				$input['Message'.DTR.'MessageReceiverGroup']=''; 
			}
		}
		
		//print_r($input);
		
		if(is_array($input['Message'.DTR.'MessageReceiverID']))
		{
			foreach($input['Message'.DTR.'MessageReceiverID'] as $value){
				$where['Message'] = "MessageID = '".$entityID."'".$filter;
				$inputSave['actionMode']='save';
				$inputSave['Message'.DTR.'MessageReceiverID'] = $value;
				$inputSave['Message'.DTR.'MessageReceiverNickName'] = $input['Message'.DTR.'MessageReceiverNickName'][$value];
				$inputSave['Message'.DTR.'MessageStatus']='new';
				$inputSave['Message'.DTR.'MessageSubject'] = $input['Message'.DTR.'MessageSubject'];
				$inputSave['Message'.DTR.'MessageText'] = $input['Message'.DTR.'MessageText'];
				$inputSave['Message'.DTR.'MessageFolderAlias']='inbox';
				if((!empty($user['UserID']) && $user['UserID']!=1) || !empty($inputSave['Message'.DTR.'UserID']))
				{
					$result = $DS->save($inputSave,$where);
				}
				$receiverUserID = $value;
				if(!empty($result[0]['MessageID'])){
					$SERVER->setMessage('MessageClass.setMessage.msg.DataSaved');
				}	
				
				if($input['notSendEmail']=="Y"){
					$messageToReplyID = $result[0]['MessageID'];
				}
						
				if(!empty($messageToReplyID)){
					$DS->query("UPDATE Message SET MessageStatus='replied' WHERE MessageID='$messageToReplyID'");
				}
						
				if($input['notSendEmail']!="Y" && !empty($receiverUserID)){
					//echo "111111111111111";
					$this->sendEmailRemind($input,$result,$receiverUserID);
				}
			}

		}else{
				$SERVER->setMessage('MessageClass.setMessage.err.NoReceiverFound');
		}

		$SERVER->setDebug('MessageClass.setMessage.End','End');		
		return $result;		
	}
	
	function sendEmailRemind($input='',$result='',$userID)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;	
		if(!$userID)
			$userID = $user['UserID'];
		//get user's email
//		if(input('ReceiverID'))
//			$userID = input('ReceiverID');
		//print_r($input);print_r($result);
		$userIN = $input;
		$userIN['UserID'] = $userID;
		//$userIN['SID'] = $input['SID'];
//echo "|||||||$userID|||||";
//die(zxcv7);
		$usersRS = $SERVER->callService('getUserData','sessionServer',$userIN);
		$userEmail = $usersRS['DB']['User'][0]['Email'];		
		$userName = $usersRS['DB']['User'][0]['UserName'];	
		
		$emailIN['SID'] = $input['SID'];	
		$emailIN['MailTo'] = $userEmail;
		$emailIN['MailToName'] = $userName;
		$emailIN['MailFrom'] =$config['SiteMail'];
		$emailIN['MailFromName'] =$config['SiteName'];
		$emailIN['MailSubject'] = $input['Message'.DTR.'MessageSubject'];
		//$emailIN['MailContent'] = $input['Message'.DTR.'MessageText'];
		//$emailIN['MailData']['FirstName'] = $usersRS['DB']['User'][0]['FirstName'];
		//$emailIN['MailData']['LastName'] = $usersRS['DB']['User'][0]['LastName'];
		$emailIN['MailData']['SenderName'] = $user['UserName'];
		$emailIN['MailData']['ReceiverName'] = $userName;
		$emailIN['MailData']['UserID'] = $userID;
		$emailIN['MailData']['MessageID'] = $result[0]['MessageID'];
		$emailIN['MailData']['ReceiverID'] = $result[0]['UserID'];
		if($config['ClientType']=='admin')
			$emailIN['MailTemplate'] = 'messageRemindNew';
		else
			$emailIN['MailTemplate'] = 'messageRemindNew.admin';
//print_r($emailIN);
		$SERVER->callService('sendMail','mailServer',$emailIN);					
	}
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteMessage($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageClass.deleteMessage.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Message'.DTR.'MessageID'];
		if(empty($entityID)) {$entityID = $input['MessageID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'MessageClass.adminMessage');
		//set queries
		$input['actionMode']='delete';
		$where['Message'] = "MessageID = '".$entityID."'$filter";
		$result = $DS->save($input,$where);	
		$SERVER->setMessage('MessageClass.deleteMessage.msg.DataDeleted');
		$SERVER->setDebug('MessageClass.deleteMessage.End','End');		
		return $result;		
	}	

    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function messageIsRead($entityID)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageClass.deleteMessage.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set queries
		$query = "UPDATE Message SET MessageStatus='read' WHERE MessageID='$entityID' AND UserID!='$userID'";
		$DS->query($query);
		return $result;		
	}		
    	
	function getMessageAttachment($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageClass.getMessage.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables

		$entityID = $input['MessageAddedID'];
		if(empty($entityID)) {$entityID = $input['MessageID'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'MessageClass.adminMessage');
		//set queries
		$query =='';
		if(!empty($entityID))
		{
			$query = "SELECT * FROM MessageAttachment WHERE MessageID='$entityID' $filter"; 
		}
		//get the content
		//echo $query;
		if(!empty($query))
		{
			$result = $DS->query($query); 		
		}
		else
		{
			$SERVER->setMessage('MessageClass.getMessage.err.NoMessageID');
		}
		$SERVER->setDebug('MessageClass.getMessage.End','End');		
		return $result;		
	}

	function getMessagesAttachments($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageClass.getMessages.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		
		
		//set filters
		//$filter = $DS->getAccessFilter($input,'MessageClass.adminMessage');
		//set queries
		//print_r($input);
		$query = "SELECT * FROM MessageAttachment"; 
		//get the content
		//echo $query;
		//$mode['pagesMode']=100;
		$result = $DS->query($query,$mode); 
		$SERVER->setDebug('MessageClass.getMessages.End','End');
		return $result;
	}	

	function getClients($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageClass.getClients.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$UserID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		$filter = " User.UserName!='superadmin' AND User.UserName!='Anonymous' AND User.UserID!='$UserID' ";

		$itemsPerPage = $input['ItemsPerPage'];

		if(empty($itemsPerPage)) 
			$itemsPerPage = $config['ItemsPerPage'];

		if($input['SearchClients'])
			$filter .= " AND (UserName LIKE '%".$input['SearchClients']."%' OR Email LIKE '%".$input['SearchClients']."%') ";

		if($input['OrderClients']=='Blocked')
			$filter .= " AND PermAll=4 ";
		else
			$filter .= " AND PermAll=1 ";

		if(!empty($input['UserStatus']))
		{
			$filter .= " AND Status='".$input['UserStatus']."' ";
		}

		if(!empty($input['GroupID']))
		{
			if($input['GroupID']=='admin')
			{
				$filter .= " AND (GroupID='root' OR GroupID='admin' OR GroupID='content') ";
			}
			else
			{
				$filter .= " and GroupID='".$input['GroupID']."' ";
			}
		}

		if($input['OrderClients']=='Name')
			$order = ' UserName ';
		else
			$order = ' TimeCreated desc ';

		if(!empty($input['UserLanguage']))
		{
			$filter .= " AND UserLanguage='".$input['UserLanguage']."' ";
		}
		
		if(!empty($input['Managers']))
		{
			$filter .= " AND OwnerParentID='".$input['Managers']."' ";
		}
		
		if(empty($limit) && $input['ClientMode']!='all')
		{
			$itemsPerPage=100;
				$pages = $DS->getPages('User',"$filter",array('ItemsPerPage'=>$itemsPerPage));

			$limit = ' LIMIT '.$pages['begin'].','.$pages['step'];
		}

		$order = " UserFields.LastName ASC";
		$query = "SELECT * FROM User,UserFields where User.UserID = UserFields.UserId AND $filter order by $order $limit";
		$result['result'] = $DS->query($query,$mode); 
		$result['pages'] = $pages['pages'];

		$SERVER->setDebug('MessageClass.getClients.End','End');
		return $result;
	}	

	
} // end of MessageClass
?>
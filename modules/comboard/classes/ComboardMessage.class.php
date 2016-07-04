<?

class ComboardMessageClass{

	var $_DS;
	var $_controller;
	var $_config;

	function ComboardMessageClass(){
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}

	function getComboardMessages($input){

		$SERVER = &$this->_controller;
		$SERVER->setDebug('ComboardMessageClass.getComboardMessages.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ComboardMessage'.DTR.'ComboardMessageID'];
		if(empty($entityID)) {$entityID = $input['ComboardMessageID'];}
		$searchWord = $input['searchWord'];
		$folder = $input['folder'];
		if (empty($folder)) {$folder = 'inbox';}
		
		$filterMode = $input['filterMode'];
		$groupID = $user['GroupID'];
		$mailBoxID = $input['MailBoxID'];
		
		$messageType = $input['ComboardMessageType'];

		if(!empty($input['SelectedAdministrators']))
		{
			if(is_array($input['SelectedAdministrators']))
			{
				$ia = 0;
				$userFilter = " AND (";
				foreach($input['SelectedAdministrators'] as $adminID)
				{
					if($ia==0)
					{
						$userFilter .= " ComboardMessageUsers like '%|$adminID|%' OR UserID like '$adminID' ";
					}
					else
					{
						$userFilter .= "  OR ComboardMessageUsers like '%|$adminID|%' OR UserID like '$adminID' ";
					}
					$ia++;
				}
				$userFilter .=") ";
			}
		}
		else
		{
			$filterGroups = " ComboardMessageGroups  LIKE '%|".$user['GroupID']."|%' ";
			$userFilter = " AND (ComboardMessageUsers LIKE '%|$userID|%' OR UserID='$userID') ";
		}
		
		if($messageType=='message')
		{
			$newMessagesFilter = " AND ComboardMessageReadBy NOT LIKE '%|$userID|%' ";
			$typeFilter = " AND ComboardMessageType = 'message' ";
		}
		elseif($messageType=='task')
		{
			$newMessagesFilter = " AND ComboardMessageReadBy NOT LIKE '%|$userID|%' AND  ComboardMessageStartTime>=to_days(now())";
			$typeFilter = " AND ComboardMessageType = 'task' ";
		}
		elseif($messageType=='event')
		{
			$newMessagesFilter = " AND ComboardMessageReadBy NOT LIKE '%|$userID|%' AND  ComboardMessageEndTime>=to_days(now()) ";
			$typeFilter = " AND ComboardMessageType = 'event' ";
		}
		elseif($messageType=='calendar')
		{
			$newMessagesFilter = " AND ComboardMessageReadBy NOT LIKE '%|$userID|%' AND  ComboardMessageStartTime>=to_days(now()) ";
			$typeFilter = " AND ComboardMessageType = 'calendar' ";
		}
		elseif($messageType=='memo')
		{
			$newMessagesFilter = " ";
			$typeFilter = " AND ComboardMessageType = 'memo' ";
		}
		
		
		//$notDeltedMessagesFilter = " AND ComboardMessageStatus not like '%|deleted|%' ";
		
		//if($input['ComboardMessageType'] && ($filterMode=='event' || $filterMode=='calendar' || $filterMode=='task')){
		/*
		if($input['ComboardMessageType']){
			if(!empty($input['viewMode']))
				$filter .= $userFilter."  AND ComboardMessageType LIKE '".$input['ComboardMessageType']."'";
			else
				$filter .= $userFilter.$notDeltedMessagesFilter."  AND ComboardMessageType like '".$input['ComboardMessageType']."'";
		}
		*/
		
		//if($filterMode=='message')
			//$filter .= $userFilter.$notDeltedMessagesFilter."  AND ComboardMessageType like 'message' AND ComboardMessageParentID=0";

		if($filterMode=='answer')
			$filter .= $userFilter.$notDeltedMessagesFilter."  AND ComboardMessageType like 'message' AND ComboardMessageParentID!=0";
		if($filterMode=='memo')
			$filter .= $notDeltedMessagesFilter." AND UserID like '$userID' AND ComboardMessageType like 'memo'";
		//if($filterMode=='new')
			//$filter .= $userFilter.$notDeltedMessagesFilter.$newMessagesFilter.$typeFilter."  AND ComboardMessageType not like 'memo'";
		elseif($filterMode=='read')
			$filter .= $userFilter.$notDeltedMessagesFilter."  AND ComboardMessageReadBy like '%|$userID|%'  AND ComboardMessageType not like 'memo'";
		elseif($filterMode=='thread')
			$filter .= " AND ComboardMessageParentID = '".input('MessageID')."' ".$notDeltedMessagesFilter;	
	//		$filter .= " AND (ComboardMessageID = '".input('MessageID')."' OR ComboardMessageParentID = '".input('MessageID')."') AND ComboardMessageStatus not like '%|deleted|%' ";
		elseif($filterMode=='deleted')
			$filter .= $userFilter."  AND ComboardMessageStatus like '%|deleted|%' ";
		
		if(!empty($searchWord))
			$filter .= " AND (ComboardMessageTitle LIKE '%$searchWord%' OR ComboardMessageContent LIKE '%$searchWord%')";

		//echo $input['viewMode'];	
		switch($input['viewMode']){
			case 'day':
				$filter .= " AND to_days(ComboardMessageStartTime)=to_days(now()) ";
			break;
			case 'week':
				$filter .= " AND to_days(ComboardMessageStartTime)>=to_days(now()-3) AND to_days(ComboardMessageStartTime)<=(to_days(now())+3) ";
			break;
			case 'month':
				$filter .= " AND to_days(ComboardMessageStartTime)>=to_days(now()-15) AND to_days(ComboardMessageStartTime)<=(to_days(now())+15) ";
			break;
			case 'period':
				//echo input('ComboardMessageStartTime');
				$d1=explode('-',input('ComboardMessageStartTime'));
				//print_r($d1);
				$yeardl = explode(' ',$d1[2]);
				$d1[2] = $yeardl[0];
				$d1="$d1[2]-$d1[1]-$d1[0]";
				$d2=explode('-',input('ComboardMessageEndTime'));
				$yeardl2 = explode(' ',$d2[2]);
				$d2[2] = $yeardl2[0];
				$d2="$d2[2]-$d2[1]-$d2[0]";
				//echo $d1;
				//echo $d2;

				$filter .= $typeFilter.$userFilter." AND to_days(ComboardMessageStartTime)>=to_days('$d1') AND to_days(ComboardMessageStartTime)<=(to_days('$d2')) ";
			break;
		}
		

		if(empty($input['viewMode']) || $filterMode=='new')
		{
			$filter .= $userFilter.$notDeltedMessagesFilter.$newMessagesFilter.$typeFilter;
		}

		if($filterMode=='thread')
			$query = "SELECT * FROM ComboardMessage WHERE 1 $filter ORDER BY ComboardMessageParentID asc,TimeCreated DESC"; 
		else
			$query = "SELECT * FROM ComboardMessage WHERE 1 $filter ORDER BY TimeCreated DESC"; 
//echo "<hr>$query<hr>";
		$result = $DS->query($query); 
		if(is_array($result))
		foreach($result as $v1=>$r1){
			$query = "select UserName from User where '".$r1['ComboardMessageUsers']."' like concat('%|',UserID,'|%') or '".$r1['ComboardMessageGroups']."' like concat('%|',GroupID,'|%') ";
			$result2 = $DS->query($query);
			$result[$v1]['UserNames']='- ';
			if(is_array($result2))
				foreach($result2 as $r2)
					$result[$v1]['UserNames'].=$r2['UserName'].' - ';


			$icon = setting('layout').'/images/icons/cb_'.$r1['ComboardMessageType'];
			if($r1['ComboardMessageType']=='task'){
				if(strstr($r1['ComboardMessageStatus'],'|completed|'))
					$icon .= '_completed';
				elseif($r1['ComboardMessageStartTime']<date('Y-m-d H:i:s'))
					$icon .= '_delayed';
			}
			if($r1['ComboardMessageType']=='calendar' && strstr($r1['ComboardMessageStatus'],'|completed|')){
				$icon .= '_completed';
			}
			$icon .= '.gif';
			$result[$v1]['icon'] = $icon;


			/*$pattern="/^(19|20)(\d{2})-(\d{2})-(\d{2})/";
			$replace="\\4-\\3-\\1\\2";
			$result[$v1]['ComboardMessageStartTime'] = preg_replace($pattern,$replace,$r1['ComboardMessageStartTime']);
			$result[$v1]['ComboardMessageEndTime'] = preg_replace($pattern,$replace,$r1['ComboardMessageEndTime']);
			*/
		}
/*
		if($filterMode=='new'){
echo "<hr>";
print_r($result);
echo "<hr>";
			foreach($result as $r){
				$where=" ComboardMessageID=$r[ComboardMessageID] ";
				$input_update = array('ComboardMessage'.DTR.'ComboardMessageReadBy'=>$r['ComboardMessageReadBy']."|$userID|");
				$DS->save($input_update,$where);
			}
		}
*/



		$SERVER->setDebug('ComboardMessageClass.getComboardMessages.End','End');
		return $result;
	}	

	function getComboardMessage($input){
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ComboardMessageClass.getComboardMessage.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		$entityID = $input['ComboardMessage'.DTR.'ComboardMessageID'];
		
		if(empty($entityID)) $entityID = $input['ComboardMessageID'];
		if(empty($entityID)) $entityID = $input['MessageID'];
			
		$query = "SELECT * FROM ComboardMessage WHERE ComboardMessageID='$entityID'"; 

		if(!empty($query))
			$result = $DS->query($query); 		

		/*
		$pattern="/^(19|20)(\d{2})-(\d{2})-(\d{2})/";
		$replace="\\4-\\3-\\1\\2";
		$result[0]['ComboardMessageStartTime'] = preg_replace($pattern,$replace,$result[0]['ComboardMessageStartTime']);
		$result[0]['ComboardMessageEndTime'] = preg_replace($pattern,$replace,$result[0]['ComboardMessageEndTime']);
		*/
		//echo "<hr><pre>";
		//print_r($result);
		//echo "</pre><hr>";

		$SERVER->setDebug('ComboardMessageClass.getComboardMessage.End','End');		
		return $result;		
	}

	function setComboardMessage($input){

		$SERVER = &$this->_controller;
		$SERVER->setDebug('ComboardMessageClass.setComboardMessage.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$ownerID = $config['OwnerID'];
		$entityID = $input['ComboardMessage'.DTR.'ComboardMessageID'];
//		$input['ComboardMessage'.DTR.'ComboardMessageUsers']="|$userID|";
		$input['ComboardMessage'.DTR.'ComboardMessageReadBy']="|$userID|";


		if(!empty($input['ComboardMessage'.DTR.'ComboardMessageGroups']))
		{
			if(is_array($input['ComboardMessage'.DTR.'ComboardMessageGroups']))
			{
				$adminsRS = $DS->query("SELECT UserID, Status FROM User WHERE GroupID!='user'");
				if(is_array($input['ComboardMessage'.DTR.'ComboardMessageUsers']))
				{
					$input['ComboardMessage'.DTR.'ComboardMessageUsers'] = '|'.implode("|",$input['ComboardMessage'.DTR.'ComboardMessageUsers']).'|';
					//$patern = '|'.$userID.'|';
					//$string = $input['ComboardMessage'.DTR.'ComboardMessageUsers'];
					//echo $string;
					//if(!ereg($patern,$string))
					$input['ComboardMessage'.DTR.'ComboardMessageUsers'] = $input['ComboardMessage'.DTR.'ComboardMessageUsers'].$userID.'|';
						
					//echo 'ComboardMessageUsers='.$input['ComboardMessage'.DTR.'ComboardMessageUsers']."_#_";
					//echo 'userID='.$userID."_#_";
				}
				foreach($input['ComboardMessage'.DTR.'ComboardMessageGroups'] as $groupID)
				{
					foreach($adminsRS as $adminRow)
					{
						if($adminRow['Status']==$groupID)
						{
							$currentAdminUserID =  $adminRow['UserID'];
							if(!eregi($currentAdminUserID,$input['ComboardMessage'.DTR.'ComboardMessageUsers']))
							{
								$input['ComboardMessage'.DTR.'ComboardMessageUsers'] .= $currentAdminUserID.'|';
							}
						}//end of if($adminRow['Status']==$groupID)
					}// end of foreach($adminsRS as $adminRow)
				}//end of foreach($input['ComboardMessage'.DTR.'ComboardMessageGroups'] as $groupID)
			}//end of if(is_array($input['ComboardMessage'.DTR.'ComboardMessageGroups']))
		}//end of if(!empty($input['ComboardMessage'.DTR.'ComboardMessageGroups']))

		if(empty($input['ComboardMessage'.DTR.'ComboardMessageGroups'])){
			if(is_array($input['ComboardMessage'.DTR.'ComboardMessageUsers'])){
				$input['ComboardMessage'.DTR.'ComboardMessageUsers'] = '|'.implode("|",$input['ComboardMessage'.DTR.'ComboardMessageUsers']).'|';
				//$string = '|'.$userID.'|';
				//if(!ereg($string,$input['ComboardMessage'.DTR.'ComboardMessageUsers']))
				$input['ComboardMessage'.DTR.'ComboardMessageUsers'] = $input['ComboardMessage'.DTR.'ComboardMessageUsers'].$userID.'|';
			}
		}	
	//echo 'rr='.$input['ComboardMessage'.DTR.'ComboardMessageUsers'];
		$where['ComboardMessage'] = "ComboardMessageID = '".$entityID."'";

		if(!empty($input['ComboardMessage'.DTR.'ComboardMessageStartTime_calendar'])) {$input['ComboardMessage'.DTR.'ComboardMessageStartTime']=$input['ComboardMessage'.DTR.'ComboardMessageStartTime_calendar'];}
		if(!empty($input['ComboardMessage'.DTR.'ComboardMessageStartTime_task'])) {$input['ComboardMessage'.DTR.'ComboardMessageStartTime']=$input['ComboardMessage'.DTR.'ComboardMessageStartTime_task'];}
		if(!empty($input['ComboardMessage'.DTR.'ComboardMessageStartTime_event'])) {$input['ComboardMessage'.DTR.'ComboardMessageStartTime']=$input['ComboardMessage'.DTR.'ComboardMessageStartTime_event'];}
		if(!empty($input['ComboardMessage'.DTR.'ComboardMessageEndTime_event'])) {$input['ComboardMessage'.DTR.'ComboardMessageEndTime']=$input['ComboardMessage'.DTR.'ComboardMessageEndTime_event'];}

		$pattern="/^(\d{2})-(\d{2})-(19|20)(\d{2})/";
		$replace="\\3\\4-\\2-\\1";
		$input['ComboardMessage'.DTR.'ComboardMessageStartTime'] = preg_replace($pattern,$replace,$input['ComboardMessage'.DTR.'ComboardMessageStartTime']);
		$input['ComboardMessage'.DTR.'ComboardMessageEndTime'] = preg_replace($pattern,$replace,$input['ComboardMessage'.DTR.'ComboardMessageEndTime']);

//echo "<hr>";
//print_r($input);
//echo "<hr>";
//die('rrr');

		if(input('ComboardMessage'.DTR.'ComboardMessageTitle')||(input('ComboardMessage'.DTR.'ComboardMessageType')=='memo'))
			$result = $DS->save($input,$where);	

		//print_r($result);

//		if($input['actionMode']=='add')
//			$query = 'insert into ComboardMessage (	ComboardMessageID,	OwnerID,	UserID,		PermAll,	ComboardMessageType,										ComboardMessageTitle,										ComboardMessageContent,											ComboardMessageUsers,										ComboardMessageGroups,											ComboardMessageStartTime,	ComboardMessageEndTime,	ComboardMessageTimeCreated,									ComboardMessageTimeSaved,									ComboardMessageStatus) values'.
//												"(	null,				'$ownerID',	'$userID',	1,			'".$input['ComboardMessage'.DTR.'ComboardMessageType']."',	'".$input['ComboardMessage'.DTR.'ComboardMessageTitle']."',	'".$input['ComboardMessage'.DTR.'ComboardMessageContent']."',	'".$input['ComboardMessage'.DTR.'ComboardMessageUsers']."',	'".$input['ComboardMessage'.DTR.'ComboardMessageGroups']."',	curdate(),					curdate(),				'".$input['ComboardMessage'.DTR.'ComboardTimeCreated']."',	'".$input['ComboardMessage'.DTR.'ComboardTimeSaved']."',	'new')";
//												"(	null,				$ownerID,	$userID,	1,			".$input['ComboardMessage'.DTR.'ComboardMessageType'].")";
//echo "||$query||";
//		if(!empty($query))
//			$result = $DS->query($query); 		
		
		
/*
		if(is_array($input['ComboardMessage'.DTR.'ComboardMessageID'])){
			while (list($fieldNimber,$fieldValue)= each($input['ComboardMessage'.DTR.'ComboardMessageID'])) 
				$where['ComboardMessage'][] = "ComboardMessageID = '".$fieldValue."'".$filter;
		}else{
			$where['ComboardMessage'] = "ComboardMessageID = '".$entityID."s'".$filter;
		}
		
		if(empty($input['ComboardMessage'.DTR.'ComboardMessageStatus']))
			$input['ComboardMessage'.DTR.'ComboardMessageStatus']='new';
		if(empty($input['ComboardMessage'.DTR.'ComboardMessageFolderAlias']))
			$input['ComboardMessage'.DTR.'ComboardMessageFolderAlias']='inbox';
		if(empty($input['ComboardMessage'.DTR.'ComboardMessageSenderNickName']))
			$input['ComboardMessage'.DTR.'ComboardMessageSenderNickName']=$user['FirstName'].' '.$user['LastName'];
		
		if(!$SERVER->hasRights('adminComboardMessages'))
			if($input['ComboardMessage'.DTR.'ComboardMessageReceiverGroup']!='root' && $input['ComboardMessage'.DTR.'ComboardMessageReceiverGroup']!='admin' && $input['ComboardMessage'.DTR.'ComboardMessageReceiverGroup']!='content')
				$input['ComboardMessage'.DTR.'ComboardMessageReceiverGroup']=''; 

		if(!empty($input['ComboardMessage'.DTR.'ComboardMessageUsers']) || !empty($input['ComboardMessage'.DTR.'ComboardMessageGroups'])){
			if(eregi('@',$input['ComboardMessage'.DTR.'ComboardMessageReceiverNickName'])){
				//send email in case if the receiver's nickname is an email address;
				$emailIN['MailTo'] = $input['ComboardMessage'.DTR.'ComboardMessageReceiverNickName'];
				//$emailIN['MailToName'] = $userName;
				$emailIN['MailFrom'] =$user['UserName'];
				$emailIN['MailFromName'] =$user['Email'];
				$emailIN['MailData'] ='<Content><ComboardMessage><![CDATA['.$input['ComboardMessage'.DTR.'ComboardMessageText'].']]></ComboardMessage><SenderName><![CDATA['.$user['UserName'].']]></SenderName></Content>';
				$emailIN['MailTemplate'] = 'comboardMessageSendEmail';
				//print_r($emailIN);
				//$SERVER->callService('sendMail','mailServer',$emailIN);	
			}else{
				$isActive='Y';
				if($isActive=='Y'){
					if($input['actionMode']=='attach'){
						$input['actionMode']='save';
						$result = $DS->save($input,$where,'insert');	
						$result['ComboardMessageAddedID'] = $DS->dbLastID();

						$input['ComboardMessageAttachment'.DTR.'ComboardMessageID']= $result['ComboardMessageAddedID'];
						$where='';
						$where['ComboardMessageAttachment']='ComboardMessageID="'.$result['ComboardMessageAddedID'].'"';
						//print_r($where);
						$DS->save($input,$where,'insert');	
						$input['actionMode']='attach';
						$SERVER->setComboardMessage('ComboardMessageClass.setComboardMessage.msg.DataSaved');
					}

					if($input['actionMode']=='attach2'){
						$input['actionMode']='save';
						
						$result['ComboardMessageAddedID']=$input['ComboardMessageAddedID'];

						$where='';
						$where['ComboardMessageAttachment']='ComboardMessageID="'.$result['ComboardMessageAddedID'].'"';
						//print_r($where);
						$DS->save($input,$where,'insert');	
						$input['actionMode']='attach2';
						$SERVER->setComboardMessage('ComboardMessageClass.setComboardMessage.msg.DataSaved');
					}

					if($input['actionMode']=='updateNew'){
						$where='';
						$where['ComboardMessage'] = "ComboardMessageID = '".$entityID."'".$filter;
						$input['actionMode']='save';
						$result = $DS->save($input,$where,'update');
						$SERVER->setComboardMessage('ComboardMessageClass.setComboardMessage.msg.DataSaved');
					}

					if($input['actionMode']=='send'){
						$input['actionMode']='save';
						$result = $DS->save($input,$where,'insert');	
						//print_r($where);
						$SERVER->setComboardMessage('ComboardMessageClass.setComboardMessage.msg.DataSaved');
					}

					if(!empty($comboardMessageToReplyID)){
						$DS->query("UPDATE ComboardMessage SET ComboardMessageStatus='replied' WHERE ComboardMessageID='$comboardMessageToReplyID'");
					}
				}else{
					$SERVER->setComboardMessage('ComboardMessageClass.setComboardMessage.err.NoReceiverFound');
				}
			}
		}else{
			$SERVER->setComboardMessage('ComboardMessageClass.setComboardMessage.err.NoReceiversSelected');
		}
*/
		$SERVER->setDebug('ComboardMessageClass.setComboardMessage.End','End');		
		return $result;		
	}

	function setComboardMessageAsRead($input){

		$SERVER = &$this->_controller;
		$SERVER->setDebug('ComboardMessageClass.deleteComboardMessage.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$user = $this->_user;
		$userID = $user['UserID'];
		$entityID = $input['ComboardMessage'.DTR.'ComboardMessageID'];
		
		if(!empty($entityID))
		{
			$rs = $DS->query("SELECT ComboardMessageReadBy FROM ComboardMessage WHERE ComboardMessageID='$entityID' ");
			$ComboardMessageReadBy = $rs[0]['ComboardMessageReadBy'];
			$ComboardMessageReadBy = $ComboardMessageReadBy.$userID.'|';
			$DS->query("UPDATE ComboardMessage SET ComboardMessageReadBy='".$ComboardMessageReadBy."' WHERE ComboardMessageID='$entityID'");
		}

	}
	
	function deleteComboardMessage($input){

		$SERVER = &$this->_controller;
		$SERVER->setDebug('ComboardMessageClass.deleteComboardMessage.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$user = $this->_user;
		$userID = $user['UserID'];
		$entityID = $input['ComboardMessage'.DTR.'ComboardMessageID'];
//		if(!$entityID)
//			$entityID = $input['ID'];
		$result=null;
		if(empty($entityID)) {$entityID = $input['ComboardMessageID'];}		

		$newStatus='deleted';
		if($input['actionMode']=='complete')
			$newStatus='completed';

		$input['actionMode']='save';
			
		$where['ComboardMessage'] = "ComboardMessageID = '".$entityID."'";
		$result1 = $DS->query("select ComboardMessageStatus from ComboardMessage where $where[ComboardMessage]");
		if(is_array($result1) and count($result1)){
			$status = array_unique(preg_split("/\|/",$result1[0]['ComboardMessageStatus'],-1,PREG_SPLIT_NO_EMPTY));
			if(!is_array($status) || !in_array($newStatus,$status))
				$status[] = $newStatus;
			else
				$status = array_diff($status,array($newStatus));
			$input['ComboardMessage'.DTR.'ComboardMessageStatus']='|'.implode('|',$status).'|';
//echo "<hr>";
//print_r($input);
//echo "<hr>";
			$result = $DS->save($input,$where);	
		}

		$SERVER->setDebug('ComboardMessageClass.deleteComboardMessage.End','End');		
		return $result;		
	}	

	function comboardMessageIsRead($entityID){

		$SERVER = &$this->_controller;
		$SERVER->setDebug('ComboardMessageClass.deleteComboardMessage.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	

		$query = "UPDATE ComboardMessage SET ComboardMessageStatus='read' WHERE ComboardMessageID='$entityID' AND UserID!='$userID'";
		$DS->query($query);
		return $result;		
	}		
	
	function getComboardMessageType($input){
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ComboardMessageClass.getComboardMessage.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		$entityID = $input['ComboardMessage'.DTR.'ComboardMessageID'];

		$query = "SELECT ComboardMessageType Name FROM ComboardMessage GROUP BY ComboardMessageType"; 
		$result = $DS->query($query); 		
		
		//print_r($result);
		
		$SERVER->setDebug('ComboardMessageClass.getComboardMessage.End','End');		
		return $result;		
	}
	
}
?>
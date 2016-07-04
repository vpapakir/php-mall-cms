<?php
//XCMSPro: Web Service entity class
class PollQuestionClass
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
	function PollQuestionClass()
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
	function getPollQuestions($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PollQuestionClass.getPollQuestions.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$searchWord = $input['searchWord'];
		$place = $input['pollQuestionsPlace'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'PollQuestionServer.adminPollQuestion');
		if(!empty($searchWord))
		{
			//$filter .= " AND (PollQuestionName LIKE '{ls}%$searchWord%{le}' OR PollQuestionName LIKE '%$searchWord%' OR PollQuestionDescription LIKE '{ls}%$searchWord%{le}' OR PollQuestionDescription LIKE '%$searchWord%')";
		}
		if($clientType!='admin')
		{
			$filter .= " AND PermAll!=4";
		}
		if(!empty($place))		
		{		
			$filter .= " AND PollQuestionHiddenPlaces NOT LIKE '%|$place|%'";
		}
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM PollQuestion WHERE PollQuestionID>0 $filter ORDER BY PollQuestionPosition";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		$SERVER->setDebug('PollQuestionClass.getPollQuestions.End','End');
		return $result;
	}	
	
	function getPollAnswers($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PollQuestionClass.getPollAnswers.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['PollQuestion'.DTR.'PollQuestionID'];
		if(empty($entityID)) {$entityID = $input['PollQuestionID'];}
		/*$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['PollQuestion'];}
		if(empty($entityAlias)) {$entityAlias = $input['PollQuestionAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PollQuestion'.DTR.'PollQuestionAlias'];}*/
		$searchWord = $input['searchWord'];
		//set filters
		/*if(empty($entityID) && !empty($entityAlias))
		{
			$pollQuestionIDRS = $DS->query("SELECT PollQuestionID FROM PollQuestion WHERE PollQuestionAlias='$entityAlias'");
			$entityID = $pollQuestionIDRS[0]['PollQuestionID'];
		}*/
		//$filter = $DS->getAccessFilter($input,'PollQuestionServer.adminPollQuestion');
		if(!empty($entityID) && $clientType=='admin')		
		{
			$filter .= " AND PollQuestionID='$entityID'";
		}
		if($clientType!='admin')
		{
			$filter .= " AND PermAll!=4";
		}
		//set queries
		//$filter .= "OwnerID='$ownerID' ";
		$query = "SELECT * FROM PollAnswer WHERE PollAnswerID>0 $filter ORDER BY PollAnswerPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('PollQuestionClass.getPollAnswers.End','End');
		return $result;
	}	
	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getPollQuestion($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PollQuestionClass.getPollQuestion.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['PollQuestion'.DTR.'PollQuestionID'];
		if(empty($entityID)) {$entityID = $input['PollQuestionID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['PollQuestion'];}
		if(empty($entityAlias)) {$entityAlias = $input['PollQuestionAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PollQuestion'.DTR.'PollQuestionAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'PollQuestionServer.adminPollQuestion');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " PollQuestionAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " PollQuestionID='$entityID' ";
		}
		$query = "SELECT * FROM PollQuestion WHERE $filter"; 
		//echo $query;
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('PollQuestionClass.getPollQuestion.End','End');		
		return $result;		
	}
	
	function getPollAnswer($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PollQuestionClass.getPollAnswer.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['PollAnswer'.DTR.'PollAnswerID'];
		if(empty($entityID)) {$entityID = $input['PollAnswerID'];}

		$entityAlias = $input['PollAnswer'];
		if(empty($entityAlias)) {$entityAlias = $input['PollAnswerAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['PollAnswer'.DTR.'PollAnswerAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'PollQuestionServer.adminPollQuestion');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " PollAnswerAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " PollAnswerID='$entityID' ";
		}
		$query = "SELECT * FROM PollAnswer WHERE $filter"; 
		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('PollQuestionClass.getPollAnswer.End','End');		
		return $result;		
	}
	
	function getPollStatistics($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PollQuestionClass.getPollStatistics.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		$session = $SERVER->getSession();
		//set filters
		if(!empty($userID))
		{	
			$filter .= " AND UserID = '$userID'";
		}
			else
				{
					$filter .= " AND SessionID = '".$session['SessionID']."'";
				}

		//set queries
		$query = "SELECT * FROM  PollStatisticUser WHERE PollStatisticUserID>0 $filter"; 

		//get the content
		$result = $DS->query($query);
		$SERVER->setDebug('PollQuestionClass.getPollStatistics.End','End');		
		return $result;		
	}
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setPollQuestion($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PollQuestionClass.setPollQuestion.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['PollQuestion'.DTR.'PollQuestionID'];
		if(empty($entityID)) {$entityID = $input['PollQuestionID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PollQuestionServer.adminPollQuestion');
		//set queries	
		//if(is_array($input['PollQuestion'.DTR.'AccessGroups'])) {$input['PollQuestion'.DTR.'AccessGroups'] = '|'. implode("|",$input['PollQuestion'.DTR.'AccessGroups']).'|'; }
		$where['PollQuestion'] = "PollQuestionID = '".$entityID."'".$filter;
		/*if(empty($input['PollQuestion'.DTR.'PollQuestionAlias']) && !empty($input['PollQuestion'.DTR.'PollQuestionName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langPollQuestionName = $input['PollQuestion'.DTR.'PollQuestionName']['en'];
			if(empty($langPollQuestionName)) { $lang = $config['lang']; $langPollQuestionName = $input['PollQuestion'.DTR.'PollQuestionName'][$lang];}
			$input['PollQuestion'.DTR.'PollQuestionAlias'] = $typeObject->setDataType($langPollQuestionName);
		}	
		if(!empty($input['PollQuestion'.DTR.'PollQuestionAlias']))
		{
			$checkRS=$DS->query("SELECT PollQuestionAlias FROM PollQuestion WHERE PollQuestionAlias='".$input['PollQuestion'.DTR.'PollQuestionAlias']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['PollQuestion'.DTR.'PollQuestionAlias'] = $input['PollQuestion'.DTR.'PollQuestionAlias'].date('Ymd-His');
				$SERVER->setMessage('resource.PollQuestionClass.setPollQuestion.err.DuplicatedPollQuestion');
			}				
		}

		if(!empty($input['PollQuestion'.DTR.'PollQuestionAlias']) && !empty($input['PollQuestion'.DTR.'PollQuestionName']))
		{	*/	
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		/*}
		else
		{
			if(!empty($input['PollQuestion'.DTR.'PollQuestionAlias']))
			{
				$SERVER->setMessage('PollQuestionClass.setPollQuestion.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('PollQuestionClass.setPollQuestion.msg.DataSaved');
		}
		if(!empty($input['PollQuestion'.DTR.'PollQuestionAlias']) && !empty($entityID))
		{
			$this->updateEntityPositions($entityID,'PollQuestion');
			$DS->query("UPDATE PollAnswer SET PollQuestion='".$input['PollQuestion'.DTR.'PollQuestionAlias']."' WHERE PollQuestionID='$entityID'");
		}*/
		$SERVER->setDebug('PollQuestionClass.setPollQuestion.End','End');		
		return $result;		
	}

	function setPollAnswer($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PollAnswerClass.setPollAnswer.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['PollAnswer'.DTR.'PollAnswerID'];
		if(empty($entityID)) {$entityID = $input['PollAnswerID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PollAnswerServer.adminPollAnswer');
		//set queries	

		//if(is_array($input['PollAnswer'.DTR.'AccessGroups'])) {$input['PollAnswer'.DTR.'AccessGroups'] = '|'. implode("|",$input['PollAnswer'.DTR.'AccessGroups']).'|'; }
		$where['PollAnswer'] = "PollAnswerID = '".$entityID."'".$filter;

		/*if(empty($input['PollAnswer'.DTR.'PollAnswerAlias']) && !empty($input['PollAnswer'.DTR.'PollAnswerName']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langPollAnswerName = $input['PollAnswer'.DTR.'PollAnswerName']['en'];
			if(empty($langPollAnswerName)) { $lang = $config['lang']; $langPollAnswerName = $input['PollAnswer'.DTR.'PollAnswerName'][$lang];}
			$input['PollAnswer'.DTR.'PollAnswerAlias'] = $typeObject->setDataType($langPollAnswerName);
		}	
		if(!empty($input['PollAnswer'.DTR.'PollAnswerAlias']))
		{
			$checkRS=$DS->query("SELECT PollAnswerAlias FROM PollAnswer WHERE PollAnswerAlias='".$input['PollAnswer'.DTR.'PollAnswerAlias']."' AND PollQuestion='".$input['PollAnswer'.DTR.'PollQuestion']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['PollAnswer'.DTR.'PollAnswerAlias'] = $input['PollAnswer'.DTR.'PollAnswerAlias'].date('Ymd-His');
				$SERVER->setMessage('resource.PollAnswerClass.setPollAnswer.err.DuplicatedPollAnswer');
			}				
		}
		if(!empty($input['PollAnswer'.DTR.'PollAnswerAlias']) && !empty($input['PollAnswer'.DTR.'PollAnswerName'])  && !empty($input['PollAnswer'.DTR.'PollQuestionID']))
		{*/		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		/*}
		else
		{
			if(!empty($input['PollAnswer'.DTR.'PollAnswerAlias']))
			{		
				$SERVER->setMessage('PollAnswerClass.setPollAnswer.err.AlreadyExists');
			}
		}
		if(count($result)>0)	
		{
			$SERVER->setMessage('PollAnswerClass.setPollAnswer.msg.DataSaved');
		}
		if(!empty($input['PollAnswer'.DTR.'PollAnswerAlias']))
		{
			$this->updateEntityPositions($entityID,'PollAnswer',$input['PollAnswer'.DTR.'PollQuestionID'],'PollQuestion');
		}*/		
		$SERVER->setDebug('PollAnswerClass.setPollAnswer.End','End');		
		return $result;		
	}
	
	function updateVotes($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PollAnswerClass.updateVotes.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$session = $SERVER->getSession();
		//set client side variables
		$entityID = $input['PollAnswer'.DTR.'PollAnswerID'];
		if(empty($entityID)) {$entityID = $input['PollAnswerID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PollAnswerServer.adminPollAnswer');
		//set queries	
		$PollQuestionID = $input['PollQuestionID'];
		if(!empty($PollQuestionID))
		{	
			$filterUser .=" AND PollQuestionID = '$PollQuestionID'";
		}
		if(!empty($userID))
		{	
			$filterUser .= " AND UserID = '$userID'";
		}
			else
				{
					$filterUser .= " AND SessionID = '".$session['SessionID']."'";
				}
		$query = "SELECT * FROM PollStatisticUser WHERE PollAnswerID>0 $filterUser"; 
		//get the content
		$RSuser = $DS->query($query);
		if(count($RSuser)<1)
		{
			if(!empty($entityID))
			{	
				$filter .="PollAnswerID = '$entityID'";
			} 
			$query = "SELECT PollAnswerVotes FROM PollAnswer WHERE $filter"; 
			//get the content
			$resultVotes = $DS->query($query);
			$inputVotes['PollAnswer'.DTR.'PollAnswerVotes'] = $resultVotes[0]['PollAnswerVotes']+1;
			$inputVotes['PollAnswer'.DTR.'PollAnswerID'] = $entityID;
			
			$where['PollAnswer'] = "PollAnswerID = '".$entityID."'";
	
			$inputVotes['actionMode']='save';					
			$result = $DS->save($inputVotes,$where,'insert');	
			
			//$PollQuestionID = $input['PollQuestionID'];
			if(!empty($PollQuestionID))
			{	
				$filterQuestion .="PollQuestionID = '$PollQuestionID'";
			} 
			$query = "SELECT PollQuestionVotes FROM PollQuestion WHERE $filterQuestion"; 
			//get the content
			$resultQuestionVotes = $DS->query($query);
			$inputQuestionVotes['PollQuestion'.DTR.'PollQuestionVotes'] = $resultQuestionVotes[0]['PollQuestionVotes']+1;
			$inputQuestionVotes['PollQuestion'.DTR.'PollQuestionID'] = $PollQuestionID;
			
			$whereQuestionVotes['PollQuestion'] = "PollQuestionID = '".$PollQuestionID."'";
			$inputQuestionVotes['actionMode']='save';					
			$result = $DS->save($inputQuestionVotes,$whereQuestionVotes,'insert');
			
			$whereValues['PollStatisticUser'] = "PollStatisticUserID = '".$PollStatisticUserID."'";
			
			$inValues['PollStatisticUser'.DTR.'PollAnswerID'] = $entityID;
			$inValues['PollStatisticUser'.DTR.'PollQuestionID'] = $PollQuestionID;
			$inValues['PollStatisticUser'.DTR.'SessionID'] = $session['SessionID'];
			$inValues['actionMode']='save';					
			$result = $DS->save($inValues,$whereValues,'insert');
		}
			else{
					$SERVER->setMessage('PollAnswerClass.updateVotes.err.AlreadyVotes');
				}
		$SERVER->setDebug('PollAnswerClass.updateVotes.End','End');		
		return $result;		
	}
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deletePollQuestion($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PollQuestionClass.deletePollQuestion.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['PollQuestion'.DTR.'PollQuestionID'];
		//if(empty($entityID)) {$entityID = $input['PollQuestionID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PollQuestionServer.adminPollQuestion');
		//set queries
		if(!empty($entityID))
		{
			$typeFieldIDRS = $DS->query("SELECT PollAnswerID FROM PollAnswer WHERE PollQuestionID='$entityID'");
			$typeFieldID = $typeFieldIDRS[0]['PollAnswerID'];
			$DS->query("DELETE FROM PollQuestion WHERE PollQuestionID='$entityID'");
			$DS->query("DELETE FROM PollAnswer WHERE PollQuestionID='$entityID'");
			/*if(!empty($typeFieldID))
			{
				$DS->query("DELETE FROM PollQuestionOption WHERE PollAnswerID='$typeFieldID'");
			}*/
		}
		$SERVER->setMessage('PollQuestionClass.deletePollQuestion.msg.DataDeleted');
		$SERVER->setDebug('PollQuestionClass.deletePollQuestion.End','End');		
		return $result;		
	}	
	
	function deletePollAnswer($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PollQuestionClass.deletePollAnswer.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['PollAnswer'.DTR.'PollAnswerID'];
		//if(empty($entityID)) {$entityID = $input['PollQuestionID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'PollQuestionServer.adminPollQuestion');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM PollAnswer WHERE PollAnswerID='$entityID'");
			//$DS->query("DELETE FROM PollQuestionOption WHERE PollAnswerID='$entityID'");
		}
		$SERVER->setMessage('PollQuestionClass.deletePollAnswer.msg.DataDeleted');
		$SERVER->setDebug('PollQuestionClass.deletePollAnswer.End','End');		
		return $result;		
	}	
	

	function updateEntityPositions($entityID,$entityName,$entityParentID='',$entityParentName='')
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$input = $SERVER->getInput();
		//set client side variables
		if(empty($entityID))
		{
			return '';
		}

		if(!empty($entityParentID))
		{
			$query = "SELECT ".$entityName."ID, ".$entityName."Position FROM $entityName WHERE ".$entityParentName."ID='$entityParentID' ORDER BY ".$entityName."Position ASC";			
		}
		else
		{
			$query = "SELECT ".$entityName."ID, ".$entityName."Position FROM $entityName ORDER BY ".$entityName."Position ASC";			
		}
		$rs = $DS->query($query);
		$i=2;
		
		foreach($rs as $row)
		{
			$DS->query("UPDATE $entityName SET ".$entityName."Position='$i' WHERE ".$entityName."ID='".$row[$entityName.'ID']."'");
			//echo "UPDATE $entityName SET ".$entityName."Position='$i' WHERE ".$entityName."ID='".$row[$entityName.'ID']."'<br>";
			$i = $i+2;
		}
		//return $result;		
	}	
	
	function getResourceTemplate($pollQuestion,$resourceID='')
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		//set filters
		//$filter = $DS->getAccessFilter($input,'ResourceServer.adminResource');
		//set queries
		$query ='';
		if(!empty($resourceID))
		{
			$pollQuestionRS = $DS->query("SELECT PollQuestion FROM Resource WHERE ResourceID='$resourceID'");
			$pollQuestion = $pollQuestionRS[0]['PollQuestion'];
		}
		
		if(!empty($pollQuestion))
		{
			$query = "SELECT ResourceTemplate FROM PollQuestion WHERE PollQuestionAlias='$pollQuestion'"; 
		}
		else
		{
			return '';
		}
		//get the content
		$result = $DS->query($query);	

		return $result[0]['ResourceTemplate'];		
	}
		
} // end of PollQuestionServer
?>
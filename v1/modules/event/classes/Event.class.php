<?php
class EventClass
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
	function EventClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	
	// PUBLIC METHODS
	
	//jb 21.11.05 refactored,updated
	function runEvents($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$SERVER->setDebug('EventClass.runEvents.Start','Start');
		//get events
		if(!empty($input['EventID']))
		{
			$sql = "SELECT * FROM  Event WHERE TimeStart<'".date('Y-m-d H:i:s')."' AND EventID='".$input['EventID']."'";
		}
		else
		{
			$sql = "SELECT * FROM  Event WHERE TimeStart<'".date('Y-m-d H:i:s')."' ORDER BY TimeStart ASC";			
		}
		$dsResult = $DS->query($sql);
		
		if(is_array($dsResult))
		{
			foreach ($dsResult as $row)
			{
				//authorize event
				$eventID = $row['EventID'];
				$authorizeIN['EventID'] = $row['EventID'];
				$authorizeIN['UserID'] = $row['UserID'];
				$authorizeIN['SessionID'] = $row['EventSessionID'];
				
				/*!!! jb 21.11.05 tmp commented, need to be running after changing session module
				!!! if($this->authorizeEvent($authorizeIN)))*/
				if(1) //tmp
				{
					
					//run event's web service
					$serviceIN = $this->getEventInputData($row['EvenetInput']);			
					
					$eventType = $row['EventType'];
					if($eventType=='onetime')
					{
						//delete event that starts if this is 1 time event
						$sql = "DELETE FROM Event WHERE EventID = '$eventID'";
						if(!empty($eventID))
						{
							//echo '<br>sqlDeleteEvent='.$sql.'<br>'.LB;
							$DS->query($sql);
						}
						
					}
					else
					{
						//deactivate the event .. put the next time when it must run
						$sql = "UPDATE Event SET TimeStart='".date('Y-m-d H:i:s')."' WHERE EventID='$eventID'";
						//echo '<br>sql UpdateEvent'.$sql.'<br>'.LB;
						$DS->query($sql);
					}
					
					$logRecord = date('d/m/Y H:i:s').' : EventID : '.$row['EventID'].' : Run server : '.$row['EventServer'].' : Run method : '.$row['EventMethod'].' : Authorized UserID : '.$row['UserID'].' :<br>'."\n";	
					//echo $logRecord;
					$retval .= $logRecord;
					$SERVER->callService($row['EventMethod'],$row['EventServer'],$serviceIN);
				}
			}
		}
		else
		{
			$SERVER->setMessage('EventClass.runEvents.NoEvents');
			$SERVER->setDebug('EventClass.runEvents.NoEvents');			
		}
		$SERVER->setDebug('EventClass.runEvents.End','End');		
		return $retval;
	}
	
	//jb 21.11.05 refactored,updated
	function authorizeEvent($in)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$eventID = $in['EventID'];
		$userID = $in['UserID'];
		$SERVER->setSessionID($in['SessionID']);
		
		$retval = $SERVER->callService('authorizeEvent','sessionServer',$in);
		$result = $retval['Result'];
		if ($result!='false')
		{
			//print_r($retval);
			if($result['SessionID']!=$in['SessionID'])
			{
				$sqlupdate = "UPDATE Event SET EventSessionID='".$result['SessionID']."' WHERE EventID='$eventID'";			
				$dsResult = $DS->query($sqlupdate);			
				//echo 'session update data:'.$sqlupdate.'<br>';
			}
			$SERVER->setSessionData($result['Vars']);
			$SERVER->setUserData($result['User']);
			$SERVER->setSessionID($result['SessionID']);			
			return true;
		}
		else
		{
			return false;
		}	
	}
	
	//jb 19.11.05 refactored,updated
	function addEvent($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$user = $SERVER->getUser();
		$SERVER->setDebug('EventClass.getEvents.Start','Start');
		$inputSave['actionMode']='save';
		$inputSave['Event'.DTR.'UserID']=$user['UserID'];
		if($input['EventStart']=='now')
		{
			$inputSave['Event'.DTR.'TimeStart']=date('Y-m-d H:i:s');
		}
		else
		{
			$inputSave['Event'.DTR.'TimeStart']=$input['EventStart'];
		}
		
		//jb 21.11.05 old $inputSave['Event'.DTR.'EventSessionID']=$user['SessionID'];
		$inputSave['Event'.DTR.'EventSessionID']=$SERVER->getCurrentSessionID(); //jb 21.11.05 new
		
		if(empty($input['EventType']))
		{
			$inputSave['Event'.DTR.'EventType']='onetime';
		}
		else
		{
			$inputSave['Event'.DTR.'EventType']=$input['EventType'];
		}
		$inputSave['Event'.DTR.'EventPeriod']=$input['EventPeriod'];
		$inputSave['Event'.DTR.'EventServer']=$input['EventServer'];
		$inputSave['Event'.DTR.'EventService']=$input['EventService'];
		$inputSave['Event'.DTR.'EventMethod']=$input['EventMethod'];
		$inputSave['Event'.DTR.'EventEmailRemind']=$input['EventEmail'];
		$inputSave['Event'.DTR.'EvenetInput'] = $this->makeEventInput($input['EvenetInput']);
		$where['Event'] = "EventID = ''";
		$saveResult = $DS->save($inputSave,$where,'insert');
		$SERVER->setDebug('EventClass.getEvents.Start','Start');	
			
		return $dsResult;
	}	
	
	//jb 19.11.05 refactored,updated
	function makeEventInput($input)
	{
		$retval = '<'.'Input'.'>' . LB;
		while (list($varName,$varValue)= each($input))
		{
			if (is_array($varValue))
			{
				while (list($varName2,$varValue2)= each($varValue))
				{
					if(eregi(DTR,$varName2))
					{
						$entityArray2 = explode (DTR,$varName2);
						$table2 = $entityArray2[0]; $field2 =  $entityArray2[1];
						$entitiesXML[$varName2][$table2] = '<'.$field2.'><![CDATA['.$varValue2.']]></'.$field2.'>' . LB;
					}
					else
					{
						$variablesXML[$varName2] .= '<'.$varName.'><![CDATA['.$varValue.']]></'.$varName.'>' . LB;
					}
				}
			}
			elseif(eregi(DTR,$varName))
			{
				$entityArray = explode (DTR,$varName);
				$table = $entityArray[0]; $field =  $entityArray[1];
				$entityXML[$table] .= '<'.$field.'><![CDATA['.$varValue.']]></'.$field.'>' . LB;
			}
			else
			{
				$retval .= '<'.$varName.'><![CDATA['.$varValue.']]></'.$varName.'>' . LB;
			}
		}
		
		if(is_array($entityXML))
		{
			while (list($tableXML,$valueXML)= each($entityXML))
			{
				$retval .= '<'.$tableXML.'>'. LB . $valueXML . LB . '</'.$tableXML.'>' . LB;
			}
		}
		if(is_array($variablesXML))
		{				
			while (list($variableNumber,$variableXMLString)= each($variablesXML))
			{
				//torefact2: make it better for associative arrays
				$retval .= '<'.'Var'.'>'. LB . $variableXMLString . LB . '</'.'Var'.'>' . LB;
			}
		}
		if(is_array($entitiesXML))
		{		
			//torefact1: make it to work for rows of table fields in the form
			while (list($tableXML,$valueXML)= each($entitiesXML))
			{
				//$retval .= '<'.$tableXML.'>'. LB . $valueXML . LB . '</'.$tableXML.'>' . LB;
			}			
		}		
		$retval .= '</'.'Input'.'>' . LB;	
		
		return $retval;
	}
	
	//jb 19.11.05 refactored,updated
	function getEventInputData($xml)
	{
		$inArray = $this->_controller->XML2ARRAY($xml);
		foreach($inArray['Input']['#'] as $varName=>$varValue)
		{
			if(is_array($varValue[0]['#']))
			{
				foreach($varValue[0]['#'] as $varName2=>$varValue2)
				{
					$retval[$varName.DTR.$varName2] =$varValue2[0]['#'];
				}
			}
			else
			{
				$retval[$varName] = $varValue[0]['#'];
			}
		}
		return $retval;
	}
	
	//jb 21.11.05 refactored,updated
	function getEvent($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$SERVER->setDebug('EventClass.getEvent.Start','Start');
		//get events
		if(!empty($input['Event'.DTR.'EventID']))
		{
			$eventID = $input['Event'.DTR.'EventID'];
		}
		else
		{
			$eventID = $input['EventID'];
		}
		
		$sql = "SELECT * FROM Event WHERE EventID='".$eventID."'";
		$dsResult = $DS->query($sql);
		
		$SERVER->setDebug('EventClass.getEvent.Start','Start');		
		return $dsResult;
	}

	function getEvents($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;
		$SERVER->setDebug('EventClass.getEvents.Start','Start');
		//get events
		$xcmsq = "Event/";
		//print_r($DS);
		$mode['pagesMode']=20;
		$dsResult = $DS->query($xcmsq,$mode);
		//echo 'EventServer.GetEvent'.$xcmsq.'<br>';
		//print_r($dsResult);
		$SERVER->setDebug('EventClass.getEvents.Start','Start');		
		return $dsResult;
	}
	
	function setEvent($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('EventServer.setEvent.Start','Start');	
		$DS = &$this->_DS;
		$user = $SERVER->getUser();
		$userID = $user['UserID'];
		if($SERVER->hasRights('CompanyServer.adminCompanies'))
		{
			$filter = "";
		}
		else
		{
			$filter = " AND UserID='$userID'";			
		}
		$eventID = $input['Event'.DTR.'EventID'];
		$where['Event'] = "EventID = '".$eventID."'".$filter;
		$saveRS = $DS->save($input,$where);
		$SERVER->setDebug('EventServer.setEvent.End','End');
		return $saveRS;		
	}
	

} // end of UserSession

?>
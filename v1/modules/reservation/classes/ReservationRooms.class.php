<?php
//XCMSPro: Web Service entity class
class ReservationRoomsClass
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
	function ReservationRoomsClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	// PUBLIC METHODS

	function setReservationRoom($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomTaskClass.setReservationRoomTask.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservationRoom'.DTR.'ReservationRoomID'];
		if(empty($entityID)) {$entityID = $input['ReservationRoomID'];}
		
		$where['ReservationRoom'] = "ReservationRoomID = '".$entityID."'".$filter;

		if(!empty($input['ReservationRoom'.DTR.'OptionCode']) && $input['ReservationRoom'.DTR.'OptionMinOccupation'] >= $input['ReservationRoom'.DTR.'OptionMaxOccupation'] && ($input['actionMode']=='addRoom' || $input['actionMode']=='saveRoom') && !empty($userID))
		{
			$errorOccupation = 1;
		}
		if(!empty($input['ReservationRoom'.DTR.'OptionCode']) && $input['ReservationRoom'.DTR.'OptionMaxChildren'] >= $input['ReservationRoom'.DTR.'OptionMaxOccupation'] && ($input['actionMode']=='addRoom' || $input['actionMode']=='saveRoom') && !empty($userID))
		{
			$errorChildren = 1;
		}
		
		if(!empty($input['ReservationRoom'.DTR.'OptionCode']) && $input['actionMode']=='addRoom' && !empty($userID))
		{
			$FM = new FilesManager();
		    $input = $FM->getUploadedFields($input,'ReservationRoom',array('previewFieldName'=>'OptionIcon'));
			
			$input['actionMode']='save';
			$result = $DS->save($input,$where);
			$entityID = $result[0]['ReservationRoomID'];
			
			$this->updateReservationRoomPositions($entityID);
			
			/*
			$query = $DS->query("SELECT OptionPosition FROM ReservationRoom WHERE OptionName ='".$input['ReservationRoom'.DTR.'OptionPosition']."'");
			$query1 = $DS->query("SELECT OptionPosition FROM ReservationRoom WHERE OptionPosition >'".$query[0]['OptionPosition']."'");
			foreach ($query1 as $array) {
				$NewPosition = $array['OptionPosition'] + 1;
				$DS->query("UPDATE ReservationRoom SET OptionPosition='".$NewPosition."' WHERE OptionPosition='".$array['OptionPosition']."'");
			}
			$NewPosition = $query[0]['OptionPosition'] + 1;
			$DS->query("UPDATE ReservationRoom SET OptionPosition='".$NewPosition."' WHERE OptionCode='".$input['ReservationRoom'.DTR.'OptionCode']."'");
			*/
			
		}
		
		if(!empty($input['ReservationRoom'.DTR.'ReservationRoomID']) && $input['actionMode']=='saveRoom' && !empty($userID))
		{
			$FM = new FilesManager();
		    $input = $FM->getUploadedFields($input,'ReservationRoom',array('previewFieldName'=>'OptionIcon'));
		    
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			$entityID = $result[0]['ReservationRoomID'];
			
			$this->updateReservationRoomPositions($entityID);
		}
		
		if (!empty($errorOccupation)) 
		{
			$SERVER->setMessage('ReservationOrder.ReservationRoomsClass.setReservationRoom.err.SetRoomOccupationError');
		}
		if (!empty($errorChildren)) 
		{
			$SERVER->setMessage('ReservationOrder.ReservationRoomsClass.setReservationRoom.err.SetRoomChildrenError');
		}
		
		
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ReservationRoomTaskClass.setReservationRoomTask.msg.DataSaved');
		}
		
		$SERVER->setDebug('ReservationRoomTaskClass.setReservationRoomTask.End','End');		
		return $result;		
	}	
	
	function getReservationRooms($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomServices.getReservationServicess.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;

		$query = "SELECT * FROM ReservationRoom ORDER BY OptionPosition";
		
		$result = $DS->query($query); 

		return $result;
	}
	
	function getReservationRoom($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomServices.getReservationServicess.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		if (!empty($input['ReservationRoom'.DTR.'ReservationRoomID'])) {
			$query = "SELECT * FROM ReservationRoom WHERE ReservationRoomID = '".$input['ReservationRoom'.DTR.'ReservationRoomID']."'";
		} 
		elseif (!empty($input['ReservationRoom'.DTR.'OptionCode'])) {
			$query = "SELECT * FROM ReservationRoom WHERE OptionCode = '".$input['ReservationRoom'.DTR.'OptionCode']."'";
		}
		
		$result = $DS->query($query); 

      	return $result;  	
	}
	
	function deleteReservationRoom($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomServices.getReservationServicess.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		
		$result = $DS->query("DELETE FROM ReservationRoom WHERE ReservationRoomID='".$input['ReservationRoom'.DTR.'ReservationRoomID']."'"); 

      	return $result;  	
	}
	
	function updateReservationRoomPositions($entityID)
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
		$query = "SELECT ReservationRoomID, OptionPosition FROM ReservationRoom WHERE ReservationRoomID>0 ORDER BY OptionPosition ASC";			
		$rs = $DS->query($query);
		$i=2;
		foreach($rs as $row)
		{
			$DS->query("UPDATE ReservationRoom SET OptionPosition='$i' WHERE ReservationRoomID='".$row['ReservationRoomID']."'");
			$i = $i+2;
		}
		//return $result;		
	}	
	
}
?>
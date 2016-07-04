<?php
//XCMSPro: Web Service entity class
class ReservationRoomServices
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
	function ReservationRoomServices()
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
    
	function getReservationOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomServices.getReservationServicess.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];

		$query = "SELECT * FROM ReservationOrder WHERE ReservationOrderID = '".$input['ReservationOrderID']."'";
		
		$result = $DS->query($query); 
		
		$SERVER->setDebug('ReservationRoomServices.getReservationServicess.End','End');
		return $result;
	}
	
	
	function getReservationRoomServices($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomServices.getReservationServicess.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];

		$query = "SELECT * FROM ReservationRoomServices WHERE ReservationOrderID = '".$input['ReservationOrderID']."'";
		
		$result = $DS->query($query); 
		
		$SERVER->setDebug('ReservationRoomServices.getReservationServicess.End','End');
		return $result;
	}
	
	
	function setReservationRoomServices($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];

		for ($i=$input['date_arrival']; $i<=$input['date_departure']; $i++)
		{
			$checkServices = $DS->query("SELECT * FROM ReservationRoomServices WHERE 
                    ReservationOrderID = '".input('ReservationOrderID')."' AND ReservationRoomServicesDate = '".$i."'");
			if (!empty($checkServices))
			{
				$DS->query("UPDATE ReservationRoomServices SET ReservationServicesFirst = '".input('ReservationServicesFirst'.$i)."', ReservationServicesSecond = '".input('ReservationServicesSecond'.$i)."', ReservationServicesThird = '".input('ReservationServicesThird'.$i)."', ReservationServicesFourth = '".input('ReservationServicesFourth'.$i)."' WHERE ReservationRoomServicesDate = '".$i."';");
			}
			else 
			{
				if (input('ReservationServicesFirst'.$i) != '') {
				    $DS->query("INSERT INTO ReservationRoomServices(ReservationRoomServicesID, UserID, OwnerID, ReservationOrderID, ReservationRoomServicesDate, ReservationServicesFirst, ReservationServicesSecond, ReservationServicesThird, ReservationServicesFourth) VALUES('', '".user('UserID')."', '".user('OwnerID')."', '".input('ReservationOrderID')."', '".$i."', '".input('ReservationServicesFirst'.$i)."', '".input('ReservationServicesSecond'.$i)."', '".input('ReservationServicesThird'.$i)."', '".input('ReservationServicesFourth'.$i)."')");
				}
			}
		}
	}
} // end of ReservationServicesServer
?>
<?php
//XCMSPro: Web Service entity class
class ReservationStatisticClass
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
	function ReservationStatisticClass()
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
    function getReservationStatistics($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationStatisticClass.getReservationStatistics.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}

		$query = "SELECT * FROM ReservationOrder";
		
		$result = $DS->query($query); 
		
		$SERVER->setDebug('ReservationStatisticClass.getReservationStatistics.End','End');
		return $result;
	}
    
	function getReservationStatisticsArrival($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationStatisticClass.getReservationStatistics.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}

		$query = "SELECT * FROM ReservationOrder WHERE ReservationOrderArrival >= '".date('Y-m-d', mktime(0, 0, 0, $input['month'], $input['date'], $input['year']))."' AND ReservationOrderArrival < '".date('Y-m-d', mktime(0, 0, 0, $input['month'], $input['date']+6, $input['year']))."'";
		
		$result = $DS->query($query); 
		
		$SERVER->setDebug('ReservationStatisticClass.getReservationStatistics.End','End');
		return $result;
	}

	function getReservationStatisticsDeparture($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationStatisticClass.getReservationStatistics.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}

		$query = "SELECT * FROM ReservationOrder WHERE ReservationOrderDeparture >= '".date('Y-m-d', mktime(0, 0, 0, $input['month'], $input['date'], $input['year']))."' AND ReservationOrderDeparture < '".date('Y-m-d', mktime(0, 0, 0, $input['month'], $input['date']+6, $input['year']))."'";
		
		$result = $DS->query($query); 
		
		$SERVER->setDebug('ReservationStatisticClass.getReservationStatistics.End','End');
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

		$query = "SELECT * FROM ReservationRoomServices";
		
		$result = $DS->query($query); 

		return $result;
	}
	
	function getReservationRooms($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomServices.getReservationServicess.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];

		$query = "SELECT * FROM ReservationRoom";
		
		$result = $DS->query($query); 

		return $result;
	}
} // end of ReservationStatisticServer
?>
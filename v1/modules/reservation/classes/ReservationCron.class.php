<?php
//XCMSPro: Web Service entity class
class ReservationCronClass
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
	function ReservationCronClass()
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


    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteReservationCron($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationCronClass.deleteReservationCron.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		
		$deadline = date('Y-m-d H:i:s');
		//echo $deadline;

		//$query = "SELECT * FROM ReservationOrder";
		$query = "DELETE FROM ReservationOrder WHERE ReservationOrderOptionDeadline < '".$deadline."' AND ReservationOrderOptionDeadline != '0000-00-00 00:00:00'";
		
		//$result = $DS->query($query); 

		return $result;	
	}	
} // end of ReservationCronerver
?>
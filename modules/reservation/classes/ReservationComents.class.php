<?php
//XCMSPro: Web Service entity class
class ReservationComentClass
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
	function ReservationComentClass()
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


	function getReservationComent($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationComentClass.getReservationComent.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables

		$query = "SELECT * FROM ReservationOrder WHERE ReservationOrderID = '".$input['ReservationOrder'.DTR.'ReservationOrderID']."'"; 

		$result = $DS->query($query);	

		return $result;		
	}
	
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setReservationComent($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationComentClass.setReservationComent.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables

		$entityID = $input['ReservationOrder'.DTR.'ReservationOrderID'];
		$where['ReservationOrder'] = "ReservationOrderID = '".$entityID."'";
		
		if($input['actionMode']=='save')
		{
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
		}

		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ReservationComentClass.setReservationComent.msg.DataSaved');
		}
		
		$SERVER->setDebug('ReservationComentClass.setReservationComent.End','End');		
		return $result;		
	}

    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	

} // end of ReservationComentserver
?>
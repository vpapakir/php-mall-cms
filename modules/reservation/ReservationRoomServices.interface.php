<?php
//XCMSPro: ReservationServices entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageReservationRoomServices()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservationServicesID'];		
	$ReservationRoomServices = new ReservationRoomServices();

	if($input['actionMode']=='save')
	{
		if(empty($user['UserFieldsID']))
		{
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');
		}
		$ReservationRoomServices->setReservationRoomServices($input);
	}	
	
	$result['DB']['ReservationRoomServices'] = $ReservationRoomServices->getReservationRoomServices($input);
	
	$result['DB']['ReservationOrder'] = $ReservationRoomServices->getReservationOrder($input);
	
	$result['DB']['ReservationRooms'] = $ReservationRoomServices->getReservationRooms($input);

	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

?>
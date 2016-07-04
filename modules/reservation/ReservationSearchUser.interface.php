<?php
//XCMSPro: ReservationSearchUser entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageReservationSearchUsers()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservationSearchUserID'];
	//creat objects			
	$ReservationSearchUser = new ReservationSearchUserClass();

	//get content

	if (!empty($input['searchUser']))
	{
		$ReservationUserFieldsRS = $ReservationSearchUser->getReservationUserFields($input);
	    $result['DB']['ReservationUserFields'] = $ReservationUserFieldsRS;
	    
	    $ReservationSearchUserEmailRS = $ReservationSearchUser->getReservationSearchUserEmail($input);
	    $result['DB']['ReservationSearchUser'] = $ReservationSearchUserEmailRS;
	    
	    $result['DB']['ReservationOrders'] = $ReservationSearchUser->getReservationOrders($input);
	}

	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}?>
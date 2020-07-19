<?php
//XCMSPro: ReservationCron entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageReservationCron()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservationCronID'];
	//creat objects			
	$ReservationCron = new ReservationCronClass();
	
	//get content

    //$ReservationCron->deleteReservationCron($input);

	$ReservationCron->deleteReservationCron($input);
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}
?>
<?php
//XCMSPro: ReservationStatistic entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageReservationStatistics()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservationStatisticID'];		
	$ReservationStatistic = new ReservationStatisticClass();
	
	$result['DB']['ReservationStatistics'] = $ReservationStatistic->getReservationStatistics($input);

	$result['DB']['ReservationStatisticsArrival'] = $ReservationStatistic->getReservationStatisticsArrival($input);
	
	$result['DB']['ReservationStatisticsDeparture'] = $ReservationStatistic->getReservationStatisticsDeparture($input);
	
	$result['DB']['ReservationRoomServices'] = $ReservationStatistic->getReservationRoomServices($input);
	
	$result['DB']['ReservationRooms'] = $ReservationStatistic->getReservationRooms($input);

	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

?>
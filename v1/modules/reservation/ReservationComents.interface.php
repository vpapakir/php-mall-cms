<?php
//XCMSPro: ReservationComent entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/
function manageReservationComents()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservationComentID'];
	//creat objects			
	$ReservationComent = new ReservationComentClass();

	//get content
	
	if($input['actionMode']=='save')
	{
		$ReservationComent->setReservationComent($input);
	}

	$result['DB']['ReservationComent'] = $ReservationComent->getReservationComent($input);
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}
?>
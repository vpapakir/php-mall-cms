<?php
//Section entity WebService public methods
function manageReservationRooms()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservationRoomTaskID'];
	$DS = new DataSource('main');
	//creat objects			
	$ReservationRooms = new ReservationRoomsClass();

	//get content
	
	if($input['actionMode']=='deletefile')
	{
		if(!empty($input['ReservationRoom'.DTR.'ReservationRoomID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ReservationRoom WHERE ReservationRoomID='".$input['ReservationRoom'.DTR.'ReservationRoomID']."'");
			//print_r($fileFieldRS);
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			$input['ReservationRoom'.DTR.$fileField]=' ';

			$input['actionMode']='saveRoom';

			$ReservationRooms->setReservationRoom($input);
		}
	}
	
	if($input['actionMode']=='deleteRoom')
	{
		$ReservationRooms->deleteReservationRoom($input);
	}
	
	if($input['actionMode']=='addRoom' || $input['actionMode']=='saveRoom')
	{
		$ReservationRooms->setReservationRoom($input);
	}
	
	if(!empty($input['ReservationRoom'.DTR.'ReservationRoomID']) || !empty($input['ReservationRoom'.DTR.'OptionCode']))
	{
		$result['DB']['ReservationRoom'] = $ReservationRooms->getReservationRoom($input);
	}

	$result['DB']['ReservationRooms'] = $ReservationRooms->getReservationRooms($input);	
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}
?>
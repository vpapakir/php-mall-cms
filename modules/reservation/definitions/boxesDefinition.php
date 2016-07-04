<?
	//boxes defintion
	$boxesDefinition['reservation.manageReservationOrders'] = array(
	'name'=>'Manage reservation reservationOrders',
	'type'=>'admin',
	'module'=>'reservation',
	'method'=>'manageReservationOrders',
	'template'=>'manageReservationOrders');
	
	$boxesDefinition['reservation.manageReservationCron'] = array(
	'name'=>'Manage reservation reservationCron',
	'type'=>'admin',
	'module'=>'reservation',
	'method'=>'manageReservationCron',
	'template'=>'manageReservationCron');
	
	$boxesDefinition['reservation.manageReservationRooms'] = array(
	'name'=>'Manage reservation reservationRooms',
	'type'=>'admin',
	'module'=>'reservation',
	'method'=>'manageReservationRooms',
	'template'=>'manageReservationRooms');
	
	$boxesDefinition['reservation.manageReservationRoomTasks'] = array(
	'name'=>'Manage reservation reservationRoomTasks',
	'type'=>'admin',
	'module'=>'reservation',
	'method'=>'manageReservationRoomTasks',
	'template'=>'manageReservationRoomTasks');
	
	$boxesDefinition['reservation.manageReservationComents'] = array(
	'name'=>'Manage reservation ReservationComents',
	'type'=>'admin',
	'module'=>'reservation',
	'method'=>'manageReservationComents',
	'template'=>'manageReservationComents');
	
	$boxesDefinition['reservation.manageReservationSearchUsers'] = array(
	'name'=>'Manage reservation reservationSearchUsers',
	'type'=>'admin',
	'module'=>'reservation',
	'method'=>'manageReservationSearchUsers',
	'template'=>'manageReservationSearchUsers');
	
	$boxesDefinition['reservation.manageReservationStatistics'] = array(
	'name'=>'Manage reservation reservationStatistics',
	'type'=>'admin',
	'module'=>'reservation',
	'method'=>'manageReservationStatistics',
	'template'=>'manageReservationStatistics');
	
	$boxesDefinition['reservation.manageReservationRoomServices'] = array(
	'name'=>'Manage reservation reservationRoomServices',
	'type'=>'admin',
	'module'=>'reservation',
	'method'=>'manageReservationRoomServices',
	'template'=>'manageReservationRoomServices');
	
	$boxesDefinition['reservation.reservationMailbox'] = array(
	'type'=>'admin',
	'name'=>'Reservation Mail Box',
	'module'=>'reservation',
	'template'=>'reservationMailbox');
	

	$boxesDefinition['loan.getReservationOrderLogRecords'] = array(
	'name'=>'View reservation order mirror log recortds',
	'type'=>'admin',
	'module'=>'reservation',
	'method'=>'getReservationOrderLog',
	'template'=>'vewReservationOrderLog');	
		
	//---------front end--------------------------------------------------------------------
	

	$boxesDefinition['reservation.UserReservationOrders'] = array(
	'name'=>'User reservation reservationOrders',
	'type'=>'front',
	'module'=>'reservation',
	'method'=>'manageReservationOrders',
	'template'=>'UserReservationOrders');
	
	$boxesDefinition['reservation.UserReservationOrdersResult'] = array(
	'name'=>'User reservation reservationOrdersResult',
	'type'=>'front',
	'module'=>'reservation',
	'method'=>'manageReservationOrders',
	'template'=>'UserReservationOrders');
	
	$boxesDefinition['reservation.UserReservationOrdersNoResult'] = array(
	'name'=>'User reservation reservationOrdersNoResult',
	'type'=>'front',
	'module'=>'reservation',
	'method'=>'manageReservationOrders',
	'template'=>'UserReservationOrders');	
	
	$boxesDefinition['reservation.EmptyReservationOrders'] = array(
	'name'=>'Empty reservation box',
	'type'=>'front',
	'module'=>'reservation',
	'method'=>'',
	'template'=>'');		
?>
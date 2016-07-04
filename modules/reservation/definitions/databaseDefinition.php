<?
	$databaseDefinition['t']['ReservationOrder']='ReservationOrderID,ReservationOrderAlias,UserID,OwnerID,GroupID,PermAll,ReservationOrderArrival,ReservationOrderDeparture,ReservationOrderRooms,ReservationOrderType,ReservationOrderClientType,ReservationOrderComents,ReservationOrderOptionDeadline,ReservationOrderOptionValid,ReservationOrderLinen,ReservationOrderSatelliteTV,ReservationOrderCarType,ReservationOrderSecondDriver,ReservationOrderBabySeat,ReservationOrderChildrenSeat,ReservationOrderObservations,ReservationOrderAirportArrival,ReservationOrderArrivalNumber,ReservationOrderAirportDeparture,ReservationOrderDepartureNumber,ReservationOrderFidelityCardNumber,ReservationOrderSesameCardNumber,ReservationOrderHowFind,ReservationOrderWhoProposed';
	$databaseDefinition['k']['ReservationOrder']='ReservationOrderID';
	$databaseDefinition['langs']['ReservationOrder']['ReservationOrderContent']='infield';	
	$databaseDefinition['langs']['ReservationOrder']['ReservationOrderIntro']='infield';	
	$databaseDefinition['langs']['ReservationOrder']['ReservationOrderTitle']='infield';		

	$databaseDefinition['t']['ReservationOrderLog']='ReservationOrderLogID,ReservationOrderLogTimeCreated,ReservationOrderLogUserID,ReservationOrderLogAction,ReservationOrderID,ReservationOrderAlias,UserID,OwnerID,GroupID,PermAll,ReservationOrderArrival,ReservationOrderDeparture,ReservationOrderRooms,ReservationOrderType,ReservationOrderClientType,ReservationOrderComents,ReservationOrderOptionDeadline,ReservationOrderOptionValid,ReservationOrderLinen,ReservationOrderSatelliteTV,ReservationOrderCarType,ReservationOrderSecondDriver,ReservationOrderBabySeat,ReservationOrderChildrenSeat,ReservationOrderObservations,ReservationOrderAirportArrival,ReservationOrderArrivalNumber,ReservationOrderAirportDeparture,ReservationOrderDepartureNumber,ReservationOrderFidelityCardNumber,ReservationOrderSesameCardNumber,ReservationOrderHowFind,ReservationOrderWhoProposed';
	$databaseDefinition['k']['ReservationOrderLog']='ReservationOrderLogID';
	$databaseDefinition['langs']['ReservationOrderLog']['ReservationOrderContent']='infield';	
	$databaseDefinition['langs']['ReservationOrderLog']['ReservationOrderIntro']='infield';	
	$databaseDefinition['langs']['ReservationOrderLog']['ReservationOrderTitle']='infield';		

	
    $databaseDefinition['t']['ReservationRoomTask']='ReservationRoomTaskID,ReservationRoomTaskAlias,UserID,OwnerID,PermAll,ReservationOrderTitle,ReservationOrderIntro,ReservationOrderContent,ReservationRoomTaskCreate,ReservationRoomTaskRoomID,ReservationRoomTaskTaskName,ReservationRoomTaskStatus,ReservationRoomTaskRoomDescription';
	$databaseDefinition['k']['ReservationRoomTask']='ReservationRoomTaskID';
	
    $databaseDefinition['t']['ReservationRoom']='ReservationRoomID,OptionCode,UserID,OwnerID,TimeCreated,TimeSaved,OptionName,OptionIcon,OptionPosition,OptionReflection,OptionDescription,OptionMinOccupation,OptionMaxOccupation,OptionMaxChildren,OptionRoomUrl,OptionRoomTarget,OptionRoomType';
	$databaseDefinition['k']['ReservationRoom']='ReservationRoomID';
	$databaseDefinition['langs']['ReservationRoom']['OptionName']='infield';	
	$databaseDefinition['langs']['ReservationRoom']['OptionDescription']='infield';
	$databaseDefinition['langs']['ReservationRoom']['OptionRoomUrl']='infield';
	
	$databaseDefinition['t']['ReservationOrderStat']='ReservationOrderStatID,ReservationOrderStatMonth,ReservationOrderStatYear,ReservationOrderStatProcent';
	$databaseDefinition['k']['ReservationOrderStat']='ReservationOrderStatID';
?>
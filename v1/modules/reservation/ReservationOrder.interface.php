<?php
//XCMSPro: ReservationOrder entity WebService public methods
/**
* Add, Edit and delete entities. Only for back-end interface
*
* @param	array	$in			variables sent from client
* @return 	string 				XML result
* @access	public
*/


function manageReservationOrders()
{
	global $CORE;
	//get input

	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservationOrderID'];
	$DS = new DataSource('main');
	
	//die('ffffgggfgfg');
	//creat objects			
	$ReservationOrder = new ReservationOrderClass();
	
			//if($input['UseCAPTCHA']==1)
			//{
			if($input['actionMessageMode']=='send'){
				$CAPTCHA = $CORE->callService("validateCaptchaCode", "antispamServer", $input);
				if(!$CAPTCHA) 
				{
					$parentID=$input['ParentSID'];
					$input='';
					$CORE->setInputVar('actionMessageMode','');
					$CORE->setInputVar('SID',$parentID);
					$input['SID']=$parentID;
					$CORE->setInputVar('CAPTCHA','-CAPTCHA_wrong_Code');
					$input['CAPTCHA']='-CAPTCHA_wrong_Code';
				}
			}


	if(eregi("http",$input['MessageTextEmail'])) return false;
	if(eregi("http",$input['MessageTextFirstName'])) return false;
	if(eregi("http",$input['MessageTextTitle'])) return false;
	if(eregi("http",$input['MessageTextFirstName'])) return false;
	if(eregi("http",$input['MessageTextLastName'])) return false;
	if(eregi("http",$input['MessageTextAddress'])) return false;
	if(eregi("http",$input['MessageTextCompany'])) return false;
	if(eregi("http",$input['MessageTextZip'])) return false;
	if(eregi("http",$input['MessageTextCountry'])) return false;
	if(eregi("http",$input['MessageTextPhone'])) return false;
	if(eregi("http",$input['MessageTextFax'])) return false;
	if(eregi("http",$input['MessageTextMobile'])) return false;
	if(eregi("http",$input['MessageTextTown'])) return false;
	if(eregi("http",$input['MessageTextNumberPersons'])) return false;
	if(eregi("http",$input['MessageTextNumberChildren'])) return false;
	if(eregi("http",$input['MessageTextObservations'])) return false;
	if(eregi("http",$input['MessageTextYourComments'])) return false;
	if(eregi("http",$input['MessageTextFidelityCardNumber'])) return false;
	if(eregi("http",$input['MessageTextSesameCardNumber'])) return false;
	if(eregi("http",$input['MessageTextWhoProposed'])) return false;
	//creat objects			
	$Message = new MessageClassReservation();
	//get content
	if($input['actionMessageMode']=='send'){
		//$input['Message'.DTR.'MessageText'] = ;
		//echo $userID;
		
	    $result['DB']['UserFields'] = $ReservationOrder->getReservationSearchUserEmail($input);
	    $result['DB']['ReservationFields'] = $ReservationOrder->getReservationReservationFields($input);
	    //print_r($result['DB']['UserFields']);
	    echo '<br><br>';
	    //print_r($result['DB']['ReservationFields']);
	    
	    if (!empty($result['DB']['UserFields'][0]['UserID']))
	    {
	    	//$userID = $result['DB']['ReservationSearchUser'][0]['UserID'];
	    	$input['MessageTextTitle'] = $result['DB']['UserFields'][0]['Title'];
	    	$input['MessageTextFirstName'] = $result['DB']['UserFields'][0]['FirstName'];
	    	$input['MessageTextLastName'] = $result['DB']['UserFields'][0]['LastName'];
	    	$input['MessageTextCompany'] = $result['DB']['UserFields'][0]['CompanyName'];
	    	$input['MessageTextAddress'] = $result['DB']['UserFields'][0]['Address'];
	    	$input['MessageTextTown'] = $result['DB']['UserFields'][0]['City'];
	    	$input['MessageTextCountry'] = $result['DB']['UserFields'][0]['Country'];
	    	$input['MessageTextZip'] = $result['DB']['UserFields'][0]['PostalCode'];
	    	$input['MessageTextPhone'] = $result['DB']['UserFields'][0]['Phone'];
	    	$input['MessageTextFax'] = $result['DB']['UserFields'][0]['Fax'];
	    	$input['MessageTextMobile'] = $result['DB']['UserFields'][0]['Mobile'];

	    	//$input['MessageTextDateArrival'] = $input['ReservationOrder'.DTR.'ReservationOrderArrival'];
	    	//$input['MessageTextDateDeparture'] = $input['ReservationOrder'.DTR.'ReservationOrderDeparture'];
	    	//$input['MessageTextRoomName'] = $input['MessageTextRoomName'];
	    	//$input['MessageTextNumberPersons'] = $input['MessageTextNumberPersons'];
	    	//$input['MessageTextNumberChildren'] = $input['MessageTextNumberChildren'];
	    	$input['MessageTextLinen'] = $result['DB']['ReservationFields'][0]['ReservationOrderLinen'];
	    	$input['MessageTextSatelliteTV'] = $result['DB']['ReservationFields'][0]['ReservationOrderSatelliteTV'];
	    	$input['MessageTextCarType'] = $result['DB']['ReservationFields'][0]['ReservationOrderCarType'];
	    	$input['MessageTextSecondDriver'] = $result['DB']['ReservationFields'][0]['ReservationOrderSecondDriver'];
			$input['MessageTextBabySeat'] = $result['DB']['ReservationFields'][0]['ReservationOrderBabySeat'];
	    	$input['MessageTextChildrenSeat'] = $result['DB']['ReservationFields'][0]['ReservationOrderChildrenSeat'];
	    	$input['MessageTextObservations'] = $result['DB']['ReservationFields'][0]['ReservationOrderObservations'];
	    	$input['MessageTextAirportArrival'] = $result['DB']['ReservationFields'][0]['ReservationOrderAirportArrival'];
	    	$input['MessageTextArrivalNumber'] = $result['DB']['ReservationFields'][0]['ReservationOrderArrivalNumber'];
	    	$input['MessageTextAirportDeparture'] = $result['DB']['ReservationFields'][0]['ReservationOrderAirportDeparture'];
	    	$input['MessageTextDepartureNumber'] = $result['DB']['ReservationFields'][0]['ReservationOrderDepartureNumber'];
	    	$input['MessageTextFidelityCardNumber'] = $result['DB']['ReservationFields'][0]['ReservationOrderFidelityCardNumber'];
	    	$input['MessageTextSesameCardNumber'] = $result['DB']['ReservationFields'][0]['ReservationOrderSesameCardNumber'];
	    	$input['MessageTextHowFind'] = $result['DB']['ReservationFields'][0]['ReservationOrderHowFind'];
	    	$input['MessageTextWhoProposed'] = $result['DB']['ReservationFields'][0]['ReservationOrderWhoProposed'];
	    }
	    //echo $result['DB']['ReservationSearchUser'][0]['UserID'];


		if(empty($userID) && empty($result['DB']['UserFields'][0]['UserID']))
		{
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->setInputVar('User'.DTR.'Email',$input['MessageTextEmail']);
			$CORE->setInputVar('User'.DTR.'Password',$input['MessageTextPassword']);
			$CORE->setInputVar('User'.DTR.'UserName',$input['MessageTextFirstName']);
			$CORE->setInputVar('UserField'.DTR.'Title',$input['MessageTextTitle']);
			$CORE->setInputVar('UserField'.DTR.'FirstName',$input['MessageTextFirstName']);
			$CORE->setInputVar('UserField'.DTR.'LastName',$input['MessageTextLastName']);
			$CORE->setInputVar('UserField'.DTR.'Address',$input['MessageTextAddress']);
			$CORE->setInputVar('UserField'.DTR.'CompanyName',$input['MessageTextCompany']);
			$CORE->setInputVar('UserField'.DTR.'PostalCode',$input['MessageTextZip']);
			$CORE->setInputVar('UserField'.DTR.'Country',$input['MessageTextCountry']);
			$CORE->setInputVar('UserField'.DTR.'Phone',$input['MessageTextPhone']);
			$CORE->setInputVar('UserField'.DTR.'Fax',$input['MessageTextFax']);
			$CORE->setInputVar('UserField'.DTR.'Mobile',$input['MessageTextMobile']);
			$CORE->setInputVar('UserField'.DTR.'City',$input['MessageTextTown']);

			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderLinen',$input['MessageTextLinen']);		
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderSatelliteTV ',$input['MessageTextSatelliteTV']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderCarType ',$input['MessageTextCarType']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderSecondDriver ',$input['MessageTextSecondDriver']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderBabySeat',$input['MessageTextBabySeat']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderChildrenSeat',$input['MessageTextChildrenSeat']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderObservations',$input['MessageTextObservations']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderAirportArrival',$input['MessageTextAirportArrival']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderArrivalNumber',$input['MessageTextArrivalNumber']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderAirportDeparture',$input['MessageTextAirportDeparture']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderDepartureNumber',$input['MessageTextDepartureNumber']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderFidelityCardNumber',$input['MessageTextFidelityCardNumber']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderSesameCardNumber',$input['MessageTextSesameCardNumber']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderHowFind',$input['MessageTextHowFind']);
			$CORE->setInputVar('ReservationOrder'.DTR.'ReservationOrderWhoProposed',$input['MessageTextWhoProposed']);
			
			$input = $CORE->getInput();
			
			
			$CORE->callService('doLogin','sessionServer');	

			$user = $CORE->getUser();
			$userID = $user['UserID'];
			//echo "#".$userID."#";
		}
		
		if(empty($userID) || $userID==1)
		{
			$userRS = $DS->query("SELECT UserID FROM User WHERE Email ='".$input['MessageTextEmail']."'");
			$userID = $userRS[0]['UserID'];
			$input['ReservationOrder'.DTR.'UserID'] = $userID;
			$input['Message'.DTR.'UserID'] = $userID;
			$CORE->setInputVar('Message'.DTR.'UserID',$userID);
			$CORE->setInputVar('ReservationOrder'.DTR.'UserID',$userID);
		}		
				
		$input['DateArrival'] = date('d-m-Y',mktime(0, 0, 0, $input['ReservationOrder'.DTR.'ReservationOrderArrival_month'], $input['ReservationOrder'.DTR.'ReservationOrderArrival_day'], $input['ReservationOrder'.DTR.'ReservationOrderArrival_year']));
		$input['DateDeparture'] = date('d-m-Y',mktime(0, 0, 0, $input['ReservationOrder'.DTR.'ReservationOrderDeparture_month'], $input['ReservationOrder'.DTR.'ReservationOrderDeparture_day'], $input['ReservationOrder'.DTR.'ReservationOrderDeparture_year']));

		$input['Message'.DTR.'MessageText'] .= lang('RequestedDateArrival.reservation.tip').": ".$input['DateArrival']."\n";
		$input['Message'.DTR.'MessageText'] .= lang('RequestedDateDeparture.reservation.tip').": ".$input['DateDeparture']."\n";

		$input['Message'.DTR.'MessageText'] .= lang('RequestedPersons.reservation.tip').": ".$input['total_persons']."\n";

		$input['Message'.DTR.'MessageText'] .= lang('RequestedChildren.reservation.tip').": ".$input['children']."\n";
				
		if(!empty($input['MessageTextAppartement'])) $input['Message'.DTR.'MessageText'] = 'Appartment: '.$input['MessageTextAppartement']."\n";

		
		foreach($input as $key=>$value){
			if(eregi('MessageText',$key)){
				$key = str_replace("MessageText","",$key);
				if(is_array($value)){
					foreach($value as $row){
						$varray .= $row."\n";
					}
					$value = $varray;
				}
					
				if(trim($value) && $key!='Message'.DTR)
				{
					$input['Message'.DTR.'MessageText'] .= lang('Requested'.$key.'.reservation.tip').": ".$value."\n";
				}
				/*if($key=='Appartement'){
					 $input['Message'.DTR.'MessageText'] .= "DateArrival: ".$input['DateArrival']."\n";
					 $input['Message'.DTR.'MessageText'] .= "DateDeparture: ".$input['DateDeparture']."\n";
				}*/
			}
		}
		
		
		
		//send email to admin
		$emailIN['MailTo'] = $config['SiteMail'];
		
		//$emailIN['MailTo'] = 'ac@abtsolutions.net';
		
		$emailIN['MailToName'] = $config['SiteName'];
		$emailIN['MailFrom'] =$input['MessageTextEmail'];
		$emailIN['MailFromName'] =$input['MessageTextFirstName'].' '.$input['MessageTextLastName'];
		$emailIN['MailData']['SenderName'] = $emailIN['MailFrom'];
		$emailIN['MailData']['UserID'] = $input['Message'.DTR.'UserID'];
		$emailIN['MailData']['Message'] = nl2br($input['Message'.DTR.'MessageText']);
		$emailIN['MailTemplate'] = 'reservationNewRequest.admin';
		$CORE->callService('sendMail','mailServer',$emailIN);					


		$Message->setMessage($input);
	}

		//print_r($input);
		//die('ddd');	
	
	
	

	//get content
	if($input['actionMode']=='delete')
	{
		$resultDelete = $ReservationOrder->deleteReservationOrder($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['ReservationOrder'.DTR.'ReservationOrderID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ReservationOrder WHERE ReservationOrderID='".$input['ReservationOrder'.DTR.'ReservationOrderID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			$input['ReservationOrder'.DTR.$fileField]=' ';
			$input['actionMode']='save';
			$resourceObject->setReservationOrder($input);
		}
	}
	elseif($input['actionMode']=='save' || $input['actionMode']=='add' || $input['actionMode']=='save1')
	{
		if(empty($user['UserFieldsID']))
		{
			$CORE->setInputVar('User'.DTR.'GroupID','user');
			$CORE->setInputVar('registrationMode','Y');
			$CORE->setInputVar('redirectionMode','N');
			$CORE->callService('doLogin','sessionServer');
		}
		
		//$CORE->setConfigVar("UseImageResize",'Y');
		$CORE->setConfigVar("UseImagePreview",'N');
		$CORE->setConfigVar("UseImageIcon",'Y');		
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		
		if(!empty($uploadRS['ReservationOrderImage']['icon']))
		{
			$input['ReservationOrder'.DTR.'ReservationOrderImage']= $uploadRS['ReservationOrderImage']['file'];
			$input['ReservationOrder'.DTR.'ReservationOrderIcon']= $uploadRS['ReservationOrderImage']['icon'];
		}
	    $resultSet = $ReservationOrder->setReservationOrder($input);
		
		
		
		
		
		
		
		
		
		if (!empty($resultSet)) 
		{
			$result['DB']['ReservationRooms'] = $ReservationOrder->getReservationRooms($input);
	        $result['DB']['ReservationOrders'] = $ReservationOrder->getReservationOrders($input);
			//print_r($input);
$reservation_rooms = 0;
$all_rooms = 0;
$all_remarks_rooms = 0;
$unavailable_rooms = 0;
$rooms_info = 0;
foreach($result['DB']['ReservationRooms'] as $array) {
	if ($array['OptionRoomType'] == 'info') {
		$rooms_info++;
	}
            for($number=1; $number<=date("t", mktime(0, 0, 0, $input[ReservationOrder.DTR.ReservationOrderArrival_month], 01, $input[ReservationOrder.DTR.ReservationOrderArrival_year])); $number++) {
      	        $date_arrival = date("Y-m-d", mktime(0, 0, 0, $input[ReservationOrder.DTR.ReservationOrderArrival_month], $number, $input[ReservationOrder.DTR.ReservationOrderArrival_year]));
      	        $date_departure = date("Y-m-d", mktime(0, 0, 0, $input[ReservationOrder.DTR.ReservationOrderArrival_month], $number+1, $input[ReservationOrder.DTR.ReservationOrderArrival_year]));
      	        $all_remarks_rooms = $number;
      	        $all_rooms++;
                foreach($result['DB']['ReservationOrders'] as $id=>$row) {
                    if ((($row['ReservationOrderArrival'] == $date_arrival &&
                        $row['ReservationOrderDeparture'] == $date_departure) ||
                        $row['ReservationOrderArrival'] == $date_arrival ||
                        ($row['ReservationOrderArrival'] < $date_arrival &&
                        $row['ReservationOrderDeparture'] > $date_departure) ||
                        $row['ReservationOrderDeparture'] == $date_departure) &&
                        $row['ReservationOrderRooms'] == $array['OptionCode'] &&
                        $array['OptionRoomType'] != 'info' &&
                        $row['ReservationOrderType'] == 'reservation') {
                        	$reservation_rooms++;
                    }
                    if ((($row['ReservationOrderArrival'] == $date_arrival &&
                        $row['ReservationOrderDeparture'] == $date_departure) ||
                        $row['ReservationOrderArrival'] == $date_arrival ||
                        ($row['ReservationOrderArrival'] < $date_arrival &&
                        $row['ReservationOrderDeparture'] > $date_departure) ||
                        $row['ReservationOrderDeparture'] == $date_departure) &&
                        $row['ReservationOrderRooms'] == $array['OptionCode'] &&
                        $array['OptionRoomType'] != 'info' &&
                        ($row['ReservationOrderType'] == 'unavailable' ||
                        $row['ReservationOrderType'] == 'other')) {
                        	$unavailable_rooms++;
                    }
                }
            }
}

        $all_rooms = $all_rooms - $all_remarks_rooms*$rooms_info - $unavailable_rooms;

        $input['ReservationOrderStat'.DTR.'ReservationOrderStatProcent'] = 100 / $all_rooms * $reservation_rooms;
        //echo $input['ReservationOrderStat'.DTR.'ReservationOrderStatProcent'];
        $input['ReservationOrderStat'.DTR.'ReservationOrderStatMonth'] = $input[ReservationOrder.DTR.ReservationOrderArrival_month];
        $input['ReservationOrderStat'.DTR.'ReservationOrderStatYear'] = $input[ReservationOrder.DTR.ReservationOrderArrival_year];
        //echo $input['ReservationOrderStat'.DTR.'ReservationOrderStatProcent'];
        $ReservationOrder->setReservationStat($input);
        
        
        
$reservation_rooms = 0;
$all_rooms = 0;
$all_remarks_rooms = 0;
$unavailable_rooms = 0;
$rooms_info = 0;
foreach($result['DB']['ReservationRooms'] as $array) {
	if ($array['OptionRoomType'] == 'info') {
		$rooms_info++;
	}
            for($number=1; $number<=date("t", mktime(0, 0, 0, $input[ReservationOrder.DTR.ReservationOrderDeparture_month], 01, $input[ReservationOrder.DTR.ReservationOrderDeparture_year])); $number++) {
      	        $date_arrival = date("Y-m-d", mktime(0, 0, 0, $input[ReservationOrder.DTR.ReservationOrderDeparture_month], $number, $input[ReservationOrder.DTR.ReservationOrderDeparture_year]));
      	        $date_departure = date("Y-m-d", mktime(0, 0, 0, $input[ReservationOrder.DTR.ReservationOrderDeparture_month], $number+1, $input[ReservationOrder.DTR.ReservationOrderDeparture_year]));
      	        $all_remarks_rooms = $number;
      	        $all_rooms++;
                foreach($result['DB']['ReservationOrders'] as $id=>$row) {
                    if ((($row['ReservationOrderArrival'] == $date_arrival &&
                        $row['ReservationOrderDeparture'] == $date_departure) ||
                        $row['ReservationOrderArrival'] == $date_arrival ||
                        ($row['ReservationOrderArrival'] < $date_arrival &&
                        $row['ReservationOrderDeparture'] > $date_departure) ||
                        $row['ReservationOrderDeparture'] == $date_departure) &&
                        $row['ReservationOrderRooms'] == $array['OptionCode'] &&
                        $array['OptionRoomType'] != 'info' &&
                        $row['ReservationOrderType'] == 'reservation') {
                        	$reservation_rooms++;
                    }
                    if ((($row['ReservationOrderArrival'] == $date_arrival &&
                        $row['ReservationOrderDeparture'] == $date_departure) ||
                        $row['ReservationOrderArrival'] == $date_arrival ||
                        ($row['ReservationOrderArrival'] < $date_arrival &&
                        $row['ReservationOrderDeparture'] > $date_departure) ||
                        $row['ReservationOrderDeparture'] == $date_departure) &&
                        $row['ReservationOrderRooms'] == $array['OptionCode'] &&
                        $array['OptionRoomType'] != 'info' &&
                        ($row['ReservationOrderType'] == 'unavailable' ||
                        $row['ReservationOrderType'] == 'other')) {
                        	$unavailable_rooms++;
                    }
                }
            }
}

        $all_rooms = $all_rooms - $all_remarks_rooms*$rooms_info - $unavailable_rooms;
        //echo $all_rooms.'<br>'.$reservation_rooms;
        $input['ReservationOrderStat'.DTR.'ReservationOrderStatProcent'] = 100 / $all_rooms * $reservation_rooms;
        $input['ReservationOrderStat'.DTR.'ReservationOrderStatMonth'] = $input[ReservationOrder.DTR.ReservationOrderDeparture_month];
        $input['ReservationOrderStat'.DTR.'ReservationOrderStatYear'] = $input[ReservationOrder.DTR.ReservationOrderDeparture_year];
        //echo $input['ReservationOrderStat'.DTR.'ReservationOrderStatProcent'];


        $ReservationOrder->setReservationStat($input);
		}
	}	
		
$ReservationRoomTaskRS = $ReservationOrder->getReservationRoomTask($input);
	$result['DB']['ReservationRoomTask'] = $ReservationRoomTaskRS;

	if($input['actionMode'] == 'availability')
	{
		$result['DB']['ReservationSearchRooms'] = $ReservationOrder->getReservationSearchRooms($input);
	}
	$result['DB']['ReservationRooms'] = $ReservationOrder->getReservationRooms($input);
	
	
	if(!empty($entityID) || !empty($input['TipSection']) || !empty($input['TipCode']))
	{
		$ReservationOrderRS = $ReservationOrder->getReservationOrder($input);
		$result['DB']['ReservationOrder'] = $ReservationOrderRS;
		$query = "SELECT * FROM User WHERE UserID = '".$result['DB']['ReservationOrder']['0']['UserID']."' AND  GroupID = 'root'";
		$result['DB']['CheckUser'] = $DS->query($query);
		//print_r($CheckUser);	
	}
	
	$ReservationOrder->checkReservationOption($input);
	
	$result['DB']['ReservationOrders'] = $ReservationOrder->getReservationOrders($input);
	
	$result['DB']['ReservationOrdersOptions'] = $ReservationOrder->getReservationOrdersOptions($input);
	//print_r($result['DB']['ReservationOrdersOptions']);
	
	$result['DB']['ReservationOrderStat'] = $ReservationOrder->getReservationOrderStat($input);
	
	$result['DB']['ClientMessages'] = $ReservationOrder->getClientMessages($input);
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

function manageReservationOrder()
{
	global $CORE;
	//get input
	$input = $CORE->getInput($in);
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$entityID = $input['ReservationOrderID'];
	
	//creat objects		


	$ReservationOrder = new ReservationOrderClass();
	//get content
	if($input['actionMode']=='delete')
	{
		$ReservationOrder->deleteReservationOrder($input);
	
	}	
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['ReservationOrder'.DTR.'ReservationOrderID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM ReservationOrder WHERE ReservationOrderID='".$input['ReservationOrder'.DTR.'ReservationOrderID']."'");
			$lang = $input['lang'];
			$filePath = $CORE->getValue($fileFieldRS[0][$fileField],$lang);
			$FM->deleteFile($filePath);
			$input['ReservationOrder'.DTR.$fileField]=' ';
			$input['actionMode']='save';
			$resourceObject->setReservationOrder($input);
		}
	}	
	elseif($input['actionMode']=='save' || $input['actionMode']=='add')
	{
		//$CORE->setConfigVar("UseImageResize",'Y');
		$CORE->setConfigVar("UseImagePreview",'N');
		//$CORE->setConfigVar("UseImageIcon",'Y');		
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		if(!empty($uploadRS['ReservationOrderImage']['file']))
		{
			$input['ReservationOrder'.DTR.'ReservationOrderImage']= $uploadRS['ReservationOrderImage']['file'];
			$input['ReservationOrder'.DTR.'ReservationOrderIcon']= $uploadRS['ReservationOrderImage']['icon'];
		}		
		$ReservationOrder->setReservationOrder($input);
	}	

	if(!empty($entityID) || !empty($input['TipSection']) || !empty($input['TipCode']))
	{
		$ReservationOrderRS = $ReservationOrder->getReservationOrder($input);
		$result['DB']['ReservationOrder'] = $ReservationOrderRS;	
	}
	
	$ReservationOrdersRS = $ReservationOrder->getReservationOrders($input);
	$result['DB']['ReservationOrders'] = $ReservationOrdersRS;
	
	$input['treeType']='all';
	$input['downLevels']='all';
	//$input['ReservationOrderCategoryGroup'] = $groupID;
	$categoriesRS = $sectionsObject->getReservationOrderCategoriesTree($input);
	//
	
	$k=1;		
	if(is_array($categoriesRS))
	{
		foreach($categoriesRS as $id=>$row)
		{
			if($lastLevel != $row['ReservationOrderCategoryLevel'])
			{
				$lastLevel = $row['ReservationOrderCategoryLevel'];
				$treeString='';
				if($row['ReservationOrderCategoryLevel']!=1)
				{
					for($i=2;$i<=$row['ReservationOrderCategoryLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
				}
			}
			//if($row['ReservationOrderCategoryID']!=$input['ReservationOrderCategoryID'])
			//{
				$inputValues[$k]['id']=$row['ReservationOrderCategoryID'];	
				$inputValues[$k]['value']=$treeString.getValue($row['ReservationOrderCategoryTitle']);
				$k++;		
			//}
			//echo 'i= '.$i.' id= '.$row['ResourceCategoryID'].' name='.$inputValues[$i]['value'].'<hr>';
		}
	}
	$result['DB']['ReservationOrderCategories'] = $inputValues;
	//$input['treeType']='all';
	//$input['downLevels']='all';
	//$input['SectionGroup'] = 'main';
	//$sectionsRS = $CORE->callService('getSectionsTreeList','coreServer',$input);
	//$result['DB']['SectionsList'] = $sectionsRS['DB']['SectionsList'];

	//print_r($result['DB']['SectionsList']);
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	
	return $result;
}

function getReservationOrder()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$ReservationOrderObject = new ReservationOrderClass();
	$rs = $ReservationOrderObject->getReservationOrder($input);
	$result['DB']['ReservationOrder'] = $rs[0];
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages']= $languagesList;
	/*
	$ReservationOrderCategory = new ReservationOrderCategoryClass();
	$CORE->setInputVar('ReservationOrderType',$rs[0]['ReservationOrderType']);	
	$CORE->setInputVar('type',$rs[0]['ReservationOrderType']);
	$typesRS = $ReservationOrderCategory->getReservationOrderCategoryTypes($input);	
	$result['DB']['ReservationOrderCategoryTypes'] = $typesRS;		
	*/
	//print_r($result);	
	return $result;
}

function getReservationOrderLog()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	$DS = new DataSource('main');
	
	//creat objects			
	$ReservationOrderObject = new ReservationOrderClass();

	$deletedRecords = $DS->query("SELECT  ReservationOrderID, ReservationOrderLogTimeCreated, ReservationOrderClientType FROM  ReservationOrderLog WHERE ReservationOrderLogAction='deleted' GROUP BY ReservationOrderID ORDER BY  ReservationOrderLogTimeCreated DESC");
	$result['DB']['ReservationOrderLogDeletedRecords'] = $deletedRecords;
	
	$entityID = $input['ReservationOrderID'];
	$rs = $ReservationOrderObject->getReservationOrder($input);
	$result['DB']['ReservationOrder'] = $rs[0];
	
	$records = $DS->query("SELECT  ReservationOrderLogID, ReservationOrderLogTimeCreated FROM  ReservationOrderLog WHERE ReservationOrderID='".$entityID."' ORDER BY  ReservationOrderLogTimeCreated DESC");
	$result['DB']['ReservationOrderLogRecords'] = $records;
	
	$requestedLogID = $input['RequestedLogID'];
	if(empty($requestedLogID)) {$requestedLogID = $records[0]['ReservationOrderLogID'];}
	
	$logRS = $DS->query("SELECT * FROM ReservationOrderLog WHERE ReservationOrderLogID='".$requestedLogID."'");
	$result['DB']['ReservationOrderLog'] = $logRS[0];

	
	//$rsUser = $ReservationOrderObject->getReservationOrderUser($rs[0]['UserID']);
	//$result['DB']['ReservationOrderUser'] = $rsUser;
	
	return $result;
}

?>
<?php
//XCMSPro: Web Service entity class
class ReservationOrderClass
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
	function ReservationOrderClass()
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
	function getReservationOrders($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.getReservationOrders.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$searchWord = $input['searchWord'];
		$searchWord = $input['searchword1'];
		$ReservationOrderCategoryID = $input['ReservationOrderCategoryID'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservationOrderServer.adminReservationOrder');
		//if(!empty($searchWord))
		//{
			//$filter .= " AND (ReservationOrderTitle LIKE '{ls}%$searchWord%{le}' OR ReservationOrderTitle LIKE '%$searchWord%' OR ReservationOrderIntro LIKE '{ls}%$searchWord%{le}' OR ReservationOrderIntro LIKE '%$searchWord%' OR ReservationOrderContent LIKE '{ls}%$searchWord%{le}' OR ReservationOrderContent LIKE '%$searchWord%')";
		//}		
		if(!empty($searchWord))
		{
			$filter .= " AND (ReservationOrderClientType LIKE '%".$searchWord."%' OR ReservationOrderID ='".$searchWord."')";
		}		
		
		//$filter .= "OwnerID='$ownerID' ";
		if(!empty($input['ReservationOrderType']))
		{
			$filter .= " AND ReservationOrderType='".$input['ReservationOrderType']."' ";
		}
		
		/*if($input['ReservationOrderType']=='tips')
		{
			$filter .= " AND ReservationOrderType='tips' ";
		}
		else
		{
			$filter .= " AND ReservationOrderType!='tips' ";
		}*/
		if(!empty($ReservationOrderCategoryID))
		{
			$filter .= " AND ReservationOrderCategories LIKE '%|$ReservationOrderCategoryID|%' ";
		}
		if(!empty($input['ReservationOrderClientType']))
		{
			$filter .= " AND ReservationOrderClientType = '".$input['ReservationOrderClientType']."' ";
		}
		//set queries
		$query = "SELECT * FROM ReservationOrder WHERE ReservationOrderID>0 $filter ORDER BY ReservationOrderID DESC";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		$SERVER->setDebug('ReservationOrderClass.getReservationOrders.End','End');
		return $result;
	}	
	
	function getReservationOrdersOptions($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.getReservationOrder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		$entityID = $input['ReservationOrder'.DTR.'ReservationOrderID'];

	    //$result = $DS->query("SELECT * FROM ReservationOrder WHERE ReservationOrderType = 'option' AND PermAll = '4' ORDER BY ReservationOrderID");
	    $result = $DS->query("SELECT * FROM ReservationOrder WHERE ReservationOrderType = 'option' ORDER BY ReservationOrderID");
		
		return $result;
	}
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getReservationOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.getReservationOrder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['ReservationOrder'.DTR.'ReservationOrderID'];
		if(empty($entityID)) {$entityID = $input['ReservationOrderID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['ReservationOrder'];}
		if(empty($entityAlias)) {$entityAlias = $input['ReservationOrderAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['ReservationOrder'.DTR.'ReservationOrderAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['TipCode'];}
		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservationOrderServer.adminReservationOrder');
		//set queries
		$query =='';
		if(!empty($entityID))
		{
			$filter = " ReservationOrderID='$entityID' ";
		}
		elseif(!empty($entityAlias))
		{
			$filter = " ReservationOrderAlias='$entityAlias' "; 
		}
		elseif($input['ReservationOrderType']=='tips')
		{	
			if(!empty($input['TipSection']))
			{
				$filter = " ReservationOrderSections='|".$input['TipSection']."|' ";
			}
			else
			{
				$filter = " ReservationOrderSections='|".$input['SID']."|' "; 
			}
		}		
		if(!empty($filter))
		{
			$query = "SELECT * FROM ReservationOrder WHERE $filter"; 
			//get the content
			$result = $DS->query($query);	

		}
		//echo $query;
		//$SERVER->setDebug('ReservationOrderClass.getReservationOrder.End','End');	
		return $result;		
	}
	
	
	function getReservationRoomTask($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.getReservationOrder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		$entityID = $input['ReservationOrder'.DTR.'ReservationOrderID'];

		$ListReference = $DS->query("SELECT * FROM ReservationRoomTask");
		
		return $ListReference;
	}
	
	
	function getReservationSearchUserEmail($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.getReservationOrder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		$entityID = $input['ReservationOrder'.DTR.'ReservationOrderID'];

	    $result = $DS->query("SELECT * FROM UserFields WHERE UserID IN (SELECT UserID FROM User WHERE Email LIKE '%".$input['MessageTextEmail']."%')");
		
		return $result;
	}
	
	function getReservationReservationFields($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.getReservationOrder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		$entityID = $input['ReservationOrder'.DTR.'ReservationOrderID'];

	    $result = $DS->query("SELECT * FROM ReservationOrder WHERE UserID IN (SELECT UserID FROM User WHERE Email LIKE '%".$input['MessageTextEmail']."%')");
		
		return $result;
	}
	
	function getReservationRooms($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomServices.getReservationServicess.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;

		$query = "SELECT * FROM ReservationRoom ORDER BY OptionPosition";
		//echo $query ;
		$result = $DS->query($query); 

		return $result;
	}
	
	function getReservationSearchRooms($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomServices.getReservationServicess.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
        $arrival_date = input('ReservationOrder'.DTR.'ReservationOrderArrival_year').'-'.input('ReservationOrder'.DTR.'ReservationOrderArrival_month').'-'.input('ReservationOrder'.DTR.'ReservationOrderArrival_day');
	    $departure_date = input('ReservationOrder'.DTR.'ReservationOrderDeparture_year').'-'.input('ReservationOrder'.DTR.'ReservationOrderDeparture_month').'-'.input('ReservationOrder'.DTR.'ReservationOrderDeparture_day');
	    
	    //print_r($input);

	    if ($input['ReservationOrder'.DTR.'ReservationOrderArrival_day'] > date('t', @mktime(0, 0, 0, $input['ReservationOrder'.DTR.'ReservationOrderArrival_month'], 01, $input['ReservationOrder'.DTR.'ReservationOrderDeparture_year'])) || $input['ReservationOrder'.DTR.'ReservationOrderDeparture_day'] > date('t', @mktime(0, 0, 0, $input['ReservationOrder'.DTR.'ReservationOrderDeparture_month'], 01, $input['ReservationOrder'.DTR.'ReservationOrderDeparture_year']))) {
	    	$SERVER->setMessage('ReservationOrder.ReservationOrderClass.getReservationSearchRooms.err.NonexistentDate');
	    	$error=1;
	    }
	    if ((strtotime('now') - strtotime($arrival_date))/60/60 > 24) {
	    	$SERVER->setMessage('ReservationOrder.ReservationOrderClass.getReservationSearchRooms.err.LessArrivalDate');
	    	$error=1;	
	    }
	    
	    if ($departure_date <= $arrival_date) {
	    	$SERVER->setMessage('ReservationOrder.ReservationOrderClass.getReservationSearchRooms.err.IncorrectDate');
	    	$error=1;
	    }
	    if ($input['children'] > $input['total_persons']-1) {
	    	$SERVER->setMessage('ReservationOrder.ReservationOrderClass.getReservationSearchRooms.err.ManyChildren');
	    	$error=1;
	    }
	    if (empty($input['ReservationOrder'.DTR.'ReservationOrderArrival_day']) || empty($input['ReservationOrder'.DTR.'ReservationOrderArrival_month']) || empty($input['ReservationOrder'.DTR.'ReservationOrderArrival_year']) || empty($input['ReservationOrder'.DTR.'ReservationOrderDeparture_day']) || empty($input['ReservationOrder'.DTR.'ReservationOrderDeparture_month']) || empty($input['ReservationOrder'.DTR.'ReservationOrderDeparture_year'])) {
	    	$SERVER->setMessage('ReservationOrder.ReservationOrderClass.getReservationSearchRooms.err.NonexistentDateParametr');
	    	$error=1;
	    }
	    if (!is_numeric($input['total_persons']) || !is_numeric($input['children'])) {
	    	$SERVER->setMessage('ReservationOrder.ReservationOrderClass.getReservationSearchRooms.err.NotNumber');
	    	$error=1;
	    }
        if (empty($error)) {
        	$query = "SELECT * FROM ReservationRoom WHERE OptionReflection != 'hidden' AND OptionRoomType != 'info' ORDER BY OptionPosition";
        	$result = $DS->query($query);
        	return $result;
        }
		else
		{
			$SERVER->setConfigVar('RoomSearchError','Y');
		}
	}

	function getReservationRoom($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomServices.getReservationServicess.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		if (!empty($input['ReservationRoom'.DTR.'ReservationRoomID'])) {
			$query = "SELECT * FROM ReservationRoom WHERE ReservationRoomID = '".$input['ReservationRoom'.DTR.'ReservationRoomID']."'";
		} 
		elseif (!empty($input['ReservationRoom'.DTR.'OptionCode'])) {
			$query = "SELECT * FROM ReservationRoom WHERE OptionCode = '".$input['ReservationRoom'.DTR.'OptionCode']."'";
		}
		
		$result = $DS->query($query); 

      	return $result;  	
	}
	
	function getReservationOrderStat($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationRoomServices.getReservationServicess.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		
		$query = "SELECT * FROM ReservationOrderStat ORDER BY ReservationOrderStatID DESC";
		
		$result = $DS->query($query); 

      	return $result;  	
	}
	
	function getClientMessages($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('MessageClass.getLastAdminMessages.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Message'.DTR.'MessageID'];
		if(empty($entityID)) {$entityID = $input['MessageID'];}
		$searchWord = $input['searchWord'];
		$folder = $input['folder'];
		if (empty($folder)) {$folder = 'inbox';}
		
		$ReceiverID = $input['ReceiverID'];
		

		$orderLastSent = input('OrderLastSent');
		if(input('ReceiverID')){

			$filter .= " AND ( Message.UserID='$ReceiverID' OR MessageReceiverID='$ReceiverID')  ";

		}
		$filter .= " AND MessageStatus='new' AND (MessageSenderGroup ='user' OR MessageSenderGroup ='')";
		$query = "SELECT * FROM User, Message WHERE User.UserID = Message.UserID AND MessageFolderAlias='$folder' $filter ORDER BY Message.TimeCreated DESC "; 
//echo $query;
		$result = $DS->query($query,$mode); 
		$SERVER->setDebug('MessageClass.getLastAdminMessages.End','End');
		return $result;
	}
		
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setReservationOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.setReservationOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		global $CORE;
		$user = $CORE->getUser();
		$input['ReservationOrder'.DTR.'GroupID'] = $user['GroupID'];
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ReservationOrder'.DTR.'ReservationOrderID'];
		if (empty($input['ReservationOrder'.DTR.'ReservationOrderClientType']))
		{
			$input['ReservationOrder'.DTR.'ReservationOrderClientType'] = $user['UserName'];
		}
		if(empty($entityID)) {$entityID = $input['ReservationOrderID'];}
		if (empty($input['ReservationOrder'.DTR.'ReservationOrderOptionValid'])) {
			$input['ReservationOrder'.DTR.'ReservationOrderOptionValid'] = '3';
		}
		$input['ReservationOrder'.DTR.'ReservationOrderOptionDeadline'] = date('Y-m-d H:i:s', mktime(date("H"), date("i"), date("s"), date("m")  , date("d")+$input['ReservationOrder'.DTR.'ReservationOrderOptionValid'], date("Y")));
		
		if(empty($userID)) {
			$SelectUser = $DS->query("SELECT UserID, UserName, GroupID FROM User WHERE Email = '".$input['MessageTextEmail']."'");
			//print_r($SelectUser);
			$userID = $SelectUser[0]['UserID'];
			$input['ReservationOrder'.DTR.'UserID'] = $SelectUser[0]['UserID'];
			$input['ReservationOrder'.DTR.'ReservationOrderClientType'] = $SelectUser[0]['UserName'];
			$input['ReservationOrder'.DTR.'GroupID'] = $SelectUser[0]['GroupID'];
			//echo '<br><br><br>';
			//echo $userID;
			//echo $input['ReservationOrder'.DTR.'ReservationOrderClientType'];
			//echo $input['ReservationOrder'.DTR.'GroupID'];
		}
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservationOrderServer.adminReservationOrder');
		//set queries			
		//if(is_array($input['ReservationOrder'.DTR.'ReservationOrderSections'])) {$input['ReservationOrder'.DTR.'ReservationOrderSections'] = '|'. implode("|",$input['ReservationOrder'.DTR.'ReservationOrderSections']).'|'; }
		//$input['ReservationOrderStat'.DTR.'ReservationOrderStatMonth'] = 'May';
		//$input['ReservationOrderStat'.DTR.'ReservationOrderStatYear'] = '2007';
		//$input['ReservationOrderStat'.DTR.'ReservationOrderStatProcent'] = '50%';
		
		$where['ReservationOrder'] = "ReservationOrderID = '".$entityID."'".$filter;

        $ReservationOrderArrival = $input['ReservationOrder'.DTR.'ReservationOrderArrival_year'].'-'.$input['ReservationOrder'.DTR.'ReservationOrderArrival_month'].'-'.$input['ReservationOrder'.DTR.'ReservationOrderArrival_day'];
        $ReservationOrderDeparture = $input['ReservationOrder'.DTR.'ReservationOrderDeparture_year'].'-'.$input['ReservationOrder'.DTR.'ReservationOrderDeparture_month'].'-'.$input['ReservationOrder'.DTR.'ReservationOrderDeparture_day'];
        $ReservationOrderPeriod = (strtotime($ReservationOrderDeparture) - strtotime($ReservationOrderArrival)) / 60 / 60 / 24;
        if ($ReservationOrderPeriod > $config['ReservationPeriod'] && $user['GroupID'] != 'root')
        {
        	$checkAdd = '1';
        }
        
        if (empty($checkAdd))
        {
        $checkAdd = $DS->query("SELECT * FROM ReservationOrder WHERE 
               ((ReservationOrderArrival < '".$ReservationOrderArrival."' 
               AND ReservationOrderDeparture > '".$ReservationOrderDeparture."')
               OR (ReservationOrderArrival > '".$ReservationOrderArrival."' 
               AND ReservationOrderDeparture < '".$ReservationOrderDeparture."')
               OR (ReservationOrderArrival = '".$ReservationOrderArrival."')
               OR (ReservationOrderDeparture = '".$ReservationOrderDeparture."')
               OR (ReservationOrderArrival > '".$ReservationOrderArrival."' 
               AND ReservationOrderDeparture > '".$ReservationOrderDeparture."'
               AND ReservationOrderArrival < '".$ReservationOrderDeparture."')
               OR (ReservationOrderDeparture < '".$ReservationOrderDeparture."' 
               AND ReservationOrderDeparture > '".$ReservationOrderArrival."'
               AND ReservationOrderArrival < '".$ReservationOrderArrival."')
               OR ('".$ReservationOrderArrival."' >= '".$ReservationOrderDeparture."'))
               AND ReservationOrderRooms = '".$input['ReservationOrder'.DTR.'ReservationOrderRooms']."' 
               AND ReservationOrderID != '".$input['ReservationOrder'.DTR.'ReservationOrderID']."'");
        }
        
        //$checkSave = $DS->query("SELECT * FROM ReservationOrder WHERE 
               //('".$ReservationOrderArrival."' >= '".$ReservationOrderDeparture."')
               //AND ReservationOrderRooms = '".$input['ReservationOrder'.DTR.'ReservationOrderRooms']."'");
        
        $checkRoom = $DS->query("SELECT * FROM ReservationRoom WHERE 
                    OptionRoomType = 'info' AND
                    '".$input['ReservationOrder'.DTR.'ReservationOrderType']."' != 'other' AND
                    OptionCode = '".$input['ReservationOrder'.DTR.'ReservationOrderRooms']."'");

		if(empty($input['ReservationOrder'.DTR.'ReservationOrderAlias']) && !empty($input['ReservationOrder'.DTR.'ReservationOrderTitle']))
		{
			$typeObject = new AliasDataType($SERVER);
			$langReservationOrderTitle = $input['ReservationOrder'.DTR.'ReservationOrderTitle']['en'];
			if(empty($langReservationOrderTitle)) { $lang = $config['lang']; $langReservationOrderTitle = $input['ReservationOrder'.DTR.'ReservationOrderTitle'][$lang];}
			$input['ReservationOrder'.DTR.'ReservationOrderAlias'] = $typeObject->setDataType($langReservationOrderTitle);
		}
		if(!empty($input['ReservationOrder'.DTR.'ReservationOrderAlias']))
		{
			$checkRS=$DS->query("SELECT ReservationOrderAlias FROM ReservationOrder WHERE ReservationOrderAlias='".$input['ReservationOrder'.DTR.'ReservationOrderAlias']."'");
			if($input['actionMode']=='add') { if(count($checkRS)>0) {$duplicated='Y'; } }
			else { if(count($checkRS)>1) {$duplicated='Y'; } }
			if($duplicated == 'Y')
			{
				$input['ReservationOrder'.DTR.'ReservationOrderAlias'] = $input['ReservationOrder'.DTR.'ReservationOrderAlias'].date('Ymd-His');
				$SERVER->setMessage('ReservationOrder.ReservationOrderClass.setReservationOrder.err.DuplicatedReservationOrderCode');
			}				
		}
        $separateDateField = 'ReservationOrder'.DTR.'ReservationOrderArrival'; 
        if(!empty($input[$separateDateField.'_day'])) 
        {
            $input[$separateDateField] = $input[$separateDateField.'_year'].'-'.$input[$separateDateField.'_month'].'-'.$input[$separateDateField.'_day'];
        }
        $separateDateField = 'ReservationOrder'.DTR.'ReservationOrderDeparture'; 
        if(!empty($input[$separateDateField.'_day'])) 
        {
            $input[$separateDateField] = $input[$separateDateField.'_year'].'-'.$input[$separateDateField.'_month'].'-'.$input[$separateDateField.'_day'];
        }
        //print_r($input);
        
		if(!empty($input['ReservationOrder'.DTR.'ReservationOrderArrival']) && !empty($input['ReservationOrder'.DTR.'ReservationOrderDeparture']) && !empty($input['ReservationOrder'.DTR.'ReservationOrderRooms']) && !empty($input['ReservationOrder'.DTR.'ReservationOrderType']) && !empty($input['ReservationOrder'.DTR.'ReservationOrderClientType']) && empty($checkAdd) && empty($checkRoom) && $input['actionMode']=='add' && !empty($userID))
		{
			$input['actionMode']='save';
			if(!empty($input['ReservationOrder'.DTR.'UserID']) || !empty($user['UserID']))
			{			
			
				$result = $DS->save($input,$where,'insert');
	
				$entityID = $result[0]['ReservationOrderID'];
				$input['ReservationOrder'.DTR.'ReservationOrderID'] = $entityID;
				$this->setReservationOrderLog($input);		
			}	
		}
		elseif(!empty($input['ReservationOrder'.DTR.'ReservationOrderArrival']) && !empty($input['ReservationOrder'.DTR.'ReservationOrderDeparture']) && !empty($input['ReservationOrder'.DTR.'ReservationOrderRooms']) && !empty($input['ReservationOrder'.DTR.'ReservationOrderType']) && !empty($input['ReservationOrder'.DTR.'ReservationOrderClientType']) && empty($checkAdd) && empty($checkRoom) && $input['actionMode']=='save' && !empty($userID))
		{
			$input['actionMode']='save';		
			if(!empty($input['ReservationOrder'.DTR.'UserID']) || !empty($user['UserID']))
			{			
				$result = $DS->save($input,$where,'insert');
	
				$entityID = $result[0]['ReservationOrderID'];
				$input['ReservationOrder'.DTR.'ReservationOrderID'] = $entityID;
				$this->setReservationOrderLog($input);			
			}
			
		}
		else
		{
			if (!empty($checkAdd) || !empty($checkRoom))
			{
                $SERVER->setMessage('ReservationOrderClass.setReservationOrder.err.AlreadyExists');
			}
			//if(!empty($input['ReservationOrder'.DTR.'ReservationOrderAlias']))
			//{
				//$SERVER->setMessage('ReservationOrderClass.setReservationOrder.err.AlreadyExists');
			//}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ReservationOrderClass.setReservationOrder.msg.DataSaved');
		}
		
		$SERVER->setDebug('ReservationOrderClass.setReservationOrder.End','End');		
		return $result;		
	}
	

	function setReservationOrderLog($input,$action='')
	{
		//set global variables
		if(empty($action)) {$action='updated';}
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		$entityID = $input['ReservationOrder'.DTR.'ReservationOrderID'];
		if(empty($entityID)) {$entityID = $input['ReservationOrderID'];}	
		
		if(!empty($entityID))
		{
			$oldRS = $DS->query("SELECT * FROM ReservationOrder WHERE ReservationOrderID='".$entityID."'");		
			if(is_array($oldRS[0]))
			{
				$changedFields  = '';
				foreach($oldRS[0] as $fieldName=>$fieldValue)
				{
					if(!empty($input['ReservationOrder'.DTR.$fieldName]))
					{
						$inputSave['ReservationOrderLog'.DTR.$fieldName] = $input['ReservationOrder'.DTR.$fieldName];
						
						if($fieldValue!=$input['ReservationOrder'.DTR.$fieldName])
						{
							$changedFields .= lang('ReservationOrder.'.$fieldName).' ['.lang('ChangedField.reservation.tip').'] : '.$inputSave['ReservationOrderLog'.DTR.$fieldName]."<br>\n";
						}
						else
						{
							$changedFields .= lang('ReservationOrder.'.$fieldName).' : '.$inputSave['ReservationOrderLog'.DTR.$fieldName]."<br>\n";
						}
						
					}
					else
					{
						$inputSave['ReservationOrderLog'.DTR.$fieldName] = addslashes(stripslashes($fieldValue));
						$changedFields .= lang('ReservationOrder.'.$fieldName).' : '.$inputSave['ReservationOrderLog'.DTR.$fieldName]."<br>\n";
						
					}
					
				}
				$inputSave['ReservationOrderLog'.DTR.'ReservationOrderLogTimeCreated'] = date('Y-m-d H:i:s');
				$inputSave['ReservationOrderLog'.DTR.'ReservationOrderLogUserID'] = $userID;
				$inputSave['ReservationOrderLog'.DTR.'ReservationOrderLogAction'] = $action;
				
				
				//print_r($inputSave);
				$inputSave['actionMode']='save';
				$where['ReservationOrderLog'] = "ReservationOrderLogID = ''";
				$DS->save($inputSave,$where,'insert');

				$emailInput['MailData']['ChangedFields'] = $changedFields;

				$emailInput['MailTemplate']	= 'ReservationOrderChangeLog.reservation';
				$emailInput['MailFrom'] = 'noreply-'.$config['SiteMail'];
				$emailInput['MailFromName'] = $config['SiteName'];
				//$emailInput['MailTo']	= 'ac@abtsolutions.net';
				$emailInput['MailTo']	= $config['SiteMail'];
				$emailInput['MailToName']	= $config['SiteName'];
				
				if($action=='deleted') {$subject ="Order deleted:"; }else {$subject ="Order changed:";}
				$emailInput['MailSubject']	= $subject.' ID-'.$inputSave['ReservationOrderLog'.DTR.'ReservationOrderID'].' - '.$inputSave['ReservationOrderLog'.DTR.'ReservationOrderClientType'];
				
				$SERVER->callService('sendMail','mailServer',$emailInput);
				//print_r($emailInput);
				//die('tt');
				
			}
		}
	}	
	
	
	function setReservationStat($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.setReservationOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		global $CORE;
		$user = $CORE->getUser();
		$input['ReservationOrder'.DTR.'GroupID'] = $user['GroupID'];
		$userID = $user['UserID'];

		$where['ReservationOrderStat'] = "ReservationOrderStatID = '".$entityID."'".$filter;
        //print_r($input);
        
		$input['actionMode']='save';
		$result = $DS->save($input,$where);



		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ReservationOrderClass.setReservationOrder.msg.DataSaved');
		}
		
		$SERVER->setDebug('ReservationOrderClass.setReservationOrder.End','End');		
		return $result;		
	}

    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteReservationOrder($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.deleteReservationOrder.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ReservationOrder'.DTR.'ReservationOrderID'];
		//if(empty($entityID)) {$entityID = $input['ReservationOrderID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ReservationOrderServer.adminReservationOrder');
		//set queries
		if(!empty($entityID))
		{
			
			$inputLog['ReservationOrder'.DTR.'ReservationOrderID'] = $entityID;
			$this->setReservationOrderLog($inputLog,'deleted');			
			$deleteQuery = "DELETE FROM ReservationOrder WHERE ReservationOrderID='$entityID'";
			//echo $deleteQuery;
			//die($deleteQuery);
			$result = $DS->query($deleteQuery);
		}
		$SERVER->setMessage('ReservationOrderClass.deleteReservationOrder.msg.DataDeleted');
		$SERVER->setDebug('ReservationOrderClass.deleteReservationOrder.End','End');		
		return $result;		
	}
	
	function checkReservationOption($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ReservationOrderClass.getReservationOrder.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		$entityID = $input['ReservationOrder'.DTR.'ReservationOrderID'];

	    $deadline = date('Y-m-d H:i:s');

		$query = "UPDATE ReservationOrder SET PermAll = '5' WHERE ReservationOrderOptionDeadline < '".$deadline."' AND ReservationOrderType = 'option'";
		$result = $DS->query($query);
		$query = "UPDATE ReservationOrder SET PermAll = '4' WHERE ReservationOrderOptionDeadline > '".$deadline."' AND ReservationOrderType = 'option'";
		$result = $DS->query($query);

		return $result;
	}
} // end of ReservationOrderServer
?>
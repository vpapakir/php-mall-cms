<?php
//XCMSPro: Web Service entity class
class PaymentMethodSettingClass
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
	function PaymentMethodSettingClass()
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
	function getPaymentMethodSettings($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PaymentMethodSettingClass.getPaymentMethodSettings.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		
		$ownerID = $config['OwnerID'];
		//set client side variables
		$searchWord = $input['searchWord'];
		$permAll = $input['PermAll'];
		$filterMode = $input['filterMode'];
		
		//set filters
		if(!empty($input['PaymentMethodID']))
		{
			$filter .= " AND PaymentMethodID = '".$input['PaymentMethodID']."'";
		}
		
		if($filterMode=='last')
		{
			$filter .= " AND PermAll='4' ";
			$limit = " LIMIT 0,30";
		}

		if(!empty($permAll) && $SERVER->hasRights('content'))
		{
			$filter .= " AND PermAll='$permAll' ";
		}			
		
		if(!empty($searchWord))
		{
			$filter .= " AND (SettingVariableName LIKE '%$searchWord%' OR SettingName LIKE '%$searchWord%')  ";
		}	
		//set queries
		$query = "SELECT * FROM PaymentMethodSetting WHERE PaymentMethodSettingID>0 $filter ";
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('PaymentMethodSettingClass.getPaymentMethodSettings.End','End');
		return $result;
	}	


	function getPaymentMethodSettingsFormated($method)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PaymentMethodSettingClass.getPaymentMethodSettings.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		
		$ownerID = $config['OwnerID'];
		//set client side variables
		$searchWord = $input['searchWord'];
		$permAll = $input['PermAll'];
		$filterMode = $input['filterMode'];

		if(!empty($method))
		{
			$rs = $DS->query("SELECT PaymentMethodID FROM PaymentMethod WHERE PaymentMethodAlias='$method'");
			$paymentMethodID = $rs[0]['PaymentMethodID'];
			
			$query = "SELECT * FROM PaymentMethodSetting WHERE PaymentMethodID='$paymentMethodID '";
			$settingsRS = $DS->query($query); 
			if(is_array($settingsRS))
			{
				foreach($settingsRS as $row)
				{
					if(!empty($row['SettingVariableName']))
					{
						$settingVariableName = $row['SettingVariableName'];
						$result[$settingVariableName] =$row['SettingValue'] ;
					}
				}
			}
		}
		return $result;
	}
	
	function getPaymentMethodSetting($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PaymentMethodSettingClass.getPaymentMethodSetting.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		$entityID = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingID'];
		if(empty($entityID)) {$entityID = $input['PaymentMethodSettingID'];}
		$searchWord = $input['searchWord'];
		$permAll = $input['PermAll'];
		$filterMode = $input['filterMode'];
		
		//set filters
		if(!empty($entityID))
		{
			$filter .= "PaymentMethodSettingID = $entityID";
		}
		if($filterMode=='last')
		{
			$filter .= " AND PermAll='4' ";
			$limit = " LIMIT 0,30";
		}

		if(!empty($permAll) && $SERVER->hasRights('content'))
		{
			$filter .= " AND PermAll='$permAll' ";
		}			
		
		if(!empty($searchWord))
		{
			$filter .= " AND (SettingVariableName LIKE '%$searchWord%' OR SettingName LIKE '%$searchWord%')  ";
		}	
		
		//set queries
		$query = "SELECT * FROM PaymentMethodSetting WHERE PaymentMethodSettingID>0 $filter ";
		//get the content
		$result = $DS->query($query); 

		$SERVER->setDebug('PaymentMethodSettingClass.getPaymentMethodSetting.End','End');
		return $result;
	}
	
	function getPaymentMethods($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PaymentMethodSettingClass.getPaymentMethods.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		
		$ownerID = $config['OwnerID'];
		//set client side variables
		$searchWord = $input['searchWord'];
		$permAll = $input['PermAll'];
		$filterMode = $input['filterMode'];
		
		//set filters
		if($filterMode=='last')
		{
			$filter .= " AND PermAll='4' ";
			$limit = " LIMIT 0,30";
		}

		if(!empty($permAll) && $SERVER->hasRights('content'))
		{
			$filter .= " AND PermAll='$permAll' ";
		}			
		elseif($clientType!='admin' && $manageMode!='user')
		{
			$filter .= " AND PermAll='1' ";
		}		
		
		if(!empty($searchWord))
		{
			$filter .= " AND (PaymentMethodAlias LIKE '%$searchWord%' OR PaymentMethodName LIKE '%$searchWord%' OR PaymentMethodDescription LIKE '%$searchWord%')  ";
		}	
		//set queries
		$query = "SELECT * FROM PaymentMethod WHERE PaymentMethodID>0 $filter ";
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('PaymentMethodSettingClass.getPaymentMethods.End','End');
		return $result;
	}	

	function getPaymentMethod($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PaymentMethodSettingClass.getPaymentMethod.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		$entityID = $input['PaymentMethod'.DTR.'PaymentMethodID'];
		if(empty($entityID)) {$entityID = $input['PaymentMethodID'];}
		
		$entityAlias = $input['paymentMethod'];
		
		$searchWord = $input['searchWord'];
		$permAll = $input['PermAll'];
		$filterMode = $input['filterMode'];
		
		//set filters
		if(!empty($entityID))
		{
			$filter .= " AND PaymentMethodID = $entityID";
		}

		if(!empty($entityAlias))
		{
			$filter .= " AND PaymentMethodAlias = '$entityAlias'";
		}		
		if($filterMode=='last')
		{
			$filter .= " AND PermAll='4' ";
			$limit = " LIMIT 0,30";
		}

		if(!empty($permAll) && $SERVER->hasRights('content'))
		{
			$filter .= " AND PermAll='$permAll' ";
		}			
		
		if(!empty($searchWord))
		{
			$filter .= " AND (PaymentMethodAlias LIKE '%$searchWord%' OR PaymentMethodName LIKE '%$searchWord%' OR PaymentMethodDescription LIKE '%$searchWord%')  ";
		}	
		
		//set queries
		$query = "SELECT * FROM PaymentMethod WHERE PaymentMethodID>0 $filter ";
		//echo $query;
		//get the content
		$result = $DS->query($query); 

		$SERVER->setDebug('PaymentMethodSettingClass.getPaymentMethod.End','End');
		return $result;
	}
	
	function deletePaymentMethod($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PaymentMethodSettingClass.deletePaymentMethod.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['PaymentMethod'.DTR.'PaymentMethodID'];
		if(empty($entityID)) {$entityID = $input['PaymentMethodID'];}

		if(!empty($entityID))
		{
			$DS->query("DELETE FROM PaymentMethod WHERE PaymentMethodID='$entityID'");
		}
		//$SERVER->setMessage('ServiceClass.deleteService.msg.DataDeleted');
		$SERVER->setDebug('PaymentMethodSettingClass.deletePaymentMethod.End','End');		
		return $result;		
	}
	
	function deletePaymentMethodSetting($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('PaymentMethodSettingClass.deletePaymentMethodSetting.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingID'];
		if(empty($entityID)) {$entityID = $input['PaymentMethodSettingID'];}
		
		if(!empty($entityID))
		{
			$filter .= " PaymentMethodSettingID='".$entityID."' ";
		}
		 elseif(!empty($input['PaymentMethod'.DTR.'PaymentMethodID']))
			{
				$filter .= " PaymentMethodID='".$input['PaymentMethod'.DTR.'PaymentMethodID']."' ";
			}

		if(!empty($entityID))
		{
			$DS->query("DELETE FROM PaymentMethodSetting WHERE $filter");
		}
		//$SERVER->setMessage('ServiceClass.deleteService.msg.DataDeleted');
		$SERVER->setDebug('PaymentMethodSettingClass.deletePaymentMethodSetting.End','End');		
		return $result;		
	}
	
	
	function setPaymentMethod($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ServiceClass.setService.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		$entityID = $input['PaymentMethod'.DTR.'PaymentMethodID'];
		if(empty($entityID)) {$entityID = $input['PaymentMethodID'];}		
		if(!empty($input['PaymentMethodAlias'])){$PaymentMethodAlias = $input['PaymentMethodAlias'];}
		 
		$where['PaymentMethod'] = "PaymentMethodID = '".$entityID."'";

		if(!empty($PaymentMethodAlias) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT PaymentMethodAlias FROM PaymentMethod WHERE PaymentMethodAlias='$PaymentMethodAlias'");
		}
		
		if(count($checkRS)<1)
		{
			if(!empty($input['PaymentMethod'.DTR.'PaymentMethodName']))
			{		
				$input['actionMode']='save';					
				$result = $DS->save($input,$where);
				if(empty($entityID)) {$entityID=$DS->dbLastID();}
				$result['PaymentMethodID'] = $entityID;
			}
		}
		else
		{
			if(!empty($input['PaymentMethod'.DTR.'PaymentMethodAlias']))
			{
				$SERVER->setMessage('ServiceClass.setService.err.AlreadyExists');
			}
		}

		$SERVER->setDebug('ServiceClass.setService.End','End');		
		return $result;		
	}
	
	function setPaymentMethodSetting($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ServiceClass.setService.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		//set client side variables
		$entityID = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingID'];
		if(empty($entityID)) {$entityID = $input['PaymentMethodSettingID'];}		
		//if(!empty($input['PaymentMethodAlias'])){$PaymentMethodAlias = $input['PaymentMethodAlias']}
		 
		$where['PaymentMethodSetting'] = "PaymentMethodSettingID = '".$entityID."'";

		if(!empty($input['PaymentMethodSetting'.DTR.'SettingVariableName']))
		{		
			$input['PaymentMethodSetting']='save';					
			$result = $DS->save($input,$where);
			if(empty($entityID)) {$entityID=$DS->dbLastID();}
		}

		$SERVER->setDebug('ServiceClass.setService.End','End');		
		return $result;		
	}
	
} // end of ServiceServer
?>
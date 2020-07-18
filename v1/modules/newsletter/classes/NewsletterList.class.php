<?php
//XCMSPro: Web Service entity class
class NewsletterListClass
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
	function NewsletterListClass()
	{
		global $CORE;
		$this->_controller = &$CORE;
		$this->_DS = new DataSource('main');
		$this->_config = $this->_controller->getConfig();
		$this->_user = $this->_controller->getUser();
	}
	
	// PUBLIC METHODS
	
	function getNewsletterLists($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterListClass.getNewsletterLists.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['NewsletterList'.DTR.'NewsletterListID'];
		if(empty($entityID)) {$entityID = $input['NewsletterListID'];}
		$entityAlias = $input['NewsletterList'.DTR.'NewsletterListAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['NewsletterListAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['newsletterList'];}
		$searchWord = $input['searchWord'];
		//set filters

		if(!empty($searchWord))
		{
			$filter .= " AND (ListName LIKE '{ls}%$searchWord%{le}' OR ListName LIKE '%$searchWord%' OR ListDescription LIKE '{ls}%$searchWord%{le}' OR ListDescription LIKE '%$searchWord%' OR ListComments LIKE '%$searchWord%')";
		}		
		//set queries
		$query = "SELECT * FROM NewsletterList WHERE 1 $filter ORDER BY NewsletterList.TimeSaved DESC";
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		//print_r($result);
		$SERVER->setDebug('NewsletterListClass.getNewsletterLists.End','End');
		return $result;
	}
	 
	function getNewsletterList($input)
	{
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterListClass.getNewsletterList.Start','Start');	
		$DS = &$this->_DS;
		$user = $SERVER->getUser();
		$userID = $user['UserID'];
		//print_r($user);
		$entityID = $input['NewsletterList'.DTR.'NewsletterListID'];
		if(empty($entityID)) {$entityID = $input['NewsletterListID'];}
		//jb 14.11.05 tmp commented
		//if($SERVER->hasRights('NewsletterServer.adminNewsletters'))
		//{
			$query = "SELECT * FROM NewsletterList WHERE NewsletterListID='$entityID'";
			$NewsletterRS = $DS->query($query);
			$result = $NewsletterRS;
		//}
		$SERVER->setDebug('NewsletterListClass.getNewsletterList.End','End');
		return $result;		
	}
	 
	function setNewsletterList($input)
	{
		//print_r($input);
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterListClass.setNewsletterList.Start','Start');	
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		/*jb 14.11.05 tmp commented
		if($SERVER->hasRights('NewsletterServer.adminCompanies'))
		{
			$filter = "";
		}
		else
		{
			$filter = " AND UserID='$userID'";			
		}*/
		$NewsletterListID = $input['NewsletterList'.DTR.'NewsletterListID'];
		if(!empty($NewsletterListID))
		{
			$where['NewsletterList'] = "NewsletterListID = '".$NewsletterListID."'".$filter;
		} else {
			$where['NewsletterList'] = '';
		  }
		
		$saveRS = $DS->save($input,$where);
		$SERVER->setDebug('NewsletterListClass.setNewsletterList.End','End');
		return $saveRS;		
	}
	 
	function getNewsletterListRefs()
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('NewsletterListClass.getNewsletterLists.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		
		$query = "SELECT NewsletterListID, ListName FROM NewsletterList WHERE PermAll='1' ORDER BY NewsletterList.ListPosition";	
		$newsletterListRS = $DS->query($query);
		if(is_array($newsletterListRS))	
		{
			$result = $newsletterListRS;
		} else {
			$result = false;
		  }
		  
		 return $result;
	}
} // end of NewsletterListClass
?>
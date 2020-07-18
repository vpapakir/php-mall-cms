<?php
//XCMSPro: Web Service entity class
class BannerClass
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
	function BannerClass()
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
	function getBanners($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('BannerClass.getBanners.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$place = $input['BannerPlace'];
		$category = $input['category'];
		$keywords = $input['keywords'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'BannerServer.adminBanner');
		$SID= $input['SID'];

		if(!empty($category))
		{
			$categoryIDRS = $DS->query("SELECT ResourceCategoryID FROM ResourceCategory WHERE ResourceCategoryAlias='$category'");
			$categoryID = $categoryIDRS[0]['ResourceCategoryID'];
		}
				
		if(!empty($place))
		{
			$filter .= " AND BannerPlace = '$place'";
		}	
		if(!empty($category))
		{
			$filter .= " AND (BannerCategories LIKE '%|$categoryID|%' OR BannerSections LIKE '%|$SID|%') ";
		}		
		elseif(!empty($keywords))	
		{
			//$filter .= " AND BannerKeywords LIKE '%|$SID|%' ";
		}
		elseif($clientType!='admin' && $SID!='adminBanners')
		{
			$filter .= " AND BannerSections LIKE '%|$SID|%' ";
		}	
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM Banner WHERE BannerID>0 $filter ORDER BY BannerPosition";
		//get the content
		//echo $query;
		$result = $DS->query($query); 
		$SERVER->setDebug('BannerClass.getBanners.End','End');
		return $result;
	}	
	

    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getBanner($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('BannerClass.getBanner.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		$entityID = $input['Banner'.DTR.'BannerID'];
		if(empty($entityID)) {$entityID = $input['BannerID'];}

		$entityAlias = $input['SourceType'];
		if(empty($entityAlias)) {$entityAlias = $input['Banner'];}
		if(empty($entityAlias)) {$entityAlias = $input['BannerAlias'];}		
		if(empty($entityAlias)) {$entityAlias = $input['Banner'.DTR.'BannerAlias'];}

		//set filters
		//$filter = $DS->getAccessFilter($input,'BannerServer.adminBanner');
		//set queries
		$query =='';
		if(!empty($entityAlias))
		{
			$filter = " BannerAlias='$entityAlias' "; 
		}
		else
		{
			$filter = " BannerID='$entityID' ";
		}
		$query = "SELECT * FROM Banner WHERE $filter"; 
		//get the content
		$result = $DS->query($query);	


		$SERVER->setDebug('BannerClass.getBanner.End','End');		
		return $result;		
	}
	
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setBanner($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('BannerClass.setBanner.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Banner'.DTR.'BannerID'];
		if(empty($entityID)) {$entityID = $input['BannerID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'BannerServer.adminBanner');
		//set queries			
		//if(is_array($input['Banner'.DTR.'BannerSections'])) {$input['Banner'.DTR.'BannerSections'] = '|'. implode("|",$input['Banner'.DTR.'BannerSections']).'|'; }
		$where['Banner'] = "BannerID = '".$entityID."'".$filter;

		if(!empty($input['Banner'.DTR.'BannerAlias']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT BannerAlias FROM Banner WHERE BannerAlias='".$input['Banner'.DTR.'BannerAlias']."'");
		}
		if(count($checkRS)<1 && !empty($input['Banner'.DTR.'BannerAlias']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);
			if(empty($entityID)) {$entityID = $DS->dbLastID();}	
			$this->updateEntityPositions($entityID,'Banner');
		}
		else
		{
			if(!empty($input['Banner'.DTR.'BannerAlias']))
			{
				$SERVER->setMessage('BannerClass.setBanner.err.AlreadyExists');
			}
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('BannerClass.setBanner.msg.DataSaved');
		}
		
		$SERVER->setDebug('BannerClass.setBanner.End','End');		
		return $result;		
	}

    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteBanner($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('BannerClass.deleteBanner.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['Banner'.DTR.'BannerID'];
		//if(empty($entityID)) {$entityID = $input['BannerID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'BannerServer.adminBanner');
		//set queries
		if(!empty($entityID))
		{
			$DS->query("DELETE FROM Banner WHERE BannerID='$entityID'");
		}
		$SERVER->setMessage('BannerClass.deleteBanner.msg.DataDeleted');
		$SERVER->setDebug('BannerClass.deleteBanner.End','End');		
		return $result;		
	}	
	
	
	function copyBanner($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('SectionServer.setSection.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	

		$ownerID = $config['OwnerID'];
		$ownerRootID = $config['OwnerRootID'];
		$BannerTemplateID = $input['selectedBannerID'];
		$BannerID = $input['BannerID'];
		if($BannerID==$BannerTemplateID) {return false;}
		//set client side variables
		if(!empty($BannerTemplateID) && !empty($BannerID))
		{
			//make Banner link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM BannerField WHERE BannerID='$BannerTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['BannerField'] = "BannerFieldID = ''";
			$inputNew['BannerField'.DTR.'BannerFieldID']='';
			$inputNew['BannerField'.DTR.'OwnerID']=$ownerID;
			$inputNew['BannerField'.DTR.'UserID']=$userID;
			$inputNew['BannerField'.DTR.'BannerID']=$BannerID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['BannerField'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['BannerField'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['BannerField'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM BannerField WHERE BoxID='".$inputNew['BannerField'.DTR.'BoxID']."' AND BannerID='".$BannerID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new Banner
					$newRS = $DS->save($inputNew,$where);	
				}
			}
		}
		//if(count($result['sql'])>0)	
		//{
			//$SERVER->setMessage('SectionServer.setSection.msg.DataSaved');
		//}
		$SERVER->setDebug('SectionServer.setSection.End','End');		
		return $result;		
	}

	function updateEntityPositions($entityID,$entityName,$entityParentID='',$entityParentName='')
	{
		//set global variables
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $input['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		$input = $SERVER->getInput();
		//set client side variables
		if(empty($entityID))
		{
			return '';
		}

		if(!empty($entityParentID))
		{
			$query = "SELECT ".$entityName."ID, ".$entityName."Position FROM $entityName WHERE ".$entityParentName."ID='$entityParentID' ORDER BY ".$entityName."Position ASC";			
		}
		else
		{
			$query = "SELECT ".$entityName."ID, ".$entityName."Position FROM $entityName ORDER BY ".$entityName."Position ASC";			
		}
		$rs = $DS->query($query);
		$i=2;
		
		foreach($rs as $row)
		{
			$DS->query("UPDATE $entityName SET ".$entityName."Position='$i' WHERE ".$entityName."ID='".$row[$entityName.'ID']."'");
			//echo "UPDATE $entityName SET ".$entityName."Position='$i' WHERE ".$entityName."ID='".$row[$entityName.'ID']."'<br>";
			$i = $i+2;
		}
		//return $result;		
	}	

} // end of BannerServer
?>
<?php
//XCMSPro: Web Service entity class
class ViewClass
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
	function ViewClass()
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
	function getViews($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('CategoryServer.getCategories.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['View'.DTR.'ViewID'];
		if(empty($entityID)) {$entityID = $input['ViewID'];}
		$entityAlias = $input['View'.DTR.'ViewAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['ViewAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['view'];}
		$searchWord = $input['searchWord'];
		$entityType = $input['ViewType'];
		$entityStatus = $input['ViewStatus'];		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ViewServer.adminView');
		if(!empty($searchWord))
		{
			$filter .= " AND (ViewName LIKE '{ls}%$searchWord%{le}' OR ViewName LIKE '%$searchWord%' OR ViewDescription LIKE '{ls}%$searchWord%{le}' OR ViewDescription LIKE '%$searchWord%')";
		}		
		if(!empty($entityType))		
		{
			$filter .= " AND ViewType='$entityType' ";
		}
		if(!empty($entityStatus))		
		{
			$filter .= " AND ViewStatus='$entityStatus' ";
		}		
		//$filter .= "OwnerID='$ownerID' ";
		//set queries
		$query = "SELECT * FROM View WHERE ViewID>0 $filter ORDER BY ViewAlias";
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ViewServer.getViews.End','End');
		return $result;
	}	
	
	function getViewBoxes($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ViewClass.getViewBoxes.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['View'.DTR.'ViewID'];
		if(empty($entityID)) {$entityID = $input['ViewID'];}
		$entityAlias = $input['View'.DTR.'ViewAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['ViewAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['view'];}
		$searchWord = $input['searchWord'];
		$entityType = $input['BoxSide'];
		//set filters
		//$filter = $DS->getAccessFilter($input,'ViewServer.adminView');
		if(!empty($entityType))		
		{
			$filter .= " AND BoxSide='$entityType' ";
		}
		//set queries
		$query = "SELECT * FROM ViewBox WHERE ViewID='$entityID'$filter ORDER BY BoxSide, BoxPosition"; 
		//echo $query;
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ViewClass.getViewBoxes.End','End');
		return $result;
	}	
	
	function getBoxViews($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ViewClass.getBoxViews.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$itemsPerPage = $input['ItemsPerPage'];
		if(empty($itemsPerPage)) {$itemsPerPage = $config['ItemsPerPage'];}
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['Box'.DTR.'BoxID'];
		if(empty($entityID)) {$entityID = $input['BoxID'];}
	
		$entityType = $input['BoxSide'];
		//set filters
		$filter = $DS->getAccessFilter($input,'ViewServer.adminView');
		if(!empty($entityType))		
		{
			$filter .= " AND BoxSide='$entityType' ";
		}
		
		//set queries
		$query = "SELECT * FROM View, ViewBox WHERE View.ViewID=ViewBox.ViewID AND BoxID='$entityID' $filter ORDER BY ViewAlias"; 
		//get the content
		$result = $DS->query($query); 
		$SERVER->setDebug('ViewServer.getBoxViews.End','End');
		return $result;
	}	
    /**
    * gets entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function getView($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ViewServer.getView.Start','Start');
		$DS = &$this->_DS;
		$config = $this->_config;
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];
		$ownerID = $config['OwnerID'];		
		//set client side variables
		//$entityID = $input['View'.DTR.'ViewID'];
		if(empty($entityID)) {$entityID = $input['ViewID'];}
		$entityAlias = $input['View'.DTR.'ViewAlias'];
		if(empty($entityAlias)) {$entityAlias = $input['ViewAlias'];}
		if(empty($entityAlias)) {$entityAlias = $input['view'];}
		//set filters
		//$filter = $DS->getAccessFilter($input,'ViewServer.adminView');
		//set queries
		$query =='';
		if(!empty($entityID))
		{
			$query = "SELECT * FROM View WHERE ViewID='$entityID' $filter"; 
		}
		elseif(!empty($entityAlias))
		{
			$query = "SELECT * FROM View WHERE ViewAlias='$entityAlias' $filter"; 
		}
		//get the content
		if(!empty($query))
		{
			$result = $DS->query($query); 		
		}
		else
		{
			//$SERVER->setMessage('ViewServer.getView.err.NoViewID');
		}
		$SERVER->setDebug('ViewServer.getView.End','End');		
		return $result;		
	}
	
	
    /**
    * sets entities
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function setView($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ViewServer.setView.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['View'.DTR.'ViewID'];
		if(empty($entityID)) {$entityID = $input['ViewID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ViewServer.adminView');
		//set queries	
		//if(is_array($input['View'.DTR.'AccessGroups'])) {$input['View'.DTR.'AccessGroups'] = '|'. implode("|",$input['View'.DTR.'AccessGroups']).'|'; }
		$where['View'] = "ViewID = '".$entityID."'".$filter;

		if(!empty($input['View'.DTR.'ViewAlias']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT ViewAlias FROM View WHERE ViewAlias='".$input['View'.DTR.'ViewAlias']."'");
		}
		if(count($checkRS)<1 && !empty($input['View'.DTR.'ViewAlias']))
		{		
			$input['actionMode']='save';					
			$result = $DS->save($input,$where);	
		}
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ViewServer.setView.msg.DataSaved');
		}
		$SERVER->setDebug('ViewServer.setView.End','End');		
		return $result;		
	}
	
	function setViewBox($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ViewServer.setView.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//set client side variables
		$entityID = $input['ViewBox'.DTR.'ViewBoxID'];
		if(empty($entityID)) {$entityID = $input['ViewBoxID'];}	
		if($input['actionMode']=='addbox')
		{
			$entityID='';
			$input['ViewBox'.DTR.'ViewBoxID'] = '';
		}
			
		//set filters
		//$filter = $DS->getAccessFilter($input,'ViewServer.adminView');
		//set queries
		if(is_array($input['ViewBox'.DTR.'ViewBoxID']))
		{
			while (list($fieldNimber,$fieldValue)= each($input['ViewBox'.DTR.'ViewBoxID'])) 
			{
				$where['ViewBox'][] = "ViewBoxID = '".$fieldValue."'".$filter;
			}
		}
		else
		{
			$where['ViewBox'] = "ViewBoxID = '".$entityID."'".$filter;
		}		
		$input['actionMode']='save';
		$result = $DS->save($input,$where);	
		if(count($result['sql'])>0)	
		{
			$SERVER->setMessage('ViewServer.setView.msg.DataSaved');
		}
		$SERVER->setDebug('ViewServer.setView.End','End');		
		return $result;		
	}	
    /**
    * deletes entity
    *
    * @param	array	$input		variables sent from the cleint
    * @return 	array 				XML and array result from databse
    * @access	public
    */	
	function deleteView($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ViewServer.deleteView.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['View'.DTR.'ViewID'];
		if(empty($entityID)) {$entityID = $input['ViewID'];}		
		//set filters
		$filter = $DS->getAccessFilter($input,'ViewServer.adminView');
		//set queries
		$input['actionMode']='delete';
		$where['View'] = "ViewID = '".$entityID."'$filter";
		$result = $DS->save($input,$where);	
		$SERVER->setMessage('ViewServer.deleteView.msg.DataDeleted');
		$SERVER->setDebug('ViewServer.deleteView.End','End');		
		return $result;		
	}	

	function deleteViewBox($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('ViewServer.deleteViewBox.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		//set client side variables
		$entityID = $input['ViewBox'.DTR.'ViewBoxID'];
		if(empty($entityID)) {$entityID = $input['ViewBoxID'];}		
		//set filters
		//$filter = $DS->getAccessFilter($input,'ViewServer.adminView');
		//set queries
		$input['actionMode']='delete';
		$where['ViewBox'] = "ViewBoxID = '".$entityID."'$filter";
		$result = $DS->save($input,$where);	
		$SERVER->setMessage('ViewServer.deleteViewBox.msg.DataDeleted');
		$SERVER->setDebug('ViewServer.deleteViewBox.End','End');		
		return $result;		
	}	
	
	function getViewDefinition($input)
	{
		//set global variables
		$SERVER = &$this->_controller;
		$SERVER->setDebug('getViewDefinition.setView.Start','Start');
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		//get client side variables
		$sectionID = $input['SID'];
		//set filters
		//$filter = " AND (S.AccessGroups LIKE '%|".$user['GroupID']."|%' OR S.AccessGroups='') ";//get this section only if the user has rights to see it
		//$filter = "AND S.OwnerID='$ownerID'";
		
		//$filter .= " AND S.PermAll=1 ";
		$query="SELECT 
		S.SectionID AS \"SectionID\", 
		S.SectionAlias AS \"SectionAlias\", 
		S.AccessGroups AS \"AccessGroups\", 
		S.AccessEditUsers AS \"AccessEditUsers\",
		S.SectionLayout AS \"SectionLayout\",
		S.SectionGroupID AS \"SectionGroupID\",
		S.SectionContent AS \"SectionContent\",
		S.SectionIntroContent AS \"SectionIntroContent\",
		S.SectionListingText AS \"SectionListingText\",
		S.SectionArguments AS \"SectionArguments\", 
		S.SectionName AS \"SectionName\", 
		S.SectionTitle AS \"SectionTitle\",	
		S.SectionDescription AS \"SectionDescription\", 
		S.SectionKeywords AS \"SectionKeywords\", 
		S.SectionHidden AS \"SectionHidden\", 
		S.SectionButton AS \"SectionButton\", 
		S.SectionButtonHover AS \"SectionButtonHover\", 
		S.SectionButtonCurrent AS \"SectionButtonCurrent\",
		S.SectionTitleImage AS \"SectionTitleImage\",
		S.SectionImage AS \"SectionImage\",
		S.SectionIcon AS \"SectionIcon\", 
		S.SectionBox AS \"SectionBox\", 
		S.SectionBoxStyle AS \"SectionBoxStyle\", 
		S.SectionViewOptions AS \"SectionViewOptions\",
		S.SectionCommentsOptions AS \"SectionCommentsOptions\",
		S.SectionActionOptions AS \"SectionActionOptions\",
		S.SectionManagementLink AS \"SectionManagementLink\",
		S.SectionViewType AS \"SectionViewType\",
		S.SectionResourceType AS \"SectionResourceType\",
		V.ViewArguments AS \"ViewArguments\", 
		VB.BoxSide AS \"BoxSide\",
		VB.BoxStyle AS \"BoxStyle\",
		VB.BoxID AS \"BoxID\"
		FROM Section S, View V, ViewBox VB WHERE S.SectionLayout=V.ViewAlias AND VB.ViewID=V.ViewID AND (S.SectionID='$sectionID' OR S.SectionAlias='$sectionID')  $filter ORDER BY VB.BoxPosition ASC";	
		
		//echo $query;
		$result = $DS->query($query);	
		//print_r($result['sql']);
		//echo 'query='.$qury;
		//print_r($result['sql']);
		/*
		if(!empty($result['sql']))
		{
			
			
			$rs = '<Section>';
			if(!empty($result['sql'][0]['SectionID'])) {$rs .= '<SectionID>'.$result['sql'][0]['SectionID'].'</SectionID>';}
			if(!empty($result['sql'][0]['SectionAlias'])) {$rs .= '<SectionAlias>'.$result['sql'][0]['SectionAlias'].'</SectionAlias>';}
			if(!empty($result['sql'][0]['AccessGroups'])) {$rs .= '<AccessGroups>'.$result['sql'][0]['AccessGroups'].'</AccessGroups>';}
			if(!empty($result['sql'][0]['SectionArguments'])) {$rs .= '<SectionArguments><![CDATA['.$result['sql'][0]['SectionArguments'].']]></SectionArguments>';}
			if(!empty($result['sql'][0]['SectionChildren'])) {$rs .= '<SectionChildren>'.$result['sql'][0]['SectionChildren'].'</SectionChildren>';}
			if(!empty($result['sql'][0]['SectionName'])) {$rs .= '<SectionName><![CDATA['.$SERVER->getLanguageFieldValue($result['sql'][0]['SectionName']).']]></SectionName>';}
			if(!empty($result['sql'][0]['SectionTitle'])) {$rs .= '<SectionTitle><![CDATA['.$SERVER->getLanguageFieldValue($result['sql'][0]['SectionTitle']).']]></SectionTitle>';}
			if(!empty($result['sql'][0]['SectionDescription'])) {$rs .= '<SectionDescription><![CDATA['.$SERVER->getLanguageFieldValue($result['sql'][0]['SectionDescription']).']]></SectionDescription>';}
			if(!empty($result['sql'][0]['SectionKeywords'])) {$rs .= '<SectionKeywords><![CDATA['.$SERVER->getLanguageFieldValue($result['sql'][0]['SectionKeywords']).']]></SectionKeywords>';}
			if(!empty($result['sql'][0]['SectionHidden'])) {$rs .= '<SectionHidden><![CDATA['.$SERVER->getLanguageFieldValue($result['sql'][0]['SectionHidden']).']]></SectionHidden>';}
			if(!empty($result['sql'][0]['SectionButton'])) {$rs .= '<SectionButton>'.$SERVER->getLanguageFieldValue($result['sql'][0]['SectionButton']).'</SectionButton>';}
			if(!empty($result['sql'][0]['SectionButtonHover'])) {$rs .= '<SectionButtonHover>'.$SERVER->getLanguageFieldValue($result['sql'][0]['SectionButtonHover']).'</SectionButtonHover>';}
			if(!empty($result['sql'][0]['SectionIcon'])) {$rs .= '<SectionIcon>'.$SERVER->getLanguageFieldValue($result['sql'][0]['SectionIcon']).'</SectionIcon>';}
			if(!empty($result['sql'][0]['ViewArguments'])) {$rs .= '<ViewArguments><![CDATA['.$SERVER->getLanguageFieldValue($result['sql'][0]['ViewArguments']).']]></ViewArguments>';}
			foreach($result['sql'] as $row)
			{
				$side = $row['BoxSide'];
				$currentBoxID = $row['BoxID'];
				
				
				
				$result[$sectionID][$side][$currentBoxID] = $boxesDefinition[$currentBoxID];
				
				
				if(!empty($side) && empty($views[$side][$currentBoxID]))
				{
					$views[$side][$currentBoxID]='Y';
					$view[$side] .= '<View>' . LB;
					if(!empty($row['BoxAlias'])) {$view[$side] .= '<Name><![CDATA['.$row['BoxAlias'].']]></Name>';}
					if(!empty($row['BoxName'])) {$view[$side] .= '<Title><![CDATA['.$SERVER->getLanguageFieldValue($row['BoxName']).']]></Title>';}
					if(!empty($row['BoxModule'])) {$view[$side] .= '<Module>'.$row['BoxModule'].'</Module>';}
					if(!empty($row['BoxServerID'])) {$view[$side] .= '<ServerID>'.$row['BoxServerID'].'</ServerID>';}
					if(!empty($row['BoxClass'])) {$view[$side] .= '<Class>'.$row['BoxClass'].'</Class>';}
					if(!empty($row['BoxMethod'])) {$view[$side] .= '<Method>'.$row['BoxMethod'].'</Method>';}
					if(!empty($row['BoxTemplate'])) {$view[$side] .= '<Template>'.$row['BoxTemplate'].'</Template>';}
					if(!empty($row['BoxArguments'])) {$view[$side] .= '<Arguments><![CDATA['.$row['BoxArguments'].']]></Arguments>';}
					if(!empty($row['BoxContent'])) {$view[$side] .= '<Content><![CDATA['.$SERVER->getLanguageFieldValue($row['BoxContent']).']]></Content>';}
					$view[$side] .= '</View>' . LB;
				}
			}
			foreach($view as $sideName=>$sideValue)
			{
				$rs .= '<'.$sideName.'>'.LB;
				$rs .= $sideValue . LB;
				$rs .= '</'.$sideName.'>'.LB;
			}
			$rs .= '</Section>';
		}*/
		//echo 'rs='.$rs;
		return $result;		
	}	

	function getViewsRef($input)
	{
		$SERVER = &$this->_controller;
		$DS = &$this->_DS;	
		$config = $this->_config;
		$user = $this->_user;		
		$user = $this->_user;
		$userID = $user['UserID'];
		$clientType = $config['ClientType'];	
		$ownerID = $config['OwnerID'];
		
		$query = "SELECT ViewID AS \"ViewID\", ViewName AS \"ViewName\" FROM {dbprefix}View WHERE OwnerID='$ownerID' ORDER BY ViewAlias";	
		$rs = $DS->query($query);
		//print_r($rs);
		if(is_array($rs['sql']))	
		{
			foreach ($rs['sql'] as $row)
			{
				$SERVER->setRefItem('Views',$row['ViewID'],$SERVER->getLanguageFieldValue($row['ViewName']));								
			}
		}	
		//$refsResult = $DS->query('NewsletterSubscriberGroup','','localRefs');
		return $refsResult;			
	}
	
	function copyView($input)
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
		$viewTemplateID = $input['selectedViewID'];
		$viewID = $input['ViewID'];
		if($viewID==$viewTemplateID) {return false;}
		//set client side variables
		if(!empty($viewTemplateID) && !empty($viewID))
		{
			//make view link to box
			//get template boxes
			//$filter = " AND OwnerID='$ownerID' ";
			$templateQuery = "SELECT * FROM ViewBox WHERE ViewID='$viewTemplateID' $filter";
			$templateRS = $DS->query($templateQuery);
			//get owner's boxes
			//find new boxes
			
			$where['ViewBox'] = "ViewBoxID = ''";
			$inputNew['ViewBox'.DTR.'ViewBoxID']='';
			$inputNew['ViewBox'.DTR.'OwnerID']=$ownerID;
			$inputNew['ViewBox'.DTR.'UserID']=$userID;
			$inputNew['ViewBox'.DTR.'ViewID']=$viewID;
			$inputNew['actionMode']='save';
			foreach($templateRS as $rowTemplate)
			{
				$inputNew['ViewBox'.DTR.'BoxID']=$rowTemplate['BoxID'];
				$inputNew['ViewBox'.DTR.'BoxSide']=$rowTemplate['BoxSide'];
				$inputNew['ViewBox'.DTR.'BoxPosition']=$rowTemplate['BoxPosition'];
				//check if this box has been already added
				$checkRS = $DS->query("SELECT BoxID as \"BoxID\" FROM ViewBox WHERE BoxID='".$inputNew['ViewBox'.DTR.'BoxID']."' AND ViewID='".$viewID."'");
				
				if(count($checkRS)==0)
				{
					//print_r($inputNew);
					//echo '<hr>';
					//add new view
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

	function updateBoxPositions($ViewBoxID)
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
		if(empty($ViewBoxID))
		{
			return '';
		}
		$checkRS = $DS->query("SELECT BoxSide AS \"BoxSide\", ViewID AS \"ViewID\" FROM ViewBox WHERE ViewBoxID='$ViewBoxID'");
		$boxSide = $checkRS[0]['BoxSide'];
		$viewID = $checkRS[0]['ViewID'];

		$query = "SELECT ViewBoxID AS \"ViewBoxID\" FROM ViewBox WHERE ViewID='$viewID' AND BoxSide='$boxSide' ORDER BY BoxPosition ASC";			
		$rs = $DS->query($query);
		$i=2;
		foreach($rs as $row)
		{
			$DS->query("UPDATE ViewBox SET BoxPosition='$i' WHERE ViewBoxID='".$row['ViewBoxID']."'");
			$i = $i+2;
		}
		//return $result;		
	}	
	
		
} // end of ViewServer
?>
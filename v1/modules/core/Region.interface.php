<?php
function manageRegions()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	//set client variables
	$entityID = $input['RegionParentID'];
	if(empty($entityID))
	{
		$input['RegionParentID'] = $input['Region'.DTR.'RegionParentID'];
		$entityID = $input['Region'.DTR.'RegionParentID'];
	}
	
	//creat objects			
	$DS = new DataSource('main');
	/*$location = $input['location'];
		
	if(!empty($location))
	{
		$query = "SELECT * FROM Region WHERE RegionCode = '$location' ORDER BY RegionCode";
		$RegionRS = $DS->query($query);
		$entityID = $RegionRS[0]['RegionID'];
	}*/

	$groupID = $input['GroupID'];
	if(empty($groupID)){$groupID=1;}
	
	$sectionsObject = new RegionClass();
	
	//delete item
	if($input['actionMode']=='delete')
	{
		$sectionsObject->deleteRegion($input);
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['RegionID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM Region WHERE RegionID='".$input['RegionID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE Region SET ".$fileField."='' WHERE RegionID='".$input['RegionID']."'");
			}
		}
	}
	elseif($input['actionMode']=='save')
	{
		$sectionsObject->setRegions($input);
	}		
	elseif($input['actionMode']=='add' || $input['actionMode']=='save1')
	{
		//add or update one item
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		
		if(!empty($uploadRS['RegionImage']['file']))
		{
			$input['Region'.DTR.'RegionImage']= $uploadRS['RegionImage']['file'];
		}	
		if(!empty($uploadRS['RegionIcon']['file']))
		{
			$input['Region'.DTR.'RegionIcon']= $uploadRS['RegionIcon']['icon'];
		}	
		if(!empty($uploadRS['RegionImagePreview']['file']))
		{
			$input['Region'.DTR.'RegionImagePreview']= $uploadRS['RegionImagePreview']['preview'];
		}	

		$sectionsObject->setRegion($input);
	}

	//get Regions
	$entityRS = $sectionsObject->getRegions($input);
	$result['DB']['Regions'] = $entityRS;
	
	//get parent item details
	if(!empty($entityID))
	{
		$input['RegionID'] = $entityID;
		$RegRes = $sectionsObject->getRegion($input);
		$result['DB']['Region'] = $RegRes[0];
	}	
	
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	//get activation status reference
	$mode='';
	$mode['code']='Y';
	$result['Refs']['PermAll'] = $CORE->getType('PermAll','Region'.DTR.'PermAll',$sectionRS[0]['PermAll'],$config['lang'],$mode);
	
	//format categories tree into a drop down
	$mode='';$inputValues='';
	$mode['name']='Region'.DTR.'RegionParentID';
	$inputValues[0]['id']='';	
	$inputValues[0]['value']=lang('-top');	
	$k=1;		
	if(is_array($entityRS))
	{
		foreach($entityRS as $id=>$row)
		{
			if($lastLevel != $row['RegionLevel'])
			{
				$lastLevel = $row['RegionLevel'];
				$treeString='';
				if($row['RegionLevel']!=1)
				{
					for($i=2;$i<=$row['RegionLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
				}
			}
			if($row['RegionID']!=$input['RegionID'])
			{
				$inputValues[$k]['id']=$row['RegionID'];	
				$inputValues[$k]['value']=$treeString.getValue($row['RegionTitle']);
				$k++;		
			}
			//echo 'i= '.$i.' id= '.$row['RegionID'].' name='.$inputValues[$i]['value'].'<hr>';
		}
	}

	if(!empty($entityID))
	{
		//global $parentRegionsPath;
		
		$parentRegions = $sectionsObject->getRegionsPath($input);
		if(is_array($parentRegions))
		{
			$i=0;
			foreach ($parentRegions as $id=>$item)
			{
				$temp[$i][$id] = $item;
				$i++;
			}
			$temp = array_reverse($temp);
			foreach ($temp as $row)
			{
				foreach ($row as $id=>$item)
				{
					$parent[$id] = $item;
				}
			}			
			$result['DB']['RegionsPath'] = $parent;
		}
	}
	
	$RegionRS = $DS->query("SELECT * FROM Region WHERE RegionID>0 ORDER BY RegionCode");
	//print_r($RegionRS);
	/*foreach($RegionRS as $key=>$value){
		//echo $value['RegionID'];
		//$DS->query("UPDATE Region SET RegionActionType = 'political' WHERE RegionID='".$value['RegionID']."'");
		$inputRegion['Region'.DTR.'RegionParentID'] = "";
		
		$inputRegion['Region'.DTR.'RegionParentID'] = $value['RegionParentID'];
		$inputRegion['Region'.DTR.'RegionName'] = $value['RegionName'];
		$inputRegion['Region'.DTR.'RegionCode'] = $value['RegionCode']."2";
		//$inputRegion['Region'.DTR.'RegionZIP'] = $value['RegionZIP'];
		$inputRegion['Region'.DTR.'RegionType'] = $value['RegionType'];
		//$inputRegion['Region'.DTR.'RegionParentID'] = $value['RegionParentID'];
		$inputRegion['Region'.DTR.'RegionActionType'] = 'geographical';
		
		$where['Region'] = "RegionID='".$inputRegion['Region'.DTR.'RegionID']."'";
		$inputRegion['actionMode']='save';
		$DS->save($inputRegion,$where);
	}*/
	//return result array
	return $result;
}

function manageRegion()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	//set client variables
	$entityID = $input['RegionID'];

	//creat objects			
	$DS = new DataSource('main');
	$sectionsObject = new RegionClass();
	
	$groupID = $input['GroupID'];
	if(empty($groupID)){$groupID=1;}
	
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	//get ref PermAll
	$mode='';
	$mode['code']='Y';
	$result['Refs']['PermAll'] = $CORE->getType('PermAll','Region'.DTR.'PermAll',$sectionRS[0]['PermAll'],$config['lang'],$mode);
	
	//get 1 item details
	if(!empty($entityID))
	{
		$sectionRS = $sectionsObject->getRegion($input);
		$result['DB']['Region'] = $sectionRS;
	}	
	
	//get all items details
	if(!empty($input['RegionParentID']))
	{
		$input['RegionID'] = $input['RegionParentID'];
		$RegRes = $sectionsObject->getRegion($input);
		$result['DB']['ParentRegion'] = $RegRes[0];
	}

	//print_r($result);
	return $result;
}


function getRegionsTree($input='')
{
	global $CORE;
	$regionsObject = new RegionClass();	
	if(empty($input))
		$input = $CORE->getInput();
	//get categories reference
	//$input['treeType']='all';
	$countryID = $input['CountryID'];
	//echo 'rrrr='.$countryID;
	if(!empty($countryID))
	{
		if(empty($input['treeType'])){$input['treeType']='all';}
		$input['downLevels']='all';
		$regionsRS = $regionsObject->getRegionsTree($input);
		
		//print_r($categoriesRS);
		//echo 'tttt';
		$inputValues[0]['id']='';	
		$inputValues[0]['value']=lang('SelectRegionDropDown.core.option');	
		$k=1;		
		if(is_array($regionsRS))
		{
			foreach($regionsRS as $id=>$row)
			{
				if($lastLevel != $row['RegionLevel'])
				{
					$lastLevel = $row['RegionLevel'];
					$treeString='';
					if($row['RegionLevel']!=1)
					{
						for($i=2;$i<=$row['RegionLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
					}
				}
				//if($row['RegionID']!=$input['RegionID'])
				//{
					$inputValues[$k]['id']=$row['RegionID'];	
					$inputValues[$k]['code']=$row['RegionCode'];
					$inputValues[$k]['value']=$treeString.getValue($row['RegionName']);
					$k++;		
				//}
				//echo 'i= '.$i.' id= '.$row['RegionID'].' name='.$inputValues[$i]['value'].'<hr>';
			}
		}
		$result['DB']['RegionsList'] = $inputValues;
		$result['DB']['Regions'] = $categoriesRS;
	}
	//print_r($result['DB']['RegionsList']);
	//echo 'ttttt<br>';//$result['Refs']['Categories']= $CORE->getLists($inputValues,$parentID,$mode,$config['lang']);	
	return $result;
}

function getRegionsPath($input='')
{
	global $CORE, $parentRegionsPath;
	//get input
	if(empty($input))
		$input = $CORE->getInput();
	//creat objects			
	$Region = new RegionClass();
	$Region->getRegionsPath($input);
	$result['DB']['RegionsPath'] = $parentRegionsPath;
	//print_r($parentRegionsPath);
	//echo 'ttttttt';
	//echo '<textarea cols=70 rows=10>';
	//print_r($parentRegions);
	//echo '</textarea>';
	return $result;
}

function getRegion()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$Region = new RegionClass();
	$rs = $Region->getRegion($input);
	$result['DB']['Region'] = $rs[0];
	return $result;
}

function getContinents($input='')
{
	global $CORE;
	//get input
	if(empty($input)) {	$input = $CORE->getInput();}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$filter = " AND PermAll=1 ";
	$resultList = $DS->query("SELECT * FROM Region WHERE RegionParentID=0 $filter ORDER BY RegionCode");
	$result['DB']['Continents']=$resultList;		
	
	return $result;
}

function getCountries($input='')
{
	global $CORE;
	//get input
	if(empty($input)) {	$input = $CORE->getInput();}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects
	$DS = new DataSource('main');
	$filter = " AND PermAll=1 ";
	$continentID = $input['ContinentID'];
	if(empty($continentID)) {$continentID=0;}
	$resultList = $DS->query("SELECT * FROM Region WHERE RegionParentID=$continentID $filter ORDER BY RegionCode");
	$result['DB']['Countries']=$resultList;		
	//print_r($result['DB']['Countries']);
	return $result;
}

function getRegions($input='')
{
	global $CORE;
	//get input
	if(empty($input)) {	$input = $CORE->getInput();}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$filter = " AND PermAll=1 ";
	$countryID = $input['CountryID'];
	if(!empty($countryID))
	{
		$resultList = $DS->query("SELECT * FROM Region WHERE RegionParentID='$countryID' $filter ORDER BY RegionCode");
		$result['DB']['Regions']=$resultList;		
	}
	return $result;
}

function getCities($input='')
{
	global $CORE;
	//get input
	if(empty($input)) {	$input = $CORE->getInput();}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$filter = " AND PermAll=1 ";
	$regionID = $input['RegionID'];
	if(!empty($regionID))
	{
		$resultList = $DS->query("SELECT * FROM Region WHERE RegionParentID='$regionID' $filter ORDER BY RegionCode");
		$result['DB']['Cities']=$resultList;		
	}
	return $result;
}


function getDistricts($input='')
{
	global $CORE;
	//get input
	if(empty($input)) {	$input = $CORE->getInput();}
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$filter = " AND PermAll=1 ";
	$cityID = $input['CityID'];
	if(!empty($cityID))
	{
		$resultList = $DS->query("SELECT * FROM Region WHERE RegionParentID='$cityID' $filter ORDER BY RegionCode");
		$result['DB']['Districts']=$resultList;		
	}
	return $result;
}

function locationSelector()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	$Region = new RegionClass();
	$DS = new DataSource('main');

//print_r($input);

if ($input['changedItem']=='CountryID'){ 
     $CORE->setInputVar('RegionID', '');
	 $CORE->setInputVar('RegionName', '');
	  $CORE->setInputVar('CountryName', '');
     $input['RegionID']='';
     $CORE->setInputVar('CityID', '');
	 $CORE->setInputVar('CityName', '');
     $input['CityID']='';
     $CORE->setInputVar('DistrictID', '');
	 $CORE->setInputVar('DistrictName', '');
     $input['DistrictID']='';
}	

if ($input['changedItem']=='RegionID'){ 
     $CORE->setInputVar('CityID', '');
	  $CORE->setInputVar('CityName', '');
     $input['CityID']='';
     $CORE->setInputVar('DistrictID', '');
	 $CORE->setInputVar('DistrictName', '');
     $input['DistrictID']='';
}

if ($input['changedItem']=='CityID'){ 
     $CORE->setInputVar('DistrictID', '');
	 $CORE->setInputVar('DistrictName', '');
     $input['DistrictID']='';
}

	
	$input['locStr'] = urldecode($input['locStr']);
	//$input['locStr'] = stripslashes($input['locStr']);
	$input['locStr'] = str_replace("\\","",$input['locStr']);
	//$input['locStr'] = str_replace("%5D","]",$input['locStr']);
	//echo $input['locStr'];
	$currentLocation = spliti("\|", $input['locStr']);
	//print_r($currentLocation);
	if (is_array($currentLocation)){
	foreach ($currentLocation as $id=>$row){
	    if ($id == 0) {continue;}

	    if ($id == 1) {
		if (substr($row, 0, 1)=='[' && substr($row, strlen($row)-1, 1)==']'){
		    $CORE->setInputVar('CountryName', substr($row, 1, strlen($row)-2));
		}elseif(!empty($row)){
		    $query = "SELECT * FROM Region WHERE RegionCode='".$row."'";
		    $rsTmp = $DS->query($query);
		    $CORE->setInputVar('CountryID', $rsTmp[0]['RegionID']);
		    $input['CountryID']=$rsTmp[0]['RegionID'];
		}
	    }

	    if ($id == 2) {
		if (substr($row, 0, 1)=='[' && substr($row, strlen($row)-1, 1)==']'){
		    $CORE->setInputVar('RegionName', substr($row, 1, strlen($row)-2));
		}elseif(!empty($row)){
		    $query = "SELECT * FROM Region WHERE RegionCode='".$row."'";
		    $rsTmp = $DS->query($query);
		    $CORE->setInputVar('RegionID', $rsTmp[0]['RegionID']);
		    $input['RegionID']=$rsTmp[0]['RegionID'];//echo  $input['RegionID'];
		}
	    }

	    if ($id == 3) {
		if (substr($row, 0, 1)=='[' && substr($row, strlen($row)-1, 1)==']'){
		    $CORE->setInputVar('CityName', substr($row, 1, strlen($row)-2));
		}elseif(!empty($row)){
		    $query = "SELECT * FROM Region WHERE RegionCode='".$row."'";
		    $rsTmp = $DS->query($query);
		    $CORE->setInputVar('CityID', $rsTmp[0]['RegionID']);
		    $input['CityID']=$rsTmp[0]['RegionID'];
		}
	    }

	    if ($id == 4) {
		if (substr($row, 0, 1)=='[' && substr($row, strlen($row)-1, 1)==']'){
		    $CORE->setInputVar('DistrictName', substr($row, 1, strlen($row)-2));
		}elseif(!empty($row)){
		    $query = "SELECT * FROM Region WHERE RegionCode='".$row."'";
		    $rsTmp = $DS->query($query);
		    $CORE->setInputVar('DistrictID', $rsTmp[0]['RegionID']);
		    $input['DistrictID']=$rsTmp[0]['RegionID'];
		}
	    }



	    //if ($id == 2) {$input['RegeionID']=$row;}

	}
	}
//echo "jj ".$input['CountryID'];
	//$locationParams = $Region->getLocation();
	//creat objects			
	$continents = getContinents($input);
	$result['DB']['Continents'] = $continents['DB']['Continents'];
	if(!empty($input['ContinentID']))
	{
		$inputRegion['RegionID'] = $input['ContinentID'];
		$rs = $Region->getRegion($inputRegion);
		$result['DB']['Continent'] = $rs[0];	
		$rs='';
	}
	//get countries
	$isInList = 'N';
	if(is_array($result['DB']['Continents']))
	{
		foreach($result['DB']['Continents'] as $row)
		{
			if($row['RegionID']==$input['ContinentID']) {$isInList='Y';}
		}
		$row='';
	}
	if($isInList!='Y') {$input['ContinentID']='';}
	$countries = getCountries($input);
	$result['DB']['Countries'] = $countries['DB']['Countries'];
	if(!empty($input['CountryID']))
	{//echo "ee";
		$inputRegion['RegionID'] = $input['CountryID'];
		$rs = $Region->getRegion($inputRegion);
		$result['DB']['Country'] = $rs[0];//print_r($rs);
		$rs='';
	}
	//get regions
	$isInList = 'N';
	if(is_array($result['DB']['Countries']))
	{
		foreach($result['DB']['Countries'] as $row)
		{
			if($row['RegionID']==$input['CountryID']) {$isInList='Y';}
		}
		$row='';
	}
	if($isInList!='Y') {$input['CountryID']='';}	
	$regions = getRegions($input);
	$result['DB']['Regions'] = $regions['DB']['Regions'];
	if(!empty($input['RegionID']) && $isInList=='Y')
	{
		$inputRegion['RegionID'] = $input['RegionID'];
		$rs = $Region->getRegion($inputRegion);
		$result['DB']['Region'] = $rs[0];	
		$rs='';
	}
	//get cities
	$isInList = 'N';
	if(is_array($result['DB']['Regions']))
	{
		foreach($result['DB']['Regions'] as $row)
		{
			if($row['RegionID']==$input['RegionID']) {$isInList='Y';}
		}
		$row='';
	}
	if($isInList!='Y') {$input['RegionID']='';}
	$cities = getCities($input);
	$result['DB']['Cities'] = $cities['DB']['Cities'];	
	if(!empty($input['CityID']) && $isInList=='Y')
	{
		$inputRegion['RegionID'] = $input['CityID'];
		$rs = $Region->getRegion($inputRegion);
		$result['DB']['City'] = $rs[0];	
		$rs='';
	}
	//get districts
	$isInList = 'N';
	if(is_array($result['DB']['Cities']))
	{
		foreach($result['DB']['Cities'] as $row)
		{
			if($row['RegionID']==$input['CityID']) {$isInList='Y';}
		}
		$row='';
	}
	if($isInList!='Y') {$input['CityID']='';}
	$districts = getDistricts($input);
	$result['DB']['Districts'] = $districts['DB']['Districts'];
	if(!empty($input['DistrictID']) && $isInList=='Y')
	{
		$inputRegion['RegionID'] = $input['DistrictID'];
		$rs = $Region->getRegion($inputRegion);
		$result['DB']['District'] = $rs[0];	
		$rs='';
	}
	return $result;
}

function getLocations()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	
	//set client variables
	$entityID = $input['RegionParentID'];
	if(empty($entityID))
	{
		$input['RegionParentID'] = $input['Region'.DTR.'RegionParentID'];
		$entityID = $input['Region'.DTR.'RegionParentID'];
	}
	
	//creat objects			
	$DS = new DataSource('main');
	$location = $input['location'];
		
	if(!empty($location))
	{
		$query = "SELECT * FROM Region WHERE RegionCode = '$location' ORDER BY RegionCode";
		$RegionRS = $DS->query($query);
		$entityID = $RegionRS[0]['RegionID'];
	}

	$groupID = $input['GroupID'];
	if(empty($groupID)){$groupID=1;}
	
	$sectionsObject = new RegionClass();
	
	//get Regions
	$entityRS = $sectionsObject->getRegions($input);
	$result['DB']['Regions'] = $entityRS;
	
	//get parent item details
	if(!empty($entityID))
	{
		$input['RegionID'] = $entityID;
		$RegRes = $sectionsObject->getRegion($input);
		$result['DB']['Region'] = $RegRes[0];
	}	
	
	//get all active languages
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	//get activation status reference
	$mode='';
	$mode['code']='Y';
	$result['Refs']['PermAll'] = $CORE->getType('PermAll','Region'.DTR.'PermAll',$sectionRS[0]['PermAll'],$config['lang'],$mode);
	
	//format categories tree into a drop down
	$mode='';$inputValues='';
	$mode['name']='Region'.DTR.'RegionParentID';
	$inputValues[0]['id']='';	
	$inputValues[0]['value']=lang('-top');	
	$k=1;		
	if(is_array($entityRS))
	{
		foreach($entityRS as $id=>$row)
		{
			if($lastLevel != $row['RegionLevel'])
			{
				$lastLevel = $row['RegionLevel'];
				$treeString='';
				if($row['RegionLevel']!=1)
				{
					for($i=2;$i<=$row['RegionLevel'];$i++){$treeString .= "&nbsp;&nbsp;";}
				}
			}
			if($row['RegionID']!=$input['RegionID'])
			{
				$inputValues[$k]['id']=$row['RegionID'];	
				$inputValues[$k]['value']=$treeString.getValue($row['RegionTitle']);
				$k++;		
			}
			//echo 'i= '.$i.' id= '.$row['RegionID'].' name='.$inputValues[$i]['value'].'<hr>';
		}
	}

	if(!empty($entityID))
	{
		//global $parentRegionsPath;
		$input['mode'] = 'id';
		$parentRegions = $sectionsObject->getRegionsPath($input);
		//print_r($parentRegions);
		if(is_array($parentRegions))
		{
			$i=0;
			foreach ($parentRegions as $id=>$item)
			{
				$temp[$i][$id] = $item;
				$i++;
			}
			$temp = array_reverse($temp);
			foreach ($temp as $row)
			{
				foreach ($row as $id=>$item)
				{
					$parent[$id] = $item;
				}
			}			
			$result['DB']['RegionsPath'] = $parent;
		}
	}
	//return result array
	return $result;
}

?>
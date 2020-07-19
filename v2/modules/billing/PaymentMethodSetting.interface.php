<?php
//Section entity WebService public methods
function managePaymentMethodSettings()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	
	$PaymentMethodID = $input['PaymentMethodID'];
	
	if(empty($PaymentMethodID)){
		$defaultGoupRS = $DS->query("SELECT PaymentMethodID FROM PaymentMethod WHERE PaymentMethodPosition='1'");
		$PaymentMethodID = $defaultGoupRS[0]['PaymentMethodID'];
		$CORE->setInputVar("PaymentMethodID",$PaymentMethodID);
	}
	
	$entityID = $input['PaymentMethodSettingID'];
	//$section = new SectionClass();
	
	if($input['actionMode']=='delete')
	{
		if(!empty($input['PaymentMethodSetting'.DTR.'PaymentMethodSettingID']))
		{
			$DS->query("DELETE FROM PaymentMethodSetting WHERE PaymentMethodSettingID='".$input['PaymentMethodSetting'.DTR.'PaymentMethodSettingID']."'");
		}
	}
	elseif($input['actionMode']=='deletefile')
	{
		if(!empty($input['PaymentMethodSettingID']) && !empty($input['fileField']))
		{
			$FM = new FilesManager();
			$fileField =$input['fileField'];
			$fileFieldRS = $DS->query("SELECT ".$fileField." FROM PaymentMethodSetting WHERE PaymentMethodSettingID='".$input['PaymentMethodSettingID']."'");
			if($FM->deleteFile($fileFieldRS[0][$fileField]))
			{
				$DS->query("UPDATE PaymentMethodSetting SET ".$fileField."='' WHERE PaymentMethodSettingID='".$input['PaymentMethodSettingID']."'");
			}
		}
	}		
	elseif($input['actionMode']=='save')
	{
		foreach($input['PaymentMethodSetting'.DTR.'PaymentMethodSettingID'] as $id=>$value)
		{
			//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingVariableName'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingVariableName'][$id];
			if(is_array($input['PaymentMethodSetting'.DTR.'PaymentMethodSettingValue_'.$value]))
			{
				$fieldValeResult='';
				$k=1;
				foreach($input['PaymentMethodSetting'.DTR.'PaymentMethodSettingValue_'.$value] as $itemIndex=>$itemValue)
				{
					if(is_numeric($itemIndex))
					{
						if($k==1)
						{
							$fieldValeResult .= "|$itemValue|";
							$k++;
						}
						else
						{
							$fieldValeResult .= "$itemValue|";
						}
					}
					else
					{
						$fieldValeResult .= "<$itemIndex>".$itemValue."</$itemIndex>";
					}
				}
				$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingValue'] = $fieldValeResult;
			}
			else
			{
				if(!empty($input['PaymentMethodSetting'.DTR.'PaymentMethodSettingValue_'.$value])) {$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingValue'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingValue_'.$value];}
				else {$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingValue'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingValue'][$id];}
			}
			//print_r($input);
			$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingID'] = $value;
			
			//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingName'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingName'][$id];
			//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingValueType'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingValueType'][$id];
			//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingValueOptions'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingValueOptions'][$id];
			//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingType'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingType'][$id];
			//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingDescription'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingDescription'][$id];
			//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingGroup'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingGroup'][$id];
			//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingModule'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingModule'][$id];
			//if(is_array($input['PaymentMethodSetting'.DTR.'modules'])) {$input['types'.DTR.'modules'] = '|'. implode("|",$input['types'.DTR.'modules']).'|'; }
			$inputSave['actionMode']='save';
			$where['PaymentMethodSetting'] = "PaymentMethodSettingID='".$value."'";
			$saveResult = $DS->save($inputSave,$where);			
		}    	
	}	
	elseif($input['actionMode']=='add1' || $input['actionMode']=='save1')
	{

		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		if(!empty($uploadRS['SettingValue']['file']))
		{
			$input['PaymentMethodSetting'.DTR.'SettingValue']= $uploadRS['PaymentMethodSettingValue']['file'];
		}	
		
		if(is_array($input['PaymentMethodSetting'.DTR.'SettingValue']))
		{
			if($input['PaymentMethodSetting'.DTR.'SettingValueType']=='text')
			{
				foreach($input['PaymentMethodSetting'.DTR.'SettingValue'] as $langCode=>$value)
				{
					$PaymentMethodSettingValue .= "<$langCode>".$value."</$langCode>";
				}
			}
			else
			{
				$PaymentMethodSettingValue = '|'. implode("|",$input['PaymentMethodSetting'.DTR.'SettingValue']).'|';
			}
			$input['PaymentMethodSetting'.DTR.'SettingValue'] = $PaymentMethodSettingValue;	
		}
		$where['PaymentMethodSetting'] = "PaymentMethodSettingID='".$input['PaymentMethodSetting'.DTR.'PaymentMethodSettingID'] ."'";
		
		if(!empty($input['PaymentMethodSetting'.DTR.'SettingVariableName']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT SettingVariableName FROM PaymentMethodSetting WHERE SettingVariableName='".$input['PaymentMethodSetting'.DTR.'SettingVariableName']."'");
		}
		if(count($checkRS)<1 && !empty($input['PaymentMethodSetting'.DTR.'SettingVariableName']))
		{		
			$lastActioMode = $input['actionMode'];
			$input['actionMode']='save';		
			$saveResult = $DS->save($input,$where);
			if($lastActioMode=='add1') {$entityID = $DS->dbLastID(); }
		}
	}		
	
	$resultList = $DS->query("SELECT * FROM PaymentMethod $filter ORDER BY PaymentMethodPosition");
	$result['DB']['PaymentMethods'] = $resultList;

	if(!empty($PaymentMethodID))
	{
		$entityRS = $DS->query("SELECT * FROM PaymentMethodSetting WHERE PaymentMethodID='$PaymentMethodID'");
		$result['DB']['PaymentMethodSettings'] = $entityRS;
	}
	
	if(!empty($entityID))
	{
		$entityRS = $DS->query("SELECT * FROM PaymentMethodSetting WHERE PaymentMethodSettingID='$entityID'");
		$result['DB']['PaymentMethodSetting'] = $entityRS;
	}	
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	return $result;
}

function managePayments()
{
	global $CORE;
	//get input
	$input = $CORE->getInput();
	$user = $CORE->getUser();
	$config = $CORE->getConfig();
	//creat objects			
	$DS = new DataSource('main');
	$PaymentMethodSetting = new PaymentMethodSettingClass();	
	
	$categoryID = $input['CategoryID'];
	$clientType = $config['ClientType'];
	$entityID = $input['PaymentMethodID'];
	

	//delete item
	if($input['actionMode']=='delete')
	{
		if($input['PaymentMethod'.DTR.'PaymentMethodID'])
		{
			$PaymentMethodSetting->deletePaymentMethod($input);
			$PaymentMethodSetting->deletePaymentMethodSetting($input);
			//$DS->query("DELETE FROM PaymentMethod WHERE PaymentMethodID='".$input['PaymentMethod'.DTR.'PaymentMethodID']."'");
			//$DS->query("DELETE FROM PaymentMethodSetting WHERE PaymentMethodID='".$input['PaymentMethod'.DTR.'PaymentMethodID']."'");
		}
	}
	if($input['actionMode']=='delete1')
	{
		if(!empty($input['PaymentMethodSetting'.DTR.'PaymentMethodSettingID']))
		{
			$DS->query("DELETE FROM PaymentMethodSetting WHERE PaymentMethodSettingID='".$input['PaymentMethodSetting'.DTR.'PaymentMethodSettingID']."'");
		}
	}
	elseif($input['actionMode']=='add' || $input['actionMode']=='save')
	{
		$saveResult = $PaymentMethodSetting->setPaymentMethod($input);
	}	
	elseif($input['actionMode']=='add1' || $input['actionMode']=='save1')
	{
		$FM = new FilesManager();
		$uploadRS = $FM->uploadFile();
		if(!empty($uploadRS['SettingValue']['file']))
		{
			$input['PaymentMethodSetting'.DTR.'SettingValue']= $uploadRS['PaymentMethodSettingValue']['file'];
		}	
		
		if(is_array($input['PaymentMethodSetting'.DTR.'SettingValue']))
		{
			if($input['PaymentMethodSetting'.DTR.'SettingValueType']=='text')
			{
				foreach($input['PaymentMethodSetting'.DTR.'SettingValue'] as $langCode=>$value)
				{
					$PaymentMethodSettingValue .= "<$langCode>".$value."</$langCode>";
				}
			}
			else
			{
				$PaymentMethodSettingValue = '|'. implode("|",$input['PaymentMethodSetting'.DTR.'SettingValue']).'|';
			}
			$input['PaymentMethodSetting'.DTR.'SettingValue'] = $PaymentMethodSettingValue;	
		}
		$where['PaymentMethodSetting'] = "PaymentMethodSettingID='".$input['PaymentMethodSetting'.DTR.'PaymentMethodSettingID'] ."'";
		
		if(!empty($input['PaymentMethodSetting'.DTR.'SettingVariableName']) && $input['actionMode']=='add')
		{
			$checkRS=$DS->query("SELECT SettingVariableName FROM PaymentMethodSetting WHERE SettingVariableName='".$input['PaymentMethodSetting'.DTR.'SettingVariableName']."'");
		}
		if(count($checkRS)<1 && !empty($input['PaymentMethodSetting'.DTR.'SettingVariableName']))
		{		
			$lastActioMode = $input['actionMode'];
			$input['actionMode']='save';		
			$saveResult = $DS->save($input,$where);
			if($lastActioMode=='add1') {$entityID = $DS->dbLastID(); }
		}
	}	
	elseif($input['actionMode']=='savelist')
	{
		if(is_array($input['PaymentMethodSetting'.DTR.'PaymentMethodSettingID']))
		{
			foreach($input['PaymentMethodSetting'.DTR.'PaymentMethodSettingID'] as $id=>$value)
			{
				//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingVariableName'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingVariableName'][$id];
				if(is_array($input['PaymentMethodSetting'.DTR.'PaymentMethodSettingValue_'.$value]))
				{
					$fieldValeResult='';
					$k=1;
					foreach($input['PaymentMethodSetting'.DTR.'PaymentMethodSettingValue_'.$value] as $itemIndex=>$itemValue)
					{
						if(is_numeric($itemIndex))
						{
							if($k==1)
							{
								$fieldValeResult .= "|$itemValue|";
								$k++;
							}
							else
							{
								$fieldValeResult .= "$itemValue|";
							}
					 	}
						else
						{
							$fieldValeResult .= "<$itemIndex>".$itemValue."</$itemIndex>";
						}
					}
					$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingValue'] = $fieldValeResult;
				}
				else
				{
					if(!empty($input['PaymentMethodSetting'.DTR.'SettingValue_'.$value])) { $inputSave['PaymentMethodSetting'.DTR.'SettingValue'] = $input['PaymentMethodSetting'.DTR.'SettingValue_'.$value];}
					else {$inputSave['PaymentMethodSetting'.DTR.'SettingValue'] = $input['PaymentMethodSetting'.DTR.'SettingValue_'][$id];}
				}
				//print_r($input);
				$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingID'] = $value;
				
				//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingName'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingName'][$id];
				//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingValueType'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingValueType'][$id];
				//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingValueOptions'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingValueOptions'][$id];
				//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingType'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingType'][$id];
				//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingDescription'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingDescription'][$id];
				//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingGroup'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingGroup'][$id];
				//$inputSave['PaymentMethodSetting'.DTR.'PaymentMethodSettingModule'] = $input['PaymentMethodSetting'.DTR.'PaymentMethodSettingModule'][$id];
				//if(is_array($input['PaymentMethodSetting'.DTR.'modules'])) {$input['types'.DTR.'modules'] = '|'. implode("|",$input['types'.DTR.'modules']).'|'; }
				$inputSave['actionMode']='save';
				$where['PaymentMethodSetting'] = "PaymentMethodSettingID='".$value."'";
				$saveResult = $DS->save($inputSave,$where);			
			} 
		}   	
	}
	if(!empty($saveResult['PaymentMethodID']))
	{
		$entityID = $saveResult['PaymentMethodID'];
	}
	
	//get 1 item details
	if(!empty($entityID))
	{
		//$PaymentRS = $PaymentMethod->getPaymentMethod($input);
		
		$PaymentRS = $DS->query("SELECT * FROM PaymentMethod WHERE PaymentMethodID='$entityID'");
		$result['DB']['PaymentMethod'] = $PaymentRS;	
		
		if($input['PaymentMethodSettingID'])
		{
			$PaymentSettingRS = $DS->query("SELECT * FROM PaymentMethodSetting WHERE PaymentMethodSettingID='".$input['PaymentMethodSettingID']."'");
			$result['DB']['PaymentMethodSetting'] = $PaymentSettingRS;
		}
		
		$PaymentSettingsRS = $DS->query("SELECT * FROM PaymentMethodSetting WHERE PaymentMethodID='$entityID'");
		$result['DB']['PaymentMethodSettings'] = $PaymentSettingsRS;
	}	
	
	$PaymentsRS = $DS->query("SELECT PaymentMethodID,PaymentMethodName FROM PaymentMethod");
	$result['DB']['PaymentMethods'] = $PaymentsRS;
	
	$languagesList = $CORE->getLanguages();
	$result['DB']['Languages'] = $languagesList;
	
	//return result array
	return $result;
}

?>
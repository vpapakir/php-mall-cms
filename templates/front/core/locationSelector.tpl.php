<?//print_r($input);?>
<?=boxHeader(array('title'=>'LocationSelector.core.title'))?>
<? $level = 'district';?>
<tr>

<? if (input('redirectMode')!=1){ ?>
<SCRIPT language=JavaScript>
	rs1 = window.opener.document.<?=input('formName')?>.<?=input('fieldName')?>.value;
	if (rs1 != ''){
	//alert('<?=setting('url')?><?=input('SID')?>');
	window.location = '<?=setting('url')?><?=input('SID')?>/redirectMode/1/locStr/'+rs1+'/formName/<?=input('formName')?>/fieldName/<?=input('fieldName')?>/windowMode/popupselector';
}
</SCRIPT>
<? } ?>

	<? $formName = 'locationSelector';?>
	<form method="post" name="<?=$formName?>">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
		<input type="hidden" name="location" value="<?=input('location')?>" />
		<input type="hidden" name="formName" value="<?=input('formName')?>" />
		<input type="hidden" name="fieldName" value="<?=input('fieldName')?>" />
		<input type="hidden" name="redirectMode" value="1" />
		<input type="hidden" name="locStr" value=" " />
		<input type="hidden" name="changedItem" value=" " />
		<td>
		<div class="subtitle"><?=lang('LocationSelector.core.title')?></div>
		<br/>
		<? /* if(count($out['DB']['Continents'])>0) { ?>
			<?=lang('SelectContinent.core.tip')?>: <br/>
			<?=getLists($out['DB']['Continents'],$continentID,array('name'=>'ContinentID','id'=>'RegionID','value'=>'RegionName','options'=>$options,'style'=>'width:150px','action'='submit()')); ?>
		<? } */ ?>
		<? $options[0]['id']=''; $options[0]['value']=lang('-select'); ?>		
		<? $options[1]['id']='-'; $options[1]['value']=lang('SelectLocationNotInList.core.tip'); ?>		
		<? if(count($out['DB']['Countries'])>0) { ?>
			<?=lang('SelectCountry.core.tip')?>: <br/>
			<?=getLists($out['DB']['Countries'],$out['DB']['Country']['RegionID'],array('name'=>'CountryID','id'=>'RegionID','value'=>'RegionName','options'=>$options,'style'=>'width:150px','action'=>"document.locationSelector.changedItem.value = 'CountryID'; submit()")); ?>
			<br/>
		<? } ?>
		<? if(!empty($out['DB']['Country']['RegionCode']) && count($out['DB']['Countries'])>0 && !input('CountryName')) { ?>
			<input type="hidden" name="CountryCode" value="<?=$out['DB']['Country']['RegionCode']?>" />
			<input type="hidden" name="CountryValByCode" value="<?=getValue($out['DB']['Country']['RegionName'])?>" />
		<? } elseif (input('CountryID')=='-' && ($level=='country' || $level=='region' || $level=='city' || $level=='district') || input('CountryName')) { ?>
			<?=lang('EnterCountryName.core.tip')?>: <br/>
			<input type="text" name="CountryName" value="<?=stripslashes(input('CountryName'))?>" size="25" />
			<br/>
		<? } ?>
		
		<? if(count($out['DB']['Regions'])>0 && !input('RegionName')) { ?>
			<?=lang('SelectRegion.core.tip')?>: <br/>
			<?=getLists($out['DB']['Regions'],$out['DB']['Region']['RegionID'],array('name'=>'RegionID','id'=>'RegionID','value'=>'RegionName','options'=>$options,'style'=>'width:150px','action'=>"document.locationSelector.changedItem.value = 'RegionID'; submit()")); ?>
			<br/>
		<? } ?>
		<? //echo "ff ".$out['DB']['Region']['RegionID']; 
		    if(!empty($out['DB']['Region']['RegionCode']) && count($out['DB']['Regions'])>0 && !input('RegionName')) {?>
			<input type="hidden" name="RegionCode" value="<?=$out['DB']['Region']['RegionCode']?>" />
			<input type="hidden" name="RegionValByCode" value="<?=getValue($out['DB']['Region']['RegionName'])?>" />
		<? } elseif ((count($out['DB']['Regions'])==0 || input('RegionID')=='-') && input('CountryID') && ($level=='region' || $level=='city' || $level=='district') || input('RegionName')) { ?>
			<?=lang('EnterRegionName.core.tip')?>: <br/>
			<input type="text" name="RegionName" value="<?=stripslashes(input('RegionName'))?>" size="25" />
			<br/>
		<? } ?>

		<? if(count($out['DB']['Cities'])>0 && !input('CityName')) { ?>
			<?=lang('SelectCity.core.tip')?>: <br/>
			<?=getLists($out['DB']['Cities'],$out['DB']['City']['RegionID'],array('name'=>'CityID','id'=>'RegionID','value'=>'RegionName','options'=>$options,'style'=>'width:150px','action'=>"document.locationSelector.changedItem.value = 'CityID';submit()")); ?>
			<br/>
		<? } ?>
		<? //echo "ee ".input('CityName'); 
		    if(!empty($out['DB']['City']['RegionCode']) && count($out['DB']['Cities'])>0 && !input('CityName')) { ?>
			<input type="hidden" name="CityCode" value="<?=$out['DB']['City']['RegionCode']?>" />
			<input type="hidden" name="CityValByCode" value="<?=getValue($out['DB']['City']['RegionName'])?>" />
		<? } elseif ((count($out['DB']['Regions'])==0 || input('RegionID')) && (count($out['DB']['Cities'])==0 || input('CityID')=='-') && input('CountryID') && ($level=='city' || $level=='district') || input('CityName')) { ?>
			<?=lang('EnterCityName.core.tip')?>: <br/>
			<input type="text" name="CityName" value="<?=stripslashes(input('CityName'))?>" size="25" />
			<br/>
		<? } ?>
		
		<? if(count($out['DB']['Districts'])>0 && !input('DistrictName')) { ?>
			<?=lang('SelectDistrict.core.tip')?>: <br/>
			<?=getLists($out['DB']['Districts'],$out['DB']['District']['RegionID'],array('name'=>'DistrictID','id'=>'RegionID','value'=>'RegionName','options'=>$options,'style'=>'width:150px','action'=>"document.locationSelector.changedItem.value = 'DistrictID';submit()")); ?>
			<br/>
		<? } ?>			
		<? if(!empty($out['DB']['District']['RegionCode']) && count($out['DB']['Districts'])>0 && !input('DistrictName')) { ?>
			<input type="hidden" name="DistrictCode" value="<?=$out['DB']['District']['RegionCode']?>" />
			<input type="hidden" name="DistrictValByCode" value="<?=getValue($out['DB']['District']['RegionName'])?>" />
		<? } elseif ((count($out['DB']['Regions'])==0 || input('RegionID')) && (count($out['DB']['Cities'])==0 || input('CityID')) && (count($out['DB']['Districts'])==0 || input('DistrictID')=='-') && input('CountryID') && $level=='district' || input('DistrictName')) { ?>
			<?=lang('EnterDistrictName.core.tip')?>: <br/>
			<input type="text" name="DistrictName" value="<?=stripslashes(input('DistrictName'))?>" size="25" />
		<? } ?>
		<br/><br/>
		<input type="button" name="selectLocationButton" value="<?=lang('SelectLocation.core.button')?>" onClick="setLocationCode()" style="width:150px;"/>
		<br/><br/>
		<input type="button" name="selectLocationButton" value="<?=lang('CancelSelection.core.button')?>" onClick="window.close();window.opener.focus();" style="width:150px;" />

		</td>
	</form>
</tr>
<script language="javascript">
	function getLocationCode()
	{
		var result = '|';
		if(document.locationSelector.CountryCode)
		{
			result = result + document.locationSelector.CountryCode.value + '|';
		}
		else if (document.locationSelector.CountryName)
		{
			result = result + '[' + document.locationSelector.CountryName.value + ']|';
		} 
		if(document.locationSelector.RegionCode)
		{
			result = result + document.locationSelector.RegionCode.value + '|';
		}
		else if (document.locationSelector.RegionName)
		{
			result = result + '[' + document.locationSelector.RegionName.value + ']|';
		} 
		
		if(document.locationSelector.CityCode)
		{
			result = result + document.locationSelector.CityCode.value + '|';
		}		
		else if (document.locationSelector.CityName)
		{
			result = result + '[' + document.locationSelector.CityName.value + ']|';
		} 
		
		if(document.locationSelector.DistrictCode)
		{
			result = result + document.locationSelector.DistrictCode.value + '|';
		}	
		else if (document.locationSelector.DistrictName)
		{
			result = result + '[' + document.locationSelector.DistrictName.value + ']|';
		} 
		
		return result;
	}


	function getLocationStr()
	{
		var result = '';
		if(document.locationSelector.CountryValByCode)
		{
			result = result + document.locationSelector.CountryValByCode.value;
		}
		else if (document.locationSelector.CountryName)
		{
			result = result + document.locationSelector.CountryName.value;
		} 
		if(document.locationSelector.RegionValByCode)
		{
			result = result + ', ' + document.locationSelector.RegionValByCode.value;
		}
		else if (document.locationSelector.RegionName)
		{
			result = result + ', ' + document.locationSelector.RegionName.value + ', ';
		} 
		
		if(document.locationSelector.CityValByCode)
		{
			result = result + ', ' + document.locationSelector.CityValByCode.value;
		}		
		else if (document.locationSelector.CityName)
		{
			result = result + ', ' + document.locationSelector.CityName.value;
		} 
		
		if(document.locationSelector.DistrictValByCode)
		{
			result = result + ', ' + document.locationSelector.DistrictValByCode.value;
		}	
		else if (document.locationSelector.DistrictName)
		{
			result = result + ', ' + document.locationSelector.DistrictName.value;
		} 
		
		return result;
	}

	
	function setLocationCode()
	{
		var rs, rsD;
		rs = getLocationCode ();
		rsD = getLocationStr ();
		//alert('code=' + rs);
		window.opener.focus();
		//window.opener.location=url;
		window.opener.document.<?=input('formName')?>.<?=input('fieldName')?>.value=rs;
		window.opener.document.<?=input('formName')?>.<?=input('fieldName')?>_Display.value=rsD;
		window.close();
	}
</script>
<?=boxFooter()?>
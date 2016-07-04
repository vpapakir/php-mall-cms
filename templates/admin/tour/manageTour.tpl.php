<? if(input('viewMode')=='view') { getBox('tour.getTour'); } else { ?>
<? $formName = 'manageTours'; $entityID = $out['DB']['Tour'][0]['TourID']; $categoryID = input('CategoryID'); ?>
<? //boxHeader(array('title'=>'ManageTour.tour.title'))?>
<?=boxHeader(array('title'=>'ManageTour.tour.title','tabs'=>'manageTour','formName'=>$formName,'tabslink'=>'TourID/'.input('TourID')))?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageTour" />
		<? if(empty($out['DB']['Tour'][0]['TourID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="Tour<?=DTR?>TourID" value="<?=$out['DB']['Tour'][0]['TourID']?>">
		<input type="hidden" name="TourID" value="<?=$out['DB']['Tour'][0]['TourID']?>">
		<? } ?>		
		<input type="hidden" name="AddFieldOptionFieldCode" value="" >		
		<input type="hidden" name="DeleteFieldOptionID" value="" >			
		<? 
						if(!input('viewMode') || input('viewMode')=='profile')
						{
							?>
							<input type="hidden" name="tabLink" value="9" >
							<?
						}
						elseif(input('viewMode')=='details')
						{
							?>
							<input type="hidden" name="tabLink" value="10" >
							<?
						}
						elseif(input('viewMode')=='rates')
						{
							?>
							<input type="hidden" name="tabLink" value="11" >
							<?
						}
						elseif(input('viewMode')=='description')
						{
							?>
							<input type="hidden" name="tabLink" value="12" >
							<?
						}
						else
						{
							?>
							<input type="hidden" name="tabLink" value="13" >
							<?
						}
		?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table width="100%"  border="0" cellspacing="1" cellpadding="3" bgcolor="#eeeeee">
		  	  		<? 
						if(!input('viewMode') || input('viewMode')=='profile')
						{
							getTourFormProfileFields($out);
						}
						elseif(input('viewMode')=='details')
						{
							getTourFormDetailsFields($out);
						}
						elseif(input('viewMode')=='rates')
						{
							getTourFormRatesFields($out);
						}
						elseif(input('viewMode')=='description')
						{
							getTourFormDescriptionFields($out);
						}		
					?>			  		  
				  <tr>
					<td colspan="2" align="center" bgcolor="#EEEEEE">
						<? if(empty($out['DB']['Tour'][0]['TourID'])) { ?>
						<input type="submit" value="<?=lang("-add")?>">
						<? } else { ?>
						<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageTours.actionMode.value='delete';confirmDelete('manageTours', '<?=lang("-deleteconfirmation")?>');">
						<? } ?>					
						&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageTours.actionMode.value='cancell';submit();">
					</td>
				  </tr>
				</table>	
				<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>
<? } ?>

<?
	function getTourFormProfileFields($out)
	{
		?>
		<input type="hidden" name="viewMode" value="details" />
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('SelectTourCountry.tour.tip')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<?
					$options[0]['id']='';	
					$options[0]['value']=lang('TourCountrySelect.tour.tip');
					//print_r($out['DB']['Tour']);
					echo getLists($out['DB']['Countries'],$out['DB']['Tour'][0]['TourCountryID'],array('name'=>'Tour'.DTR.'TourCountryID','id'=>'RegionID','value'=>'RegionName','style'=>'width:200px;','options'=>$options,'editlink'=>'manageRegions/'));	
				?>					
			</td>
		  </tr>
		  <tr>
			<td class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourType')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('TourTypeSelect.tour.tip').' -';
					echo getLists($out['DB']['TourTypes'],$out['DB']['Tour'][0]['TourType'],array('name'=>'Tour'.DTR.'TourType','id'=>'TourTypeAlias','value'=>'TourTypeName','style'=>'width:200px;','options'=>$options,'editlink'=>'manageTourTypes/'));	
				?>	
			</td>
		  </tr>
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactFirstName')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<input type="text" name="Tour<?=DTR?>TourContactFirstName" size="35" value="<?=$out['DB']['Tour'][0]['TourContactFirstName']?>" />
			</td>
		  </tr>
		  <tr>
			<td class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactLastName')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<input type="text" name="Tour<?=DTR?>TourContactLastName" size="35" value="<?=$out['DB']['Tour'][0]['TourContactLastName']?>" />
			</td>
		  </tr>
		  <tr>
			<td class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactAddress')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<input type="text" name="Tour<?=DTR?>TourContactAddress" size="35" value="<?=$out['DB']['Tour'][0]['TourContactAddress']?>" />
			</td>
		  </tr>	
		  <tr>
			<td class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactPostalCode')?>/<?=lang('Tour.TourContactCity')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<input type="text" name="Tour<?=DTR?>TourContactPostalCode" size="5" value="<?=$out['DB']['Tour'][0]['TourContactPostalCode']?>" /> <input type="text" name="Tour<?=DTR?>TourContactCity" size="26" value="<?=$out['DB']['Tour'][0]['TourContactCity']?>" />
			</td>
		  </tr>	
		  <? /* tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactRegionID')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<?
					$options[0]['id']='';	
					$options[0]['value']=lang('TourContactRegionSelect.tour.tip');
					echo getLists($out['DB']['Regions'],$out['DB']['Tour'][0]['TourContactRegionID'],array('name'=>'Tour'.DTR.'TourContactRegionID','id'=>'RegionID','value'=>'RegionName','style'=>'width:200px;','options'=>$options,'editlink'=>'manageRegions/'));	
				?>					
			</td>
		  </tr */ ?>
		  <tr>
			<td class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactRegion')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<input type="text" name="Tour<?=DTR?>TourContactRegion" size="35" value="<?=$out['DB']['Tour'][0]['TourContactRegion']?>" />
			</td>
		  </tr>		  
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactCountryID')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<?
					$options[0]['id']='';	
					$options[0]['value']=lang('TourContactCountrySelect.tour.tip');
					echo getLists($out['DB']['Countries'],$out['DB']['Tour'][0]['TourContactCountryID'],array('name'=>'Tour'.DTR.'TourContactCountryID','id'=>'RegionID','value'=>'RegionName','style'=>'width:200px;','options'=>$options,'editlink'=>'manageRegions/'));	
				?>					
			</td>
		  </tr>
		  <tr>
			<td class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactPhone')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<input type="text" name="Tour<?=DTR?>TourContactPhone" size="35" value="<?=$out['DB']['Tour'][0]['TourContactPhone']?>" />
				<input type="hidden" name="Tour<?=DTR?>TourContactAccessOptions[]" value="-" />
				<? $option = 'phone'; if(@eregi("\|".$option."\|",$out['DB']['Tour'][0]['TourContactAccessOptions'])) { $checked ='checked';} else {$checked ='';}?>
				<input type="checkbox" name="Tour<?=DTR?>TourContactAccessOptions[]" value="<?=$option?>" <?=$checked?> /> <?=lang('PublishOption.tour.tip')?>
			</td>
		  </tr>	
		  <tr>
			<td class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactFax')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<input type="text" name="Tour<?=DTR?>TourContactFax" size="35" value="<?=$out['DB']['Tour'][0]['TourContactFax']?>" />
				<? $option = 'fax'; if(@eregi("\|".$option."\|",$out['DB']['Tour'][0]['TourContactAccessOptions'])) { $checked ='checked';} else {$checked ='';}?>
				<input type="checkbox" name="Tour<?=DTR?>TourContactAccessOptions[]" value="<?=$option?>" <?=$checked?> /> <?=lang('PublishOption.tour.tip')?>
			</td>
		  </tr>	
		  <tr>
			<td class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactEmail')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<input type="text" name="Tour<?=DTR?>TourContactEmail" size="35" value="<?=$out['DB']['Tour'][0]['TourContactEmail']?>" />
				<? $option = 'email'; if(@eregi("\|".$option."\|",$out['DB']['Tour'][0]['TourContactAccessOptions'])) { $checked ='checked';} else {$checked ='';}?>
				<input type="checkbox" name="Tour<?=DTR?>TourContactAccessOptions[]" value="<?=$option?>" <?=$checked?> /> <?=lang('PublishOption.tour.tip')?>
			</td>
		  </tr>	
		  <tr>
			<td class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactWebsite')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<input type="text" name="Tour<?=DTR?>TourContactWebsite" size="35" value="<?=$out['DB']['Tour'][0]['TourContactWebsite']?>" />
				<? $option = 'web'; if(@eregi("\|".$option."\|",$out['DB']['Tour'][0]['TourContactAccessOptions'])) { $checked ='checked';} else {$checked ='';}?>
				<input type="checkbox" name="Tour<?=DTR?>TourContactAccessOptions[]" value="<?=$option?>" <?=$checked?> /> <?=lang('PublishOption.tour.tip')?>
			</td>
		  </tr>
		  <tr>
			<td class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactICQ')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<input type="text" name="Tour<?=DTR?>TourContactICQ" size="35" value="<?=$out['DB']['Tour'][0]['TourContactICQ']?>" />
				<? $option = 'icq'; if(@eregi("\|".$option."\|",$out['DB']['Tour'][0]['TourContactAccessOptions'])) { $checked ='checked';} else {$checked ='';}?>
				<input type="checkbox" name="Tour<?=DTR?>TourContactAccessOptions[]" value="<?=$option?>" <?=$checked?> /> <?=lang('PublishOption.tour.tip')?>
			</td>
		  </tr>
		  <tr>
			<td class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourContactSkype')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<input type="text" name="Tour<?=DTR?>TourContactSkype" size="35" value="<?=$out['DB']['Tour'][0]['TourContactSkype']?>" />
				<? $option = 'skype'; if(@eregi("\|".$option."\|",$out['DB']['Tour'][0]['TourContactAccessOptions'])) { $checked ='checked';} else {$checked ='';}?>
				<input type="checkbox" name="Tour<?=DTR?>TourContactAccessOptions[]" value="<?=$option?>" <?=$checked?> /> <?=lang('PublishOption.tour.tip')?>
			</td>
		  </tr>		
		  <tr>
			<td class="subtitle" bgcolor="#ffffff" valign="top"><?=lang('Tour.TourContactComments')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<textarea cols="35" rows="2" name="Tour<?=DTR?>TourContactComments" wrap="virtual"><?=$out['DB']['Tour'][0]['TourContactComments']?></textarea>
			</td>
		  </tr>	
		  <tr>
			<td class="subtitle" bgcolor="#ffffff" valign="top"><?=lang('Tour.TourActionOptions')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<?=getReference('Tour.TourActionOptions','Tour'.DTR.'TourActionOptions',$out['DB']['Tour'][0]['TourActionOptions'],array('code'=>'Y','delimiter'=>'<br/>'))?>
			</td>
		  </tr>		  	
	  <?	
	}
	
	function getTourFormDetailsFields($out)
	{
		?>
		<input type="hidden" name="viewMode" value="rates" />
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourTitle')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<?=$out['DB']['Tour'][0]['TourContactFirstName']?> <?=$out['DB']['Tour'][0]['TourContactLastName']?> <? if(!empty($out['DB']['Tour'][0]['TourTitle'])) { ?> (<?=getValue($out['DB']['Tour'][0]['TourTitle']) ?>) <? } ?>
			</td>
		  </tr>		
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourRegionID')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<?
					$options[0]['id']='';	
					$options[0]['value']=lang('TourRegionSelect.tour.tip');
					echo getLists($out['DB']['Regions'],$out['DB']['Tour'][0]['TourRegionID'],array('name'=>'Tour'.DTR.'TourRegionID','id'=>'RegionID','value'=>'RegionName','style'=>'width:200px;','editlink'=>'manageRegions/RegionParentID/'.$out['DB']['Tour'][0]['TourCountryID'],'options'=>$options,'action'=>'viewMode.value=\''.input('viewMode').'\';submit();'));	
				?>					
			</td>
		  </tr>
		  <tr>
			<td class="subtitle" bgcolor="#ffffff"><?=lang('SelectTourCity.tour.tip')?></td>
			<td class="subtitle" bgcolor="#ffffff">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('TourCitySelect.tour.tip').' -';
					echo getLists($out['DB']['Cities'],$out['DB']['Tour'][0]['TourCityID'],array('name'=>'Tour'.DTR.'TourCityID','id'=>'RegionID','value'=>'RegionName','editlink'=>'manageRegions/RegionParentID/'.$out['DB']['Tour'][0]['TourRegionID'],'style'=>'width:200px;','options'=>$options));	
				?>	
			</td>
		  </tr>	
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourCity')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<input type="text" name="Tour<?=DTR?>TourCity" size="35" value="<?=$out['DB']['Tour'][0]['TourCity']?>" />
			</td>
		  </tr>		  
			<?=showTourExtraFieldsForm($out,'details')?>	
			
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff" valign="top"><?=lang('Tour.TourComments')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<textarea cols="50" rows="5" name="Tour<?=DTR?>TourComments"><?=$out['DB']['Tour'][0]['TourComments']?></textarea>
			</td>
		  </tr>				
	  <?	
	}	
	
	function getTourFormRatesFields($out)
	{
		?>
		<input type="hidden" name="viewMode" value="description" />
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourTitle')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<?=$out['DB']['Tour'][0]['TourContactFirstName']?> <?=$out['DB']['Tour'][0]['TourContactLastName']?> <? if(!empty($out['DB']['Tour'][0]['TourTitle'])) { ?> (<?=getValue($out['DB']['Tour'][0]['TourTitle']) ?>) <? } ?>
			</td>
		  </tr>		
		 <!--  <tr> -->
		<? 
			//get room types
			$roomTypes = getTourFieldsTypesForRatesShow($out,'TourAvailableRoomsValue1');
			//get service types
			$serviceTypes = getTourFieldsTypesForRatesShow($out,'TourAvailableBoardValue1');
			//get all season types
			$seasonAllTypes = getTourFieldsTypesForRatesShow($out,'TourAvailableSeasonsValue2');
			//filter and get only active season types
			$seasonTypes = getTourActiveSeasonsForRatesShow($out,$seasonAllTypes);
			//print_r($seasonTypes);
		?>
		<? 
			if(is_array($seasonTypes)) { foreach($seasonTypes as $seasonType) {
			
			//$seasonType['code']='s1';
			$i++;
			$TourRatePricePerPerson = ''; 
			$TourRateMinimumNights = ''; 
			$TourRateComments = ''; 
			
			if(is_array($out['DB']['TourRates'])) { 
				foreach($out['DB']['TourRates'] as $row) { 
					if($row['SeasonType']==$seasonType['code'] && empty($row['RoomType']) && empty($row['ServiceType']) && $row['TourID']==$out['DB']['Tour'][0]['TourID'] ) { 
						$TourRatePricePerPerson=$row['TourRatePricePerPerson']; 
						$TourRateMinimumNights=$row['TourRateMinimumNights']; 
						$TourRateComments=$row['TourRateComments']; 
					} 
				} 
			} 
		?>		
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#EEEEEE"><?=$seasonType['name']?> <?=lang('SeasonSubtitle.tour.tip')?></td>
			<td width="70%" class="subtitle" bgcolor="#EEEEEE">
				<? foreach ($seasonType['options'] as $seasonTypeOption) { ?>
					<?=$seasonTypeOption['name']?><br/>
				<? } ?>
			</td>
		  </tr>		
		<input type="hidden" name="TourRate<?=DTR?>TourID[<?=$i?>]" value="<?=$out['DB']['Tour'][0]['TourID']?>" />
		<input type="hidden" name="TourRate<?=DTR?>SeasonType[<?=$i?>]" value="<?=$seasonType['code']?>" />							
		<input type="hidden" name="TourRate<?=DTR?>RoomType[<?=$i?>]" />
		<input type="hidden" name="TourRate<?=DTR?>ServiceType[<?=$i?>]" />
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('TourRate.TourRatePricePerPerson')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<?=getReference('TourRate.TourRatePricePerPerson','TourRate'.DTR.'TourRatePricePerPerson['.$i.']',$TourRatePricePerPerson,array('code'=>'Y','delimiter'=>' '))?>
			</td>
		  </tr>		
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('TourRate.TourRateMinimumNights')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<input type="text" name="TourRate<?=DTR?>TourRateMinimumNights[<?=$i?>]" value="<?=$TourRateMinimumNights?>" size="10" />
			</td>
		  </tr>
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('TourRate.TourRateComments')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<input type="text" name="TourRate<?=DTR?>TourRateComments[<?=$i?>]" value="<?=$TourRateComments?>" size="50" />
			</td>
		  </tr>		  		  
		  <tr>		  
			<td width="100%" class="subtitle" bgcolor="#ffffff" colspan="2">
				<? if(is_array($roomTypes) && is_array($serviceTypes)) { ?>
				<table cellpadding="3" cellspacing="1" border="0" width="100%">
					<tr>
						<td width="30%">
							<b><?=lang('ServiceRateColumnName.tour.tip')?></b>
						</td>
						<? foreach($serviceTypes as $serviceType) { ?>
						<td class="row1" align="center">
							<b><?=$serviceType['name']?></b>
						</td>
						<? } ?>
					</tr>				
					<? foreach($roomTypes as $roomType) {  ?>
					<tr>
						<td>
							<? if(is_array($out['DB']['TourRates'])) { foreach($out['DB']['TourRates'] as $row) { ?>
								<? if($row['SeasonType']==$seasonType['code'] && $row['RoomType']==$roomType['code'] && $row['TourID']==$out['DB']['Tour'][0]['TourID'] ) { if($row['PermAll']==1) {$checked='checked';} else {$checked='';} } ?>
							<? }}
							$seasonTypeForActivation = $seasonType['code']; $roomTypeForActivation = $roomType['code']; ?>
							<input type="checkbox" name="TourRateActivation[<?=$seasonTypeForActivation.DTR.$roomTypeForActivation?>]" value="1" <?=$checked?> /> <?=$roomType['name']?>
						</td>
						<? foreach($serviceTypes as $serviceType) { $i++;  ?>
						<td class="row1" align="center">
							<input type="hidden" name="TourRate<?=DTR?>TourID[<?=$i?>]" value="<?=$out['DB']['Tour'][0]['TourID']?>" />
							<input type="hidden" name="TourRate<?=DTR?>SeasonType[<?=$i?>]" value="<?=$seasonType['code']?>" />							
							<input type="hidden" name="TourRate<?=DTR?>RoomType[<?=$i?>]" value="<?=$roomType['code']?>" />
							<input type="hidden" name="TourRate<?=DTR?>ServiceType[<?=$i?>]" value="<?=$serviceType['code']?>" />
							<? if(is_array($out['DB']['TourRates'])) { $fieldiswithvalie = 'N'; foreach($out['DB']['TourRates'] as $row) { ?>
								<? if($row['SeasonType']==$seasonType['code'] && $row['RoomType']==$roomType['code'] && $row['ServiceType']==$serviceType['code'] && $row['TourID']==$out['DB']['Tour'][0]['TourID'] ) { ?>
								<input type="hidden" name="TourRate<?=DTR?>TourRateID[<?=$i?>]" value="<?=$row['TourRateID']?>" />
								<input type="text" name="TourRate<?=DTR?>TourRatePrice[<?=$i?>]" value="<?=$row['TourRatePrice']?>" size="5" />
								<? $fieldiswithvalie = 'Y'; } ?>
							<? } if ($fieldiswithvalie =='N') { ?>
								<input type="hidden" name="TourRate<?=DTR?>TourRateID[<?=$i?>]" value="" />
								<input type="text" name="TourRate<?=DTR?>TourRatePrice[<?=$i?>]" value="" size="5" />
							<? }} ?>
						</td>
						<? } ?>
					</tr>
					<? } ?>
				</table>	
				<? } ?>			
			</td>
		  </tr>		
		  <? } } // end of if(is_array($seasonTypes)) { foreach($seasonTypes as $seasonType)  ?>  
			<?=showTourExtraFieldsForm($out,'rates')?>	
	  <?	
	}	


		
	function getTourFormDescriptionFields($out)
	{
		?>
		<input type="hidden" name="viewMode" value="view" />
		  <tr>
			<td width="30%" class="subtitle" bgcolor="#ffffff"><?=lang('Tour.TourTitle')?></td>
			<td width="70%" class="subtitle" bgcolor="#ffffff">
				<?=$out['DB']['Tour'][0]['TourContactFirstName']?> <?=$out['DB']['Tour'][0]['TourContactLastName']?> <? if(!empty($out['DB']['Tour'][0]['TourTitle'])) { ?> (<?=getValue($out['DB']['Tour'][0]['TourTitle']) ?>) <? } ?>
			</td>
		  </tr>		
		<tr>
			<td colspan="2" align="left" bgcolor="#EEEEEE" class="subtitle" >
			<?=lang('TourTitle.tour.subtitle')?>:
			</td>
		</tr>
		<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
		<tr>
			<td width="30%" valign="top" bgcolor="#ffffff">
			 <?=$out['DB']['Languages']['languageNames'][$langID]?>
			</td>
			<td width="70%"  bgcolor="#ffffff">

<script language="javascript" type="text/javascript">
var MAX_symbols_title=50;
var text;
function <?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_title ()
{
if(document.getElementById ('<?=$out['DB']['Languages']['languageNames'][$langID]?>_title').value.length > MAX_symbols_title)
{
document.getElementById ('<?=$out['DB']['Languages']['languageNames'][$langID]?>_title').value = document.getElementById ('<?=$out['DB']['Languages']['languageNames'][$langID]?>_title').value.substring(0, MAX_symbols_title);
return;
}
document.getElementById('<?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_title').innerHTML = MAX_symbols_title-document.getElementById ('<?=$out['DB']['Languages']['languageNames'][$langID]?>_title').value.length;
}
</script>

				<textarea cols=34 rows=2 name="Tour<?=DTR?>TourTitle[<?=$langCode?>]" id="<?=$out['DB']['Languages']['languageNames'][$langID]?>_title" onKeyUp="<?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_title()" maxlength="50"><?=getValue($out['DB']['Tour'][0]['TourTitle'],$langCode);?></textarea>
				<br><span onCreate="<?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_title()" align="left" id="<?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_title"><?=50-strlen(getValue($out['DB']['Tour'][0]['TourTitle'],$langCode));?></span> <?=lang('Tour.CharactersLeft')?>

				
			</td>
		</tr>
		<? } ?>	
		<tr>
			<td colspan="2" align="left" bgcolor="#EEEEEE" class="subtitle" bgcolor="#ffffff">
			<?=lang('TourIntro.tour.subtitle')?>:
			</td>
		</tr>
		<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
		<tr>
			<td width="30%" c valign="top" bgcolor="#ffffff">
			 <?=$out['DB']['Languages']['languageNames'][$langID]?>
			</td>
			<td width="70%" bgcolor="#ffffff">
<script language="javascript" type="text/javascript">
var MAX_symbols_intro=300;
var text;
function <?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_intro ()
{
if(document.getElementById ('<?=$out['DB']['Languages']['languageNames'][$langID]?>_intro').value.length > MAX_symbols_intro)
{
document.getElementById ('<?=$out['DB']['Languages']['languageNames'][$langID]?>_intro').value = document.getElementById ('<?=$out['DB']['Languages']['languageNames'][$langID]?>_intro').value.substring(0, MAX_symbols_intro);
return;
}
document.getElementById('<?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_intro').innerHTML = MAX_symbols_intro-document.getElementById ('<?=$out['DB']['Languages']['languageNames'][$langID]?>_intro').value.length;
}
</script>
				<textarea name="Tour<?=DTR?>TourIntro[<?=$langCode?>]" cols="34" rows="5" id="<?=$out['DB']['Languages']['languageNames'][$langID]?>_intro" onKeyUp="<?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_intro()" maxlength="300"><?=getValue($out['DB']['Tour'][0]['TourIntro'],$langCode);?></textarea><br>
				<span align="left" id="<?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_intro"><?=300-strlen(getValue($out['DB']['Tour'][0]['TourTitle'],$langCode));?></span> <?=lang('Tour.CharactersLeft')?>
			</td>
		</tr>
		<? } ?>
		<tr>
			<td colspan="2" align="left" bgcolor="#EEEEEE" class="subtitle" bgcolor="#ffffff">
			<?=lang('TourContent.tour.subtitle')?>:
			</td>
		</tr>
		<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
		<tr>
			<td width="30%"  valign="top" bgcolor="#ffffff">
			 <?=$out['DB']['Languages']['languageNames'][$langID]?>
			</td>
			<td width="70%"  bgcolor="#ffffff">
<script language="javascript" type="text/javascript">
var MAX_symbols_desc=2000;
var text;
function <?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_desc ()
{
if(document.getElementById ('<?=$out['DB']['Languages']['languageNames'][$langID]?>_desc').value.length > MAX_symbols_desc)
{
document.getElementById ('<?=$out['DB']['Languages']['languageNames'][$langID]?>_desc').value = document.getElementById ('<?=$out['DB']['Languages']['languageNames'][$langID]?>_desc').value.substring(0, MAX_symbols_desc);
return;
}
document.getElementById('<?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_desc').innerHTML = MAX_symbols_desc-document.getElementById ('<?=$out['DB']['Languages']['languageNames'][$langID]?>_desc').value.length;
}
</script>
				<textarea name="Tour<?=DTR?>TourContent[<?=$langCode?>]" cols="34" rows="10" id="<?=$out['DB']['Languages']['languageNames'][$langID]?>_desc" onKeyUp="<?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_desc()" maxlength="2000"><?=getValue($out['DB']['Tour'][0]['TourContent'],$langCode);?></textarea><br>
				<span align="left" id="<?=$out['DB']['Languages']['languageNames'][$langID]?>_symbols_desc"><?=2000-strlen(getValue($out['DB']['Tour'][0]['TourTitle'],$langCode));?></span> <?=lang('Tour.CharactersLeft')?>
			</td>
		</tr>
		<? } ?>
		<tr>
			<td colspan="2" align="left" bgcolor="#EEEEEE" class="subtitle" bgcolor="#ffffff">
			<?=lang('TourImagesText.tour.subtitle')?>:
			</td>
		</tr>
		<tr>
			<td width="30%"  valign="top" bgcolor="#ffffff">
			 <?=lang('Tour.TourIcon')?>:
			</td>
			<td width="70%"  bgcolor="#ffffff">
			<input type="hidden" name="fileField"/>
			<input type="hidden" name="TourID" value="<?=$out['DB']['Tour'][0]['TourID']?>">
			<? $formName = 'manageTours';?>
			<? $fieldName = 'TourIcon';  echo getFormated($out['DB']['Tour'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Tour','deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.viewMode.value=\''.input('viewMode').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
			</td>
		</tr>
		<tr>
			<td width="30%"  valign="top" bgcolor="#ffffff">
			 <?=lang('Tour.TourImage1')?>:
			</td>
			<td width="70%" bgcolor="#ffffff">
			<? $fieldName = 'TourImage1';  echo getFormated($out['DB']['Tour'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Tour','deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.viewMode.value=\''.input('viewMode').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
			</td>
		</tr>
		<tr>
			<td width="30%"  valign="top" bgcolor="#ffffff">
			 <?=lang('Tour.TourImage2')?>:
			</td>
			<td width="70%" bgcolor="#ffffff">
			<? $fieldName = 'TourImage3';  echo getFormated($out['DB']['Tour'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Tour','deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.viewMode.value=\''.input('viewMode').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
			</td>
		</tr>
		<tr>
			<td width="30%"  valign="top" bgcolor="#ffffff">
			 <?=lang('Tour.TourPreviewImage3')?>:
			</td>
			<td width="70%" bgcolor="#ffffff">
			<? $fieldName = 'TourImage4';  echo getFormated($out['DB']['Tour'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Tour','deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.viewMode.value=\''.input('viewMode').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
			</td>
		</tr>				
		<tr>
			<td width="30%"  valign="top" bgcolor="#ffffff">
			 <?=lang('Tour.TourImage')?>:
			</td>
			<td width="70%" bgcolor="#ffffff">
			<? $fieldName = 'TourImage';  echo getFormated($out['DB']['Tour'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Tour','deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.viewMode.value=\''.input('viewMode').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
			</td>
		</tr>
			<?=showTourExtraFieldsForm($out,'description')?>	
	  <?	
	}		

?>
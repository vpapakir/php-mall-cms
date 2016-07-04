<?=boxHeader(array('title'=>'ManageTourFields.tour.title'))?>
	<form name="getTourTypeFields" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="TourTypeID" value="<?=$out['DB']['TourType'][0]['TourTypeID'];?>" />	
	<tr>
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('TourTypeFieldNew.tour.tip').' -';
			echo getLists($out['DB']['TourTypeFields'],$out['DB']['TourTypeField'][0]['TourTypeFieldID'],array('name'=>'TourTypeFieldID','id'=>'TourTypeFieldID','value'=>'TourTypeFieldName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageTourTypeFields" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['TourTypeField'][0]['TourTypeFieldID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="TourTypeID" value="<?=$out['DB']['TourType'][0]['TourTypeID'];?>" />
		<input type="hidden" name="TourTypeField<?=DTR?>TourTypeFieldID" value="<?=$out['DB']['TourTypeField'][0]['TourTypeFieldID'];?>" />
		<input type="hidden" name="TourTypeField<?=DTR?>TourTypeID" value="<?=$out['DB']['TourType'][0]['TourTypeID'];?>" />
		<input type="hidden" name="TourTypeField<?=DTR?>TourType" value="<?=$out['DB']['TourType'][0]['TourTypeAlias'];?>" />
		
		<input type="hidden" name="TourTypeFieldID" value="<?=$out['DB']['TourTypeField'][0]['TourTypeFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('TourTypeField.TourTypeFieldAlias')?>*:<br/>
					<input type="text" name="TourTypeField<?=DTR?>TourTypeFieldAlias" value="<?=$out['DB']['TourTypeField'][0]['TourTypeFieldAlias'];?>" size="50">
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('TourTypeField.TourTypeFieldName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="TourTypeField<?=DTR?>TourTypeFieldName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['TourTypeField'][0]['TourTypeFieldName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>		
					<br/>
					<?=lang('TourTypeField.TourTypeFieldMode')?>:<br/>
					<?=getReference('TourTypeField.TourTypeFieldMode','TourTypeField'.DTR.'TourTypeFieldMode',$out['DB']['TourTypeField'][0]['TourTypeFieldMode'],array('code'=>'Y'))?>
					<br/><br/>
					<?=lang('TourTypeField.TourTypeFieldHidenPlaces')?>:<br/>
					<?=getReference('TourTypeField.TourTypeFieldHidenPlaces','TourTypeField'.DTR.'TourTypeFieldHidenPlaces',$out['DB']['TourTypeField'][0]['TourTypeFieldHidenPlaces'],array('code'=>'Y'))?>
					<br/>
					<br/>
					<?=lang('TourTypeField.TourTypeFieldType')?>:<br/>
					<?=getReference('DataTypes','TourTypeField'.DTR.'TourTypeFieldType',$out['DB']['TourTypeField'][0]['TourTypeFieldType'],array('code'=>'Y'))?>
					<br/>
					<br/>
					<?=lang('-addafter')?>:
					&nbsp;
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['TourTypeFields']))
						{
						foreach($out['DB']['TourTypeFields'] as $row)
						{
							if ($row['TourTypeFieldID']!=$out['DB']['TourTypeField'][0]['TourTypeFieldID'])
							{
								$i++;
								$options[$i]['id']=$row['TourTypeFieldPosition']+1;	
								$options[$i]['value']=$row['TourTypeFieldName'];
							}
						}
						}
						echo getLists('',$out['DB']['TourTypeField'][0]['TourTypeFieldPosition']-1,array('name'=>'TourTypeField'.DTR.'TourTypeFieldPosition','id'=>'TourTypeFieldPosition','value'=>'TourTypeFieldName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['TourTypeField'][0]['TourTypeFieldID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageTourTypeFields.actionMode.value='delete';confirmDelete('manageTourTypeFields', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/><br/><br/>
			</td> 
		</tr> 
	</form>
	<? if (!empty($out['DB']['TourTypeField'][0]['TourTypeFieldID']) && ($out['DB']['TourTypeField'][0]['TourTypeFieldType']=='dropdown' || $out['DB']['TourTypeField'][0]['TourTypeFieldType']=='checkboxes' || $out['DB']['TourTypeField'][0]['TourTypeFieldType']=='radioboxes')) {?>
	<form name="getTourTypeOptions" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="TourTypeID" value="<?=$out['DB']['TourType'][0]['TourTypeID'];?>" />
	<input type="hidden" name="TourTypeFieldID" value="<?=$out['DB']['TourTypeField'][0]['TourTypeFieldID'];?>" />
	<tr>
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('TourTypeOptionNew.tour.tip').' -';
			echo getLists($out['DB']['TourTypeOptions'],$out['DB']['TourTypeOption'][0]['TourTypeOptionID'],array('name'=>'TourTypeOptionID','id'=>'TourTypeOptionID','value'=>'TourTypeOptionName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageTourTypeOptions" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['TourTypeOption'][0]['TourTypeOptionID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="TourTypeID" value="<?=$out['DB']['TourType'][0]['TourTypeID'];?>" />
		<input type="hidden" name="TourTypeFieldID" value="<?=$out['DB']['TourTypeField'][0]['TourTypeFieldID'];?>" />
		<input type="hidden" name="TourTypeOptionID" value="<?=$out['DB']['TourTypeOption'][0]['TourTypeOptionID'];?>" />

		<input type="hidden" name="TourTypeOption<?=DTR?>TourTypeOptionID" value="<?=$out['DB']['TourTypeOption'][0]['TourTypeOptionID'];?>" />
		<input type="hidden" name="TourTypeOption<?=DTR?>TourTypeFieldID" value="<?=$out['DB']['TourTypeField'][0]['TourTypeFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('TourTypeOption.TourTypeOptionAlias')?>*:<br/>
					<input type="text" name="TourTypeOption<?=DTR?>TourTypeOptionAlias" value="<?=$out['DB']['TourTypeOption'][0]['TourTypeOptionAlias'];?>" size="50">
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('TourTypeOption.TourTypeOptionName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="TourTypeOption<?=DTR?>TourTypeOptionName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['TourTypeOption'][0]['TourTypeOptionName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>	
					<br/>
					<? if($out['DB']['TourTypeField'][0]['TourTypeFieldMode'] =='option') { ?>
					<table cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('TourTypeOption.TourTypeOptionPrice')?>:<br/>
							<input type="text" name="TourTypeOption<?=DTR?>TourTypeOptionPrice" value="<?=$out['DB']['TourTypeOption'][0]['TourTypeOptionPrice'];?>" size="10">
						</td>
						<td valign="top" class="fieldNames">
							<?=lang('TourTypeOption.TourTypeOptionPriceAction')?>*:<br/>
							<?=getReference('plusminus','TourTypeOption'.DTR.'TourTypeOptionPriceAction',$out['DB']['TourTypeOption'][0]['TourTypeOptionPriceAction'],array('code'=>'Y'))?>
						</td>						
					</tr>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('TourTypeOption.TourTypeOptionWeight')?>:<br/>
							<input type="text" name="TourTypeOption<?=DTR?>TourTypeOptionWeight" value="<?=$out['DB']['TourTypeOption'][0]['TourTypeOptionWeight'];?>" size="10">
						</td>
						<td valign="top" class="fieldNames">
							<?=lang('TourTypeOption.TourTypeOptionWeightAction')?>:<br/>
							<?=getReference('plusminus','TourTypeOption'.DTR.'TourTypeOptionWeightAction',$out['DB']['TourTypeOption'][0]['TourTypeOptionWeightAction'],array('code'=>'Y'))?>
						</td>						
					</tr>							
					</table>					
					<? } ?>
					<br/>				
					<?=lang('-addafter')?>:
					&nbsp;
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['TourTypeOptions']))				
						{		
						foreach($out['DB']['TourTypeOptions'] as $row)
						{
							if ($row['TourTypeOptionID']!=$out['DB']['TourTypeOption'][0]['TourTypeOptionID'])
							{
								$i++;
								$options[$i]['id']=$row['TourTypeOptionPosition']+1;	
								$options[$i]['value']=$row['TourTypeOptionName'];
							}
						}
						}
						$newPosition = $out['DB']['TourTypeOption'][0]['TourTypeOptionPosition'] - 1;
						echo getLists('',$newPosition,array('name'=>'TourTypeOption'.DTR.'TourTypeOptionPosition','id'=>'TourTypeOptionPosition','value'=>'TourTypeOptionName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['TourTypeOption'][0]['TourTypeOptionID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageTourTypeOptions.actionMode.value='delete';confirmDelete('manageTourTypeOptions', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>
	<? }//if (!empty(input('selectedTourTypeID'))) ?>
<?=boxFooter()?>
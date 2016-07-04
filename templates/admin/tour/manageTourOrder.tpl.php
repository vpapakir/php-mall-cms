<?=boxHeader(array('title'=>'ManageTourOrder.tour.title'))?>
	<tr> 
	<form name="getTourOrders" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('TourOrderNew.tour.tip').' -';
			echo getLists($out['DB']['TourOrders'],$out['DB']['TourOrder'][0]['TourOrderID'],array('name'=>'TourOrderID','id'=>'TourOrderID','value'=>'TourOrderName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageTourOrders" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['TourOrder'][0]['TourOrderID'])) { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="TourOrder<?=DTR?>TourOrderID" value="<?=$out['DB']['TourOrder'][0]['TourOrderID'];?>" />
		<input type="hidden" name="TourOrderID" value="<?=$out['DB']['TourOrder'][0]['TourOrderID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('TourOrder.TourOrderAlias')?>*:<br/>
					<input type="text" name="TourOrder<?=DTR?>TourOrderAlias" value="<?=$out['DB']['TourOrder'][0]['TourOrderAlias'];?>" size="50">
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('TourOrder.TourOrderName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="TourOrder<?=DTR?>TourOrderName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['TourOrder'][0]['TourOrderName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>		
					<br/>
					<?=lang('-addafter')?>:
					&nbsp;
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['TourOrders']))
						{
						foreach($out['DB']['TourOrders'] as $row)
						{
							if ($row['TourOrderID']!=$out['DB']['TourOrder'][0]['TourOrderID'])
							{
								$i++;
								$options[$i]['id']=$row['TourOrderPosition']+1;	
								$options[$i]['value']=$row['TourOrderName'];
							}
						}
						}
						echo getLists('',$out['DB']['TourOrder'][0]['TourOrderPosition']-1,array('name'=>'TourOrder'.DTR.'TourOrderPosition','id'=>'TourOrderPosition','value'=>'TourOrderName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['TourOrder'][0]['TourOrderID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageTourOrders.actionMode.value='delete';confirmDelete('manageTourOrders', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>	
	<? if (!empty($out['DB']['TourOrder'][0]['TourOrderID'])) {?>
	<form name="getTourOrderFields" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="TourOrderID" value="<?=$out['DB']['TourOrder'][0]['TourOrderID'];?>" />	
	<tr>
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('TourOrderFieldNew.tour.tip').' -';
			echo getLists($out['DB']['TourOrderFields'],$out['DB']['TourOrderField'][0]['TourOrderFieldID'],array('name'=>'TourOrderFieldID','id'=>'TourOrderFieldID','value'=>'TourOrderFieldName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageTourOrderFields" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['TourOrderField'][0]['TourOrderFieldID'])) { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="TourOrderID" value="<?=$out['DB']['TourOrder'][0]['TourOrderID'];?>" />
		<input type="hidden" name="TourOrderField<?=DTR?>TourOrderFieldID" value="<?=$out['DB']['TourOrderField'][0]['TourOrderFieldID'];?>" />
		<input type="hidden" name="TourOrderField<?=DTR?>TourOrderID" value="<?=$out['DB']['TourOrder'][0]['TourOrderID'];?>" />
		<input type="hidden" name="TourOrderField<?=DTR?>TourOrder" value="<?=$out['DB']['TourOrder'][0]['TourOrderAlias'];?>" />
		
		<input type="hidden" name="TourOrderFieldID" value="<?=$out['DB']['TourOrderField'][0]['TourOrderFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('TourOrderField.TourOrderFieldAlias')?>*:<br/>
					<input type="text" name="TourOrderField<?=DTR?>TourOrderFieldAlias" value="<?=$out['DB']['TourOrderField'][0]['TourOrderFieldAlias'];?>" size="50">
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('TourOrderField.TourOrderFieldName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="TourOrderField<?=DTR?>TourOrderFieldName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['TourOrderField'][0]['TourOrderFieldName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>		
					<br/>
					<?=lang('TourOrderField.TourOrderFieldMode')?>:<br/>
					<?=getReference('TourOrderField.TourOrderFieldMode','TourOrderField'.DTR.'TourOrderFieldMode',$out['DB']['TourOrderField'][0]['TourOrderFieldMode'],array('code'=>'Y'))?>

					<br/>
					<br/>
					<?=lang('TourOrderField.TourOrderFieldType')?>:<br/>
					<?=getReference('Setting.SettingValueType','TourOrderField'.DTR.'TourOrderFieldType',$out['DB']['TourOrderField'][0]['TourOrderFieldType'],array('code'=>'Y'))?>
					<br/>
					<br/>
					<?=lang('-addafter')?>:
					&nbsp;
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['TourOrderFields']))
						{
						foreach($out['DB']['TourOrderFields'] as $row)
						{
							if ($row['TourOrderFieldID']!=$out['DB']['TourOrderField'][0]['TourOrderFieldID'])
							{
								$i++;
								$options[$i]['id']=$row['TourOrderFieldPosition']+1;	
								$options[$i]['value']=$row['TourOrderFieldName'];
							}
						}
						}
						echo getLists('',$out['DB']['TourOrderField'][0]['TourOrderFieldPosition']-1,array('name'=>'TourOrderField'.DTR.'TourOrderFieldPosition','id'=>'TourOrderFieldPosition','value'=>'TourOrderFieldName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['TourOrderField'][0]['TourOrderFieldID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageTourOrderFields.actionMode.value='delete';confirmDelete('manageTourOrderFields', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>
	<? } ?>
	<? if (!empty($out['DB']['TourOrderField'][0]['TourOrderFieldID']) && ($out['DB']['TourOrderField'][0]['TourOrderFieldType']=='dropdown' || $out['DB']['TourOrderField'][0]['TourOrderFieldType']=='checkboxes' || $out['DB']['TourOrderField'][0]['TourOrderFieldType']=='radioboxes')) {?>
	<form name="getTourOrderOptions" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="TourOrderID" value="<?=$out['DB']['TourOrder'][0]['TourOrderID'];?>" />
	<input type="hidden" name="TourOrderFieldID" value="<?=$out['DB']['TourOrderField'][0]['TourOrderFieldID'];?>" />
	<tr>
	<td valign=top bgcolor="#ffffff">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('TourOrderOptionNew.tour.tip').' -';
			echo getLists($out['DB']['TourOrderOptions'],$out['DB']['TourOrderOption'][0]['TourOrderOptionID'],array('name'=>'TourOrderOptionID','id'=>'TourOrderOptionID','value'=>'TourOrderOptionName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	<form name="manageTourOrderOptions" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['TourOrderOption'][0]['TourOrderOptionID'])) { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="TourOrderID" value="<?=$out['DB']['TourOrder'][0]['TourOrderID'];?>" />
		<input type="hidden" name="TourOrderFieldID" value="<?=$out['DB']['TourOrderField'][0]['TourOrderFieldID'];?>" />
		<input type="hidden" name="TourOrderOptionID" value="<?=$out['DB']['TourOrderOption'][0]['TourOrderOptionID'];?>" />

		<input type="hidden" name="TourOrderOption<?=DTR?>TourOrderOptionID" value="<?=$out['DB']['TourOrderOption'][0]['TourOrderOptionID'];?>" />
		<input type="hidden" name="TourOrderOption<?=DTR?>TourOrderFieldID" value="<?=$out['DB']['TourOrderField'][0]['TourOrderFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<?=lang('TourOrderOption.TourOrderOptionAlias')?>*:<br/>
					<input type="text" name="TourOrderOption<?=DTR?>TourOrderOptionAlias" value="<?=$out['DB']['TourOrderOption'][0]['TourOrderOptionAlias'];?>" size="50">
					<br/>
					<table cellspacing="0" cellpadding="0">
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('TourOrderOption.TourOrderOptionName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<input type="text" name="TourOrderOption<?=DTR?>TourOrderOptionName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['TourOrderOption'][0]['TourOrderOptionName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					</table>	
					<br/>
					<? if($out['DB']['TourOrderField'][0]['TourOrderFieldMode'] =='option') { ?>
					<table cellspacing="0" cellpadding="0" border="0">
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('TourOrderOption.TourOrderOptionPrice')?>:<br/>
							<input type="text" name="TourOrderOption<?=DTR?>TourOrderOptionPrice" value="<?=$out['DB']['TourOrderOption'][0]['TourOrderOptionPrice'];?>" size="10">
						</td>
						<td valign="top" class="fieldNames">
							<?=lang('TourOrderOption.TourOrderOptionPriceAction')?>*:<br/>
							<?=getReference('plusminus','TourOrderOption'.DTR.'TourOrderOptionPriceAction',$out['DB']['TourOrderOption'][0]['TourOrderOptionPriceAction'],array('code'=>'Y'))?>
						</td>						
					</tr>
					<tr>
						<td valign="top" class="fieldNames">
							<?=lang('TourOrderOption.TourOrderOptionWeight')?>:<br/>
							<input type="text" name="TourOrderOption<?=DTR?>TourOrderOptionWeight" value="<?=$out['DB']['TourOrderOption'][0]['TourOrderOptionWeight'];?>" size="10">
						</td>
						<td valign="top" class="fieldNames">
							<?=lang('TourOrderOption.TourOrderOptionWeightAction')?>:<br/>
							<?=getReference('plusminus','TourOrderOption'.DTR.'TourOrderOptionWeightAction',$out['DB']['TourOrderOption'][0]['TourOrderOptionWeightAction'],array('code'=>'Y'))?>
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
						if(is_array($out['DB']['TourOrderOptions']))				
						{		
						foreach($out['DB']['TourOrderOptions'] as $row)
						{
							if ($row['TourOrderOptionID']!=$out['DB']['TourOrderOption'][0]['TourOrderOptionID'])
							{
								$i++;
								$options[$i]['id']=$row['TourOrderOptionPosition']+1;	
								$options[$i]['value']=$row['TourOrderOptionName'];
							}
						}
						}
						$newPosition = $out['DB']['TourOrderOption'][0]['TourOrderOptionPosition'] - 1;
						echo getLists('',$newPosition,array('name'=>'TourOrderOption'.DTR.'TourOrderOptionPosition','id'=>'TourOrderOptionPosition','value'=>'TourOrderOptionName','options'=>$options));	
						$options='';
					?>
					<br/><br/>
					<? if(empty($out['DB']['TourOrderOption'][0]['TourOrderOptionID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageTourOrderOptions.actionMode.value='delete';confirmDelete('manageTourOrderOptions', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					<br/>
			</td> 
		</tr> 
	</form>
	<? }//if (!empty(input('selectedTourOrderID'))) ?>
<?=boxFooter()?>
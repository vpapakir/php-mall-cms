<?=boxHeader(array('title'=>'ManageReservedPropertyFields.reservedProperty.title'))?>
	<tr> 
		<td valign="top" bgcolor="#ffffff" class="fieldNames">
			<form name="getReservedPropertyTypeFields" method="post">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<input type="hidden" name="ReservedPropertyTypeID" value="<?=$out['DB']['ReservedPropertyType'][0]['ReservedPropertyTypeID'];?>" />	
				<table cellspacing="0" cellpadding="2" width="100%" border="0">
				<tr>
				<td width="30%" bgcolor="#efefef">&nbsp;</td>
				<td valign=top bgcolor="#efefef" align="left">
					<?
						$options[0]['id']='';	
						$options[0]['value']='- '.lang('ReservedPropertyTypeFieldNew.reservedProperty.tip').' -';
						echo getLists($out['DB']['ReservedPropertyTypeFields'],$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldID'],array('name'=>'ReservedPropertyTypeFieldID','id'=>'ReservedPropertyTypeFieldID','value'=>'ReservedPropertyTypeFieldName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
					?>	
				</td> 
				</tr> 
				</table>
			</form>
		</td>
	</tr>
	<form name="manageReservedPropertyTypeFields" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="ReservedPropertyTypeID" value="<?=$out['DB']['ReservedPropertyType'][0]['ReservedPropertyTypeID'];?>" />
		<input type="hidden" name="ReservedPropertyTypeField<?=DTR?>ReservedPropertyTypeFieldID" value="<?=$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldID'];?>" />
		<input type="hidden" name="ReservedPropertyTypeField<?=DTR?>ReservedPropertyTypeID" value="1" />
		<input type="hidden" name="ReservedPropertyTypeField<?=DTR?>ReservedPropertyType" value="main" />
		
		<input type="hidden" name="ReservedPropertyTypeFieldID" value="<?=$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
			<table cellspacing="0" cellpadding="2" width="100%" border="0">
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
						<?=lang('ReservedPropertyTypeField.ReservedPropertyTypeFieldAlias')?>*:
						</td>
						<td align="left">
						<input type="text" name="ReservedPropertyTypeField<?=DTR?>ReservedPropertyTypeFieldAlias" value="<?=$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldAlias'];?>" size="50">
						</td>
					</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('ReservedPropertyTypeField.ReservedPropertyTypeFieldName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
						</td>
						<td align="left">
							<input type="text" name="ReservedPropertyTypeField<?=DTR?>ReservedPropertyTypeFieldName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
					<?=lang('ReservedPropertyTypeField.ReservedPropertyTypeFieldMode')?>:<br/>
						</td>
						<td align="left">
					<?=getReference('ReservedPropertyTypeField.ReservedPropertyTypeFieldMode','ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldMode',$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldMode'],array('code'=>'Y'))?>
						</td>
					</tr>	
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('ReservedPropertyTypeField.ReservedPropertyTypeFieldParts')?>:<br/>
						</td>
						<td align="left">
							<?=getReference('ReservedPropertyTypeField.ReservedPropertyTypeFieldParts','ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldParts',$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldParts'],array('code'=>'Y'))?>
						</td>
					</tr>	
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
					<?=lang('ReservedPropertyTypeField.ReservedPropertyTypeFieldHidenPlaces')?>:<br/>
						</td>
						<td align="left">
					<?=getReference('ReservedPropertyTypeField.ReservedPropertyTypeFieldHidenPlaces','ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldHidenPlaces',$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldHidenPlaces'],array('code'=>'Y'))?>
						</td>
					</tr>	
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
					<?=lang('ReservedPropertyTypeField.ReservedPropertyTypeFieldType')?>:<br/>
						</td>
						<td align="left">
					<?=getReference('DataTypes','ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldType',$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldType'],array('code'=>'Y'))?>
						</td>
					</tr>	
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
					<?=lang('-addafter')?>:
						</td>
						<td align="left">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['ReservedPropertyTypeFields']))
						{
						foreach($out['DB']['ReservedPropertyTypeFields'] as $row)
						{
							if ($row['ReservedPropertyTypeFieldID']!=$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldID'])
							{
								$i++;
								$options[$i]['id']=$row['ReservedPropertyTypeFieldPosition']+1;	
								$options[$i]['value']=$row['ReservedPropertyTypeFieldName'];
							}
						}
						}
						echo getLists('',$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldPosition']-1,array('name'=>'ReservedPropertyTypeField'.DTR.'ReservedPropertyTypeFieldPosition','id'=>'ReservedPropertyTypeFieldPosition','value'=>'ReservedPropertyTypeFieldName','options'=>$options));	
						$options='';
					?>
						</td>
					</tr>	
					<tr><td width="100%" colspan="2">&nbsp;</td></tr>
					<tr>
						<td align="center" width="100%" colspan="2" bgcolor="efefef">
					<? if(empty($out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageReservedPropertyTypeFields.actionMode.value='delete';confirmDelete('manageReservedPropertyTypeFields', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
						</td>
					</tr>	
					</table>		
			</td> 
		</tr> 
	</form>
	<? if (!empty($out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldID']) && ($out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldType']=='dropdown' || $out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldType']=='checkboxes' || $out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldType']=='radioboxes')) {?>
	<form name="getReservedPropertyTypeOptions" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="ReservedPropertyTypeID" value="<?=$out['DB']['ReservedPropertyType'][0]['ReservedPropertyTypeID'];?>" />
	<input type="hidden" name="ReservedPropertyTypeFieldID" value="<?=$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldID'];?>" />
	<tr> 
	<td valign="top" bgcolor="#ffffff" class="fieldNames">
		<table cellspacing="0" cellpadding="2" width="100%" border="0">
		<tr>
			<td width="30%" bgcolor="#efefef">&nbsp;</td>
			<td valign=top bgcolor="#efefef" align="left">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('ReservedPropertyTypeOptionNew.reservedProperty.tip').' -';
					echo getLists($out['DB']['ReservedPropertyTypeOptions'],$out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionID'],array('name'=>'ReservedPropertyTypeOptionID','id'=>'ReservedPropertyTypeOptionID','value'=>'ReservedPropertyTypeOptionName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
				?>	
			</td> 
		</form>
		</tr> 
		</table>
	</td> 
	</tr> 
	<form name="manageReservedPropertyTypeOptions" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="ReservedPropertyTypeID" value="<?=$out['DB']['ReservedPropertyType'][0]['ReservedPropertyTypeID'];?>" />
		<input type="hidden" name="ReservedPropertyTypeFieldID" value="<?=$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldID'];?>" />
		<input type="hidden" name="ReservedPropertyTypeOptionID" value="<?=$out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionID'];?>" />

		<input type="hidden" name="ReservedPropertyTypeOption<?=DTR?>ReservedPropertyTypeOptionID" value="<?=$out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionID'];?>" />
		<input type="hidden" name="ReservedPropertyTypeOption<?=DTR?>ReservedPropertyTypeFieldID" value="<?=$out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table cellspacing="0" cellpadding="2" width="100%" border="0">
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
						<?=lang('ReservedPropertyTypeOption.ReservedPropertyTypeOptionAlias')?>*:<br/>
						</td>
						<td align="left">
						<input type="text" name="ReservedPropertyTypeOption<?=DTR?>ReservedPropertyTypeOptionAlias" value="<?=$out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionAlias'];?>" size="50">
						</td>
					</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('ReservedPropertyTypeOption.ReservedPropertyTypeOptionName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?>
						</td>
						<td align="left">
							<input type="text" name="ReservedPropertyTypeOption<?=DTR?>ReservedPropertyTypeOptionName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					<? if($out['DB']['ReservedPropertyTypeField'][0]['ReservedPropertyTypeFieldMode'] =='option') { ?>
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('ReservedPropertyTypeOption.ReservedPropertyTypeOptionPrice')?>:
						</td>
						<td align="left">
							<input type="text" name="ReservedPropertyTypeOption<?=DTR?>ReservedPropertyTypeOptionPrice" value="<?=$out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionPrice'];?>" size="10">
						</td>
					</tr>	
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('ReservedPropertyTypeOption.ReservedPropertyTypeOptionPriceAction')?>*:
						</td>
						<td align="left">
							<?=getReference('plusminus','ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionPriceAction',$out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionPriceAction'],array('code'=>'Y'))?>
						</td>						
					</tr>
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('ReservedPropertyTypeOption.ReservedPropertyTypeOptionWeight')?>:<br/>
						</td>
						<td align="left">
							<input type="text" name="ReservedPropertyTypeOption<?=DTR?>ReservedPropertyTypeOptionWeight" value="<?=$out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionWeight'];?>" size="10">
						</td>						
					</tr>
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('ReservedPropertyTypeOption.ReservedPropertyTypeOptionWeightAction')?>:<br/>
						</td>
						<td align="left">
							<?=getReference('plusminus','ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionWeightAction',$out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionWeightAction'],array('code'=>'Y'))?>
						</td>						
					</tr>							
					<? } ?>
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
					<?=lang('-addafter')?>:
						</td>
						<td align="left">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['ReservedPropertyTypeOptions']))				
						{		
						foreach($out['DB']['ReservedPropertyTypeOptions'] as $row)
						{
							if ($row['ReservedPropertyTypeOptionID']!=$out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionID'])
							{
								$i++;
								$options[$i]['id']=$row['ReservedPropertyTypeOptionPosition']+1;	
								$options[$i]['value']=$row['ReservedPropertyTypeOptionName'];
							}
						}
						}
						$newPosition = $out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionPosition'] - 1;
						echo getLists('',$newPosition,array('name'=>'ReservedPropertyTypeOption'.DTR.'ReservedPropertyTypeOptionPosition','id'=>'ReservedPropertyTypeOptionPosition','value'=>'ReservedPropertyTypeOptionName','options'=>$options));	
						$options='';
					?>
						</td>						
					</tr>							
					<tr><td width="100%" colspan="2">&nbsp;</td></tr>
					<tr>
						<td align="center" width="100%" bgcolor="efefef" colspan="2">
					<? if(empty($out['DB']['ReservedPropertyTypeOption'][0]['ReservedPropertyTypeOptionID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageReservedPropertyTypeOptions.actionMode.value='delete';confirmDelete('manageReservedPropertyTypeOptions', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
						</td>						
					</tr>							
				</table>					
			</td> 
		</tr> 
	</form>
	<? }//if (!empty(input('selectedReservedPropertyTypeID'))) ?>
<?=boxFooter()?>
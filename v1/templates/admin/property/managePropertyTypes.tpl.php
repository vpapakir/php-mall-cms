<?=boxHeader(array('title'=>'ManagePropertyType.property.title'))?>
	<tr> 
		<td valign="top" bgcolor="#ffffff" class="fieldNames">
			<table cellpadding="2" cellspacing="0" border="0" width="100%">
			<tr> 
			<form name="getPropertyTypes" method="post">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<td width="30%" bgcolor="efefef">&nbsp;</td>
			<td valign=top bgcolor="#efefef" align="left">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('PropertyTypeNew.property.tip').' -';
					echo getLists($out['DB']['PropertyTypes'],$out['DB']['PropertyType'][0]['PropertyTypeID'],array('name'=>'PropertyTypeID','id'=>'PropertyTypeID','value'=>'PropertyTypeName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
				?>	
			</td> 
			</form>
			</tr> 
			</table>
		</td>
	</tr>
	<form name="managePropertyTypes" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['PropertyType'][0]['PropertyTypeID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="PropertyType<?=DTR?>PropertyTypeID" value="<?=$out['DB']['PropertyType'][0]['PropertyTypeID'];?>" />
		<input type="hidden" name="PropertyTypeID" value="<?=$out['DB']['PropertyType'][0]['PropertyTypeID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table cellpadding="2" cellspacing="0" border="0" width="100%">
				 <tr>
				 <td align="left" width="30%" class="subtitle">
					<?=lang('PropertyType.PropertyTypeAlias')?>*:
				 </td>
				 <td align="left">
					<input type="text" name="PropertyType<?=DTR?>PropertyTypeAlias" value="<?=$out['DB']['PropertyType'][0]['PropertyTypeAlias'];?>" size="50">
				 </td>
				 </tr>
				 <tr>
				 <td align="left" class="subtitle">
					<?=lang('PropertyType.PropertyTemplate')?>:
				 </td>
				 <td align="left">
					<?=getReference('PropertyTemplate','PropertyType'.DTR.'PropertyTemplate',$out['DB']['PropertyType'][0]['PropertyTemplate'],array('code'=>'Y'))?>&nbsp;<a href="<?=setting('url')?>manageReferences/ReferenceCode/PropertyTemplate">[<?=lang('-edit')?>]</a>
				 </td>
				 </tr>
				 <tr>
				 <td align="left" class="subtitle">
					<?=lang('PropertyType.PropertyTypeHiddenPlaces')?>:
				 </td>
				 <td align="left">
					<?=getReference('PropertyType.PropertyTypeHiddenPlaces','PropertyType'.DTR.'PropertyTypeHiddenPlaces',$out['DB']['PropertyType'][0]['PropertyTypeHiddenPlaces'],array('code'=>'Y'))?>
				 </td>
				 </tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="subtitle" align="left">
							<?=lang('PropertyType.PropertyTypeName')?>*:
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
						</td>
						<td align="left">
							<input type="text" name="PropertyType<?=DTR?>PropertyTypeName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['PropertyType'][0]['PropertyTypeName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					<tr>
					<td align="left" valign="top" class="subtitle">
					<?=lang('-addafter')?>:
					</td>
					<td align="left" valign="top">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['PropertyTypes']))
						{
						foreach($out['DB']['PropertyTypes'] as $row)
						{
							if ($row['PropertyTypeID']!=$out['DB']['PropertyType'][0]['PropertyTypeID'])
							{
								$i++;
								$options[$i]['id']=$row['PropertyTypePosition']+1;	
								$options[$i]['value']=$row['PropertyTypeName'];
							}
						}
						}
						echo getLists('',$out['DB']['PropertyType'][0]['PropertyTypePosition']-1,array('name'=>'PropertyType'.DTR.'PropertyTypePosition','id'=>'PropertyTypePosition','value'=>'PropertyTypeName','options'=>$options));	
						$options='';
					?>
					</td></tr>
					<tr><td width="100%" colspan="2">&nbsp;</td></tr>
					<tr>
					<td bgcolor="#efefef" width="100%" align="center" colspan="2">
					<? if(empty($out['DB']['PropertyType'][0]['PropertyTypeID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.managePropertyTypes.actionMode.value='delete';confirmDelete('managePropertyTypes', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
			 </td>
    		 </tr>
			</table>
			</td> 
		</tr> 
	</form>	
	<? if (!empty($out['DB']['PropertyType'][0]['PropertyTypeID'])) {?>
	<form name="getPropertyTypeFields" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="PropertyTypeID" value="<?=$out['DB']['PropertyType'][0]['PropertyTypeID'];?>" />	
	<tr> 
	<td valign="top" bgcolor="#ffffff" class="fieldNames">
	<table cellpadding="2" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="30%" bgcolor="efefef">
			</td>
			<td valign=top bgcolor="#efefef" align="left">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('PropertyTypeFieldNew.property.tip').' -';
					echo getLists($out['DB']['PropertyTypeFields'],$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldID'],array('name'=>'PropertyTypeFieldID','id'=>'PropertyTypeFieldID','value'=>'PropertyTypeFieldName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
				?>	
			</td> 
		</form>
		</tr> 
	</table>
	</td>
 	</tr>
	<form name="managePropertyTypeFields" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['PropertyTypeField'][0]['PropertyTypeFieldID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="PropertyTypeID" value="<?=$out['DB']['PropertyType'][0]['PropertyTypeID'];?>" />
		<input type="hidden" name="PropertyTypeField<?=DTR?>PropertyTypeFieldID" value="<?=$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldID'];?>" />
		<input type="hidden" name="PropertyTypeField<?=DTR?>PropertyTypeID" value="<?=$out['DB']['PropertyType'][0]['PropertyTypeID'];?>" />
		<input type="hidden" name="PropertyTypeField<?=DTR?>PropertyType" value="<?=$out['DB']['PropertyType'][0]['PropertyTypeAlias'];?>" />
		
		<input type="hidden" name="PropertyTypeFieldID" value="<?=$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
			<table cellpadding="2" cellspacing="0" border="0" width="100%">
				<tr>
					<td valign="top" align="left" width="30%" class="subtitle">
					<?=lang('PropertyTypeField.PropertyTypeFieldAlias')?>*:<br/>
					</td>
					<td align="left">
					<input type="text" name="PropertyTypeField<?=DTR?>PropertyTypeFieldAlias" value="<?=$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldAlias'];?>" size="50">
					</td>
				</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				<tr>
					<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('PropertyTypeField.PropertyTypeFieldName')?>*: 
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
					</td>
					<td align="left">
							<input type="text" name="PropertyTypeField<?=DTR?>PropertyTypeFieldName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['PropertyTypeField'][0]['PropertyTypeFieldName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
				<tr>
					<td valign="top" align="left" width="30%" class="subtitle">
					<?=lang('PropertyTypeField.PropertyTypeFieldMode')?>:<br/>
					</td>
					<td align="left">
					<?=getReference('PropertyTypeField.PropertyTypeFieldMode','PropertyTypeField'.DTR.'PropertyTypeFieldMode',$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldMode'],array('code'=>'Y'))?>
					</td>
				</tr>
					<tr>
						<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('PropertyTypeField.PropertyTypeFieldParts')?>:<br/>
						</td>
						<td align="left">
							<?=getReference('PropertyTypeField.PropertyTypeFieldParts','PropertyTypeField'.DTR.'PropertyTypeFieldParts',$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldParts'],array('code'=>'Y'))?>
						</td>
					</tr>	
				
				<tr>
					<td valign="top" align="left" width="30%" class="subtitle">
					<?=lang('PropertyTypeField.PropertyTypeFieldHidenPlaces')?>:<br/>
					</td>
					<td align="left">
					<?=getReference('PropertyTypeField.PropertyTypeFieldHidenPlaces','PropertyTypeField'.DTR.'PropertyTypeFieldHidenPlaces',$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldHidenPlaces'],array('code'=>'Y'))?>
					</td>
				</tr>
				<tr>
					<td valign="top" align="left" width="30%" class="subtitle">
					<?=lang('PropertyTypeField.PropertyTypeFieldType')?>:<br/>
					</td>
					<td align="left">
					<?=getReference('DataTypes','PropertyTypeField'.DTR.'PropertyTypeFieldType',$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldType'],array('code'=>'Y'))?>
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
						if(is_array($out['DB']['PropertyTypeFields']))
						{
						foreach($out['DB']['PropertyTypeFields'] as $row)
						{
							if ($row['PropertyTypeFieldID']!=$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldID'])
							{
								$i++;
								$options[$i]['id']=$row['PropertyTypeFieldPosition']+1;	
								$options[$i]['value']=$row['PropertyTypeFieldName'];
							}
						}
						}
						echo getLists('',$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldPosition']-1,array('name'=>'PropertyTypeField'.DTR.'PropertyTypeFieldPosition','id'=>'PropertyTypeFieldPosition','value'=>'PropertyTypeFieldName','options'=>$options));	
						$options='';
					?>
					</td>
				</tr>
					<tr><td width="100%" colspan="2">&nbsp;</td></tr>
				<tr>
					<td align="center" width="100%" bgcolor="efefef" colspan="2">
					<? if(empty($out['DB']['PropertyTypeField'][0]['PropertyTypeFieldID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.managePropertyTypeFields.actionMode.value='delete';confirmDelete('managePropertyTypeFields', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					</td>
				</tr>
				</table>		
			</td> 
		</tr> 
	</form>
	<? } ?>
	<? if (!empty($out['DB']['PropertyTypeField'][0]['PropertyTypeFieldID']) && ($out['DB']['PropertyTypeField'][0]['PropertyTypeFieldType']=='dropdown' || $out['DB']['PropertyTypeField'][0]['PropertyTypeFieldType']=='checkboxes' || $out['DB']['PropertyTypeField'][0]['PropertyTypeFieldType']=='radioboxes')) {?>
	<form name="getPropertyTypeOptions" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="PropertyTypeID" value="<?=$out['DB']['PropertyType'][0]['PropertyTypeID'];?>" />
	<input type="hidden" name="PropertyTypeFieldID" value="<?=$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldID'];?>" />
	<tr> 
	<td valign="top" bgcolor="#ffffff" class="fieldNames">
	<table cellpadding="2" cellspacing="0" border="0" width="100%">
		<tr>
			<td width="30%" bgcolor="efefef">
			</td>
			<td valign=top bgcolor="#efefef" align="left">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('PropertyTypeOptionNew.property.tip').' -';
			echo getLists($out['DB']['PropertyTypeOptions'],$out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionID'],array('name'=>'PropertyTypeOptionID','id'=>'PropertyTypeOptionID','value'=>'PropertyTypeOptionName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
			</td> 
	</form>
		</tr> 
	</table>
	</td>
	</tr>
	<form name="managePropertyTypeOptions" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="PropertyTypeID" value="<?=$out['DB']['PropertyType'][0]['PropertyTypeID'];?>" />
		<input type="hidden" name="PropertyTypeFieldID" value="<?=$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldID'];?>" />
		<input type="hidden" name="PropertyTypeOptionID" value="<?=$out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionID'];?>" />

		<input type="hidden" name="PropertyTypeOption<?=DTR?>PropertyTypeOptionID" value="<?=$out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionID'];?>" />
		<input type="hidden" name="PropertyTypeOption<?=DTR?>PropertyTypeFieldID" value="<?=$out['DB']['PropertyTypeField'][0]['PropertyTypeFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
			<table cellpadding="2" cellspacing="0" border="0" width="100%">
				<tr>
					<td valign="top" align="left" width="30%" class="subtitle">
					<?=lang('PropertyTypeOption.PropertyTypeOptionAlias')?>*:<br/>
					</td>
					<td align="left">
					<input type="text" name="PropertyTypeOption<?=DTR?>PropertyTypeOptionAlias" value="<?=$out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionAlias'];?>" size="50">
					</td>
				</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
					<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('PropertyTypeOption.PropertyTypeOptionName')?>*: 
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<? }?>
					</td>
					<td align="left">
							<input type="text" name="PropertyTypeOption<?=DTR?>PropertyTypeOptionName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					<? if($out['DB']['PropertyTypeField'][0]['PropertyTypeFieldMode'] =='option') { ?>
					<tr>
					<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('PropertyTypeOption.PropertyTypeOptionPrice')?>:<br/>
					</td>
					<td align="left">
							<input type="text" name="PropertyTypeOption<?=DTR?>PropertyTypeOptionPrice" value="<?=$out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionPrice'];?>" size="10">
						</td>
					</tr>	
					<tr>
					<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('PropertyTypeOption.PropertyTypeOptionPriceAction')?>*:<br/>
					</td>
					<td align="left">
							<?=getReference('plusminus','PropertyTypeOption'.DTR.'PropertyTypeOptionPriceAction',$out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionPriceAction'],array('code'=>'Y'))?>
						</td>
					</tr>	
					<tr>
					<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('PropertyTypeOption.PropertyTypeOptionWeight')?>:<br/>
					</td>
					<td align="left">
							<input type="text" name="PropertyTypeOption<?=DTR?>PropertyTypeOptionWeight" value="<?=$out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionWeight'];?>" size="10">
						</td>
					</tr>	
					<tr>
					<td valign="top" align="left" width="30%" class="subtitle">
							<?=lang('PropertyTypeOption.PropertyTypeOptionWeightAction')?>:<br/>
					</td>
					<td align="left">
							<?=getReference('plusminus','PropertyTypeOption'.DTR.'PropertyTypeOptionWeightAction',$out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionWeightAction'],array('code'=>'Y'))?>
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
						if(is_array($out['DB']['PropertyTypeOptions']))				
						{		
						foreach($out['DB']['PropertyTypeOptions'] as $row)
						{
							if ($row['PropertyTypeOptionID']!=$out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionID'])
							{
								$i++;
								$options[$i]['id']=$row['PropertyTypeOptionPosition']+1;	
								$options[$i]['value']=$row['PropertyTypeOptionName'];
							}
						}
						}
						$newPosition = $out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionPosition'] - 1;
						echo getLists('',$newPosition,array('name'=>'PropertyTypeOption'.DTR.'PropertyTypeOptionPosition','id'=>'PropertyTypeOptionPosition','value'=>'PropertyTypeOptionName','options'=>$options));	
						$options='';
					?>
						</td>
					</tr>	
					<tr><td width="100%" colspan="2">&nbsp;</td></tr>
					<tr>
					<td align="center" width="100%" bgcolor="efefef" colspan="2">
					<? if(empty($out['DB']['PropertyTypeOption'][0]['PropertyTypeOptionID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.managePropertyTypeOptions.actionMode.value='delete';confirmDelete('managePropertyTypeOptions', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
						</td>
					</tr>	
				</table>					
			</td> 
		</tr> 
	</form>
	<? }//if (!empty(input('selectedPropertyTypeID'))) ?>
<?=boxFooter()?>
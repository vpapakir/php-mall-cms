<?=boxHeader(array('title'=>'ManageResourceType.resource.title'))?>
	<table cellpadding="2" cellspacing="0" border="0" width="100%">
	<tr> 
	<form name="getResourceTypes" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<td width="30%" bgcolor="#efefef">&nbsp;</td>
	<td valign=top bgcolor="#efefef" align="left">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('ResourceTypeNew.resource.tip').' -';
			echo getLists($out['DB']['ResourceTypes'],$out['DB']['ResourceType'][0]['ResourceTypeID'],array('name'=>'ResourceTypeID','id'=>'ResourceTypeID','value'=>'ResourceTypeName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr> 
	</table>
	<form name="manageResourceTypes" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['ResourceType'][0]['ResourceTypeID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="ResourceType<?=DTR?>ResourceTypeID" value="<?=$out['DB']['ResourceType'][0]['ResourceTypeID'];?>" />
		<input type="hidden" name="ResourceTypeID" value="<?=$out['DB']['ResourceType'][0]['ResourceTypeID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table cellpadding="2" cellspacing="0" border="0" width="100%">
				 <tr>
				 <td align="left" width="30%" class="subtitle">
					<?=lang('ResourceType.ResourceTypeAlias')?>*:
				 </td>
				 <td align="left">
					<input type="text" name="ResourceType<?=DTR?>ResourceTypeAlias" value="<?=$out['DB']['ResourceType'][0]['ResourceTypeAlias'];?>" size="50">
				 </td>
				 </tr>
				 <tr>
				 <td align="left" valign="top" class="subtitle">
					<?=lang('ResourceType.ResourceTemplate')?>:
				 </td>
				 <td align="left">
					<?=getReference('ResourceTemplate','ResourceType'.DTR.'ResourceTemplate',$out['DB']['ResourceType'][0]['ResourceTemplate'],array('code'=>'Y'))?>&nbsp;<a href="<?=setting('url')?>manageReferences/ReferenceCode/ResourceTemplate">[<?=lang('-edit')?>]</a>
				 </td>
				 </tr>
				 <tr>
				 <td align="left" class="subtitle" valign="top">
					<?=lang('ResourceType.ResourceTypeHiddenPlaces')?>:
				 </td>
				 <td align="left">
					<?=getReference('ResourceType.ResourceTypeHiddenPlaces','ResourceType'.DTR.'ResourceTypeHiddenPlaces',$out['DB']['ResourceType'][0]['ResourceTypeHiddenPlaces'],array('code'=>'Y'))?>
				 </td>
				 <tr>
					 <td align="left" class="subtitle" valign="top">
						<?=lang('ResourceType.ResourceTypeAction')?>:
					 </td>
					 <td align="left">
						<?=getReference('ResourceType.ResourceTypeAction','ResourceType'.DTR.'ResourceTypeAction',$out['DB']['ResourceType'][0]['ResourceTypeAction'],array('code'=>'Y'))?>
					 </td>	
				 </tr>			 
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left">
							<span class="subtitle"><?=lang('ResourceType.ResourceTypeName')?>*: </span>
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
						</td>
						<td align="left">
							<input type="text" name="ResourceType<?=DTR?>ResourceTypeName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['ResourceType'][0]['ResourceTypeName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					<tr>
					<td align="left" valign="top" class="subtitle">
					<?=lang('-addafter')?>:
					&nbsp;
					</td>
					<td align="left" valign="top">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['ResourceTypes']))
						{
						foreach($out['DB']['ResourceTypes'] as $row)
						{
							if ($row['ResourceTypeID']!=$out['DB']['ResourceType'][0]['ResourceTypeID'])
							{
								$i++;
								$options[$i]['id']=$row['ResourceTypePosition']+1;	
								$options[$i]['value']=$row['ResourceTypeName'];
							}
						}
						}
						echo getLists('',$out['DB']['ResourceType'][0]['ResourceTypePosition']-1,array('name'=>'ResourceType'.DTR.'ResourceTypePosition','id'=>'ResourceTypePosition','value'=>'ResourceTypeName','options'=>$options));	
						$options='';
					?>
					</td></tr>
					<tr><td width="100%" colspan="2">&nbsp;</td></tr>
					<tr>
					<td bgcolor="#efefef" align="center" colspan="2">
					<? if(empty($out['DB']['ResourceType'][0]['ResourceTypeID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="confirmDelete('manageResourceTypes', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
			 </td>
    		 </tr>
			</table>
			</td> 
		</tr> 
	</form>	
	<? if (!empty($out['DB']['ResourceType'][0]['ResourceTypeID'])) {?>
	<form name="getResourceTypeFields" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="ResourceTypeID" value="<?=$out['DB']['ResourceType'][0]['ResourceTypeID'];?>" />	
	<tr> 
	<td valign="top" bgcolor="#ffffff" class="fieldNames">
		<table cellpadding="2" cellspacing="0" border="0" width="100%">
			<tr>
				<td width="30%" bgcolor="efefef">&nbsp;</td>
				<td valign="top" bgcolor="#efefef" align="left">
					<?
						$options[0]['id']='';	
						$options[0]['value']='- '.lang('ResourceTypeFieldNew.resource.tip').' -';
						echo getLists($out['DB']['ResourceTypeFields'],$out['DB']['ResourceTypeField'][0]['ResourceTypeFieldID'],array('name'=>'ResourceTypeFieldID','id'=>'ResourceTypeFieldID','value'=>'ResourceTypeFieldName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
					?>	
				</td> 
			</tr> 
		</table>
	</td> 
	</tr> 
	</form>
	<form name="manageResourceTypeFields" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['ResourceTypeField'][0]['ResourceTypeFieldID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="ResourceTypeID" value="<?=$out['DB']['ResourceType'][0]['ResourceTypeID'];?>" />
		<input type="hidden" name="ResourceTypeField<?=DTR?>ResourceTypeFieldID" value="<?=$out['DB']['ResourceTypeField'][0]['ResourceTypeFieldID'];?>" />
		<input type="hidden" name="ResourceTypeField<?=DTR?>ResourceTypeID" value="<?=$out['DB']['ResourceType'][0]['ResourceTypeID'];?>" />
		<input type="hidden" name="ResourceTypeField<?=DTR?>ResourceType" value="<?=$out['DB']['ResourceType'][0]['ResourceTypeAlias'];?>" />
		
		<input type="hidden" name="ResourceTypeFieldID" value="<?=$out['DB']['ResourceTypeField'][0]['ResourceTypeFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="2" border="0" width="100%">
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
					<?=lang('ResourceTypeField.ResourceTypeFieldAlias')?>*:
						</td>
						<td align="left">
					<input type="text" name="ResourceTypeField<?=DTR?>ResourceTypeFieldAlias" value="<?=$out['DB']['ResourceTypeField'][0]['ResourceTypeFieldAlias'];?>" size="50">
						</td>
					</tr>	
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
							<?=lang('ResourceTypeField.ResourceTypeFieldName')?>*: 
						</td>
						<td align="left">
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
							<br/>
							<input type="text" name="ResourceTypeField<?=DTR?>ResourceTypeFieldName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['ResourceTypeField'][0]['ResourceTypeFieldName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
							<?=lang('ResourceTypeField.ResourceTypeFieldMode')?>:<br/>
						</td>
						<td align="left">
							<?=getReference('ResourceTypeField.ResourceTypeFieldMode','ResourceTypeField'.DTR.'ResourceTypeFieldMode',$out['DB']['ResourceTypeField'][0]['ResourceTypeFieldMode'],array('code'=>'Y'))?>
						</td>
					</tr>	
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
							<?=lang('ResourceTypeField.ResourceTypeFieldHidenPlaces')?>:<br/>
						</td>
						<td align="left">
							<?=getReference('ResourceTypeFieldsPlaces','ResourceTypeField'.DTR.'ResourceTypeFieldHidenPlaces',$out['DB']['ResourceTypeField'][0]['ResourceTypeFieldHidenPlaces'],array('code'=>'Y'))?>
						</td>
					</tr>	
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
							<?=lang('ResourceTypeField.ResourceTypeFieldType')?>:<br/>
						</td>
						<td align="left">
							<?=getReference('DataTypes','ResourceTypeField'.DTR.'ResourceTypeFieldType',$out['DB']['ResourceTypeField'][0]['ResourceTypeFieldType'],array('code'=>'Y'))?>
						</td>
					</tr>	
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
							<?=lang('-addafter')?>:
							&nbsp;
						</td>
						<td align="left">
							<?
								$options[0]['id']='1';	
								$options[0]['value']='- '.lang('-first').' -';
								if(is_array($out['DB']['ResourceTypeFields']))
								{
								foreach($out['DB']['ResourceTypeFields'] as $row)
								{
									if ($row['ResourceTypeFieldID']!=$out['DB']['ResourceTypeField'][0]['ResourceTypeFieldID'])
									{
										$i++;
										$options[$i]['id']=$row['ResourceTypeFieldPosition']+1;	
										$options[$i]['value']=$row['ResourceTypeFieldName'];
									}
								}
								}
								echo getLists('',$out['DB']['ResourceTypeField'][0]['ResourceTypeFieldPosition']-1,array('name'=>'ResourceTypeField'.DTR.'ResourceTypeFieldPosition','id'=>'ResourceTypeFieldPosition','value'=>'ResourceTypeFieldName','options'=>$options));	
								$options='';
							?>
						</td>
					</tr>
					<tr><td width="100%" colspan="2">&nbsp;</td></tr>	
					<tr>
						<td valign="top" bgcolor="efefef" width="100%" align="center" colspan="2">
							<? if(empty($out['DB']['ResourceTypeField'][0]['ResourceTypeFieldID'])) { ?>
							<input type="submit" value="<?=lang("-add")?>">
							<? } else { ?>
							<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageResourceTypeFields.actionMode.value='delete';confirmDelete('manageResourceTypeFields', '<?=lang("-deleteconfirmation")?>');">
							<? } ?>					
						</td>
					</tr>	
					</table>		
			</td> 
		</tr> 
	</form>
	<? } ?>
	<? if (!empty($out['DB']['ResourceTypeField'][0]['ResourceTypeFieldID']) && ($out['DB']['ResourceTypeField'][0]['ResourceTypeFieldType']=='dropdown' || $out['DB']['ResourceTypeField'][0]['ResourceTypeFieldType']=='checkboxes' || $out['DB']['ResourceTypeField'][0]['ResourceTypeFieldType']=='radioboxes')) {?>
	<form name="getResourceTypeOptions" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="ResourceTypeID" value="<?=$out['DB']['ResourceType'][0]['ResourceTypeID'];?>" />
	<input type="hidden" name="ResourceTypeFieldID" value="<?=$out['DB']['ResourceTypeField'][0]['ResourceTypeFieldID'];?>" />
	<tr> 
		<td valign="top" bgcolor="#ffffff" class="fieldNames">
			<table cellpadding="2" cellspacing="0" border="0" width="100%">
				<tr>
					<td width="30%" align="left" bgcolor="efefef">&nbsp;</td>
					<td valign="top" bgcolor="#efefef">
						<?
							$options[0]['id']='';	
							$options[0]['value']='- '.lang('ResourceTypeOptionNew.resource.tip').' -';
							echo getLists($out['DB']['ResourceTypeOptions'],$out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionID'],array('name'=>'ResourceTypeOptionID','id'=>'ResourceTypeOptionID','value'=>'ResourceTypeOptionName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
						?>	
					</td> 
				</tr> 
			</table>
		</td> 
	</tr> 
	</form>
	<form name="manageResourceTypeOptions" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="ResourceTypeID" value="<?=$out['DB']['ResourceType'][0]['ResourceTypeID'];?>" />
		<input type="hidden" name="ResourceTypeFieldID" value="<?=$out['DB']['ResourceTypeField'][0]['ResourceTypeFieldID'];?>" />
		<input type="hidden" name="ResourceTypeOptionID" value="<?=$out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionID'];?>" />

		<input type="hidden" name="ResourceTypeOption<?=DTR?>ResourceTypeOptionID" value="<?=$out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionID'];?>" />
		<input type="hidden" name="ResourceTypeOption<?=DTR?>ResourceTypeFieldID" value="<?=$out['DB']['ResourceTypeField'][0]['ResourceTypeFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table cellpadding="2" cellspacing="0" border="0" width="100%">
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
					<?=lang('ResourceTypeOption.ResourceTypeOptionAlias')?>*:
						</td>
						<td align="left">
					<input type="text" name="ResourceTypeOption<?=DTR?>ResourceTypeOptionAlias" value="<?=$out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionAlias'];?>" size="50">
						</td>
					</tr>	
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
							<?=lang('ResourceTypeOption.ResourceTypeOptionName')?>*: 
						</td>
						<td align="left">
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<? }?>
							<br/>
							<input type="text" name="ResourceTypeOption<?=DTR?>ResourceTypeOptionName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					<? if($out['DB']['ResourceTypeField'][0]['ResourceTypeFieldMode'] =='option') { ?>
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
							<?=lang('ResourceTypeOption.ResourceTypeOptionPrice')?>:<br/>
						</td>
						<td align="left">
							<input type="text" name="ResourceTypeOption<?=DTR?>ResourceTypeOptionPrice" value="<?=$out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionPrice'];?>" size="10">
						</td>
					</tr>	
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
							<?=lang('ResourceTypeOption.ResourceTypeOptionPriceAction')?>*:<br/>
						</td>
						<td align="left">
							<?=getReference('plusminus','ResourceTypeOption'.DTR.'ResourceTypeOptionPriceAction',$out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionPriceAction'],array('code'=>'Y'))?>
						</td>						
					</tr>
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
							<?=lang('ResourceTypeOption.ResourceTypeOptionWeight')?>:<br/>
						</td>
						<td align="left">
							<input type="text" name="ResourceTypeOption<?=DTR?>ResourceTypeOptionWeight" value="<?=$out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionWeight'];?>" size="10">
						</td>						
					</tr>
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
							<?=lang('ResourceTypeOption.ResourceTypeOptionWeightAction')?>:<br/>
						</td>
						<td align="left">
							<?=getReference('plusminus','ResourceTypeOption'.DTR.'ResourceTypeOptionWeightAction',$out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionWeightAction'],array('code'=>'Y'))?>
						</td>						
					</tr>							
					<? } ?>
					<tr>
						<td valign="top" class="subtitle" width="30%" align="left">
						<?=lang('-addafter')?>:
						</td>
						<td align="left">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['ResourceTypeOptions']))				
						{		
						foreach($out['DB']['ResourceTypeOptions'] as $row)
						{
							if ($row['ResourceTypeOptionID']!=$out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionID'])
							{
								$i++;
								$options[$i]['id']=$row['ResourceTypeOptionPosition']+1;	
								$options[$i]['value']=$row['ResourceTypeOptionName'];
							}
						}
						}
						$newPosition = $out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionPosition'] - 1;
						echo getLists('',$newPosition,array('name'=>'ResourceTypeOption'.DTR.'ResourceTypeOptionPosition','id'=>'ResourceTypeOptionPosition','value'=>'ResourceTypeOptionName','options'=>$options));	
						$options='';
					?>
						</td>						
					</tr>							
					<tr><td width="100%" colspan="2">&nbsp;</td></tr>
					<tr>
						<td valign="top" width="100%" align="center" colspan="2" bgcolor="efefef">
					<? if(empty($out['DB']['ResourceTypeOption'][0]['ResourceTypeOptionID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageResourceTypeOptions.actionMode.value='delete';confirmDelete('manageResourceTypeOptions', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
						</td>						
					</tr>							
					</table>					
			</td> 
		</tr> 
	</form>
	<? }//if (!empty(input('selectedResourceTypeID'))) ?>
<?=boxFooter()?>
<script language="JavaScript">
	var fromValidator = new Validator("manageResourceTypes");
	fromValidator.addValidation("ResourceType<?=DTR?>ResourceTypeAlias","req","<?=lang('EmptyResourceTypeAlias.resource.tip')?>");
	
	<? if (!empty($out['DB']['ResourceType'][0]['ResourceTypeID'])) {?>
	var fromValidator = new Validator("manageResourceTypeFields");
	fromValidator.addValidation("ResourceTypeField<?=DTR?>ResourceTypeFieldAlias","req","<?=lang('EmptyResourceTypeFieldAlias.resource.tip')?>");
		<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			fromValidator.addValidation("ResourceTypeField<?=DTR?>ResourceTypeFieldName[<?=$langCode?>]","req","<?=lang('EmptyResourceTypeFieldName.resource.tip')?>");
		<? }?>
	<? }?>
	
	<? if (!empty($out['DB']['ResourceTypeField'][0]['ResourceTypeFieldID']) && ($out['DB']['ResourceTypeField'][0]['ResourceTypeFieldType']=='dropdown' || $out['DB']['ResourceTypeField'][0]['ResourceTypeFieldType']=='checkboxes' || $out['DB']['ResourceTypeField'][0]['ResourceTypeFieldType']=='radioboxes')) {?>
	var fromValidator = new Validator("manageResourceTypeOptions");
	fromValidator.addValidation("ResourceTypeOption<?=DTR?>ResourceTypeOptionAlias","req","<?=lang('EmptyResourceTypeOptionAlias.resource.tip')?>");
		<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			fromValidator.addValidation("ResourceTypeOption<?=DTR?>ResourceTypeOptionName[<?=$langCode?>]","req","<?=lang('EmptyResourceTypeOptionName.resource.tip')?>");
		<? }?>
	<? }?>
</script>

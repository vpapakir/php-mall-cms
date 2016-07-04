<?=boxHeader(array('title'=>'ManageDomainFields.webcontrol.title'));
$out['DB']['DomainType'][0]['DomainTypeID']=1;
?>
	<? if (!empty($out['DB']['DomainType'][0]['DomainTypeID'])) {?>
	<form name="getDomainTypeFields" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="DomainTypeID" value="<?=$out['DB']['DomainType'][0]['DomainTypeID'];?>" />	
	<tr>
	<td valign=top bgcolor="#efefef" width="100%" align="center">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('DomainTypeFieldNew.webcontrol.tip').' -';
			echo getLists($out['DB']['DomainTypeFields'],$out['DB']['DomainTypeField'][0]['DomainTypeFieldID'],array('name'=>'DomainTypeFieldID','id'=>'DomainTypeFieldID','value'=>'DomainTypeFieldName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr>
	<tr>
	<td>&nbsp;
	 
	</td>
	</tr> 
	<form name="manageDomainTypeFields" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['DomainTypeField'][0]['DomainTypeFieldID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="DomainTypeID" value="<?=$out['DB']['DomainType'][0]['DomainTypeID'];?>" />
		<input type="hidden" name="DomainTypeField<?=DTR?>DomainTypeFieldID" value="<?=$out['DB']['DomainTypeField'][0]['DomainTypeFieldID'];?>" />
		<input type="hidden" name="DomainTypeField<?=DTR?>DomainTypeID" value="<?=$out['DB']['DomainType'][0]['DomainTypeID'];?>" />
		<input type="hidden" name="DomainTypeField<?=DTR?>DomainType" value="<?=$out['DB']['DomainType'][0]['DomainTypeAlias'];?>" />
		
		<input type="hidden" name="DomainTypeFieldID" value="<?=$out['DB']['DomainTypeField'][0]['DomainTypeFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
			<table cellpadding="2" cellspacing="0" width="100%" border="0">
			<tr>
			<td align="left">
					<span class="subtitle"><?=lang('DomainTypeField.DomainTypeFieldAlias')?>*: </span>
			</td>
			<td align="left">
								<input type="text" name="DomainTypeField<?=DTR?>DomainTypeFieldAlias" value="<?=$out['DB']['DomainTypeField'][0]['DomainTypeFieldAlias'];?>" size="50">
			</td>
			</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left">
							<span class="subtitle"><?=lang('DomainTypeField.DomainTypeFieldName')?>*: </span>
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
						</td>
						<td align="left">
							<input type="text" name="DomainTypeField<?=DTR?>DomainTypeFieldName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['DomainTypeField'][0]['DomainTypeFieldName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					<? // =lang('DomainTypeField.DomainTypeFieldMode')?>
					<? // =getReference('DomainTypeField.DomainTypeFieldMode','DomainTypeField'.DTR.'DomainTypeFieldMode',$out['DB']['DomainTypeField'][0]['DomainTypeFieldMode'],array('code'=>'Y'))?>
			<!-- <tr>
			<td align="left" class="subtitle">
					<?=lang('DomainTypeField.DomainTypeFieldGroups')?>: 
			</td>
			<td align="left">
					<?=getReference('DomainTypeFieldGroups','DomainTypeField'.DTR.'DomainTypeFieldGroups',$out['DB']['DomainTypeField'][0]['DomainTypeFieldGroups'],array('code'=>'Y'))?>
			</td>
			</tr> -->
			<tr>
			<td align="left" class="subtitle">
					<?=lang('DomainTypeField.DomainTypeFieldType')?>: 
			</td>
			<td align="left">
					<?=getReference('DataTypes','DomainTypeField'.DTR.'DomainTypeFieldType',$out['DB']['DomainTypeField'][0]['DomainTypeFieldType'],array('code'=>'Y'))?>
			</td>
			</tr>
			<tr>
			<td align="left" class="subtitle">
					<?=lang('-addafter')?>: 
			</td>
			<td align="left">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['DomainTypeFields']))
						{
						foreach($out['DB']['DomainTypeFields'] as $row)
						{
							if ($row['DomainTypeFieldID']!=$out['DB']['DomainTypeField'][0]['DomainTypeFieldID'])
							{
								$i++;
								$options[$i]['id']=$row['DomainTypeFieldPosition']+1;	
								$options[$i]['value']=$row['DomainTypeFieldName'];
							}
						}
						}
						echo getLists('',$out['DB']['DomainTypeField'][0]['DomainTypeFieldPosition']-1,array('name'=>'DomainTypeField'.DTR.'DomainTypeFieldPosition','id'=>'DomainTypeFieldPosition','value'=>'DomainTypeFieldName','options'=>$options));	
						$options='';
					?>
			<tr>
			<td align="center" bgcolor="#efefef" width="100%" colspan="2">
					<? if(empty($out['DB']['DomainTypeField'][0]['DomainTypeFieldID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageDomainTypeFields.actionMode.value='delete';confirmDelete('manageDomainTypeFields', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
			</td>
			</tr>
			</table>
			</td> 
		</tr> 
	</form>
	<? } ?>
	<? if (!empty($out['DB']['DomainTypeField'][0]['DomainTypeFieldID']) && ($out['DB']['DomainTypeField'][0]['DomainTypeFieldType']=='dropdown' || $out['DB']['DomainTypeField'][0]['DomainTypeFieldType']=='checkboxes' || $out['DB']['DomainTypeField'][0]['DomainTypeFieldType']=='radioboxes')) {?>
	<form name="getDomainTypeOptions" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="DomainTypeID" value="<?=$out['DB']['DomainType'][0]['DomainTypeID'];?>" />
	<input type="hidden" name="DomainTypeFieldID" value="<?=$out['DB']['DomainTypeField'][0]['DomainTypeFieldID'];?>" />
	<tr>
	<td>&nbsp;
	 
	</td>
	</tr>
	<tr>
	<td valign=top bgcolor="#efefef" width="100%" align="center">
		<?
			$options[0]['id']='';	
			$options[0]['value']='- '.lang('DomainTypeOptionNew.webcontrol.tip').' -';
			echo getLists($out['DB']['DomainTypeOptions'],$out['DB']['DomainTypeOption'][0]['DomainTypeOptionID'],array('name'=>'DomainTypeOptionID','id'=>'DomainTypeOptionID','value'=>'DomainTypeOptionName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
		?>	
	</td> 
	</form>
	</tr>
	<tr>
	<td>&nbsp;
	 
	</td>
	</tr>
	<form name="manageDomainTypeOptions" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['DomainTypeOption'][0]['DomainTypeOptionID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="DomainTypeID" value="<?=$out['DB']['DomainType'][0]['DomainTypeID'];?>" />
		<input type="hidden" name="DomainTypeFieldID" value="<?=$out['DB']['DomainTypeField'][0]['DomainTypeFieldID'];?>" />
		<input type="hidden" name="DomainTypeOptionID" value="<?=$out['DB']['DomainTypeOption'][0]['DomainTypeOptionID'];?>" />

		<input type="hidden" name="DomainTypeOption<?=DTR?>DomainTypeOptionID" value="<?=$out['DB']['DomainTypeOption'][0]['DomainTypeOptionID'];?>" />
		<input type="hidden" name="DomainTypeOption<?=DTR?>DomainTypeFieldID" value="<?=$out['DB']['DomainTypeField'][0]['DomainTypeFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
			<table cellpadding="2" cellspacing="0" width="100%" border="0">
			<tr>
			<td align="left" class="subtitle">
					<?=lang('DomainTypeOption.DomainTypeOptionAlias')?>*:
			</td>
			<td align="left">
					<input type="text" name="DomainTypeOption<?=DTR?>DomainTypeOptionAlias" value="<?=$out['DB']['DomainTypeOption'][0]['DomainTypeOptionAlias'];?>" size="50">
			</td>
			</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top">
							<span class="subtitle"><?=lang('DomainTypeOption.DomainTypeOptionName')?>*: </span>
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
								<? }?>
						</td>
						<td align="left">
							<input type="text" name="DomainTypeOption<?=DTR?>DomainTypeOptionName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['DomainTypeOption'][0]['DomainTypeOptionName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
					<? if($out['DB']['DomainTypeField'][0]['DomainTypeFieldMode'] =='option') { ?>
					<tr>
						<td valign="top" class="subtitle">
							<?=lang('DomainTypeOption.DomainTypeOptionPrice')?>:
						</td>
						<td align="left">
							<input type="text" name="DomainTypeOption<?=DTR?>DomainTypeOptionPrice" value="<?=$out['DB']['DomainTypeOption'][0]['DomainTypeOptionPrice'];?>" size="10">
						</td>
					</tr>
					<tr>
						<td valign="top" class="subtitle" align="left">
							<?=lang('DomainTypeOption.DomainTypeOptionPriceAction')?>*: 
						</td>
						<td align="left">
							<?=getReference('plusminus','DomainTypeOption'.DTR.'DomainTypeOptionPriceAction',$out['DB']['DomainTypeOption'][0]['DomainTypeOptionPriceAction'],array('code'=>'Y'))?>
						</td>						
					</tr>
					<tr>
						<td valign="top" class="subtitle" align="left">
							<?=lang('DomainTypeOption.DomainTypeOptionWeight')?>: 
						</td>
						<td align="left">
							<input type="text" name="DomainTypeOption<?=DTR?>DomainTypeOptionWeight" value="<?=$out['DB']['DomainTypeOption'][0]['DomainTypeOptionWeight'];?>" size="10">
						</td>
					</tr>
					<tr>
						<td valign="top" class="subtitle">
							<?=lang('DomainTypeOption.DomainTypeOptionWeightAction')?>: 
						</td>
						<td align="left">
							<?=getReference('plusminus','DomainTypeOption'.DTR.'DomainTypeOptionWeightAction',$out['DB']['DomainTypeOption'][0]['DomainTypeOptionWeightAction'],array('code'=>'Y'))?>
						</td>						
					</tr>							
					<? } ?>
			<tr>
			<td align="left" class="subtitle">
					<?=lang('-addafter')?>: 
			</td>
			<td align="left">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['DomainTypeOptions']))				
						{		
						foreach($out['DB']['DomainTypeOptions'] as $row)
						{
							if ($row['DomainTypeOptionID']!=$out['DB']['DomainTypeOption'][0]['DomainTypeOptionID'])
							{
								$i++;
								$options[$i]['id']=$row['DomainTypeOptionPosition']+1;	
								$options[$i]['value']=$row['DomainTypeOptionName'];
							}
						}
						}
						$newPosition = $out['DB']['DomainTypeOption'][0]['DomainTypeOptionPosition'] - 1;
						echo getLists('',$newPosition,array('name'=>'DomainTypeOption'.DTR.'DomainTypeOptionPosition','id'=>'DomainTypeOptionPosition','value'=>'DomainTypeOptionName','options'=>$options));	
						$options='';
					?>
			</td>
			</tr>
			<tr>
			<td>&nbsp;
			 
			</td>
			</tr>
			<tr>
			<td align="center" bgcolor="#efefef" colspan="2" width="100%">
					<? if(empty($out['DB']['DomainTypeOption'][0]['DomainTypeOptionID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageDomainTypeOptions.actionMode.value='delete';confirmDelete('manageDomainTypeOptions', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
			</td>
			</tr>
			</table>
			</td> 
		</tr> 
	</form>
	<? }//if (!empty(input('selectedDomainTypeID'))) ?>
<?=boxFooter()?>
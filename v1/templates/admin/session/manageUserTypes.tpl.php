<?=boxHeader(array('title'=>'ManageUserType.session.title'))?>
	<tr>
		<td valign="top">
			<table cellpadding="2" cellspacing="0" class="fieldNames" width="100%" border="0">
			<tr> 
			<form name="getUserTypes" method="post">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<td bgcolor="#efefef" width="30%" align="left">&nbsp;
			
			</td>
			<td valign=top bgcolor="#efefef" align="left">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('UserGroupSelect.session.tip').' -';
					echo getLists($out['DB']['UserGroups'],input('UserGroupID'),array('name'=>'UserGroupID','id'=>'GroupID','value'=>'GroupName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
				?>	
			</td> 
			</form>
			</tr> 
			<tr>
			<td align="center">&nbsp;
			</td>
			</tr>
			<? if (input('UserGroupID')) {?>
			<form name="getUserTypeFields" method="post">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<input type="hidden" name="UserGroupID" value="<?=input('UserGroupID')?>" />	
			<tr>
			<td bgcolor="#efefef" width="30%" align="left">&nbsp;
			
			</td>
			<td valign=top bgcolor="#efefef" align="left">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('UserTypeFieldNew.session.tip').' -';
					echo getLists($out['DB']['UserTypeFields'],$out['DB']['UserTypeField'][0]['UserTypeFieldID'],array('name'=>'UserTypeFieldID','id'=>'UserTypeFieldID','value'=>'UserTypeFieldName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
				?>	
			</td> 
			</tr> 
			</form>
			</table>
	</td>
	</tr>
	<tr>
	<td align="center">&nbsp;
	</td>
	</tr>	
	<form name="manageUserTypeFields" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<? if(empty($out['DB']['UserTypeField'][0]['UserTypeFieldID'])) { ?>
	<input type="hidden" name="actionMode" value="add" />
	<? } else { ?>
	<input type="hidden" name="actionMode" value="save" />
	<? } ?>
	<input type="hidden" name="UserGroupID" value="<?=input('UserGroupID')?>" />
	<input type="hidden" name="UserTypeField<?=DTR?>UserTypeFieldID" value="<?=$out['DB']['UserTypeField'][0]['UserTypeFieldID'];?>" />
	<input type="hidden" name="UserTypeField<?=DTR?>UserGroupID" value="<?=input('UserGroupID')?>" />
	
	<input type="hidden" name="UserTypeFieldID" value="<?=$out['DB']['UserTypeField'][0]['UserTypeFieldID'];?>" />
	<tr> 
		<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
		<table cellpadding="2" cellspacing="0" width="100%" border="0">
			<tr>
			<td align="left" width="30%">
					<span class="subtitle"><?=lang('UserTypeField.UserTypeFieldAlias')?>*: </span>
			</td>
			<td align="left">
					<input type="text" name="UserTypeField<?=DTR?>UserTypeFieldAlias" value="<?=$out['DB']['UserTypeField'][0]['UserTypeFieldAlias'];?>" size="50">
			</td>
			</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" width="30%" class="fieldNames" align="left">
							<span class="subtitle"><?=lang('UserTypeField.UserTypeFieldName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?></span>
						</td>
						<td align="left">
							<input type="text" name="UserTypeField<?=DTR?>UserTypeFieldName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['UserTypeField'][0]['UserTypeFieldName'],$langCode);?>" />
						</td>
					</tr>	
					<? } ?>			
			<tr>
			<td align="left" width="30%" valign="top">
					<span class="subtitle"><?=lang('UserTypeField.UserTypeFieldType')?>: </span>
			</td>
			<td align="left">
					<?=getReference('DataTypes','UserTypeField'.DTR.'UserTypeFieldType',$out['DB']['UserTypeField'][0]['UserTypeFieldType'],array('code'=>'Y'))?>
			</td>
			</tr>
			<tr>
			<td align="left" width="30%" valign="top">
					<span class="subtitle"><?=lang('UserTypeField.UserTypeFieldGroups')?>: </span>
			</td>
			<td align="left">
					<?=getReference('UserTypeField.UserTypeFieldGroups','UserTypeField'.DTR.'UserTypeFieldGroups',$out['DB']['UserTypeField'][0]['UserTypeFieldGroups'],array('code'=>'Y'))?>
			</td>
			</tr>			
			<tr>
			<td align="left" width="30%">
					<span class="subtitle"><?=lang('-addafter')?>: </span>
			</td>
			<td align="left">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['UserTypeFields']))
						{
							foreach($out['DB']['UserTypeFields'] as $row)
							{
								if ($row['UserTypeFieldID']!=$out['DB']['UserTypeField'][0]['UserTypeFieldID'])
								{
									$i++;
									$options[$i]['id']=$row['UserTypeFieldPosition']+1;	
									$options[$i]['value']=$row['UserTypeFieldName'];
								}
							}
						}
						echo getLists('',$out['DB']['UserTypeField'][0]['UserTypeFieldPosition']-1,array('name'=>'UserTypeField'.DTR.'UserTypeFieldPosition','id'=>'UserTypeFieldPosition','value'=>'UserTypeFieldName','options'=>$options));	
						$options='';
					?>
				</td>
				</tr>
			<tr>
			<td>&nbsp;
			 
			</td>
			</tr>
			<tr>
			<td align="center" bgcolor="#efefef" width="100%" colspan="2">
					<? if(empty($out['DB']['UserTypeField'][0]['UserTypeFieldID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageUserTypeFields.actionMode.value='delete';confirmDelete('manageUserTypeFields', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>
			</td>
			</tr>
		</table>
		</td> 
	</tr> 
	</form>
	<? } ?>
	<tr>
	<td align="center">&nbsp;
	</td>
	</tr>	
	<? if (!empty($out['DB']['UserTypeField'][0]['UserTypeFieldID']) && ($out['DB']['UserTypeField'][0]['UserTypeFieldType']=='dropdown' || $out['DB']['UserTypeField'][0]['UserTypeFieldType']=='checkboxes' || $out['DB']['UserTypeField'][0]['UserTypeFieldType']=='radioboxes')) {?>
	<form name="getUserTypeOptions" method="post">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="UserGroupID" value="<?=input('UserGroupID')?>" />
	<input type="hidden" name="UserTypeFieldID" value="<?=$out['DB']['UserTypeField'][0]['UserTypeFieldID'];?>" />
	<tr> 
	<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
		<table cellpadding="2" cellspacing="0" class="fieldNames" width="100%" border="0">
		<tr>
			<td bgcolor="#efefef" width="30%" align="left">&nbsp;
			
			</td>
			<td valign=top bgcolor="#efefef" align="left">
				<?
					$options[0]['id']='';	
					$options[0]['value']='- '.lang('UserTypeOptionNew.session.tip').' -';
					echo getLists($out['DB']['UserTypeOptions'],$out['DB']['UserTypeOption'][0]['UserTypeOptionID'],array('name'=>'UserTypeOptionID','id'=>'UserTypeOptionID','value'=>'UserTypeOptionName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
				?>	
			</td> 
		</tr>
		</table>
	</td> 
	</tr>
	</form>
	<tr>
	<td align="center">&nbsp;
	</td>
	</tr>
	<form name="manageUserTypeOptions" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['UserTypeOption'][0]['UserTypeOptionID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="UserGroupID" value="<?=input('UserGroupID')?>" />
		<input type="hidden" name="UserTypeFieldID" value="<?=$out['DB']['UserTypeField'][0]['UserTypeFieldID'];?>" />
		<input type="hidden" name="UserTypeOptionID" value="<?=$out['DB']['UserTypeOption'][0]['UserTypeOptionID'];?>" />

		<input type="hidden" name="UserTypeOption<?=DTR?>UserTypeOptionID" value="<?=$out['DB']['UserTypeOption'][0]['UserTypeOptionID'];?>" />
		<input type="hidden" name="UserTypeOption<?=DTR?>UserTypeFieldID" value="<?=$out['DB']['UserTypeField'][0]['UserTypeFieldID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
			<table cellpadding="2" cellspacing="0" width="100%" border="0">
				<tr>
				<td align="left" width="30%">
						<span class="subtitle"><?=lang('UserTypeOption.UserTypeOptionAlias')?>*: </span>
				</td>
				<td align="left">
						<input type="text" name="UserTypeOption<?=DTR?>UserTypeOptionAlias" value="<?=$out['DB']['UserTypeOption'][0]['UserTypeOptionAlias'];?>" size="50">
				</td>
				</tr>
				<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				<tr>
					<td valign="top" width="30%" class="fieldNames" align="left">
						<span class="subtitle"><?=lang('UserTypeOption.UserTypeOptionName')?>*: <?=$out['DB']['Languages']['languageNames'][$langID]?></span>
					</td>
					<td align="left">
						<input type="text" name="UserTypeOption<?=DTR?>UserTypeOptionName[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['UserTypeOption'][0]['UserTypeOptionName'],$langCode);?>" />
					</td>
				</tr>	
				<? } ?>			
	
				<tr>
				<td align="left">
				<span class="subtitle"><?=lang('-addafter')?>: </span>
				</td>
				<td align="left">
				<?
					$options[0]['id']='1';	
					$options[0]['value']='- '.lang('-first').' -';
					if(is_array($out['DB']['UserTypeOptions']))				
					{		
					foreach($out['DB']['UserTypeOptions'] as $row)
					{
						if ($row['UserTypeOptionID']!=$out['DB']['UserTypeOption'][0]['UserTypeOptionID'])
						{
							$i++;
							$options[$i]['id']=$row['UserTypeOptionPosition']+1;	
							$options[$i]['value']=$row['UserTypeOptionName'];
						}
					}
					}
					$newPosition = $out['DB']['UserTypeOption'][0]['UserTypeOptionPosition'] - 1;
					echo getLists('',$newPosition,array('name'=>'UserTypeOption'.DTR.'UserTypeOptionPosition','id'=>'UserTypeOptionPosition','value'=>'UserTypeOptionName','options'=>$options));	
					$options='';
				?>
				</td>
				</tr>
				<tr>
				<td>&nbsp;
				 
				</td>
				</tr>
				<tr>
				<td align="center" bgcolor="#efefef" width="100%" colspan="2">
				<? if(empty($out['DB']['UserTypeOption'][0]['UserTypeOptionID'])) { ?>
				<input type="submit" value="<?=lang("-add")?>">
				<? } else { ?>
				<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageUserTypeOptions.actionMode.value='delete';confirmDelete('manageUserTypeOptions', '<?=lang("-deleteconfirmation")?>');">
				<? } ?>					
				</td>
				</tr>
			</table>
			</td> 
		</tr> 
	</form>
	<? }//if (!empty(input('selectedUserGroupID'))) ?>
<?=boxFooter()?>
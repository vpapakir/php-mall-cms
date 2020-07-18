<?=boxHeader(array('title'=>'ManageSettingGroups.core.title'))?>
	<?
		if(input('actionMode')=='save' || input('actionMode')=='add' || input('actionMode')=='cancell' || input('actionMode')=='delete')
		{
			if(input('GroupID') || input('Level2GroupID'))
			{
				$groupID = input('GroupID');
				if(!input('Level2GroupID'))
				{
					$groupIDLevel2 = $out['DB']['SettingGroup'][0]['SettingGroupID'];
				}
				else
				{
					$groupIDLevel2 = input('Level2GroupID');
				}
				goLink(setting('url').'manageSettings/GroupID/'.$groupID.'/Level2GroupID/'.$groupIDLevel2);
			}
		}
	
	?>
	<tr> 
	<form name="getSettingGroups" method="post">
	<input type="hidden" name="SID" value="manageSettingGroups" />
	<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
	<input type="hidden" name="Level2GroupID" value="<?=input('Level2GroupID')?>" />
	<input type="hidden" name="GroupParentID" value="<?=input('GroupParentID')?>" />
	<td valign=top bgcolor="#efefef" width="100%" align="center">
		<?=$out['Refs']['SettingGroups']?>
	</td> 
	</form>
	</tr> 

	<form name="manageSettingGroups" method="post">
		<input type="hidden" name="SID" value="manageSettingGroups" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="Level2GroupID" value="<?=input('Level2GroupID')?>" />
		<input type="hidden" name="GroupParentID" value="<?=input('GroupParentID')?>" />
		
		<? if(empty($out['DB']['SettingGroup'][0]['SettingGroupID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="SettingGroup<?=DTR?>SettingGroupID" value="<?=$out['DB']['SettingGroup'][0]['SettingGroupID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
				<table cellpadding="2" cellspacing="0" width="100%" border="0">
				<tr>
				<td align="left">
					<span class="subtitle"><?=lang('SettingGroups.SettingGroupCode')?>:</span>
					<?
						if(!empty($out['DB']['SettingGroup'][0]['SettingGroupCode'])) {$settingGroupCode = $out['DB']['SettingGroup'][0]['SettingGroupCode'];}
						else {$settingGroupCode = input('SettingGroupCode').'.';}
						
					?>
				</td>
				<td align="left">
					<input type="text" name="SettingGroup<?=DTR?>SettingGroupCode" value="<?=$settingGroupCode?>" size="50">
				</td>
				</tr>
				<tr>
				<td align="left">
					<span class="subtitle"><?=lang('SettingGroups.SettingGroupModule')?>: </span>
				</td>
				<td align="left">
					<input type="text" name="SettingGroup<?=DTR?>SettingGroupModule" value="<?=$out['DB']['SettingGroup'][0]['SettingGroupModule'];?>" size="50">
				</td>
				</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left">
							<span class="subtitle"><?=lang('SettingGroup.SettingGroupName')?>: </span>
						</td>
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
						<td align="left">
							<input type="text" name="SettingGroup<?=DTR?>SettingGroupName[<?=$langCode?>]" value="<?=getValue($out['DB']['SettingGroup'][0]['SettingGroupName'],$langCode)?>" size="50">
						</td>
					</tr>	
					<? } ?>						
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="fieldNames" align="left">
							<span class="subtitle"><?=lang('SettingGroup.SettingGroupDescription')?>: </span>
						</td>
						<td align="left">
							<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
							<textarea name="SettingGroup<?=DTR?>SettingGroupDescription[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['SettingGroup'][0]['SettingGroupDescription'],$langCode);?></textarea>
						</td>
					</tr>	
					<? } ?>			
					<tr>
					<td align="left">
					<span class="subtitle"><?=lang('SettingGroup.AccessGroups')?>: </span>
					</td>
					<td align="left">
					<?
						$options[0]['id']='all';	
						$options[0]['value']=lang('-allgroups');
						echo getLists($out['DB']['UserGroups'],$out['DB']['SettingGroup'][0]['AccessGroups'],array('name'=>'SettingGroup'.DTR.'AccessGroups','id'=>'GroupID','value'=>'GroupName','type'=>'checkboxes','options'=>$options));	
					?>
					</td>
					</tr>
					<tr>
					<td align="center" bgcolor="#efefef" width="100%" colspan="2">
					<? if(empty($out['DB']['SettingGroup'][0]['SettingGroupID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">&nbsp;&nbsp;
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageSettingGroups.actionMode.value='delete';confirmDelete('manageSettingGroups', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>
					<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageSettingGroups.actionMode.value='cancell';submit();">
				</td>
				</tr>
				</table>
			</td> 
		</tr> 
		
	</form>	

<?=boxFooter()?>
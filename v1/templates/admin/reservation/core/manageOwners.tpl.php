<?=boxHeader(array('title'=>'ManageOwners.core.title'))?>
	<tr>
		<td>
			<table cellpadding="2" cellspacing="0" width="100%" border="0">
				<tr> 
				<form name="getOwners" method="post">
				<input type="hidden" name="SID" value="manageOwners" />
					<td width="34%" bgcolor="#efefef">&nbsp;</td>
					<td valign=top bgcolor="#efefef" align="left">
						<?=$out['Refs']['Owners']?>
					</td> 
				</form>
				</tr> 
			</table>
		</td>
	</tr>
	<form name="manageOwners" method="post">
		<input type="hidden" name="SID" value="manageOwners" />
		<? if(empty($out['DB']['Owner'][0]['OwnerID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="Owner<?=DTR?>OwnerID" value="<?=$out['DB']['Owner'][0]['OwnerID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
			<table cellpadding="2" cellspacing="0" width="100%" border="0">
			<tr>
				<td align="left" class="subtitle"><?=lang('Owner.OwnerCode')?>:</td>
				<td align="left">
						<input type="text" name="Owner<?=DTR?>OwnerCode" value="<?=$out['DB']['Owner'][0]['OwnerCode'];?>" size="50">
				</td>
			</tr>
			<tr>
				<td align="left" class="subtitle"><?=lang('Owner.OwnerDomain')?>:</td>
				<td align="left">
						<input type="text" name="Owner<?=DTR?>OwnerDomain" value="<?=$out['DB']['Owner'][0]['OwnerDomain'];?>" size="50">
				</td>
			</tr>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td valign="top" class="subtitle" align="left">
					<?=lang('Owner.OwnerName')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
				</td>
				<td align="left">
					<input type="text" name="Owner<?=DTR?>OwnerName[<?=$langCode?>]" value="<?=getValue($out['DB']['Owner'][0]['OwnerName'],$langCode);?>" size="50"/>
				</td>
			</tr>	
			<? } ?>
			<tr>
			<td align="left" class="subtitle"><?=lang('Owner.OwnerStyle')?>:</td>
			<td align="left">
					<?=getLists($out['DB']['Styles'],$out['DB']['Owner'][0]['OwnerStyle'],array('name'=>'Owner'.DTR.'OwnerStyle','id'=>'SettingGroupCode','value'=>'SettingGroupName'))?>
			</td>
			</tr>
			<tr>
			<td align="left" class="subtitle"><?=lang('Owner.OwnerIsDefault')?>:</td>
			<td align="left">
					<?=$out['Refs']['OwnerIsDefault']?>						
			</td>
			</tr>
			<tr>
			<td align="left" class="subtitle"><?=lang('Owner.PermAll')?>:</td>
			<td align="left">
					<?=$out['Refs']['PermAll']?>					
			</td>
			<tr>
			<td colspan="2">&nbsp;</td>
			</tr>
			<tr>
			<td align="center" bgcolor="#efefef" width="100%" colspan="2">
					<? if(empty($out['DB']['Owner'][0]['OwnerID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageOwners.actionMode.value='delete';confirmDelete('manageOwners', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
			</td>
			</tr>
			</table>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>
<? //boxHeader(array('title'=>'AddOwner.core.title')); 
	if(input('actionMode')=='add' && !empty($out['DB']['Owner'][0]['OwnerID'])) { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
			<?=lang('OwnerRegistered.core.tip')?>
			<br/>
			<div align="center">
				<?=lang('YourOwnerURL.core.tip')?>:
				<br/>
				<a href="http://<?=$out['DB']['Owner'][0]['OwnerDomain']?>" target="_blank">http://<?=$out['DB']['Owner'][0]['OwnerDomain']?></a>
				<? if(setting('OwnerType')!='root') { ?>
				<? } else { ?>
				<br/><br/>
				<a href="<?=setting('rooturl')?>go/<?=$out['DB']['Owner'][0]['OwnerCode']?>.<?=setting('lang')?>/myWebsite/">[<?=lang('EditOwnerSettings.core.link')?>]</a>
				<br/><br/>
				<? } ?>
			</div>			
		</td> 
	</tr>
	<? } else { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
			<?=lang('NoOwner.core.tip')?>
			<br/><br/>
			<?=lang('SearchFreeOwnerName.core.tip')?>
		</td> 
	</tr>
	<form name="registerOwner" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="actionMode" value="add" />
		<input type="hidden" name="Owner<?=DTR?>PermAll" value="1" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" width="100%">
			<table cellpadding="2" cellspacing="0" width="100%" border="0">
			<tr>
				<td align="left" class="subtitle"><?=lang('Owner.OwnerCode')?>: <?=lang('Owner.OwnerCode.helptip')?></td>
				<td align="left">
						<input type="text" name="Owner<?=DTR?>OwnerCode" value="<?=$out['DB']['Owner'][0]['OwnerCode'];?>" size="50">
				</td>
			</tr>
			<? /* tr>
				<td align="left" class="subtitle"><?=lang('Owner.OwnerDomain')?>:</td>
				<td align="left">
						<input type="text" name="Owner<?=DTR?>OwnerDomain" value="<?=$out['DB']['Owner'][0]['OwnerDomain'];?>" size="50">
				</td>
			</tr */ ?>
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
	<? } ?>
<? //boxFooter()?>
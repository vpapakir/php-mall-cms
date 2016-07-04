<?=boxHeader(array('title'=>'ManageSettingText.core.title'))?>
	<form name="manageSettings" method="post" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageSettings" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="SettingID" value="<?=input('SettingID')?>" />
		<input type="hidden" name="Level2GroupID" value="<?=input('Level2GroupID')?>" />
		<? if(empty($out['DB']['Setting'][0]['SettingID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="Setting<?=DTR?>SettingID" value="<?=$out['DB']['Setting'][0]['SettingID']?>">
		<input type="hidden" name="Setting<?=DTR?>SettingVariableName" value="<?=$out['DB']['Setting'][0]['SettingVariableName']?>">
		<input type="hidden" name="Setting<?=DTR?>SettingValueType" value="<?=$out['DB']['Setting'][0]['SettingValueType']?>">
		<? } ?>		
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" class="fieldNames">
						
						<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
							<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<br/>
							<?=getFormated(getValue($out['DB']['Setting'][0]['SettingValue'],$langCode),'HTML','form',array('fieldName'=>'Setting'.DTR.'SettingValue['.$langCode.']','editorName'=>'SettingValue'.$langCode,'editorWidth'=>550,'editorHeight'=>400,'editorToolbar'=>'Default'))?>
							<br/>
						<? } ?>			
										
						</td>
					</tr>	
					</table>		
					<br/>
					<? if(empty($out['DB']['Setting'][0]['SettingID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">
					<? } ?>					
					
					<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>
<?=boxHeader(array('title'=>'ManageLanguageField.core.title'))?>
	<tr> 
		<td valign=top bgcolor="#ffffff">
		<table width="100%" cellpadding="5" cellspacing="0" border="0">
		<tr>
			<td colspan="2">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<form name="getLangFields" method="post">
				<input type="hidden" name="SID" value="adminTranslation" />
				<input type="hidden" name="searchWord" value="<?=input('searchWord')?>" />
				<tr><td><?=$out['Refs']['LangFields']?></td></tr>
				</form>
			</table>
			</td>
		</tr>
		<tr>
			<td colspan="2">
			<table width="100%" cellpadding="0" cellspacing="0" border="0">
				<form name="searchLangFields" method="post" >
				<input type="hidden" name="SID" value="adminTranslation" />
				<tr>
					<td>
					<input type="text" name="searchWord" size="20" value="<?=input('searchWord')?>">
					<input type="submit" value="<?=lang('SearchCode.core.button')?>">
					</td>
				</tr>
				</form>
			</table>
			</td>
		</tr>		
		    <form name="manageLangFields" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		    <input type="hidden" name="SID" value="adminTranslation" />
		    <? if(empty($out['DB']['LangField'][0]['LangFieldID'])) { ?>
		    <input type="hidden" name="actionMode" value="add" />
		    <? } else { ?>
		    <input type="hidden" name="actionMode" value="save" />
		    <? } ?>
		    <input type="hidden" name="LangField<?=DTR?>LangFieldID" value="<?=$out['DB']['LangField'][0]['LangFieldID'];?>" />
		    <input type="hidden" name="searchWord" value="<?=input('searchWord')?>" />

		<tr>
		    <td class="subtitle" colspan="2">
			<hr size="1">
			<?=lang('LangCodeFormat.core.hint','html')?>
		    <hr size="1">
		    </td>
		</tr>
		<tr>
		    <td class="subtitle">
			<?=lang('LangField.Code')?>:
		    </td>
		    <td>
			<input type="text" name="LangField<?=DTR?>Code" value="<?=$out['DB']['LangField'][0]['Code'];?>" size="50">				
		    </td>
		</tr>
		    <? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
		<tr>
		    <td valign="top" class="subtitle">
			<?=lang('LangField.Value')?>: 
			<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
			<?=$out['DB']['Languages']['languageNames'][$langID]?>
			<? }?>
		    </td>
		    <td>
			<textarea name="LangField<?=DTR?>Value[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['LangField'][0]['Value'],$langCode);?></textarea>
		    </td>
		</tr>
		    <? } ?>
		<tr>
		    <td class="subtitle">
			<?=lang('LangField.PutLanguages')?>:
		    </td>
		    <td>
			<?foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)
			{
			$languagesList[$langID]['id']=$out['DB']['Languages']['languageCodes'][$langID];	
			$languagesList[$langID]['value']=$langName;		
			}						
			echo getLists($languagesList,$out['DB']['LangField'][0]['PutLanguages'],array('name'=>'LangField'.DTR.'PutLanguages','type'=>'checkboxes'));	
			?>
		    </td>
		</tr>
		<tr>
		    <td class="subtitle">
			<?=lang('LangField.FileValue')?>: 
		    </td>
		    <td>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<? $value = getValue($out['DB']['LangField'][0]['FileValue'],$langCode);
			if(!empty($value)) { ?>
			<img src="<?=setting('urlfiles').$value?>" border="0" />
			<br/>
			<a href="<?=setting('url').input('SID')?>/LangFieldID/<?=$out['DB']['LangField'][0]['LangFieldID']?>/selectedLangFieldID/<?=$out['DB']['LangField'][0]['LangFieldID']?>/actionMode/deletefile/fileField/FileValue/lang/<?=$langCode?>"><?=lang('-deleteimage')?></a>
			<? } ?>
			<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
			<?=$out['DB']['Languages']['languageNames'][$langID]?>
			<? }?>
			<br/>
			<input size="22" type="file" name="uploadFile[FileValue_lang_<?=$langCode?>]" />
			<input type="hidden" name="oldUploadFile[FileValue_lang_<?=$langCode?>]" value="<?=$value?>" />
			<br/>
			<? } ?>
		    </td>
		</tr>
		<tr>
		    <td class="subtitle">
			<?=lang('LangField.LockMode')?>:
		    </td>
		    <td>
			<?=getReference('LockMode','LangField'.DTR.'LockMode',$out['DB']['LangField'][0]['LockMode'],array('code'=>'Y'))?>
		    </td>
		</tr>
		</table>
	    </td>
	<tr>
	    <td class="subtitleline" align="center">
		<? if(empty($out['DB']['LangField'][0]['LangFieldID'])) { ?>
		<input type="submit" value="<?=lang("-add")?>">
		<? } else { ?>
		<input type="submit" value="<?=lang("-save")?>">
		&nbsp;&nbsp;
		<? if(empty($out['searchWord'])) { ?>
		<input type="button" value="<?=lang("-next")?>" onClick="document.manageLangFields.actionMode.value='next';submit();">&nbsp;&nbsp;
		<? } ?>
		<input type="button" value="<?=lang("-delete")?>" onClick="document.manageLangFields.actionMode.value='delete';confirmDelete('manageLangFields', '<?=lang("-deleteconfirmation")?>');">
		<? } ?>					
		<br/>
	    </td> 
	</tr> 
		
	</form>	

<?=boxFooter()?>
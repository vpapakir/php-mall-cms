<?=boxHeader(array('title'=>'ManageLanguages.core.title'))?>
	<tr> 
	<form name="getLanguages" method="post">
	<input type="hidden" name="SID" value="adminLanguages" />
	<td valign=top bgcolor="#efefef" align="center" width="100%">
		<?=$out['Refs']['Languages']?>
	</td> 
	</form>
	</tr> 
	<tr>
	<td>&nbsp;
	 
	</td>
	</tr>
	<? $formName='adminLanguages';?>
	<form name="adminLanguages" method="post" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="adminLanguages" />
		<? if(empty($out['DB']['Language'][0]['LanguageID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="Language<?=DTR?>LanguageID" value="<?=$out['DB']['Language'][0]['LanguageID'];?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" width="100%">
				<table cellpadding="2" cellspacing="0" width="100%" border="0">
					<tr>
						<td class="subtitle" align="left">
							<span><?=lang('Language.LanguageCode')?>: </span>
						</td>
						<td align="left">
							<input type="text" name="Language<?=DTR?>LanguageCode" value="<?=$out['DB']['Language'][0]['LanguageCode'];?>" size="50">
						</td>
					</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top" class="subtitle" align="left">
							<?=lang('Language.LanguageName')?>: 
								<? if(count($out['DB']['Languages']['languageCodes'])>1){?>
								<?=$out['DB']['Languages']['languageNames'][$langID]?>
							<? }?>
						</td>
						<td align="left">
						<input type="text" name="Language<?=DTR?>LanguageName[<?=$langCode?>]" value="<?=getValue($out['DB']['Language'][0]['LanguageName'],$langCode);?>" size="50">
						</td>
					</tr>	
					<? } ?>		
					<? /*tr>
						<td align="left">
							<span class="subtitle"><?=lang('Language.LanguageIsDefault')?>: </span>
						</td>
						<td align="left">
							<?=getReference('YesNo','Language'.DTR.'LanguageIsDefault',$out['DB']['Language'][0]['LanguageIsDefault'],array('code'=>'Y'))?>
						</td>
					</tr */ ?>
					<tr>
						<td class="subtitle" align="left">
							<span><?=lang('Language.LanguageTranslationType')?>: </span>
						</td>
						<td align="left">
							<?=getReference('Language.LanguageTranslationType','Language'.DTR.'LanguageTranslationType',$out['DB']['Language'][0]['LanguageTranslationType'],array('code'=>'Y'))?>
						</td>
					</tr>
					
					<tr>
						<td class="subtitle" valign="top"><?=lang('Language.LanguageIcon')?></td>
						<td>
							<input type="hidden" name="fileField"/>
							<input type="hidden" name="LanguageID" value="<?=$out['DB']['Language'][0]['LanguageID']?>">
							<? $fieldName = 'LanguageIcon';  echo getFormated($out['DB']['Language'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="#" onClick="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
						</td>
					</tr>
					<tr>
						<td class="subtitle" valign="top"><?=lang('Language.LanguageIconActive')?></td>
						<td>
							<? $fieldName = 'LanguageIconActive';  echo getFormated($out['DB']['Language'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="#" onClick="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
						</td>
					</tr>
					<tr>
						<td class="subtitle" align="left">
							<span class="subtitle"><?=lang('Language.PermAll')?>: </span>
						</td>
						<td align="left">
							<?=$out['Refs']['PermAll']?>
						</td>
					</tr>
					<tr>
						<td align="center" class="subtitle" colspan="2">
							<? if(empty($out['DB']['Language'][0]['LanguageID'])) { ?>
							<input type="submit" value="<?=lang("-add")?>">
							<? } else { ?>
							<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.adminLanguages.actionMode.value='delete';confirmDelete('adminLanguages', '<?=lang("-deleteconfirmation")?>');">
							<? } ?>					
						</td>
					</tr>
				</table>
			</td> 
		</tr> 
		
	</form>	

<?=boxFooter()?>
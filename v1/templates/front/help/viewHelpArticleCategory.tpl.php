<?=boxHeader(array('title'=>'ManageHelpArticleCategory.help.title'))?>
<? $entityID = $out['DB']['HelpArticleCategory'][0]['HelpArticleCategoryID'];
	$formName = 'manageHelpArticleCategories';
 ?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageHelpArticleCategories" />
		<? if(empty($out['DB']['HelpArticleCategory'][0]['HelpArticleCategoryID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="HelpArticleCategory<?=DTR?>HelpArticleCategoryID" value="<?=$out['DB']['HelpArticleCategory'][0]['HelpArticleCategoryID']?>">
		<? } ?>		
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td valign="top" class="fieldNames">
							<input type="hidden" name="HelpArticleCategory<?=DTR?>HelpArticleCategoryPosition" value="<? if(!empty($entityID)){ echo $out['DB']['HelpArticleCategory'][0]['HelpArticleCategoryPosition'];} else { echo input('HelpArticleCategoryPosition');}?>" size="5">					
							<?=lang('HelpArticleCategory.HelpArticleCategoryParentID')?>:<br/>
							<?=$out['Refs']['HelpArticleCategoryParentID']?>							
							<br/><br/>				
							<?=lang('HelpArticleCategory.HelpArticleTypes')?>*:<br/>
							<? 
								/*$options[0]['id']='';	
								$options[0]['value']='- '.lang('HelpArticleTypeSelect.help.tip').' -';
								echo getLists($out['DB']['HelpArticleTypes'],$out['DB']['HelpArticleCategory'][0]['HelpArticleType'],array('name'=>'HelpArticleCategory'.DTR.'HelpArticleType','id'=>'HelpArticleTypeAlias','value'=>'HelpArticleTypeName','style'=>'width:200px;','options'=>$options));	
							*/
							?>
							<?=getReference('HelpArticleType','HelpArticleCategory'.DTR.'HelpArticleType',$out['DB']['HelpArticleCategory'][0]['HelpArticleType'],array('code'=>'Y'))?>
							<hr size="1">
							<?=lang('HelpArticleCategory.HelpArticleCategoryAlias')?>:<br/>
							<input type="text" name="HelpArticleCategory<?=DTR?>HelpArticleCategoryAlias" value="<?=$out['DB']['HelpArticleCategory'][0]['HelpArticleCategoryAlias'];?>" size="50">
							<br/>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('HelpArticleCategory.HelpArticleCategoryTitle')?>*: <? if(count($out['DB']['Languages']['languageCodes'])>1){?><?=$out['DB']['Languages']['languageNames'][$langID]?><? }?>
								<br/>
								<input type="text" name="HelpArticleCategory<?=DTR?>HelpArticleCategoryTitle[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['HelpArticleCategory'][0]['HelpArticleCategoryTitle'],$langCode);?>">
								<br/>
							<? } ?>	
							<hr size="1">
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('HelpArticleCategory.HelpArticleCategoryDescription')?>: <? if(count($out['DB']['Languages']['languageCodes'])>1){?><?=$out['DB']['Languages']['languageNames'][$langID]?><? }?>
								<br/>
								<textarea name="HelpArticleCategory<?=DTR?>HelpArticleCategoryDescription[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['HelpArticleCategory'][0]['HelpArticleCategoryDescription'],$langCode);?></textarea>
								<br/>
							<? } ?>	
							<hr size="1">
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('HelpArticleCategory.HelpArticleCategoryKeywords')?>: <? if(count($out['DB']['Languages']['languageCodes'])>1){?><?=$out['DB']['Languages']['languageNames'][$langID]?><? }?>
								<br/>
								<textarea name="HelpArticleCategory<?=DTR?>HelpArticleCategoryKeywords[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['HelpArticleCategory'][0]['HelpArticleCategoryKeywords'],$langCode);?></textarea>
								<br/>
							<? } ?>
							<!-- Category Icon -->
							<input type="hidden" name="fileField"/>
							<input type="hidden" name="lang"/>
							<hr size="1">
							<? $fieldName = 'HelpArticleCategoryIcon';  echo getFormated($out['DB']['HelpArticleCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'HelpArticleCategory','deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
							<hr size="1">
							<? $fieldName = 'HelpArticleCategoryImagePreview';  echo getFormated($out['DB']['HelpArticleCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'HelpArticleCategory','deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
							<hr size="1">
							<? $fieldName = 'HelpArticleCategoryImage';  echo getFormated($out['DB']['HelpArticleCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'HelpArticleCategory','deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
							<hr size="1">
							<? $fieldName = 'HelpArticleCategoryImageTitle'; echo getFormated($out['DB']['HelpArticleCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'formName'=>$formName,'langCode'=>'HelpArticleCategory','langMode'=>'Y','deleteLinkOnClick'=>'document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';'))?>
							<hr size="1">
							<? $fieldName = 'HelpArticleCategoryImageButton'; echo getFormated($out['DB']['HelpArticleCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'formName'=>$formName,'langCode'=>'HelpArticleCategory','langMode'=>'Y','deleteLinkOnClick'=>'document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';'))?>
							<hr size="1">
							<? $fieldName = 'HelpArticleCategoryImageButtonHover'; echo getFormated($out['DB']['HelpArticleCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'formName'=>$formName,'langCode'=>'HelpArticleCategory','langMode'=>'Y','deleteLinkOnClick'=>'document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';'))?>
							<hr size="1">
							<? $fieldName = 'HelpArticleCategoryImageButtonCurrent'; echo getFormated($out['DB']['HelpArticleCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'formName'=>$formName,'langCode'=>'HelpArticleCategory','langMode'=>'Y','deleteLinkOnClick'=>'document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';'))?>
							<hr size="1">
							<?=lang('HelpArticleCategory.HelpArticleCategoryHiddenPlaces')?>:<br/>
							<?=getReference('HelpArticleCategory.HelpArticleCategoryHiddenPlaces','HelpArticleCategory'.DTR.'HelpArticleCategoryHiddenPlaces',$out['DB']['HelpArticleCategory'][0]['HelpArticleCategoryHiddenPlaces'],array('code'=>'Y'))?>
							<br/>
							<hr size="1">
							<?=lang('HelpArticleCategory.PermAll')?>:<br/>
							<? if(empty($out['DB']['HelpArticleCategory'][0]['PermAll'])) {$out['DB']['HelpArticleCategory'][0]['PermAll']=1;} ?>
							<?=getReference('PermAll','HelpArticleCategory'.DTR.'PermAll',$out['DB']['HelpArticleCategory'][0]['PermAll'],array('code'=>'Y'))?>
							<br/>	
						</td>
					</tr>	
					</table>		
					<br/>
					<? if(empty($out['DB']['HelpArticleCategory'][0]['HelpArticleCategoryID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageHelpArticleCategories.actionMode.value='delete';confirmDelete('manageHelpArticleCategories', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageHelpArticleCategories.actionMode.value='cancell';submit();">
					<br/>
			</td> 
		</tr> 
	</form>	
	<script language="JavaScript">
			var fromValidator = new Validator("<?=$formName?>");
			fromValidator.addValidation("HelpArticleCategory<?=DTR?>HelpArticleType","req","<?=lang('HelpArticleType.help.tip')?>");
			//fromValidator.addValidation("HelpArticleCategory<?=DTR?>HelpArticleCategoryAlias","req","<?=lang('HelpArticleCategoryAlias.help.tip')?>");
			//<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				//fromValidator.addValidation("HelpArticleCategory<?=DTR?>HelpArticleCategoryTitle[<?=$langCode?>]","req","<?=lang('HelpArticleCategoryTitle.help.tip')?>");
			//<? }?>
	</script>
<?=boxFooter()?>
<?=boxHeader(array('title'=>'ManageResourceCategory.resource.title'))?>
<? $entityID = $out['DB']['ResourceCategory'][0]['ResourceCategoryID'];
	$formName = 'manageResourceCategories';
 ?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageCategories" />
		<? if(empty($out['DB']['ResourceCategory'][0]['ResourceCategoryID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="ResourceCategory<?=DTR?>ResourceCategoryID" value="<?=$out['DB']['ResourceCategory'][0]['ResourceCategoryID']?>">
		<? } ?>		
		<input type="hidden" name="SectionGroupCode" value="<?=input('SectionGroupCode')?>" />
		
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td valign="top" class="fieldNames" width="100%">
						<table cellpadding="2" cellspacing="0" border="0" width="100%">
						<tr>
						<td align="center" bgcolor="#efefef" width="100%" colspan="2" class="subtitle">
							<?=lang('CategoryMainInfo.resource.subtitle')?>
						</td>
						</tr>
						<tr>
						<td align="left" class="subtitle" width="30%">
							<input type="hidden" name="ResourceCategory<?=DTR?>ResourceCategoryPosition" value="<? if(!empty($entityID)){ echo $out['DB']['ResourceCategory'][0]['ResourceCategoryPosition'];} else { echo input('ResourceCategoryPosition');}?>" size="5">					
							<?=lang('ResourceCategory.ResourceCategoryParentID')?>: 
						</td>
						<td align="left">
							<?=$out['Refs']['ResourceCategoryParentID']?>							
						</td>
						</tr>
						<? if(setting('CategoryUseType')!='N') { ?>
						<tr>
						<td align="left" class="subtitle" valign="top">
							<?=lang('ResourceCategory.ResourceTypes')?>*: 
						</td>
						<td align="left" valign="top">
							<? 
								$options[0]['id']='';	
								$options[0]['value']='- '.lang('ResourceTypeSelect.resource.tip').' -';
								echo getLists($out['DB']['ResourceTypes'],$out['DB']['ResourceCategory'][0]['ResourceType'],array('name'=>'ResourceCategory'.DTR.'ResourceType','id'=>'ResourceTypeAlias','value'=>'ResourceTypeName','style'=>'width:200px;','options'=>$options));	
							?>
						</td>
						</tr>
						<? } ?>
						<tr>
						<td bgcolor="#efefef" colspan="2" width="100%" align="center" valign="top">
							<span class="subtitle"><?=lang('CategoryContentInfo.resource.subtitle')?></span>
						</td>
						</tr>
						<tr>
						<td align="left" class="subtitle" valign="top">
							<?=lang('ResourceCategory.ResourceCategoryAlias')?>: 
						</td>
						<td align="left" valign="top">
							<input type="text" name="ResourceCategory<?=DTR?>ResourceCategoryAlias" value="<?=$out['DB']['ResourceCategory'][0]['ResourceCategoryAlias'];?>" size="50">
						</td>
						</tr>
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
							<tr>
							<td align="left" valign="top">
								<span  class="subtitle"><?=lang('ResourceCategory.ResourceCategoryTitle')?>*:</span> <? if(count($out['DB']['Languages']['languageCodes'])>1){?><?=$out['DB']['Languages']['languageNames'][$langID]?><? }?>
							</td>
							<td align="left" valign="top">
								<input type="text" name="ResourceCategory<?=DTR?>ResourceCategoryTitle[<?=$langCode?>]" size="50" value="<?=getValue($out['DB']['ResourceCategory'][0]['ResourceCategoryTitle'],$langCode);?>">
							</td>
							</tr>
						<tr>
							<td class="subtitle" valign="top"><?=lang('ResourceCategory.ResourceCategoryIntroContent')?></td>
							<td>
								<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
									<? if(count($out['DB']['Languages']['languageCodes']>1)) { ?><?=$out['DB']['Languages']['languageNames'][$langID]?><br/><? } ?>
									<?=getFormated(getValue($out['DB']['ResourceCategory'][0]['ResourceCategoryIntroContent'],$langCode),'HTML','form',array('fieldName'=>'ResourceCategory'.DTR.'ResourceCategoryIntroContent['.$langCode.']','editorName'=>'ResourceCategoryIntroContent'.$langCode,'editorHeight'=>200))?>
									<br/>
								<? } ?>								
							</td>
						</tr>
							<? } ?>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
							<tr>
							<td align="left" valign="top">
								<span class="subtitle"><?=lang('ResourceCategory.ResourceCategoryDescription')?>: </span><? if(count($out['DB']['Languages']['languageCodes'])>1){?><?=$out['DB']['Languages']['languageNames'][$langID]?><? }?>
							</td>
							<td align="left" valign="top">
								<!--<textarea name="ResourceCategory<?=DTR?>ResourceCategoryDescription[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['ResourceCategory'][0]['ResourceCategoryDescription'],$langCode);?></textarea>-->
								<?=getFormated(getValue($out['DB']['ResourceCategory'][0]['ResourceCategoryDescription'],$langCode),'HTML','form',array('fieldName'=>'ResourceCategory'.DTR.'ResourceCategoryDescription['.$langCode.']','editorName'=>'ResourceCategoryDescription'.$langCode,'editorHeight'=>400))?>
							</td>
							</tr>
							<? } ?>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
							<tr>
							<td align="left" valign="top">
								<span class="subtitle"><?=lang('ResourceCategory.ResourceCategoryKeywords')?>: </span><? if(count($out['DB']['Languages']['languageCodes'])>1){?><?=$out['DB']['Languages']['languageNames'][$langID]?><? }?>
							</td>
							<td align="left" valign="top">
								<textarea name="ResourceCategory<?=DTR?>ResourceCategoryKeywords[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['ResourceCategory'][0]['ResourceCategoryKeywords'],$langCode);?></textarea>
							</td>
							</tr>
							<? } ?>
							<tr>
							<td align="center" class="subtitleline" colspan="2" valign="top">
								<span class="subtitle"><?=lang('CategoryButtonsInfo.resource.subtitle')?></span>
							</td>
						</tr>
								<input type="hidden" name="fileField"/>
								<input type="hidden" name="SectionID" value="<?=$out['DB']['ResourceCategory'][0]['ResourceID']?>">
					
					<tr>
						<td class="subtitle" valign="top"><?=lang('ResourceCategory.ResourceCategoryIcon')?></td>
						<td align="left" valign="top">
							<? $fieldName = 'ResourceCategoryIcon';  echo getFormated($out['DB']['ResourceCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="#" onClick="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
						</td>
					</tr>
					<tr>
						<td class="subtitle" valign="top"><?=lang('ResourceCategory.ResourceCategoryImagePreview')?></td>
						<td align="left" valign="top">
							<? $fieldName = 'ResourceCategoryImagePreview';  echo getFormated($out['DB']['ResourceCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="#" onClick="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
						</td>
					</tr>
					<tr>
						<td class="subtitle" valign="top"><?=lang('ResourceCategory.ResourceCategoryImage')?></td>
						<td align="left" valign="top">
							<? $fieldName = 'ResourceCategoryImage';  echo getFormated($out['DB']['ResourceCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="#" onClick="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
						</td>
					</tr>
					<tr>
						<td class="subtitle" valign="top"><?=lang('ResourceCategory.ResourceCategoryImageTitle')?></td>
						<td align="left" valign="top">
							<? $fieldName = 'ResourceCategoryImageTitle'; echo getFormated($out['DB']['ResourceCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langMode'=>'Y','deleteLink'=>'<a href="#" onClick="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
						</td>
					</tr>
						<tr>
							<td class="subtitle" valign="top"><?=lang('ResourceCategory.ResourceCategoryImageButton')?></td>
							<td>
								<? $fieldName = 'ResourceCategoryImageButton';  echo getFormated($out['DB']['ResourceCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langMode'=>'Y','deleteLink'=>'<a href="#" onClick="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
							</td>
						</tr>							
						<tr>
							<td class="subtitle" valign="top"><?=lang('ResourceCategory.ResourceCategoryImageButtonHover')?></td>
							<td>
								<? $fieldName = 'ResourceCategoryImageButtonHover';  echo getFormated($out['DB']['ResourceCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langMode'=>'Y','deleteLink'=>'<a href="#" onClick="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
							</td>
						</tr>													
						<tr>
							<td class="subtitle" valign="top"><?=lang('ResourceCategory.ResourceCategoryImageButtonCurrent')?></td>
							<td>
								<? $fieldName = 'ResourceCategoryImageButtonCurrent';  echo getFormated($out['DB']['ResourceCategory'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langMode'=>'Y','deleteLink'=>'<a href="#" onClick="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
							</td>
						</tr>
					<tr>
					<TD colspan="2" align="center" bgcolor="#efefef">
						<span class="subtitle"><?=lang('ResourceCategoryOptions.resource.subtitle')?></span>
					</TD>
					</tr>
					<tr>
						<TD class="subtitle" valign="top">
							<?=lang('Category.CategoryViewOptions')?>
						</TD>
						<td>
							<?=getReference('Section.SectionViewOptions','ResourceCategory'.DTR.'ResourceCategoryViewOptions',$out['DB']['ResourceCategory'][0]['ResourceCategoryViewOptions'],array('code'=>'Y'))?>
						</td>
					</tr>
					<tr>
						<td class="subtitle" valign="top"><?=lang('ResourceCategory.ResouceCategoryActionOptions')?></td>
						<td><?=getReference('Section.SectionActionOptions','ResourceCategory'.DTR.'ResouceCategoryActionOptions',$out['DB']['ResourceCategory'][0]['ResouceCategoryActionOptions'],array('code'=>'Y'))?></td>
					</tr>
					<tr>
						<td class="subtitle" valign="top"><?=lang('ResourceCategory.ResourceCategoryCommentsOptions')?></td>
						<td><?=getReference('Section.SectionCommentsOptions','ResourceCategory'.DTR.'ResourceCategoryCommentsOptions',$out['DB']['ResourceCategory'][0]['ResourceCategoryCommentsOptions'],array('code'=>'Y'))?></td>
					</tr>
					<tr>
						<td align="left" valign="top">
							<span class="subtitle"><?=lang('ResourceCategory.ResourceCategoryHiddenPlaces')?>:</span>
						</td>
						<td align="left" valign="top">
							<?=getReference('ResourceCategory.ResourceCategoryHiddenPlaces','ResourceCategory'.DTR.'ResourceCategoryHiddenPlaces',$out['DB']['ResourceCategory'][0]['ResourceCategoryHiddenPlaces'],array('code'=>'Y'))?>
						</td>
					</tr>
					<tr>
						<TD align="center" colspan="2" bgcolor="#efefef">
							<span class="subtitle"><?=lang('CategoryActivationInfoResourceCategory.subtitle')?></span>
						</TD>
					</tr>
					<tr>
						<td align="left" valign="top">
							<span class="subtitle"><?=lang('ResourceCategory.PermAll')?>: </span><? if(empty($out['DB']['ResourceCategory'][0]['PermAll'])) {$out['DB']['ResourceCategory'][0]['PermAll']=1;} ?>
						</td>
						<td align="left" valign="top">
							<?=getReference('PermAll','ResourceCategory'.DTR.'PermAll',$out['DB']['ResourceCategory'][0]['PermAll'],array('code'=>'Y'))?>
						</td>
						</tr>
					<tr>
					<td align="center" colspan="2">
					<? if(empty($out['DB']['ResourceCategory'][0]['ResourceCategoryID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageResourceCategories.actionMode.value='delete';confirmDelete('manageResourceCategories', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageResourceCategories.actionMode.value='cancell';submit();">
					</td>
					</tr>
					</table>
			</td> 
		</tr> 
	</form>	
	<script language="JavaScript">
			var fromValidator = new Validator("<?=$formName?>");
			<? if(setting('CategoryUseType')!='N') { ?>
			fromValidator.addValidation("ResourceCategory<?=DTR?>ResourceType","req","<?=lang('ResourceType.resource.tip')?>");
			<? } ?>
			//fromValidator.addValidation("ResourceCategory<?=DTR?>ResourceCategoryAlias","req","<?=lang('ResourceCategoryAlias.resource.tip')?>");
			//<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				//fromValidator.addValidation("ResourceCategory<?=DTR?>ResourceCategoryTitle[<?=$langCode?>]","req","<?=lang('ResourceCategoryTitle.resource.tip')?>");
			//<? }?>
	</script>
<?=boxFooter()?>
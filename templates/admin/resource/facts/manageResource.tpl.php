<?
	$resourceTemplate = input('ResourceTemplate');
	$resourceType = $out['DB']['Resource'][0]['ResourceType']; if(empty($resourceType)) {$resourceType=$input['ResourceType'];}
	if(!empty($resourceType)) {$resourceTypeName = getListValue($out['DB']['ResourceTypes'],$resourceType,array('id'=>'ResourceTypeAlias','value'=>'ResourceTypeName'));}
	if(!empty($resourceTypeName)) {$resourceTypeTitle = ' > '.$resourceTypeName;}
	
	$title = lang('AddEditResource.resource.title').$resourceTypeTitle;
	if(input('viewMode')=='next')
	{
		$out['DB']['Resource'][0]['ResourceID']='';
		$out['DB']['Resource'][0]['ResourceTitle']='';
		$out['DB']['Resource'][0]['ResourceAlias']='';
		$out['DB']['Resource'][0]['ResourceIntro']='';
		$out['DB']['Resource'][0]['ResourceContent']='';
		$out['DB']['Resource'][0]['ResourceKeywords']='';
	}
?>
<?=boxHeader(array('title'=>$title))?>
<? $entityID = $out['DB']['Resource'][0]['ResourceID']; $categoryID = input('CategoryID'); ?>
	<? if(!empty($input['ResourceType']) || !empty($out['DB']['Resource'][0]['ResourceType'])) { ?>
	<? /*tr> 
		<td valign=top bgcolor="#ffffff">
			<? $resourceType = $out['DB']['Resource'][0]['ResourceType']; if(empty($resourceType)) {$resourceType=$input['ResourceType'];}?>
			<?=lang('Resource.facts.ResourceType')?>: <b><?=getListValue($out['DB']['ResourceTypes'],$resourceType,array('id'=>'ResourceTypeAlias','value'=>'ResourceTypeName'))?></b>
		</td> 
	</tr*/ ?>
	<? } else { ?>
	<tr> 
	<form name="getResourceTypes" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="Resource<?=DTR?>ResourceID" value="<?=$out['DB']['Resource'][0]['ResourceID']?>">
		<input type="hidden" name="ResourceID" value="<?=$out['DB']['Resource'][0]['ResourceID']?>">
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id']='';	
				$options[0]['value']='- '.lang('ResourceTypeSelect.resource.facts').' -';
				echo getLists($out['DB']['ResourceTypes'],$input['ResourceType'],array('name'=>'ResourceType','id'=>'ResourceTypeAlias','value'=>'ResourceTypeName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
			?>	
		</td> 
	</form>
	</tr> 
	<? } ?>
	<? if(!empty($out['DB']['Resource'][0]['ResourceType']) || !empty($input['ResourceType'])) { 
		$formName = 'manageResources';
	?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="mulfactsart/form-data">
		<input type="hidden" name="SID" value="manageResources" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<? if(empty($out['DB']['Resource'][0]['ResourceID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="Resource<?=DTR?>ResourceID" value="<?=$out['DB']['Resource'][0]['ResourceID']?>">
		<? } ?>		
		<? if(empty($out['DB']['Resource'][0]['ResourceType'])) { ?>
		<input type="hidden" name="Resource<?=DTR?>ResourceType" value="<?=input('ResourceType')?>" />		
		<input type="hidden" name="ResourceType" value="<?=input('ResourceType')?>" />		
		<? } else { ?>
		<input type="hidden" name="Resource<?=DTR?>ResourceType" value="<?=$out['DB']['Resource'][0]['ResourceType']?>">
		<input type="hidden" name="ResourceType" value="<?=$out['DB']['Resource'][0]['ResourceType']?>">
		<? } ?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="4" cellpadding="0">
						<tr>
							<td class="subtitleline" align="center" colspan="2">
								<span class="subtitle"><?=lang('TitleArea.facts.subtitle')?></span>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>
							<input type="hidden" name="Resource<?=DTR?>ResourcePosition" value="<? if(!empty($entityID)){ echo $out['DB']['Resource'][0]['ResourcePosition'];} else { echo input('ResourcePosition');}?>" size="5">					
							<? //lang('Resource.facts.ResourceCategories')?><!-- :<br/> -->
							<? /*
								if(!empty($out['DB']['Resource'][0]['ResourceCategories']))
								{
									$parentID = $out['DB']['Resource'][0]['ResourceCategories'];
								}
								else
								{
									$parentID = '|'.$categoryID.'|';
								}								
								echo getLists($out['DB']['ResourceCategories'],$parentID,array('name'=>'Resource'.DTR.'ResourceCategories','attributes'=>'size="10"','type'=>'mulfactsle','style'=>'width:500px;'));	
							*/?>
							<span class="subtitle"><?=lang('Resource.facts.ResourceAlias')?></span>
							</td>
							<td>
								<input type="text" name="Resource<?=DTR?>ResourceAlias" value="<?=$out['DB']['Resource'][0]['ResourceAlias'];?>" size="70" id="ResourceAlias" onMouseDown="convertToAlias('ResourceTitle_en','ResourceAlias')" />
							</td>
						</tr>										
						<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
						<tr>
							<td>
								<span class="subtitle"><?=lang('Resource.facts.ResourceTitle')?></span>
								<? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
							</td>
							<td>
								<input type="text" name="Resource<?=DTR?>ResourceTitle[<?=$langCode?>]" id="ResourceTitle_<?=$langCode?>" size="70" value="<?=getValue($out['DB']['Resource'][0]['ResourceTitle'],$langCode);?>">
							</td>
						</tr>	
						<? } ?>	
						<tr>
							<td>
								<span class="subtitle"><?=lang('Resource.facts.ResourceAuthor')?></span>
							</td>
							<td>
								<input type="text" name="Resource<?=DTR?>ResourceAuthor" value="<?=$out['DB']['Resource'][0]['ResourceAuthor'];?>" size="70">
							</td>
						</tr>
						<tr>
							<td>
								<span class="subtitle"><?=lang('Resource.facts.ResourceLink')?></span>
							</td>
							<td>
								<input type="text" name="Resource<?=DTR?>ResourceLink" value="<?=$out['DB']['Resource'][0]['ResourceLink'];?>" size="70">
							</td>
						</tr>									
						<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
							<tr>
								<td valign="top">
									<span class="subtitle"><?=lang('Resource.facts.ResourceIntro')?></span> 
									<? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
								</td>
								<td>
									<textarea name="Resource<?=DTR?>ResourceIntro[<?=$langCode?>]" cols="60" rows="5"><?=getValue($out['DB']['Resource'][0]['ResourceIntro'],$langCode);?></textarea>
								</td>
							</tr>	
						<? } ?>	
						<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
							<tr>
								<td valign="top">
									<span class="subtitle"><?=lang('Resource.facts.ResourceContent')?></span> 
									<? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
								</td>
								<td>
									<?=getFormated(getValue($out['DB']['Resource'][0]['ResourceContent'],$langCode),'HTML','form',array('fieldName'=>'Resource'.DTR.'ResourceContent['.$langCode.']','editorName'=>'ResourceContent'.$langCode,'editorWidth'=>550,'editorHeight'=>400,'editorToolbar'=>'Default'))?>
								</td>
							</tr>
						<? } ?>	
						<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
							<tr>
								<td valign="top">
									<span class="subtitle"><?=lang('Resource.facts.ResourceKeywords')?></span>
									<? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
								</td>
								<td>
									<textarea name="Resource<?=DTR?>ResourceKeywords[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['Resource'][0]['ResourceKeywords'],$langCode);?></textarea>
								</td>
							</tr>
						<? } ?>															
						<tr>
							<td class="subtitleline" align="center" colspan="2">
								<span class="subtitle"><?=lang('ImagesArea.resource.subtitle')?></span>

							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<input type="hidden" name="fileField"/>
								<input type="hidden" name="ResourceID" value="<?=$out['DB']['Resource'][0]['ResourceID']?>">
								<? $fieldName = 'ResourceIcon';  echo getFormated($out['DB']['Resource'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Resource.'.$resourceTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<? $fieldName = 'ResourceImagePreview';  echo getFormated($out['DB']['Resource'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Resource.'.$resourceTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
							</td>
						</tr>
						<tr>
							<td>&nbsp;</td>
							<td>
								<? $fieldName = 'ResourceImage';  echo getFormated($out['DB']['Resource'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Resource.'.$resourceTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
							</td>
						</tr>
						<tr>
							<td class="subtitleline" colspan="2" align="center">
								<span class="subtitle"><?=lang('ExtraFieldsArea.resource.subtitle')?></span>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<? if(count($out['DB']['ResourceField'])>0) {?>
							<tr>
								<td>
									<?=lang('ResourceExtraFieldsList.resource.facts')?>:<a href="<?=setting('url')?>manageResourceTypes/ResourceType/<?=input('ResourceType')?>" target="_blank">[<?=lang('EditResourceExtraFields.resource.link')?>]</a>
								</td>
								<td>
									<?=showExtraFieldsForm($out)?>
								</td>
							</tr>
							<tr>
								<td>
									<?=lang('ResourceOptionsList.resource.facts')?>:<a href="<?=setting('url')?>manageResourceTypes/ResourceType/<?=input('ResourceType')?>" target="_blank">[<?=lang('EditResourceExtraOptions.resource.link')?>]</a>
								</td>
								<td>
									<?=showExtraOptionsForm($out)?>
								</td>
							</tr>		
						<?  } ?>
							<tr>
								<td>
									<span class="subtitle"><?=lang('Resource.facts.ResourcePaidRate')?></span>
								</td>
								<td>
									<?=getReference('Resource.ResourcePaidRate','Resource'.DTR.'ResourcePaidRate',$out['DB']['Resource'][0]['ResourcePaidRate'],array('code'=>'Y'))?>
								</td>
							</tr>		
							<tr>
								<td>
									<span class="subtitle"><?=lang('Resource.facts.ResourceReviewsRate')?></span>
								</td>
								<td>
									<?=getReference('Resource.ResourceReviewsRate','Resource'.DTR.'ResourceReviewsRate',$out['DB']['Resource'][0]['ResourceReviewsRate'],array('code'=>'Y'))?>
								</td>
							</tr>
							<tr>
								<td valign="top">
									<span class="subtitle"><?=lang('Resource.facts.ResourceFeaturedOptions')?></span>
								</td>
								<td>
									<?=getReference('Resource.ResourceFeaturedOptions','Resource'.DTR.'ResourceFeaturedOptions',$out['DB']['Resource'][0]['ResourceFeaturedOptions'],array('code'=>'Y'))?>
								</td>
							</tr>
							<? if(count($out['DB']['Languages']['languageNames'])>1) { ?>
								<tr>
									<td valign="top">
										<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceLanguages')?></span>
									</td>
									<td>
										<?
											foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)
											{
												$languagesList[$langID]['id']=$languagesList['languageCodes'][$langID];	
												$languagesList[$langID]['value']=$langName;		
											}								
											echo getLists($languagesList,$out['DB']['Resource'][0]['ResourceLanguages'],array('name'=>'Resource'.DTR.'ResourceLanguages','type'=>'checkboxes','delimiter'=>' '));	
										?>	
									</td>
								</tr>														
							<? } ?>
							<tr>
								<td valign="top">
									<span class="subtitle"><?=lang('Resource.ResourceComments')?></span>
								</td>
								<td>
									<textarea cols="50" rows="7" name="Resource<?=DTR?>ResourceComments"><?=$out['DB']['Resource'][0]['ResourceComments']?></textarea>
								</td>
							</tr>		
							<tr>
								<td class="subtitleline" colspan="2" align="center">
									<span class="subtitle"><?=lang('StatusesArea.resource.subtitle')?></span>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td>
									<span class="subtitle"><?=lang('Resource.facts.ResourceStatus')?></span>
								</td>
								<td>
									<? if(empty($out['DB']['Resource'][0]['ResourceStatus'])) { $out['DB']['Resource'][0]['ResourceStatus'] = 'active';} ?>
									<?=getReference('Resource.ResourceStatus','Resource'.DTR.'ResourceStatus',$out['DB']['Resource'][0]['ResourceStatus'],array('code'=>'Y'))?>
								</td>
							</tr>
							<tr>
								<td>
									<span class="subtitle"><?=lang('Resource.facts.PermAll')?></span>
								</td>
								<td>
									<? if(empty($out['DB']['Resource'][0]['PermAll'])) {$out['DB']['Resource'][0]['PermAll']=1;} ?>
									<?=getReference('PermAll','Resource'.DTR.'PermAll',$out['DB']['Resource'][0]['PermAll'],array('code'=>'Y'))?>
								</td>
							</tr>
							<tr><td>&nbsp;</td></tr>
							<tr>
								<td colspan="2" class="subtitleline" align="center" >
									<? if(empty($out['DB']['Resource'][0]['ResourceID'])) { ?>
									<input type="submit" value="<?=lang("-add")?>">
									<? } else { ?>
									<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageResources.actionMode.value='delete';confirmDelete('manageResources', '<?=lang("-deleteconfirmation")?>');">
									<? } ?>					
									&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageResources.actionMode.value='cancell';submit();">
								</td>
							</tr>
				</table>	
			</td> 
		</tr> 
	</form>	
	<script language="JavaScript">
			var fromValidator = new Validator("manageResources");
			//fromValidator.addValidation("Resource<?=DTR?>ResourceAlias","req","<?=lang('ResourceCategoryAlias.products.facts')?>");
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				fromValidator.addValidation("Resource<?=DTR?>ResourceTitle[<?=$langCode?>]","req","<?=lang('ResourceTitle.products.facts')?>");
			<? }?>
	</script>
	<? } ?>
<?=boxFooter()?>
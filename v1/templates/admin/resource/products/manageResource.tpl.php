<? if($input['actionMode']=='add' || $input['actionMode']=='save1')  { ?>
	<script language="javascript">
		window.document.onLoad= setTimeout("goback('<?= setting('url')?>manageResources/CategoryID/<?=$input[Resource.DTR.ResourceCategories][0]?>')");
	</script>
  <? }else{?>
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
		$out['DB']['Resource'][0]['ResourceIcon'] = '';
		$out['DB']['Resource'][0]['ResourceImagePreview'] = '';
		$out['DB']['Resource'][0]['ResourceImage'] = '';
	}
?>  
<?=boxHeader(array('title'=>$title))?>
<? $entityID = $out['DB']['Resource'][0]['ResourceID']; $categoryID = input('CategoryID'); ?>
	<? if(!empty($input['ResourceType']) || !empty($out['DB']['Resource'][0]['ResourceType'])) { ?>
	<? /* tr> 
		<td valign=top bgcolor="#ffffff">
			<? $resourceType = $out['DB']['Resource'][0]['ResourceType']; if(empty($resourceType)) {$resourceType=$input['ResourceType'];}?>
			<?=lang('Resource.'.$resourceTemplate.'.ResourceType')?>: <b><?=getListValue($out['DB']['ResourceTypes'],$resourceType,array('id'=>'ResourceTypeAlias','value'=>'ResourceTypeName'))?></b>
		</td> 
	</tr */ ?>
	<? } else { ?>
	<tr> 
	<form name="getResourceTypes" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="Resource<?=DTR?>ResourceID" value="<?=$out['DB']['Resource'][0]['ResourceID']?>">
		<input type="hidden" name="ResourceID" value="<?=$out['DB']['Resource'][0]['ResourceID']?>">
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="page" value="<?=input('page')?>" />
		<input type="hidden" name="next" value="<?=input('next')?>" />
		
		<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id']='';	
				$options[0]['value']='- '.lang('ResourceTypeSelect.resource.tip').' -';
				echo getLists($out['DB']['ResourceTypes'],$input['ResourceType'],array('name'=>'ResourceType','id'=>'ResourceTypeAlias','value'=>'ResourceTypeName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
			?>	
		</td> 
	</form>
	</tr> 
	<? } ?>
	<? if(!empty($out['DB']['Resource'][0]['ResourceType']) || !empty($input['ResourceType'])) { 
	$formName = 'manageResources';
	?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageResources" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="ResourceType" value="<?=input('ResourceType')?>" />	
		<input type="hidden" name="viewMode" />
		<? if(empty($out['DB']['Resource'][0]['ResourceID'])) { ?>
		<input type="hidden" name="actionMode" value="add1" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="Resource<?=DTR?>ResourceID" value="<?=$out['DB']['Resource'][0]['ResourceID']?>">
		<? } ?>		
		<? if(empty($out['DB']['Resource'][0]['ResourceType'])) { ?>
		<input type="hidden" name="Resource<?=DTR?>ResourceType" value="<?=input('ResourceType')?>" />		
		<? } else { ?>
		<input type="hidden" name="Resource<?=DTR?>ResourceType" value="<?=$out['DB']['Resource'][0]['ResourceType']?>">
		<? } ?>			
		<input type="hidden" name="page" value="<?=input('page')?>" />
		<input type="hidden" name="next" value="<?=input('next')?>" />
		
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="4" width="100%">
					<tr>
						<td align="center" class="subtitleline" colspan="2">
							<span class="subtitle"><?=lang('CategoriesArea.resource.subtitle')?></span>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td valign="top" valign="top">
							<input type="hidden" name="Resource<?=DTR?>ResourcePosition" value="<? if(!empty($entityID)){ echo $out['DB']['Resource'][0]['ResourcePosition'];} else { echo input('ResourcePosition');}?>" size="5">					
							<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceCategories')?></span>
						</td>
						<td>
							<?
								if(!empty($out['DB']['Resource'][0]['ResourceCategories']))
								{
									$parentID = $out['DB']['Resource'][0]['ResourceCategories'];
								}
								else
								{
									$parentID = '|'.$categoryID.'|';
								}								
								if(setting('ResourceCategoriesMode')=='one') {$typeOFCats='multipledropdown'; $catsSelectorSize='';} else {$typeOFCats='multiple'; $catsSelectorSize='size="10"';}
								echo getLists($out['DB']['ResourceCategories'],$parentID,array('name'=>'Resource'.DTR.'ResourceCategories','attributes'=>$catsSelectorSize,'type'=>$typeOFCats,'style'=>'width:500px;'));	
							?>
						</td>
					</tr>	
					<?=/*lang('Resource.'.$resourceTemplate.'.ResourceLocation')?><!-- :<br/> -->
					<?=setInput('CountryID','118'); ?>
					<? 
						$params['currentValue'] = $out['DB']['Resource'][0]['ResourceLocationID'];
						$params['fieldName'] = 'Resource'.DTR.'ResourceLocationID';
						$params['id'] = 'id';
						getBox('core.getRegionsDropDwon',array("params"=>$params)); 
					*/
					?>
					<? //=getReference('Resource.ResourceLocation','Resource'.DTR.'ResourceLocation',$out['DB']['Resource'][0]['ResourceLocation'],array('code'=>'Y'))?>
					<? if(eregi("political",setting('resourceFieldsOptions'))){?>
					<tr>
						<td class="subtitle" valign="top">
							<?=lang('Resource.'.$resourceTemplate.'.ResourceLocation')?>
						</td>
						<td align="left">
						<?
							if(!empty($out['DB']['RegionsList'])) 
							{	
								$listArray = $out['DB']['RegionsList'];
								$valueName = 'value';
								if(empty($id)) {$id='code';}
							} 
							echo getLists($listArray,$out['DB']['Resource'][0]['ResourceLocation'],array('name'=>'Resource'.DTR.'ResourceLocation','id'=>$id,'value'=>$valueName,'options'=>$options,'style'=>'width:200px'));
						?>
						</td>
					</tr>	
					<? }?>
					<? if(eregi("geographical",setting('resourceFieldsOptions'))){?>
					<tr>
						<td class="subtitle" valign="top">
							<?=lang('Resource.'.$resourceTemplate.'.ResourceLocationGeo')?>
						</td>
						<td align="left">
							<?
								if(!empty($out['DB']['RegionsGeoList'])) 
								{	
									$listArray = $out['DB']['RegionsGeoList'];
									$valueName = 'value';
									if(empty($id)) {$id='code';}
								} 
								echo getLists($listArray,$out['DB']['Resource'][0]['ResourceLocationGeo'],array('name'=>'Resource'.DTR.'ResourceLocationGeo','id'=>$id,'value'=>$valueName,'options'=>$options,'style'=>'width:200px'));
							?>
						</td>
					</tr>
					<? }?>
					<tr>
						<td class="subtitleline" align="center" colspan="2">
							<span class="subtitle"><?=lang('TitleArea.resource.subtitle')?></span>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td>
							<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceAlias')?></span>
						</td>
						<td>
							<input type="text" name="Resource<?=DTR?>ResourceAlias" value="<?=$out['DB']['Resource'][0]['ResourceAlias'];?>" size="35">
						</td>
					</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td>
							<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceTitle')?></span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
						</td>
						<td>
							<input type="text" name="Resource<?=DTR?>ResourceTitle[<?=$langCode?>]" size="35" value="<?=getValue($out['DB']['Resource'][0]['ResourceTitle'],$langCode);?>">
						</td>
					</tr>	
					<? } ?>	
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top">
							<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceIntro')?></span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
						</td>
						<td>
							<? if(eregi("editor",setting('resourceFieldsOptions'))){?>
								<?=getFormated(getValue($out['DB']['Resource'][0]['ResourceIntro'],$langCode),'HTML','form',array('fieldName'=>'Resource'.DTR.'ResourceIntro['.$langCode.']','editorName'=>'ResourceIntro'.$langCode,'editorWidth'=>550,'editorHeight'=>400,'editorToolbar'=>'Default'))?>
							<? }else{?>
								<textarea name="Resource<?=DTR?>ResourceIntro[<?=$langCode?>]" cols="35" rows="5"><?=getValue($out['DB']['Resource'][0]['ResourceIntro'],$langCode);?></textarea>
							<? }?>
						</td>
					</tr>
					<? } ?>	
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top">
							<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceContent')?></span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
						</td>
						<td>
							<? if(eregi("editor",setting('resourceFieldsOptions'))){?>
								<?=getFormated(getValue($out['DB']['Resource'][0]['ResourceContent'],$langCode),'HTML','form',array('fieldName'=>'Resource'.DTR.'ResourceContent['.$langCode.']','editorName'=>'ResourceContent'.$langCode,'editorWidth'=>550,'editorHeight'=>400,'editorToolbar'=>'Default'))?>
							<? }else{?>
								<textarea name="Resource<?=DTR?>ResourceContent[<?=$langCode?>]" cols="60" rows="10"><?=getValue($out['DB']['Resource'][0]['ResourceContent'],$langCode);?></textarea>
							<? }?>
						</td>
					</tr>
					<? } ?>	
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td valign="top">
							<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceKeywords')?></span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
						</td>
						<td>
							<textarea name="Resource<?=DTR?>ResourceKeywords[<?=$langCode?>]" cols="35" rows="5"><?=getValue($out['DB']['Resource'][0]['ResourceKeywords'],$langCode);?></textarea>
						</td>
					</tr>	
					<? } ?>															
					<? /*
					<br/>					
					<?=lang('Resource.'.$resourceTemplate.'.ResourceLink')?>:<br/>
					<input type="text" name="Resource<?=DTR?>ResourceLink" value="<?=$out['DB']['Resource'][0]['ResourceLink'];?>" size="30">
					<br>
					<hr size="1">
					*/ ?>
					<tr>
						<td>
							<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourcePrice')?></span>
						</td>
						<td>
							<?=getFormated($out['DB']['Resource'][0]['ResourcePrice'],'Money','form',array('fieldName'=>'Resource'.DTR.'ResourcePrice'))?>
						</td>
					</tr>
					<tr>
						<td>
							<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceWeight')?></span>
						</td>
						<td>
							<?=getFormated($out['DB']['Resource'][0]['ResourceWeight'],'Weight','form',array('fieldName'=>'Resource'.DTR.'ResourceWeight'))?>
						</td>
					</tr>
					<tr>
						<td class="subtitleline" align="center" colspan="2">
							<span class="subtitle"><?=lang('ImagesArea.resource.subtitle')?></span>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td class="subtitle" valign="top"><?=lang('Resource.'.$resourceTemplate.'.ResourceIcon')?></td>
						<td>
							<input type="hidden" name="fileField"/>
							<input type="hidden" name="ResourceID" value="<?=$out['DB']['Resource'][0]['ResourceID']?>">
							<? $fieldName = 'ResourceIcon';  echo getFormated($out['DB']['Resource'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
						</td>
					</tr>
					<tr>
						<td class="subtitle" valign="top"><?=lang('Resource.'.$resourceTemplate.'.ResourceImagePreview')?></td>
						<td>
							<? $fieldName = 'ResourceImagePreview';  echo getFormated($out['DB']['Resource'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
						</td>
					</tr>			
					<tr>
						<td class="subtitle" valign="top"><?=lang('Resource.'.$resourceTemplate.'.ResourceImage')?></td>
						<td>
							<? $fieldName = 'ResourceImage';  echo getFormated($out['DB']['Resource'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
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
							<span class="subtitle"><?=lang('ResourceExtraFieldsList.resource.tip')?>:</span>&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceTypes/ResourceType/<?=input('ResourceType')?>" target="_blank">[<?=lang('EditResourceExtraFields.resource.link')?>]</a><br/><br/>
						</td>
						<td>
							<?=showExtraFieldsForm($out)?>
						</td>
					</tr>
					<tr>
						<td>
							<span class="subtitle"><?=lang('ResourceOptionsList.resource.tip')?>:</span>&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceTypes/ResourceType/<?=input('ResourceType')?>" target="_blank">[<?=lang('EditResourceExtraOptions.resource.link')?>]</a><br/><br/>
						</td>
						<td>
							<?=showExtraOptionsForm($out)?>
						</td>
					</tr>
					<?  } ?>	
					<tr>
						<td valign="top">
							<span class="subtitle"><?=lang('Resource.tip.ResourceFeaturedOptions')?></span>
						</td>
						<td>
							<?=getReference('Resource.ResourceFeaturedOptions','Resource'.DTR.'ResourceFeaturedOptions',$out['DB']['Resource'][0]['ResourceFeaturedOptions'],array('code'=>'Y'))?>
						</td>
					</tr>			
					<? if(!empty($out['DB']['Resource'][0]['ResourceID'])) { ?>	
					<tr>
						<td>
							<?=lang('RelatedResourceList.resource.tip')?>
							<br/><br/>
							<a href="<?=setting('url')?>addRelatedResource/ResourceID/<?=$out['DB']['Resource'][0]['ResourceID']?>/CategoryID/<?=input('CategoryID')?>/ResourceType/<?=input('ResourceType')?>/"><?=lang('AddRelatedResource.resource.link')?></a>
							<br/><br/>
						</td>
					</tr>
						<? if(is_array($out['DB']['ResourceRelations'])) { ?>
							<? foreach($out['DB']['ResourceRelations'] as $relatedRow) {?>
								<tr>
									<td>
										<?=getValue($relatedRow['ResourceTitle'])?>
									</td>
									<td>
										<a href="<?=setting('url').input('SID')?>/actionMode/deleterelated/ResourceRelation<?=DTR?>ResourceRelationID/<?=$relatedRow['ResourceRelationID']?>/ResourceID/<?=$out['DB']['Resource'][0]['ResourceID']?>/CategoryID/<?=input('CategoryID')?>/ResourceType/<?=input('ResourceType')?>">[<?=lang('DeleteRelatedResource.resource.link')?>]</a>
									</td>
								</tr>
							<? } ?>
						<? } ?>
					<? } ?>							
					
					<? if(count($out['DB']['Languages']['languageNames'])>1) { ?>
						<tr>
							<td class="subtitle">
								<?=lang('Resource.'.$resourceTemplate.'.ResourceLanguages')?>
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
					<? /*span class="subtitle"><?=lang('Resource.ResourceStatus')?>:</span><br/>
					<? if(empty($out['DB']['Resource'][0]['ResourceStatus'])) { $out['DB']['Resource'][0]['ResourceStatus'] = 'active';} ?>
					<?=getReference('Resource.ResourceStatus','Resource'.DTR.'ResourceStatus',$out['DB']['Resource'][0]['ResourceStatus'],array('code'=>'Y'))?>
					<br/><br/ */?>
					<tr><td width="100%" colspan="2">&nbsp;</td></tr>
					<tr>
						<td class="subtitleline" colspan="2" align="center">
							<span class="subtitle"><?=lang('StatusesArea.resource.subtitle')?></span>
						</td>
					</tr>
					<tr><td>&nbsp;</td></tr>
					<tr>
						<td class="subtitle">
							<?=lang('Resource.PermAll')?>
						</td>
						<td>
							<? if(empty($out['DB']['Resource'][0]['PermAll'])) {$out['DB']['Resource'][0]['PermAll']=1;} ?>
							<?=getReference('PermAll','Resource'.DTR.'PermAll',$out['DB']['Resource'][0]['PermAll'],array('code'=>'Y'))?>
						</td>
					</tr>
					<tr><td width="100%" colspan="2">&nbsp;</td></tr>
					<tr>
						<td class="subtitleline" colspan="2" align="center">
							<? if(empty($out['DB']['Resource'][0]['ResourceID'])) { ?>
							<input type="submit" value="<?=lang("-addquit")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-addnext")?>" onClick="document.<?=$formName?>.viewMode.value='next';document.<?=$formName?>.SID.value='<?=input('SID')?>';submit();">
							<? } else { ?>
							<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.<?=$formName?>.actionMode.value='delete';confirmDelete('<?=$formName?>', '<?=lang("-deleteconfirmation")?>');">
							<? } ?>					
							&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.<?=$formName?>.actionMode.value='cancell';submit();">
							<br/>
						</td>
					</tr>
				</table>
			</td> 
		</tr> 
	</form>	
	<script language="JavaScript">
			var fromValidator = new Validator("<?=$formName?>");
			fromValidator.addValidation("Resource<?=DTR?>ResourceCategories[]","req","<?=lang('ResourceCategories.'.$resourceTemplate.'.tip')?>");
			//fromValidator.addValidation("Resource<?=DTR?>ResourceAlias","req","<?=lang('ResourceCategoryAlias.'.$resourceTemplate.'.tip')?>");
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				fromValidator.addValidation("Resource<?=DTR?>ResourceTitle[<?=$langCode?>]","req","<?=lang('ResourceTitle.'.$resourceTemplate.'.tip')?>");
			<? }?>
	</script>		
	<? } ?>
<?=boxFooter()?>
<? }?>

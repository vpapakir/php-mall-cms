<?
$formName = 'ownerSitemap';
	if(!empty($out['DB']['Section'][0]['SectionLink']) || input('sectionContentType')=='link')
	{ 
	
	$formName = 'ownerSitemap';
	$sectionContentType = input('sectionContentType');
	if(empty($sectionContentType)) {$sectionContentType='link';}
	
	?>


<?=boxHeader(array('title'=>'EditOwnerSection.core.title'))?>
<? $entityID = $out['DB']['Section'][0]['SectionID']; $viewMode = input('viewMode');  ?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="ownerSitemap" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="tabLink" value="<?=input('tabLink')?>" />
		<? if(empty($out['DB']['Section'][0]['SectionID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="SectionID" value="<?=$out['DB']['Section'][0]['SectionID']?>" />
		<input type="hidden" name="Section<?=DTR?>SectionID" value="<?=$out['DB']['Section'][0]['SectionID']?>">
		<? } ?>	
		<input type="hidden" name="Section<?=DTR?>SectionPosition" value="<? if(!empty($entityID)){ echo $out['DB']['Section'][0]['SectionPosition'];} else { echo input('SectionPosition');}?>" size="5">					
		<input type="hidden" name="viewMode" value="<?=input('viewMode')?>" >
		<input type="hidden" name="afterSaveAction" value="<?=input('afterSaveAction')?>" >
		
		<? if(empty($out['DB']['Section'][0]['SectionGroupID'])) {$out['DB']['Section'][0]['SectionGroupID']=input('RequestedGroupID');} ?>
		<input type="hidden" name="Section<?=DTR?>SectionGroupID" value="<?=$out['DB']['Section'][0]['SectionGroupID']?>">
				<input type="hidden" name="Section<?=DTR?>SectionLayout" value="main" >
		<? if(empty($out['DB']['Section'][0]['SectionBox'])) {$out['DB']['Section'][0]['SectionBox']='core.page';} ?>
		<input type="hidden" name="Section<?=DTR?>SectionBox" value="<?=$out['DB']['Section'][0]['SectionBox']?>" />
		<? if(empty($out['DB']['Section'][0]['SectionType'])) {$out['DB']['Section'][0]['SectionType']='front';} ?>
		<input type="hidden" name="Section<?=DTR?>SectionType" value="<?=$out['DB']['Section'][0]['SectionType']?>" />
		<input type="hidden" name="Section<?=DTR?>AccessGroups" value=" " />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="4" width="100%">
						<tr>
							<td width="20%"></td>
							<td width="80%"></td>
						</tr>
						<tr>
							<td align="center" class="subtitleline" colspan="2">
								<span class="subtitle"><?=lang('PageMainInfo.core.subtitle')?></span>
							</td>
						</tr>
						<tr>
							<td class="subtitle" valign="top"><?=lang('PageType.core.tip')?></td>
							<td>
								<?
									$linkTypeOptions[0]['id']='page';	
									$linkTypeOptions[0]['value']=lang('PageTypePage.core.option');
									$linkTypeOptions[1]['id']='link';
									$linkTypeOptions[1]['value']=lang('PageTypeLink.core.option');
									echo getLists($linkTypeOptions,$sectionContentType,array('name'=>'sectionContentType','action'=>'document.manageSections.SID.value=\'manageSection\';submit();'));	
									$options='';
								?>								
							</td>
						</tr>	
						<tr>
							<td class="subtitle"><?=lang('Section.SectionParentID')?></td>
							<td><?=$out['Refs']['SectionParentID']?></td>
						</tr>
						<tr>
							<td class="subtitle"><?=lang('Section.SectionLink')?> <?=lang('Section.SectionLink.helptip')?></td>
							<td><input type="text" name="Section<?=DTR?>SectionLink" value="<?=$out['DB']['Section'][0]['SectionLink'];?>" size="80"></td>
						</tr>		
						<? if(!stristr($out['DB']['Section'][0]['SectionLink'],'http://')) { ?>														
						<tr>
							<?
								$pageSID = $out['DB']['Section'][0]['SectionLink'];
							?>
							<td class="subtitle"><?=lang('EditPageContent.core.tip')?></td>
							<td><a href="<?=setting('url')?>manageSection/SectionAlias/<?=$pageSID?>/">[<?=lang('EditPageContent.core.link')?>]</a></td>
						</tr>
						<? } ?>
						<? /* tr>
							<td class="subtitle" valign="top"><?=lang('Section.SectionLanguages')?></td>
							<td><?=$out['Refs']['SectionLanguages']?></td>
						</tr */ ?>
						<tr>
							<td class="subtitle" valign="top"><?=lang('Section.SectionName')?></td>
							<td>							
								<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
									<br/>
									<input type="text" name="Section<?=DTR?>SectionName[<?=$langCode?>]" size="80" value="<?=getValue($out['DB']['Section'][0]['SectionName'],$langCode);?>">
									<br/>
								<? } ?>
							</td>
						</tr>						
						<? /*tr>
							<td class="subtitle"><?=lang('Section.SectionAlias')?></td>
							<td><input type="text" name="Section<?=DTR?>SectionAlias" value="<?=$out['DB']['Section'][0]['SectionAlias'];?>" size="35"></td>
						</tr>
						<tr>
							<td class="subtitle" valign="top"><?=lang('Section.AccessGroups')?></td>
							<td>
								<?
									$options[0]['id']='all';	
									$options[0]['value']=lang('-allgroups');
									$options[1]['id']='hideforloggedin';
									$options[1]['value']=lang('SectionHideFromLogedInUsers.core.tip');
									echo getLists($out['DB']['UserGroups'],$out['DB']['Section'][0]['AccessGroups'],array('name'=>'Section'.DTR.'AccessGroups','id'=>'GroupID','value'=>'GroupName','type'=>'checkboxes','options'=>$options));	
									$options='';
								?>								
							</td>
						</tr >	
						<tr>
							<td align="center" class="subtitleline" colspan="2">
								<span class="subtitle"><?=lang('PageActivationInfo.core.subtitle')?></span>
							</td>
						</tr>
						<tr>
							<td class="subtitle"><?=lang('Section.SectionIsHiddenInMenu')?></td>
							<? if(empty($out['DB']['Section'][0]['SectionIsHiddenInMenu'])) {$out['DB']['Section'][0]['SectionIsHiddenInMenu']='N';} ?>
							<td><?=getReference('YesNo','Section'.DTR.'SectionIsHiddenInMenu',$out['DB']['Section'][0]['SectionIsHiddenInMenu'],array('code'=>'Y'))?></td>
						</tr */ ?>
						<tr>
							<td class="subtitle"><?=lang('Section.PermAll')?></td>
							<td><?=$out['Refs']['PermAll']?></td>
						</tr>	
					</table>		
					<br/>
					<? if(empty($out['DB']['Section'][0]['SectionID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<?
						if(input('viewMode')=='seo') {$nextView = 'advanced';}
						elseif(input('viewMode')=='advanced') {$nextView = 'design';}
						elseif(input('viewMode')=='design') {$nextView = '';}
						else {$nextView = 'seo';}
					?>
					&nbsp;&nbsp;<input type="submit" value="<?=lang("-save")?>">				
					&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.ownerSitemap.actionMode.value='delete';confirmDelete('manageSections', '<?=lang("-deleteconfirmation")?>');">					
					<? } ?>
					&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.ownerSitemap.actionMode.value='cancell';submit();">
					<br/>
			</td> 
		</tr> 
	</form>
	<? if ($viewMode=='main' || empty($viewMode) ) { ?>
		<script language="JavaScript">
			var fromValidator = new Validator("<?=$formName?>");
			//fromValidator.addValidation("Section<?=DTR?>SectionAlias","req","<?=lang('EmptySectionAlias.core.tip')?>");
			fromValidator.addValidation("Section<?=DTR?>SectionName[<?=setting('lang')?>]","req","<?=lang('EmptySectionName.core.tip')?>");
		</script>
	<? }?>	

		
	<? 
	
	echo boxFooter();
	
	}//if(!empty($out['DB']['Section'][0]['SectionLink']) || input('sectionContentType')=='link')
	else
	{
?>


<?
	if(input('afterSaveAction')=='goToWebsite') { goLink(setting('rooturl').'go/home/frontBackLinkAction/do/'); }
	$formName = 'ownerSitemap';
	$sectionContentType = input('sectionContentType');
	if(empty($sectionContentType)) {$sectionContentType='page';}
	
?>
<? //boxHeader(array('title'=>'ManageSections.core.title','tabs'=>'manageSections','formName'=>$formName,'tabslink'=>'SectionID/'.input('SectionID').'/GroupID/'.input('GroupID')))?>
<?=boxHeader(array('title'=>'EditOwnerSection.core.title'))?>

<? $entityID = $out['DB']['Section'][0]['SectionID']; $viewMode = input('viewMode');  ?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="ownerSitemap" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="tabLink" value="<?=input('tabLink')?>" />
		<? if(empty($out['DB']['Section'][0]['SectionID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="SectionID" value="<?=$out['DB']['Section'][0]['SectionID']?>" />
		<input type="hidden" name="Section<?=DTR?>SectionID" value="<?=$out['DB']['Section'][0]['SectionID']?>">
		<? } ?>	
		<input type="hidden" name="Section<?=DTR?>SectionPosition" value="<? if(!empty($entityID)){ echo $out['DB']['Section'][0]['SectionPosition'];} else { echo input('SectionPosition');}?>" size="5">					
		<input type="hidden" name="viewMode" value="<?=input('viewMode')?>" >
		<input type="hidden" name="afterSaveAction" value="<?=input('afterSaveAction')?>" >
		

		<? if(empty($out['DB']['Section'][0]['SectionGroupID'])) {$out['DB']['Section'][0]['SectionGroupID']=input('RequestedGroupID');} ?>
		<input type="hidden" name="Section<?=DTR?>SectionGroupID" value="<?=$out['DB']['Section'][0]['SectionGroupID']?>">
		<input type="hidden" name="Section<?=DTR?>SectionLayout" value="main" >
		<? if(empty($out['DB']['Section'][0]['SectionBox'])) {$out['DB']['Section'][0]['SectionBox']='core.page';} ?>
		<input type="hidden" name="Section<?=DTR?>SectionBox" value="<?=$out['DB']['Section'][0]['SectionBox']?>" />
		<? if(empty($out['DB']['Section'][0]['SectionType'])) {$out['DB']['Section'][0]['SectionType']='front';} ?>
		<input type="hidden" name="Section<?=DTR?>SectionType" value="<?=$out['DB']['Section'][0]['SectionType']?>" />
		<input type="hidden" name="Section<?=DTR?>AccessGroups" value=" " />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="4" width="100%">
						<tr>
							<td width="20%"></td>
							<td width="80%"></td>
						</tr>
						<? if ($viewMode=='main' || empty($viewMode) ) { ?>
						<tr>
							<td align="center" class="subtitleline" colspan="2">
								<span class="subtitle"><?=lang('PageMainInfo.core.subtitle')?></span>
							</td>
						</tr>
						<tr>
							<td class="subtitle" valign="top"><?=lang('PageType.core.tip')?></td>
							<td>
								<?
									$linkTypeOptions[0]['id']='page';	
									$linkTypeOptions[0]['value']=lang('PageTypePage.core.option');
									$linkTypeOptions[1]['id']='link';
									$linkTypeOptions[1]['value']=lang('PageTypeLink.core.option');
									echo getLists($linkTypeOptions,$sectionContentType,array('name'=>'sectionContentType','action'=>'document.manageSections.SID.value=\'manageSection\';submit();'));	
									$options='';
								?>								
							</td>
						</tr>						
						<tr>
							<td class="subtitle"><?=lang('Section.SectionParentID')?></td>
							<td><?=$out['Refs']['SectionParentID']?></td>
						</tr>
						<tr>
							<td class="subtitle"><?=lang('Section.SectionAlias')?> <?=lang('Section.SectionAlias.helptip')?></td>
							<td><input type="text" name="Section<?=DTR?>SectionAlias" value="<?=$out['DB']['Section'][0]['SectionAlias'];?>" size="35"></td>
						</tr>
						<tr>
							<td class="subtitle"><?=lang('Section.SectionTarget')?></td>
							<td><?=getReference('target','Section'.DTR.'SectionTarget',$out['DB']['Section'][0]['SectionTarget'],array('code'=>'Y'))?></td>
						</tr>
						<? /* tr>
							<td class="subtitle" valign="top"><?=lang('Section.AccessGroups')?></td>
							<td>
								<?
									$options[0]['id']='all';	
									$options[0]['value']=lang('-allgroups');
									$options[1]['id']='hideforloggedin';
									$options[1]['value']=lang('SectionHideFromLogedInUsers.core.tip');
									echo getLists($out['DB']['UserGroups'],$out['DB']['Section'][0]['AccessGroups'],array('name'=>'Section'.DTR.'AccessGroups','id'=>'GroupID','value'=>'GroupName','type'=>'checkboxes','options'=>$options));	
									$options='';
								?>								
							</td>
						</tr */ ?>	
						<tr>
							<td align="center" class="subtitleline" colspan="2">
								<span class="subtitle"><?=lang('PageContentInfo.core.subtitle')?></span>
							</td>
						</tr>
						<? /*tr>
							<td class="subtitle" valign="top"><?=lang('Section.SectionLanguages')?></td>
							<td><?=$out['Refs']['SectionLanguages']?></td>
						</tr */ ?>
						<tr>
							<td class="subtitle" valign="top"><?=lang('Section.SectionName')?></td>
							<td>							
								<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
									<?=$out['DB']['Languages']['languageNames'][$langID]?>
									<br/>
									<input type="text" name="Section<?=DTR?>SectionName[<?=$langCode?>]" size="80" value="<?=getValue($out['DB']['Section'][0]['SectionName'],$langCode);?>">
									<br/>
								<? } ?>
							</td>
						</tr>	
						<? /*tr>
							<td class="subtitle" valign="top"><?=lang('Section.SectionIntroContent')?></td>
							<td>
								<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
									<? if(count($out['DB']['Languages']['languageCodes']>1)) { ?><?=$out['DB']['Languages']['languageNames'][$langID]?><br/><? } ?>
									<?=getFormated(getValue($out['DB']['Section'][0]['SectionIntroContent'],$langCode),'HTML','form',array('fieldName'=>'Section'.DTR.'SectionIntroContent['.$langCode.']','editorName'=>'SectionIntroContent'.$langCode,'editorHeight'=>200))?>
									<br/>
								<? } ?>								
							</td>
						</tr */ ?>						
						<tr>
							<td class="subtitle" valign="top"><?=lang('Section.SectionContent')?></td>
							<td>
								<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
									<? if(count($out['DB']['Languages']['languageCodes']>1)) { ?><?=$out['DB']['Languages']['languageNames'][$langID]?><br/><? } ?>
									<?=getFormated(getValue($out['DB']['Section'][0]['SectionContent'],$langCode),'HTML','form',array('fieldName'=>'Section'.DTR.'SectionContent['.$langCode.']','editorWidth'=>600,'editorName'=>'SectionContent'.$langCode))?>
									<br/>
								<? } ?>								
							</td>
						</tr>
						<tr>
							<td align="center" class="subtitleline" colspan="2">
								<span class="subtitle"><?=lang('SEOSectionFields.core.tip')?></span>
							</td>
						</tr>
						<tr>
							<td class="subtitle" valign="top"><?=lang('Section.SectionTitle')?></td>
							<td>
								<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
									<? if(count($out['DB']['Languages']['languageCodes']>1)) { ?><?=$out['DB']['Languages']['languageNames'][$langID]?><br/><? } ?>
									<input type="text" name="Section<?=DTR?>SectionTitle[<?=$langCode?>]" size="80" value="<?=getValue($out['DB']['Section'][0]['SectionTitle'],$langCode);?>">
									<br/>
								<? } ?>								
							</td>
						</tr>		
						<tr>
							<td class="subtitle" valign="top"><?=lang('Section.SectionDescription')?></td>
							<td>
								<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
									<? if(count($out['DB']['Languages']['languageCodes']>1)) { ?><?=$out['DB']['Languages']['languageNames'][$langID]?><br/><? } ?>
									<textarea name="Section<?=DTR?>SectionDescription[<?=$langCode?>]" cols="70" rows="5"><?=getValue($out['DB']['Section'][0]['SectionDescription'],$langCode);?></textarea>
									<br/>
								<? } ?>								
							</td>
						</tr>						
						<tr>
							<td class="subtitle" valign="top"><?=lang('Section.SectionKeywords')?></td>
							<td>
								<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
									<? if(count($out['DB']['Languages']['languageCodes']>1)) { ?><?=$out['DB']['Languages']['languageNames'][$langID]?><br/><? } ?>
									<textarea name="Section<?=DTR?>SectionKeywords[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['Section'][0]['SectionKeywords'],$langCode);?></textarea>
									<br/>
								<? } ?>								
							</td>
						</tr>	
						
						<? }//if ($viewMode=='main' || empty($viewMode) ) ?>
						<? if ($viewMode=='seo') { ?>
						<input type="hidden" name="Section<?=DTR?>SectionAlias" value="<?=$out['DB']['Section'][0]['SectionAlias'];?>" size="30">
						<tr>
							<td class="subtitle" valign="top"><?=lang('Section.SectionHidden')?></td>
							<td>
								<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
									<? if(count($out['DB']['Languages']['languageCodes']>1)) { ?><?=$out['DB']['Languages']['languageNames'][$langID]?><br/><? } ?>
									<textarea name="Section<?=DTR?>SectionHidden[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['Section'][0]['SectionHidden'],$langCode);?></textarea>
									<br/>
								<? } ?>								
							</td>
						</tr>										
						<? }//if ($viewMode=='seo') ?>
						<? if ($viewMode=='advanced') { ?>
						<input type="hidden" name="Section<?=DTR?>SectionAlias" value="<?=$out['DB']['Section'][0]['SectionAlias'];?>" size="30">
						<tr>
							<td align="center" class="subtitleline" colspan="2">
								<span class="subtitle"><?=lang('PageAdvancedInfo.core.subtitle')?></span>
							</td>
						</tr>
						<tr>
							<td class="subtitle"><?=lang('Section.SectionType')?></td>
							<td><?=getReference('ViewType','Section'.DTR.'SectionType',$out['DB']['Section'][0]['SectionType'],array('code'=>'Y','action'=>'document.manageSections.SID.value=\'manageSection\';submit();'))?></td>
						</tr>
						<tr>
							<td class="subtitle"><?=lang('Section.SectionBox')?></td>
							<td>
								<?
									$inputValues='';
									foreach($out['DB']['BoxesDefinition'] as $code=>$value) {
										if($value['type']==$out['DB']['Section'][0]['SectionType'] || empty($value['type']))
										{
											if(empty($prevModule)) {$prevModule = $out['DB']['BoxesDefinition'][$code]['module'];}
											if($prevModule!=$out['DB']['BoxesDefinition'][$code]['module'])
											{
												$inputValues[$code.'1']['id'] = '';
												$inputValues[$code.'1']['value'] = '=================='.$out['DB']['BoxesDefinition'][$code]['module'].'=================';
											}
											$inputValues[$code]['id'] = $code;
											$inputValues[$code]['value'] = $value['name'].' - '.$out['DB']['BoxesDefinition'][$code]['module'];
											$prevModule = $out['DB']['BoxesDefinition'][$code]['module'];
										}
									}
									echo getLists($inputValues,$out['DB']['Section'][0]['SectionBox'],array('name'=>'Section'.DTR.'SectionBox'));	
								?>							
							</td>
						</tr>
						<tr>
							<td class="subtitle"><?=lang('Section.SectionLayout')?></td>
							<td><?=$out['Refs']['SectionLayout']?>&nbsp;<a href="<?=setting('url')?>manageViews/ViewAlias/<?=$out['DB']['Section'][0]['SectionLayout']?>">[<?=lang('ManageLayouts.core.link')?>]</a></td>
						</tr>
						<tr>
							<td class="subtitle"><?=lang('Section.SectionArguments')?></td>
							<td><input type="text" name="Section<?=DTR?>SectionArguments" value="<?=$out['DB']['Section'][0]['SectionArguments'];?>" size="30"></td>
						</tr>	
						<tr>
							<td class="subtitle"><?=lang('Section.SectionManagementLink')?></td>
							<td><input type="text" name="Section<?=DTR?>SectionManagementLink" value="<?=$out['DB']['Section'][0]['SectionManagementLink'];?>" size="30"></td>
						</tr>	
						<tr>
							<td class="subtitle"><?=lang('Section.SectionModule')?></td>
							<td>
								<? $options[0]['id']=' '; $options[0]['value']='--';?>
								<?=getLists($out['DB']['Modules'],$out['DB']['Section'][0]['SectionModule'],array('name'=>'Section'.DTR.'SectionModule','id'=>'ModuleAlias','value'=>'ModuleName','options'=>$options))?>						
							</td>
						</tr>	
						<tr>
							<td align="center" class="subtitleline" colspan="2">
								<span class="subtitle"><?=lang('PageFilesInfo.core.subtitle')?></span>
							</td>
						</tr>
						<tr>
							<td class="subtitle" valign="top"><?=lang('Section.SectionSound')?></td>
							<td>
								<input type="hidden" name="fileField"/>
								<input type="hidden" name="SectionID" value="<?=$out['DB']['Section'][0]['SectionID']?>">
								<? $fieldName = 'SectionSound';  echo getFormated($out['DB']['Section'][0][$fieldName],'File','form',array('fieldName'=>$fieldName,'langMode'=>'Y','deleteLink'=>'<a href="#" onClick="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
							</td>
						</tr>				
						<? }//if ($viewMode=='advanced') ?>		
						<tr>
							<td align="center" class="subtitleline" colspan="2">
								<span class="subtitle"><?=lang('PageActivationInfo.core.subtitle')?></span>
							</td>
						</tr>
						<? /* tr>
							<td class="subtitle"><?=lang('Section.SectionIsHiddenInMenu')?></td>
							<? if(empty($out['DB']['Section'][0]['SectionIsHiddenInMenu'])) {$out['DB']['Section'][0]['SectionIsHiddenInMenu']='N';} ?>
							<td><?=getReference('YesNo','Section'.DTR.'SectionIsHiddenInMenu',$out['DB']['Section'][0]['SectionIsHiddenInMenu'],array('code'=>'Y'))?></td>
						</tr */ ?>
						<tr>
							<td class="subtitle"><?=lang('Section.PermAll')?></td>
							<td><?=$out['Refs']['PermAll']?></td>
						</tr>	
					</table>		
						
					<br/>
					<? if(empty($out['DB']['Section'][0]['SectionID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<?
						if(input('viewMode')=='seo') {$nextView = 'advanced';}
						elseif(input('viewMode')=='advanced') {$nextView = 'design';}
						elseif(input('viewMode')=='design') {$nextView = '';}
						else {$nextView = 'seo';}
					?>
					&nbsp;&nbsp;<input type="submit" value="<?=lang("-save")?>">
					&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.ownerSitemap.actionMode.value='delete';confirmDelete('manageSections', '<?=lang("-deleteconfirmation")?>');">					
					<? } ?>
					&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.ownerSitemap.actionMode.value='cancell';submit();">
					<br/>
			</td> 
		</tr> 
	</form>
	<? if ($viewMode=='main' || empty($viewMode) ) { ?>
		<script language="JavaScript">
			var fromValidator = new Validator("<?=$formName?>");
			//fromValidator.addValidation("Section<?=DTR?>SectionAlias","req","<?=lang('EmptySectionAlias.core.tip')?>");
			fromValidator.addValidation("Section<?=DTR?>SectionName[<?=setting('lang')?>]","req","<?=lang('EmptySectionName.core.tip')?>");
		</script>
	<? }?>	
<?=boxFooter()?>
<?
 }//if(!empty($out['DB']['Section'][0]['SectionLink']) || input('sectionContentType')=='link')
?>
<?=boxHeader(array('title'=>'ManageServiceCategory.billing.title'))?>
<? $entityID = $out['DB']['ServiceCategory'][0]['ServiceCategoryID']; ?>
	<form name="manageServiceCategories" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageServiceCategories" />
		<? if(empty($out['DB']['ServiceCategory'][0]['ServiceCategoryID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="ServiceCategory<?=DTR?>ServiceCategoryID" value="<?=$out['DB']['ServiceCategory'][0]['ServiceCategoryID']?>">
		<? } ?>		
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" class="fieldNames">
							<input type="hidden" name="ServiceCategory<?=DTR?>ServiceCategoryPosition" value="<? if(!empty($entityID)){ echo $out['DB']['ServiceCategory'][0]['ServiceCategoryPosition'];} else { echo input('ServiceCategoryPosition');}?>" size="5">					
							<?=lang('ServiceCategory.ServiceCategoryParentID')?>:<br/>
							<?=$out['Refs']['ServiceCategoryParentID']?>
							<br/>							
							<?=lang('ServiceCategory.ServiceCategoryAlias')?>:<br/>
							<input type="text" name="ServiceCategory<?=DTR?>ServiceCategoryAlias" value="<?=$out['DB']['ServiceCategory'][0]['ServiceCategoryAlias'];?>" size="30">
							<br/>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('ServiceCategory.ServiceCategoryTitle')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<input type="text" name="ServiceCategory<?=DTR?>ServiceCategoryTitle[<?=$langCode?>]" size="30" value="<?=getValue($out['DB']['ServiceCategory'][0]['ServiceCategoryTitle'],$langCode);?>">
								<br/>
							<? } ?>	
							<br/>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('ServiceCategory.ServiceCategoryDescription')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<textarea name="ServiceCategory<?=DTR?>ServiceCategoryDescription[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['ServiceCategory'][0]['ServiceCategoryDescription'],$langCode);?></textarea>
								<br/>
							<? } ?>	
							<br/>
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('ServiceCategory.ServiceCategoryKeywords')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<textarea name="ServiceCategory<?=DTR?>ServiceCategoryKeywords[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['ServiceCategory'][0]['ServiceCategoryKeywords'],$langCode);?></textarea>
								<br/>
							<? } ?>
							<!-- Category Image -->	
							<hr size="1">
							<? if(!empty($out['DB']['ServiceCategory'][0]['ServiceCategoryImage'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['ServiceCategory'][0]['ServiceCategoryImage']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/ServiceCategoryID/<?=$out['DB']['ServiceCategory'][0]['ServiceCategoryID']?>/actionMode/deletefile/fileField/ServiceCategoryImage"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<?=lang('ServiceCategory.ServiceCategoryImage')?>:<br/>
							<input size="22" type="file" name="uploadFile[ServiceCategoryImage]" />
							<input type="hidden" name="oldUploadFile[ServiceCategoryImage]" value="<?=$out['DB']['ServiceCategory'][0]['ServiceCategoryImage']?>" />
							<!--input type="text" name="ServiceCategory<?=DTR?>ServiceCategoryImage" value="<?=$out['DB']['ServiceCategory'][0]['ServiceCategoryImage']?>" size="30"-->
							<br/>							
							<!-- Category Icon -->
							<hr size="1">
							<? if(!empty($out['DB']['ServiceCategory'][0]['ServiceCategoryIcon'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['ServiceCategory'][0]['ServiceCategoryIcon']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/ServiceCategoryID/<?=$out['DB']['ServiceCategory'][0]['ServiceCategoryID']?>/actionMode/deletefile/fileField/ServiceCategoryIcon"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<?=lang('ServiceCategory.ServiceCategoryIcon')?>:<br/>
							<input size="22" type="file" name="uploadFile[ServiceCategoryIcon]" />
							<input type="hidden" name="oldUploadFile[ServiceCategoryIcon]" value="<?=$out['DB']['ServiceCategory'][0]['ServiceCategoryIcon']?>" />
							<!-- Category Image Preview -->
							<hr size="1">
							<? if(!empty($out['DB']['ServiceCategory'][0]['ServiceCategoryImagePreview'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['ServiceCategory'][0]['ServiceCategoryImagePreview']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/ServiceCategoryID/<?=$out['DB']['ServiceCategory'][0]['ServiceCategoryID']?>/actionMode/deletefile/fileField/ServiceCategoryImagePreview"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<?=lang('ServiceCategory.ServiceCategoryImagePreview')?>:<br/>
							<input size="22" type="file" name="uploadFile[ServiceCategoryImagePreview]" />
							<input type="hidden" name="oldUploadFile[ServiceCategoryImagePreview]" value="<?=$out['DB']['ServiceCategory'][0]['ServiceCategoryImagePreview']?>" />
							<hr size="1">
							<br/>
							<?=lang('ServiceCategory.PermAll')?>:<br/>
							<?=$out['Refs']['PermAll']?>
							<br/>	
						</td>
					</tr>	
					</table>		
					<br/>
					<? if(empty($out['DB']['ServiceCategory'][0]['ServiceCategoryID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageServiceCategories.actionMode.value='delete';confirmDelete('manageServiceCategories', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageServiceCategories.actionMode.value='cancell';submit();">
					<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>
<?=boxHeader(array('title'=>'ManageTourCategory.tour.title'))?>
<? $entityID = $out['DB']['TourCategory'][0]['TourCategoryID']; ?>
	<form name="manageTourCategories" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageTourCategories" />
		<? if(empty($out['DB']['TourCategory'][0]['TourCategoryID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="TourCategory<?=DTR?>TourCategoryID" value="<?=$out['DB']['TourCategory'][0]['TourCategoryID']?>">
		<? } ?>		
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0">
					<tr>
						<td valign="top" class="fieldNames">
							<input type="hidden" name="TourCategory<?=DTR?>TourCategoryPosition" value="<? if(!empty($entityID)){ echo $out['DB']['TourCategory'][0]['TourCategoryPosition'];} else { echo input('TourCategoryPosition');}?>" size="5">					
							<?=lang('TourCategory.TourCategoryParentID')?>:<br/>
							<?=$out['Refs']['TourCategoryParentID']?>
							<br/>							
							<?=lang('TourCategory.TourCategoryAlias')?>:<br/>
							<input type="text" name="TourCategory<?=DTR?>TourCategoryAlias" value="<?=$out['DB']['TourCategory'][0]['TourCategoryAlias'];?>" size="30">
							<br/>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('TourCategory.TourCategoryTitle')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<input type="text" name="TourCategory<?=DTR?>TourCategoryTitle[<?=$langCode?>]" size="30" value="<?=getValue($out['DB']['TourCategory'][0]['TourCategoryTitle'],$langCode);?>">
								<br/>
							<? } ?>	
							<br/>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('TourCategory.TourCategoryDescription')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<textarea name="TourCategory<?=DTR?>TourCategoryDescription[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['TourCategory'][0]['TourCategoryDescription'],$langCode);?></textarea>
								<br/>
							<? } ?>	
							<br/>
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('TourCategory.TourCategoryKeywords')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<textarea name="TourCategory<?=DTR?>TourCategoryKeywords[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['TourCategory'][0]['TourCategoryKeywords'],$langCode);?></textarea>
								<br/>
							<? } ?>
							<!-- Category Image -->	
							<hr size="1">
							<? if(!empty($out['DB']['TourCategory'][0]['TourCategoryImage'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['TourCategory'][0]['TourCategoryImage']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/TourCategoryID/<?=$out['DB']['TourCategory'][0]['TourCategoryID']?>/actionMode/deletefile/fileField/TourCategoryImage"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<?=lang('TourCategory.TourCategoryImage')?>:<br/>
							<input size="22" type="file" name="uploadFile[TourCategoryImage]" />
							<input type="hidden" name="oldUploadFile[TourCategoryImage]" value="<?=$out['DB']['TourCategory'][0]['TourCategoryImage']?>" />
							<!--input type="text" name="TourCategory<?=DTR?>TourCategoryImage" value="<?=$out['DB']['TourCategory'][0]['TourCategoryImage']?>" size="30"-->
							<br/>							
							<!-- Category Icon -->
							<hr size="1">
							<? if(!empty($out['DB']['TourCategory'][0]['TourCategoryIcon'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['TourCategory'][0]['TourCategoryIcon']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/TourCategoryID/<?=$out['DB']['TourCategory'][0]['TourCategoryID']?>/actionMode/deletefile/fileField/TourCategoryIcon"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<?=lang('TourCategory.TourCategoryIcon')?>:<br/>
							<input size="22" type="file" name="uploadFile[TourCategoryIcon]" />
							<input type="hidden" name="oldUploadFile[TourCategoryIcon]" value="<?=$out['DB']['TourCategory'][0]['TourCategoryIcon']?>" />
							<!-- Category Image Preview -->
							<hr size="1">
							<? if(!empty($out['DB']['TourCategory'][0]['TourCategoryImagePreview'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['TourCategory'][0]['TourCategoryImagePreview']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/TourCategoryID/<?=$out['DB']['TourCategory'][0]['TourCategoryID']?>/actionMode/deletefile/fileField/TourCategoryImagePreview"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<?=lang('TourCategory.TourCategoryImagePreview')?>:<br/>
							<input size="22" type="file" name="uploadFile[TourCategoryImagePreview]" />
							<input type="hidden" name="oldUploadFile[TourCategoryImagePreview]" value="<?=$out['DB']['TourCategory'][0]['TourCategoryImagePreview']?>" />
							<hr size="1">
							<br/>
							<?=lang('TourCategory.PermAll')?>:<br/>
							<?=$out['Refs']['PermAll']?>
							<br/>	
						</td>
					</tr>	
					</table>		
					<br/>
					<? if(empty($out['DB']['TourCategory'][0]['TourCategoryID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageTourCategories.actionMode.value='delete';confirmDelete('manageTourCategories', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageTourCategories.actionMode.value='cancell';submit();">
					<br/>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>
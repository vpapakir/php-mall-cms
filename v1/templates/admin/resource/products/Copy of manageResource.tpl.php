<? if($input['actionMode']=='add' || $input['actionMode']=='save1')  { ?> 
	<script language="javascript">
		window.document.onLoad= setTimeout("goback('<?= setting('url')?>manageResources/CategoryID/<?=$input[Resource.DTR.ResourceCategories][0]?>')");
	</script>
  <? }else{?>
<?=boxHeader(array('title'=>'ManageResourceProducts.resource.title'))?>
<? $entityID = $out['DB']['Resource'][0]['ResourceID']; $categoryID = input('CategoryID'); ?>
	<? if(!empty($input['ResourceType']) || !empty($out['DB']['Resource'][0]['ResourceType'])) { ?>
	<tr> 
		<td valign=top bgcolor="#ffffff">
			<? $resourceType = $out['DB']['Resource'][0]['ResourceType']; if(empty($resourceType)) {$resourceType=$input['ResourceType'];}?>
			<?=lang('Resource.products.ResourceType')?>: <b><?=getListValue($out['DB']['ResourceTypes'],$resourceType,array('id'=>'ResourceTypeAlias','value'=>'ResourceTypeName'))?></b>
		</td> 
	</tr>
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
				$options[0]['value']='- '.lang('ResourceTypeSelect.resource.tip').' -';
				echo getLists($out['DB']['ResourceTypes'],$input['ResourceType'],array('name'=>'ResourceType','id'=>'ResourceTypeAlias','value'=>'ResourceTypeName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
			?>	
		</td> 
	</form>
	</tr> 
	<? } ?>
	<? if(!empty($out['DB']['Resource'][0]['ResourceType']) || !empty($input['ResourceType'])) { ?>
	<form name="manageResources" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageResources" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		
		<? if(empty($out['DB']['Resource'][0]['ResourceID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<input type="hidden" name="ResourceType" value="<?=input('ResourceType')?>" />	
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="Resource<?=DTR?>ResourceID" value="<?=$out['DB']['Resource'][0]['ResourceID']?>">
		<input type="hidden" name="Resource<?=DTR?>ResourceType" value="<?=$out['DB']['Resource'][0]['ResourceType']?>">
		<? } ?>		
		<? if(empty($out['DB']['Resource'][0]['ResourceType'])) { ?>
		<input type="hidden" name="Resource<?=DTR?>ResourceType" value="<?=input('ResourceType')?>" />		
		<? } else { ?>
		<input type="hidden" name="Resource<?=DTR?>ResourceType" value="<?=$out['DB']['Resource'][0]['ResourceType']?>">
		<? } ?>			
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames" align="center">
					<table cellspacing="0" cellpadding="0" align="center">
					<tr>
						<td valign="top" class="fieldNames" align="center">
							<input type="hidden" name="Resource<?=DTR?>ResourcePosition" value="<? if(!empty($entityID)){ echo $out['DB']['Resource'][0]['ResourcePosition'];} else { echo input('ResourcePosition');}?>" size="5">					
							<?=lang('Resource.products.ResourceCategories')?>:<br/>
							<?
								if(!empty($out['DB']['Resource'][0]['ResourceCategories']))
								{
									$parentID = $out['DB']['Resource'][0]['ResourceCategories'];
								}
								else
								{
									$parentID = '|'.$categoryID.'|';
								}								
								echo getLists($out['DB']['ResourceCategories'],$parentID,array('name'=>'Resource'.DTR.'ResourceCategories','attributes'=>'size="10"','type'=>'multiple','style'=>'width=500px;'));	
							?>
							<br/><br/>
							<?=lang('Resource.products.ResourceLocation')?>:<br/>
							<? setInput('CountryID','118'); ?>
							<? 
								$params['currentValue'] = $out['DB']['Resource'][0]['ResourceLocationID'];
								$params['fieldName'] = 'Resource'.DTR.'ResourceLocationID';
								$params['id'] = 'id';
								getBox('core.getRegionsDropDwon',array("params"=>$params)); 
							?>
							<? //=getReference('Resource.ResourceLocation','Resource'.DTR.'ResourceLocation',$out['DB']['Resource'][0]['ResourceLocation'],array('code'=>'Y'))?>
							<br/>
							<?=lang('Resource.products.ResourceAlias')?>:<br/>
							<input type="text" name="Resource<?=DTR?>ResourceAlias" value="<?=$out['DB']['Resource'][0]['ResourceAlias'];?>" size="30">
							<br/>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('Resource.products.ResourceTitle')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<input type="text" name="Resource<?=DTR?>ResourceTitle[<?=$langCode?>]" size="30" value="<?=getValue($out['DB']['Resource'][0]['ResourceTitle'],$langCode);?>">
								<br/>
							<? } ?>	
							<br/>	
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('Resource.products.ResourceIntro')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<textarea name="Resource<?=DTR?>ResourceIntro[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['Resource'][0]['ResourceIntro'],$langCode);?></textarea>
								<br/>
							<? } ?>	
							<br/>
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('Resource.products.ResourceContent')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<textarea name="Resource<?=DTR?>ResourceContent[<?=$langCode?>]" cols="80" rows="10"><?=getValue($out['DB']['Resource'][0]['ResourceContent'],$langCode);?></textarea>
								<br/>
							<? } ?>	
							<br>
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
								<?=lang('Resource.products.ResourceKeywords')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>
								<br/>
								<textarea name="Resource<?=DTR?>ResourceKeywords[<?=$langCode?>]" cols="40" rows="5"><?=getValue($out['DB']['Resource'][0]['ResourceKeywords'],$langCode);?></textarea>
								<br/>
							<? } ?>															
							<br/>	
							<hr size="1">
							
							<?=lang('Resource.products.ResourceLanguages')?>:<br/>
							<?
								foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)
								{
									$languagesList[$langID]['id']=$languagesList['languageCodes'][$langID];	
									$languagesList[$langID]['value']=$langName;		
								}								
								echo getLists($languagesList,$out['DB']['Resource'][0]['ResourceLanguages'],array('name'=>'Resource'.DTR.'ResourceLanguages','type'=>'checkboxes'));	
							?>	
							
							<br/>					
							<?=lang('Resource.products.ResourceLink')?>:<br/>
							<input type="text" name="Resource<?=DTR?>ResourceLink" value="<?=$out['DB']['Resource'][0]['ResourceLink'];?>" size="30">
							<br>
							<hr size="1">
							<?=lang('Resource.products.ResourcePrice')?>:<br/>
							<input type="text" name="Resource<?=DTR?>ResourcePrice" value="<?=$out['DB']['Resource'][0]['ResourcePrice']?>" size="5"> <?=setting('currency')?>
							<br/><br/>
							<?=lang('Resource.products.ResourceWeight')?>:<br/>
							<input type="text" name="Resource<?=DTR?>ResourceWeight" value="<?=$out['DB']['Resource'][0]['ResourceWeight']?>" size="5"> <?=lang('kg')?>
							
							<hr size="1">
							<!-- Big Image -->
							<? //if(!empty($out['DB']['Resource'][0]['ResourceImage'])) { ?>
								<!-- <img src="<?=setting('urlfiles').$out['DB']['Resource'][0]['ResourceImage']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/ResourceID/<?=$out['DB']['Resource'][0]['ResourceID']?>/CategoryID/<?=input('CategoryID')?>/actionMode/deletefile/fileField/ResourceImage"><?=lang('-deleteimage')?></a> -->
							<? //} ?>
							<? if(!empty($out['DB']['Resource'][0]['ResourceIcon'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['Resource'][0]['ResourceIcon']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/ResourceID/<?=$out['DB']['Resource'][0]['ResourceID']?>/CategoryID/<?=input('CategoryID')?>/actionMode/deletefile/fileField/ResourceIcon"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<?=lang('Resource.products.ResourceImage')?>:<br/>
							<input size="22" type="file" name="uploadFile[ResourceImage]" />
							<input type="hidden" name="uploadFileSettings[ResourceImage][ImageWidthLimit]" value="500" />
							<input type="hidden" name="uploadFileSettings[ResourceImage][ImageHeightLimit]" value="1000" />
							<input type="hidden" name="oldUploadFile[ResourceImage]" value="<?=$out['DB']['Resource'][0]['ResourceImage']?>" />
							<hr size="1">
							<br/>
							<!-- Icon Image -->
							<? if(!empty($out['DB']['Resource'][0]['ResourceIcon'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['Resource'][0]['ResourceIcon']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/ResourceID/<?=$out['DB']['Resource'][0]['ResourceID']?>/CategoryID/<?=input('CategoryID')?>/actionMode/deletefile/fileField/ResourceIcon"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br>
							<?=lang('Resource.products.ResourceIcon')?>:<br/>
							<input size="22" type="file" name="uploadFile[ResourceIcon]" />
							<!--input type="hidden" name="uploadFileSettings[ResourceIcon][ImageWidthLimit]" value="60" />
							<input type="hidden" name="uploadFileSettings[ResourceIcon][ImageHeightLimit]" value="300" /-->
							<input type="hidden" name="oldUploadFile[ResourceIcon]" value="<?=$out['DB']['Resource'][0]['ResourceIcon']?>" />
							<br/>
							<!-- Preview Image -->
							<hr size="1">
							<? //if(!empty($out['DB']['Resource'][0]['ResourceImagePreview'])) { ?>
								<!-- <img src="<?=setting('urlfiles').$out['DB']['Resource'][0]['ResourceImagePreview']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/ResourceID/<?=$out['DB']['Resource'][0]['ResourceID']?>/CategoryID/<?=input('CategoryID')?>/actionMode/deletefile/fileField/ResourceImagePreview"><?=lang('-deleteimage')?></a> -->
							<? //} ?>
							<? if(!empty($out['DB']['Resource'][0]['ResourceIcon'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['Resource'][0]['ResourceIcon']?>" border="0" />
								<br/>
								<a href="<?=setting('url').input('SID')?>/ResourceID/<?=$out['DB']['Resource'][0]['ResourceID']?>/CategoryID/<?=input('CategoryID')?>/actionMode/deletefile/fileField/ResourceIcon"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br>
							<?=lang('Resource.products.ResourceImagePreview')?>:<br/>
							<input size="22" type="file" name="uploadFile[ResourceImagePreview]" />
							<!--input type="hidden" name="uploadFileSettings[ResourceImagePreview][ImageWidthLimit]" value="220" />
							<input type="hidden" name="uploadFileSettings[ResourceImagePreview][ImageHeightLimit]" value="500" /-->
							<input type="hidden" name="oldUploadFile[ResourceImagePreview]" value="<?=$out['DB']['Resource'][0]['ResourceImagePreview']?>" />
							<? if(count($out['DB']['ResourceField'])>0) {?>
							<hr size="1">
							<?=lang('ResourceExtraFieldsList.resource.tip')?>:&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceTypes/ResourceType/<?=input('ResourceType')?>" target="_blank">[<?=lang('EditResourceExtraFields.resource.link')?>]</a><br/><br/>
								<?=showExtraFieldsForm($out)?>
								<hr size="1">
								<?=lang('ResourceOptionsList.resource.tip')?>:&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceTypes/ResourceType/<?=input('ResourceType')?>" target="_blank">[<?=lang('EditResourceExtraOptions.resource.link')?>]</a><br/><br/>
								<?=showExtraOptionsForm($out)?>						
							<?  } ?>				
							<hr size="1">
							<?=lang('Resource.tip.ResourceFeaturedOptions')?>:<br/>
							<?=getReference('Resource.ResourceFeaturedOptions','Resource'.DTR.'ResourceFeaturedOptions',$out['DB']['Resource'][0]['ResourceFeaturedOptions'],array('code'=>'Y'))?>
							<br/><br/>				
										
							<hr size="1">
							<?=lang('Resource.products.PermAll')?>:<br/>
							<?=getReference('PermAll','Resource'.DTR.'PermAll',$out['DB']['Resource'][0]['PermAll'],array('code'=>'Y'))?>
							<br/>	
						</td>
					</tr>	
					</table>		
					<br/>
					<? if(empty($out['DB']['Resource'][0]['ResourceID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageResources.actionMode.value='delete';confirmDelete('manageResources', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageResources.actionMode.value='cancell';submit();">
					
					<br/>
			</td> 
		</tr> 
	</form>
	<script language="JavaScript">
			var fromValidator = new Validator("manageResources");
			fromValidator.addValidation("Resource<?=DTR?>ResourceCategories[]","req","<?=lang('ResourceCategories.products.tip')?>");
			fromValidator.addValidation("Resource<?=DTR?>ResourceAlias","req","<?=lang('ResourceCategoryAlias.products.tip')?>");
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				fromValidator.addValidation("Resource<?=DTR?>ResourceTitle[<?=$langCode?>]","req","<?=lang('ResourceTitle.products.tip')?>");
			<? }?>
	</script>	
	<? } ?>
<?=boxFooter()?>
<? }?>
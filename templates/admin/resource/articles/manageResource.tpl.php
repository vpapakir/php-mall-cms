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

			<?=lang('Resource.tip.ResourceType')?>: <b><?=getListValue($out['DB']['ResourceTypes'],$resourceType,array('id'=>'ResourceTypeAlias','value'=>'ResourceTypeName'))?></b>

		</td> 

	</tr*/?>

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

	<? if(!empty($out['DB']['Resource'][0]['ResourceType']) || !empty($input['ResourceType'])) { 

		$formName = 'manageResources';?>

	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">

		<input type="hidden" name="SID" value="manageResources" />

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

		<input type="hidden" name="ResourceType" value="<?=input('ResourceType')?>" />		

		<? } else { ?>

		<input type="hidden" name="Resource<?=DTR?>ResourceType" value="<?=$out['DB']['Resource'][0]['ResourceType']?>">

		<input type="hidden" name="ResourceType" value="<?=$out['DB']['Resource'][0]['ResourceType']?>">

		<? } ?>

		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />

		<tr> 

			<td valign="top" bgcolor="#ffffff" class="fieldNames" align="center">

					<table cellspacing="0" cellpadding="0" align="center">

					<tr>

						<td valign="top" class="fieldNames" align="center">

							<input type="hidden" name="Resource<?=DTR?>ResourcePosition" value="<? if(!empty($entityID)){ echo $out['DB']['Resource'][0]['ResourcePosition'];} else { echo input('ResourcePosition');}?>" size="5">					

							<? //lang('Resource.tip.ResourceCategories')?><!-- :<br/> -->

							<? /*

								if(!empty($out['DB']['Resource'][0]['ResourceCategories']))

								{

									$parentID = $out['DB']['Resource'][0]['ResourceCategories'];

								}

								else

								{

									$parentID = '|'.$categoryID.'|';

								}								

								echo getLists($out['DB']['ResourceCategories'],$parentID,array('name'=>'Resource'.DTR.'ResourceCategories','attributes'=>'size="10"','type'=>'multiple','style'=>'width:500px;'));	

							*/?>

							<br/>

							<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceAlias')?>:</span><br/>	

							<?=lang('Resource.tip.ResourceAlias')?>:<br/>

							<input type="text" name="Resource<?=DTR?>ResourceAlias" value="<?=$out['DB']['Resource'][0]['ResourceAlias'];?>" size="35" id="ResourceAlias" onMouseDown="convertToAlias('ResourceTitle_en','ResourceAlias')" />

							<br/>

							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>

								<?=lang('Resource.tip.ResourceTitle')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>

								<br/>

								<input type="text" name="Resource<?=DTR?>ResourceTitle[<?=$langCode?>]" id="ResourceTitle_<?=$langCode?>" size="35" value="<?=getValue($out['DB']['Resource'][0]['ResourceTitle'],$langCode);?>">

								<br/>

							<? } ?>	

							<br/>

							<?=lang('Resource.tip.ResourceAuthor')?>:<br/>

							<input type="text" name="Resource<?=DTR?>ResourceAuthor" value="<?=$out['DB']['Resource'][0]['ResourceAuthor'];?>" size="35">

							<br>

							<?=lang('Resource.tip.ResourceLink')?>:<br/>

							<input type="text" name="Resource<?=DTR?>ResourceLink" value="<?=$out['DB']['Resource'][0]['ResourceLink'];?>" size="35">

							<br>

							

							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>

								<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceIntro')?>:</span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo $out['DB']['Languages']['languageNames'][$langID];?>

								<br/>

								<textarea name="Resource<?=DTR?>ResourceIntro[<?=$langCode?>]" cols="35" rows="5"><?=getValue($out['DB']['Resource'][0]['ResourceIntro'],$langCode);?></textarea>

								<br/>

							<? } ?>	

							<br/>

							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>

								<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceContent')?>:</span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo $out['DB']['Languages']['languageNames'][$langID];?>

								<br/>

								<?=getFormated(getValue($out['DB']['Resource'][0]['ResourceContent'],$langCode),'HTML','form',array('fieldName'=>'Resource'.DTR.'ResourceContent['.$langCode.']','editorName'=>'ResourceContent'.$langCode,'editorWidth'=>550,'editorHeight'=>400,'editorToolbar'=>'Default'))?>

								<br/>

							<? } ?>	

							<br>

							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>

								<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceKeywords')?>:</span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo $out['DB']['Languages']['languageNames'][$langID];?>

								<br/>

								<textarea name="Resource<?=DTR?>ResourceKeywords[<?=$langCode?>]" cols="35" rows="5"><?=getValue($out['DB']['Resource'][0]['ResourceKeywords'],$langCode);?></textarea>

								<br/>

							<? } ?>															

							<br/>	

							<hr size="1">

							<br/>

							<table cellpadding="4" cellspacing="0" border="0" width="100%">

								<tr>

									<td class="row1" align="center">

										<span class="subtitle"><?=lang('ImagesArea.resource.subtitle')?></span>

									</td>

								</tr>

							</table>

							<br/>

								<input type="hidden" name="fileField"/>

								<input type="hidden" name="ResourceID" value="<?=$out['DB']['Resource'][0]['ResourceID']?>">

								<? $fieldName = 'ResourceIcon';  echo getFormated($out['DB']['Resource'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Resource.'.$resourceTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>

								<br/><br/>

								<hr size="1">

								<? $fieldName = 'ResourceImagePreview';  echo getFormated($out['DB']['Resource'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Resource.'.$resourceTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>

								<br/><br/>

								<hr size="1">

								<? $fieldName = 'ResourceImage';  echo getFormated($out['DB']['Resource'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Resource.'.$resourceTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>

								<br/><br/>

							<br/>		

							<? if(count($out['DB']['ResourceField'])>0) {?>

							<hr size="1">

							<br/>

							<span class="subtitle"><?=lang('ResourceExtraFieldsList.resource.tip')?>:</span>&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceTypes/ResourceType/<?=input('ResourceType')?>" target="_blank">[<?=lang('EditResourceExtraFields.resource.link')?>]</a><br/><br/>

								<?=showExtraFieldsForm($out)?>

								<hr size="1">

								<span class="subtitle"><?=lang('ResourceOptionsList.resource.tip')?>:</span>&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceTypes/ResourceType/<?=input('ResourceType')?>" target="_blank">[<?=lang('EditResourceExtraOptions.resource.link')?>]</a><br/><br/>

								<?=showExtraOptionsForm($out)?>						

							<?  } ?>		

							<hr size="1">

							<span class="subtitle"><?=lang('Resource.tip.ResourcePaidRate')?>:</span><br/>

							<?=getReference('Resource.ResourcePaidRate','Resource'.DTR.'ResourcePaidRate',$out['DB']['Resource'][0]['ResourcePaidRate'],array('code'=>'Y'))?>

							<br/>

							<hr size="1">

							<span class="subtitle"><?=lang('Resource.tip.ResourceReviewsRate')?>:</span><br/>

							<?=getReference('Resource.ResourceReviewsRate','Resource'.DTR.'ResourceReviewsRate',$out['DB']['Resource'][0]['ResourceReviewsRate'],array('code'=>'Y'))?>

							<br/>							

							<hr size="1">

							<span class="subtitle"><?=lang('Resource.tip.ResourceFeaturedOptions')?>:</span><br/>

							<?=getReference('Resource.ResourceFeaturedOptions','Resource'.DTR.'ResourceFeaturedOptions',$out['DB']['Resource'][0]['ResourceFeaturedOptions'],array('code'=>'Y'))?>

							<br/>							

							<table cellpadding="4" cellspacing="0" border="0" width="100%">

								<tr>

									<td class="row1" align="center">

										<span class="subtitle"><?=lang('StatusesArea.resource.subtitle')?></span>

									</td>

								</tr>

							</table>

							<br/>

							<? if(count($out['DB']['Languages']['languageNames'])>1) { ?>														

								<span class="subtitle"><?=lang('Resource.'.$resourceTemplate.'.ResourceLanguages')?>: </span>

								<?

									foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)

									{

										$languagesList[$langID]['id']=$languagesList['languageCodes'][$langID];	

										$languagesList[$langID]['value']=$langName;		

									}								

									echo getLists($languagesList,$out['DB']['Resource'][0]['ResourceLanguages'],array('name'=>'Resource'.DTR.'ResourceLanguages','type'=>'checkboxes','delimiter'=>' '));	

								?>	

							<? } ?>

							<hr size="1">

							<span class="subtitle"><?=lang('Resource.ResourceComments')?>:</span><br/>

							<textarea cols="35" rows="7" name="Resource<?=DTR?>ResourceComments"><?=$out['DB']['Resource'][0]['ResourceComments']?></textarea>

							

							<hr size="1">

							<span class="subtitle"><?=lang('Resource.ResourceStatus')?>:</span><br/>

							<? if(empty($out['DB']['Resource'][0]['ResourceStatus'])) { $out['DB']['Resource'][0]['ResourceStatus'] = 'active';} ?>

							<?=getReference('Resource.ResourceStatus','Resource'.DTR.'ResourceStatus',$out['DB']['Resource'][0]['ResourceStatus'],array('code'=>'Y'))?>

							<br/><br/>

							<span class="subtitle"><?=lang('Resource.PermAll')?>:</span><br/>

							<? if(empty($out['DB']['Resource'][0]['PermAll'])) {$out['DB']['Resource'][0]['PermAll']=1;} ?>

							<?=getReference('PermAll','Resource'.DTR.'PermAll',$out['DB']['Resource'][0]['PermAll'],array('code'=>'Y'))?>

							<br/>	

						</td>

					</tr>	

					</table>		

					<br/>

					<? if(empty($out['DB']['Resource'][0]['ResourceID'])) { ?>

					<input type="submit" value="<?=lang("-add")?>">

					<? } else { ?>

					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="confirmDelete('manageResources', '<?=lang("-deleteconfirmation")?>');">

					<? } ?>					

					&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageResources.actionMode.value='cancell';submit();">

					

					<br/>

			</td> 

		</tr> 

	</form>

	<script language="JavaScript">

			var fromValidator = new Validator("<?=$formName?>");

			fromValidator.addValidation("Resource<?=DTR?>ResourceCategories[]","req","<?=lang('ResourceCategories.products.tip')?>");

			//fromValidator.addValidation("Resource<?=DTR?>ResourceAlias","req","<?=lang('ResourceCategoryAlias.products.tip')?>");

			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>

				fromValidator.addValidation("Resource<?=DTR?>ResourceTitle[<?=$langCode?>]","req","<?=lang('ResourceTitle.products.tip')?>");

			<? }?>

	</script>	

	<? } ?>

<?=boxFooter()?>


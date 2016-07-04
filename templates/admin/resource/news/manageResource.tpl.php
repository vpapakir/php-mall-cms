<? if($input['actionMode']=='save1' || $input['actionMode']=='add' || $input['actionMode']=='view') { ?>

<?=getBox('resource.getResource')?>

<? } else { ?>

<?

	$resourceTemplate = input('ResourceTemplate');

	$resourceType = $out['DB']['Resource'][0]['ResourceType']; if(empty($resourceType)) {$resourceType=$input['ResourceType'];}

	if(!empty($resourceType)) {$resourceTypeName = getListValue($out['DB']['ResourceTypes'],$resourceType,array('id'=>'ResourceTypeAlias','value'=>'ResourceTypeName'));}

	if(!empty($resourceTypeName)) {$resourceTypeTitle = ' > '.$resourceTypeName;}

	

	$title = lang('AddEditResource.resource.title').$resourceTypeTitle;

?>

<?=boxHeader(array('title'=>$title))?>

<? $entityID = $out['DB']['Resource'][0]['ResourceID']; $categoryID = input('CategoryID'); ?>

	<? if(!empty($input['ResourceType']) || !empty($out['DB']['Resource'][0]['ResourceType'])) { ?>

	<? /*tr> 

		<td valign=top bgcolor="#ffffff">

			<? $resourceType = $out['DB']['Resource'][0]['ResourceType']; if(empty($resourceType)) {$resourceType=$input['ResourceType'];}?>

			<?=lang('Resource.products.ResourceType')?>: <b><?=getListValue($out['DB']['ResourceTypes'],$resourceType,array('id'=>'ResourceTypeAlias','value'=>'ResourceTypeName'))?></b>

		</td> 

	</tr */ ?>

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

				echo getLists($out['DB']['ResourceTypes'],$input['ResourceType'],array('name'=>'ResourceType','id'=>'ResourceTypeAlias','value'=>'ResourceTypeName','action'=>'submit();','style'=>'width:200px;','options'=>$options));	

			?>	

		</td> 

	</form>

	</tr> 

	<? } ?>

	<? if(!empty($out['DB']['Resource'][0]['ResourceType']) || input('ResourceType')) { 

	   $formName = 'editResource';

	?>

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

		<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />

		<input type="hidden" name="ResourceStatus" value="<?=input('ResourceStatus')?>" />

		<tr> 

			<td valign="top" bgcolor="#ffffff" class="fieldNames">

					<table cellspacing="4" cellpadding="0">

						<input type="hidden" name="Resource<?=DTR?>ResourcePosition" value="<? if(!empty($entityID)){ echo $out['DB']['Resource'][0]['ResourcePosition'];} else { echo input('ResourcePosition');}?>" size="5">					

						<? //lang('Resource.news.ResourceCategories')?><!-- :<br/> -->

						<? /*

							if(!empty($out['DB']['Resource'][0]['ResourceCategories']))

							{

								$parentID = $out['DB']['Resource'][0]['ResourceCategories'];

							}

							else

							{

								$parentID = '|'.$categoryID.'|';

							}								

							echo getLists($out['DB']['ResourceCategories'],$parentID,array('name'=>'Resource'.DTR.'ResourceCategories','attributes'=>'size="1"','type'=>'multipledropdown','style'=>'width:500px;'));	

						*/?>

						<tr>

							<td class="subtitleline" align="center" colspan="2">

								<span class="subtitle"><?=lang('TitleAreaNews.resource.subtitle')?></span>

							</td>

						</tr>

						<tr><td>&nbsp;</td></tr>

						<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>

							<tr>

								<td>

								<span class="subtitle"><?=lang('Resource.news.ResourceTitle')?></span>

									 <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>

								</td>

								<td>

									<input type="text" name="Resource<?=DTR?>ResourceTitle[<?=$langCode?>]" id="ResourceTitle_<?=$langCode?>" size="35" value="<?=getValue($out['DB']['Resource'][0]['ResourceTitle'],$langCode);?>">

								</td>

							</tr>

						<? } ?>	

						<tr>

							<td>

								<span class="subtitle"><?=lang('Resource.news.ResourceLink')?></span>

							</td>

							<td>

								<? if(!empty($out['DB']['Resource'][0]['ResourceLink'])) {$link = $out['DB']['Resource'][0]['ResourceLink'];} else {$link='http://';} ?>

								<input type="text" name="Resource<?=DTR?>ResourceLink" value="<?=$link?>" size="35">

								<br>

							</td>	

						</tr>

						<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>

						<tr>

							<td>

								<span class="subtitle"><?=lang('Resource.news.ResourceIntro')?></span> 

									<? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>

							</td>

							<td>

								<textarea name="Resource<?=DTR?>ResourceIntro[<?=$langCode?>]" cols="35" rows="5"><?=getValue($out['DB']['Resource'][0]['ResourceIntro'],$langCode);?></textarea>

							</td>

						</tr>

						<? } ?>	

						<? if(count($out['DB']['ResourceField'])>0) {?>

							<tr>

								<td class="subtitleline" colspan="2" align="center">

									<span class="subtitle"><?=lang('ExtraFieldsArea.resource.subtitle')?></span>

								</td>

							</tr>

							<tr><td>&nbsp;</td></tr>

							<tr>

								<td>

									<span class="subtitle"><?=lang('ResourceExtraFieldsList.resource.tip')?>:</span>&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceTypes/ResourceType/<?=input('ResourceType')?>" target="_blank">[<?=lang('EditResourceExtraFields.resource.link')?>]</a>

								</td>

								<td>

									<?=showExtraFieldsForm($out)?>

								</td>

							</tr>

							<tr>

								<td>

									<span class="subtitle"><?=lang('ResourceOptionsList.resource.tip')?>:</span>&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceTypes/ResourceType/<?=input('ResourceType')?>" target="_blank">[<?=lang('EditResourceExtraOptions.resource.link')?>]</a>

								</td>

								<td>

									<?=showExtraOptionsForm($out)?>		

								</td>

							</tr>

						<?  } ?>		

						<tr>

							<td class="subtitleline" colspan="2" align="center">

								<span class="subtitle"><?=lang('StatusesArea.resource.subtitle')?></span>

							</td>

						</tr>

						<tr><td>&nbsp;</td></tr>

						<tr>

							<td>

								<span class="subtitle"><?=lang('Resource.news.ResourceStatus')?></span>

							</td>

							<td>

								<? if(empty($out['DB']['Resource'][0]['ResourceStatus'])) { $out['DB']['Resource'][0]['ResourceStatus'] = 'active';} ?>

								<?=getReference('Resource.ResourceStatus','Resource'.DTR.'ResourceStatus',$out['DB']['Resource'][0]['ResourceStatus'],array('code'=>'Y'))?>

							</td>

						</tr>

						<tr><td>&nbsp;</td></tr>

						<tr>

							<td colspan="2" align="center">

								<span class="subtitle"><?=lang('SaveResourceWarning.resource.tip')?></span>

							</td>

						</tr>

						<tr><td>&nbsp;</td></tr>

						<tr>

							<td colspan="2" align="center" class="subtitleline">

								<? if(empty($out['DB']['Resource'][0]['ResourceID'])) { ?>

								<input type="submit" value="<?=lang("-add")?>">

								<? } else { ?>

								<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="confirmDelete('editResource', '<?=lang("-deleteconfirmation")?>');">

								<? } ?>

								&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.editResource.actionMode.value='cancell';submit();">

							</td>

						</tr>

				</table>						

			</td> 

		</tr> 

	</form>

	<script language="JavaScript">

			var fromValidator = new Validator("<?=$formName?>");

			//fromValidator.addValidation("Resource<?=DTR?>ResourceAlias","req","<?=lang('ResourceCategoryAlias.products.tip')?>");

			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>

				fromValidator.addValidation("Resource<?=DTR?>ResourceTitle[<?=$langCode?>]","req","<?=lang('ResourceTitle.products.tip')?>");

			<? }?>

	</script>	

	<? } ?>



<?=boxFooter()?>

<? } ?>


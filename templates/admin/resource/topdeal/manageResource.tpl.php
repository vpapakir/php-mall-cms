<?=boxHeader(array('title'=>'ManageResourceProducts.resource.title'))?>

<? $entityID = $out['DB']['Resource'][0]['ResourceID']; $categoryID = input('CategoryID'); ?>

	<? if(!empty($input['ResourceType']) || !empty($out['DB']['Resource'][0]['ResourceType'])) { ?>

	<tr> 

		<td valign=top bgcolor="#ffffff">

			<? $resourceType = $out['DB']['Resource'][0]['ResourceType']; if(empty($resourceType)) {$resourceType=$input['ResourceType'];}?>

			<?=lang('Resource.featured.ResourceType')?>: <b><?=getListValue($out['DB']['ResourceTypes'],$resourceType,array('id'=>'ResourceTypeAlias','value'=>'ResourceTypeName'))?></b>

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

							<?=lang('Resource.featured.ResourceCategories')?>:<br/>

							<?

								if(!empty($out['DB']['Resource'][0]['ResourceCategories']))

								{

									$parentID = $out['DB']['Resource'][0]['ResourceCategories'];

								}

								else

								{

									$parentID = '|'.$categoryID.'|';

								}								

								echo getLists($out['DB']['ResourceCategories'],$parentID,array('name'=>'Resource'.DTR.'ResourceCategories','attributes'=>'size="10"','type'=>'multiple','style'=>'width:500px;'));	

							?>

							<br/>	

							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>

								<?=lang('Resource.featured.ResourceTitle')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>

								<br/>

								<input type="text" name="Resource<?=DTR?>ResourceTitle[<?=$langCode?>]" id="ResourceTitle_<?=$langCode?>" size="90" value="<?=getValue($out['DB']['Resource'][0]['ResourceTitle'],$langCode);?>">

								<br/>

							<? } ?>	

							<br/>	

							<?=lang('Resource.featured.ResourceAuthor')?>:<br/>

							<input type="text" name="Resource<?=DTR?>ResourceAuthor" value="<?=$out['DB']['Resource'][0]['ResourceAuthor'];?>" size="50">

							<br>

							<?=lang('Resource.featured.ResourceLink')?>:<br/>

							<input type="text" id="ResourceLink" name="Resource<?=DTR?>ResourceLink" value="<?=$out['DB']['Resource'][0]['ResourceLink'];?>" size="90">

							<br>

							<?=lang('Resource.featured.ResourceAlias')?>:<br/>

							<input type="text" name="Resource<?=DTR?>ResourceAlias" value="<?=$out['DB']['Resource'][0]['ResourceAlias'];?>" size="70" id="ResourceAlias" onMouseDown="convertToAlias('ResourceLink','ResourceAlias')" />

							<br/>

							<?=lang('Resource.featured.ResourceReciprocalLink')?>:<br/>

							<input type="text" name="Resource<?=DTR?>ResourceReciprocalLink" value="<?=$out['DB']['Resource'][0]['ResourceReciprocalLink'];?>" size="90">

							<br>

							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>

								<?=lang('Resource.featured.ResourceIntro')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?>

								<br/>

								<textarea name="Resource<?=DTR?>ResourceIntro[<?=$langCode?>]" cols="80" rows="5"><?=getValue($out['DB']['Resource'][0]['ResourceIntro'],$langCode);?></textarea>

								<br/>

							<? } ?>	

							<br/>

							<hr size="1">		

							<!-- Icon Image -->

							<? if(!empty($out['DB']['Resource'][0]['ResourceIcon'])) { ?>

								<img src="<?=setting('urlfiles').$out['DB']['Resource'][0]['ResourceIcon']?>" border="0" />

								<br/>

								<a href="<?=setting('url').input('SID')?>/ResourceID/<?=$out['DB']['Resource'][0]['ResourceID']?>/CategoryID/<?=input('CategoryID')?>/actionMode/deletefile/fileField/ResourceIcon"><?=lang('-deleteimage')?></a>

							<? } ?>

							<br>

							<?=lang('Resource.featured.ResourceIcon')?>:<br/>

							<input size="22" type="file" name="uploadFile[ResourceIcon]" />

							<input type="hidden" name="oldUploadFile[ResourceIcon]" value="<?=$out['DB']['Resource'][0]['ResourceIcon']?>" />

							<br/>

							<? if(count($out['DB']['ResourceField'])>0) {?>

							<hr size="1">

							<br/>

							<?=lang('ResourceExtraFieldsList.resource.tip')?>:&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceTypes/ResourceType/<?=input('ResourceType')?>" target="_blank">[<?=lang('EditResourceExtraFields.resource.link')?>]</a><br/><br/>

								<?=showExtraFieldsForm($out)?>

								<hr size="1">

								<?=lang('ResourceOptionsList.resource.tip')?>:&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceTypes/ResourceType/<?=input('ResourceType')?>" target="_blank">[<?=lang('EditResourceExtraOptions.resource.link')?>]</a><br/><br/>

								<?=showExtraOptionsForm($out)?>						

							<?  } ?>		

							<hr size="1">

							<?=lang('Resource.featured.ResourcePaidRate')?>:<br/>

							<?=getReference('Resource.ResourcePaidRate','Resource'.DTR.'ResourcePaidRate',$out['DB']['Resource'][0]['ResourcePaidRate'],array('code'=>'Y'))?>

							<br/>							

							<hr size="1">

							<?=lang('Resource.featured.ResourceFeaturedOptions')?>:<br/>

							<?=getReference('Resource.ResourceFeaturedOptions','Resource'.DTR.'ResourceFeaturedOptions',$out['DB']['Resource'][0]['ResourceFeaturedOptions'],array('code'=>'Y'))?>

							<br/>							

							<hr size="1">

							<?=lang('Resource.featured.ResourceLanguages')?>:<br/>

							<?

								foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)

								{

									$languagesList[$langID]['id']=$languagesList['languageCodes'][$langID];	

									$languagesList[$langID]['value']=$langName;		

								}								

								echo getLists($languagesList,$out['DB']['Resource'][0]['ResourceLanguages'],array('name'=>'Resource'.DTR.'ResourceLanguages','type'=>'checkboxes'));	

							?>	

							<hr size="1">

							<?=lang('Resource.ResourceComments')?>:<br/>

							<textarea cols="50" rows="7" name="Resource<?=DTR?>ResourceComments"><?=$out['DB']['Resource'][0]['ResourceComments']?></textarea>

							<hr size="1">

							<? //lang('Resource.ResourceStatus')?><!-- :<br/> -->

							<? //getReference('Resource.ResourceStatus','Resource'.DTR.'ResourceStatus',$out['DB']['Resource'][0]['ResourceStatus'],array('code'=>'Y'))?>

							<!-- <br/><br/> -->

							<input type="hidden" name="Resource<?=DTR?>ResourceStatus" value="active"/>

							

							<?=lang('Resource.PermAll')?>:<br/>

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

			var fromValidator = new Validator("manageResources");

			fromValidator.addValidation("Resource<?=DTR?>ResourceCategories[]","req","<?=lang('ResourceCategories.products.tip')?>");

			fromValidator.addValidation("Resource<?=DTR?>ResourceAlias","req","<?=lang('ResourceCategoryAlias.products.tip')?>");

			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>

				fromValidator.addValidation("Resource<?=DTR?>ResourceTitle[<?=$langCode?>]","req","<?=lang('ResourceTitle.products.tip')?>");

			<? }?>

	</script>

	<? } ?>

<?=boxFooter()?>


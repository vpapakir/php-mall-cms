<? if(input('viewMode')=='view') { getBox('reservedProperty.viewReservedProperty'); } else { 
	$reservedPropertyTemplate = input('ResourceTemplate');
	$reservedPropertyType = $out['DB']['ReservedProperty'][0]['ReservedPropertyType']; if(empty($reservedPropertyType)) {$reservedPropertyType=$input['ReservedPropertyType'];}
	if(!empty($reservedPropertyType)) {$reservedPropertyTypeName = getListValue($out['DB']['ReservedPropertyTypes'],$reservedPropertyType,array('id'=>'ReservedPropertyTypeAlias','value'=>'ReservedPropertyTypeName'));}
	if(!empty($reservedPropertyTypeName)) {$reservedPropertyTypeTitle = ' > '.$reservedPropertyTypeName;}
	
	$title = lang('AddEditReservedProperty.reservedProperty.title').$reservedPropertyTypeTitle;
	$formName1 = 'getReservedPropertyTypes';
	$formName = 'manageReservedProperties';
?>  

<? if(!empty($out['DB']['ReservedProperty'][0]['ReservedPropertyID'])) { ?>
<?=boxHeader(array('title'=>$title,'tabs'=>'manageReservedProperty','formName'=>$formName,'tabslink'=>'ReservedPropertyID/'.input('ReservedPropertyID')))?>
<? } else { ?>
<?=boxHeader(array('title'=>$title))?>
<? } ?>
<? $entityID = $out['DB']['ReservedProperty'][0]['ReservedPropertyID']; $categoryID = input('CategoryID'); ?>
	<? if(!empty($input['ReservedPropertyType']) || !empty($out['DB']['ReservedProperty'][0]['ReservedPropertyType'])) { ?>
	<? /* tr> 
		<td valign=top bgcolor="#ffffff">
			<? $reservedPropertyType = $out['DB']['ReservedProperty'][0]['ReservedPropertyType']; if(empty($reservedPropertyType)) {$reservedPropertyType=$input['ReservedPropertyType'];}?>
			<?=lang('ReservedProperty.ReservedPropertyType')?>: <b><?=getListValue($out['DB']['ReservedPropertyTypes'],$reservedPropertyType,array('id'=>'ReservedPropertyTypeAlias','value'=>'ReservedPropertyTypeName'))?></b>
		</td> 
	</tr */ ?>
	<? } else { ?>
	<tr> 
	<form name="<?=$formName1?>" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="ReservedProperty<?=DTR?>ReservedPropertyID" value="<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyID']?>">
		<input type="hidden" name="ReservedPropertyID" value="<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyID']?>">
		<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id']='';	
				$options[0]['value']='- '.lang('ReservedPropertyTypeSelect.reservedProperty.tip').' -';
				echo getLists($out['DB']['ReservedPropertyTypes'],$input['ReservedPropertyType'],array('name'=>'ReservedPropertyType','id'=>'ReservedPropertyTypeAlias','value'=>'ReservedPropertyTypeName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
			?>	
		</td> 
	</form>
	</tr> 
	<? } ?>
	
	<? if(!empty($out['DB']['ReservedProperty'][0]['ReservedPropertyType']) || !empty($input['ReservedPropertyType'])) { 
	
	?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageReservedProperty" />
		<input type="hidden" name="ReservedPropertyType" value="<?=input('ReservedPropertyType')?>" />	
		<? if(empty($out['DB']['ReservedProperty'][0]['ReservedPropertyType'])) { ?>
		<input type="hidden" name="ReservedProperty<?=DTR?>ReservedPropertyType" value="<?=input('ReservedPropertyType')?>" />		
		<? } else { ?>
		<input type="hidden" name="ReservedProperty<?=DTR?>ReservedPropertyType" value="<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyType']?>">
		<? } ?>			
		<input type="hidden" name="tabLink" value="" />
		<input type="hidden" name="ReservedPropertyID" value="<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyID']?>">
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table cellspacing="0" cellpadding="4" width="100%">
		  	  		<? 
						if(!input('viewMode') || input('viewMode')=='main')
						{
							getReservedPropertyFormMainFields($out,$formName);
						}
						elseif(input('viewMode')=='resources')
						{
							getReservedPropertyFormResourcesFields($out,$formName);
						}
					?>	
					<? if(input('viewMode')!='resources'){?>
					<tr>
						<td class="subtitleline" colspan="2" align="center">
								<? if(empty($out['DB']['ReservedProperty'][0]['ReservedPropertyID'])) { ?>
								<input type="submit" value="<?=lang("-add")?>">
								<? } else { ?>
								<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.<?=$formName?>.actionMode.value='delete';confirmDelete('<?=$formName?>', '<?=lang("-deleteconfirmation")?>');">
								<? } ?>					
								&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.<?=$formName?>.actionMode.value='cancell';document.<?=$formName?>.SID.value='manageReservedProperties';submit();">
							<br/>
						</td>
					</tr>
					<? } ?>
				</table>
			</td> 
		</tr>
	</form>	
		<? if(!input('viewMode') || input('viewMode')=='main') { ?>
		<script language="JavaScript">
				var fromValidator = new Validator("<?=$formName?>");
				<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					fromValidator.addValidation("ReservedProperty<?=DTR?>ReservedPropertyTitle[<?=$langCode?>]","req","<?=lang('ReservedPropertyTitle.tip')?>");
				<? }?>
		</script>		
		<? } ?>
	<? } ?>
<?=boxFooter()?>
<? }?>

<?
	function getReservedPropertyFormMainFields($out,$formName)
	{
		$reservedPropertyType = $out['DB']['ReservedProperty'][0]['ReservedPropertyType']; if(empty($reservedPropertyType)) {$reservedPropertyType=input('ReservedPropertyType');}
	
		?>
		<? if(empty($out['DB']['ReservedProperty'][0]['ReservedPropertyID'])) { ?>
			<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
			<input type="hidden" name="actionMode" value="save" />
			<input type="hidden" name="ReservedProperty<?=DTR?>ReservedPropertyID" value="<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyID']?>">
		<? } ?>
		<input type="hidden" name="viewMode" value="resources" />
			<tr>
				<td align="center" class="subtitleline" colspan="2">
					<span class="subtitle"><?=lang('MainArea.reservedProperty.subtitle')?></span>
				</td>
			</tr>
			<tr>
				<td class="subtitle">
					<?=lang('ReservedProperty.ReservedPropertyType')?>
				</td>
				<td>
					<?=getListValue($out['DB']['ReservedPropertyTypes'],$reservedPropertyType,array('id'=>'ReservedPropertyTypeAlias','value'=>'ReservedPropertyTypeName'))?></b>
				</td>
			</tr>			
			<tr>
				<td class="subtitle">
					<?=lang('ReservedProperty.ReservedPropertyLocation')?> <?=lang('LocationSelector.core.helptip')?>
				</td>
				<td>
					<?=getFormated($out['DB']['ReservedProperty'][0]['ReservedPropertyLocation'],'Location','form',array('fieldName'=>'ReservedProperty'.DTR.'ReservedPropertyLocation','formName'=>'manageReservedProperties','editorWidth'=>550))?>
				</td>
			</tr>	
			<tr>
				<td class="subtitle">
					<?=lang('ReservedProperty.ReservedPropertyPostCode')?>
				</td>
				<td>
					<input type="text" name="ReservedProperty<?=DTR?>ReservedPropertyPostCode" size="10" value="<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyPostCode']?>">
				</td>
			</tr>			
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td valign="top" class="subtitle">
					<?=lang('ReservedProperty.ReservedPropertyAddress')?> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
				</td>
				<td>
					<textarea name="ReservedProperty<?=DTR?>ReservedPropertyAddress[<?=$langCode?>]" cols="60" rows="2"><?=getValue($out['DB']['ReservedProperty'][0]['ReservedPropertyAddress'],$langCode);?></textarea>
				</td>
			</tr>
			<? } ?>				
			<tr>
				<td class="subtitle">
					<?=lang('ReservedProperty.ReservedPropertyActionType')?>
				</td>
				<td>
					<?=getReference('ReservedProperty.ReservedPropertyActionType','ReservedProperty'.DTR.'ReservedPropertyActionType',$out['DB']['ReservedProperty'][0]['ReservedPropertyActionType'],array('code'=>'Y'))?>
				</td>
			</tr>								
			<tr>
				<td class="subtitleline" align="center" colspan="2">
					<span class="subtitle"><?=lang('TitleArea.reservedProperty.subtitle')?></span>
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<? /* tr>
				<td>
					<span class="subtitle"><?=lang('ReservedProperty.ReservedPropertyAlias')?></span>
				</td>
				<td>
					<input type="text" name="ReservedProperty<?=DTR?>ReservedPropertyAlias" value="<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyAlias'];?>" size="35">
				</td>
			</tr */ ?>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td>
					<span class="subtitle"><?=lang('ReservedProperty.ReservedPropertyTitle')?></span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
				</td>
				<td>
					<input type="text" name="ReservedProperty<?=DTR?>ReservedPropertyTitle[<?=$langCode?>]" size="80" value="<?=getValue($out['DB']['ReservedProperty'][0]['ReservedPropertyTitle'],$langCode);?>">
				</td>
			</tr>	
			<? } ?>	
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td valign="top">
					<span class="subtitle"><?=lang('ReservedProperty.ReservedPropertyIntro')?></span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
				</td>
				<td>
					<textarea name="ReservedProperty<?=DTR?>ReservedPropertyIntro[<?=$langCode?>]" cols="60" rows="5"><?=getValue($out['DB']['ReservedProperty'][0]['ReservedPropertyIntro'],$langCode);?></textarea>
				</td>
			</tr>
			<? } ?>	
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td valign="top">
					<span class="subtitle"><?=lang('ReservedProperty.ReservedPropertyContent')?></span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
				</td>
				<td>
					<textarea name="ReservedProperty<?=DTR?>ReservedPropertyContent[<?=$langCode?>]" cols="60" rows="10"><?=getValue($out['DB']['ReservedProperty'][0]['ReservedPropertyContent'],$langCode);?></textarea>
				</td>
			</tr>
			<? } ?>	
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td valign="top">
					<span class="subtitle"><?=lang('ReservedProperty.ReservedPropertyKeywords')?></span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
				</td>
				<td>
					<textarea name="ReservedProperty<?=DTR?>ReservedPropertyKeywords[<?=$langCode?>]" cols="35" rows="5"><?=getValue($out['DB']['ReservedProperty'][0]['ReservedPropertyKeywords'],$langCode);?></textarea>
				</td>
			</tr>	
			<? } ?>															
			<tr>
				<td>
					<span class="subtitle"><?=lang('ReservedProperty.ReservedPropertyPrice')?></span>
				</td>
				<td>
					<?=getFormated($out['DB']['ReservedProperty'][0]['ReservedPropertyPrice'],'Money','form',array('fieldName'=>'ReservedProperty'.DTR.'ReservedPropertyPrice','currency'=>$out['DB']['ReservedProperty'][0]['ReservedPropertyCurrency'],'currencyMode'=>'noCurrency'))?> - <?=getFormated($out['DB']['ReservedProperty'][0]['ReservedPropertyMaxPrice'],'Money','form',array('fieldName'=>'ReservedProperty'.DTR.'ReservedPropertyMaxPrice','currency'=>$out['DB']['ReservedProperty'][0]['ReservedPropertyCurrency'],'currencyFieldName'=>'ReservedProperty'.DTR.'ReservedPropertyCurrency'))?>
				</td>
			</tr>
			<tr>
				<td class="subtitle" valign="top">
					<?=lang('ReservedProperty.ReservedPropertyPriceComments')?>
				</td>
				<td>
					<?=getReference('ReservedProperty.ReservedPropertyPriceComments','ReservedProperty'.DTR.'ReservedPropertyPriceComments',$out['DB']['ReservedProperty'][0]['ReservedPropertyPriceComments'],array('code'=>'Y'))?>
				</td>
			</tr>					
			<tr>
				<td class="subtitleline" align="center" colspan="2">
					<span class="subtitle"><?=lang('ImagesArea.reservedProperty.subtitle')?></span>
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td class="subtitle" valign="top"><?=lang('ReservedProperty.ReservedPropertyIcon')?></td>
				<td>
					<input type="hidden" name="fileField"/>
					<? $fieldName = 'ReservedPropertyIcon';  echo getFormated($out['DB']['ReservedProperty'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
				</td>
			</tr>
			<tr>
				<td class="subtitle" valign="top"><?=lang('ReservedProperty.ReservedPropertyImagePreview')?></td>
				<td>
					<? $fieldName = 'ReservedPropertyImagePreview';  echo getFormated($out['DB']['ReservedProperty'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
				</td>
			</tr>			
			<tr>
				<td class="subtitle" valign="top"><?=lang('ReservedProperty.ReservedPropertyImage')?></td>
				<td>
					<? $fieldName = 'ReservedPropertyImage';  echo getFormated($out['DB']['ReservedProperty'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
				</td>
			</tr>
			<tr>
				<td class="subtitleline" colspan="2" align="center">
					<span class="subtitle"><?=lang('ExtraFieldsArea.reservedProperty.subtitle')?></span> <a href="<?=setting('url')?>manageReservedPropertyTypes/ReservedPropertyType/<?=input('ReservedPropertyType')?>" target="_blank">[<?=lang('EditReservedPropertyExtraFields.reservedProperty.link')?>]</a>
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<? if(count($out['DB']['ReservedPropertyField'])>0) {?>
			<?=showExtraFieldsForm($out)?>
			<tr>
				<td class="subtitleline" colspan="2" align="center">
					<span class="subtitle"><?=lang('ReservedPropertyOptionsList.reservedProperty.tip')?></span> <a href="<?=setting('url')?>manageReservedPropertyTypes/ReservedPropertyType/<?=input('ReservedPropertyType')?>" target="_blank">[<?=lang('EditReservedPropertyExtraOptions.reservedProperty.link')?>]</a>
				</td>
			</tr>
			<?=showExtraOptionsForm($out)?>
			<?  } ?>	
			<tr>
				<td valign="top">
					<span class="subtitle"><?=lang('ReservedProperty.tip.ReservedPropertyFeaturedOptions')?></span>
				</td>
				<td>
					<?=getReference('ReservedProperty.ReservedPropertyFeaturedOptions','ReservedProperty'.DTR.'ReservedPropertyFeaturedOptions',$out['DB']['ReservedProperty'][0]['ReservedPropertyFeaturedOptions'],array('code'=>'Y'))?>
				</td>
			</tr>			
			<? /* if(!empty($out['DB']['ReservedProperty'][0]['ReservedPropertyID'])) { ?>	
			<tr>
				<td>
					<?=lang('RelatedReservedPropertyList.reservedProperty.tip')?>
					<br/><br/>
					<a href="<?=setting('url')?>addRelatedReservedProperty/ReservedPropertyID/<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyID']?>/CategoryID/<?=input('CategoryID')?>/ReservedPropertyType/<?=input('ReservedPropertyType')?>/"><?=lang('AddRelatedReservedProperty.reservedProperty.link')?></a>
					<br/><br/>
				</td>
			</tr>
				<? if(is_array($out['DB']['ReservedPropertyRelations'])) { ?>
					<? foreach($out['DB']['ReservedPropertyRelations'] as $relatedRow) {?>
						<tr>
							<td>
								<?=getValue($relatedRow['ReservedPropertyTitle'])?>
							</td>
							<td>
								<a href="<?=setting('url').input('SID')?>/actionMode/deleterelated/ReservedPropertyRelation<?=DTR?>ReservedPropertyRelationID/<?=$relatedRow['ReservedPropertyRelationID']?>/ReservedPropertyID/<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyID']?>/CategoryID/<?=input('CategoryID')?>/ReservedPropertyType/<?=input('ReservedPropertyType')?>">[<?=lang('DeleteRelatedReservedProperty.reservedProperty.link')?>]</a>
							</td>
						</tr>

					<? } ?>
				<? } ?>
			<? } */ ?>							
			
			<? if(count($out['DB']['Languages']['languageNames'])>1) { ?>
				<tr>
					<td>
						<span class="subtitle"><?=lang('ReservedProperty.ReservedPropertyLanguages')?></span>
					</td>
					<td>
						<?
							foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)
							{
								$languagesList[$langID]['id']=$languagesList['languageCodes'][$langID];	
								$languagesList[$langID]['value']=$langName;		
							}								
							echo getLists($languagesList,$out['DB']['ReservedProperty'][0]['ReservedPropertyLanguages'],array('name'=>'ReservedProperty'.DTR.'ReservedPropertyLanguages','type'=>'checkboxes','delimiter'=>' '));	
						?>
					</td>
				</tr>														
			<? } ?>							
			<? /*span class="subtitle"><?=lang('ReservedProperty.ReservedPropertyStatus')?>:</span><br/>
			<? if(empty($out['DB']['ReservedProperty'][0]['ReservedPropertyStatus'])) { $out['DB']['ReservedProperty'][0]['ReservedPropertyStatus'] = 'active';} ?>
			<?=getReference('ReservedProperty.ReservedPropertyStatus','ReservedProperty'.DTR.'ReservedPropertyStatus',$out['DB']['ReservedProperty'][0]['ReservedPropertyStatus'],array('code'=>'Y'))?>
			<br/><br/ */?>
			<tr>
				<td class="subtitleline" colspan="2" align="center">
					<span class="subtitle"><?=lang('StatusesArea.reservedProperty.subtitle')?></span>
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td class="subtitle">
					<?=lang('ReservedProperty.ReservedPropertyStatus')?>
				</td>
				<td>
					<? if(empty($out['DB']['ReservedProperty'][0]['ReservedPropertyStatus'])) {$out['DB']['ReservedProperty'][0]['ReservedPropertyStatus']='active';} ?>
					<?=getReference('ReservedProperty.ReservedPropertyStatus','ReservedProperty'.DTR.'ReservedPropertyStatus',$out['DB']['ReservedProperty'][0]['ReservedPropertyStatus'],array('code'=>'Y'))?>
				</td>
			</tr>			
			
			<tr>
				<td>
					<span class="subtitle"><?=lang('ReservedProperty.PermAll')?></span>
				</td>
				<td>
					<? if(empty($out['DB']['ReservedProperty'][0]['PermAll'])) {$out['DB']['ReservedProperty'][0]['PermAll']=1;} ?>
					<?=getReference('PermAll','ReservedProperty'.DTR.'PermAll',$out['DB']['ReservedProperty'][0]['PermAll'],array('code'=>'Y'))?>
				</td>
			</tr>
		<?
	}
	
	function getReservedPropertyFormResourcesFields($out,$formName)
	{	
			?>
		<? if(empty($out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceID'])) { ?>
			<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
			<input type="hidden" name="actionMode" value="save" />
		<? } ?>	
		<input type="hidden" name="viewMode" value="resources" />
		<input type="hidden" name="ReservedPropertyResource<?=DTR?>ReservedPropertyResourceID" size="80" value="<?=$out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceID']?>">	
		<input type="hidden" name="ReservedProperty<?=DTR?>ReservedPropertyStatus" value="<?=$out['DB']['ReservedProperty'][0]['ReservedPropertyStatus']?>">
		<input type="hidden" name="ReservedProperty<?=DTR?>PermAll" value="<?=$out['DB']['ReservedProperty'][0]['PermAll']?>">

			<!-- <tr>
				<td align="left" valign="top">
					<span class="subtitle"><?=lang('ReservedPropertyResource.ReservedPropertyResourceParentID')?>:&nbsp;</span>
				</td>
				<td align="left" valign="top">
					<?
						/*$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['ReservedPropertyResourcies']['result']))
						{
							foreach($out['DB']['ReservedPropertyResourcies']['result'] as $row)
							{
								if ($row['ReservedPropertyResourceID']!=$out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceID'])
								{
									$i++;
									$options[$i]['id']=$row['ReservedPropertyResourcePosition']+1;	
									$options[$i]['value']=getValue($row['ReservedPropertyResourceName'],setting('lang'));
								}
							}
						}

						echo getLists('',$out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceParentID'],array('name'=>'ReservedPropertyResource'.DTR.'ReservedPropertyResourceParentID','id'=>'id','value'=>'value','options'=>$options));	
						$options='';*/
					?>
				</td>
			</tr> -->
			<tr>
				<?
					$types = getReference('ReservedPropertyResourceType','','',array('type'=>'array','code'=>'Y'));
				?>
				<td width="20%">&nbsp;</td>
				<td width="80%">
					<table border="0" cellspacing="0" cellpadding="0">
						<tr>
							<? foreach($types as $typeValue) {?>
							<td>
								<a href="<?=setting('url').input('SID')?>/ReservedPropertyID/<?=input('ReservedPropertyID')?>/viewMode/resources/ReservedPropertyResourceType/<?=$typeValue['id']?>"><?=lang('addNew.reservedProperty.link').' '.getValue($typeValue['value'])?></a>
							</td>
							<td>&nbsp;</td>
							<? } ?>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="subtitle">
					<?=lang('ReservedPropertyResource.ReservedPropertyResourceType')?>
				</td>
				<td>
					<? 
						if(!empty($out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceType']))
						{
							$v=$out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceType'];
						}
							elseif(input('ReservedPropertyResourceType')!='')
									{
										$v=input('ReservedPropertyResourceType');
										echo $input['ReservedPropertyResourceType'];
									}
									else
										{
											$v="photo";
										}
					?>
					<?=getReference('ReservedPropertyResourceType','ReservedPropertyResource'.DTR.'ReservedPropertyResourceType',$v,array('code'=>'Y'))?>
				</td>
			</tr>
			<tr>
				<td class="subtitle"><?=lang('ReservedPropertyResource.ReservedPropertyResourceIcon')?></td>
				<td>
					<input type="hidden" name="fileField"/>
					<? $fieldName = 'ReservedPropertyResourceIcon';  echo getFormated($out['DB']['ReservedPropertyResource'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'limitsStringMode'=>'N','deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.forms.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
				</td>
			</tr>			
			<!-- <tr>	
				<td>
					<? //lang('ReservedPropertyResource.ReservedPropertyResourceCode')?>
				</td>
				<td>
					<input type="text" name="ReservedPropertyResource<?=DTR?>ReservedPropertyResourceCode" size="80" value="<?=$out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceCode']?>">
				</td>
			</tr> -->
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>	
				<td class="subtitle">
					<?=lang('ReservedPropertyResource.ReservedPropertyResourceName')?>
					<?=$out['DB']['Languages']['languageNames'][$langID]?>
				</td>
				<td>
					<input type="text" name="ReservedPropertyResource<?=DTR?>ReservedPropertyResourceName[<?=$langCode?>]" size="56" value="<?=getValue($out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceName'],$langCode);?>">
				</td>
			</tr>
			<? } ?>	
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td valign="top" class="subtitle">
					<?=lang('ReservedPropertyResource.ReservedPropertyResourceDescription')?>
					<?=$out['DB']['Languages']['languageNames'][$langID]?>
				</td>
				<td>
					<textarea name="ReservedPropertyResource<?=DTR?>ReservedPropertyResourceDescription[<?=$langCode?>]" cols="35" rows="2"><?=getValue($out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceDescription'],$langCode);?></textarea>
				</td>
			</tr>
			<? } ?>				
			<tr>	
				<td class="subtitle">
					<?=lang('ReservedPropertyResource.ReservedPropertyResourceArea')?>
				</td>
				<td>
					<input type="text" name="ReservedPropertyResource<?=DTR?>ReservedPropertyResourceArea" size="15" value="<?=$out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceArea']?>">
				</td>
			</tr>
			<tr>
				<td align="left" valign="top" class="subtitle">
					<?=lang('-addafter')?>:
				</td>
				<td align="left" valign="top">
					<? if(!empty($out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceType']))
						{
							$type=$out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceType'];
						}
							elseif(input('ReservedPropertyResourceType')!='')
									{
										$type=input('ReservedPropertyResourceType');
									}
									else
										{
											$type="photo";
										}
					?>
					<?
							$options[0]['id']='1';	
							$options[0]['value']='- '.lang('-first').' -';
							if(is_array($out['DB']['ReservedPropertyResourcies'][$type]))
							{
								foreach($out['DB']['ReservedPropertyResourcies'][$type] as $row)
								{
									if ($row['ReservedPropertyResourceID']!=$out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceID'])
									{
										$i++;
										$options[$i]['id']=$row['ReservedPropertyResourcePosition']+1;	
										$name = getValue($row['ReservedPropertyResourceName'],setting('lang'));
										if(!empty($name)) {$options[$i]['value']= $name;}
										else {$options[$i]['value']= lang('-item').' '.$i;}
									}
								}
							}
						echo getLists('',$out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourcePosition']-1,array('name'=>'ReservedPropertyResource'.DTR.'ReservedPropertyResourcePosition','id'=>'id','value'=>'value','options'=>$options));	
						$options='';
					?>
				</td>
			</tr>
			<tr>
				<td class="subtitleline" colspan="2" align="center">
					<? if(empty($out['DB']['ReservedPropertyResource'][0]['ReservedPropertyResourceID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.<?=$formName?>.actionMode.value='delete';confirmDelete('<?=$formName?>', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>
					&nbsp;&nbsp;<input type="button" value="<?=lang("SaveToNextStep.reservedProperty.button")?>" onClick="document.<?=$formName?>.actionMode.value='save';document.<?=$formName?>.viewMode.value='view';submit();">
				</td>
			</tr>		
			<tr> 
				<td valign="top" colspan="2" align="center">
				<? if(is_array($types) && count($out['DB']['ReservedPropertyResourcies'])>0){ 
					foreach($types as $value){  $typeCode = $value['id'];?>
					<? if(is_array($out['DB']['ReservedPropertyResourcies'][$typeCode])){ $total = count($out['DB']['ReservedPropertyResourcies'][$typeCode]);?>
						<table class="subtitleline" width="100%" align="center">
							<tr>
								<td class="subtitle" align="center"><?=getValue($value['value'])?></td>
							</tr>
						</table>
						<table border="0" cellspacing="1" cellpadding="1">
							<tr>
							<? $i=0; $k=0; foreach($out['DB']['ReservedPropertyResourcies'][$typeCode] as $id=>$row) {  $i++; $k++;?>
								<td valign="top" align="center" width="150">
									<a href="<?=setting('url').input('SID')?>/ReservedPropertyID/<?=input('ReservedPropertyID')?>/ReservedPropertyResourceID/<?=$row['ReservedPropertyResourceID']?>/viewMode/resources"><?=getValue($row['ReservedPropertyResourceName'])?></a>
									<br/>
									<? if(!empty($row['ReservedPropertyResourceIcon'])){?>
										<a href="javascript://" onClick="popup('<?=setting('url')?>viewReservedPropertyResource/ReservedPropertyResourceID/<?=$row['ReservedPropertyResourceID']?>/windowMode/popup/')" class="image"><img src="<?=setting('urlfiles').$row['ReservedPropertyResourceIcon']?>" border="0"/></a>
										<br/>
									<? }?>
									<? if(!empty($row['ReservedPropertyResourceDescription'])) { ?>
									<?=getFormated($row['ReservedPropertyResourceDescription'],'TEXT')?>
									<br/>
									<? } ?>
									
									<?
									$ReservedPropertyResourcePositionUp = $row['ReservedPropertyResourcePosition'] - 3;
									$ReservedPropertyResourcePositionDown = $row['ReservedPropertyResourcePosition'] + 3;
									?>
									<a href="<?=setting('url').input('SID')?>/ReservedPropertyID/<?=input('ReservedPropertyID')?>/ReservedPropertyResource<?=DTR?>ReservedPropertyResourceID/<?=$row['ReservedPropertyResourceID']?>/ReservedPropertyResource<?=DTR?>ReservedPropertyResourcePosition/<?=$ReservedPropertyResourcePositionUp?>/actionMode/updateposition/viewMode/resources">&lt;</a>
									<a href="<?=setting('url').input('SID')?>/ReservedPropertyID/<?=input('ReservedPropertyID')?>/ReservedPropertyResourceID/<?=$row['ReservedPropertyResourceID']?>/viewMode/resources"><?=lang('-edit')?></a>
									<a href="<?=setting('url').input('SID')?>/ReservedPropertyID/<?=input('ReservedPropertyID')?>/ReservedPropertyResource<?=DTR?>ReservedPropertyResourceID/<?=$row['ReservedPropertyResourceID']?>/ReservedPropertyResource<?=DTR?>ReservedPropertyResourcePosition/<?=$ReservedPropertyResourcePositionDown?>/actionMode/updateposition/viewMode/resources">&gt;</a>
								</td>
								<? if($i==4 && $k!=$total) { $i=0; ?>
							</tr>	
						</table>		
						<table border="0" cellspacing="1" cellpadding="1">
							<tr>
								<? } ?>
								<? } ?>					
							</tr>	
						</table>				
					<? } ?>
					<? } ?>
					<table width="100%">
						<tr>
							<td class="subtitleline" align="center">
								&nbsp;&nbsp;<input type="button" value="<?=lang("SaveToNextStep.reservedProperty.button")?>" onClick="document.<?=$formName?>.actionMode.value='save';document.<?=$formName?>.viewMode.value='view';submit();">
							</td>
						</tr>
					</table>
					<? } ?>
				</td> 
			</tr>
			
		<?
	}
?>
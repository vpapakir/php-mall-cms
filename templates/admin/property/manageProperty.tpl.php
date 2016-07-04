<? if(input('viewMode')=='view') { getBox('property.viewProperty'); } else { 
	$propertyTemplate = input('ResourceTemplate');
	$propertyType = $out['DB']['Property'][0]['PropertyType']; if(empty($propertyType)) {$propertyType=$input['PropertyType'];}
	if(!empty($propertyType)) {$propertyTypeName = getListValue($out['DB']['PropertyTypes'],$propertyType,array('id'=>'PropertyTypeAlias','value'=>'PropertyTypeName'));}
	if(!empty($propertyTypeName)) {$propertyTypeTitle = ' > '.$propertyTypeName;}
	
	$title = lang('AddEditProperty.property.title').$propertyTypeTitle;
	$formName1 = 'getPropertyTypes';
	$formName = 'manageProperties';
?>  

<? if(!empty($out['DB']['Property'][0]['PropertyID'])) { ?>
<?=boxHeader(array('title'=>$title,'tabs'=>'manageProperty','formName'=>$formName,'tabslink'=>'PropertyID/'.input('PropertyID')))?>
<? } else { ?>
<?=boxHeader(array('title'=>$title))?>
<? } ?>
<? $entityID = $out['DB']['Property'][0]['PropertyID']; $categoryID = input('CategoryID'); ?>
	<? if(!empty($input['PropertyType']) || !empty($out['DB']['Property'][0]['PropertyType'])) { ?>
	<? /* tr> 
		<td valign=top bgcolor="#ffffff">
			<? $propertyType = $out['DB']['Property'][0]['PropertyType']; if(empty($propertyType)) {$propertyType=$input['PropertyType'];}?>
			<?=lang('Property.PropertyType')?>: <b><?=getListValue($out['DB']['PropertyTypes'],$propertyType,array('id'=>'PropertyTypeAlias','value'=>'PropertyTypeName'))?></b>
		</td> 
	</tr */ ?>
	<? } else { ?>
	<tr> 
	<form name="<?=$formName1?>" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="Property<?=DTR?>PropertyID" value="<?=$out['DB']['Property'][0]['PropertyID']?>">
		<input type="hidden" name="PropertyID" value="<?=$out['DB']['Property'][0]['PropertyID']?>">
		<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id']='';	
				$options[0]['value']='- '.lang('PropertyTypeSelect.property.tip').' -';
				echo getLists($out['DB']['PropertyTypes'],$input['PropertyType'],array('name'=>'PropertyType','id'=>'PropertyTypeAlias','value'=>'PropertyTypeName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
			?>	
		</td> 
	</form>
	</tr> 
	<? } ?>
	
	<? if(!empty($out['DB']['Property'][0]['PropertyType']) || !empty($input['PropertyType'])) { 
	
	?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageProperty" />
		<input type="hidden" name="PropertyType" value="<?=input('PropertyType')?>" />	
		<? if(empty($out['DB']['Property'][0]['PropertyID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="Property<?=DTR?>PropertyID" value="<?=$out['DB']['Property'][0]['PropertyID']?>">
		<? } ?>		
		<? if(empty($out['DB']['Property'][0]['PropertyType'])) { ?>
		<input type="hidden" name="Property<?=DTR?>PropertyType" value="<?=input('PropertyType')?>" />		
		<? } else { ?>
		<input type="hidden" name="Property<?=DTR?>PropertyType" value="<?=$out['DB']['Property'][0]['PropertyType']?>">
		<? } ?>			
		<input type="hidden" name="tabLink" value="" />
		<input type="hidden" name="PropertyID" value="<?=$out['DB']['Property'][0]['PropertyID']?>">

		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table cellspacing="0" cellpadding="4" width="100%">
		  	  		<? 
						if(!input('viewMode') || input('viewMode')=='main')
						{
							getPropertyFormMainFields($out);
						}
						elseif(input('viewMode')=='resources')
						{
							getPropertyFormResourcesFields($out);
						}
					?>	
									
					<tr>
						<td class="subtitleline" colspan="2" align="center">
							<? if(input('viewMode')!='resources'){?>
								<? if(empty($out['DB']['Property'][0]['PropertyID'])) { ?>
								<input type="submit" value="<?=lang("-add")?>">
								<? } else { ?>
								<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.<?=$formName?>.actionMode.value='delete';confirmDelete('<?=$formName?>', '<?=lang("-deleteconfirmation")?>');">
								<? } ?>					
								&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.<?=$formName?>.actionMode.value='cancell';submit();">
							<? }else{?>
								<? if(empty($out['DB']['PropertyResource'][0]['PropertyResourceID'])) { ?>
								<input type="submit" value="<?=lang("-add")?>">
								<? } else { ?>
								<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.<?=$formName?>.actionMode.value='delete';confirmDelete('<?=$formName?>', '<?=lang("-deleteconfirmation")?>');">
								<? } ?>
								&nbsp;&nbsp;<input type="button" value="<?=lang("SaveToNextStep.property.button")?>" onClick="document.<?=$formName?>.actionMode.value='save';document.<?=$formName?>.viewMode.value='view';submit();">
							<? }?>
							<br/>
						</td>
					</tr>
				</table>
			</td> 
		</tr>
		<? if(input('viewMode')=='resources'){?>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td align="center" class="subtitleline" colspan="2">
					<span class="subtitle"><?=lang('PropertyResourcies.property.subtitle')?></span>
				</td>
			</tr>
			<tr> 
				<td valign="top" bgcolor="#ffffff">
				<? foreach($out['DB']['Reference'] as $value){?>
					<? if(is_array($out['DB']['PropertyResourcies'][$value['OptionCode']]))
						{ 
							$t[$value['OptionCode']] = count($out['DB']['PropertyResourcies'][$value['OptionCode']]);?>
					 <? }
					}
				?>
				<? if(is_array($t)){foreach($out['DB']['Reference'] as $value){?>
					<? if(is_array($out['DB']['PropertyResourcies'][$value['OptionCode']])){ $total = count($out['DB']['PropertyResourcies'][$value['OptionCode']]);?>
					<br/><br/>
					<table class="subtitleline" width="100%" align="center">
						<tr>
							<td class="subtitle" align="center"><?=getValue($value['OptionName'])?></td>
						</tr>
					</table>
					<table border="0" cellspacing="1" cellpadding="0">
						<tr>
						<?  foreach($out['DB']['PropertyResourcies'][$value['OptionCode']] as $id=>$row) {  
									$i++; $k++;?>
							<td valign="top" width="100" align="center">
								<img src="<?=setting('layout')?>images/_clear.gif" width="100" height="1">
								<table cellpadding="0" cellspacing="2" border="0" width="100%">
									<!-- <tr>
										<td height="30" align="center" valign="top">
											<a href="<?=setting('url').input('SID')?>/PropertyID/<?=input('PropertyID')?>/PropertyResourceID/<?=$row['PropertyResourceID']?>/viewMode/resources"><?=getValue($row['PropertyResourceName'])?></a>
										</td>
									</tr> -->
									<tr>
										<td align="center" valign="top">
											<a href="<?=setting('url').input('SID')?>/PropertyID/<?=input('PropertyID')?>/PropertyResourceID/<?=$row['PropertyResourceID']?>/viewMode/resources"><?=getValue($row['PropertyResourceName'])?></a>
											<br/>
											<? if(!empty($row['PropertyResourceIcon'])){?>
												<a href="javascript://" onClick="popup('<?=setting('urlfiles').$row['PropertyResourceImage']?>')"><img src="<?=setting('urlfiles').$row['PropertyResourceIcon']?>" border="0"/></a>
												<br/>
											<? }?>
											<?=getValue($row['PropertyResourceDescription'])?>
											<br/>
											<a href="<?=setting('url').input('SID')?>/PropertyID/<?=input('PropertyID')?>/PropertyResourceID/<?=$row['PropertyResourceID']?>/viewMode/resources"><?=lang('-edit')?></a>
										</td>
									</tr>
								</table>
							</td>
						<? if($i==4 && $k!=$total) { $i=0; ?>
						</tr>	
						<TR>
							<TD align="center" valign="top">
								<?
								echo $temp_store['1'];
								$temp_store['1']="";
								?>
							</TD>
							<TD align="center" valign="top">
								<?
									echo $temp_store['2'];
									 $temp_store['2']="";
								?>
							</TD>
							<TD align="center" valign="top">
								<?
									echo $temp_store['3'];
									$temp_store['3']="";
								?>
							</TD>
							<TD align="center" valign="top">
								<?
									echo $temp_store['4'];
									$temp_store['4']="";
								?>
							</TD>
						</TR>
					</table>		
					<br/>
					<table border="0" cellspacing="1" cellpadding="0">
						<tr>
							<? } ?>
							<? }?>					
						</tr>	
						<TR>
							<TD align="center" valign="top">
								<?
									echo $temp_store['1'];
								?>
							</TD>
							<TD align="center" valign="top">
								<?
									echo $temp_store['2'];
								?>
							</TD>
							<TD align="center" valign="top">
								<?
									echo $temp_store['3'];
								?>
							</TD>
							<TD align="center" valign="top">
								<?
									echo $temp_store['4'];
								?>
							</TD>
						</TR>
					</table>		
					<table width="100%">
						<tr>
							<td class="subtitleline" align="center">
								&nbsp;&nbsp;<input type="button" value="<?=lang("SaveToNextStep.property.button")?>" onClick="document.<?=$formName?>.actionMode.value='save';document.<?=$formName?>.viewMode.value='view';submit();">
							</td>
						</tr>
					</table>
					<? }}}else{ ?>
						<table width="100%">
							<tr>
								<td align="center">
									<br/><br/>
									<?=lang('NoPropertyResourceFound.property.tip')?>
									<br/><br/>
								</td>
							</tr>	
						</table>
					<? }?>		
				</td> 
			</tr>
		<? }?> 
	</form>	
		<? if(!input('viewMode') || input('viewMode')=='main') { ?>
		<script language="JavaScript">
				var fromValidator = new Validator("<?=$formName?>");
				<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					fromValidator.addValidation("Property<?=DTR?>PropertyTitle[<?=$langCode?>]","req","<?=lang('PropertyTitle.tip')?>");
				<? }?>
		</script>		
		<? } ?>
	<? } ?>
<?=boxFooter()?>
<? }?>

<?
	function getPropertyFormMainFields($out)
	{
		$propertyType = $out['DB']['Property'][0]['PropertyType']; if(empty($propertyType)) {$propertyType=input('PropertyType');}
	
		?>
		<input type="hidden" name="viewMode" value="resources" />
			<tr>
				<td align="center" class="subtitleline" colspan="2">
					<span class="subtitle"><?=lang('MainArea.property.subtitle')?></span>
				</td>
			</tr>
			<tr>
				<td class="subtitle">
					<?=lang('Property.PropertyType')?>
				</td>
				<td>
					<?=getListValue($out['DB']['PropertyTypes'],$propertyType,array('id'=>'PropertyTypeAlias','value'=>'PropertyTypeName'))?></b>
				</td>
			</tr>			
			<tr>
				<td class="subtitle">
					<?=lang('Property.PropertyLocation')?>
				</td>
				<td>
					<?=getFormated($out['DB']['Property'][0]['PropertyLocation'],'Location','form',array('fieldName'=>'Property'.DTR.'PropertyLocation','formName'=>'manageProperties','editorWidth'=>550))?>
				</td>
			</tr>	
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td valign="top" class="subtitle">
					<?=lang('Property.PropertyAddress')?> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
				</td>
				<td>
					<textarea name="Property<?=DTR?>PropertyAddress[<?=$langCode?>]" cols="60" rows="2"><?=getValue($out['DB']['Property'][0]['PropertyAddress'],$langCode);?></textarea>
				</td>
			</tr>
			<? } ?>				
			<tr>
				<td class="subtitle">
					<?=lang('Property.PropertyActionType')?>
				</td>
				<td>
					<?=getReference('Property.PropertyActionType','Property'.DTR.'PropertyActionType',$out['DB']['Property'][0]['PropertyActionType'],array('code'=>'Y'))?>
				</td>
			</tr>								
			<tr>
				<td class="subtitleline" align="center" colspan="2">
					<span class="subtitle"><?=lang('TitleArea.property.subtitle')?></span>
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<? /* tr>
				<td>
					<span class="subtitle"><?=lang('Property.PropertyAlias')?></span>
				</td>
				<td>
					<input type="text" name="Property<?=DTR?>PropertyAlias" value="<?=$out['DB']['Property'][0]['PropertyAlias'];?>" size="35">
				</td>
			</tr */ ?>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td>
					<span class="subtitle"><?=lang('Property.PropertyTitle')?></span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
				</td>
				<td>
					<input type="text" name="Property<?=DTR?>PropertyTitle[<?=$langCode?>]" size="80" value="<?=getValue($out['DB']['Property'][0]['PropertyTitle'],$langCode);?>">
				</td>
			</tr>	
			<? } ?>	
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td valign="top">
					<span class="subtitle"><?=lang('Property.PropertyIntro')?></span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
				</td>
				<td>
					<textarea name="Property<?=DTR?>PropertyIntro[<?=$langCode?>]" cols="60" rows="5"><?=getValue($out['DB']['Property'][0]['PropertyIntro'],$langCode);?></textarea>
				</td>
			</tr>
			<? } ?>	
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td valign="top">
					<span class="subtitle"><?=lang('Property.PropertyContent')?></span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
				</td>
				<td>
					<textarea name="Property<?=DTR?>PropertyContent[<?=$langCode?>]" cols="60" rows="10"><?=getValue($out['DB']['Property'][0]['PropertyContent'],$langCode);?></textarea>
				</td>
			</tr>
			<? } ?>	
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td valign="top">
					<span class="subtitle"><?=lang('Property.PropertyKeywords')?></span> <? if(count($out['DB']['Languages']['languageCodes'])>1) echo ':'.$out['DB']['Languages']['languageNames'][$langID];?>
				</td>
				<td>
					<textarea name="Property<?=DTR?>PropertyKeywords[<?=$langCode?>]" cols="35" rows="5"><?=getValue($out['DB']['Property'][0]['PropertyKeywords'],$langCode);?></textarea>
				</td>
			</tr>	
			<? } ?>															
			 <tr>
				<td>
					<span class="subtitle"><?=lang('Property.PropertyPrice')?></span>
				</td>
				<td>
					<?=getFormated($out['DB']['Property'][0]['PropertyPrice'],'Money','form',array('fieldName'=>'Property'.DTR.'PropertyPrice'))?>
				</td>
			</tr>
			<tr>
				<td class="subtitleline" align="center" colspan="2">
					<span class="subtitle"><?=lang('ImagesArea.property.subtitle')?></span>
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<tr>
				<td class="subtitle" valign="top"><?=lang('Property.PropertyIcon')?></td>
				<td>
					<input type="hidden" name="fileField"/>
					<? $fieldName = 'PropertyIcon';  echo getFormated($out['DB']['Property'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
				</td>
			</tr>
			<tr>
				<td class="subtitle" valign="top"><?=lang('Property.PropertyImagePreview')?></td>
				<td>
					<? $fieldName = 'PropertyImagePreview';  echo getFormated($out['DB']['Property'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
				</td>
			</tr>			
			<tr>
				<td class="subtitle" valign="top"><?=lang('Property.PropertyImage')?></td>
				<td>
					<? $fieldName = 'PropertyImage';  echo getFormated($out['DB']['Property'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
				</td>
			</tr>
			<tr>
				<td class="subtitleline" colspan="2" align="center">
					<span class="subtitle"><?=lang('ExtraFieldsArea.property.subtitle')?></span> <a href="<?=setting('url')?>managePropertyTypes/PropertyType/<?=input('PropertyType')?>" target="_blank">[<?=lang('EditPropertyExtraFields.property.link')?>]</a>
				</td>
			</tr>
			<tr><td>&nbsp;</td></tr>
			<? if(count($out['DB']['PropertyField'])>0) {?>
			<?=showExtraFieldsForm($out)?>
			<tr>
				<td class="subtitleline" colspan="2" align="center">
					<span class="subtitle"><?=lang('PropertyOptionsList.property.tip')?></span> <a href="<?=setting('url')?>managePropertyTypes/PropertyType/<?=input('PropertyType')?>" target="_blank">[<?=lang('EditPropertyExtraOptions.property.link')?>]</a>
				</td>
			</tr>
			<?=showExtraOptionsForm($out)?>
			<?  } ?>	
			<tr>
				<td valign="top">
					<span class="subtitle"><?=lang('Property.tip.PropertyFeaturedOptions')?></span>
				</td>
				<td>
					<?=getReference('Property.PropertyFeaturedOptions','Property'.DTR.'PropertyFeaturedOptions',$out['DB']['Property'][0]['PropertyFeaturedOptions'],array('code'=>'Y'))?>
				</td>
			</tr>			
			<? /* if(!empty($out['DB']['Property'][0]['PropertyID'])) { ?>	
			<tr>
				<td>
					<?=lang('RelatedPropertyList.property.tip')?>
					<br/><br/>
					<a href="<?=setting('url')?>addRelatedProperty/PropertyID/<?=$out['DB']['Property'][0]['PropertyID']?>/CategoryID/<?=input('CategoryID')?>/PropertyType/<?=input('PropertyType')?>/"><?=lang('AddRelatedProperty.property.link')?></a>
					<br/><br/>
				</td>
			</tr>
				<? if(is_array($out['DB']['PropertyRelations'])) { ?>
					<? foreach($out['DB']['PropertyRelations'] as $relatedRow) {?>
						<tr>
							<td>
								<?=getValue($relatedRow['PropertyTitle'])?>
							</td>
							<td>
								<a href="<?=setting('url').input('SID')?>/actionMode/deleterelated/PropertyRelation<?=DTR?>PropertyRelationID/<?=$relatedRow['PropertyRelationID']?>/PropertyID/<?=$out['DB']['Property'][0]['PropertyID']?>/CategoryID/<?=input('CategoryID')?>/PropertyType/<?=input('PropertyType')?>">[<?=lang('DeleteRelatedProperty.property.link')?>]</a>
							</td>
						</tr>

					<? } ?>
				<? } ?>
			<? } */ ?>							
			
			<? if(count($out['DB']['Languages']['languageNames'])>1) { ?>
				<tr>
					<td>
						<span class="subtitle"><?=lang('Property.PropertyLanguages')?></span>
					</td>
					<td>
						<?
							foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)
							{
								$languagesList[$langID]['id']=$languagesList['languageCodes'][$langID];	
								$languagesList[$langID]['value']=$langName;		
							}								
							echo getLists($languagesList,$out['DB']['Property'][0]['PropertyLanguages'],array('name'=>'Property'.DTR.'PropertyLanguages','type'=>'checkboxes','delimiter'=>' '));	
						?>
					</td>
				</tr>														
			<? } ?>							
			<? /*span class="subtitle"><?=lang('Property.PropertyStatus')?>:</span><br/>
			<? if(empty($out['DB']['Property'][0]['PropertyStatus'])) { $out['DB']['Property'][0]['PropertyStatus'] = 'active';} ?>
			<?=getReference('Property.PropertyStatus','Property'.DTR.'PropertyStatus',$out['DB']['Property'][0]['PropertyStatus'],array('code'=>'Y'))?>
			<br/><br/ */?>
			<tr>
				<td class="subtitleline" colspan="2" align="center">
					<span class="subtitle"><?=lang('StatusesArea.property.subtitle')?></span>
				</td>
			</tr>
			<tr><td colspan="2">&nbsp;</td></tr>
			<tr>
				<td class="subtitle">
					<?=lang('Property.PropertyStatus')?>
				</td>
				<td>
					<? if(empty($out['DB']['Property'][0]['PropertyStatus'])) {$out['DB']['Property'][0]['PropertyStatus']='active';} ?>
					<?=getReference('Property.PropertyStatus','Property'.DTR.'PropertyStatus',$out['DB']['Property'][0]['PropertyStatus'],array('code'=>'Y'))?>
				</td>
			</tr>			
			
			<tr>
				<td>
					<span class="subtitle"><?=lang('Property.PermAll')?></span>
				</td>
				<td>
					<? if(empty($out['DB']['Property'][0]['PermAll'])) {$out['DB']['Property'][0]['PermAll']=1;} ?>
					<?=getReference('PermAll','Property'.DTR.'PermAll',$out['DB']['Property'][0]['PermAll'],array('code'=>'Y'))?>
				</td>
			</tr>
		<?
	}
	
	function getPropertyFormResourcesFields($out)
	{	
			?>
		<? if(empty($out['DB']['PropertyResource'][0]['PropertyResourceID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<? } ?>	
		<input type="hidden" name="viewMode" value="resources" />
		<input type="hidden" name="PropertyResource<?=DTR?>PropertyResourceID" size="80" value="<?=$out['DB']['PropertyResource'][0]['PropertyResourceID']?>">	
		<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<input type="hidden" name="Property<?=DTR?>PropertyTitle[<?=$langCode?>]" value="<?=getValue($out['DB']['Property'][0]['PropertyTitle'],$langCode);?>">
		<? } ?>
		<input type="hidden" name="Property<?=DTR?>PropertyStatus" value="<?=$out['DB']['Property'][0]['PropertyStatus']?>">
		<input type="hidden" name="Property<?=DTR?>PermAll" value="<?=$out['DB']['Property'][0]['PermAll']?>">

			<!-- <tr>
				<td align="left" valign="top">
					<span class="subtitle"><?=lang('PropertyResource.PropertyResourceParentID')?>:&nbsp;</span>
				</td>
				<td align="left" valign="top">
					<?
						/*$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['PropertyResourcies']['result']))
						{
							foreach($out['DB']['PropertyResourcies']['result'] as $row)
							{
								if ($row['PropertyResourceID']!=$out['DB']['PropertyResource'][0]['PropertyResourceID'])
								{
									$i++;
									$options[$i]['id']=$row['PropertyResourcePosition']+1;	
									$options[$i]['value']=getValue($row['PropertyResourceName'],setting('lang'));
								}
							}
						}

						echo getLists('',$out['DB']['PropertyResource'][0]['PropertyResourceParentID'],array('name'=>'PropertyResource'.DTR.'PropertyResourceParentID','id'=>'id','value'=>'value','options'=>$options));	
						$options='';*/
					?>
				</td>
			</tr> -->
			<tr>
				<td>&nbsp;
					
				</td>
				<td>
					<table>
						<tr>
							<td>
								<a href="<?=setting('url').input('SID')?>/PropertyID/<?=input('PropertyID')?>/PropertyResourceID/<?=$row['PropertyResourceID']?>/viewMode/resources/PropertyResourceType/photo"><?=lang('addNewFoto.property.link')?></a>
							</td>
							<td>
								<a href="<?=setting('url').input('SID')?>/PropertyID/<?=input('PropertyID')?>/PropertyResourceID/<?=$row['PropertyResourceID']?>/viewMode/resources/PropertyResourceType/file"><?=lang('addNewFile.property.link')?></a>
							</td>
							<td>
								<a href="<?=setting('url').input('SID')?>/PropertyID/<?=input('PropertyID')?>/PropertyResourceID/<?=$row['PropertyResourceID']?>/viewMode/resources/PropertyResourceType/room"><?=lang('addNewRoom.property.link')?></a>
							</td>
						</tr>
					</table>
				</td>
			</tr>
			<tr>
				<td class="subtitle">
					<?=lang('PropertyResource.PropertyResourceType')?>
				</td>
				<td>
					<? if(!empty($out['DB']['PropertyResource'][0]['PropertyResourceType']))
						{
							$v=$out['DB']['PropertyResource'][0]['PropertyResourceType'];
						}
							else
									{
										$v=input('PropertyResourceType');
									}
					?>
					<?=getReference('PropertyResourceType','PropertyResource'.DTR.'PropertyResourceType',$v,array('code'=>'Y'))?>
				</td>
			</tr>
			<!-- <tr>	
				<td>
					<? //lang('PropertyResource.PropertyResourceCode')?>
				</td>
				<td>
					<input type="text" name="PropertyResource<?=DTR?>PropertyResourceCode" size="80" value="<?=$out['DB']['PropertyResource'][0]['PropertyResourceCode']?>">
				</td>
			</tr> -->
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>	
				<td class="subtitle">
					<?=lang('PropertyResource.PropertyResourceName')?>
					<?=$out['DB']['Languages']['languageNames'][$langID]?>
				</td>
				<td>
					<input type="text" name="PropertyResource<?=DTR?>PropertyResourceName[<?=$langCode?>]" size="80" value="<?=getValue($out['DB']['PropertyResource'][0]['PropertyResourceName'],$langCode);?>">
				</td>
			</tr>
			<? } ?>	
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
			<tr>
				<td valign="top" class="subtitle">
					<?=lang('PropertyResource.PropertyResourceDescription')?>
					<?=$out['DB']['Languages']['languageNames'][$langID]?>
				</td>
				<td>
					<textarea name="PropertyResource<?=DTR?>PropertyResourceDescription[<?=$langCode?>]" cols="35" rows="3"><?=getValue($out['DB']['PropertyResource'][0]['PropertyResourceDescription'],$langCode);?></textarea>
				</td>
			</tr>
			<? } ?>	
			<tr>
				<td>&nbsp;</td>
				<td>
					<? $fieldName = 'PropertyResourceIcon';  echo getFormated($out['DB']['PropertyResource'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'limitsStringMode'=>'N','langCode'=>'PropertyResource.'.$resourceTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
				</td>
			</tr>			
			<tr>	
				<td class="subtitle">
					<?=lang('PropertyResource.PropertyResourceArea')?>
				</td>
				<td>
					<input type="text" name="PropertyResource<?=DTR?>PropertyResourceArea" size="15" value="<?=$out['DB']['PropertyResource'][0]['PropertyResourceArea']?>">
				</td>
			</tr>
			<tr>
				<td align="left" valign="top" class="subtitle">
					<?=lang('-addafter')?>:
				</td>
				<td align="left" valign="top">
					<?
						$options[0]['id']='1';	
						$options[0]['value']='- '.lang('-first').' -';
						if(is_array($out['DB']['PropertyResourcies']['result']))
						{
							foreach($out['DB']['PropertyResourcies']['result'] as $row)
							{
								if ($row['PropertyResourceID']!=$out['DB']['PropertyResource'][0]['PropertyResourceID'])
								{
									$i++;
									$options[$i]['id']=$row['PropertyResourcePosition']+1;	
									$options[$i]['value']=getValue($row['PropertyResourceName'],setting('lang'));
								}
							}
						}

						echo getLists('',$out['DB']['PropertyResource'][0]['PropertyResourcePosition'],array('name'=>'PropertyResource'.DTR.'PropertyResourcePosition','id'=>'id','value'=>'value','options'=>$options));	
						$options='';
					?>
				</td>
			</tr>
			
		<?
	}
?>
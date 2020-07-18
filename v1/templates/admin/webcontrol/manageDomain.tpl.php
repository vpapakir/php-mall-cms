<? if($input['actionMode']=='add' || $input['actionMode']=='save1' || $input['actionMode']=='cancell' || $input['actionMode']=='delete')  { ?> 
	<script language="javascript">
		//window.document.onLoad= setTimeout("goback('<?= setting('url')?>manageDomains/)");
	</script>
  <? }else{?>
<?
	$DomainType = $out['DB']['Domain'][0]['DomainType']; if(empty($DomainType)) {$DomainType=$input['DomainType'];}
	if(!empty($DomainType)) {$DomainTypeName = getListValue($out['DB']['DomainTypes'],$DomainType,array('id'=>'DomainTypeAlias','value'=>'DomainTypeName'));}
	if(!empty($DomainTypeName)) {$DomainTypeTitle = ' > '.$DomainTypeName;}
	
	//$title = lang('AddEditDomain.webcontrol.title').$DomainTypeTitle;
	$title = lang('AddEditDomain.webcontrol.title');
?>  
<? //$input['DomainType'] = 'domain1';?>
<?=boxHeader(array('title'=>$title))?>
<? $entityID = $out['DB']['Domain'][0]['DomainID']; $categoryID = input('CategoryID'); ?>
	<? if(!empty($input['DomainType']) || !empty($out['DB']['Domain'][0]['DomainType'])) { ?>
	<!-- <tr> 
		<td valign="middle" bgcolor="#ffffff" class="subtitleline">
			<? $DomainType = $out['DB']['Domain'][0]['DomainType']; if(empty($DomainType)) {$DomainType=$input['DomainType'];}?>
			<span  class="subtitle"><?=lang('Domain.DomainType')?>: <b><?=getListValue($out['DB']['DomainTypes'],$DomainType,array('id'=>'DomainTypeAlias','value'=>'DomainTypeName'))?></b></span>
		</td> 
	</tr> -->
	<? } else { ?>
	<tr> 
	<form name="getDomainTypes" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="Domain<?=DTR?>DomainID" value="<?=$out['DB']['Domain'][0]['DomainID']?>">
		<input type="hidden" name="DomainID" value="<?=$out['DB']['Domain'][0]['DomainID']?>">
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id']='';	
				$options[0]['value']='- '.lang('DomainTypeSelect.webcontrol.tip').' -';
				echo getLists($out['DB']['DomainTypes'],$input['DomainType'],array('name'=>'DomainType','id'=>'DomainTypeAlias','value'=>'DomainTypeName','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
			?>	
		</td> 
	</form>
	</tr> 
	<? } ?>
	<? if(!empty($out['DB']['Domain'][0]['DomainType']) || !empty($input['DomainType'])) { 
	$formName = 'manageDomain';
	?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<input type="hidden" name="SID" value="manageDomains" />
		<input type="hidden" name="DomainType" value="<?=input('DomainType')?>" />	
		<? if(empty($out['DB']['Domain'][0]['DomainID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="Domain<?=DTR?>DomainID" value="<?=$out['DB']['Domain'][0]['DomainID']?>">
		<? } ?>		
		<? if(empty($out['DB']['Domain'][0]['DomainType'])) { ?>
		<input type="hidden" name="Domain<?=DTR?>DomainType" value="<?=input('DomainType')?>" />		
		<? } else { ?>
		<input type="hidden" name="Domain<?=DTR?>DomainType" value="<?=$out['DB']['Domain'][0]['DomainType']?>">
		<? } ?>		
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="2" cellpadding="2" width="100%">
					<tr>
						<td colspan="2" align="center">
							<?
								$options[0]['id'] = '';
								$options[0]['value'] = lang('AllDomainList.webcontrol.tip');
								echo getLists($out['DB']['Domains'],input('DomainID'),array('name'=>'DomainID','id'=>'DomainID','value'=>'DomainName','action'=>'document.'.$formName.'.SID.value=\'manageDomain\';submit();','options'=>$options));	
							?>
							<br/><br/>
						</td>
					</tr>
					<tr>
						<td valign="top" class="subtitle">
							<?=lang('Domain.DomainName')?>
						</td>
						<? /* if(!empty($out['DB']['Domain'][0]['DomainName'])){?>
						<td>
							<?
								$options[0]['id'] = '';
								$options[0]['value'] = lang('AllDomainList.webcontrol.tip');
								echo getLists($out['DB']['Domains'],input('DomainID'),array('name'=>'DomainID','id'=>'DomainID','value'=>'DomainName','action'=>'document.$formName.SID.value=\'manageDomain\';submit();','options'=>$options));	
							?>
						</td>	
						<? }else{?>
						<td>
							<input type="text" name="Domain<?=DTR?>DomainName" value="<?=$out['DB']['Domain'][0]['DomainName'];?>" size="35">
						</td>
						<? } */?>
						<td>
							<input type="text" name="Domain<?=DTR?>DomainName" value="<?=$out['DB']['Domain'][0]['DomainName'];?>" size="35">
						</td>
						
					</tr>
					<? /* <tr>
						<td class="subtitle"><?=lang('Domain.DomainLocation')?></td>
						<td>
							<? setInput('CountryID','118'); ?>
							<? 
								$params['currentValue'] = $out['DB']['Domain'][0]['DomainLocationID'];
								$params['fieldName'] = 'Domain'.DTR.'DomainLocationID';
								$params['id'] = 'id';
								getBox('core.getRegionsDropDwon',array("params"=>$params)); 
							?>
						</td>
					</tr> */ ?>	
					<?
						if(is_array($out['DB']['Clients']))
						{
							$list[0]['id'] = '';
							$list[0]['value'] = lang('SelectClient.webcontrol.tip');
							$i=1;
							foreach($out['DB']['Clients'] as $row)
							{
								$list[$i]['id'] = $row['id'];
								$list[$i]['value'] = utf8_encode($row['nickname'].': '.$row['prenom'].' '.$row['nom']);
								$i++;
							}
						}
					?>
					<tr>
						<td class="subtitle">
							<?=lang('Domain.DomainClientID')?>
						</td>
						<td>
							<?=getLists($list,$out['DB']['Domain'][0]['DomainClientID'],array('name'=>'Domain'.DTR.'DomainClientID'));	?>
						</td>
					</tr>
					<tr>
						<td class="subtitle">
							<?=lang('Domain.DomainProfileID')?>
						</td>
						<td>
							<?=getLists($list,$out['DB']['Domain'][0]['DomainProfileID'],array('name'=>'Domain'.DTR.'DomainProfileID'));	?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="subtitle">
							<?=lang('Domain.DomainClientNumber')?>
						</td>
						<td>
							<input type="text" name="Domain<?=DTR?>DomainClientNumber" value="<?=$out['DB']['Domain'][0]['DomainClientNumber'];?>" size="35">
						</td>
					</tr>
					<tr>
						<td colspan="2" align="center" class="subtitleline">
							<span class="subtitle"><?=lang('DomainExtraFieldsList.webcontrol.subtitle')?></span>
						</td>
					</tr>
					<!-- <tr>
						<td>&nbsp;</td>
						<td> -->
							<? if(count($out['DB']['DomainField'])>0) {?>
								<!-- <hr size="1"> -->
								<? //lang('DomainExtraFieldsList.webcontrol.tip')?><!-- :<br/> -->
								<? /*if(hasRights('admin')){?>
									<a href="<?=setting('url')?>manageDomainFields/DomainType/<?=input('DomainType')?>" target="_blank">[<?=lang('EditDomainExtraFields.webcontrol.link')?>]</a>
									<br/><br/>
								<? }*/?>
								<?=showExtraFieldsForm($out)?>
								<? /*hr size="1">
								<?=lang('DomainOptionsList.webcontrol.tip')?>:&nbsp;&nbsp;<a href="<?=setting('url')?>manageDomainTypes/DomainType/<?=input('DomainType')?>" target="_blank">[<?=lang('EditDomainExtraOptions.webcontrol.link')?>]</a><br/><br/> */?>
								<? //showExtraOptionsForm($out)?>						
							<?  } ?>						
						<!-- </td>
					</tr> -->		
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
					<tr>
						<td class="subtitle" valign="top">	
							<?=lang('Domain.DomainIntro')?><? if(count($out['DB']['Languages']['languageCodes'])>1) echo ":".$out['DB']['Languages']['languageNames'][$langID];?>
						</td>
						<td>
							<textarea name="Domain<?=DTR?>DomainIntro[<?=$langCode?>]" cols="50" rows="5"><?=getValue($out['DB']['Domain'][0]['DomainIntro'],$langCode);?></textarea>
						</td>
					</tr>
					<? } ?>	
					<!-- <tr>
						<td align="center" colspan="2" class="subtitleline">
							<span  class="subtitle"><?=lang('DomainFoto.webcontrol.subtitle')?></span>
						</td>
					</tr>
					<tr>
						<td class="subtitle">
							<input type="hidden" name="fileField"/>
							<?=lang('Domain.DomainImage')?>
						</td>
						<td>
							<? $fieldName = 'DomainImage';?>
							<? if(!empty($out['DB']['Domain'][0]['DomainImage'])) { ?>
								<a href="<?=setting('urlfiles').$out['DB']['Domain'][0]['DomainImage']?>" target="_blank"><img src="<?=setting('urlfiles').$out['DB']['Domain'][0]['DomainImage']?>" border="0" width="240" /></a>
								<br/>
								<a href="javascript://" onClick="document.<?=$formName?>.SID.value='<?=input('SID')?>';document.<?=$formName?>.actionMode.value='deletefile';document.<?=$formName?>.fileField.value='<?=$fieldName?>';document.<?=$formName?>.submit();"><?=lang('-deleteimage')?></a>
							<? } ?>
							<br/>
							<?=lang('Domain.DomainImage')?>:<br/>
							<input size="20" type="file" name="uploadFile[DomainImage]" />
							<input type="hidden" name="oldUploadFile[DomainImage]" value="<?=$out['DB']['Domain'][0]['$fieldName']?>" /> 
							<br/><br/>
						</td>
					</tr>		
					<tr>
						<td class="subtitle">
							<?=lang('Domain.DomainImagePreview')?>
						</td>
						<td>
							<? $fieldName = 'DomainImagePreview';  echo getFormated($out['DB']['Domain'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Domain.'.$DomainTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
						</td>
					</tr>		
					<tr>
						<td class="subtitle">
							<?=lang('Domain.DomainIcon')?>
						</td>
						<td>
							<? $fieldName = 'DomainIcon';  echo getFormated($out['DB']['Domain'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Domain.'.$DomainTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
						</td>
					</tr> -->		
					<? /*if(count($out['DB']['Languages']['languageNames'])>1) { ?>				
					<tr>
						<td class="subtitle">
							<?=lang('Domain.DomainLanguages')?>:
						</td>
						<td>
							<?
								foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)
								{
									$languagesList[$langID]['id']=$languagesList['languageCodes'][$langID];	
									$languagesList[$langID]['value']=$langName;		
								}								
								echo getLists($languagesList,$out['DB']['Domain'][0]['DomainLanguages'],array('name'=>'Domain'.DTR.'DomainLanguages','type'=>'checkboxes'));	
							?>	
						</td>
					</tr>
					<? } */ ?>
					<tr>
						<td align="center" colspan="2" class="subtitleline">
							<span class="subtitle"><?=lang('PermAll.domain.subtitle')?></span>
						</td>
					</tr>
					<!-- <tr>
						<td class="subtitle">
							<?=lang('Domain.DomainStatus')?>
						</td>
						<td>
							<?=getReference('Domain.DomainStatus','Domain'.DTR.'DomainStatus',$out['DB']['Domain'][0]['DomainStatus'],array('code'=>'Y'))?>
						</td>
					</tr> -->		
					<tr>
						<td class="subtitle">
							<?=lang('Domain.PermAll')?>
						</td>
						<td>
							<? if(empty($out['DB']['Domain'][0]['PermAll'])) {$out['DB']['Domain'][0]['PermAll']='1';} ?>
							<?=getReference('PermAll','Domain'.DTR.'PermAll',$out['DB']['Domain'][0]['PermAll'],array('code'=>'Y'))?>
						</td>
					</tr>		
					<tr>
						<td align="center" colspan="2" class="subtitleline" valign="middle">
							<? if(empty($out['DB']['Domain'][0]['DomainID'])) { ?>
							<input type="submit" value="<?=lang("-add")?>" >
							<? } else { ?>
							<input type="submit" value="<?=lang("-save")?>" onClick="document.manageDomain.SID.value='manageDomain';submit();">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageDomain.actionMode.value='delete';confirmDelete('manageDomain', '<?=lang("-deleteconfirmation")?>');">
							<? } ?>					
							&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageDomain.actionMode.value='cancell';submit();">
						</td>
					</tr>		
				</table>
			</td> 
		</tr> 
	</form>	
	<? } ?>
<?=boxFooter()?>
<? }?>
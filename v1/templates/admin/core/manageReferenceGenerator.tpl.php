<?=boxHeader(array('title'=>'ManageReferenceGenerators.core.title'))?>
	<form name="getReferenceGenerators" method="post">
		<input type="hidden" name="SID" value="manageReferenceGenerators" />
		<tr>
			<td align="center" bgcolor="#FFFFFF">
				<table cellpadding="5" cellspacing="0" bgcolor="#FFFFFF">
					<tr>
						<td>
							<?=getReference('ReferenceMode','ReferenceMode',$input['ReferenceMode'],array('code'=>'Y'))?>
						</td>
						<td>
							<?
								foreach($out['DB']['Languages']['languageNames'] as $langID=>$langName)
								{
									$languagesList[$langID]['id']=$languagesList['languageCodes'][$langID];	
									$languagesList[$langID]['value']=$langName;		
								}								
								echo getLists($languagesList,$input['ReferenceGeneratorLanguages'],array('name'=>'ReferenceGeneratorLanguages','type'=>'dropdowns'));	
							?>
						</td>
						<td>
							<?=getReference('ReferenceCategories','GroupID',$input['GroupID'],array('code'=>'Y','action'=>'submit();'))?>
							<?	//echo getLists($out['DB']['ResourceCategories'],$parentID,array('name'=>'Resource'.DTR.'ResourceCategories','type'=>'dropdown','style'=>'width:100px;'));?>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</form>
	<form name="manageReferenceGenerators" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<? if(empty($out['DB']['ReferenceGenerator'][0]['ReferenceGeneratorID'])) { ?>
			<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
			<input type="hidden" name="actionMode" value="save" />
		<? } ?>
		<input type="hidden" name="ReferenceCode<?=DTR?>ReferenceCodeID" value="<?=$out['DB']['ReferenceCode'][0]['ReferenceCodeID'];?>" />
		<input type="hidden" name="ReferenceGenerator<?=DTR?>ReferenceGeneratorID[]" value="<?=$out['DB']['ReferenceGenerator']['ReferenceGeneratorID1'];?>" />
		<input type="hidden" name="ReferenceGenerator<?=DTR?>ReferenceGeneratorID[]" value="<?=$out['DB']['ReferenceGenerator']['ReferenceGeneratorID2'];?>" />
		<input type="hidden" name="ReferenceGenerator<?=DTR?>ReferenceGeneratorID[]" value="<?=$out['DB']['ReferenceGenerator']['ReferenceGeneratorID3'];?>" />
		<input type="hidden" name="ReferenceGenerator<?=DTR?>ReferenceGeneratorID[]" value="<?=$out['DB']['ReferenceGenerator']['ReferenceGeneratorID4'];?>" />
			<tr>
				<td bgcolor="#FFFFFF">
				<table bgcolor="#FFFFFF" cellpadding="5" cellspacing="0">
					<tr>
						<td>&nbsp;</td>
						<td>
							<?=getLists($out['DB']['ReferenceCode1'],$input['ReferenceCode'.DTR.'ReferenceCode'][0],array('name'=>'ReferenceCode'.DTR.'ReferenceCode[]','id'=>'ReferenceGeneratorCode','value'=>'ReferenceGeneratorName','type'=>'dropdown','style'=>'width:100px;','action'=>'document.manageReferenceGenerators.actionMode.value=\'cancell\';submit();'));?>
						</td>
						<td>
							<?=getLists($out['DB']['ReferenceCode2'],$input['ReferenceCode'.DTR.'ReferenceCode'][1],array('name'=>'ReferenceCode'.DTR.'ReferenceCode[]','id'=>'ReferenceGeneratorCode','value'=>'ReferenceGeneratorName','type'=>'dropdown','style'=>'width:100px;','action'=>'document.manageReferenceGenerators.actionMode.value=\'cancell\';submit();'));?>
						</td>
						<td>
							<?=getLists($out['DB']['ReferenceCode3'],$input['ReferenceCode'.DTR.'ReferenceCode'][2],array('name'=>'ReferenceCode'.DTR.'ReferenceCode[]','id'=>'ReferenceGeneratorCode','value'=>'ReferenceGeneratorName','type'=>'dropdown','style'=>'width:100px;','action'=>'document.manageReferenceGenerators.actionMode.value=\'cancell\';submit();'));?>
						</td>
						<td>
							<?=getLists($out['DB']['ReferenceCode4'],$input['ReferenceCode'.DTR.'ReferenceCode'][3],array('name'=>'ReferenceCode'.DTR.'ReferenceCode[]','id'=>'ReferenceGeneratorCode','value'=>'ReferenceGeneratorName','type'=>'dropdown','style'=>'width:100px;','action'=>'document.manageReferenceGenerators.actionMode.value=\'cancell\';submit();'));?>
						</td>
					</tr>
					<tr>
						<td>&nbsp;</td>
						<td>
							<input type="text" name="ReferenceGenerator<?=DTR?>ReferenceGeneratorCode[]" value="<?=$out['DB']['ReferenceGenerator']['ReferenceGeneratorCode1'];?>" size="25">
						</td>
						<td>
							<input type="text" name="ReferenceGenerator<?=DTR?>ReferenceGeneratorCode[]" value="<?=$out['DB']['ReferenceGenerator']['ReferenceGeneratorCode2'];?>" size="25">
						</td>
						<td>
							<input type="text" name="ReferenceGenerator<?=DTR?>ReferenceGeneratorCode[]" value="<?=$out['DB']['ReferenceGenerator']['ReferenceGeneratorCode3'];?>" size="25">
						</td>
						<td>
							<input type="text" name="ReferenceGenerator<?=DTR?>ReferenceGeneratorCode[]" value="<?=$out['DB']['ReferenceGenerator']['ReferenceGeneratorCode4'];?>" size="25">
						</td>
					</tr>
					<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
						<tr>
							<td><?=$out['DB']['Languages']['languageNames'][$langID];?></td>
							<td>
								<input type="text" name="ReferenceGenerator<?=DTR?>ReferenceGeneratorName0[<?=$langCode?>]" size="25" value="<?=getValue($out['DB']['ReferenceGenerator']['ReferenceGeneratorName1'],$langCode);?>" />
							</td>
							<td>
								<input type="text" name="ReferenceGenerator<?=DTR?>ReferenceGeneratorName1[<?=$langCode?>]" size="25" value="<?=getValue($out['DB']['ReferenceGenerator']['ReferenceGeneratorName2'],$langCode);?>" />
							</td>
							<td>
								<input type="text" name="ReferenceGenerator<?=DTR?>ReferenceGeneratorName2[<?=$langCode?>]" size="25" value="<?=getValue($out['DB']['ReferenceGenerator']['ReferenceGeneratorName3'],$langCode);?>" />
							</td>
							<td>
								<input type="text" name="ReferenceGenerator<?=DTR?>ReferenceGeneratorName3[<?=$langCode?>]" size="25" value="<?=getValue($out['DB']['ReferenceGenerator']['ReferenceGeneratorName4'],$langCode);?>" />
							</td>
						</tr>
					<? }?>
				</table>
				</td>
			</tr>
			<tr>
				<td align="center" bgcolor="#efefef" width="100%" colspan="7">
					<?=getReference('ReferenceType','ReferenceCode'.DTR.'ReferenceCodeType',$input['ReferenceCode'.DTR.'ReferenceCodeType'],array('code'=>'Y'))?>
					&nbsp;
					<? if(empty($out['DB']['ReferenceGenerator'][0]['ReferenceGeneratorID'])) { ?>
						<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
						<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageReferenceGenerators.actionMode.value='delete';confirmDelete('manageReferenceGenerators', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
				</td>
			</tr>
	</form>
	<tr>
		<table bgcolor="#FFFFFF" cellpadding="0" cellspacing="0">
			<? if(is_array($out['DB']['ReferenceCodes'])){foreach($out['DB']['ReferenceCodes'] as $value){?>
			<tr>
				<td><a href="<?=setting('url').input('SID')?>/ReferenceCodeID/<?=$value['ReferenceCodeID']?>"><?=$value['ReferenceCodeName']?></a></td>
			</tr>
			<? }}?>
		</table>
	</tr>
<?=boxFooter()?>

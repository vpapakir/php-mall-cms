<?=boxHeader(array('title'=>'ManageRegion.core.title'))?>
<? $entityID = $out['DB']['Region'][0]['RegionID']; ?>
	<form name="manageRegions" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">
		<? if(input('RegionActionType')=='geographical'){?>
			<input type="hidden" name="SID" value="manageRegionGeo" />
		<? }else{?>
			<input type="hidden" name="SID" value="manageRegions" />
		<? }?>
		<input type="hidden" name="RegionActionType" value="<?=input('RegionActionType')?>" />
		<? if(empty($out['DB']['Region'][0]['RegionID'])) { ?>
		<input type="hidden" name="actionMode" value="add" />
		<? } else { ?>
		<input type="hidden" name="actionMode" value="save1" />
		<input type="hidden" name="RegionID" value="<?=input('RegionID')?>" />
		<input type="hidden" name="Region<?=DTR?>RegionID" value="<?=$out['DB']['Region'][0]['RegionID']?>">
		<? } ?>		
		<? if(empty($out['DB']['Region'][0]['RegionActionType'])) $out['DB']['Region'][0]['RegionActionType'] = input('RegionActionType');?>
		<input type="hidden" name="Region<?=DTR?>RegionActionType" value="<?=$out['DB']['Region'][0]['RegionActionType']?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0" border="0" width="100%">
					<tr>
						<td valign="top" class="fieldNames">
						<table cellpadding="2" cellspacing="0" border="0" width="100%">
						<tr>
						<td align="center" bgcolor="#efefef" colspan="2" width="100%">
							<? if(empty($out['DB']['ParentRegion']['RegionID'])) $out['DB']['ParentRegion']['RegionID'] = "0";?>
							<input type="hidden" name="Region<?=DTR?>RegionParentID" value="<?=$out['DB']['ParentRegion']['RegionID']?>" />
							<input type="hidden" name="Region<?=DTR?>RegionType" value="<?= $out['DB']['ParentRegion']['RegionType']?>" />
							<span class="subtitle"><?=lang('Region.RegionParentID')?>: </span>
							<strong><?= $out['DB']['ParentRegion']['RegionName']?></strong>
						</td>
						</tr>
						<tr>
							<td align="left" width="50">
								<span class="subtitle"><?=lang('Region.RegionCode')?>: </span>
							</td>
							<td align="left">
								<input type="text" name="Region<?=DTR?>RegionCode" value="<?=$out['DB']['Region'][0]['RegionCode'];?>" size="30">
							</td>
						</tr>
						<!-- <tr>
							<td align="left" width="50">
								<span class="subtitle"><?=lang('Region.RegionActionType')?>: </span>
							</td>
							<td align="left">
								<? if(empty($out['DB']['Region'][0]['RegionActionType'])) $out['DB']['Region'][0]['RegionActionType'] = input('RegionActionType');?>
								<? //getReference('Region.RegionActionType','Region'.DTR.'RegionActionType',$out['DB']['Region'][0]['RegionActionType'],array('code'=>'Y'))?>
							</td>
						</tr> -->
							<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
							<TR>
							<td align="left">
								<span class="subtitle"><?=lang('Region.RegionName')?>: <?=$out['DB']['Languages']['languageNames'][$langID]?> </span>
							</td>
							<td align="left">
								<input type="text" name="Region<?=DTR?>RegionName[<?=$langCode?>]" size="30" value="<?=getValue($out['DB']['Region'][0]['RegionName'],$langCode);?>">
							</TR>
							<? } ?>	
							<tr>
							<td align="left">
							<span class="subtitle"><?=lang('Region.RegionZIP')?>: </span>
							</td>
							<td align="left">
							<input type="text" name="Region<?=DTR?>RegionZIP" value="<?=$out['DB']['Region'][0]['RegionZIP'];?>" size="30">
							</td>
							</tr>
							<tr>
							<td align="left">
							<span class="subtitle"><?=lang('Region.PermAll')?>: </span>
							</td>
							<td align="left">
							<?=getReference('PermAll','Region'.DTR.'PermAll',$out['DB']['Region'][0]['PermAll'],array('code'=>'Y'))?>
						</td>
						</tr>
						<tr>
						<td align="center" bgcolor="#efefef" colspan="2">
					<? if(empty($out['DB']['Region'][0]['RegionID'])) { ?>
					<input type="submit" value="<?=lang("-add")?>">
					<? } else { ?>
					<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="document.manageRegions.actionMode.value='delete';confirmDelete('manageRegions', '<?=lang("-deleteconfirmation")?>');">
					<? } ?>					
					&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageRegions.actionMode.value='cancell';submit();">
					</td>
					</tr>
					</table>
					</td>
					</tr>
					</table>
			</td> 
		</tr> 
	</form>	
<?=boxFooter()?>
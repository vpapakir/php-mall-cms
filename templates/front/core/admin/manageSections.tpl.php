<?=boxHeader(array('title'=>'ManageSections.core.title'))?>
	<? /* tr> 
	<form name="getSections" method="post">
	<input type="hidden" name="SID" value="adminSitemap" />
	<td valign=top bgcolor="#ffffff">
		<?=$out['Refs']['SectionGroups']?> <input type="text" name="searchWord" size="30"/> <input type="submit" name="goSearch" value="<?=lang('-search')?>"/>  <? if(hasRights('root')) { ?>&nbsp;&nbsp;<a href="<?=setting('url')?>adminPageGroups">[<?=lang('EditSectionGroup.core.link')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageViews">[<?=lang('ManageLayouts.core.link')?>]</a> <? } ?>
	</td> 
	</form>
	</tr */ ?> 
	<? if(count($out['DB']['Sections'])>0) {?>
	<form name="adminSitemap" method="post">
		<input type="hidden" name="SID" value="adminSitemap" />
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="GroupID" value="<?=input('GroupID')?>" />
		<input type="hidden" name="searchWord" value="<?=input('searchWord')?>" />
		<input type="hidden" name="windowMode" value="<?=input('windowMode')?>"/>
		<? $sectionGroupID = input('GroupID');?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['Sections'] as $sectionGroupCurrentID=>$sectionTreeValue) {?>
					<tr>
						<td colspan="5" class="subtitle">
							<?=getValue($out['DB']['SectionGroups'][$sectionGroupCurrentID]['SectionGroupName'])?>
						</td>
					</tr>
					<? if(is_array($sectionTreeValue)) { foreach($sectionTreeValue as $id1=>$row) { $id = $row['SectionID'];?>
					<input type="hidden" name="Section<?=DTR?>SectionID[<?=$id?>]" value="<?=$row['SectionID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13" alt="<?=$row['SectionAlias']?>"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="Section<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="Section<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>											
						<td valign="top" class="row1" width="65%">
							<? $deep=$row['SectionLevel']*15-15; ?>
							<img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1" />
							<?
								$selectedSectionID = input('SectionID'); if(empty($selectedSectionID)) {$selectedSectionID = input('Section'.DTR.'SectionID');}
								//print_r($row);
								//if($out['DB']['Sections'][$id+1]['SectionLevel']>$row['SectionLevel'] || $row['SectionChildren']==0) {
								if($out['DB']['Sections'][$id+1]['SectionLevel']>$row['SectionLevel'] || $row['SectionID']==$selectedSectionID ) {
									$expandImage = 'minus';
								} else {
									$expandImage = 'plus';
								}
							?>							
							<a href="<?=setting('url')?><?=input('SID')?>/SectionID/<?=$row['SectionID']?>/GroupID/<?=$sectionGroupID?>/windowMode/<?=input('windowMode')?>"><img src="<?=setting('layout')?>images/icons/<?=$expandImage?>.jpg" width="9" height="9" hspace="3" border="0"/></a>
							
							<? if(!empty($row['SectionManagementLink'])) { ?>
							<a href="<?=setting('url').$row['SectionManagementLink']?>"><?=getValue($row['SectionName'])?></a>
							<? } elseif($row['SectionBox']=='core.page') { ?>
							<a href="<?=setting('url')?>adminPage/viewMode/main/SectionID/<?=$row['SectionID']?>/GroupID/<?=$sectionGroupID?>/tabLink/5/windowMode/<?=input('windowMode')?>"><?=getValue($row['SectionName'])?></a>
							<? } else { ?>
							<?=getValue($row['SectionName'])?> 
							<? } ?>
						</td>
						<td valign="top" class="row1">
							<?
							$SectionPositionUp = $row['SectionPosition'] - 3;
							$SectionPositionDown = $row['SectionPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/Section<?=DTR?>SectionPosition/<?=$SectionPositionUp?>/Section<?=DTR?>SectionID/<?=$row['SectionID']?>/Section<?=DTR?>SectionParentID/<?=$row['SectionParentID']?>/SectionID/<?=$row['SectionID']?>/GroupID/<?=$sectionGroupID?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpSection.core.tip')?>" hspace="3"  /></a>&nbsp;
							<a href="<?=setting('url')?><?=input('SID')?>/Section<?=DTR?>SectionPosition/<?=$SectionPositionDown?>/Section<?=DTR?>SectionID/<?=$row['SectionID']?>/Section<?=DTR?>SectionParentID/<?=$row['SectionParentID']?>/SectionID/<?=$row['SectionID']?>/GroupID/<?=$sectionGroupID?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownSection.core.tip')?>" hspace="3"  /></a>
						</td>						
						<td valign="top" class="row1" width="10%" align="right">
							<select name="manageDD_<?=$id?>" onChange="selectLink('adminSitemap', 'manageDD_<?=$id?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '3')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url')?>adminPage/SectionID/<?=$row['SectionID']?>/GroupID/<?=$sectionGroupID?>/viewMode/main/tabLink/1/windowMode/<?=input('windowMode')?>"><?=lang('-edit')?></option>
								<option value="<?=setting('url')?>adminPage/SectionID/<?=$row['SectionID']?>/GroupID/<?=$sectionGroupID?>/viewMode/advanced/tabLink/4/windowMode/<?=input('windowMode')?>"><?=lang('SectionEditAdvanced.core.option')?></option>
								<option value="<?=setting('url')?>adminSitemap/Section<?=DTR?>SectionID/<?=$row['SectionID']?>/SectionID/<?=$row['SectionParentID']?>/actionMode/delete/GroupID/<?=$sectionGroupID?>/windowMode/<?=input('windowMode')?>"><?=lang('-delete')?></option>
								<option value="<?=setting('url')?>adminPage/SectionParentID/<?=$row['SectionParentID']?>/GroupID/<?=$sectionGroupID?>/RequestedGroupID/<?=$row['SectionGroupID']?>/SectionPosition/<? $newSectionPosition=$row['SectionPosition'] + 1; echo $newSectionPosition; ?>/viewMode/main/tabLink/1/windowMode/<?=input('windowMode')?>"><?=lang('AddSectionAfter.core.link','nospace')?></option>
								<option value="<?=setting('url')?>adminPage/SectionParentID/<?=$row['SectionID']?>/GroupID/<?=$sectionGroupID?>/RequestedGroupID/<?=$row['SectionGroupID']?>/SectionPosition/1/viewMode/main/tabLink/1/windowMode/<?=input('windowMode')?>"><?=lang('AddSectionUnder.core.link','nospace')?></option>
							</select>
						</td>
					</tr>
					<?  } } else {  ?>	
					<tr>
						<td colspan="5" class="subtitle">
							<? if(!empty($sectionGroupCurrentID)) { ?>
							<a href="<?=setting('url')?>adminPage/RequestedGroupID/<?=$sectionGroupCurrentID?>/windowMode/<?=input('windowMode')?>"><?=lang('AddSection.core.link')?></a>
							<? } else { ?>
									<div align="center">
										<a href="<?=setting('url')?>adminPage/RequestedGroupID/<?=input('GroupID')?>/windowMode/<?=input('windowMode')?>" class="boldLink">[<?=lang('AddSection.core.link')?>]</a>
									</div>		
							<? } ?>
						</td>
					</tr>
				<? } } ?>					
				</table>		
			</td> 
		</tr> 
		<tr> 
			<td valign=top bgcolor="#ffffff">
				<input type="submit" value="<?=lang("-save")?>">
			</td> 
		</tr>		
	</form>	
	<?  }// end of  if(!empty($out['DB']['Sections'][0]['SectionID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>adminPage/RequestedGroupID/<?=input('GroupID')?>/windowMode/<?=input('windowMode')?>" class="boldLink">[<?=lang('AddSection.core.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoSectionFound.core.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>
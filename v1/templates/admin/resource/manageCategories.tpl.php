<? if(setting('UseResourceCategories')=='Y') { ?>
<?=boxHeader(array('title'=>'ManageResourceCategories.resource.title'))?>
	<!--tr> 
	<form name="getResourceCategories" method="post">
	<input type="hidden" name="SID" value="manageCategories" />
	<td valign=top bgcolor="#ffffff">
		<?=$out['Refs']['ResourceCategoryGroups']?>&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceCategoryGroups">[<?=lang('EditResourceCategoryGroup.resource.link')?>]</a>
	</td> 
	</form>
	</tr--> 
	<? if(!empty($out['DB']['ResourceCategories'][0]['ResourceCategoryID'])) {?>
	<form name="manageResourceCategories" method="post">
		<input type="hidden" name="SID" value="manageCategories" />
		<input type="hidden" name="actionMode" value="save" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['ResourceCategories'] as $id=>$row) {?>
					<input type="hidden" name="ResourceCategory<?=DTR?>ResourceCategoryID[<?=$id?>]" value="<?=$row['ResourceCategoryID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="ResourceCategory<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="ResourceCategory<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>											
						<td valign="top" class="row1" width="65%">
							<? $deep=$row['ResourceCategoryLevel']*15-15; ?>
							<img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1"/>
							<?
								$selectedCategoryID = input('ResourceCategoryID'); if(empty($selectedCategoryID)) {$selectedCategoryID = input('ResourceCategory'.DTR.'ResourceCategoryID');}
								//print_r($row);
								//if($out['DB']['ResourceCategories'][$id+1]['ResourceCategoryLevel']>$row['ResourceCategoryLevel'] || $row['ResourceCategoryChildren']==0) {
								if($out['DB']['ResourceCategories'][$id+1]['ResourceCategoryLevel']>$row['ResourceCategoryLevel'] || $row['ResourceCategoryID']==$selectedCategoryID ) {
									$expandImage = 'minus';
								} else {
									$expandImage = 'plus';
								}
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/ResourceCategoryID/<?=$row['ResourceCategoryID']?>/ResourceCategoryGroup/<?=$row['ResourceCategoryGroupID']?>/"><img src="<?=setting('layout')?>images/icons/<?=$expandImage?>.jpg" width="9" height="9" hspace="3" border="0"/></a><a href="<?=setting('url')?>manageResources/CategoryID/<?=$row['ResourceCategoryID']?>"><?=getValue($row['ResourceCategoryTitle'])?></a>
						</td>
						<td valign="top" class="row1" align="center">
							<?
							$ResourceCategoryPositionUp = $row['ResourceCategoryPosition'] - 3;
							$ResourceCategoryPositionDown = $row['ResourceCategoryPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/ResourceCategory<?=DTR?>ResourceCategoryPosition/<?=$ResourceCategoryPositionUp?>/ResourceCategory<?=DTR?>ResourceCategoryID/<?=$row['ResourceCategoryID']?>/ResourceCategoryGroup/<?=$row['ResourceCategoryGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpResourceCategory.resource.tip')?>" hspace="3"  /></a>&nbsp;
							<a href="<?=setting('url')?><?=input('SID')?>/ResourceCategory<?=DTR?>ResourceCategoryPosition/<?=$ResourceCategoryPositionDown?>/ResourceCategory<?=DTR?>ResourceCategoryID/<?=$row['ResourceCategoryID']?>/GroupID/<?=$row['ResourceCategoryGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownResourceCategory.resource.tip')?>" hspace="3"  /></a>
						</td>						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageCategory/ResourceCategoryID/<?=$row['ResourceCategoryID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageCategories/ResourceCategory<?=DTR?>ResourceCategoryID/<?=$row['ResourceCategoryID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteResourceCategory.resource.tip')?>')">[<?=lang('-delete')?>]</a>
							<br/>
							<a href="<?=setting('url')?>manageCategory/ResourceCategoryParentID/<?=$row['ResourceCategoryParentID']?>/GroupID/<?=input('GroupID')?>/ResourceCategoryPosition/<? $newResourceCategoryPosition=$row['ResourceCategoryPosition'] + 1; echo $newResourceCategoryPosition; ?>">[<?=lang('AddResourceCategoryAfter.resource.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageCategory/ResourceCategoryParentID/<?=$row['ResourceCategoryID']?>/GroupID/<?=input('GroupID')?>/ResourceCategoryPosition/1">[<?=lang('AddResourceCategoryUnder.resource.link','nospace')?>]</a>
							-->
						<select name="ManageCategories<?=$row['ResourceCategoryID']?>" onChange="selectLink('manageResourceCategories', 'ManageCategories<?=$row['ResourceCategoryID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
							<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
							<option value="<?=setting('url')?>manageCategory/ResourceCategoryID/<?=$row['ResourceCategoryID']?>/GroupID/<?=input('GroupID')?>"><?=lang('-edit')?></option>
							<option value="<?=setting('url')?>manageCategories/ResourceCategory<?=DTR?>ResourceCategoryID/<?=$row['ResourceCategoryID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>"><?=lang('-delete')?></option>
							<option value="<?=setting('url')?>manageCategory/ResourceCategoryParentID/<?=$row['ResourceCategoryParentID']?>/GroupID/<?=input('GroupID')?>/ResourceCategoryPosition/<? $newResourceCategoryPosition=$row['ResourceCategoryPosition'] + 1; echo $newResourceCategoryPosition; ?>"><?=lang('AddResourceCategoryAfter.resource.link','nospace')?></option>
							<option value="<?=setting('url')?>manageCategory/ResourceCategoryParentID/<?=$row['ResourceCategoryID']?>/GroupID/<?=input('GroupID')?>/ResourceCategoryPosition/1"><?=lang('AddResourceCategoryUnder.resource.link','nospace')?></option>
						</select>
						</td>										
					</tr>	
				<? } ?>					
				</table>		
			</td> 
		</tr> 
		<tr> 
			<td valign=top bgcolor="#ffffff">
				<input type="submit" value="<?=lang("-save")?>">
			</td> 
		</tr>		
	</form>	
	<?  }// end of  if(!empty($out['DB']['ResourceCategories'][0]['ResourceCategoryID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageCategory/GroupID/<?=input('GroupID')?>" class="boldLink">[<?=lang('AddResourceCategory.resource.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoResourceCategoryFound.resource.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>
<? } ?>
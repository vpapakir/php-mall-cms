<?=boxHeader(array('title'=>'ManageTourCategories.tour.title'))?>
	<!--tr> 
	<form name="getTourCategories" method="post">
	<input type="hidden" name="SID" value="manageCategories" />
	<td valign=top bgcolor="#ffffff">
		<?=$out['Refs']['TourCategoryGroups']?>&nbsp;&nbsp;<a href="<?=setting('url')?>manageTourCategoryGroups">[<?=lang('EditTourCategoryGroup.tour.link')?>]</a>
	</td> 
	</form>
	</tr--> 
	<? if(!empty($out['DB']['TourCategories'][0]['TourCategoryID'])) {?>
	<form name="manageTourCategories" method="post">
		<input type="hidden" name="SID" value="manageTourCategories" />
		<input type="hidden" name="actionMode" value="save" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['TourCategories'] as $id=>$row) {?>
					<input type="hidden" name="TourCategory<?=DTR?>TourCategoryID[<?=$id?>]" value="<?=$row['TourCategoryID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="TourCategory<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="TourCategory<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>											
						<td valign="top" class="row1" width="65%">
							<? $deep=$row['TourCategoryLevel']*15-15; ?>
							<img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1"/>
							<a href="<?=setting('url')?>manageTours/CategoryID/<?=$row['TourCategoryID']?>"><?=getValue($row['TourCategoryTitle'])?></a>
						</td>
						<td valign="top" class="row1" align="center">
							<?
							$TourCategoryPositionUp = $row['TourCategoryPosition'] - 3;
							$TourCategoryPositionDown = $row['TourCategoryPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/TourCategory<?=DTR?>TourCategoryPosition/<?=$TourCategoryPositionUp?>/TourCategory<?=DTR?>TourCategoryID/<?=$row['TourCategoryID']?>/TourCategoryGroup/<?=$row['TourCategoryGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpTourCategory.tour.tip')?>" hspace="3"  /></a>&nbsp;
							<a href="<?=setting('url')?><?=input('SID')?>/TourCategory<?=DTR?>TourCategoryPosition/<?=$TourCategoryPositionDown?>/TourCategory<?=DTR?>TourCategoryID/<?=$row['TourCategoryID']?>/GroupID/<?=$row['TourCategoryGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownTourCategory.tour.tip')?>" hspace="3"  /></a>
						</td>						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageCategory/TourCategoryID/<?=$row['TourCategoryID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageCategories/TourCategory<?=DTR?>TourCategoryID/<?=$row['TourCategoryID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteTourCategory.tour.tip')?>')">[<?=lang('-delete')?>]</a>
							<br/>
							<a href="<?=setting('url')?>manageCategory/TourCategoryParentID/<?=$row['TourCategoryParentID']?>/GroupID/<?=input('GroupID')?>/TourCategoryPosition/<? $newTourCategoryPosition=$row['TourCategoryPosition'] + 1; echo $newTourCategoryPosition; ?>">[<?=lang('AddTourCategoryAfter.tour.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageCategory/TourCategoryParentID/<?=$row['TourCategoryID']?>/GroupID/<?=input('GroupID')?>/TourCategoryPosition/1">[<?=lang('AddTourCategoryUnder.tour.link','nospace')?>]</a>
							-->
						<select name="ManageCategories<?=$row['TourCategoryID']?>" onChange="selectLink('manageTourCategories', 'ManageCategories<?=$row['TourCategoryID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
							<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
							<option value="<?=setting('url')?>manageTourCategory/TourCategoryID/<?=$row['TourCategoryID']?>/GroupID/<?=input('GroupID')?>"><?=lang('-edit')?></option>
							<option value="<?=setting('url')?>manageTourCategories/TourCategory<?=DTR?>TourCategoryID/<?=$row['TourCategoryID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>"><?=lang('-delete')?></option>
							<option value="<?=setting('url')?>manageTourCategory/TourCategoryParentID/<?=$row['TourCategoryParentID']?>/GroupID/<?=input('GroupID')?>/TourCategoryPosition/<? $newTourCategoryPosition=$row['TourCategoryPosition'] + 1; echo $newTourCategoryPosition; ?>"><?=lang('AddTourCategoryAfter.tour.link','nospace')?></option>
							<option value="<?=setting('url')?>manageTourCategory/TourCategoryParentID/<?=$row['TourCategoryID']?>/GroupID/<?=input('GroupID')?>/TourCategoryPosition/1"><?=lang('AddTourCategoryUnder.tour.link','nospace')?></option>
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
	<?  }// end of  if(!empty($out['DB']['TourCategories'][0]['TourCategoryID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageTourCategory/GroupID/<?=input('GroupID')?>" class="boldLink">[<?=lang('AddTourCategory.tour.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoTourCategoryFound.tour.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>
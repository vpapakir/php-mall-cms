<?=boxHeader(array('title'=>'ManageServiceCategories.billing.title'))?>
	<!--tr> 
	<form name="getServiceCategories" method="post">
	<input type="hidden" name="SID" value="manageCategories" />
	<td valign=top bgcolor="#ffffff">
		<?=$out['Refs']['ServiceCategoryGroups']?>&nbsp;&nbsp;<a href="<?=setting('url')?>manageServiceCategoryGroups">[<?=lang('EditServiceCategoryGroup.billing.link')?>]</a>
	</td> 
	</form>
	</tr--> 
	<? if(!empty($out['DB']['ServiceCategories'][0]['ServiceCategoryID'])) {?>
	<form name="manageServiceCategories" method="post">
		<input type="hidden" name="SID" value="manageServiceCategories" />
		<input type="hidden" name="actionMode" value="save" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['ServiceCategories'] as $id=>$row) {?>
					<input type="hidden" name="ServiceCategory<?=DTR?>ServiceCategoryID[<?=$id?>]" value="<?=$row['ServiceCategoryID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="ServiceCategory<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="ServiceCategory<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>											
						<td valign="top" class="row1" width="65%">
							<? $deep=$row['ServiceCategoryLevel']*15-15; ?>
							<img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1"/>
							<a href="<?=setting('url')?>manageServices/CategoryID/<?=$row['ServiceCategoryID']?>"><?=getValue($row['ServiceCategoryTitle'])?></a>
						</td>
						<td valign="top" class="row1" align="center">
							<?
							$ServiceCategoryPositionUp = $row['ServiceCategoryPosition'] - 3;
							$ServiceCategoryPositionDown = $row['ServiceCategoryPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/ServiceCategory<?=DTR?>ServiceCategoryPosition/<?=$ServiceCategoryPositionUp?>/ServiceCategory<?=DTR?>ServiceCategoryID/<?=$row['ServiceCategoryID']?>/ServiceCategoryGroup/<?=$row['ServiceCategoryGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpServiceCategory.billing.tip')?>" hspace="3"  /></a>&nbsp;
							<a href="<?=setting('url')?><?=input('SID')?>/ServiceCategory<?=DTR?>ServiceCategoryPosition/<?=$ServiceCategoryPositionDown?>/ServiceCategory<?=DTR?>ServiceCategoryID/<?=$row['ServiceCategoryID']?>/GroupID/<?=$row['ServiceCategoryGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownServiceCategory.billing.tip')?>" hspace="3"  /></a>
						</td>						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageCategory/ServiceCategoryID/<?=$row['ServiceCategoryID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageCategories/ServiceCategory<?=DTR?>ServiceCategoryID/<?=$row['ServiceCategoryID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteServiceCategory.billing.tip')?>')">[<?=lang('-delete')?>]</a>
							<br/>
							<a href="<?=setting('url')?>manageCategory/ServiceCategoryParentID/<?=$row['ServiceCategoryParentID']?>/GroupID/<?=input('GroupID')?>/ServiceCategoryPosition/<? $newServiceCategoryPosition=$row['ServiceCategoryPosition'] + 1; echo $newServiceCategoryPosition; ?>">[<?=lang('AddServiceCategoryAfter.billing.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageCategory/ServiceCategoryParentID/<?=$row['ServiceCategoryID']?>/GroupID/<?=input('GroupID')?>/ServiceCategoryPosition/1">[<?=lang('AddServiceCategoryUnder.billing.link','nospace')?>]</a>
							-->
						<select name="ManageCategories<?=$row['ServiceCategoryID']?>" onChange="selectLink('manageServiceCategories', 'ManageCategories<?=$row['ServiceCategoryID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
							<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
							<option value="<?=setting('url')?>manageServiceCategory/ServiceCategoryID/<?=$row['ServiceCategoryID']?>/GroupID/<?=input('GroupID')?>"><?=lang('-edit')?></option>
							<option value="<?=setting('url')?>manageServiceCategories/ServiceCategory<?=DTR?>ServiceCategoryID/<?=$row['ServiceCategoryID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>"><?=lang('-delete')?></option>
							<option value="<?=setting('url')?>manageServiceCategory/ServiceCategoryParentID/<?=$row['ServiceCategoryParentID']?>/GroupID/<?=input('GroupID')?>/ServiceCategoryPosition/<? $newServiceCategoryPosition=$row['ServiceCategoryPosition'] + 1; echo $newServiceCategoryPosition; ?>"><?=lang('AddServiceCategoryAfter.billing.link','nospace')?></option>
							<option value="<?=setting('url')?>manageServiceCategory/ServiceCategoryParentID/<?=$row['ServiceCategoryID']?>/GroupID/<?=input('GroupID')?>/ServiceCategoryPosition/1"><?=lang('AddServiceCategoryUnder.billing.link','nospace')?></option>
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
	<?  }// end of  if(!empty($out['DB']['ServiceCategories'][0]['ServiceCategoryID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageServiceCategory/GroupID/<?=input('GroupID')?>" class="boldLink">[<?=lang('AddServiceCategory.billing.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoServiceCategoryFound.billing.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>
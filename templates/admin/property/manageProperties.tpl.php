<? if(input('filterMode')=='last'){?>
	<?=boxHeader(array('title'=>'ManageLastProperties.property.title'))?>
<? }else{?>
	<?=boxHeader(array('title'=>'ManageProperties.property.title'))?>
<? }?>

<?  $propertyType = input('PropertyType'); ?>
	<tr> 
	<form name="getProperties" method="post">
	<input type="hidden" name="SID" value="manageProperties" />
	<input type="hidden" name="PropertyType" value="<?=input('PropertyType')?>" />
	<td valign=top bgcolor="#ffffff">
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectPropertyActionTypeForList.property.tip');
		echo getReference('Property.PropertyActionType','PropertyActionType',$input['PropertyActionType'],array('code'=>'Y','type'=>'dropdown','options'=>$options))
	?>	
	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectPropertyTypeForList.property.tip');
		echo getLists($out['DB']['PropertyTypes'],$propertyType,array('name'=>'PropertyType','id'=>'PropertyTypeAlias','value'=>'PropertyTypeName','options'=>$options));	
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectPropertyFeaturedOptions.property.tip');
		echo getReference('Property.PropertyFeaturedOptions','PropertyFeaturedOption',$input['PropertyFeaturedOption'],array('code'=>'Y','type'=>'dropdown','options'=>$options))
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectPropertyPermAll.property.tip');
		echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','options'=>$options))
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectPropertyStatusForList.property.tip');
		echo getReference('Property.PropertyStatus','PropertyStatus',input('PropertyStatus'),array('code'=>'Y','type'=>'dropdown','options'=>$options))
	?>	
	<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
	</td> 
	</form>
	</tr> 
	<? if(!empty($out['DB']['Properties'][0]['PropertyID'])) {?>
	<form name="manageProperties" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageProperties" />
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="PropertyType" value="<?=input('PropertyType')?>" />
		<input type="hidden" name="PropertyFeaturedOption" value="<?=input('PropertyFeaturedOption')?>" />
		<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
		<input type="hidden" name="PropertyStatus" value="<?=input('PropertyStatus')?>" />
		<input type="hidden" name="searchWord" value="<?=input('searchWord')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageProperty/PropertyType/<?=input('PropertyType')?>" class="boldLink">[<?=lang('AddProperty.property.link')?>]</a>
					</div>		
					<br/>				
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['Properties'] as $id=>$row) {?>
					<input type="hidden" name="Property<?=DTR?>PropertyID[<?=$id?>]" value="<?=$row['PropertyID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13" alt="Type: <?=$row['PropertyType']?>, Categories: <?=$row['PropertyCategories']?>"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="Property<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="Property<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>	
						<td valign="top" align="center" class="row1" width="1%">
							<? if(!empty($row['PropertyIcon'])) { ?>
								<!-- <img src="<?=setting('urlfiles').$row['PropertyIcon']?>" border="0"/> -->
								<img src="<?=setting('layout')?>images/icons/picture.gif" width="15" height="13" id="<?=$row['PropertyID']?>" onmouseover="showDiv('<?=$row['PropertyID']?>','<?=$row['PropertyID']?>.content','right')" onmouseout="hideDiv('<?=$row['PropertyID']?>.content'); return false;" />
								<div id="<?=$row['PropertyID']?>.content" class="popup" style="width:150px"><img src="<?=setting('urlfiles').$row['PropertyIcon']?>" border="0"/></div>
							<? } else {?>
								<img src="<?=setting('layout')?>images/icons/nopicture.gif" width="15" height="13"/>
							<? }?>
						</td>																
						<td valign="top" class="row1" width="50%">
							<a href="<?=setting('url')?>manageProperty/PropertyID/<?=$row['PropertyID']?>/PropertyType/<?=input('PropertyType')?>/viewMode/view"><?=getValue($row['PropertyTitle'])?></a>
							<br/>
							<?=getFormated($row['PropertyLocation'],'Location')?>
							<br>
							<?=getValue($row['PropertyAddress']);?>
						</td>
						<td valign="top" class="row1">
							<?=getFormated($row['PropertyPrice'],'Money')?>
						</td valign="top" class="row1">
						<td valign="top" class="row1">
							<?=getReferenceValue('Property.PropertyActionType',$row['PropertyActionType'])?>
						</td>
						<td valign="top" class="row1">
							<?=getListValue($out['DB']['PropertyTypes'],$row['PropertyType'],array('id'=>'PropertyTypeAlias','value'=>'PropertyTypeName'))?>
						</td>
						<!--td valign="top" class="row1">
							<?
							$PropertyPositionUp = $row['PropertyPosition'] - 3;
							$PropertyPositionDown = $row['PropertyPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/Property<?=DTR?>PropertyPosition/<?=$PropertyPositionUp?>/Property<?=DTR?>PropertyID/<?=$row['PropertyID']?>/PropertyGroup/<?=$row['PropertyGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpProperty.property.tip')?>" hspace="3"  /></a>
							<a href="<?=setting('url')?><?=input('SID')?>/Property<?=DTR?>PropertyPosition/<?=$PropertyPositionDown?>/Property<?=DTR?>PropertyID/<?=$row['PropertyID']?>/GroupID/<?=$row['PropertyGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownProperty.property.tip')?>" hspace="3"  /></a>
						</td-->						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageProperty/PropertyID/<?=$row['PropertyID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageProperties/Property<?=DTR?>PropertyID/<?=$row['PropertyID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteProperty.property.tip')?>')">[<?=lang('-delete')?>]</a-->
							<select name="manageR<?=$row['PropertyID']?>" onChange="selectLink('manageProperties', 'manageR<?=$row['PropertyID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url')?>manageProperty/PropertyID/<?=$row['PropertyID']?>/PropertyType/<?=input('PropertyType')?>"><?=lang('-edit')?></option>
								<option value="<?=setting('url')?>manageProperties/Property<?=DTR?>PropertyID/<?=$row['PropertyID']?>/actionMode/delete/PropertyType/<?=input('PropertyType')?>"><?=lang('-delete')?></option>
								<option value="<?=setting('url')?>manageProperty/PropertyID/<?=$row['PropertyID']?>/PropertyType/<?=input('PropertyType')?>/viewMode/view"><?=lang('-view')?></option>
							</select>
							
							<!--br/>
							<a href="<?=setting('url')?>manageProperty/PropertyParentID/<?=$row['PropertyParentID']?>/GroupID/<?=input('GroupID')?>/PropertyPosition/<? $newPropertyPosition=$row['PropertyPosition'] + 1; echo $newPropertyPosition; ?>">[<?=lang('AddPropertyAfter.property.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageProperty/PropertyParentID/<?=$row['PropertyID']?>/GroupID/<?=input('GroupID')?>/PropertyPosition/1">[<?=lang('AddPropertyUnder.property.link','nospace')?>]</a-->
						</td>										
					</tr>	
				<? } ?>				
				<tr>  
					<td valign="top" align="center" colspan="5"> 
						<?=getPages($out['pages']['Properties'])?>
					</td> 
				</tr>					
				</table>		
			</td> 
		</tr> 
		<tr> 
			<td valign=top bgcolor="#ffffff">
				<input type="submit" value="<?=lang("-save")?>">
			</td> 
		</tr>		
	</form>	
	<?  }// end of  if(!empty($out['DB']['Properties'][0]['PropertyID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageProperty/PropertyType/<?=input('PropertyType')?>" class="boldLink">[<?=lang('AddProperty.property.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoPropertyFound.property.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>
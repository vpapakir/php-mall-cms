<? if(input('filterMode')=='last'){?>
	<?=boxHeader(array('title'=>'ManageLastReservedProperties.reservedProperty.title'))?>
<? }else{?>
	<?=boxHeader(array('title'=>'ManageReservedProperties.reservedProperty.title'))?>
<? }?>

<?  $reservedPropertyType = input('ReservedPropertyType'); ?>
	<tr> 
	<form name="getReservedProperties" method="post">
	<input type="hidden" name="SID" value="manageReservedProperties" />
	<input type="hidden" name="ReservedPropertyType" value="<?=input('ReservedPropertyType')?>" />
	<td valign=top bgcolor="#ffffff">
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectReservedPropertyActionTypeForList.reservedProperty.tip');
		echo getReference('ReservedProperty.ReservedPropertyActionType','ReservedPropertyActionType',$input['ReservedPropertyActionType'],array('code'=>'Y','type'=>'dropdown','options'=>$options,'action'=>'submit();'))
	?>	
	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectReservedPropertyTypeForList.reservedProperty.tip');
		echo getLists($out['DB']['ReservedPropertyTypes'],$reservedPropertyType,array('name'=>'ReservedPropertyType','id'=>'ReservedPropertyTypeAlias','value'=>'ReservedPropertyTypeName','options'=>$options,'action'=>'submit();'));	
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectReservedPropertyFeaturedOptions.reservedProperty.tip');
		echo getReference('ReservedProperty.ReservedPropertyFeaturedOptions','ReservedPropertyFeaturedOption',$input['ReservedPropertyFeaturedOption'],array('code'=>'Y','type'=>'dropdown','options'=>$options,'action'=>'submit();'))
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectReservedPropertyPermAll.reservedProperty.tip');
		echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','options'=>$options,'action'=>'submit();'))
	?>	
	<?
		$options[0]['id'] = '';
		$options[0]['value'] = lang('SelectReservedPropertyStatusForList.reservedProperty.tip');
		echo getReference('ReservedProperty.ReservedPropertyStatus','ReservedPropertyStatus',input('ReservedPropertyStatus'),array('code'=>'Y','type'=>'dropdown','options'=>$options,'action'=>'submit();'))
	?>	
	<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
	</td> 
	</form>
	</tr> 
	<? if(!empty($out['DB']['ReservedProperties'][0]['ReservedPropertyID'])) {?>
	<form name="manageReservedProperties" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageReservedProperties" />
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="ReservedPropertyType" value="<?=input('ReservedPropertyType')?>" />
		<input type="hidden" name="ReservedPropertyFeaturedOption" value="<?=input('ReservedPropertyFeaturedOption')?>" />
		<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
		<input type="hidden" name="ReservedPropertyStatus" value="<?=input('ReservedPropertyStatus')?>" />
		<input type="hidden" name="searchWord" value="<?=input('searchWord')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageReservedProperty/ReservedPropertyType/<?=input('ReservedPropertyType')?>" class="boldLink">[<?=lang('AddReservedProperty.reservedProperty.link')?>]</a>
					</div>		
					<br/>				
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['ReservedProperties'] as $id=>$row) {?>
					<input type="hidden" name="ReservedProperty<?=DTR?>ReservedPropertyID[<?=$id?>]" value="<?=$row['ReservedPropertyID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13" alt="Type: <?=$row['ReservedPropertyType']?>, Categories: <?=$row['ReservedPropertyCategories']?>"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="ReservedProperty<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="ReservedProperty<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>	
						<td valign="top" align="center" class="row1" width="1%">
							<? if(!empty($row['ReservedPropertyIcon'])) { ?>
								<!-- <img src="<?=setting('urlfiles').$row['ReservedPropertyIcon']?>" border="0"/> -->
								<img src="<?=setting('layout')?>images/icons/picture.gif" width="15" height="13" id="<?=$row['ReservedPropertyID']?>" onmouseover="showDiv('<?=$row['ReservedPropertyID']?>','<?=$row['ReservedPropertyID']?>.content','right')" onmouseout="hideDiv('<?=$row['ReservedPropertyID']?>.content'); return false;" />
								<div id="<?=$row['ReservedPropertyID']?>.content" class="popup" style="width:150px"><img src="<?=setting('urlfiles').$row['ReservedPropertyIcon']?>" border="0"/></div>
							<? } else {?>
								<img src="<?=setting('layout')?>images/icons/nopicture.gif" width="15" height="13"/>
							<? }?>
						</td>																
						<td valign="top" class="row1" width="50%">
							<a href="<?=setting('url')?>manageReservedProperty/ReservedPropertyID/<?=$row['ReservedPropertyID']?>/ReservedPropertyType/<?=input('ReservedPropertyType')?>/viewMode/view"><?=getValue($row['ReservedPropertyTitle'])?></a>
							<br/>
							<?=getFormated($row['ReservedPropertyLocation'],'Location')?>
							<br>
							<?=getValue($row['ReservedPropertyAddress']);?>
						</td>
						<td valign="top" class="row1">
							<?=getFormated($row['ReservedPropertyPrice'],'Money')?>
						</td valign="top" class="row1">
						<td valign="top" class="row1">
							<?=getReferenceValue('ReservedProperty.ReservedPropertyActionType',$row['ReservedPropertyActionType'])?>
						</td>
						<td valign="top" class="row1">
							<?=getListValue($out['DB']['ReservedPropertyTypes'],$row['ReservedPropertyType'],array('id'=>'ReservedPropertyTypeAlias','value'=>'ReservedPropertyTypeName'))?>
						</td>
						<!--td valign="top" class="row1">
							<?
							$ReservedPropertyPositionUp = $row['ReservedPropertyPosition'] - 3;
							$ReservedPropertyPositionDown = $row['ReservedPropertyPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/ReservedProperty<?=DTR?>ReservedPropertyPosition/<?=$ReservedPropertyPositionUp?>/ReservedProperty<?=DTR?>ReservedPropertyID/<?=$row['ReservedPropertyID']?>/ReservedPropertyGroup/<?=$row['ReservedPropertyGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpReservedProperty.reservedProperty.tip')?>" hspace="3"  /></a>
							<a href="<?=setting('url')?><?=input('SID')?>/ReservedProperty<?=DTR?>ReservedPropertyPosition/<?=$ReservedPropertyPositionDown?>/ReservedProperty<?=DTR?>ReservedPropertyID/<?=$row['ReservedPropertyID']?>/GroupID/<?=$row['ReservedPropertyGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownReservedProperty.reservedProperty.tip')?>" hspace="3"  /></a>
						</td-->						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageReservedProperty/ReservedPropertyID/<?=$row['ReservedPropertyID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageReservedProperties/ReservedProperty<?=DTR?>ReservedPropertyID/<?=$row['ReservedPropertyID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteReservedProperty.reservedProperty.tip')?>')">[<?=lang('-delete')?>]</a-->
							<select name="manageR<?=$row['ReservedPropertyID']?>" onChange="selectLink('manageReservedProperties', 'manageR<?=$row['ReservedPropertyID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url')?>manageReservedProperty/ReservedPropertyID/<?=$row['ReservedPropertyID']?>/ReservedPropertyType/<?=input('ReservedPropertyType')?>"><?=lang('-edit')?></option>
								<option value="<?=setting('url')?>manageReservedProperties/ReservedProperty<?=DTR?>ReservedPropertyID/<?=$row['ReservedPropertyID']?>/actionMode/delete/ReservedPropertyType/<?=input('ReservedPropertyType')?>"><?=lang('-delete')?></option>
								<option value="<?=setting('url')?>manageReservedProperty/ReservedPropertyID/<?=$row['ReservedPropertyID']?>/ReservedPropertyType/<?=input('ReservedPropertyType')?>/viewMode/view"><?=lang('-view')?></option>
							</select>
							
							<!--br/>
							<a href="<?=setting('url')?>manageReservedProperty/ReservedPropertyParentID/<?=$row['ReservedPropertyParentID']?>/GroupID/<?=input('GroupID')?>/ReservedPropertyPosition/<? $newReservedPropertyPosition=$row['ReservedPropertyPosition'] + 1; echo $newReservedPropertyPosition; ?>">[<?=lang('AddReservedPropertyAfter.reservedProperty.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageReservedProperty/ReservedPropertyParentID/<?=$row['ReservedPropertyID']?>/GroupID/<?=input('GroupID')?>/ReservedPropertyPosition/1">[<?=lang('AddReservedPropertyUnder.reservedProperty.link','nospace')?>]</a-->
						</td>										
					</tr>	
				<? } ?>				
				<tr>  
					<td valign="top" align="center" colspan="5"> 
						<?=getPages($out['pages']['ReservedProperties'])?>
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
	<?  }// end of  if(!empty($out['DB']['ReservedProperties'][0]['ReservedPropertyID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageReservedProperty/ReservedPropertyType/<?=input('ReservedPropertyType')?>" class="boldLink">[<?=lang('AddReservedProperty.reservedProperty.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoReservedPropertyFound.reservedProperty.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>
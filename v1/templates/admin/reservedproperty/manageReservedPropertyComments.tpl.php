<?=boxHeader(array('title'=>'ManageReservedPropertyComments.reservedProperty.title'))?>
<? $categoryID = input('CategoryID');  $sectionID = input('SectionID'); ?>
	<tr> 
	<form name="getReservedPropertyComments" method="post">
	<input type="hidden" name="SID" value="manageReservedPropertyComments" />
	<input type="hidden" name="ReservedPropertyCommentType" value="<?=input('ReservedPropertyCommentType')?>" />
	<td valign=top bgcolor="#ffffff">
		<? $options[0]['id']=' '; $options[0]['value']=lang('SelectSection.reservedProperty.tip'); ?>
		<?=getLists($out['DB']['SectionsList'],$sectionID,array('name'=>'SectionID','id'=>'code','value'=>'value','options'=>$options,'style'=>'width:200px','action'=>'submit();'))?>
		&nbsp;&nbsp;
		<?=getLists($out['DB']['ReservedPropertyCategories'],$categoryID,array('name'=>'CategoryID','action'=>'submit();'))?>	
		<?
			$options[0]['id'] = '';
			$options[0]['value'] = lang('SelectReservedPropertyPermAll.reservedProperty.tip');
			echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
		?>	
		<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
	</td> 
	</form>
	</tr> 
	<? if(!empty($out['DB']['ReservedPropertyComments'][0]['ReservedPropertyCommentID'])) {?>
	<form name="manageReservedPropertyComments" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageReservedPropertyComments" />
		<input type="hidden" name="actionMode" value="savelist" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
		<input type="hidden" name="ReservedPropertyCommentType" value="<?=input('ReservedPropertyCommentType')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageReservedPropertyComment/CategoryID/<?=input('CategoryID')?>/ReservedPropertyCommentType/<?=input('ReservedPropertyCommentType')?>" class="boldLink">[<?=lang('AddReservedPropertyComment.reservedProperty.link')?>]</a>
					</div>		
					<br/>				
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['ReservedPropertyComments'] as $id=>$row) {?>
					<input type="hidden" name="ReservedPropertyComment<?=DTR?>ReservedPropertyCommentID[<?=$id?>]" value="<?=$row['ReservedPropertyCommentID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="ReservedPropertyComment<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="ReservedPropertyComment<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>																	
						<td valign="top" class="row1" width="70%">
							<?=getValue($row['ReservedPropertyCommentTitle'])?> : <small><?=getFormated($row['TimeCreated'],'DateTime')?></small>
						</td>
						<!--td valign="top" class="row1">
							<?
							$ReservedPropertyCommentPositionUp = $row['ReservedPropertyCommentPosition'] - 3;
							$ReservedPropertyCommentPositionDown = $row['ReservedPropertyCommentPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/ReservedPropertyComment<?=DTR?>ReservedPropertyCommentPosition/<?=$ReservedPropertyCommentPositionUp?>/ReservedPropertyComment<?=DTR?>ReservedPropertyCommentID/<?=$row['ReservedPropertyCommentID']?>/ReservedPropertyCommentGroup/<?=$row['ReservedPropertyCommentGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpReservedPropertyComment.reservedProperty.tip')?>" hspace="3"  /></a>
							<a href="<?=setting('url')?><?=input('SID')?>/ReservedPropertyComment<?=DTR?>ReservedPropertyCommentPosition/<?=$ReservedPropertyCommentPositionDown?>/ReservedPropertyComment<?=DTR?>ReservedPropertyCommentID/<?=$row['ReservedPropertyCommentID']?>/GroupID/<?=$row['ReservedPropertyCommentGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownReservedPropertyComment.reservedProperty.tip')?>" hspace="3"  /></a>
						</td-->						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageReservedPropertyComment/ReservedPropertyCommentID/<?=$row['ReservedPropertyCommentID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageReservedPropertyComments/ReservedPropertyComment<?=DTR?>ReservedPropertyCommentID/<?=$row['ReservedPropertyCommentID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteReservedPropertyComment.reservedProperty.tip')?>')">[<?=lang('-delete')?>]</a-->
							<select name="manageR<?=$row['ReservedPropertyCommentID']?>" onChange="selectLink('manageReservedPropertyComments', 'manageR<?=$row['ReservedPropertyCommentID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url')?>manageReservedPropertyComment/ReservedPropertyCommentID/<?=$row['ReservedPropertyCommentID']?>/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/ReservedPropertyCommentType/<?=input('ReservedPropertyCommentType')?>"><?=lang('-edit')?></option>
								<option value="<?=setting('url')?>manageReservedPropertyComments/ReservedPropertyComment<?=DTR?>ReservedPropertyCommentID/<?=$row['ReservedPropertyCommentID']?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/ReservedPropertyCommentType/<?=input('ReservedPropertyCommentType')?>"><?=lang('-delete')?></option>
							</select>
							
							<!--br/>
							<a href="<?=setting('url')?>manageReservedPropertyComment/ReservedPropertyCommentParentID/<?=$row['ReservedPropertyCommentParentID']?>/GroupID/<?=input('GroupID')?>/ReservedPropertyCommentPosition/<? $newReservedPropertyCommentPosition=$row['ReservedPropertyCommentPosition'] + 1; echo $newReservedPropertyCommentPosition; ?>">[<?=lang('AddReservedPropertyCommentAfter.reservedProperty.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageReservedPropertyComment/ReservedPropertyCommentParentID/<?=$row['ReservedPropertyCommentID']?>/GroupID/<?=input('GroupID')?>/ReservedPropertyCommentPosition/1">[<?=lang('AddReservedPropertyCommentUnder.reservedProperty.link','nospace')?>]</a-->
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
	<?  }// end of  if(!empty($out['DB']['ReservedPropertyComments'][0]['ReservedPropertyCommentID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageReservedPropertyComment/CategoryID/<?=input('CategoryID')?>/ReservedPropertyCommentType/<?=input('ReservedPropertyCommentType')?>" class="boldLink">[<?=lang('AddReservedPropertyComment.reservedProperty.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoReservedPropertyCommentFound.reservedProperty.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>
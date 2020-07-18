<?=boxHeader(array('title'=>'ManagePropertyComments.property.title'))?>
<? $categoryID = input('CategoryID');  $sectionID = input('SectionID'); ?>
	<tr> 
	<form name="getPropertyComments" method="post">
	<input type="hidden" name="SID" value="managePropertyComments" />
	<input type="hidden" name="PropertyCommentType" value="<?=input('PropertyCommentType')?>" />
	<td valign=top bgcolor="#ffffff">
		<? $options[0]['id']=' '; $options[0]['value']=lang('SelectSection.property.tip'); ?>
		<?=getLists($out['DB']['SectionsList'],$sectionID,array('name'=>'SectionID','id'=>'code','value'=>'value','options'=>$options,'style'=>'width:200px','action'=>'submit();'))?>
		&nbsp;&nbsp;
		<?=getLists($out['DB']['PropertyCategories'],$categoryID,array('name'=>'CategoryID','action'=>'submit();'))?>	
		<?
			$options[0]['id'] = '';
			$options[0]['value'] = lang('SelectPropertyPermAll.property.tip');
			echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
		?>	
		<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
	</td> 
	</form>
	</tr> 
	<? if(!empty($out['DB']['PropertyComments'][0]['PropertyCommentID'])) {?>
	<form name="managePropertyComments" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="managePropertyComments" />
		<input type="hidden" name="actionMode" value="savelist" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
		<input type="hidden" name="PropertyCommentType" value="<?=input('PropertyCommentType')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>managePropertyComment/CategoryID/<?=input('CategoryID')?>/PropertyCommentType/<?=input('PropertyCommentType')?>" class="boldLink">[<?=lang('AddPropertyComment.property.link')?>]</a>
					</div>		
					<br/>				
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['PropertyComments'] as $id=>$row) {?>
					<input type="hidden" name="PropertyComment<?=DTR?>PropertyCommentID[<?=$id?>]" value="<?=$row['PropertyCommentID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="PropertyComment<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="PropertyComment<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>																	
						<td valign="top" class="row1" width="70%">
							<?=getValue($row['PropertyCommentTitle'])?> : <small><?=getFormated($row['TimeCreated'],'DateTime')?></small>
						</td>
						<!--td valign="top" class="row1">
							<?
							$PropertyCommentPositionUp = $row['PropertyCommentPosition'] - 3;
							$PropertyCommentPositionDown = $row['PropertyCommentPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/PropertyComment<?=DTR?>PropertyCommentPosition/<?=$PropertyCommentPositionUp?>/PropertyComment<?=DTR?>PropertyCommentID/<?=$row['PropertyCommentID']?>/PropertyCommentGroup/<?=$row['PropertyCommentGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpPropertyComment.property.tip')?>" hspace="3"  /></a>
							<a href="<?=setting('url')?><?=input('SID')?>/PropertyComment<?=DTR?>PropertyCommentPosition/<?=$PropertyCommentPositionDown?>/PropertyComment<?=DTR?>PropertyCommentID/<?=$row['PropertyCommentID']?>/GroupID/<?=$row['PropertyCommentGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownPropertyComment.property.tip')?>" hspace="3"  /></a>
						</td-->						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>managePropertyComment/PropertyCommentID/<?=$row['PropertyCommentID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>managePropertyComments/PropertyComment<?=DTR?>PropertyCommentID/<?=$row['PropertyCommentID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeletePropertyComment.property.tip')?>')">[<?=lang('-delete')?>]</a-->
							<select name="manageR<?=$row['PropertyCommentID']?>" onChange="selectLink('managePropertyComments', 'manageR<?=$row['PropertyCommentID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url')?>managePropertyComment/PropertyCommentID/<?=$row['PropertyCommentID']?>/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/PropertyCommentType/<?=input('PropertyCommentType')?>"><?=lang('-edit')?></option>
								<option value="<?=setting('url')?>managePropertyComments/PropertyComment<?=DTR?>PropertyCommentID/<?=$row['PropertyCommentID']?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/PropertyCommentType/<?=input('PropertyCommentType')?>"><?=lang('-delete')?></option>
							</select>
							
							<!--br/>
							<a href="<?=setting('url')?>managePropertyComment/PropertyCommentParentID/<?=$row['PropertyCommentParentID']?>/GroupID/<?=input('GroupID')?>/PropertyCommentPosition/<? $newPropertyCommentPosition=$row['PropertyCommentPosition'] + 1; echo $newPropertyCommentPosition; ?>">[<?=lang('AddPropertyCommentAfter.property.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>managePropertyComment/PropertyCommentParentID/<?=$row['PropertyCommentID']?>/GroupID/<?=input('GroupID')?>/PropertyCommentPosition/1">[<?=lang('AddPropertyCommentUnder.property.link','nospace')?>]</a-->
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
	<?  }// end of  if(!empty($out['DB']['PropertyComments'][0]['PropertyCommentID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>managePropertyComment/CategoryID/<?=input('CategoryID')?>/PropertyCommentType/<?=input('PropertyCommentType')?>" class="boldLink">[<?=lang('AddPropertyComment.property.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoPropertyCommentFound.property.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>
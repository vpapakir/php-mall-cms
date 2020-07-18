<?=boxHeader(array('title'=>'ManageResourceComments.resource.title'))?>
<? $categoryID = input('CategoryID');  $sectionID = input('SectionID'); ?>
	<tr> 
	<form name="getResourceComments" method="post">
	<input type="hidden" name="SID" value="manageResourceComments" />
	<input type="hidden" name="ResourceCommentType" value="<?=input('ResourceCommentType')?>" />
	<td valign=top bgcolor="#ffffff">
		<? $options[0]['id']=' '; $options[0]['value']=lang('SelectSection.resource.tip'); ?>
		<?=getLists($out['DB']['SectionsList'],$sectionID,array('name'=>'SectionID','id'=>'code','value'=>'value','options'=>$options,'style'=>'width:200px','action'=>'submit();'))?>
		&nbsp;&nbsp;
		<?=getLists($out['DB']['ResourceCategories'],$categoryID,array('name'=>'CategoryID','action'=>'submit();'))?>	
		<?
			$options[0]['id'] = '';
			$options[0]['value'] = lang('SelectResourcePermAll.resource.tip');
			echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
		?>	
		<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
	</td> 
	</form>
	</tr> 
	<? if(!empty($out['DB']['ResourceComments'][0]['ResourceCommentID'])) {?>
	<form name="manageResourceComments" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageResourceComments" />
		<input type="hidden" name="actionMode" value="savelist" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
		<input type="hidden" name="ResourceCommentType" value="<?=input('ResourceCommentType')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageResourceComment/CategoryID/<?=input('CategoryID')?>/ResourceCommentType/<?=input('ResourceCommentType')?>" class="boldLink">[<?=lang('AddResourceComment.resource.link')?>]</a>
					</div>		
					<br/>				
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['ResourceComments'] as $id=>$row) {?>
					<input type="hidden" name="ResourceComment<?=DTR?>ResourceCommentID[<?=$id?>]" value="<?=$row['ResourceCommentID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="ResourceComment<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="ResourceComment<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>																	
						<td valign="top" class="row1" width="70%">
							<?=getValue($row['ResourceCommentTitle'])?> : <small><?=getFormated($row['TimeCreated'],'DateTime')?></small>
						</td>
						<!--td valign="top" class="row1">
							<?
							$ResourceCommentPositionUp = $row['ResourceCommentPosition'] - 3;
							$ResourceCommentPositionDown = $row['ResourceCommentPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/ResourceComment<?=DTR?>ResourceCommentPosition/<?=$ResourceCommentPositionUp?>/ResourceComment<?=DTR?>ResourceCommentID/<?=$row['ResourceCommentID']?>/ResourceCommentGroup/<?=$row['ResourceCommentGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpResourceComment.resource.tip')?>" hspace="3"  /></a>
							<a href="<?=setting('url')?><?=input('SID')?>/ResourceComment<?=DTR?>ResourceCommentPosition/<?=$ResourceCommentPositionDown?>/ResourceComment<?=DTR?>ResourceCommentID/<?=$row['ResourceCommentID']?>/GroupID/<?=$row['ResourceCommentGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownResourceComment.resource.tip')?>" hspace="3"  /></a>
						</td-->						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageResourceComment/ResourceCommentID/<?=$row['ResourceCommentID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceComments/ResourceComment<?=DTR?>ResourceCommentID/<?=$row['ResourceCommentID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteResourceComment.resource.tip')?>')">[<?=lang('-delete')?>]</a-->
							<select name="manageR<?=$row['ResourceCommentID']?>" onChange="selectLink('manageResourceComments', 'manageR<?=$row['ResourceCommentID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url')?>manageResourceComment/ResourceCommentID/<?=$row['ResourceCommentID']?>/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/ResourceCommentType/<?=input('ResourceCommentType')?>"><?=lang('-edit')?></option>
								<option value="<?=setting('url')?>manageResourceComments/ResourceComment<?=DTR?>ResourceCommentID/<?=$row['ResourceCommentID']?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/ResourceCommentType/<?=input('ResourceCommentType')?>"><?=lang('-delete')?></option>
							</select>
							
							<!--br/>
							<a href="<?=setting('url')?>manageResourceComment/ResourceCommentParentID/<?=$row['ResourceCommentParentID']?>/GroupID/<?=input('GroupID')?>/ResourceCommentPosition/<? $newResourceCommentPosition=$row['ResourceCommentPosition'] + 1; echo $newResourceCommentPosition; ?>">[<?=lang('AddResourceCommentAfter.resource.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceComment/ResourceCommentParentID/<?=$row['ResourceCommentID']?>/GroupID/<?=input('GroupID')?>/ResourceCommentPosition/1">[<?=lang('AddResourceCommentUnder.resource.link','nospace')?>]</a-->
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
	<?  }// end of  if(!empty($out['DB']['ResourceComments'][0]['ResourceCommentID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageResourceComment/CategoryID/<?=input('CategoryID')?>/ResourceCommentType/<?=input('ResourceCommentType')?>" class="boldLink">[<?=lang('AddResourceComment.resource.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoResourceCommentFound.resource.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>
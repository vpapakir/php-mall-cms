<?=boxHeader(array('title'=>'ManageResourceLinks.resource.title'))?>
<? $categoryID = input('CategoryID');  $sectionID = input('SectionID'); ?>
	<tr> 
	<form name="getResourceLinks" method="post">
	<input type="hidden" name="SID" value="manageResourceLinks" />
	<input type="hidden" name="ResourceLinkType" value="<?=input('ResourceLinkType')?>" />
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
	<? if(!empty($out['DB']['ResourceLinks'][0]['ResourceLinkID'])) {?>
	<form name="manageResourceLinks" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageResourceLinks" />
		<input type="hidden" name="actionMode" value="savelist" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
		<input type="hidden" name="ResourceLinkType" value="<?=input('ResourceLinkType')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageResourceLink/CategoryID/<?=input('CategoryID')?>/ResourceLinkType/<?=input('ResourceLinkType')?>" class="boldLink">[<?=lang('AddResourceLink.resource.link')?>]</a>
					</div>		
					<br/>				
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['ResourceLinks'] as $id=>$row) {?>
					<input type="hidden" name="ResourceLink<?=DTR?>ResourceLinkID[<?=$id?>]" value="<?=$row['ResourceLinkID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="ResourceLink<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="ResourceLink<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>																	
						<td valign="top" class="row1" width="70%">
							<?=getValue($row['ResourceLinkTitle'])?> : <small><?=getFormated($row['TimeCreated'],'DateTime')?></small>
						</td>
						<!--td valign="top" class="row1">
							<?
							$ResourceLinkPositionUp = $row['ResourceLinkPosition'] - 3;
							$ResourceLinkPositionDown = $row['ResourceLinkPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/ResourceLink<?=DTR?>ResourceLinkPosition/<?=$ResourceLinkPositionUp?>/ResourceLink<?=DTR?>ResourceLinkID/<?=$row['ResourceLinkID']?>/ResourceLinkGroup/<?=$row['ResourceLinkGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpResourceLink.resource.tip')?>" hspace="3"  /></a>
							<a href="<?=setting('url')?><?=input('SID')?>/ResourceLink<?=DTR?>ResourceLinkPosition/<?=$ResourceLinkPositionDown?>/ResourceLink<?=DTR?>ResourceLinkID/<?=$row['ResourceLinkID']?>/GroupID/<?=$row['ResourceLinkGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownResourceLink.resource.tip')?>" hspace="3"  /></a>
						</td-->						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageResourceLink/ResourceLinkID/<?=$row['ResourceLinkID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceLinks/ResourceLink<?=DTR?>ResourceLinkID/<?=$row['ResourceLinkID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteResourceLink.resource.tip')?>')">[<?=lang('-delete')?>]</a-->
							<select name="manageR<?=$row['ResourceLinkID']?>" onChange="selectLink('manageResourceLinks', 'manageR<?=$row['ResourceLinkID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url')?>manageResourceLink/ResourceLinkID/<?=$row['ResourceLinkID']?>/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/ResourceLinkType/<?=input('ResourceLinkType')?>"><?=lang('-edit')?></option>
								<option value="<?=setting('url')?>manageResourceLinks/ResourceLink<?=DTR?>ResourceLinkID/<?=$row['ResourceLinkID']?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/ResourceLinkType/<?=input('ResourceLinkType')?>"><?=lang('-delete')?></option>
							</select>
							
							<!--br/>
							<a href="<?=setting('url')?>manageResourceLink/ResourceLinkParentID/<?=$row['ResourceLinkParentID']?>/GroupID/<?=input('GroupID')?>/ResourceLinkPosition/<? $newResourceLinkPosition=$row['ResourceLinkPosition'] + 1; echo $newResourceLinkPosition; ?>">[<?=lang('AddResourceLinkAfter.resource.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageResourceLink/ResourceLinkParentID/<?=$row['ResourceLinkID']?>/GroupID/<?=input('GroupID')?>/ResourceLinkPosition/1">[<?=lang('AddResourceLinkUnder.resource.link','nospace')?>]</a-->
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
	<?  }// end of  if(!empty($out['DB']['ResourceLinks'][0]['ResourceLinkID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageResourceLink/CategoryID/<?=input('CategoryID')?>/ResourceLinkType/<?=input('ResourceLinkType')?>" class="boldLink">[<?=lang('AddResourceLink.resource.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoResourceLinkFound.resource.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>
<?=boxHeader(array('title'=>'ManageLastLinks.resource.title'))?>
<? $categoryID = input('CategoryID');  $sectionID = input('SectionID'); ?>
	<tr>
		<form name="getResources" method="post">
			<input type="hidden" name="SID" value="homeadmin" />
			<td valign=top bgcolor="#ffffff">
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('SelectResourceCategoriesForList.resource.tip');
				//print_r($out['DB']['ResourceCategories']);
				echo getLists($out['DB']['ResourceCategories'],$categoryID,array('name'=>'CategoryID','id'=>'id','value'=>'value','action'=>'submit();','options'=>$options))
			?>	
			<!-- <?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('SelectResourceTypeForList.resource.tip');
				echo getLists($out['DB']['ResourceTypes'],$resourceType,array('name'=>'ResourceType','id'=>'ResourceTypeAlias','value'=>'ResourceTypeName','action'=>'submit();','options'=>$options));	
			?> -->	
			<?
				$options[0]['id'] = '';
				$options[0]['value'] = lang('SelectResourcePermAll.resource.tip');
				echo getReference('PermAll','PermAll',input('PermAll'),array('code'=>'Y','type'=>'dropdown','action'=>'submit();','options'=>$options))
			?>	
			<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
			</td> 
		</form>
	</tr>
	<? if(!empty($out['DB']['Blogs'][0]['BlogID'])) {?>
	<form name="manageBlogs" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="manageBlogs" />
		<input type="hidden" name="actionMode" value="savelist" />
		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
		<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
		<input type="hidden" name="BlogType" value="<?=input('BlogType')?>" />
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<!-- <br/>
					<div align="center">
					<a href="<?=setting('url')?>manageBlog/CategoryID/<?=input('CategoryID')?>/BlogType/<?=input('BlogType')?>" class="boldLink">[<?=lang('AddBlog.resource.link')?>]</a>
					</div>		
					<br/> -->				
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['Blogs'] as $id=>$row) {?>
					<input type="hidden" name="Blog<?=DTR?>BlogID[<?=$id?>]" value="<?=$row['BlogID']?>"/>
					<tr>
						<td valign="top" class="row1" width="1%">
							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>
						</td>	
						<td valign="top" class="row1" width="1%">
							<? if($row['PermAll']==1) { ?>
								<input type="checkbox" name="Blog<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>
							<? } else {?>
								<input type="checkbox" name="Blog<?=DTR?>PermAll[<?=$id?>]" value="1" />							
							<? } ?>
						</td>																	
						<td valign="top" class="row1" width="70%">
							<?=getValue($row['BlogTitle'])?><!--  : <small><?=getFormated($row['TimeCreated'],'DateTime')?></small> -->
						</td>
						<td valign="top" class="row1" width="70%">
							<small><?=getFormated($row['TimeCreated'],'DateTime')?></small>
						</td>
						<!--td valign="top" class="row1">
							<?
							$BlogPositionUp = $row['BlogPosition'] - 3;
							$BlogPositionDown = $row['BlogPosition'] + 3;
							?>
							<a href="<?=setting('url')?><?=input('SID')?>/Blog<?=DTR?>BlogPosition/<?=$BlogPositionUp?>/Blog<?=DTR?>BlogID/<?=$row['BlogID']?>/BlogGroup/<?=$row['BlogGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpBlog.resource.tip')?>" hspace="3"  /></a>
							<a href="<?=setting('url')?><?=input('SID')?>/Blog<?=DTR?>BlogPosition/<?=$BlogPositionDown?>/Blog<?=DTR?>BlogID/<?=$row['BlogID']?>/GroupID/<?=$row['BlogGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownBlog.resource.tip')?>" hspace="3"  /></a>
						</td-->						
						<td valign="top" class="row1" width="10%" align="right">
							<!--a href="<?=setting('url')?>manageBlog/BlogID/<?=$row['BlogID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageBlogs/Blog<?=DTR?>BlogID/<?=$row['BlogID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteBlog.resource.tip')?>')">[<?=lang('-delete')?>]</a-->
							<select name="manageR<?=$row['BlogID']?>" onChange="selectLink('manageBlogs', 'manageR<?=$row['BlogID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
								<option value="<?=setting('url')?>manageBlog/BlogID/<?=$row['BlogID']?>/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/BlogType/<?=input('BlogType')?>"><?=lang('-edit')?></option>
								<option value="<?=setting('url')?>manageBlogs/Blog<?=DTR?>BlogID/<?=$row['BlogID']?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/BlogType/<?=input('BlogType')?>"><?=lang('-delete')?></option>
							</select>
							
							<!--br/>
							<a href="<?=setting('url')?>manageBlog/BlogParentID/<?=$row['BlogParentID']?>/GroupID/<?=input('GroupID')?>/BlogPosition/<? $newBlogPosition=$row['BlogPosition'] + 1; echo $newBlogPosition; ?>">[<?=lang('AddBlogAfter.resource.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageBlog/BlogParentID/<?=$row['BlogID']?>/GroupID/<?=input('GroupID')?>/BlogPosition/1">[<?=lang('AddBlogUnder.resource.link','nospace')?>]</a-->
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
	<?  }// end of  if(!empty($out['DB']['Blogs'][0]['BlogID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
					<br/>
					<div align="center">
					<a href="<?=setting('url')?>manageBlog/CategoryID/<?=input('CategoryID')?>/BlogType/<?=input('BlogType')?>" class="boldLink">[<?=lang('AddBlog.resource.link')?>]</a>
					</div>		
					<br/>
				<?=lang('NoBlogFound.resource.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>
<?=boxFooter()?>
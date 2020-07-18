<?=boxHeader(array('title'=>'ManageBlogs.resource.title'))?>
<? $categoryID = input('CategoryID');  $sectionID = input('SectionID'); ?>
	<!-- <tr> 
	<form name="getBlogs" method="post">
	<input type="hidden" name="SID" value="manageBlogs" />
	<input type="hidden" name="BlogType" value="<?=input('BlogType')?>" />
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
	</tr> --> 
	<? if(!empty($out['DB']['Blogs'][0]['BlogID'])) {?>
		<form name="manageBlogs" method="post" onSubmit="submitonce(this)">
			<input type="hidden" name="SID" value="manageBlogs" />
			<input type="hidden" name="actionMode" value="savelist" />
			<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
			<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
			<input type="hidden" name="BlogRecordType" value="<?=input('BlogRecordType')?>" />
			<tr> 
				<td valign="top" bgcolor="#ffffff" class="fieldNames">
						<br/>
						<div align="center">
						<a href="<?=setting('url')?>manageBlog/CategoryID/<?=input('CategoryID')?>/BlogType/<?=input('BlogType')?>" class="boldLink">[<?=lang('AddBlog.blog.link')?>]</a>
						</div>		
						<br/>				
						<table bgcolor="#ffffff" cellpadding="0" cellspacing="2" width="100%" border="0">
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
								<td class="row1" width="20%">
									<a href="<?=setting('url')?>manageBlogRecords/BlogID/<?=$row['BlogID']?>"><?=$row['BlogTitle'];?></a>
								</td>
								<!-- <td valign="top">
									<? if(!empty($row['BlogImage'])){?>
										<img src="<?=setting('urlfiles').$row['BlogImage']?>" border="0" />
									<? }?>
								</td> -->
								<td class="row1" align="left">
									<?=$row['BlogContent'];?>
								</td>
								<td valign="top" class="row1" width="5%" align="right">
									<select name="manageR<?=$row['BlogID']?>" onChange="selectLink('manageBlogs', 'manageR<?=$row['BlogID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">
										<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
										<option value="<?=setting('url')?>ManageBlog/BlogID/<?=$row['BlogID']?>/actionMode/editBlog"><?=lang('-edit')?></option>
										<option value="<?=setting('url')?>manageblogs/Blog<?=DTR?>BlogID/<?=$row['BlogID']?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/BlogType/<?=input('BlogType')?>"><?=lang('-delete')?></option>
									</select>
									<!-- <a href="" class="subtitle">[<?=lang('-edit')?>]</a> -->
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
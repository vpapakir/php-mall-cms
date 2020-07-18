<?=boxHeader(array('title'=>'EditBlogs.blog.title'))?>
<? $categoryID = input('CategoryID');  $sectionID = input('SectionID'); ?>
<!-- 	<tr> 
	<form name="getBlogs" method="post">
	<input type="hidden" name="SID" value="manageBlogs" />
	<input type="hidden" name="BlogType" value="<?=input('BlogType')?>" />
	<td valign=top bgcolor="#ffffff">
		<? $options[0]['id']=' '; $options[0]['value']=lang('SelectSection.resource.tip'); ?>
		<?=getLists($out['DB']['SectionsList'],$sectionID,array('name'=>'SectionID','id'=>'code','value'=>'value','options'=>$options,'style'=>'width:200px','action'=>'submit();'))?>
		&nbsp;&nbsp;
		<?=getLists($out['DB']['ResourceCategories'],$categoryID,array('name'=>'CategoryID','action'=>'submit();'))?>	
	</td> 
	</form>
	</tr>
 -->	
 	<?
		$resourceTemplate = 'blog';
		$formName = 'manageBlog';
	?>
	<? if(input('viewMode')=='editBlog' || empty($out['DB']['Blog'][0]['BlogID'])){?>
	<tr>
		<td align="center" colspan="3" class="subtitleline">
			<span class="subtitle"><?=lang('EditBlogTitle.blog.tip')?></span>
		</td>
	</tr>
	<tr>
		<td>
			<form name="manageBlog" method="post" onSubmit="submitonce(this)"  enctype="multipart/form-data">
				<input type="hidden" name="SID" value="<?=input('SID')?>" />
				<? if(input('actionMode')=='add'){?>
					<input type="hidden" name="actionMode" value="add" />
				<? }else{?>
					<input type="hidden" name="actionMode" value="save" />
				<? }?>
				<input type="hidden" name="Blog<?=DTR?>BlogID" value="<?=input('BlogID')?>" />
				<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />
				<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />
				<input type="hidden" name="BlogType" value="<?=input('BlogType')?>" />
				<input type="hidden" name="Blog<?=DTR?>PermAll" value="4" />
				<input type="hidden" name="viewMode" value="view"/>
					
						
			<table width="100%"> 
					<tr>
						<td colspan="2" width="100%">
						<span class="subtitle"><?=lang('Blog.BlogTitle')?>:</span><br/>
						<input type="text" name="Blog<?=DTR?>BlogTitle" value="<?=$out['DB']['Blog'][0]['BlogTitle'];?>" size="78">
						</td>
					</tr>
					<tr>
						<td valign="top">
							<input type="hidden" name="fileField"/>
							<? $fieldName = 'BlogImage';
							  echo getFormated($out['DB']['Blog'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Blog.'.$resourceTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';
							document.'.$formName.'.actionMode.value=\'deletefile\';
							document.'.$formName.'.fileField.value=\''.$fieldName.'\';
							document.'.$formName.'.viewMode.value=\'editBlog\';
							document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>
						</td>
						<td>
							<span class="subtitle"><?=lang('Blog.BlogContent')?>:</span><br/>
							<textarea name="Blog<?=DTR?>BlogContent" cols="24" rows="10"><?=$out['DB']['Blog'][0]['BlogContent'];?></textarea>
							<br/><br/>
							<span class="subtitle"><?=lang('Blog.BlogEmail')?>:</span><br/>
							<input type="text" name="Blog<?=DTR?>BlogEmail" value="<?=$out['DB']['Blog'][0]['BlogEmail'];?>" size="34">
							<br/><br/>
							<span class="subtitle"><?=lang('Blog.BlogStatus')?>:</span><br/>
							<? if(empty($out['DB']['Blog'][0]['BlogStatus'])) { $out['DB']['Blog'][0]['BlogStatus'] = 'active';} ?>
							<?=getReference('Resource.ResourceStatus','Blog'.DTR.'BlogStatus',$out['DB']['Blog'][0]['BlogStatus'],array('code'=>'Y'))?>
							<br/><br/>
							<!-- <span class="subtitle"><? //lang('Blog.blog.BlogCategories')?>:</span><br/> -->
							<?
								/*if(!empty($out['DB']['Blog'][0]['BlogCategoryID']))
								{
									$parentID = $out['DB']['Blog'][0]['BlogCategoryID'];
								}
								else
									{
										$parentID = $categoryID;
									}								
									echo getLists($out['DB']['ResourceCategories'],$parentID,array('name'=>'Blog'.DTR.'BlogCategoryID','attributes'=>'size="10"','type'=>'multiple','style'=>'width=500px;'));	
								*/
							?>
							<!-- <br/><br/> -->
							<!-- <? //lang('Blog.blog.BlogLocation')?>:<br/> -->
							<? //setInput('CountryID','118'); ?>
							<? 
								/*$params['currentValue'] = $out['DB']['Blog'][0]['BlogLocationID'];
								$params['fieldName'] = 'Blog'.DTR.'BlogLocationID';
								$params['id'] = 'id';
								getBox('core.getRegionsDropDwon',array("params"=>$params)); */
							?>
							<!-- <br/><br/> -->
							<!-- <span class="subtitle"><?=lang('Blog.blog.BlogAuthor')?>:</span><br/>
							<input type="text" name="Blog<?=DTR?>BlogAuthor" value="<?=$out['DB']['Blog'][0]['BlogAuthor'];?>" size="25">
							<br/><br/>
							<span class="subtitle"><?=lang('Blog.blog.BlogURL')?>:</span><br/>
							<input type="text" name="Blog<?=DTR?>BlogURL" value="<?=$out['DB']['Blog'][0]['BlogURL'];?>" size="25">
							<br/><br/> -->
							<? if(empty($out['DB']['Blog'][0]['BlogID'])) { ?>
								<input type="submit" value="<?=lang("-add")?>">
							<? } else { ?>
								<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<!-- <input type="button" value="<?=lang("-delete")?>" onClick="document.editResource.actionMode.value='delete';confirmDelete('editResource', '<?=lang("-deleteconfirmation")?>');"> -->
							<? } ?>
						</td>
					</tr>
          	</table> 
			</form>
		</td>
	</tr> 
	<? }else{?>	
	<tr>
		<td align="center" colspan="3" class="subtitleline">
			<span class="subtitle"><?=lang('BlogTitle.blog.tip')?></span>
		</td>
	</tr>
	<tr>
		<td>
			<table bgcolor="#ffffff" cellpadding="0" cellspacing="2" width="100%" border="0">
				<tr>
					<td valign="top">
						<span class="subtitle"><?=$out['DB']['Blog'][0]['BlogTitle'];?></span>
					</td>
					<td valign="top" align="right">
						<a href="<?=setting('url')?><?=input('SID')?>/BlogID/<?=$out['DB']['Blog'][0]['BlogID']?>/viewMode/editBlog" class="subtitle"><?=lang('-editbox')?></a>
					</td>
				</tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td valign="top">
						<? if(!empty($out['DB']['Blog'][0]['BlogImage'])){?>
							<img src="<?=setting('urlfiles').$out['DB']['Blog'][0]['BlogImage']?>" border="0" align="left" />
						<? }?>
						<?=$out['DB']['Blog'][0]['BlogContent'];?>
					</td>
				</tr>
			</table>
		</td>
	</tr>
	<? }?>
	
	<? if(!empty($out['DB']['Blog'][0]['BlogID'])){?>
	
	<? if(input('actionMode')=='add1' || input('viewMode')=='edit'){?>
	<?
		$resourceTemplate = 'blog';
		$formName = 'manageBlogRecord';
	?>
			<tr>
						<td align="center" colspan="3" class="subtitleline">
							<span class="subtitle"><?=lang('EditBlogRecordTitle.blog.tip')?></span>
						</td>
					</tr>
		<tr>
		<td bgcolor="#ffffff">
			<form name="manageBlogRecord" method="post" onSubmit="submitonce(this)"  enctype="multipart/form-data">
				<input type="hidden" name="SID" value="<?=input('SID')?>" />
				<? if(input('actionMode')=='add'){?>
					<input type="hidden" name="actionMode" value="add" />
				<? }else{?>
					<input type="hidden" name="actionMode" value="save" />
				<? }?>
				<input type="hidden" name="viewMode" value="view"/>
				<input type="hidden" name="BlogRecord<?=DTR?>PermAll" value="4" />
				<input type="hidden" name="BlogRecord<?=DTR?>BlogRecordID" value="<?=input('BlogRecordID')?>" />
				<input type="hidden" name="BlogRecord<?=DTR?>BlogID" value="<?=input('BlogID')?>" />
    	 <table width="100%"> 
					<tr>
						<td colspan="2" width="100%">
						<span class="subtitle"><?=lang('BlogRecord.BlogRecordTitle')?>:</span><br/>
						<input type="text" name="BlogRecord<?=DTR?>BlogRecordTitle" value="<?=$out['DB']['BlogRecord'][0]['BlogRecordTitle'];?>" size="78">
						<br/><br/>
						</td>
					</tr>
					<tr>
						<td valign="top">
							<input type="hidden" name="fileField"/>
							<? $fieldName = 'BlogRecordImage'; 
							 echo getFormated($out['DB']['BlogRecord'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Blog.'.$resourceTemplate,'deleteLink'=>'<a href="#" onClick="javascript:document.'.$formName.'.SID.value=\''.input('SID').'\';
							document.'.$formName.'.actionMode.value=\'deletefile\';
							document.'.$formName.'.fileField.value=\''.$fieldName.'\';
							document.'.$formName.'.viewMode.value=\'edit\';
							document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))
							?>
						
						<? //echo "INPUT:'".print_r($input)."'"  ?>
							
						</td>
						<td valign="top">
						<!-- <span class="subtitle"><?=lang('BlogRecord.BlogRecordURL')?>:</span><br/>
						<input type="text" name="BlogRecord<?=DTR?>BlogRecordURL" value="<?=$out['DB']['BlogRecord'][0]['BlogRecordURL'];?>" size="25">
						<br/><br/> -->
						<span class="subtitle"><?=lang('BlogRecord.BlogRecordContent')?>:</span><br/>
						<textarea name="BlogRecord<?=DTR?>BlogRecordContent" cols="24" rows="10"><?=$out['DB']['BlogRecord'][0]['BlogRecordContent'];?></textarea>
						<br/><br/>
						<span class="subtitle"><?=lang('BlogRecord.BlogRecordAuthor')?>:</span><br/>
						<input type="text" name="BlogRecord<?=DTR?>BlogRecordAuthor" value="<?=$out['DB']['BlogRecord'][0]['BlogRecordAuthor'];?>" size="34">
						<br/><br/>
						<span class="subtitle"><?=lang('BlogRecord.BlogRecordStatus')?>:</span><br/>
						<? if(empty($out['DB']['BlogRecord'][0]['BlogRecordStatus'])) { $out['DB']['BlogRecord'][0]['BlogRecordStatus'] = 'active';} ?>
						<?=getReference('Resource.ResourceStatus','BlogRecord'.DTR.'BlogRecordStatus',$out['DB']['BlogRecord'][0]['BlogRecordStatus'],array('code'=>'Y'))?>
						<br/><br/>
						<? if(empty($out['DB']['Blog'][0]['BlogID'])) { ?>
							<input type="submit" value="<?=lang("-add")?>">
						<? } else { ?>
							<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<!-- <input type="button" value="<?=lang("-delete")?>" onClick="document.editResource.actionMode.value='delete';confirmDelete('editResource', '<?=lang("-deleteconfirmation")?>');"> -->
						<? } ?>
						</td>
					</tr>
				</table>	
			</form>
</td>
	</tr> 
	<? }else{?>
	<tr>
		<td width="100%" align="center" class="subtitleline">
			<span class="subtitle"><?=lang('BlogRecordsTitle.blog.tip')?></span>
		</td>
	</tr>
	<tr>
		<td bgcolor="#ffffff">
			<br/>
			<div align="center">
			<a href="<?=setting('url')?>myblog/BlogID/<?=$out['DB']['Blog'][0]['BlogID'];?>/actionMode/add1" class="boldLink">[<?=lang('AddBlogRecord.blog.link')?>]</a>
			</div>		
			<br/>
		</td>
	</tr>
	<? }?>
	<? if(!empty($out['DB']['BlogRecords'][0]['BlogRecordID'])) {?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<? foreach($out['DB']['BlogRecords'] as $id=>$row) {?>
					<table border="0" cellspacing="2" cellpadding="0" width="100%">
						<tr>
							<td valign="center">
								<span class="subtitle"><?=getValue($row['BlogRecordTitle'])?></span>
								<br/>
								<small><?=getFormated($row['TimeCreated'],'DateTime')?></small>
							</td>
							<td valign="top" align="right">
								<a href="<?=setting('url')?><?=input('SID')?>/BlogRecordID/<?=$row['BlogRecordID']?>/BlogID/<?=$out['DB']['Blog'][0]['BlogID']?>/viewMode/edit" class="subtitle"><?=lang('-editbox')?></a>
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
						<tr>
							<td valign="top">
								<? if(!empty($row['BlogRecordImage'])){?>
									<img src="<?=setting('urlfiles').$row['BlogRecordImage']?>" border="0" align="left" />
								<? }?>
								<?=getValue($row['BlogRecordContent'])?>
							</td>
						</tr>
						<tr>
							<td valign="top">
								
							</td>
						</tr>
						<tr><td>&nbsp;</td></tr>
					</table>	
				<? } ?>					
			</td> 
		</tr> 
	<?  }// end of  if(!empty($out['DB']['Blogs'][0]['BlogID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<br/><br/>
				<?=lang('NoBlogRecordFound.blog.tip')?>
				<br/><br/>
			</td> 
		</tr>
	<? } }?>		
<?=boxFooter()?>
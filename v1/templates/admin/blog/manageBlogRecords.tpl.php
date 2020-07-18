<?=boxHeader(array('title'=>$out['DB']['Blog'][0]['BlogTitle']))?>

<? $categoryID = input('CategoryID');  $sectionID = input('SectionID'); ?>

<!-- 	<tr> 

	<form name="getBlogRecords" method="post">

	<input type="hidden" name="SID" value="manageBlogRecords" />

	<input type="hidden" name="BlogRecordType" value="<?=input('BlogRecordType')?>" />

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

 -->	

  	<tr>

		<td>

			<table width="100%">

				<tr>

					<td align="center">

						<a href="<?=setting('url')?>manageblogs" class="subtitle"><?=lang('BackBlog.blog.link')?></a>

					</td>

				</tr>

				<tr><td>&nbsp;</td></tr>

			</table>

		</td>

	</tr>

	<? if(input('actionMode')=='editBlog' || empty($out['DB']['Blog'][0]['BlogID'])){?>

	<?

		$resourceTemplate = 'blog';

		$formName = 'manageBlog';

	?>

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

				<table width="100%">

					<tr>

						<td align="center" colspan="2" class="subtitleline">

							<span class="subtitle"><?=lang('manageBlogTitle.blog.tip')?></span>

						</td>

					</tr>

					<tr>

						<td colspan="2" align="center">

						<span class="subtitle"><?=lang('Blog.blog.BlogTitle')?>:</span><br/>

						<input type="text" name="Blog<?=DTR?>BlogTitle" value="<?=$out['DB']['Blog'][0]['BlogTitle'];?>" size="82">

						</td>

					</tr>

					<tr>

						<td valign="top" align="right">

							<? $fieldName = 'BlogImage';  echo getFormated($out['DB']['Blog'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Blog.'.$resourceTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>

						</td>

						<td>

							<span class="subtitle"><?=lang('Blog.blog.BlogContent')?>:</span><br/>

							<textarea name="Blog<?=DTR?>BlogContent" cols="24" rows="10"><?=$out['DB']['Blog'][0]['BlogContent'];?></textarea>

							<br/><br/>

							<span class="subtitle"><?=lang('Blog.blog.BlogEmail')?>:</span><br/>

							<input type="text" name="Blog<?=DTR?>BlogEmail" value="<?=$out['DB']['Blog'][0]['BlogEmail'];?>" size="41">

							<br/><br/>

							<span class="subtitle"><?=lang('Blog.PermAll')?>:</span><br/>

							<? if(empty($out['DB']['Blog'][0]['PermAll'])) { $out['DB']['Blog'][0]['PermAll'] = 'active';} ?>

							<?=getReference('PermAll','Blog'.DTR.'PermAll',$out['DB']['Blog'][0]['PermAll'],array('code'=>'Y'))?>

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

		<td>

			<table bgcolor="#ffffff" cellpadding="0" cellspacing="2" width="100%" border="0">

				<!-- <tr>

					<td align="center" colspan="3" class="subtitleline">

						<span class="subtitle"><?=lang('manageBlogTitle.blog.tip')?></span>

					</td>

				</tr>

				<tr>

					<td colspan="2" valign="top">

						<span class="subtitle"><?=$out['DB']['Blog'][0]['BlogTitle'];?></span>

					</td>

				</tr> -->

				<tr>

					<td valign="top">

						<? if(!empty($out['DB']['Blog'][0]['BlogImage'])){?>

							<img src="<?=setting('urlfiles').$out['DB']['Blog'][0]['BlogImage']?>" align="left" border="0" />

						<? }?>

						<?=$out['DB']['Blog'][0]['BlogContent'];?>

					</td>

					<!-- <td valign="top" align="right" colspan="2">

						<a href="<?=setting('url')?><?=input('SID')?>/BlogID/<?=$out['DB']['Blog'][0]['BlogID']?>/actionMode/editBlog" class="subtitle">[<?=lang('-edit')?>]</a>

					</td> -->

				</tr>

			</table>

		</td>

	</tr>

	<? }?>

	<tr>

		<td>

			<table width="100%">

				<tr>

					<td align="center" colspan="2" class="subtitleline">

						<span class="subtitle"><?=lang('manageBlogRecord.blog.tip')?></span>

					</td>

				</tr>

			</table>

		</td>

	</tr>

 <? if(input('actionMode')=='add1' || input('actionMode')=='edit'){?>

	<?

		$resourceTemplate = 'blog';

		$formName = 'manageBlogRecord';

	?>

	<tr>

		<td bgcolor="#ffffff">

			<form name="manageBlogRecord" method="post" onSubmit="submitonce(this)"  enctype="multipart/form-data">

				<input type="hidden" name="SID" value="<?=input('SID')?>" />

				<? if(input('actionMode')=='add'){?>

					<input type="hidden" name="actionMode" value="add" />

				<? }else{?>

					<input type="hidden" name="actionMode" value="save" />

				<? }?>

				<input type="hidden" name="BlogRecord<?=DTR?>BlogRecordID" value="<?=input('BlogRecordID')?>" />

				<input type="hidden" name="BlogRecord<?=DTR?>BlogID" value="<?=input('BlogID')?>" />

				<input type="hidden" name="BlogID" value="<?=input('BlogID')?>" />

				<table>

					<tr>

						<td colspan="2">

						<span class="subtitle"><?=lang('BlogRecord.blog.BlogRecordTitle')?>:</span><br/>

						<input type="text" name="BlogRecord<?=DTR?>BlogRecordTitle" value="<?=$out['DB']['BlogRecord'][0]['BlogRecordTitle'];?>" size="75">

						</td> 

					</tr>

					<tr>

						<td valign="top">

							<input type="hidden" name="fileField"/>

							<? $fieldName = 'BlogRecordImage';  echo getFormated($out['DB']['BlogRecord'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Blog.'.$resourceTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>

						</td>

						<td valign="top">

							<span class="subtitle"><?=lang('BlogRecord.blog.BlogRecordContent')?>:</span><br/>

							<textarea name="BlogRecord<?=DTR?>BlogRecordContent" cols="30" rows="10"><?=$out['DB']['BlogRecord'][0]['BlogRecordContent'];?></textarea>

							<br/><br/>

							<span class="subtitle"><?=lang('BlogRecord.blog.BlogRecordAuthor')?>:</span><br/>

							<input type="text" name="BlogRecord<?=DTR?>BlogRecordAuthor" value="<?=$out['DB']['BlogRecord'][0]['BlogRecordAuthor'];?>" size="42">

							<br/><br/>

							<!-- <span class="subtitle"><?=lang('BlogRecord.blog.BlogRecordURL')?>:</span><br/>

							<input type="text" name="BlogRecord<?=DTR?>BlogRecordURL" value="<?=$out['DB']['BlogRecord'][0]['BlogRecordURL'];?>" size="25">

							<br/><br/> -->

							<span class="subtitle"><?=lang('BlogRecord.PermAll')?>:</span><br/>

							<? if(empty($out['DB']['BlogRecord'][0]['PermAll'])) { $out['DB']['BlogRecord'][0]['PermAll'] = 'active';} ?>

							<?=getReference('PermAll','BlogRecord'.DTR.'PermAll',$out['DB']['BlogRecord'][0]['PermAll'],array('code'=>'Y'))?>

							<br/><br/>

							<? if(empty($out['DB']['Blog'][0]['BlogID'])) { ?>

								<input type="submit" value="<?=lang("-add")?>">

							<? } else { ?>

								<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="confirmDelete('manageBlogRecord', '<?=lang("-deleteconfirmation")?>');">

							<? } ?>

						</td>

					</tr>

				</table>

			</form>

		</td>

	</tr>

	<tr>

		<td>

			<br/>

			<div align="center">

			<? if(input('viewMode')=='view'){?>

				<a href="<?=setting('url')?><?=input('SID')?>/BlogID/<?=input('BlogID')?>" class="boldLink">[<?=lang('ViewBlogRecordPermAll.blog.link')?>]</a>

			<? }else{?>

				<a href="<?=setting('url')?><?=input('SID')?>/BlogID/<?=input('BlogID')?>/viewMode/view" class="boldLink">[<?=lang('ViewBlogRecordPermAll.blog.link')?>]</a>

			<? }?>

			</div>		

			<br/>

		</td>

	</tr>

	<? }else{?>

	<tr>

		<td>

			<br/>

			<div align="center">

			<? if(input('viewMode')=='view'){?>

				<a href="<?=setting('url')?><?=input('SID')?>/BlogID/<?=input('BlogID')?>" class="boldLink">[<?=lang('ViewBlogRecordPermAll.blog.link')?>]</a>

			<? }else{?>

				<a href="<?=setting('url')?><?=input('SID')?>/BlogID/<?=input('BlogID')?>/viewMode/view" class="boldLink">[<?=lang('ViewBlogRecordPermAll.blog.link')?>]</a>

			<? }?>

			</div>		

			<br/>

		</td>

	</tr>

	<tr>

		<td bgcolor="#ffffff">

			<br/>

			<div align="center">

			<a href="<?=setting('url')?><?=input('SID')?>/BlogID/<?=input('BlogID')?>/actionMode/add1" class="boldLink">[<?=lang('AddBlogRecord.blog.link')?>]</a>

			</div>		

			<br/>

		</td>

	</tr>

	<? }?>

	<? if(!empty($out['DB']['BlogRecords'][0]['BlogRecordID'])) {?>

	<!-- <form name="manageBlogRecords" method="post" onSubmit="submitonce(this)">

		<input type="hidden" name="SID" value="manageBlogRecords" />

		<input type="hidden" name="actionMode" value="savelist" />

		<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />

		<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />

		<input type="hidden" name="BlogRecordType" value="<?=input('BlogRecordType')?>" /> -->

		<? if(input('viewMode')=='view'){?>

			<tr> 

				<td valign="top" bgcolor="#ffffff" class="fieldNames">

					<table border="0" cellspacing="1" cellpadding="4" width="100%">

					<form  name="manageBlogRecords" method="post" onSubmit="submitonce(this)">

						<input type="hidden" name="SID" value="<?=input('SID')?>" />

						<input type="hidden" name="actionMode" value="savelist" />

						<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />

						<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />

						<input type="hidden" name="BlogRecordType" value="<?=input('BlogRecordType')?>" />

						<input type="hidden" name="BlogID" value="<?=input('BlogID')?>"/>

						<input type="hidden" name="viewMode" value="<?=input('viewMode')?>"/>

						<? foreach($out['DB']['BlogRecords'] as $id=>$row) {?>

						<input type="hidden" name="BlogRecord<?=DTR?>BlogRecordID[<?=$id?>]" value="<?=$row['BlogRecordID']?>" />

						<!-- <input type="hidden" name="BlogRecord<?=DTR?>BlogRecordID[<?=$id?>]" value="<?=$row['BlogRecordID']?>"/> -->

						<tr>

							<td valign="top" class="row1" width="1%" align="right">

								<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>

							</td>	

							<td valign="top" class="row1" width="1%" align="right">

								<? if($row['PermAll']==1) { ?>

									<input type="checkbox" name="BlogRecord<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>

								<? } else {?>

									<input type="checkbox" name="BlogRecord<?=DTR?>PermAll[<?=$id?>]" value="1" />							

								<? } ?>

							</td> 

							<td valign="center" class="row1" colspan="2">

								<span class="subtitle"><?=getValue($row['BlogRecordTitle'])?></span><!-- :<small><?=getFormated($row['TimeCreated'],'DateTime')?></small>  -->

							</td>

							<!--td valign="top" class="row1">

								<?

								$BlogRecordPositionUp = $row['BlogRecordPosition'] - 3;

								$BlogRecordPositionDown = $row['BlogRecordPosition'] + 3;

								?>

								<a href="<?=setting('url')?><?=input('SID')?>/BlogRecord<?=DTR?>BlogRecordPosition/<?=$BlogRecordPositionUp?>/BlogRecord<?=DTR?>BlogRecordID/<?=$row['BlogRecordID']?>/BlogRecordGroup/<?=$row['BlogRecordGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpBlogRecord.resource.tip')?>" hspace="3"  /></a>

								<a href="<?=setting('url')?><?=input('SID')?>/BlogRecord<?=DTR?>BlogRecordPosition/<?=$BlogRecordPositionDown?>/BlogRecord<?=DTR?>BlogRecordID/<?=$row['BlogRecordID']?>/GroupID/<?=$row['BlogRecordGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownBlogRecord.resource.tip')?>" hspace="3"  /></a>

							</td-->

							<td  class="row1">

								<?=getValue($row['BlogRecordContent'])?>

							</td>

							<td class="row1" valign="top" align="right">

								<select name="manageR<?=$row['BlogRecordID']?>" onChange="selectLink('manageBlogRecords', 'manageR<?=$row['BlogRecordID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">

									<option value="0" selected><?=lang('SelectAction.core.tip')?></option>

									<option value="<?=setting('url')?><?=input('SID')?>/BlogRecordID/<?=$row['BlogRecordID']?>/BlogID/<?=input('BlogID')?>/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/BlogRecordType/<?=input('BlogRecordType')?>/actionMode/edit/viewMode/view"><?=lang('-edit')?></option>

									<option value="<?=setting('url')?><?=input('SID')?>/BlogRecord<?=DTR?>BlogRecordID/<?=$row['BlogRecordID']?>/BlogID/<?=input('BlogID')?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/BlogRecordType/<?=input('BlogRecordType')?>viewMode/view"><?=lang('-delete')?></option>

								</select>

							</td>										

						</tr>

						<? } ?>

						<tr> 

							<td valign=top colspan="3" bgcolor="#ffffff">

								<input type="submit" value="<?=lang("-save")?>">

							</td> 

						</tr>		

					</form>	

										

					</table>		

				</td> 

			</tr> 

		<? }else{?>

		<tr> 

			<td valign="top" bgcolor="#ffffff" class="fieldNames">

				<table border="0" cellspacing="0" cellpadding="4" width="100%">

					<? foreach($out['DB']['BlogRecords'] as $id=>$row) {?>

					<!-- <input type="hidden" name="BlogRecord<?=DTR?>BlogRecordID[<?=$id?>]" value="<?=$row['BlogRecordID']?>"/> -->

					<tr>

						<td valign="center" colspan="2">

							<span class="subtitle"><?=getValue($row['BlogRecordTitle'])?></span>

							<br/>

							<small><?=getFormated($row['TimeCreated'],'DateTime')?></small> 

						</td>

						<td align="right">

							<a href="<?=setting('url')?><?=input('SID')?>/BlogRecordID/<?=$row['BlogRecordID']?>/BlogID/<?=input('BlogID')?>/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/BlogRecordType/<?=input('BlogRecordType')?>/actionMode/edit"><?=lang('-editbox')?></a>

						</td>

						<!-- <td valign="top" width="1%" align="right">

							<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>

						</td>	

						<td valign="top" width="1%" align="right">

							<? if($row['PermAll']==1) { ?>

								<input type="checkbox" name="BlogRecord<?=DTR?>PermAll[<?=$id?>]" value="1" checked="checked"/>

							<? } else {?>

								<input type="checkbox" name="BlogRecord<?=DTR?>PermAll[<?=$id?>]" value="1" />							

							<? } ?>

						</td> -->

					</tr>

					<tr>

						<!--td valign="top" class="row1">

							<?

							$BlogRecordPositionUp = $row['BlogRecordPosition'] - 3;

							$BlogRecordPositionDown = $row['BlogRecordPosition'] + 3;

							?>

							<a href="<?=setting('url')?><?=input('SID')?>/BlogRecord<?=DTR?>BlogRecordPosition/<?=$BlogRecordPositionUp?>/BlogRecord<?=DTR?>BlogRecordID/<?=$row['BlogRecordID']?>/BlogRecordGroup/<?=$row['BlogRecordGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpBlogRecord.resource.tip')?>" hspace="3"  /></a>

							<a href="<?=setting('url')?><?=input('SID')?>/BlogRecord<?=DTR?>BlogRecordPosition/<?=$BlogRecordPositionDown?>/BlogRecord<?=DTR?>BlogRecordID/<?=$row['BlogRecordID']?>/GroupID/<?=$row['BlogRecordGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownBlogRecord.resource.tip')?>" hspace="3"  /></a>

						</td-->

						<td valign="top">

							<? if(!empty($row['BlogRecordImage'])){?>

								<img src="<?=setting('urlfiles').$row['BlogRecordImage']?>" border="0" align="left" />

							<? }?>

							<?=getValue($row['BlogRecordContent'])?>

						</td>

					</tr>	

					<tr>

						<td>

							

						</td>

						<td valign="top" align="right">

							<!-- <select name="manageR<?=$row['BlogRecordID']?>" onChange="selectLink('manageBlogRecords', 'manageR<?=$row['BlogRecordID']?>', '<?=lang('AreYouSureToDeleteSection.core.tip')?>', '2')">

								<option value="0" selected><?=lang('SelectAction.core.tip')?></option>

								<option value="<?=setting('url')?><?=input('SID')?>/BlogRecordID/<?=$row['BlogRecordID']?>/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/BlogRecordType/<?=input('BlogRecordType')?>/actionMode/edit"><?=lang('-edit')?></option>

								<option value="<?=setting('url')?><?=input('SID')?>/BlogRecord<?=DTR?>BlogRecordID/<?=$row['BlogRecordID']?>/actionMode/delete/CategoryID/<?=input('CategoryID')?>/SectionID/<?=input('SectionID')?>/BlogRecordType/<?=input('BlogRecordType')?>"><?=lang('-delete')?></option>

							</select> -->

							

						</td>										

					</tr>	

				<? } ?>					

				</table>		

			</td> 

		</tr> 

		<? }?>

	<?  }// end of  if(!empty($out['DB']['BlogRecords'][0]['BlogRecordID']))

		else{

	?>

		<tr> 

			<td valign="top" bgcolor="#ffffff" align="center">

				<br/><br/>

				<?=lang('NoBlogRecordFound.resource.tip')?>

				<br><br>

			</td> 

		</tr>

	<? } ?>		

<?=boxFooter()?>


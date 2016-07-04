<?=boxHeader(array('title'=>'ManageBlog.resource.title'))?>

	

		<tr> 

			<td valign="top" bgcolor="#ffffff" class="fieldNames">

			<?

				$resourceTemplate = 'blog';

				$formName = 'manageBlogs';

			?>

			<form name="manageBlogs" method="post" onSubmit="submitonce(this)" enctype="multipart/form-data">

				<input type="hidden" name="SID" value="manageBlogs" />

				<input type="hidden" name="CategoryID" value="<?=input('CategoryID')?>" />

				<input type="hidden" name="SectionID" value="<?=input('SectionID')?>" />

				<? if(empty($out['DB']['Blog'][0]['BlogID'])) { ?>

				<input type="hidden" name="actionMode" value="add" />

				<? } else { ?>

				<input type="hidden" name="actionMode" value="save" />

				<? } ?>

				<input type="hidden" name="Blog<?=DTR?>BlogID" value="<?=$out['DB']['Blog'][0]['BlogID'];?>" />

				<input type="hidden" name="BlogID" value="<?=$out['DB']['Blog'][0]['BlogID'];?>" />

				<table cellpadding="2" cellspacing="0" width="100%">

					<tr>

						<td width="30%" align="left" valign="top">

						<span class="subtitle"><?=lang('Blog.BlogTitle')?>:</span>

						</td>

						<td align="left">

						<input type="text" name="Blog<?=DTR?>BlogTitle" value="<?=$out['DB']['Blog'][0]['BlogTitle'];?>" size="68">

						</td>

					</tr>

					<tr>

						<td width="30%" align="left" valign="top">

						<span class="subtitle"><?=lang('Blog.BlogImage')?>:</span>

						</td>

						<td valign="top" align="left">

							<input type="hidden" name="fileField"/>

							<? $fieldName = 'BlogImage';  echo getFormated($out['DB']['Blog'][0][$fieldName],'Image','form',array('fieldName'=>$fieldName,'langCode'=>'Blog.'.$resourceTemplate,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?>

						</td>

					</tr>

					<tr>

						<td width="30%" align="left" valign="top">

							<span class="subtitle"><?=lang('Blog.BlogContent')?>:</span>

						</td>

						<td align="left">

							<textarea name="Blog<?=DTR?>BlogContent" cols="24" rows="10"><?=$out['DB']['Blog'][0]['BlogContent'];?></textarea>

						</td>

					</tr>

					<tr>

						<td width="30%" align="left" valign="top">

							<span class="subtitle"><?=lang('Blog.BlogEmail')?>:</span><br/>

						</td>

						<td align="left">

							<input type="text" name="Blog<?=DTR?>BlogEmail" value="<?=$out['DB']['Blog'][0]['BlogEmail'];?>" size="34">

						</td>

					</tr>

					<tr>

						<td width="30%" align="left" class="subtitle" valign="top">

							<?=lang('Blog.PermAll')?>:<br/>

						</td>

						<td align="left">

							<?=getReference('PermAll','Blog'.DTR.'PermAll',$out['DB']['Blog'][0]['PermAll'],array('code'=>'Y'))?>

						</td>

					</tr>

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

					<tr><td width="100%" colspan="2">&nbsp;</td></tr>

					<tr>

						<td width="100%" align="center" colspan="2" bgcolor="efefef" valign="top">

							<? if(empty($out['DB']['Blog'][0]['BlogID'])) { ?>

								<input type="submit" value="<?=lang("-add")?>">

							<? } else { ?>

								<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;<input type="button" value="<?=lang("-delete")?>" onClick="confirmDelete('manageBlogs', '<?=lang("-deleteconfirmation")?>');"> 

							<? } ?>

							&nbsp;&nbsp;<input type="button" value="<?=lang("-cancell")?>" onClick="document.manageBlogs.actionMode.value='cancell';submit();">			

						</td>

					</tr>

				</table>

			</form>	

		</td> 

	</tr> 

<?=boxFooter()?>


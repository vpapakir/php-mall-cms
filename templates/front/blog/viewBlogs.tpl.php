<?=boxHeader(array('title'=>lang('Blogs.blog.title')))?>
<? if(!empty($out['DB']['Blogs'][0]['BlogID'])) { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
			<table width="100%">
				<? if(is_array($out['DB']['Blogs'])){ foreach($out['DB']['Blogs'] as $id=>$row) {?>
						<tr>
							<td class="subtitleline" colspan="3">
								<!-- <a href="<?=$row['BlogURL']?>" target="_blank"> --><!-- </a> -->
								<a href="<?=setting('url')?>viewBlog/BlogID/<?=$row['BlogID']?>"><b><?=$row['BlogTitle']?></b></a>
							</td>
						</tr>
						<tr>	
							<td valign="top">
								<? if(!empty($row['BlogImage'])){?>
									<img src="<?=setting('urlfiles').$row['BlogImage']?>" align="left" border="0" />
								<? }?>
								<?=getFormated($row['BlogContent'],'TEXT')?>
							</td>
							<td valign="top">
								<? if(user('UserID')==$row['UserID']){?><br/><a href="<?=setting('url')?>myblog/BlogID/<?=$row['BlogID']?>/actionMode/editBlog"><?=lang('-editbox')?></a><br/><? }?>
							</td>
						</tr>
				<? } } ?>	
			</table>	
		</td> 
	</tr> 
	<? } ?>
	<!-- <tr> 
		<td valign="top" bgcolor="#ffffff" align="center">
			<br/>
		  	<form name="addLink" method="post">
				<input type="hidden" name="SID" value="addBlog" />
				<input type="hidden" name="category" value="<?=input('category')?>" />
				<input type="hidden" name="SectionID" value="<?=input('SID')?>" />
				<input type="hidden" name="ResourceID" value="<?=input('ResourceID')?>" />
				<input type="hidden" name="resource" value="<?=input('resource')?>" />
				<input type="submit" name="addLink" value="<?=lang('AddBlog.resource.button')?>">
			  </form>
		</td> 
	</tr> --> 
<?=boxFooter()?>

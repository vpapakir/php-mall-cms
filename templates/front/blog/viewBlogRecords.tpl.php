<? if(!empty($out['DB']['BlogRecords'][0]['BlogRecordID'])) { ?>
	<?=boxHeader(array('title'=>$out['DB']['Blog']['BlogTitle']))?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
			<table width="100%">
				<tr><td align="center" class="subtitleline"><span class="subtitle"><?=lang('BlogTitle.blog.tip')?></span></td></tr>
				<tr><td>&nbsp;</td></tr>
				<tr>
					<td valign="top">
						<? //$out['DB']['Blog']['BlogAuthor']?>
						<? if(!empty($out['DB']['Blog']['BlogImage'])){?>
							<img src="<?=setting('urlfiles').$out['DB']['Blog']['BlogImage']?>" align="left" border="0" />
						<? }?>
						<?=$out['DB']['Blog']['BlogContent']?>
					</td>
				</tr>
				<tr><td align="center" class="subtitleline"><span class="subtitle"><?=lang('BlogRecordTitle.blog.tip')?></span></td></tr>
				<tr>
					<td>
						<table>
						<? if(is_array($out['DB']['BlogRecords'])){ foreach($out['DB']['BlogRecords'] as $id=>$row) {?>
								<!-- <a href="<?=$row['BlogRecordURL']?>" target="_blank"></a> -->
									<tr><td>&nbsp;</td></tr>
									<tr>
										<td>
											<b><?=$row['BlogRecordTitle']?></b>
										</td>
										<td>
											<!-- <i><a href="mailto:<?=getFormated($row['BlogRecordEmail'],'Email')?>"><?=lang('Posted.resource.tip')?> <?=getFormated($row['TimeCreated'],'Date')?> <?=lang('PostedBy.resource.tip')?> <?=$row['BlogRecordAuthor']?></a></i> -->
											<? if(user('UserID')==$row['UserID']){?><a href="<?=setting('url')?>myblog/BlogRecordID/<?=$row['BlogRecordID']?>/BlogID/<?=$row['BlogID']?>/actionMode/edit"><?=lang('-editbox')?></a><br/><? }?>
										</td>
									</tr>
									<tr>
										<td>
											<small><?=getFormated($row['TimeCreated'],'DateTime')?></small>
										</td>
									</tr>
									<tr>
										<td>
											<? if(!empty($row['BlogRecordImage'])){?>
												<img src="<?=setting('urlfiles').$row['BlogRecordImage']?>" align="left" border="0" />
											<? }?>
											<?=getFormated($row['BlogRecordContent'],'TEXT')?>
										</td>
									</tr>	
							<? } } ?>
							</table>	
					</td>
				</tr>
			</table>
		</td> 
	</tr> 
	<? }else{ ?>
		<?=boxHeader(array('title'=>lang('BlogRecords.resource.title')))?>
		<tr>
			<td>
				<table width="100%">
					<tr>
						<td align="center">
							<br><br>
							<?=lang('BlogRecordsIsEmpty.blog.title')?>
							<br><br>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	<? }?>
	<!-- <tr> 
		<td valign="top" bgcolor="#ffffff" align="center">
			<br/>
		  	<form name="addLink" method="post">
				<input type="hidden" name="SID" value="addBlogRecord" />
				<input type="hidden" name="category" value="<?=input('category')?>" />
				<input type="hidden" name="SectionID" value="<?=input('SID')?>" />
				<input type="hidden" name="ResourceID" value="<?=input('ResourceID')?>" />
				<input type="hidden" name="resource" value="<?=input('resource')?>" />
				<input type="submit" name="addLink" value="<?=lang('AddBlogRecord.resource.button')?>">
			  </form>
		</td> 
	</tr>  -->
<?=boxFooter()?>

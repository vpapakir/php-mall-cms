<?=boxHeader(array('title'=>'ManageHelpArticleCategories.help.title'))?>
	<? if(!empty($out['DB']['HelpArticleCategories'][0]['HelpArticleCategoryID'])) {?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['HelpArticleCategories'] as $id=>$row) {?>
					<tr>
						<td valign="top" class="row1" width="65%">
							<? $deep=$row['HelpArticleCategoryLevel']*15-15; ?>
							<img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1"/>
							<? if(!empty($row['ResourceCategoryImageButton'])){?>
								<a href="<?=setting('url')?>viewHelpArticles/HelpArticleCategoryID/<?=$row['HelpArticleCategoryID']?>" class="subtitle">
									<img src="<?=setting('urlfiles').getValue($row['HelpArticleCategoryImageButton'])?>" border="0" alt="<?=$row['HelpArticleCategoryID']?>"/>
								</a>
							<? }else{?>
								<a href="<?=setting('url')?>viewHelpArticles/HelpArticleCategoryID/<?=$row['HelpArticleCategoryID']?>" class="subtitle">
									<?=getValue($row['HelpArticleCategoryTitle'])?>
								</a>
							<? }?>
						</td>
					</tr>	
				<? } ?>					
				</table>		
			</td> 
		</tr> 
	<?  }// end of  if(!empty($out['DB']['HelpArticleCategories'][0]['HelpArticleCategoryID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<br><br>
				<?=lang('NoHelpArticleCategoryFound.help.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>
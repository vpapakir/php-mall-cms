<?=boxHeader(array('title'=>'ManageHelpArticles.help.title'))?>
<? $categoryID = input('CategoryID'); $HelpArticleType = input('HelpArticleType'); ?>
	<? if(!empty($out['DB']['FullHelpArticleCategories'][0]['HelpArticleCategoryID'])) {?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['FullHelpArticleCategories'] as $id=>$row) {?>
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
	<tr> 
		<form name="getHelpArticles" method="post">
		<input type="hidden" name="SID" value="<?=input('SID')?>" />
		<input type="hidden" name="HelpArticleType" value="<?=input('HelpArticleType')?>" />
		<input type="hidden" name="HelpArticleClientType" value="<?=input('HelpArticleClientType')?>" />
		<td align="center">	
			<input type="text" size="20" name="searchWord" value="<?=input('searchWord')?>"/> &nbsp; <input type="submit" name="goSearch" value="<?=lang('-search')?>" />
			<!-- <br/><a href="<?=setting('url')?>manageHelpArticleCategories">[<?=lang('EditHelpArticleCategories.help.link')?>]</a> -->
		</td> 
		</form>
	</tr> 
	<tr>
		<td class="subtitleline" align="center">
			<span class="subtitle"><?=lang('HelpArticlesTitle.help.subtitle')?></span>
		</td>
	</tr>
	<? if(!empty($out['DB']['HelpArticles'][0]['HelpArticleID'])) {?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<? foreach($out['DB']['HelpArticles'] as $id=>$row) {?>
					<tr>
						<td valign="top" align="center" class="row1" width="1%">
							<? if(!empty($row['HelpArticleIcon'])) { ?>
								<img src="<?=setting('urlfiles').$row['HelpArticleIcon']?>" border="0"/>
							<? }?>
						</td>																
						<td valign="top" class="row1" width="70%">
							<a href="javascript://" onClick="popup('<?=setting('url')?>viewHelpArticle/HelpArticleID/<?=$row['HelpArticleID']?>/HelpArticleCategoryID/<?=input('HelpArticleCategoryID')?>/windowMode/popup','<?=setting('popupwith')?>','<?=setting('popupheight')?>')">
								<?=getValue($row['HelpArticleTitle'])?>
							</a>
							<br/>
							<?=$row['HelpArticleIntro']?>
						</td>
						<td valign="top">
							<a href="javascript://" onClick="popup('<?=setting('url')?>viewHelpArticle/HelpArticleID/<?=$row['HelpArticleID']?>/HelpArticleCategoryID/<?=input('HelpArticleCategoryID')?>/windowMode/popup','<?=setting('popupwith')?>','<?=setting('popupheight')?>')">
								<?=lang('ReadMore.help.link')?>
							</a>
						</td>
					</tr>
				<? } ?>				
				<tr>  
					<td valign="top" align="center" colspan="5"> 
						<?=getPages($out['pages']['HelpArticles'])?>
					</td> 
				</tr>					
				</table>		
			</td> 
		</tr> 
	<?  }// end of  if(!empty($out['DB']['HelpArticles'][0]['HelpArticleID']))
		else{
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<br><br>
				<?=lang('NoHelpArticleFound.help.tip')?>
				<br><br>
			</td> 
		</tr>
	<? } ?>		
<?=boxFooter()?>
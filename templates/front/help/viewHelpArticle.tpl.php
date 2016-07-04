<?=getBox('HelpArticle.getHelpArticle')?>
<?
	/*$HelpArticleTemplate = input('HelpArticleTemplate');
	$HelpArticleType = $out['DB']['HelpArticle'][0]['HelpArticleType']; if(empty($HelpArticleType)) {$HelpArticleType=$input['HelpArticleType'];}
	if(!empty($HelpArticleType)) {$HelpArticleTypeName = getListValue($out['DB']['HelpArticleTypes'],$HelpArticleType,array('id'=>'HelpArticleTypeAlias','value'=>'HelpArticleTypeName'));}
	if(!empty($HelpArticleTypeName)) {$HelpArticleTypeTitle = ' > '.$HelpArticleTypeName;}
	*/
	$title = lang('AddEditHelpArticle.help.title').$HelpArticleTypeTitle;
?>
<?=boxHeader(array('title'=>$title))?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<table cellspacing="0" cellpadding="0" width="100%">
					<tr>
						<td align="center">
							<? if(!empty($out['DB']['HelpArticle'][0]['HelpArticleIcon'])) { ?>
								<img src="<?=setting('urlfiles').$out['DB']['HelpArticle'][0]['HelpArticleIcon']?>" border="0"/>
							<? }?>
						</td>
					</tr>
					<tr>
						<td valign="top" class="fieldNames">
							<p class="subtitle"><?=getValue($out['DB']['HelpArticle'][0]['HelpArticleTitle'],$langCode);?></p>
							<br/>
							<p><?=getValue($out['DB']['HelpArticle'][0]['HelpArticleIntro'],$langCode);?></p>					
							<p><?=getValue($out['DB']['HelpArticle'][0]['HelpArticleContent'],$langCode);?></p>
							<? if(!empty($out['DB']['HelpArticle'][0]['HelpArticleLink'])){?>
							<br/>
							<?=$out['DB']['HelpArticle'][0]['HelpArticleLink']?>
							<? }?>
						</td>
					</tr>	
				</table>	
			</td> 
		</tr> 
<?=boxFooter()?>

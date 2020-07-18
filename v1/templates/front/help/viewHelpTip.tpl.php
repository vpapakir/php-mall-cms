<? if(!empty($out['DB']['HelpArticle']['HelpArticleID']) || hasRights('root')) { ?>
<?=boxHeader(array('title'=>'HelpTip.help.title'))?>
	<? if(input('windowMode')=='popup'){?>
	 	<tr> 
			<td valign="top" bgcolor="#ffffff">
				<?=getValue($out['DB']['HelpArticle']['HelpArticleIntro'])?>
				<br/>
				<?=getValue($out['DB']['HelpArticle']['HelpArticleContent'])?>
			</td> 
		</tr>
	<? }else{?>
		<tr> 
			<td valign="top" bgcolor="#ffffff">
				<?=getValue($out['DB']['HelpArticle']['HelpArticleIntro'])?>
				<br/>
				<? $HelpArticleContent = getValue($out['DB']['HelpArticle']['HelpArticleContent'])?>
				<? if(!empty($HelpArticleContent)){?>
					<a href="javascript://" onClick="popup('<?=setting('url')?>ReadFullHelp/HelpArticle<?=DTR?>HelpArticleID/<?=$out['DB']['HelpArticle']['HelpArticleID']?>/windowMode/popup','<?=setting('popupwith')?>','<?=setting('popupheight')?>')"><?=lang('ReadFullHelp.help.link')?></a>
				<? }?>
				<? if(hasRights('root')) {?> <br/><a href="<?=setting('url')?>manageHelpTips/TipSection/<?=input('SID')?>"><?=lang('-editbox')?></a><? } ?>
			</td> 
		</tr>
	<? }?>
<?=boxFooter()?>
<? } ?>
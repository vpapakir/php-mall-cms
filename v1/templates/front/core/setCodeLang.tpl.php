<?=boxHeader(array('title'=>'setCodeLang.core.title'))?>
	<!-- <tr> 
		<td valign="top" bgcolor="#ffffff">
			<div class="subtitle"><? //getFormated(setting('PageIntroContent'),'HTML')?></div>
			<? //getFormated(setting('PageContent'),'HTML')?>
			<? if(hasRights('admin') || eregi("\|".user('UserID')."\|",setting('PageAccessEditUsers'))) {?><br/><br/><a href="<?=setting('url').input('SID')?>/viewMode/edit">[<?=lang('-edit')?>]</a> <br/><br/><? } ?>
		</td> 
	</tr> --> 
	<tr> 
		<td valign="top" bgcolor="#ffffff">
			<?=lang('setCodeLang.core.text')?>
		</td> 
	</tr>
<?=boxFooter()?>
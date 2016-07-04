<?
	$viewMode = input('viewMode');
	$entityID = $input['NewsletterID'];
	if(empty($entityID)) {$entityID = $input['Newsletter'.DTR.'NewsletterID'];}
	
	if(empty($entityID)) {
		echo boxHeader(array('title'=>'ManageNewslettersTemplates.newsletter.title'));
	} else {
		echo boxHeader(array('title'=>'ManageNewslettersTemplates.newsletter.title','tabs'=>'manageNewslettersTemplates','tabslink'=>'NewsletterID/'.$entityID));
	  }
?>
<? if (empty($viewMode) || $viewMode=='details') { ?>
<tr> 
	<td valign=top bgcolor="#ffffff">
		<table width="80%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<form name="getNewsletters" method="post">
						<input type="hidden" name="SID" value="<?=input('SID')?>" />
						<input type="hidden" name="NewsletterIsTemplate" value="Y" />
						<tr>
							<td valign=top bgcolor="#ffffff">
								<?
									$options[0]['id']='';	
									$options[0]['value']='- '.lang('NewsletterNew.newsletter.tip').' -';
									echo getLists($out['DB']['Newsletters'],$out['DB']['Newsletter'][0]['NewsletterID'],array('name'=>'NewsletterID','id'=>'NewsletterID','value'=>'NewsletterTitle','action'=>'submit();','style'=>'width:300px;','options'=>$options));	
								?>	
							</td> 
						</tr>
						</form>
					</table>
				</td>
				<td valign="bottom">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<form name="searchNewsletters" method="post">
						<input type="hidden" name="SID" value="<?=input('SID')?>" />
						<input type="hidden" name="NewsletterIsTemplate" value="Y" />
						<tr>
							<td>
								<input type="text" name="searchWord" size="20">
								<input type="submit" value="<?=lang('SearchCode.core.button')?>">
							</td>
						</tr>
					</form>
					</table>
				</td>
			</tr>
		</table>
	</td> 
</tr>
<tr><td align="left"><hr width="80%"/></td></tr>
<tr>
	<td>
		<form name="getNewsletter" method="post">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<input type="hidden" name="actionMode" value="save" />
			<input type="hidden" name="Newsletter<?=DTR?>NewsletterID" value="<?=$out['DB']['Newsletter'][0]['NewsletterID'];?>" />
			<input type="hidden" name="Newsletter<?=DTR?>NewsletterIsTemplate" value="Y" />
			<strong><?=lang('newsletterContentType.newsletter.hint','html')?>:</strong>
			<br/>
			<?=getReference('NewsletterType','Newsletter'.DTR.'NewsletterType',$out['DB']['Newsletter'][0]['NewsletterType'],array('code'=>'Y'))?>
			<br/><br/>
			<strong><?=lang('newsletterFromEmail.newsletter.hint','html')?>:</strong>
			<br/>
			<input type="text" name="Newsletter<?=DTR?>NewsletterFrom" value="<?=$out['DB']['Newsletter'][0]['NewsletterFrom'];?>" size="30">
			<br/>
			<strong><?=lang('newsletterFromName.newsletter.hint','html')?>:</strong>
			<br/>
			<input type="text" name="Newsletter<?=DTR?>NewsletterFromName" value="<?=$out['DB']['Newsletter'][0]['NewsletterFromName'];?>" size="30">
			<br/><br/>
			<strong><?=lang('newsletterSubject.newsletter.hint','html')?>:</strong><br/>
			<input type="text" name="Newsletter<?=DTR?>NewsletterTitle" value="<?=getValue($out['DB']['Newsletter'][0]['NewsletterTitle']);?>" size="70">
			<br/><br/>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				<strong><?=lang('newsletterHtmlData.newsletter.hint','html')?>: </strong><?=$out['DB']['Languages']['languageNames'][$langID]?>
				<br/>
				<?=getFormated(getValue($out['DB']['Newsletter'][0]['NewsletterContent'],$langCode),'HTML','form',array('fieldName'=>'Newsletter'.DTR.'NewsletterContent['.$langCode.']','editorName'=>'NewsletterContent'.$langCode,'editorWidth'=>550,'editorHeight'=>200,'editorToolbar'=>'Default'))?>
				<br/>
			<? } ?>
			<br/>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
				<strong><?=lang('newsletterTextData.newsletter.hint','html')?>: </strong><?=$out['DB']['Languages']['languageNames'][$langID]?>
				<br/>
				<textarea name="Newsletter<?=DTR?>NewsletterContentText[<?=$langCode?>]" cols="50" rows="5"><?=getValue($out['DB']['Newsletter'][0]['NewsletterContentText'],$langCode);?></textarea>
				<br/>
			<? } ?>
			<br/>
			<strong><?=lang('newsletterAdminComments.newsletter.hint','html')?>:</strong>
			<br/>
			<textarea name="Newsletter<?=DTR?>NewsletterComments" cols="50" rows="5"><?=$out['DB']['Newsletter'][0]['NewsletterComments'];?></textarea>
			<br/><br/>
			<? if(empty($out['DB']['Newsletter'][0]['NewsletterID'])) { ?>
				<input type="submit" value="<?=lang("-add")?>">
				<? } else { ?>
				<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;
				<input type="button" value="<?=lang("-delete")?>" onClick="document.getNewsletter.actionMode.value='delete';confirmDelete('getNewsletter', '<?=lang("-deleteconfirmation")?>');">
				  <? } ?>					
				<br/>
		</form>
	</td>
</tr>
<? }?>
<? if ($viewMode=='view') { ?>
<tr> 
	<td valign=top bgcolor="#ffffff">
		<table width="80%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<strong><?=lang('newsletterContentType.newsletter.hint','html')?>: </strong><?=getReferenceValue('NewsletterType',$out['DB']['Newsletter'][0]['NewsletterType'])?>
					<br/>
					<strong><?=lang('newsletterFromEmail.newsletter.hint','html')?>: </strong><?=$out['DB']['Newsletter'][0]['NewsletterFrom'];?>
					<br/>
					<strong><?=lang('newsletterFromName.newsletter.hint','html')?>: </strong><?=$out['DB']['Newsletter'][0]['NewsletterFromName'];?>
					<br/>
					<br/>
					<strong><?=lang('newsletterSubject.newsletter.hint','html')?>: </strong> <?=getValue($out['DB']['Newsletter'][0]['NewsletterTitle']);?>
					<hr/>
					<strong>HTML VERSION OF MESSAGE</strong>
					<hr/>
					<?=getValue($out['DB']['Newsletter'][0]['NewsletterContent'],setting('lang'));?>
					<hr/>
					<strong>TEXT VERSION OF MESSAGE</strong>
					<hr/>
					<textarea rows="5" cols="50" disabled="disabled"><?=getValue($out['DB']['Newsletter'][0]['NewsletterContentText'],setting('lang'));?></textarea>
					<hr/><br/>
				</td>
			</tr>
		</table>
	</td> 
</tr>
<? }?>
<?=boxFooter()?>
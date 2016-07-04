<!-- template for manageNewsletter -->
<?
	$viewMode = input('viewMode');
	$actionMode = input('actionMode');
	$entityID = $input['NewsletterID'];
	if(empty($entityID)) {$entityID = $input['Newsletter'.DTR.'NewsletterID'];}
	
	if(empty($entityID)) {
		echo boxHeader(array('title'=>'ManageNewsletters.newsletter.title'));
	} else {
		echo boxHeader(array('title'=>'ManageNewsletters.newsletter.title','tabs'=>'manageNewsletters','tabslink'=>'NewsletterID/'.$entityID));
	  }
?>
<? if (empty($viewMode) || $viewMode=='details') { ?>
<tr> 
	<td valign=top bgcolor="#ffffff">
		<table width="100%" cellpadding="2" cellspacing="0" border="0">
			<tr>
				<td align="left" width="30%">&nbsp;</td>
				<td align="left">
				<?=getFormated('','DateTime','form',array("formName"=>'QueueNewsletter',"fieldName"=>'Event'.DTR.'TimeStart'))?>
				</td>
			</tr>
<!--			<tr>
				<td valign="bottom">
					<table width="100%" cellpadding="2" cellspacing="0" border="0">
-->					
						<tr>
							<td align="left" width="30%">&nbsp;</td>
							<td align="left">
								<form name="searchNewsletters" method="post">
									<input type="hidden" name="SID" value="<?=input('SID')?>" />
									<input type="text" name="searchWord" size="20">
									<input type="submit" value="<?=lang('SearchCode.core.button')?>">
								</form>
							</td>
						</tr>
						<tr>
							<td align="left" width="30%">&nbsp;</td>
							<td align="left">
								<form name="getNewsletters" method="post">
									<input type="hidden" name="SID" value="<?=input('SID')?>" />
									<?
										$options[0]['id']='';	
										$options[0]['value']='- '.lang('NewsletterNew.newsletter.tip').' -';
										echo getLists($out['DB']['Newsletters'],$out['DB']['Newsletter'][0]['NewsletterID'],array('name'=>'NewsletterID','id'=>'NewsletterID','value'=>'NewsletterTitle','action'=>'submit();','options'=>$options));	
									?>	
								</form>
							</td> 
						</tr>
<!--					</table>
				</td>
				<td valign="bottom" align="center">-->
					<form name="sortNewsletters" method="post">
					<input type="hidden" name="SID" value="<?=input('SID')?>" />
<!--					<table width="100%" cellpadding="0" cellspacing="0" border="0">
-->
						<tr><!-- jb 15.11.05 order by status-->
							<td valign="top" align="left" width="30%" class="subtitle">
								<?=lang('orderByNewsletterStatus.newsletter.hint','html')?>:
							</td>
							<td align="left">
								<?=getReference('NewsletterStatus','NewsletterStatus',$out['NewsletterOrderStatus'],array('code'=>'Y','action'=>'submit();','style'=>'width=130px','isEmptyValue'=>'Y'))?>
							</td>
						</tr><!-- jb 15.11.05 -->
						<tr><!-- jb 15.11.05 order by status-->
							<td valign="top" align="left" width="30%" class="subtitle">
								<?=lang('newsletterSubscribersLists.newsletter.hint','html')?>:
							</td>
							<td align="left">
								<?
									$options[0]['id']='';	
									$options[0]['value']='--- ';
									echo getLists($out['DB']['NewsletterLists'],$out['NewsletterOrderSubscribersGroup'],array('name'=>'NewsletterSubscribersGroup','id'=>'NewsletterListID','value'=>'ListName','action'=>'submit();','style'=>'width=130px','options'=>$options));	
								?>
<!--							</td>
						</tr>  jb 15.11.05 
					</table>-->
					</form>
				</td>
			</tr>
			<tr><td align="left" colspan="2" width="100%"><hr /></td></tr>
		</table>
	</td> 
</tr>
 
<? if(empty($entityID) || $actionMode=='delete') { //if($actionMode=='duplicate')?>
<tr> 
	<td valign=top bgcolor="#ffffff">
		<table width="100%" cellpadding="2" cellspacing="0" border="0">
		<tr>
			<td valign="top" align="left" width="30%" class="subtitle">
				Add new newsletter
			</td>
			<td align="left">
				<form name="getNewsletter" method="post">
					<input type="hidden" name="SID" value="<?=input('SID')?>" />
					<input type="hidden" name="actionMode" value="duplicate" />
					<?
						$options[0]['id']='';	
						$options[0]['value']='-- '.lang('chooseNewsletterTemplate.newsletter.hint','html');
						echo getLists($out['DB']['NewslettersTemplates'],'',array('name'=>'NewsletterID','id'=>'NewsletterID','value'=>'NewsletterTitle','action'=>'submit();','options'=>$options));	
					?>
				</form>
			</td>
		</tr>
		</table>
	</td> 
</tr>
<? } else {?>
<tr> 
	<td valign=top bgcolor="#ffffff">
		<table width="100%" cellpadding="2" cellspacing="0" border="0">
		<form name="getNewsletter" method="post">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<input type="hidden" name="actionMode" value="save" />
			
			<? if($actionMode=='duplicate') {?>
				<input type="hidden" name="Newsletter<?=DTR?>NewsletterID" value="" />
				<input type="hidden" name="Newsletter<?=DTR?>NewsletterTemplate" value="<?=$out['DB']['Newsletter'][0]['NewsletterID'];?>" />
			<? } else {?>
				<input type="hidden" name="Newsletter<?=DTR?>NewsletterID" value="<?=$out['DB']['Newsletter'][0]['NewsletterID'];?>" />
			 <? } ?>
			
			<? if($out['DB']['Newsletter'][0]['NewsletterIsTemplate']=='N') {?>
		<tr>
			<td valign="top" align="left" width="30%" class="subtitle">
				<?=lang('newsletterStatus.newsletter.hint','html')?>:
			</td>
			<td align="left">
				<?=getReference('NewsletterStatus','Newsletter'.DTR.'NewsletterStatus',$out['DB']['Newsletter'][0]['NewsletterStatus'],array('code'=>'Y'))?>
			</td>
		</tr>
			 <? } else { //if add new newsletter from template, status is new by default?>
			 			<input type="hidden" name="Newsletter<?=DTR?>NewsletterStatus" value="new" />
				 <? } ?>
			 
		<tr>
			<td valign="top" align="left" width="30%" class="subtitle">
			<?=lang('newsletterSubscribersLists.newsletter.hint','html')?>:
			</td>
			<td align="left">
			<?
				echo getLists($out['DB']['NewsletterLists'],$out['DB']['Newsletter'][0]['NewsletterSubscriberGroup'],array('name'=>'Newsletter'.DTR.'NewsletterSubscriberGroup','id'=>'NewsletterListID','value'=>'ListName','style'=>'width=130px'));	
			?>
			</td>
		</tr>
		<tr>
			<td valign="top" align="left" width="30%" class="subtitle">
			<?=lang('newsletterContentType.newsletter.hint','html')?>:
			</td>
			<td align="left">
			<?=getReference('NewsletterType','Newsletter'.DTR.'NewsletterType',$out['DB']['Newsletter'][0]['NewsletterType'],array('code'=>'Y','style'=>'width=130px'))?>
			</td>
		</tr>
		<tr>
			<td valign="top" align="left" width="30%" class="subtitle">
			<?=lang('newsletterFromEmail.newsletter.hint','html')?>:
			</td>
			<td align="left">
			<input type="text" name="Newsletter<?=DTR?>NewsletterFrom" value="<?=$out['DB']['Newsletter'][0]['NewsletterFrom'];?>" size="30">
			</td>
		</tr>
		<tr>
			<td valign="top" align="left" width="30%" class="subtitle">
			<?=lang('newsletterFromName.newsletter.hint','html')?>:
			</td>
			<td align="left">
			<input type="text" name="Newsletter<?=DTR?>NewsletterFromName" value="<?=$out['DB']['Newsletter'][0]['NewsletterFromName'];?>" size="30">
			</td>
		</tr>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
		<tr>
			<td valign="top" align="left" width="30%">
				<span class="subtitle"><?=lang('newsletterSubject.newsletter.hint','html')?>:</span> <?=$out['DB']['Languages']['languageNames'][$langID]?>
			</td>
			<td align="left">
				<input type="text" name="Newsletter<?=DTR?>NewsletterTitle[<?=$langCode?>]" value="<?=getValue($out['DB']['Newsletter'][0]['NewsletterTitle'],$langCode);?>" size="70">
			</td>
		</tr>
			<? } ?>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
		<tr>
			<td valign="top" align="left" width="30%">
				<span class="subtitle"><?=lang('newsletterHtmlData.newsletter.hint','html')?>:</span> <?=$out['DB']['Languages']['languageNames'][$langID]?>
			</td>
			<td align="left">
				<?=getFormated(getValue($out['DB']['Newsletter'][0]['NewsletterContent'],$langCode),'HTML','form',array('fieldName'=>'Newsletter'.DTR.'NewsletterContent['.$langCode.']','editorName'=>'NewsletterContent'.$langCode,'editorWidth'=>550,'editorHeight'=>200,'editorToolbar'=>'Default'))?>
			</td>
		</tr>
			<? } ?>
			<? foreach($out['DB']['Languages']['languageCodes'] as $langID=>$langCode) { ?>
		<tr>
			<td valign="top" align="left" width="30%">
				<span class="subtitle"><?=lang('newsletterTextData.newsletter.hint','html')?>: </span><?=$out['DB']['Languages']['languageNames'][$langID]?>
			</td>
			<td align="left">
				<textarea name="Newsletter<?=DTR?>NewsletterContentText[<?=$langCode?>]" cols="50" rows="5"><?=getValue($out['DB']['Newsletter'][0]['NewsletterContentText'],$langCode);?></textarea>
			</td>
		</tr>
			<? } ?>
		<tr>
			<td valign="top" align="left" width="30%" class="subtitle">
			<?=lang('newsletterAdminComments.newsletter.hint','html')?>:
			</td>
			<td align="left">
			<textarea name="Newsletter<?=DTR?>NewsletterComments" cols="50" rows="5"><?=$out['DB']['Newsletter'][0]['NewsletterComments'];?></textarea>
			</td>
		</tr>
		<tr><td width="100%" colspan="2">&nbsp;</td></tr>
		<tr>
			<td align="center" width="100%" colspan="2" bgcolor="efefef">
			<? if(empty($out['DB']['Newsletter'][0]['NewsletterID'])) { ?>
				<input type="submit" value="<?=lang("-add")?>">
				<? } else { ?>
				<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;
				<input type="button" value="<?=lang("-delete")?>" onClick="document.getNewsletter.actionMode.value='delete';confirmDelete('getNewsletter', '<?=lang("-deleteconfirmation")?>');">
				  <? } ?>					
			</td>
		</tr>
		</form>
		</table>
	</td> 
</tr>
<? }?>
<? }?>
<!-- template for manageNewsletter -->
<!-- templates for sendNewsletter -->
<? if ($viewMode=='sendForm') { ?>
<tr>
	<td>
		<table width="80%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<strong><?=lang('newsletterStatus.newsletter.hint','html')?>: </strong><?=getReferenceValue('NewsletterStatus',$out['DB']['Newsletter'][0]['NewsletterStatus'])?>
					<br/>
					<strong><?=lang('newsletterSubscribersLists.newsletter.hint','html')?>: </strong><?=getListValue($out['DB']['NewsletterLists'],$out['DB']['Newsletter'][0]['NewsletterSubscriberGroup'],array('id'=>'NewsletterListID','value'=>'ListName'));?>
					<br/>
					<strong><?=lang('newsletterContentType.newsletter.hint','html')?>: </strong><?=getReferenceValue('NewsletterType',$out['DB']['Newsletter'][0]['NewsletterType'])?>
					<br/>
					<strong><?=lang('newsletterTemplate.newsletter.hint','html')?>: </strong><?=getListValue($out['DB']['NewslettersTemplates'],$out['DB']['Newsletter'][0]['NewsletterTemplate'],array('id'=>'NewsletterID','value'=>'NewsletterTitle'));?>
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
			<tr>
				<td align="center">
					<form name="SendTestNewsletter" method="post">
						<input type="hidden" name="SID" value="sendNewsletter" />
						<input type="hidden" name="NewsletterID" value="<?=$entityID?>" />
						<input type="hidden" name="actionMode" value="sendTest" />
						<input type="hidden" name="viewMode" value="sentTest" />
						<strong><?=lang('newsletterContentType.newsletter.hint','html')?>:</strong>
						<br/>
						<?=getReference('NewsletterType','Test'.DTR.'MailFormat','',array('code'=>'Y','style'=>'width=130px'))?>
						<br/><br/>
						<strong><?=lang('newsletterContentType.newsletter.hint','html')?>:</strong>
						<br/>
						<input type="text" name="Test<?=DTR?>MailTo" value="<?=$user['Email']?>" size="30">
						<br/><br/>
						<input type="submit" name="sendTestNewsletter" value="<?=lang('sendTestNewsletterButton.newsletter.hint','html')?>"/>
					</form>
					<hr size="1"/>
				</td>
			</tr>
			<tr>
				<td align="center">
					<form method="post" name="QueueNewsletter" onSubmit="submitonce(this)">
						<input type="hidden" name="SID" value="sendNewsletter" />
						<input type="hidden" name="actionMode" value="setQueue" />
						<input type="hidden" name="NewsletterID" value="<?=$entityID?>" />
						<input type="hidden" name="viewMode" value="inQueue" />
						<strong><?=lang('timeStartSending.newsletter.hint','html')?>:</strong>
						<br/>
						<!-- <input type="text" name="Test<?=DTR?>MailTo" value="<?=$user['Email']?>" size="30"> -->
						<?=getFormated('','DateTime','form',array("formName"=>'QueueNewsletter',"fieldName"=>'Event'.DTR.'TimeStart'))?>
						<br/><br/>
						<input type="submit" name="queueNewsletter" value="<?=lang('queueNewsletterButton.newsletter.hint','html')?>"/>
					</form>
					<hr size="1"/>
				</td>
			</tr>
			<tr>
				<td align="center">
					<form method="post" name="SendNewsletterNow" onSubmit="submitonce(this)">
						<input type="hidden" name="SID" value="sendNewsletter" />
						<input type="hidden" name="actionMode" value="send" />
						<input type="hidden" name="viewMode" value="sent" />
						<input type="hidden" name="NewsletterID" value="<?=$entityID?>" />
						<input type="submit" name="sendNewsletter" value="<?=lang('sendNewsletterButton.newsletter.hint','html')?>"/>
					</form>
					<hr size="1"/>
				</td>
			</tr>
		</table>
	</td>
</tr>		
<? }?>
<? if ($viewMode=='sent') { ?>
<tr>
	<td>
		Newsletter has been sent.
	</td>
</tr>
<? }?>
<? if ($viewMode=='sentTest') { ?>
<tr>
	<td>
		The test newsletter has been sent to root administrator email address.
	</td>
</tr>
<? }?>
<? if ($viewMode=='inQueue') { ?>
<tr>
	<td>
		Newsletter has been added to queue. It will be sent automatically on setting time.
	</td>
</tr>
<? }?>
<!-- template for sendNewsletter -->
<?=boxFooter()?>
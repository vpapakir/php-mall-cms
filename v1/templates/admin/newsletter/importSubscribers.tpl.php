<?=boxHeader(array('title'=>'importSubscribers.newsletter.title'))?>
<form name="importSubscribers" method="post">
<input type="hidden" name="SID" value="<?=input('SID')?>" />
<input type="hidden" name="actionMode" value="save" />
<input type="hidden" name="viewMode" value="view" />	
<tr>
	<td>
		<table width="80%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<strong><?=lang('importWithSubscriberStatus.newsletter.hint','html')?>:</strong><br/>
					<?=getReference('SubscriberStatus','NewsletterSubscriber'.DTR.'SubscriberStatus','',array('code'=>'Y','style'=>'width=130px'))?>
				</td>
				<td>
					<strong><?=lang('newsletterContentType.newsletter.hint','html')?>:</strong><br/>
					<?=getReference('NewsletterType','NewsletterSubscriber'.DTR.'SubscriberType','',array('code'=>'Y','style'=>'width=130px'))?>
				</td>
				<td>
					<strong><?=lang('importWithSubscriberIsConfirmed.newsletter.hint','html')?>:</strong><br/>
					<?=getReference('YesNo','NewsletterSubscriber'.DTR.'SubscriberIsConfirmed','',array('code'=>'Y','style'=>'width=130px'))?>
				</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td>
		<strong><?=lang('newsletterSubscribersLists.newsletter.hint','html')?>:</strong><br/>
		<? echo getLists($out['DB']['NewsletterLists'],'',array('name'=>'NewsletterSubscriber'.DTR.'SubscriberNewsletters','id'=>'NewsletterListID','value'=>'ListName','type'=>'checkboxes'));?>
		<br/>
		<strong><?=lang('importUpdateMode.newsletter.hint','html')?>:</strong>&#160;<input type="checkbox" name="updateMode" value="update" checked="checked"/>
		<br/><br/>
		<!-- <b>Choose column delimiter:</b>&#160;<input type="text" name="ColumnDelimiter" value=";" size="2"/> -->
		<input type="hidden" name="ColumnDelimiter" value=";"/>
		List format:<br/>
		email1@emaildomain1.com;FirstName1;LastName1<br/>
		email2@emaildomain2.com;FirstName2;LastName2
		<br/><br/>
		<strong><?=lang('Subscribers.newsletter.hint','html')?>:</strong><br/>
		<textarea name="Subscribers" cols="70" rows="10"></textarea>
		<br/><br/>
		<input type="submit" name="import" value="<?=lang('importSubscribersButton.newsletter.hint','html')?>"/>
	</td>
</tr>
</form>
<?=boxFooter()?>
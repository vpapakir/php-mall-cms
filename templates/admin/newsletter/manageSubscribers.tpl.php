<?
	$viewMode = input('viewMode');
	$entityID = $input['NewsletterSubscriberID'];
	if(empty($entityID)) {$entityID = $input['NewsletterSubscriber'.DTR.'NewsletterSubscriberID'];}
	//get SubscriberSourceKey for check if subscriber was imported. than available tab with import options
	$curSubscriberSourceKey = $out['DB']['NewsletterSubscriber'][0]['SubscriberSourceKey'];
	
	if(empty($curSubscriberSourceKey)) {
		echo boxHeader(array('title'=>'ManageNewsletters.newsletter.title'));
	} else {
		echo boxHeader(array('title'=>'ManageNewsletters.newsletter.title','tabs'=>'manageSubscribers','tabslink'=>'NewsletterSubscriberID/'.$entityID));
	  }
?>
<? if ($viewMode=='details' || empty($viewMode) ) { ?>
<tr> 
	<td valign=top bgcolor="#ffffff">
		<table width="80%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td valign="bottom">
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>
								<form name="searchSubscribers" method="post">
									<input type="hidden" name="SID" value="<?=input('SID')?>" />
									<input type="text" name="searchWord" size="20">
									<input type="submit" value="<?=lang('SearchCode.core.button')?>">
								</form>
							</td>
						</tr>
						<tr>
							<td valign=top bgcolor="#ffffff">
								<form name="getSubscribers" method="post">
									<input type="hidden" name="SID" value="<?=input('SID')?>" />
									<?
										$options[0]['id']='';	
										$options[0]['value']='- '.lang('SubscriberNew.newsletter.tip').' -';
										$value = array('SubscriberFirstName','SubscriberLastName');
										echo getLists($out['DB']['NewsletterSubscribers'],$out['DB']['NewsletterSubscriber'][0]['NewsletterSubscriberID'],array('name'=>'NewsletterSubscriberID','id'=>'NewsletterSubscriberID','value'=>$value,'action'=>'submit();','options'=>$options));	
									?>	
								</form>
							</td> 
						</tr>
					</table>
				</td>
				<td valign="bottom" align="center">
					<form name="sortSubscribers" method="post">
					<input type="hidden" name="SID" value="<?=input('SID')?>" />
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr><!-- jb 15.11.05 order by status-->
							<td>
								<strong><?=lang('orderBySubscriberStatus.newsletter.hint','html')?>:</strong><br/>
								<?=getReference('SubscriberStatus','SubscriberStatus',$out['SubscriberOrderStatus'],array('code'=>'Y','action'=>'submit();','style'=>'width=130px','isEmptyValue'=>'Y'))?>
								<br/><br/>
							</td>
						</tr><!-- jb 15.11.05 -->
						<tr><!-- jb 15.11.05 order by status-->
							<td>
								<strong><?=lang('orderBySubscribersLists.newsletter.hint','html')?>:</strong>
								<br/>
								<?
									$options[0]['id']='';	
									$options[0]['value']='--- ';
									echo getLists($out['DB']['NewsletterLists'],$out['OrderSubscribersGroup'],array('name'=>'NewsletterSubscribersGroup','id'=>'NewsletterListID','value'=>'ListName','action'=>'submit();','style'=>'width=130px','options'=>$options));	
								?>
							</td>
						</tr><!-- jb 15.11.05 -->
					</table>
					</form>
				</td>
			</tr>
			<tr><td align="left" colspan="2"><hr /></td></tr>
		</table>
	</td> 
</tr>
<tr>
	<td>
		<form name="getSubscriber" method="post">
			<input type="hidden" name="SID" value="<?=input('SID')?>" />
			<input type="hidden" name="actionMode" value="save" />
			<input type="hidden" name="NewsletterSubscriber<?=DTR?>NewsletterSubscriberID" value="<?=$out['DB']['NewsletterSubscriber'][0]['NewsletterSubscriberID'];?>" />
			<strong><?=lang('subscriberEmail.newsletter.hint','html')?>:</strong>
			<br/>
			<input type="text" name="NewsletterSubscriber<?=DTR?>SubscriberEmail" value="<?=$out['DB']['NewsletterSubscriber'][0]['SubscriberEmail'];?>" size="30">
			<br/>
			<strong><?=lang('NewsletterSubscriber.SubscriberFirstName','html')?>:</strong>
			<br/>
			<input type="text" name="NewsletterSubscriber<?=DTR?>SubscriberFirstName" value="<?=$out['DB']['NewsletterSubscriber'][0]['SubscriberFirstName'];?>" size="30">
			<br/>
			<strong><?=lang('NewsletterSubscriber.SubscriberFirstName','html')?>:</strong>
			<br/>
			<input type="text" name="NewsletterSubscriber<?=DTR?>SubscriberLastName" value="<?=$out['DB']['NewsletterSubscriber'][0]['SubscriberLastName'];?>" size="30">
			<br/>
			<strong><?=lang('NewsletterSubscriber.SubscriberGender','html')?>:</strong>
			<br/>
			<?=getReference('Gender','NewsletterSubscriber'.DTR.'SubscriberGender',$out['DB']['NewsletterSubscriber'][0]['SubscriberGender'],array('code'=>'Y','style'=>'width=130px','isEmptyValue'=>'Y'))?>
			<br/><br/>
			<strong><?=lang('newsletterSubscribersLists.newsletter.hint','html')?>:</strong>
			<br/>
			<? echo getLists($out['DB']['NewsletterLists'],$out['DB']['NewsletterSubscriber'][0]['SubscriberNewsletters'],array('name'=>'NewsletterSubscriber'.DTR.'SubscriberNewsletters','id'=>'NewsletterListID','value'=>'ListName','type'=>'checkboxes'));?>
			<br/>
			<strong><?=lang('newsletterContentType.newsletter.hint','html')?>:</strong>
			<br/>
			<?=getReference('NewsletterType','NewsletterSubscriber'.DTR.'SubscriberType',$out['DB']['NewsletterSubscriber'][0]['SubscriberType'],array('code'=>'Y','style'=>'width=130px'))?>
			<br/>
			<? if(is_array($out['Refs']['Languages'])) {?>
				<br/><strong><?=lang('SubscriberLanguage.newsletter.hint','html')?>:</strong><br/>
				<? 
					$options[0]['id'] = setting('lang');	
					$options[0]['value']='--- ';
					echo getLists($out['Refs']['Languages'],$out['DB']['NewsletterSubscriber'][0]['SubscriberLanguage'],array('name'=>'NewsletterSubscriber'.DTR.'SubscriberLanguage','id'=>'key','value'=>'lang','style'=>'width=130px','options'=>$options));
				?>
				<br/>
			<? } else {?>
					<input type="hidden" name="NewsletterSubscriber<?=DTR?>SubscriberLanguage" value="<?=setting('lang')?>" size="30"/>
			  <? }?>
			<hr align="left" width="80%"/>
			<strong><?=lang('SubscriberStatus.newsletter.hint','html')?>:</strong><br/>
			<?=getReference('SubscriberStatus','NewsletterSubscriber'.DTR.'SubscriberStatus',$out['DB']['NewsletterSubscriber'][0]['SubscriberStatus'],array('code'=>'Y','style'=>'width=130px'))?>
			<br/><br/>
			<strong><?=lang('SubscriberIsConfirmed.newsletter.hint','html')?>:</strong><br/>
			<?=getReference('YesNo','NewsletterSubscriber'.DTR.'SubscriberIsConfirmed',$out['DB']['NewsletterSubscriber'][0]['SubscriberIsConfirmed'],array('code'=>'Y','style'=>'width=130px'))?>
			<br/><br/>
			<strong><?=lang('newsletterAdminComments.newsletter.hint','html')?>:</strong>
			<br/>
			<textarea name="NewsletterSubscriber<?=DTR?>SubscriberComments" cols="50" rows="5"><?=$out['DB']['NewsletterSubscriber'][0]['SubscriberComments'];?></textarea>
			<br/><br/>
			<? if(empty($out['DB']['NewsletterSubscriber'][0]['NewsletterSubscriberID'])) { ?>
				<input type="submit" value="<?=lang("-add")?>">
				<? } else { ?>
				<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;
				<input type="button" value="<?=lang("-delete")?>" onClick="document.getSubscriber.actionMode.value='delete';confirmDelete('getSubscriber', '<?=lang("-deleteconfirmation")?>');">
				  <? } ?>					
				<br/>
		</form>
	</td>
</tr>
<? }//if ($viewMode=='main' || empty($viewMode) ) ?>
<? if($viewMode=='options') { ?>
<tr>
	<td>
		<? if(!empty($curSubscriberSourceKey)) { ?>
			<div>
				this subscriber was imported<br/><br/>
				<? 
					$urlparams = 'NewsletterSubscriberID/'.$entityID.'/'.'ImportSourceKey/'.$out['DB']['NewsletterSubscriber'][0]['SubscriberSourceKey']; 
					$sid = 'manageSubscribers';
					//$sid = 'importSubscribers';
				?>
				<a href="<?=setting('url')?><?=$sid?>/actionMode/blockImported/<?=$urlparams?>">Please click here to block all subscribers imported from this file</a><br/><br/>
				<a href="<?=setting('url')?><?=$sid?>/actionMode/deleteImported/<?=$urlparams?>">Please click here to delete all subscribers imported from this file</a>
			</div>
		<? } else {?>
				there is no options for this subscriber
		  <? }?>
	</td>
</tr>
<? }//if ($viewMode=='details' || empty($viewMode) ) ?>
<?=boxFooter()?>
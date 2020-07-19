<? if($input['windowMode']!='export')  {?>
<?=boxHeader(array('title'=>'ExportNewsletters.newsletter.title'));print_r($out['DB']['NewsletterSubscribers']);?>
<tr>
	<td>
		<table width="80%" cellpadding="0" cellspacing="0" border="0">
			<tr>
				<td>
					<table width="100%" cellpadding="0" cellspacing="0" border="0">
						<tr>
							<td>
								<form name="sortSubscribers" method="post">
									<input type="hidden" name="SID" value="<?=input('SID')?>" />
									<input type="hidden" name="actionMode" value="export" />
									<input type="hidden" name="windowMode" value="export" />
									<strong><?=lang('orderBySubscriberStatus.newsletter.hint','html')?>:</strong><br/>
									<?
										$options[0]['id']='';	
										$options[0]['value']='- All';
										echo getReference('SubscriberStatus','SubscriberStatus',$out['SubscriberOrderStatus'],array('code'=>'Y','style'=>'width=130px','options'=>$options))?>
									<br/><br/>
									<strong><?=lang('orderBySubscribersLists.newsletter.hint','html')?>:</strong>
									<br/>
									<?
										$options[0]['id']='';	
										$options[0]['value']='- All Groups';
										echo getLists($out['DB']['NewsletterLists'],'',array('name'=>'NewsletterSubscribersGroup','id'=>'NewsletterListID','value'=>'ListName','style'=>'width=130px','options'=>$options));	
									?>
									<br/><br/>
									<input type="radio" name="exportType" value="csv" checked="checked" />Export subscribers CSV<br/>
									<input type="radio" name="exportType" value="email" />Export subscribers emails list<br/>
									<br/>
									<input type="submit" value="<?=lang("exportSubscribers.newsletter.button")?>">
								</form>
							</td>
						</tr>
					</table>
				</td>
			</tr>
		</table>
	</td>
</tr>
<?=boxFooter()?>
<? } else {?>
<?
		/*
		printf("Column %d:\n", $currentfield); 
        printf("Name:     %s\n", $finfo->name);
        printf("Table:    %s\n", $finfo->table);
        printf("max. Len: %d\n", $finfo->max_length);
        printf("Flags:    %d\n", $finfo->flags);
        printf("Type:     %d\n\n", $finfo->type);
		*/
		
		print($out['ExportedSubscribers']);
?>
<? }?>
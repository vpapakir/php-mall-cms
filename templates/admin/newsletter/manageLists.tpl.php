<? echo boxHeader(array('title'=>'ManageNewsletterLists.newsletter.title')); ?>
<tr> 
	<td valign=top bgcolor="#ffffff">
		<table width="100%" cellpadding="2" cellspacing="0" border="0">
			<tr>
				<td valign="bottom">
					<table width="100%" cellpadding="2" cellspacing="0" border="0">
						<tr>
							<td width="30%">&nbsp;</td>
							<td align="left">
								<form name="searchNewsletters" method="post">
									<input type="hidden" name="SID" value="<?=input('SID')?>" />
									<input type="text" name="searchWord" size="20">
									<input type="submit" value="<?=lang('SearchCode.core.button')?>">
								</form>
							</td>
						</tr>
						<tr>
							<td width="30%">&nbsp;</td>
							<td valign=top bgcolor="#ffffff">
								<form name="getNewsletters" method="post">
									<input type="hidden" name="SID" value="<?=input('SID')?>" />
									<?
										$options[0]['id']='';	
										$options[0]['value']='- '.lang('NewsletterListNew.newsletter.tip').' -';
										echo getLists($out['DB']['NewsletterLists'],$out['DB']['NewsletterList'][0]['NewsletterListID'],array('name'=>'NewsletterListID','id'=>'NewsletterListID','value'=>'ListName','action'=>'submit();','options'=>$options));	
									?>	
								</form>
							</td> 
						</tr>
					</table>
				</td>
			</tr>
			<tr><td align="left" colspan="2"><hr /></td></tr>
		</table>
	</td> 
</tr>
<tr> 
	<td valign=top bgcolor="#ffffff">
		<table width="100%" cellpadding="2" cellspacing="0" border="0">
			<tr>
				<td align="left" width="30%" class="subtitle">
					<form name="getNewsletterList" method="post">
						<input type="hidden" name="SID" value="<?=input('SID')?>" />
						<input type="hidden" name="actionMode" value="save" />
						<input type="hidden" name="NewsletterList<?=DTR?>NewsletterListID" value="<?=$out['DB']['NewsletterList'][0]['NewsletterListID'];?>" />
						
						<?=lang('newsletterListName.newsletter.hint','html')?>:
				</td>
				<td align="left">
						<input type="text" name="NewsletterList<?=DTR?>ListName" value="<?=$out['DB']['NewsletterList'][0]['ListName'];?>" size="30">
				</td>
			</tr>
			<tr>
				<td align="left" width="30%" class="subtitle">
						<?=lang('newsletterListDescription.newsletter.hint','html')?>:
				</td>
				<td align="left">
						<textarea name="NewsletterList<?=DTR?>ListDescription" cols="50" rows="5"><?=$out['DB']['NewsletterList'][0]['ListDescription'];?></textarea>
				</td>
			</tr>
			<tr>
				<td align="left" width="30%" class="subtitle">
						<?=lang('newsletterListComments.newsletter.hint','html')?>:
				</td>
				<td align="left">
						<textarea name="NewsletterList<?=DTR?>ListComments" cols="50" rows="5"><?=$out['DB']['NewsletterList'][0]['ListComments'];?></textarea>
				</td>
			</tr>
			<tr>
				<td align="left" width="30%" class="subtitle">
						<?=lang('newsletterListPermAll.newsletter.hint','html')?>:
				</td>
				<td align="left">
						<?=getReference('PermAll','NewsletterList'.DTR.'PermAll',$out['DB']['NewsletterList'][0]['PermAll'],array('code'=>'Y','style'=>'width=130px'))?>
				</td>
			</tr>
			<tr><td width="100%" colspan="2">&nbsp;</td></tr>
			<tr>
				<td align="center" width="100%" bgcolor="efefef" colspan="2">
						<? if(empty($out['DB']['NewsletterList'][0]['NewsletterListID'])) { ?>
							<input type="submit" value="<?=lang("-add")?>">
							<? } else { ?>
							<input type="submit" value="<?=lang("-save")?>">&nbsp;&nbsp;
							<input type="button" value="<?=lang("-delete")?>" onClick="document.getNewsletterList.actionMode.value='delete';confirmDelete('getNewsletterList', '<?=lang("-deleteconfirmation")?>');">
							  <? } ?>					
				</td>
					</form>
			</tr>
					
		</table>
	</td> 
</tr>
<?=boxFooter()?>
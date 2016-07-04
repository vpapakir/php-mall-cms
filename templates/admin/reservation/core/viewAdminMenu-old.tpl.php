<? if(!empty($user['UserID'])) {?>
<? if(user('Company')) {$title=user('Company');} elseif (user('FirstName')) {$title=user('FirstName').' '.user('LastName');} else {$title=user('UserName');} ?>
<?=boxHeader(array('title'=>$title))?>
	<tr> 
		<td valign=top bgcolor="#ffffff">
			<a href="<?=setting('rooturl')?>go/home/frontBackLinkAction/do/"><b><?=lang('BackToFront.core.link')?></b></a>
			<br/><br/>
			<? if(count($out['DB']['Owners'])>1) { ?>
			<? if(setting('OwnerID')=='root') { ?>
				<a href="<?=setting('rooturl')?>admshop/"><b><?=lang('GoToShop.core.link')?></b></a>
			<? } else { ?>
				<a href="<?=setting('rooturl')?>adm/"><b><?=lang('GoToRoot.core.link')?></b></a>
			<? } ?>
			<br/>
			<? } ?>
		</td> 
	</tr>	
	<tr> 
		<td valign=top bgcolor="#ffffff">
			<? foreach($out['DB']['Sections'] as $id=>$row) {?>
				<? $deep=$row['SectionLevel']*15-15; ?>
				<table cellspacing="0" cellpadding="0" border="0">	
						<tr>
							<td width="<?=$deep?>">&nbsp;</td>
							<td>
								<!-- <img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1"/> -->
								<? if($row['SectionAlias']=='support') { ?>
								<a href="javascript:popup('http://coorda.com/coobox/support/support_mailbox.php?serial=<?=setting('SystemLicense')?>','570','570')"><?=getValue($row['SectionName'])?></a>
								<? } else { ?>
								<a href="<?=setting('url').$row['SectionAlias']?>/"><?=getValue($row['SectionName'])?></a>
								<? } ?>
							</td>
						</tr>
					</table>
			<? } ?>
			<? /*
			foreach($out['DB'] as $row)
			{
				?>
					<a href="<?=setting('url')?><?=$row['SectionAlias']?>"><?=$row['SectionName']?></a><br/>
				<?
			}
			*/
			?>
		</td> 
	</tr> 
<?=boxFooter()?>
<? } ?>
<?=boxHeader(array('title'=>'MyOwner.core.title'));
	if (count($out['DB']['Owner'])>0) { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
			<div align="center">
				<br/>
				<?=lang('YourOwnerURL.core.tip')?>:
				<br/>
				<a href="http://<?=$out['DB']['Owner'][0]['OwnerDomain']?>" target="_blank">http://<?=$out['DB']['Owner'][0]['OwnerDomain']?></a>
				<? if(setting('OwnerType')!='root') { ?>
				<? } else { ?>
				<br/><br/>
				<a href="<?=setting('rooturl')?>go/<?=$out['DB']['Owner'][0]['OwnerCode']?>.<?=setting('lang')?>/myWebsite/">[<?=lang('EditOwnerSettings.core.link')?>]</a>
				<br/><br/>
				<? } ?>
			</div>
		</td> 
	</tr>
	<? } else { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
			<?=lang('NoOwner.core.tip')?>
			<br/><br/>
			<a href="<?=setting('url')?>myWebsite/">[<?=lang('AddOwnerLink.core.link')?>]</a>
			<br/><br/>
		</td> 
	</tr> 
	<? } ?>
<?=boxFooter()?>
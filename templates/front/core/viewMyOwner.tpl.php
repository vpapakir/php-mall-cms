<?=boxHeader(array('title'=>'MyOwner.core.title')); 
	if (count($out['DB']['Owner'])>0) { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
			<?=lang('YourOwnerIntro.core.tip')?>
			<br/>
			<div align="center">
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
	<? if(setting('OwnerType')!='root') { ?>
	<tr> 
		<td valign="top" bgcolor="#ffffff" align="center">
			<a href="<?=setting('url')?>ownerSitemap">[<?=lang('ownerSitemap.core.link')?>]</a>
		</td> 
	</tr>		
	<? getBox('core.editOwnerSettings')?>
	<? } ?>
	<? } else { ?>
	<? getBox('core.registerOwner')?>
	<? } ?>
<?=boxFooter()?>
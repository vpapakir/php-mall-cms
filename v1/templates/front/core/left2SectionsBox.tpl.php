<?=boxHeader(array('title'=>lang('AboutUsMenu.core.title')))?>
	<tr> 
	<td valign="top">
		<? if(is_array($out['DB']['Sections'])) { foreach($out['DB']['Sections'] as $id=>$row) {?>
			<? //$deep=$row['SectionLevel']*15-15; ?>
			<? //if($row['SectionLevel']==1) { ?>
				<!--img src="<?=setting('layout')?>images/_clear.gif" width="1" height="1"/-->
				<? if(!empty($row['SectionArguments'])) { ?>
				<a href="<?=setting('url').$row['SectionAlias'].'/'.$row['SectionArguments']?>"><? if($row['SectionLevel']>1) {?>- <? } ?><?  $sectionButton = getValue($row['SectionButton']); if(!empty($sectionButton)) {?><img src="<?=setting('urlfiles').$sectionButton?>" border="0"/><? }else{?><?=getValue($row['SectionName'])?><? }?></a>
				<? } else { ?>
				<a href="<?=setting('url').$row['SectionAlias']?>"><? if($row['SectionLevel']>1) {?>- <? } ?><?  $sectionButton = getValue($row['SectionButton']); if(!empty($sectionButton)) {?><img src="<?=setting('urlfiles').$sectionButton?>" border="0"/><? }else{?><?=getValue($row['SectionName'])?><? }?></a>
				<? } ?>
				<br/>
			<? //} ?>
		<? } } ?>
		<? if (hasRights('admin')) { ?><a href="<?=setting('adminurl')?>manageSections/SectionGroupCode/left2/frontBackLinkAction/save/"><?=lang('-editbox')?></a> <? } ?>
	</td> 
	</tr> 
<?=boxFooter()?>

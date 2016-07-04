<? if(!empty($user['UserID'])) { ?>
	<? if(is_array($out['DB']['Sections'])) { foreach($out['DB']['Sections'] as $row) { ?><? if(!empty($row['SectionLink'])) { ?> <a href="<?=$row['SectionLink']?>"><? } else { ?> <a href="<?=setting('url').$row['SectionAlias'] ?>"> <? } ?><? $sectionButton = getValue($row['SectionButton']); if(!empty($sectionButton)) { ?><img src="<?=setting('urlfiles').$sectionButton?>" alt="<?=getValue($row['SectionName'])?>" height="16" hspace="5" border="0"/><? } else { ?><?=getValue($row['SectionName'])?><? } ?></a>
	<? }} ?>
<? } ?>
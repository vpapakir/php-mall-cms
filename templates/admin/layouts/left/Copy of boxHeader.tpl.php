<table border=0 cellpadding=5 cellspacing=1 bgcolor="#999999" width="100%"> 
	<tr> 
		<td height=28  valign=middle bgcolor="#eeeeee">
			<? if(is_array($out['DB']['tabs'])) { foreach($out['DB']['tabs'] as $row) { ?>
			<a href="<?=setting('url').$row['TabLinkValue'].'/'.$out['tabslink']?>/tabLink/<?=$row['TabLinkID']?>/" target="<?=$row['TabLinkTarget']?>"><b>[<?=getValue($row['TabLinkName'])?>]</b></a>
			<? } ?> 
			<? if(hasRights('root')) { ?><a href="<?=setting('url')?>manageTabLinks/TabLinkAlias/<?=$out['tabs']?>/" target="_blank">[+]</a> <? } ?>
			<? } ?>
		</td> 
	</tr>
	<tr> 
		<td height=23 width=100% valign=middle bgcolor="#006699"><p class="center"><span class="title"><?=lang($out['title'])?></span></p></td> 
	</tr>
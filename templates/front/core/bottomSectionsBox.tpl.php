<? if(is_array($out['DB']['Sections'])) { ?> 
			<table border="0" cellspacing="0" cellpadding="2">
			  <tr>
			<? foreach($out['DB']['Sections'] as $id=>$row) {?>
				<td>
					<? if($row['SectionLevel']==1) { ?>	
						<? if(!empty($row['SectionLink'])) { ?> <a href="<?=$row['SectionLink']?>">
						<? } else { ?> <a href="<?=setting('url').$row['SectionAlias'].'/'.$row['SectionArguments']?>"> <? } ?>
						<? $sectionButton = getValue($row['SectionButton']); if(!empty($sectionButton)) { ?><img src="<?=setting('urlfiles').$sectionButton?>" border="0"/>
						<? } else { ?><?=getValue($row['SectionName'])?><? } ?>
						</a>
					<? } ?>
				 &nbsp; &nbsp;</td>
			<? } ?>
			  </tr>
			</table>
<? } else { ?> &nbsp; <? } ?>
<? if(is_array($out['DB']['Sections'])) { ?> 
	<? 
		$csoutertable = setting('linkbar.csoutertable');
		if(empty($csoutertable)) $csoutertable = 0;
		$cpoutertable = setting('linkbar.cpoutertable');
		if(empty($cpoutertable)) $cpoutertable = 0;
		$bgcoloroutertable = setting('linkbar.bgcoloroutertable');
		$csinnertable = setting('linkbar.csinnertable');
		if(empty($csinnertable)) $csinnertable = 0;
		$cpinnertable = setting('linkbar.cpinnertable');
		if(empty($cpinnertable)) $cpinnertable = 0;
		$bgcolorinnertable = setting('linkbar.bgcolorinnertable');
	?>
	<table width="100%" align="center" border="0" cellspacing="<?=$csoutertable?>" cellpadding="<?=$cpoutertable?>" bgcolor="<?=setting('linkbar.bgcoloroutertable')?>">
		<tr>
			<td>
				<table width="100%" cellspacing="0" cellpadding="0" bgcolor="<?=setting('linkbar.bgcolorinnertable')?>">
					<tr>
						<td>
							<table align="<?=setting('linkbar.aligninnertable')?>" border="0" cellspacing="<?=$csinnertable?>" cellpadding="<?=$cpinnertable?>" bgcolor="<?=setting('linkbar.bgcolorinnertable')?>">
								<? foreach($out['DB']['Sections'] as $id=>$row) {?>
									<td align="center">
										<? if($row['SectionLevel']==1) { ?>
											<? if(!stristr($row['AccessGroups'],'hideforloggedin')){?>
												<? if(!empty($row['SectionLink'])) { if(stristr($row['SectionLink'],'http://') || stristr($row['SectionLink'],'/go/') || stristr($row['SectionLink'],'/adm/')) { $row['SectionLink'] = str_replace('{SID}',$input['SID'],$row['SectionLink']);?>
												<a href="<?=$row['SectionLink']?>"><? } else { $row['SectionLink'] = str_replace('{SID}',$input['SID'],$row['SectionLink']); ?> <a href="<?=setting('url').$row['SectionLink']?>" target="_blank"> <? } ?> 
												<? } else { ?> <a href="<?=setting('url').$row['SectionAlias'].'/'.$row['SectionArguments']?>"> <? } ?>
												<? $sectionButton = getValue($row['SectionButton']); if(!empty($sectionButton)) { ?><img src="<?=setting('urlfiles').$sectionButton?>" border="0"/>
												<? } else { ?><?=getValue($row['SectionName'])?><? } ?>
												</a>
											<? } ?>
										<? } ?>
									</td>
								<? } ?>
							</table>
						</td>
					</tr>
				</table>
			</td>
		</tr>
	</table>
<? } else { ?> &nbsp; <? } ?>

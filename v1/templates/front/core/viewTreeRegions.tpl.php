<? //print_r($out);?>
<?=boxHeader(array('title'=>'RegionsFullTree.core.title'))?>
	<? if(is_array($out['DB']['RegionsPath'])){ $count = count($out['DB']['RegionsPath']); $i=1; ?>
		<tr>
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<?=lang('RegionsPathBackTo.core.tip')?>: <a href="<?=setting('url').input('SID')?>/"><?=lang('-top')?></a> > <? foreach($out['DB']['RegionsPath'] as $id=>$name) { ?>
						<? if($i<$count) { ?><a href="<?=setting('url').input('SID')?>/location/<?=$id?>"><?=$name?></a> > <? } else { ?> <?=$name?> <? } ?>
				<? $i++; } ?>
							
			</td>
		</tr>	
		<? } ?>		
	<? //if(!empty($out['DB']['Regions'][0]['RegionID'])) {
		if(input('from')=='rental-properties')
		{
			$sid='rental-properties';
			$keyword = 'Rentals';
		}
		else
		{
			$sid='properties-for-sale';
			$keyword = 'Real Estate';
		}
		
		
	?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="locationMap">
				<table border="0" cellspacing="1" cellpadding="1" width="100%">
					<? foreach($out['DB']['Regions'] as $id=>$row) {?>
					<? if($row['RegionLevel']<5){if($row['RegionType']=='continent' || $row['RegionType'] == 'continentr' || $row['RegionType'] == 'country'){?>
							<tr>
								<td valign="top" bgcolor="#FFFFFF" colspan="2" nowrap>
									<? $deep=$row['RegionLevel']*15-10; ?>
									<a href="<?=setting('url')?><?=$sid?>--location--<?=$row['RegionCode']?>--page.html" <? if($row['RegionType']=='continent' || $row['RegionType'] == 'continentr'){?>style="font-size:18px"<? }?>><h1><img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1" border="0"/><?=getValue($row['RegionName'])?> <?=$keyword?></h1></a>
								</td>						
							</tr>	
					<? }else{?>
						<? if($out['DB']['Regions'][$id-1]['RegionType']=='continent' || $out['DB']['Regions'][$id-1]['RegionType']=='continentr'  || $out['DB']['Regions'][$id-1]['RegionType']=='country'){?>
							<tr>
								<td>
									<? $deep=$row['RegionLevel']*15-15; ?>
									<img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1"/>
								</td>
								<td valign="top" bgcolor="#FFFFFF">
								
							<? }?>	
							<a href="<?=setting('url')?><?=$sid?>--location--<?=$row['RegionCode']?>--page.html" <? if($row['RegionType']=='continent' || $row['RegionType'] == 'continentr'){?>style="font-size:18px"<? }?>><?=getValue($row['RegionName'])?> <?=$keyword?></a>,&nbsp;
							<? if($out['DB']['Regions'][$id+1]['RegionType']=='continent' || $out['DB']['Regions'][$id+1]['RegionType']=='continentr'  || $out['DB']['Regions'][$id+1]['RegionType']=='country'){?>
								</td>						
							</tr>
						<? }?>
					<? }}}?>					
				</table>		
			</td> 
		</tr> 
	<?  /*}// end of  if(!empty($out['DB']['Regions'][0]['RegionID']))
		else{
	?>
		<!-- <tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<? //lang('NoRegionFound.core.tip')?>
			</td> 
		</tr> -->		
	<? } */?>		
<?=boxFooter()?>
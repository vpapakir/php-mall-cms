<?=boxHeader(array('title'=>'ManageRegions.core.title'))?>
	<? if(is_array($out['DB']['RegionsPath'])){ $count = count($out['DB']['RegionsPath']); $i=1; ?>
		<tr>
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
					<?=lang('RegionsPathBackTo.core.tip')?>: <a href="<?=setting('url').input('SID')?>/"><?=lang('-top')?></a> > <? foreach($out['DB']['RegionsPath'] as $id=>$name) { ?>
						<? if($i<$count) { ?><a href="<?=setting('url').input('SID')?>/location/<?=$id?>"><?=$name?></a> > <? } else { ?> <?=$name?> <? } ?>
				<? $i++; } ?>
							
			</td>
		</tr>	
		<? } ?>		
	<? if(!empty($out['DB']['Regions'][0]['RegionID'])) {?>
		<tr> 
			<td valign="top" bgcolor="#ffffff" class="fieldNames">
				<table border="0" cellspacing="1" cellpadding="5" width="100%">
					<tr>
						<td valign="top" class="row1" width="65%">
						<? foreach($out['DB']['Regions'] as $id=>$row) {?>
								<? //$deep=$row['RegionLevel']*15-15; ?>
								<!-- <img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1"/> -->
								<a href="<?=setting('url')?><?=input('SID')?>/location/<?=$row['RegionCode']?>"><?=getValue($row['RegionName'])?></a>,&nbsp;
						<? } ?>					
						</td>						
					</tr>	
				</table>		
			</td> 
		</tr> 
	<?  }// end of  if(!empty($out['DB']['Regions'][0]['RegionID']))
		else{
	?>
		<!-- <tr> 
			<td valign="top" bgcolor="#ffffff" align="center">
				<? //lang('NoRegionFound.core.tip')?>
			</td> 
		</tr> -->		
	<? } ?>		
<?=boxFooter()?>
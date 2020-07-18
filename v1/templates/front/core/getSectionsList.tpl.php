<? //boxHeader(array('title'=>lang('-summary')))?>
<? //print_r($input)?>
<?=boxHeader()?>
	<tr> 
	<td valign="top">
    <? if($input['SID']!='search'){?>
    <div style="margin-left: -7px;">
    <? }?>
		<table width="100%" cellpadding="2" cellspacing="0" border="0">
		<? 
			$i=0;
			if(is_array($out['DB']['Sections'])){
				foreach($out['DB']['Sections'] as $id=>$row) {
					$SectionIcon = getValue($row['SectionIcon']);
					if(!empty($SectionIcon)) $i = 1;
				}
			}
		?>
		<? if(is_array($out['DB']['Sections'])) { foreach($out['DB']['Sections'] as $id=>$row) {?>
        <? //print_r($row)?>
			<tr>	
				<? if($i==1){?>
				<td valign="top" align="center" width="1%">
					<? $SectionIcon = getValue($row['SectionIcon']); ?>
					<? if(!empty($SectionIcon)) {?>
						<img src="<?=setting('urlfiles').$SectionIcon?>" border="0"/>
					<? }?>
				</td>
				<? }?>
				<td valign="top">
				<? if($row['SectionTarget']=='_blank') { ?>
					<? if(!empty($row['SectionLink'])){?>
						<a href="javascript://" class="subtitle" onClick="popup('<?=$row['SectionLink']?>')">
					<? }else{?>	
						<a href="javascript://" class="subtitle" onClick="popup('<?=setting('url').$row['SectionAlias']?>/windowMode/popup')">
					<? }?>
				<? } else { ?>
					<? if(!empty($row['SectionLink'])){?>
						<a class="subtitle" href="<?=setting('url').$row['SectionLink']?>">
					<? }else{?>
						<a class="subtitle" href="<?=setting('url').$row['SectionAlias']?>">
					<? }?>
				<? } ?>
				<? //=getValue($row['SectionName'])?>
                <?=getValue($row['SectionTitle'])?>
				</a>
				<? if(!eregi("\|hideintros\|",setting('PageViewOptions'))) { echo '<p>'.getFormated($row['SectionListingText'],'HTML').'</p>'; } ?>
				<? if($row['SectionAlias']=='studio' || $row['SectionAlias']=='1chambre' || $row['SectionAlias']=='2chambres' || $row['SectionAlias']=='3chambres' || $row['SectionAlias']=='gousse-de-vanille-2chambres' || $row['SectionAlias']=='villa-combava-3chambres'){?>
					<form name="getPropertyTypes" method="post">
						<input type="hidden" name="SID" value="commentreserver" />
						<input type="hidden" name="MessageTextAppartement" value="<?=$row['SectionAlias']?>" />
						<input type="submit" value="<?=lang("-add")?>"/>
					</form>
				<? }?>
				</td>
			</tr>
			<tr>
				<td colspan="2">
					<hr size="1"/>
				</td>
			</tr>
		<? } } else { ?>
			<tr>
				<td colspan="2" align="center">
					<?=lang('NoSectionFoundSearchResult.core.tip')?>
				</td>
			</tr>
		
		<? } ?>
		</table>
        <? if($input['SID']!='search'){?>
        </div>
        <? }?>
	</td> 
	</tr>
<?=boxFooter()?>

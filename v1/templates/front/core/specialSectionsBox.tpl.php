<? if(is_array($out['DB']['Sections'])) { ?>
<?=boxHeader(array('title'=>lang('SpecialsSectionsBox.core.title')))?>
	<? /* if(!empty($user['UserName'])) { ?>
		<?=lang('--welcomeback')?>  <b><?=user('FirstName')?> <?=user('LastName')?></b><br/><br/>
	<? } */ ?>
	<tr> 
	<td valign="top">
		<table cellspacing="0" cellpadding="0" border="0" width="100%">
		
			<? foreach($out['DB']['Sections'] as $id=>$row) { if($row['SectionIsHiddenInMenu']!='Y') { ?>
			<? $deep=$row['SectionLevel']*15-15; ?>
			<tr>
				<!-- <td width="<?=$deep?>">&nbsp;</td> -->
			<? if($row['SectionLevel']==1) { ?>	
				<td class="subtitle"><img src="<?=setting('layout')?>images/pixel.gif" width="<?=$deep?>">
			<? }else{?>			
				<td><img src="<?=setting('layout')?>images/pixel.gif" width="<?=$deep?>">
			<? }?>
			<? //if($row['SectionLevel']==1) { ?>
				<? if(!empty($row['SectionArguments'])) { ?>
					<a href="<?=setting('url').$row['SectionAlias']?>--page.html">
						<? if($row['SectionLevel']>1) {?>
							<?
								if($row['SectionAlias']==input('SID')) {
									$expandImage = 'minus';
								} else {
									$expandImage = 'plus';
								}
							?>
							<img src="<?=setting('layout')?>images/icons/<?=$expandImage?>.jpg" width="9" height="9" hspace="3" border="0"/>
						<? } ?>
						<?  $sectionButton = getValue($row['SectionButton']); if(!empty($sectionButton)) {?>
							<img src="<?=setting('urlfiles').$sectionButton?>" border="0"/>
						<? }else{?>
						<?=getValue($row['SectionName'])?><? }?>
					</a>
				<? } else { ?>
					<a href="<?=setting('url').$row['SectionAlias']?>--page.html">
						<? if($row['SectionLevel']>1) {?>
							<?
								if($row['SectionAlias']==input('SID')) {
									$expandImage = 'minus';
								} else {
									$expandImage = 'plus';
								}
							?>
							<img src="<?=setting('layout')?>images/icons/<?=$expandImage?>.jpg" width="9" height="9" hspace="3" border="0"/>
						<? } ?>
						<?  $sectionButton = getValue($row['SectionButton']); if(!empty($sectionButton)) {?>
							<img src="<?=setting('urlfiles').$sectionButton?>" border="0"/>
						<? }else{?>
							<?=getValue($row['SectionName'])?>
						<? }?>
					</a>
				<? } ?>
			<? //} ?>
			</td>
			</tr>
			<? if(eregi('\|showintroinmenu\|',$row['SectionViewOptions'])){?>			
			<tr>
				<td align="left">
						<?=getValue($row['SectionIntroContent'])?>
				</td>
			</tr>
			<tr>
				<td>&nbsp;</td>
			</tr>
			<? }?>
			
		<? } }   ?>
			<tr>
				<td align="left">
					<? //getValue($out['DB']['Sections'][0]['SectionIntroContent'])?><br>
					<? /*if(!empty($out['DB']['Sections'][1]['SectionIntroContent'])){?>
						<?=getValue($out['DB']['Sections'][1]['SectionIntroContent'])?>
					<? }*/?>
				</td>
			</tr>
			<tr>
				<!-- <td>&nbsp;</td> -->
				<td><img src="<?=setting('layout')?>images/pixel.gif" width="0px"><? if (hasRights('admin')) { ?><a href="<?=setting('adminurl')?>manageSections/SectionGroupCode/right/frontBackLinkAction/save/"><?=lang('-editbox')?></a> <? } ?></td>
			</tr>
		</table>
		
	</td> 
	</tr> 
<?=boxFooter()?>
<? } ?>

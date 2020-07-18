<?=boxHeader(array('title'=>lang('RightSectionsBox.core.title')))?>
	<? /* if(!empty($user['UserName'])) { ?>
		<?=lang('--welcomeback')?>  <b><?=user('FirstName')?> <?=user('LastName')?></b><br/><br/>
	<? } */ ?>
		<? if(is_array($out['DB']['Sections'])) { ?>
			<? foreach($out['DB']['Sections'] as $id=>$row) { if($row['SectionIsHiddenInMenu']!='Y') { ?>
			<? $deep=$row['SectionLevel']*15-15; ?>
			<tr>
				<!-- <td width="<?=$deep?>">&nbsp;</td> -->
			<? if($row['SectionLevel']==1) { ?>	
			<td><? /*<img src="<?=setting('layout')?>images/pixel.gif" width="<?=$deep?>"> */?>
			<? }else{?>			
				<td bgcolor="#ffffff"><img src="<?=setting('layout')?>images/pixel.gif" width="<?=$deep?>">
			<? }?>
			<? //if($row['SectionLevel']==1) { ?>
				<? if(!empty($row['SectionLink'])){ $row['SectionLink'] = str_replace('{SID}',$input['SID'],$row['SectionLink']);?>
					<a href="<?=setting('url').$row['SectionLink']?>" target="_blank">
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
					</a><br/>
				<? }elseif(!empty($row['SectionArguments'])) { ?>
					<!-- <a href="<?=setting('mainurl').getValue($row['SectionAlias']).'/'.$row['SectionArguments']?>"> -->
					<a href="<?=setting('url').getValue($row['SectionAlias']).'/'.$row['SectionArguments']?>">
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
					</a><br/>
				<? } else { ?>
					<!-- <a href="<?=setting('mainurl').$row['SectionAlias']?>"> -->
					<a href="<?=setting('url').getValue($row['SectionAlias']).'/'.$row['SectionArguments']?>">
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
					</a><br/>
				<? } ?>
			<? //} ?>
			</td>
			</tr>
				<? if(eregi('\|showintroinmenu\|',$row['SectionViewOptions'])){?>			
			<tr>
			<td align="left" bgcolor="#ffffff">
				<?=getValue($row['SectionIntroContent'])?>
			</td>
			</tr>
				<? }?>
		<? } } }  ?>
			<? if (hasRights('admin')) { ?>
			<tr>
				<td bgcolor="#ffffff"><img src="<?=setting('layout')?>images/pixel.gif" width="0px"><a href="<?=setting('adminurl')?>manageSections/SectionGroupCode/right/frontBackLinkAction/save/"><?=lang('-editbox')?></a> </td>
			</tr>
			<? } ?>
<?=boxFooter()?>

<? if(!empty($user['UserID'])) {?>
<? if(user('Company')) {$title=user('Company');} elseif (user('FirstName')) {$title=user('FirstName').' '.user('LastName');} else {$title=user('UserName');} ?>
	<?=boxHeader(array('title'=>'FrontAdminMenu.core.title'))?>
		<tr> 
			<td valign=top bgcolor="#ffffff">
				<? if(is_array($out['DB']['Sections'])) { foreach($out['DB']['Sections'] as $id=>$row) {?>
					<? $deep=$row['SectionLevel']*15-15; ?>
					<? if($deep>0) {?><img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1"/><? } ?>
					<? if(!empty($row['SectionLink'])) { 
								if(stristr($row['SectionLink'],'http://') || stristr($row['SectionLink'],'/go/') || stristr($row['SectionLink'],'/adm/')) {?>
									<a href="<?=setting('rooturl').$row['SectionLink']?>" target="_blank">
										<?=getValue($row['SectionName'])?>
									</a>
									<br>
								<? } else { ?> 
									<a href="<?=$config['rooturl'].$row['SectionLink']?>" target="_blank"> 
										<?=getValue($row['SectionName'])?>
									</a>
									<br>
								<? } ?> 
					<? } else { ?> 
						<? if(!empty($row['SectionArguments'])) { ?>
							<? if(!$row['SectionManagementLink']){?>
								<a href="<?=setting('url').$row['SectionAlias'].$row['SectionArguments']?>" target="<?=$row['SectionTarget']?>">
									<?=getValue($row['SectionName'])?>
								</a>
							<? }else{?>	
								<a href="<?=setting('rooturl').$row['SectionManagementLink']?>" target="<?=$row['SectionTarget']?>">
									<?=getValue($row['SectionName'])?>
								</a>
							<? }?>
						<? } else { ?>
							<? if(!$row['SectionManagementLink']){?>
								<a href="<?=setting('url').$row['SectionAlias'].$row['SectionArguments']?>" target="<?=$row['SectionTarget']?>">
									<?=getValue($row['SectionName'])?>
								</a>
							<? }else{?>
								<a href="<?=setting('rooturl').$row['SectionManagementLink']?>" target="<?=$row['SectionTarget']?>">
									<?=getValue($row['SectionName'])?>
								</a>
							<? }?>
						<? } ?>
						<br/>
					<? }?>
				<? } } ?>
			</td> 
		</tr> 
	<?=boxFooter()?>
<? } ?>
<? if(!empty($user['UserID'])) {?>
<? if(user('Company')) {$title=user('Company');} elseif (user('FirstName')) {$title=user('FirstName').' '.user('LastName');} else {$title=user('UserName');} ?>
<?=boxHeader(array('title'=>$title))?>
	<tr> 
	<td valign=top bgcolor="#ffffff">
		<? if(is_array($out['DB']['Sections'])) { foreach($out['DB']['Sections'] as $id=>$row) {?>
			<? $deep=$row['SectionLevel']*15-15; ?>
			<? if($deep>0) {?><img src="<?=setting('layout')?>images/_clear.gif" width="<?=$deep?>" height="1"/><? } ?>
			<? if(!empty($row['SectionArguments'])) { ?>
			<a href="<?=setting('url').$row['SectionAlias'].'/'?>"><?=getValue($row['SectionName'])?></a>
			<? } else { ?>
			<a href="<?=setting('url').$row['SectionAlias'].'/'?>"><?=getValue($row['SectionName'])?></a>
			<? } ?>
			<br/>
		<? } } ?>
	</td> 
	</tr> 
<?=boxFooter()?>
<? } ?>
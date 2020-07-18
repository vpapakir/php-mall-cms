<?=boxHeader(array('title'=>'Statistics.title.tip'))?>
	<tr>
		<td valign=top bgcolor="#efefef">
			<span class="subtitle"><?=lang('usersonline.session.tip');?>:</span> <?=$out['regCount'];?>
		</td> 
	</tr>
	<tr>
		<td valign=top bgcolor="#efefef">
		<? // print_r($out);?>
			<span class="subtitle"><?=lang('users.session.tip');?>:</span> <?=$out['regAll'];?>
		</td> 
	</tr>
<?=boxFooter()?>
<?=boxHeader(array('title'=>lang('CoordaNewsFeedURL.core.tip')))?>
	<tr> 
		<td valign="top" bgcolor="#ffffff">
			<? $rss = getFormated(setting('CoordaNewsFeedURL'),'RSS')?>
			<?=getFormated($rss['description'],'HTML')?>
		</td> 
	</tr>
<?=boxFooter()?>
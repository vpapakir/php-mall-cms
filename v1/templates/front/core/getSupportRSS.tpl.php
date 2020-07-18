<?=boxHeader(array('title'=>lang('MessagesRSS.core.tip')))?>
<tr>
	<td align="left" valign="middle">
		<? 
			$link = str_replace("/en/","/".setting('lang')."/",setting('CoordaNewsFeedURL'));
			$rss = getFormated($link,'RSS');
		?>
		<?	if(is_array($rss['items'])){
			foreach($rss['items'] as $key=>$row){?>
			<a href="<?=$row['link']?>" target="_blank"><?=getFormated($row['title'],'TEXT');?></a>
			<br>	
			<?=getFormated($row['description'],'TEXT');?>	
			<hr size="1"/>
		<? }}?>
	</td>
</tr>
<?=boxFooter()?>
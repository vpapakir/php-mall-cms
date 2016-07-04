<? /* boxHeader(array('title'=>lang('RSSNewsBox.core.tip')))?>
<tr>
	<td align="left" valign="middle">
		<? $rss = getFormated(setting('RSSNewsBox'),'RSS');?>
		<? 
			$rss['title'] = str_replace("<![CDATA[","",$rss['title']);
			$rss['title'] = str_replace("]]>","",$rss['title']);
		?>
		<? 
			$rss['description'] = str_replace("<![CDATA[","",$rss['title']);
			$rss['description'] = str_replace("]]>","",$rss['title']);
		?>
		<a href="<?=$rss['link']?>"><?=getFormated($rss['title'],'TEXT');?></a>
		<br/>
		<?=getFormated($rss['description'],'TEXT');?>
		<br/><br/>
		<?	if(is_array($rss['items'])){
			foreach($rss['items'] as $key=>$row){?>
			<? 
				$row['title'] = str_replace("<![CDATA[","",$row['title']);
				$row['title'] = str_replace("]]>","",$row['title']);
			?>
			<a href="<?=$row['link']?>"><?=getFormated($row['title'],'TEXT');?></a>
			<br>
			<? 
				$row['description'] = str_replace("<![CDATA[","",$row['title']);
				$row['description'] = str_replace("]]>","",$row['title']);
			?>	
			<?=getFormated($row['description'],'TEXT');?>	
			<br><br>
		<? }}?>
	</td>
</tr>
<?=boxFooter() */ ?>
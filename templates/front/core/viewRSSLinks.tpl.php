<?
	$rssLink = $params['RSSLink'];
	if(empty($rssLink))
	{
		$rssLink  = setting('rooturl').'rss/'.setting('lang').'/'.input('SID').'--category--'.input('category').'--type--'.input('type').'--rss.xml';
	}
?>
<a href="<?=$rssLink?>"  target="_blank"><img src="<?=setting('layout')?>images/icons/rss.gif" border="0" /></a>
&nbsp;&nbsp;<a href="<?=$rssLink?>" target="_blank"><img src="<?=setting('layout')?>images/icons/rss-xml.gif" border="0" alt="<?=lang('-rss-xml')?>" /></a>
&nbsp;&nbsp;<a href="http://fusion.google.com/add?feedurl=<?=$rssLink?>" target="_blank"><img src="<?=setting('layout')?>images/icons/rss-google.gif" border="0" alt="<?=lang('-rss-google')?>" /></a>
&nbsp;&nbsp;<a href="http://add.my.yahoo.com/rss?url=<?=$rssLink?>" target="_blank"><img src="<?=setting('layout')?>images/icons/rss-yahoo.gif" border="0" alt="<?=lang('-rss-yahoo')?>" /></a>
&nbsp;&nbsp;<a href="http://www.newsgator.com/ngs/subscriber/subext.aspx?url=<?=$rssLink?>" target="_blank"><img src="<?=setting('layout')?>images/icons/rss-newsgator.gif" border="0" alt="<?=lang('-rss-newsgator')?>" /></a>
&nbsp;&nbsp;<a href="http://www.bloglines.com/sub/<?=$rssLink?>" target="_blank"><img src="<?=setting('layout')?>images/icons/rss-bloglines.gif" border="0" alt="<?=lang('-rss-bloglines')?>" /></a>
&nbsp;&nbsp;<a href="http://my.msn.com/addtomymsn.armx?id=rss&ut=<?=$rssLink?>" target="_blank"><img src="<?=setting('layout')?>images/icons/rss-msn-icon.gif" border="0" alt="<?=lang('-rss-msn-icon')?>" /></a>
&nbsp;&nbsp;<a href="http://feeds.my.aol.com/add.jsp?url=<?=$rssLink?>" target="_blank"><img src="<?=setting('layout')?>images/icons/rss-myaol.gif" border="0" alt="<?=lang('-rss-myaol')?>" /></a>
<br/>
<?=lang('RSSFeedsIntro.core.tip')?>
<br/><br/>


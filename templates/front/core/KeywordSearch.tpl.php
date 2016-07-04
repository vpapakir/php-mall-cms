<?=boxHeader(array('title'=>lang('KeywordSearch.core.title')))?>
	<TR>
		<TD align="left">
			<form name="searchForm" method="post">
			<input type="hidden" name="SID" value="search"/>
			<input type="hidden" name="ResourceType" value="products"/>
			<input type="hidden" name="actionMode" value="search"/>
			<input type="text" size="10" name="searchWord"  value="<?=input('searchWord')?>"/>
			<input type="submit" name="goSearch" value="<?=lang('-searchPages')?>" align="left"/>
			</form>
		</TD>
	</TR>
<?=boxFooter()?>
<?=boxHeader(array('title'=>lang('GoogleSiteMap.resource.title')))?>
<? //print_r($out);?>
<tr>
		<td valign="top" bgcolor="#ffffff" align="center">
			GoogleSiteMap results:
			<? if(empty($out['createdFile'])){?>
			Error creating file
			<? }else{ ?>
				File sucersfly created to : <a href="<?=$out['createdFile']?>"><?=$out['createdFile']?></a>
			<? }?>
		</td>
	</tr>
<?=boxFooter()?>
<? if(!empty($out['DB']['ResourceComments'][0]['ResourceCommentID'])) { ?>
<?=boxHeader(array('title'=>lang('ResourceComments.resource.title')))?>
<!-- <table border=0 cellpadding=3 cellspacing=1 width=251 bgcolor="#999999"> 
  <tr> 
	<td width="500px" bgcolor="#006699" valign=middle><p class="center"><span class="title"><?= lang('ResourceComments.resource.title')?></span></p></td> 
  </tr> -->
  <tr> 
	<td valign="top" bgcolor="#ffffff">
		<table>	
			<? if(is_array($out['DB']['ResourceComments'])){ foreach($out['DB']['ResourceComments'] as $id=>$row) {?>
				<tr></tr>
				<tr>
					<td valign="top"><b><?=$row['ResourceCommentTitle']?></b></td>
					<td valign="top"><?=getFormated($row['ResourceCommentContent'],'TEXT')?></td>
				</tr>
			<? } } ?>
		</table>	
	</td> 
	</tr> 
<?=boxFooter()?>
<? } ?>
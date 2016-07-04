<? if(!empty($out['DB']['PropertyComments'][0]['PropertyCommentID'])) { ?>
<?=boxHeader(array('title'=>lang('PropertyComments.property.title')))?>
<!-- <table border=0 cellpadding=3 cellspacing=1 width=251 bgcolor="#999999"> 
  <tr> 
	<td width="500px" bgcolor="#006699" valign=middle><p class="center"><span class="title"><?= lang('PropertyComments.property.title')?></span></p></td> 
  </tr> -->
  <tr> 
	<td valign="top" bgcolor="#ffffff">
		<table>	
			<? if(is_array($out['DB']['PropertyComments'])){ foreach($out['DB']['PropertyComments'] as $id=>$row) {?>
				<tr></tr>
				<tr>
					<td valign="top"><b><?=$row['PropertyCommentTitle']?></b></td>
					<td valign="top"><?=getFormated($row['PropertyCommentContent'],'TEXT')?></td>
				</tr>
			<? } } ?>
		</table>	
	</td> 
	</tr> 
<?=boxFooter()?>
<? } ?>
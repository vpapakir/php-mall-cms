<? if(!empty($out['DB']['TourComments'][0]['TourCommentID'])) { ?>
<?=boxHeader(array('title'=>lang('TourComments.tour.title')))?>
<!-- <table border=0 cellpadding=3 cellspacing=1 width=251 bgcolor="#999999"> 
  <tr> 
	<td width="500px" bgcolor="#006699" valign=middle><p class="center"><span class="title"><?= lang('TourComments.tour.title')?></span></p></td> 
  </tr> -->
  <tr> 
	<td valign="top" bgcolor="#ffffff">
		<table>	
			<? if(is_array($out['DB']['TourComments'])){ foreach($out['DB']['TourComments'] as $id=>$row) {?>
				<tr></tr>
				<tr>
					<td valign="top"><b><?=$row['TourCommentTitle']?></b></td>
					<td valign="top"><?=getFormated($row['TourCommentContent'],'TEXT')?></td>
				</tr>
			<? } } ?>
		</table>	
	</td> 
	</tr> 
<?=boxFooter()?>
<? } ?>
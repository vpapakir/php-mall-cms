<? //print_r($out);?>
<?=boxHeader(array('title'=>'ManageTourOrderLast.tour.title'))?>
<tr>
	<td align="left">
	<form name="manageTourOrders" method="post">
		<input type="hidden" name="SID" value="<?=$input['SID']?>"/>
		<input type="hidden" name="actionMode" value="save" />
		<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
		<? if(!empty($out['DB']['TourOrder'][0]['TourOrderID'])){?>
			<input type="hidden" name="TourOrder<?=DTR?>TourOrderID" value="<?=$out['DB']['TourOrder'][0]['TourOrderID']?>"/>
		<? }?>
	<? if(empty($input['TourOrderStatus'])){ $input['TourOrderStatus'] = 'all'; } ?>
	<?=getReference('TourOrder.TourOrderStatus','TourOrderStatus',$input['TourOrderStatus'],array('code'=>'Y','action'=>'submit()'))?>
	</form>
	</td>
</tr>
<tr><td>&nbsp;</td></tr>
<tr> 
	<td valign="top" bgcolor="#ffffff" class="fieldNames">
		<form name="manageTourOrders" method="post" onSubmit="submitonce(this)">
		<table border="0" cellspacing="1" cellpadding="5" width="100%">
			<? foreach($out['DB']['TourOrders'] as $id=>$row) {?>
			<input type="hidden" name="TourOrderID[<?=$id?>]" value="<?=$row['TourID']?>"/>
			<tr>
				<!-- <td valign="top" class="row1" width="1%">
					<img src="<?=setting('layout')?>images/icons/status-<?=$row['PermAll']?>.gif" width="15" height="13"/>
				</td>	 -->
				<td valign="top" class="row1" width="70%">
					<?=getValue($row['TourOrderFullName'])?> <!-- : <small><?=getFormated($row['TimeCreated'],'DateTime')?></small> -->
				</td>
				<td valign="top" class="row1" width="70%">
					<small><?=getFormated($row['TimeCreated'],'DateTime')?></small>
				</td>
				<!--td valign="top" class="row1">
					<?
						$TourCommentPositionUp = $row['TourCommentPosition'] - 3;
						$TourCommentPositionDown = $row['TourCommentPosition'] + 3;
					?>
					<a href="<?=setting('url')?><?=input('SID')?>/TourComment<?=DTR?>TourCommentPosition/<?=$TourCommentPositionUp?>/TourComment<?=DTR?>TourCommentID/<?=$row['TourID']?>/TourCommentGroup/<?=$row['TourGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/up.gif" border="0" alt="<?=lang('MoveUpTourComment.tour.tip')?>" hspace="3"  /></a>
					<a href="<?=setting('url')?><?=input('SID')?>/TourComment<?=DTR?>TourCommentPosition/<?=$TourCommentPositionDown?>/TourComment<?=DTR?>TourCommentID/<?=$row['TourID']?>/GroupID/<?=$row['TourCommentGroupID']?>/actionMode/save1"><img src="<?=setting('layout')?>images/icons/down.gif" border="0" alt="<?=lang('MoveDownTourComment.tour.tip')?>" hspace="3"  /></a>
				</td-->						
				<td valign="top" class="row1" width="10%" align="right">
					<!--a href="<?=setting('url')?>manageTourComment/TourCommentID/<?=$row['TourCommentID']?>/GroupID/<?=input('GroupID')?>">[<?=lang('-edit')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageTourComments/TourComment<?=DTR?>TourCommentID/<?=$row['TourCommentID']?>/actionMode/delete/GroupID/<?=input('GroupID')?>" onClick="return confirm('<?=lang('AreYouSureToDeleteTourComment.tour.tip')?>')">[<?=lang('-delete')?>]</a-->
					<!-- <form name="manageTourID" method="post" onSubmit="submitonce(this)"> -->
					<form name="getTourOrders" method="post" onSubmit="submitonce(this)">
					<input type="hidden" name="SID" value="manageTourOrders">
					<input type="hidden" name="TourOrderStatus" value="all">
					<input type="hidden" name="TourOrderID" value="<?=$row['TourOrderID']?>">
					<input type="hidden" name="TourOrder<?=DTR?>TourOrderID" value="<?=$row['TourOrderID']?>">
					<input type="hidden" name="TourOrderSort" value="id">
						<select name="TourOrderID" onChange="submit()">
							<option value="0" selected><?=lang('SelectAction.core.tip')?></option>
							<option value="<?=$row['TourOrderID']?>"><?=lang('-edit')?></option>
						</select>
					</form>
					<!--br/>
					<a href="<?=setting('url')?>manageTourComment/TourCommentParentID/<?=$row['TourCommentParentID']?>/GroupID/<?=input('GroupID')?>/TourCommentPosition/<? $newTourCommentPosition=$row['TourCommentPosition'] + 1; echo $newTourCommentPosition; ?>">[<?=lang('AddTourCommentAfter.tour.link','nospace')?>]</a>&nbsp;&nbsp;<a href="<?=setting('url')?>manageTourComment/TourCommentParentID/<?=$row['TourCommentID']?>/GroupID/<?=input('GroupID')?>/TourCommentPosition/1">[<?=lang('AddTourCommentUnder.tour.link','nospace')?>]</a-->
				</td>										
			</tr>	
			<? } ?>					
		</table>
		</form>
	</td>
</tr>
<?=boxFooter()?>
<?=boxHeader(array('title'=>'','tabs'=>'manageReservationRoomTasks'))?>
<tr><td>

<?//print_r($input);?>
<?//print_r($config)?>
<?//print_r($user)?>
<?//print_r($out)?>

<? $formName  = 'ReservationRoomTask'; ?>
<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="actionMode" value="<?=input('actionMode')?>" />
	<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
	<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
 	<input type="hidden" name="ReservationRoomTask<?=DTR?>ReservationRoomTaskID" value="<?=input('ReservationRoomTaskID')?>" />
 	<input type="hidden" name="ReservationRoomTask<?=DTR?>ReservationRoomTaskRoomID" value="<?=input('RoomID')?>" />
 	<input type="hidden" name="ReservationRoomTask<?=DTR?>ReservationRoomTaskCreate" value="<?=date("Y-m-d G:i:s")?>" />
 	<input type="hidden" name="RoomID" value="<?=input('RoomID')?>" />
 

	<table border=0 align='center' cellspacing=1 cellpadding=3 bgcolor='#999999'>
	    <tr>
            <td align="left" valign='top' bgcolor='#ffffff'>
                <table border=0 width="670" cellspacing=0 cellpadding=1>
                    <tr>
                        <td align='center' colspan='2' bgcolor='#eeeeee'>
                            <? $input['RoomName'] = preg_replace('/%20/', ' ', input('RoomName'));?>
	                        <span class="listingfont"><?=$input['RoomName']?></span>
	                    </td>
	                </tr>
	                <tr>
                        <td height=14 colspan='2'>
                            &nbsp;
                        </td>
                    </tr>
	                <tr>
                        <td width="300">
	                        <?=lang('ReservationRoomTasks.ReservationTaskName')?>
	                    </td>
	                    <td align='left'>
	                        <input type="text" name="ReservationRoomTask<?=DTR?>ReservationRoomTaskTaskName" size="38" value="<?=$out['DB']['ReservationRoomTask'][0]['ReservationRoomTaskTaskName']?>">
	                    </td>
	                </tr>
	                <tr>
                        <td>
	                        <?=lang('ReservationRoomTasks.ReservationRoomDescription')?>
	                    </td>
	                    <td align='left'>
	                        <TEXTAREA rows=6 cols=25 name="ReservationRoomTask<?=DTR?>ReservationRoomTaskRoomDescription" size="30"><?=$out['DB']['ReservationRoomTask'][0]['ReservationRoomTaskRoomDescription']?></TEXTAREA>
	                    </td>
	                </tr>
	                <tr>
                        <td height=14 colspan='2'>
                            &nbsp;
                        </td>
                    </tr>
	                <tr>
                        <td align='center' colspan='2'>
                            <? if(!empty($out['DB']['ReservationRoomTask'][0]['ReservationRoomTaskID'])) { ?>
                            <input type="button" value="<?=lang("ReservationRoomTasks.save.button")?>" onClick="document.<?=$formName?>.actionMode.value='save'; submit();">
                            <? } else { ?>
	                        <input type="button" value="<?=lang("ReservationRoomTasks.add.button")?>" onClick="document.<?=$formName?>.actionMode.value='add';submit();">
	                        <? } ?>
	                    </td>
	                </tr>
	                <tr>
                        <td height=14 colspan='2'>
                            &nbsp;
                        </td>
                    </tr>
                    <?foreach($out['DB']['ReservationRoomTasks'] as $array) {?>
                        <? if ($array['ReservationRoomTaskRoomID'] == input('RoomID')) { ?>
                        <tr>
                            <td align="left" colspan="2">
                                <?preg_match('/(\d+)-(\d+)-(\d+) (\d+):(\d+):(\d+)/s', $array['ReservationRoomTaskCreate'], $date_convert);?>
                                
                                <span class="listingfont"><?=$array['ReservationRoomTaskTaskName']?></span> - <?=$date_convert[3].'.'.$date_convert[2].'.'.$date_convert[1].' '.$date_convert[4].':'.$date_convert[5].':'.$date_convert[6]?>
                                <a href='<?=setting('url')?><?=input('SID')?>/ReservationRoomTaskID/<?=$array['ReservationRoomTaskID']?>/RoomID/<?=$input['RoomID']?>/windowMode/popup/'><?=lang('ReservationRoomTasks.Edit')?></a> 
                                <a href='<?=setting('url')?><?=input('SID')?>/ReservationRoomTask<?=DTR?>ReservationRoomTaskID/<?=$array['ReservationRoomTaskID']?>/RoomID/<?=$input['RoomID']?>/actionMode/delete/windowMode/popup/'><?=lang('ReservationRoomTasks.Delete')?></a>
                            </td>
                        </tr>
                        <tr>
                            <td align="left" colspan="2">
                                <?=getFormated($array['ReservationRoomTaskRoomDescription'],'TEXT') ?>
                                <hr size="1">
                            </td>
                        </tr>
                        <? } ?>
                    <?}?>
	            </table>
	        </td>
	    </tr>

	</table>
</form>

</td></tr>
<?=boxFooter()?>
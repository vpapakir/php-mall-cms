<?=boxHeader(array('title'=>'','tabs'=>'manageReservationRoomServicess'))?>
<tr><td>

<?//print_r($input)?>
<?//print_r($config)?>
<?//print_r($user)?>
<?//print_r($out)?>


<? $formName  = 'ReservationRoomServices'; ?>
<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="actionMode" value="<?=input('actionMode')?>" />
	<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
	<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
	<input type="hidden" name="ReservationOrderID" value="<?=input('ReservationOrderID')?>" />
	
<?foreach($out['DB']['ReservationRooms'] as $array) {
    if ($out['DB']['ReservationOrder'][0]['ReservationOrderRooms'] == $array['OptionCode']) {
        $fullNameRoom = $array['OptionName'];
    }
}?>

	
<table border=0 height="100%" align='center' cellspacing=1 cellpadding=0 bgcolor='#999999'>
	<tr>
        <td valign='top' bgcolor='#ffffff'>
            <table border=0 width="670" cellspacing=0 cellpadding=1>
                <tr>
                    <td align='center' colspan='2' bgcolor='#eeeeee'>
	                    <span class="subtitle"><?=lang('ReservationRoomServices.ReservationRoomServices').' '.$out['DB']['ReservationOrder'][0]['ReservationOrderClientType'].' ('.getValue($fullNameRoom).')'?></span>
	                </td>
	            </tr>
	        </table>
	    </td>
	</tr>
	<tr>
	    <td align="center" bgcolor='#ffffff'>
	        <table border=0 width="100%" cellspacing=3 cellpadding=0>
	            <tr>
	                <td bgcolor='#999999'>
	                    <table border=0 width="100%" cellspacing=1 cellpadding=1>
<?
preg_match('/(\d+)-(\d+)-(\d+)/s', $out['DB']['ReservationOrder'][0]['ReservationOrderArrival'], $date_arrival);
preg_match('/(\d+)-(\d+)-(\d+)/s', $out['DB']['ReservationOrder'][0]['ReservationOrderDeparture'], $date_departure);
$date_departure = $date_departure[1].$date_departure[2].$date_departure[3];


$i = date("Ymd", mktime(0, 0, 0, $date_arrival[2], $date_arrival[3], $date_arrival[1]));
?>
<input type="hidden" name="date_arrival" value="<?=$i?>">
<input type="hidden" name="date_departure" value="<?=$date_departure?>">
<?
$I_arrival = 'Arrivals ';
while ($i < $date_departure+1) {
    foreach($out['DB']['ReservationRoomServices'] as $array)
    {
    	if ($array['ReservationRoomServicesDate'] == $i)
    	{
    		$currentServicesFirs = $array['ReservationServicesFirst'];
    		$currentServicesSecond = $array['ReservationServicesSecond'];
    		$currentServicesThird = $array['ReservationServicesThird'];
    		$currentServicesFourth = $array['ReservationServicesFourth'];
    		break;
    	}
    	else 
    	{
    		$currentServicesFirs = '---';
    		$currentServicesSecond = '---';
    	}
    }
    $date_actually = date("d.m.Y", mktime(0, 0, 0, $date_arrival[2], $date_arrival[3], $date_arrival[1]));
    $DOW = date("l", mktime(0, 0, 0, $date_arrival[2], $date_arrival[3], $date_arrival[1]));
    if ($DOW == 'Sunday') 
    {
    	$DOW = lang('ReservationRoomServices.DOWSunday.tip');
    } 
    elseif ($DOW == 'Monday')
    {
    	$DOW = lang('ReservationRoomServices.DOWMonday.tip');
    }
    elseif ($DOW == 'Tuesday')
    {
    	$DOW = lang('ReservationRoomServices.DOWTuesday.tip');
    }
    elseif ($DOW == 'Wednesday')
    {
    	$DOW = lang('ReservationRoomServices.DOWWednesday.tip');
    }
    elseif ($DOW == 'Thursday')
    {
    	$DOW = lang('ReservationRoomServices.DOWThursday.tip');
    }
    elseif ($DOW == 'Friday')
    {
    	$DOW = lang('ReservationRoomServices.DOWFriday.tip');
    }
    elseif ($DOW == 'Saturday')
    {
    	$DOW = lang('ReservationRoomServices.DOWSaturday.tip');
    }
?>
							<tr>
	    						<td align="left" bgcolor='#ffffff' width="160">
	        						<?=$DOW?> <?=$date_actually?>
	    						</td>
        						<td bgcolor='#ffffff'>
            						<?=getReference('ReservationRoomServices.ReservationServices','ReservationServicesFirst'.$i,$currentServicesFirs, array('code'=>'Y','noEdit'=>'Y'))?>
        						</td>
	    						<td bgcolor='#ffffff'>
            						<?=getReference('ReservationRoomServices.ReservationServices2','ReservationServicesSecond'.$i,$currentServicesSecond, array('code'=>'Y','noEdit'=>'Y'))?>

	        						<? //getLists($options_services2, $currentServicesSecond, array('name'=>'ReservationServicesSecond'.$i))?>
	    						</td>
	    						<td bgcolor='#ffffff'>
	        						<input type = text size="18" name = ReservationServicesThird<?=$i?> value = '<?=$currentServicesThird?>'>
	    						</td>
	    						<td bgcolor='#ffffff'>
	        						<input type = text size="18" name = ReservationServicesFourth<?=$i?> value = '<?=$currentServicesFourth?>'>
	        						<input type="hidden" name="date_actual" value="<?=$i?>">
	    						</td>
							</tr>
	<?$date_arrival[3]++;
	$i = date("Ymd", mktime(0, 0, 0, $date_arrival[2], $date_arrival[3], $date_arrival[1]));
	$I_arrival = '';
} ?>
	                    </table>
	                </td>
	            </tr>
	        </table>
	    </td>
    </tr>
</table>

<table width="100%">
    <tr>
        <td align="center">
            <input type="button" value="<?=lang("ReservationRoomServices.save.button")?>" onClick="document.<?=$formName?>.actionMode.value='save';submit();">
        </td>
    </tr>
</table>
</form>

</td></tr>
<?=boxFooter()?>
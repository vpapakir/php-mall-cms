<?=boxHeader(array('title'=>'','tabs'=>'manageReservationStatisticss'))?>
<tr><td>

<?//print_r($input);?>
<?//print_r($config)?>
<?//print_r($user)?>
<?//print_r($out)?>


<?function DOW($DOW) {
    if ($DOW == 'Sunday') 
    {
    	$DOW = lang('ReservationStatistics.DOWSunday.tip');
    } 
    elseif ($DOW == 'Monday')
    {
    	$DOW = lang('ReservationStatistics.DOWMonday.tip');
    }
    elseif ($DOW == 'Tuesday')
    {
    	$DOW = lang('ReservationStatistics.DOWTuesday.tip');
    }
    elseif ($DOW == 'Wednesday')
    {
    	$DOW = lang('ReservationStatistics.DOWWednesday.tip');
    }
    elseif ($DOW == 'Thursday')
    {
    	$DOW = lang('ReservationStatistics.DOWThursday.tip');
    }
    elseif ($DOW == 'Friday')
    {
    	$DOW = lang('ReservationStatistics.DOWFriday.tip');
    }
    elseif ($DOW == 'Saturday')
    {
    	$DOW = lang('ReservationStatistics.DOWSaturday.tip');
    }
    
    return $DOW;
}?>

<?//print_r($out['DB']['ReservationStatisticsDeparture'])?>

<? $formName  = 'ReservationStatistics'; ?>
<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="actionMode" value="<?=input('actionMode')?>" />
	<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
	<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
	
	
<table border=0 width="100%" align='center' cellspacing=1 cellpadding=0 bgcolor='#ffffff'>
	<tr>
        <td align="center" valign='top' bgcolor='#ffffff'>
            <table border=0 width="100%" cellspacing=0 cellpadding=1>
                <tr>
                    <td align='center' colspan='2' bgcolor='#ffffff'>
	                    <h3><?=lang('ReservationStatistics.ReservationStatistics')?><br>
	                    <?=lang('ReservationStatistics.ReservationStatisticsFrom')?>
	                    <?$DOW = date("l", mktime(0, 0, 0, $input['month'], $input['date'], $input['year']));
                       $DOW = DOW($DOW);?>
                        <?=$DOW.' '.date('d.m.Y', mktime(0, 0, 0, $input['month'], $input['date'], $input['year']))?>                    
	                    <?=lang('ReservationStatistics.ReservationStatisticsTill')?>
	                    
	                    <?$DOW = date("l", mktime(0, 0, 0, $input['month'], $input['date']+6, $input['year']));
                        $DOW = DOW($DOW);?>
	                    <?=$DOW.' '.date('d.m.Y', mktime(0, 0, 0, $input['month'], $input['date']+6, $input['year']))?></h3>
	                </td>
	            </tr>
	        </table>
	    </td>
	</tr>
	<tr>
	    <td align="center" bgcolor='#ffffff'>
	                    <? for ($i=0; $i<7; $i++) { ?>
	    <table border=0 width="100%" cellspacing=3 cellpadding=0><tr><td bgcolor='#999999'>
	        <table border=0 width="100%" cellspacing=1 cellpadding=1>

                <tr>
                    <td width="100%" align="left" bgcolor='#eeeeee' colspan="2">
                        <span class="listingfont">
                        <?$DOW = date("l",  mktime(0, 0, 0, $input['month'], $input['date']+$i, $input['year']));
                        $DOW = DOW($DOW)?>
                        <?=$DOW.' '.date('d.m.Y', mktime(0, 0, 0, $input['month'], $input['date']+$i, $input['year']))?></span>
                        <?if ($input['windowMode'] == 'print') {?>
                            <hr size="1" />
                        <?}?>
                    </td>
                </tr>
                <tr>
                    <td width="20%" valign="top" bgcolor='#ffffff'>
                        <?=lang('ReservationStatistics.ReservationStatisticsArrival')?>
                    </td>
                    <td valign="top" bgcolor='#ffffff'>
                    
                        <?$countArrival = 0?>
                        <? foreach ($out['DB']['ReservationStatisticsArrival'] as $array) { ?>
                            <? if ($array['ReservationOrderArrival'] == date('Y-m-d', mktime(0, 0, 0, $input['month'], $input['date']+$i, $input['year']))) { ?>
                                <?if (!empty($countArrival)) {echo '<hr size="1" />';}?>
                                <a href='#' onclick="javascript:window.opener.location='<?=setting('url')?>manageReservationOrders/ReservationOrderID/<?=$array['ReservationOrderID']?>'; window.close();"><?=$array['ReservationOrderClientType']?></a><br>
                                <?preg_match('/(\d+)-(\d+)-(\d+)/s', $array['ReservationOrderArrival'], $date_convert);
                                $arrival_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];
                                preg_match('/(\d+)-(\d+)-(\d+)/s', $array['ReservationOrderDeparture'], $date_convert);
                                $departure_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
                                <?=$arrival_date?> - <?=$departure_date?>
                                <?foreach($out['DB']['ReservationRooms'] as $arrayRoom) {
                                	if ($arrayRoom['OptionCode'] == $array['ReservationOrderRooms']) {
                                		echo getValue($arrayRoom['OptionName']).'<br>';
                                	}
                                }?>
                                <?$countArrival++?>
                            <? } ?>
                        <? } ?>
                        <?if ($countArrival == 0) {
                        	echo lang('ReservationStatistics.NoArrivals.tip');
                        }?>
                    </td>
                </tr>
                <?if ($input['windowMode'] == 'print') {?>
                    <tr>
                        <td colspan="2" bgcolor='#ffffff'>
                            <hr size="1" />
                        </td>
                    </tr>
                <?}?>
                <tr>
                    <td width="20%" valign="top" bgcolor='#ffffff'> 
                        <?=lang('ReservationStatistics.ReservationStatisticsDeparture')?>
                    </td>
                    <td valign="top" bgcolor='#ffffff'>
                        <?$countDeparture = 0?>
                        <? foreach ($out['DB']['ReservationStatisticsDeparture'] as $array) { ?>
                            <? if ($array['ReservationOrderDeparture'] == date('Y-m-d', mktime(0, 0, 0, $input['month'], $input['date']+$i, $input['year']))) { ?>
                                <?if (!empty($countDeparture)) {echo '<hr size="1" />';}?>
                                <a href='#' onclick="javascript:window.opener.location='<?=setting('url')?>manageReservationOrders/ReservationOrderID/<?=$array['ReservationOrderID']?>'; window.close();"><?=$array['ReservationOrderClientType']?></a><br>
                                <?preg_match('/(\d+)-(\d+)-(\d+)/s', $array['ReservationOrderArrival'], $date_convert);
                                $arrival_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];
                                preg_match('/(\d+)-(\d+)-(\d+)/s', $array['ReservationOrderDeparture'], $date_convert);
                                $departure_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
                                <?=$arrival_date?> - <?=$departure_date?>
                                <?foreach($out['DB']['ReservationRooms'] as $arrayRoom) {
                                    if ($arrayRoom['OptionCode'] == $array['ReservationOrderRooms']) {
                                	    echo getValue($arrayRoom['OptionName']).'<br>';
                                    }
                                }?>
                                <?$countDeparture++?>
                            <? } ?>
                        <? } ?>
                        <?if ($countDeparture == 0) {
                            echo lang('ReservationStatistics.NoDeparture.tip');
                        }?>
                    </td>
                </tr>
                <?if ($input['windowMode'] == 'print') {?>
                    <tr>
                        <td colspan="2" bgcolor='#ffffff'>
                            <hr size="1" />
                        </td>
                    </tr>
                <?}?>   
                <tr>
                    <td width="20%" valign="top" bgcolor='#ffffff'>    
                        <?echo lang('ReservationStatistics.Services.tip');?>
                    </td>
                    <td valign="top" bgcolor='#ffffff'>
                    <?$countServices = 0?>
                    <? foreach ($out['DB']['ReservationStatistics'] as $array) { ?>
                        <? //if ($array['ReservationOrderDeparture'] == date('Y-m-d', mktime(0, 0, 0, $input['month'], $input['date']+$i, $input['year']))) { ?>
                            <?foreach ($out['DB']['ReservationRoomServices']  as $arrayServices) {
                                	if ($array['ReservationOrderID'] == $arrayServices['ReservationOrderID'] && !empty($arrayServices['ReservationServicesFirst']) && date('Ymd', mktime(0, 0, 0, $input['month'], $input['date']+$i, $input['year'])) == $arrayServices['ReservationRoomServicesDate']) {?>
                                	    <?if (!empty($countServices)) {echo '<hr size="1" />';}?>
                                	    <?$rsFirst = getReference('ReservationRoomServices.ReservationServices','ReservationServicesFirst',$currentServicesFirs,array('code'=>'Y', 'type'=>'array'));
                                	    $rsSecond = getReference('ReservationRoomServices.ReservationServices2','ReservationServicesSecond'.$i,$currentServicesSecond, array('code'=>'Y', 'type'=>'array'));
                                	    foreach ($rsFirst as $arrayRsFirst) {
	                                        if ($arrayRsFirst['id'] == $arrayServices['ReservationServicesFirst']) {
		                                        echo $arrayRsFirst['value'].': ';
		                                        echo $array['ReservationOrderClientType'].' ';
                                	            foreach($out['DB']['ReservationRooms'] as $arrayRoom) {
                                	                if ($arrayRoom['OptionCode'] == $array['ReservationOrderRooms']) {
                                		                echo '('.getValue($arrayRoom['OptionName']).')<br>';
                                	                }
                                                }
	                                        }
                                        }
                                        
                                        foreach ($rsSecond as $arrayRsSecond) {
	                                        if ($arrayRsSecond['id'] == $arrayServices['ReservationServicesSecond']) {
		                                        echo $arrayRsSecond['value'].': ';
		                                        echo $array['ReservationOrderClientType'].' ';
                                	            foreach($out['DB']['ReservationRooms'] as $arrayRoom) {
                                	                if ($arrayRoom['OptionCode'] == $array['ReservationOrderRooms']) {
                                		                echo '('.getValue($arrayRoom['OptionName']).')<br>';
                                	                }
                                                }
	                                        }
                                        }
                                        if (!empty($arrayServices['ReservationServicesThird'])) {
		                                    echo $arrayServices['ReservationServicesThird'].': ';
		                                    echo $array['ReservationOrderClientType'].' ';
                                	        foreach($out['DB']['ReservationRooms'] as $arrayRoom) {
                                	            if ($arrayRoom['OptionCode'] == $array['ReservationOrderRooms']) {
                                		            echo '('.getValue($arrayRoom['OptionName']).')<br>';
                                	            }
                                            }
                                        }
                                        if (!empty($arrayServices['ReservationServicesFourth'])) {
		                                    echo $arrayServices['ReservationServicesFourth'].': ';
		                                    echo $array['ReservationOrderClientType'].' ';
                                	        foreach($out['DB']['ReservationRooms'] as $arrayRoom) {
                                	            if ($arrayRoom['OptionCode'] == $array['ReservationOrderRooms']) {
                                		            echo '('.getValue($arrayRoom['OptionName']).')<br>';
                                	            }
                                            }
                                        }?>
                                	    <?$countServices++?>
                                		<?//break;
                                	}
                                }?>
                        <? //} ?>
                    <? } ?>
                    <?if ($countServices == 0) {
                        echo lang('ReservationStatistics.NoServices.tip');
                    }?>
                    </td>
                </tr>
                <?if ($input['windowMode'] == 'print') {?>
                    <tr>
                        <td colspan="2" bgcolor='#ffffff'>
                            <hr size="1" />
                        </td>
                    </tr>
                <?}?>
	        </table>
	        </td></tr></table>
                <? } ?>
	    </td>
	</tr>
</table>

<br>
<?if (input('windowMode') != 'print') {?>
    <table width="100%">
        <tr>
            <td align="center">
	            <input type="button" value="<?=lang('ReservationStatistics.Print.button')?>"onClick="popup('<?=setting('url')?><?=input('SID')?>/year/<?=input('year')?>/month/<?=input('month')?>/date/<?=input('date')?>/windowMode/print')"/>
	        </td>
	    </tr>
	</table>
<?}?>
</form>

</td></tr>
<?=boxFooter()?>
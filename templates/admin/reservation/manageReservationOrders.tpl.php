<?
//print_r($out);
timeTracking('ReservationStart');
if (empty($user['UserID'])){ ?>
	<table border="0" width="100%">
	    <tr>
	        <td width="50%">
		        <?=getBox('session.login')?>
	        </td>
	        <td width="50%">
	        </td>
	    </tr>
	</table>
<? } else { ?>
<?=boxHeader(array('title'=>'ManageReservationOrders.reservation.title','tabs'=>'manageReservationOrders'))?>
<tr><td>

<? function DOW($DOW) {
    if ($DOW == 'Sunday') 
    {
    	$DOW = lang('ReservationOrder.DOWSunday.tip');
    } 
    elseif ($DOW == 'Monday')
    {
    	$DOW = lang('ReservationOrder.DOWMonday.tip');
    }
    elseif ($DOW == 'Tuesday')
    {
    	$DOW = lang('ReservationOrder.DOWTuesday.tip');
    }
    elseif ($DOW == 'Wednesday')
    {
    	$DOW = lang('ReservationOrder.DOWWednesday.tip');
    }
    elseif ($DOW == 'Thursday')
    {
    	$DOW = lang('ReservationOrder.DOWThursday.tip');
    }
    elseif ($DOW == 'Friday')
    {
    	$DOW = lang('ReservationOrder.DOWFriday.tip');
    }
    elseif ($DOW == 'Saturday')
    {
    	$DOW = lang('ReservationOrder.DOWSaturday.tip');
    }
    
    return $DOW;
}?>

<? function MOY($MOY) {
    if ($MOY == 'January') 
    {
    	$MOY = lang('ReservationOrder.MOYJanuary.tip');
    } 
    elseif ($MOY == 'February')
    {
    	$MOY = lang('ReservationOrder.MOYFebruary.tip');
    }
    elseif ($MOY == 'March')
    {
    	$MOY = lang('ReservationOrder.MOYMarch.tip');
    }
    elseif ($MOY == 'April')
    {
    	$MOY = lang('ReservationOrder.MOYApril.tip');
    }
    elseif ($MOY == 'May')
    {
    	$MOY = lang('ReservationOrder.MOYMay.tip');
    }
    elseif ($MOY == 'June')
    {
    	$MOY = lang('ReservationOrder.MOYJune.tip');
    }
    elseif ($MOY == 'July')
    {
    	$MOY = lang('ReservationOrder.MOYJuly.tip');
    }
    elseif ($MOY == 'August')
    {
    	$MOY = lang('ReservationOrder.MOYAugust.tip');
    }
    elseif ($MOY == 'September')
    {
    	$MOY = lang('ReservationOrder.MOYSeptember.tip');
    }
    elseif ($MOY == 'October')
    {
    	$MOY = lang('ReservationOrder.MOYOctober.tip');
    }
    elseif ($MOY == 'November')
    {
    	$MOY = lang('ReservationOrder.MOYNovember.tip');
    }
    elseif ($MOY == 'December')
    {
    	$MOY = lang('ReservationOrder.MOYDecember.tip');
    }
    
    return $MOY;
}?>

<? //print_r($input)?>
<? //print_r($config['ReservationPeriod'])?>
<? //print_r($user)?>
<? //print_r($out)?>
<? //print_r($out['DB']['ReservationSearchRooms'])?>
<? //print_r($out['DB']['ReservationOrder'])?>
<? //print_r($out['DB']['ReservationOrdersOptions'])?>
<? //print_r($out['DB']['ReservationOrderStat'])?>
<? //print_r($out['DB']['ClientMessages'])?>
<? //print_r($_SERVER)?>
	

<? //------------------------------ROOMS--------------------------?>

<? if (input('viewMode')=='rooms') {
	getBox('reservation.manageReservationRooms');
} ?>


<? //------------------------------TOP-LEFT MENU--------------------------?>

<? if (input('viewMode')!='availability' && input('viewMode')!='rooms' && input('viewMode')!='settings') {?>
<? $formName  = 'ReservationOrder'; ?>
	<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="<?=input('SID')?>">
  <? if(!empty($out['DB']['ReservationOrder'][0]['ReservationOrderID'])) { ?>
  <input type="hidden" name="actionMode" value="save">
  <? } else { ?>
  <input type="hidden" name="actionMode" value="add">
  <? } ?>		
		
		<input type="hidden" name="searchMode" value="<?=input('searchMode')?>">
		<input type="hidden" name="ReservationOrderType" value="<?=input('ReservationOrderType')?>">
		<input type="hidden" name="PermAll" value="<?=input('PermAll')?>">
 	    <input type="hidden" name="ReservationOrder<?=DTR?>ReservationOrderID" value="<?=input('ReservationOrderID')?>">
 	    <input type="hidden" name="ReservationOrder<?=DTR?>UserID" value="<?=$out['DB']['ReservationOrder'][0]['UserID']?>">
 	    <input type="hidden" name="ReservationOrder<?=DTR?>GroupID" value="<?=$user['GroupID']?>">


<?
if(input('actionMode')=='delete' or input('actionMode')=='new')
{
	goLink(setting('url').input('SID'));
}
?>


        <table border=0 cellspacing=1 cellpadding=3 bgcolor="#999999">
            <tr>
<?if (input('windowMode')=='print') {?>
                <td valign=top bgcolor="#ffffff">
                    <table width=1024 border=0 cellspacing=0 cellpadding=1>
                        <tr>
                            <td align="center" valign="middle" bgcolor="#eeeeee">
                                <span class="listingfont">
<?=setting('SiteName')?><?=lang('AddEditReservationTitle.reservation.tip')?></span> <?=date("D d.m.Y G:i")?>
                            </td>
<?} else {?>
                <td width=631 height=192 valign=top bgcolor="#ffffff">
                    <table border=0 cellspacing=0 cellpadding=1>
                        <tr>
                            <td width=624 height=14 colspan=2 valign=middle bgcolor="#eeeeee">
                                <span class="listingfont"><a href="<?=setting('url')?>manageReservationOrders">
<?=setting('SiteName')?></a><?=lang('AddEditReservationTitle.reservation.tip')?></span> <?$DOW = date("l")?><?$DOW = DOW($DOW)?><?=$DOW.' '.date("d.m.Y G:i")?>
                                <a href="<?=setting('url')?>reservationMailbox/tabLink/11365480442007121914375387o111/" target="_blank">
                                <?if (!empty($out['DB']['ClientMessages'])) {?>
                                    <img border="0" src="<?=Setting('urlfiles')?>/root/images/calendar/alert_img.gif"> <?=lang('MailboxReservationTitle.reservation.tip')?></a>
                                <?} else {?>
                                    <img border="0" src="<?=Setting('urlfiles')?>/root/images/calendar/dotlightgrey.gif"> <?=lang('MailboxReservationTitle.reservation.tip')?></a>
                                <?}?>
                            </td>
<?}?>
<?if (input('windowMode')!='print') {?>
                        </tr>
                        <tr>
                            <td width=152 height=14 valign=middle>&nbsp;
                                
                            </td>
                            <td width=472 height=14 valign=middle>&nbsp;
                                
                            </td>
                        </tr>
                        <?$arrival_date = input('ReservationOrder'.DTR.'ReservationOrderArrival_year').'-'.input('ReservationOrder'.DTR.'ReservationOrderArrival_month').'-'.input('ReservationOrder'.DTR.'ReservationOrderArrival_day');
	                    $departure_date = input('ReservationOrder'.DTR.'ReservationOrderDeparture_year').'-'.input('ReservationOrder'.DTR.'ReservationOrderDeparture_month').'-'.input('ReservationOrder'.DTR.'ReservationOrderDeparture_day');?>
                        <tr>
                            <td width=152 height=32 valign=middle>
                                <?=lang('ReservationOrder.ReservationOrderArrival')?>
                            </td>
                            <td width=472 height=32 valign=middle>
						        <? if(empty($out['DB']['ReservationOrder'][0]['ReservationOrderArrival'])) {$out['DB']['ReservationOrder'][0]['ReservationOrderArrival']=date('Y-m-d');} 
						           if(!empty($arrival_date)  && $arrival_date != '--') {$out['DB']['ReservationOrder'][0]['ReservationOrderArrival']=$arrival_date;}?>
							    <?=getFormated($out['DB']['ReservationOrder'][0]['ReservationOrderArrival'],'Date','separate',array('fieldName'=>'ReservationOrder'.DTR.'ReservationOrderArrival','formName'=>$formName,'startYear'=>date('Y')-3,'endYear'=>date("Y")+3))?>
                            </td>
                        </tr>
                        <tr>
                            <td width=152 height=32 valign=middle>
                                <?=lang('ReservationOrder.ReservationOrderDeparture')?>
                            </td>
                            <td width=472 height=32 valign=middle>
							    <? if(empty($out['DB']['ReservationOrder'][0]['ReservationOrderDeparture'])) {$out['DB']['ReservationOrder'][0]['ReservationOrderDeparture']=date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")+7, date("Y")));} 
							    if(!empty($departure_date) && $departure_date != '--') {$out['DB']['ReservationOrder'][0]['ReservationOrderDeparture']=$departure_date;} ?>
							    <?=getFormated($out['DB']['ReservationOrder'][0]['ReservationOrderDeparture'],'Date','separate',array('fieldName'=>'ReservationOrder'.DTR.'ReservationOrderDeparture','formName'=>$formName,'startYear'=>date('Y')-3,'endYear'=>date("Y")+3))?>
                            </td>
                        </tr>
                        <tr>
                            <td width=152 height=26 valign=middle>
							    <?=lang('ReservationOrder.ReservationOrderRoom')?>
                            </td>
                            <td width=472 height=26 valign=middle>
<select name="ReservationOrder<?=DTR?>ReservationOrderRooms">
    <? if(is_array($out['DB']['ReservationRooms'])) foreach($out['DB']['ReservationRooms'] as $array) {
        if ($out['DB']['ReservationOrder'][0]['ReservationOrderRooms'] == $array['OptionCode']) {
        	echo "<option selected value=".$array['OptionCode'].">".getValue($array['OptionName']);
        	$full=1;
        }
    }
    if (empty($full)) {
    	echo '<option selected>---';
    }?>
    <? if(is_array($out['DB']['ReservationRooms'])) foreach($out['DB']['ReservationRooms'] as $array) {?>
        <?if ($array['OptionReflection'] != 'hidden') {?>
            <option value="<?=$array['OptionCode']?>"><?=getValue($array['OptionName'])?></option>
        <?}?>
    <?}?>
</select>
                            </td>
                        </tr>
                        <tr>
                            <td height=22>
                                <?=lang('ReservationOrder.ReservationOrderType')?>
                            </td>
                            <td>
<?
if (empty($input['ReservationOrder'.DTR.'ReservationOrderType'])) {
    $input['ReservationOrder'.DTR.'ReservationOrderType'] = 'reservation';
}
if (!empty($out['DB']['ReservationOrder'][0]['ReservationOrderRooms']))
{
	$input['ReservationOrder'.DTR.'ReservationOrderType'] = $out['DB']['ReservationOrder'][0]['ReservationOrderType'];
}
?>

<script type = "text/javascript">
function done()
{	
	var next = document.getElementById("days");
    if (document.getElementById("type").options[document.getElementById("type").selectedIndex].value == 'option') {
        next.removeAttribute("disabled");
	}
	else {
	    next.setAttribute("disabled", "true");
	}
}
</script>

<? echo getReference('ReservationOrder.ReservationOrderType','ReservationOrder'.DTR.'ReservationOrderType',$input['ReservationOrder'.DTR.'ReservationOrderType'],array('code'=>'Y', 'delimiter'=>'&nbsp;','attributes'=>'id="type"', 'action'=>'done();'));?>

<? if (empty($out['DB']['ReservationOrder'][0]['ReservationOrderOptionValid'])) {
		$out['DB']['ReservationOrder'][0]['ReservationOrderOptionValid'] = '3';
	}
    echo '&nbsp&nbsp';
    if ($input['ReservationOrder'.DTR.'ReservationOrderType'] == 'option') {
        echo getReference('ReservationOrder.ReservationOrderOptionValid','ReservationOrder'.DTR.'ReservationOrderOptionValid', $out['DB']['ReservationOrder'][0]['ReservationOrderOptionValid'],array('code'=>'Y', 'delimiter'=>'&nbsp;', 'attributes'=>'id="days"'));
    } else {
    	echo getReference('ReservationOrder.ReservationOrderOptionValid','ReservationOrder'.DTR.'ReservationOrderOptionValid', $out['DB']['ReservationOrder'][0]['ReservationOrderOptionValid'],array('code'=>'Y', 'delimiter'=>'&nbsp;', 'attributes'=>'id="days" disabled'));
    }
?>
                            </td>
                        </tr>
                        <tr>
                            <td height=22>
                                <?=lang('ReservationOrder.ReservationOrderClient')?>
                                <? if (!empty($out['DB']['CheckUser'])) 
                                { ?>	
                                    <img src="<?=Setting('urlfiles')?>/root/images/calendar/alert_img.gif">
                                <? }
                                else
                                { ?>
                                    <img src="<?=Setting('urlfiles')?>/root/images/calendar/dotlightgrey.gif">
                                <? } ?>
                            </td>
                            <td>
                                <input type="button" value="<?=lang('ReservationOrder.ReservationOrderAddClient')?>" onclick="javascript:popup('<?=setting('url')?>manageUser/registerMode/register/GroupID/UserGroupID/user/windowAction/close/windowMode/popup/')">
                                <input id="searchUser" type="text" name="searchUser" size="7">
                                <script type = "text/javascript">
	                                var searchUser = document.getElementById("searchUser");
                                </script>
                                <input type="button" value="<?=lang('ReservationOrder.ReservationOrderSearchClient')?>" onclick="javascript:popup('<?=setting('url')?>manageReservationSearchUsers/searchUser/'+searchUser.value+'/windowMode/popup/')">
                                <? if (!empty($out['DB']['ReservationOrder'][0]['UserID'])) { ?>
                                	<input type="button" value="<?=lang('ReservationOrder.ReservationOrderClientComments')?>" onclick="javascript:popup('<?=setting('url')?>manageReservationComents/ReservationOrder<?=DTR?>ReservationOrderID/<?=input('ReservationOrderID')?>/windowMode/popup/')">
                                	<input type="button" value="<?=lang('ReservationOrder.ReservationOrderClientMessages')?>" onclick="javascript:popup('<?=setting('url')?>mailboxadm/ReceiverID/<?=$out['DB']['ReservationOrder'][0]['UserID']?>/windowParent/1/windowMode/popup/')">
                                <? } ?>
                            </td>
                            </td>
                        </tr>
                        <tr>
                            <td width=152 height=22 valign=middle>
							    <?=lang('ReservationOrder.ReservationOrderClientType')?>
                            </td>
                            <td width=472 height=22 valign=middle>
                                <input type="text" name="ReservationOrder<?=DTR?>ReservationOrderClientType" size="30" value="<?=$out['DB']['ReservationOrder'][0]['ReservationOrderClientType']?>">
                                <? if (!empty($input['ReservationOrderID']) && $input['ReservationOrder'.DTR.'ReservationOrderType'] == 'reservation') { ?>
                                <input type="button" value="<?=lang('ReservationOrder.ReservationOrderRoomServices')?>" onclick="javascript:popup('<?=setting('url')?>manageReservationRoomServices/ReservationOrderID/<?=input('ReservationOrderID')?>/windowMode/popup/')">
                                <? } ?>
                            </td>
                        </tr>
                        <tr>
                            <td width=152 height=14 valign=top>&nbsp;
                                
                            </td>
                            <td width=472 height=14 valign=top>&nbsp;

                            </td>
                        </tr>
                        <tr>
                            <td width=152 height=25 valign=top>&nbsp;
                                
                            </td>
                            <td width=472 height=25 valign=top>
						        <? if(!empty($out['DB']['ReservationOrder'][0]['ReservationOrderID'])) { ?>
						       <input type="submit" value="<?=lang('ReservationOrder.Save.tip')?>" />
                               <input type="button" value="<?=lang("ReservationOrder.Delete.tip")?>" onClick="document.<?=$formName?>.actionMode.value='delete';confirmDelete('<?=$formName?>', '<?=lang("-deleteconfirmation")?>');">
                               <input type="button" value="<?=lang("ReservationOrder.New.tip")?>" onClick="document.ReservationOrder.actionMode.value='new';submit();">
							   <a href="<?=setting('url')?>getReservationOrderLog/ReservationOrderID/<?=$out['DB']['ReservationOrder'][0]['ReservationOrderID']?>/"><?=lang('ViewChangesLog.reservation.link')?></a>
						   <? } else { ?>
<input type="submit" value="<?=lang("ReservationOrder.Add.tip")?>" >
<input type="reset" value="<?=lang("ReservationOrder.New.tip")?>">
                           <? } ?>
                            </td>
                        </tr>
                    </table>
                </td>

               
<? //------------------------------TOP-RIGHT MENU--------------------------?>


               <td width=336 height=192 valign=top bgcolor="#ffffff">
                   <table border=0 cellspacing=0 cellpadding=1>
                       <tr>
                           <td width=329 height=14 colspan=2 valign=middle bgcolor="#eeeeee">
                               <span class="listingfont">
<? if ($input['actionMode'] == "search") {?>
<?=lang('SearchResultsReservationTitle.reservation.tip')?>
<? } else {?>
    <? if ($input['searchMode'] == "searchOption") {?>
        <a href="<?=setting('url')?><?=input('SID')?>"><?=lang('LatestEntriesReservationTitle.reservation.tip')?></a>
    <? } else { ?>
        <?=lang('LatestEntriesReservationTitle.reservation.tip')?>
    <? } ?> 
<?='&nbsp;&nbsp;'?>

<? if(is_array($out['DB']['ReservationOrders'])) foreach ($out['DB']['ReservationOrders'] as $array) {
	if ($array['ReservationOrderType'] == 'option' && $array['PermAll'] != '5') {
		$checkOrders = 1;
		break;
	}
}
if ($checkOrders == 1) 
{ ?>	
    <img src="<?=Setting('urlfiles')?>/root/images/calendar/alert_img.gif">
<? }
else
{?>
    <img src="<?=Setting('urlfiles')?>/root/images/calendar/dotlightgrey.gif">
<? } ?>

<? if ($input['searchMode'] == "searchOption") {?>
    <?=lang('OptionsEntriesReservationTitle.reservation.tip')?>
<? } else { ?>
    <a href="<?=setting('url')?><?=input('SID')?>/searchMode/searchOption"><?=lang('OptionsEntriesReservationTitle.reservation.tip')?></a>
<? } ?>
<? } ?>
                               </span>
							  <? getBox('session.StatisticsMini')?>
                           </td>
                       </tr>
            <? if ($input[actionMode] == "search") {   //-----если поиск
            	if (!empty($input[searchword1])) {
            		$input[searchword] = $input[searchword1];
            	}
            	elseif (!empty($input[searchword2])) {
            		$input[searchword] = $input[searchword2];
            	}
                  $bgcolor = 1;
				  if(is_array($out['DB']['ReservationOrders'])) { foreach($out['DB']['ReservationOrders'] as $id=>$row) { ?>
<? //if ((@stristr($row['ReservationOrderArrival'], $input[searchword]) !== false) OR (@stristr($row['ReservationOrderDeparture'], $input[searchword]) !== false) OR (@stristr($row['ReservationOrderRooms'], $input[searchword]) !== false) OR (@stristr($row['ReservationOrderType'], $input[searchword]) !== false) OR (@stristr($row['ReservationOrderClientType'], $input[searchword]) !== false)) { ?>
<? if(1==1) { ?>
				      <tr>
                    <? if ($bgcolor%2 == 1) {
					      echo("<td valign='top' align='left'>");
                      }
                      else {
                          echo("<td valign='top' align='left' bgcolor='#eeeeee'>");
                      } ?>
<a href="<?=setting('url')?><?=input('SID')?>/ReservationOrderID/<?=$row['ReservationOrderID']?>/ReservationOrderArrival/<?=$row['ReservationOrderArrival']?>/"><?=$row['ReservationOrderClientType']?></a><br>
<?preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderArrival'], $date_convert);
$arrival_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
<?preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderDeparture'], $date_convert);
$departure_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
<?=$arrival_date." - ".$departure_date?>
(<?=getReferenceValue('ReservationOrder.ReservationOrderType',$row['ReservationOrderType'],'',array('code'=>'Y', 'type'=>'array'));?>)
<?=getListValue($out['DB']['ReservationRooms'],$row['ReservationOrderRooms'],array('id'=>'OptionCode','value'=>'OptionName'));?>
				          </td>
				      </tr>
                      <? $bgcolor++;
                  } } 
                  }
                  if ($bgcolor == '1')
                  {
                  	echo("<tr><td>".lang('NoSearchResults.reservation.tip')."</td></td>");
                  }
              }
              elseif ($input[searchMode] == "searchOption") {   //----если Option
                  $bgcolor = 1;
				  if(is_array($out['DB']['ReservationOrdersOptions'])) foreach($out['DB']['ReservationOrdersOptions'] as $id=>$row) { ?>
                      <?//if ($row['ReservationOrderType'] == 'option') {?>
				          <tr>
                          <?if ($bgcolor%2 == 1) {
					          echo("<td valign='top' align='left'>");
                              }
                              else {
                                  echo("<td valign='top' align='left' bgcolor='#eeeeee'>");
                              }?>
<a href="<?=setting('url')?><?=input('SID')?>/ReservationOrderID/<?=$row['ReservationOrderID']?>/ReservationOrderArrival/<?=$row['ReservationOrderArrival']?>/searchMode/<?=$input['searchMode']?>"><?=$row['ReservationOrderClientType']?></a><br>
<?preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderArrival'], $date_convert);
$arrival_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
<?preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderDeparture'], $date_convert);
$departure_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
<?preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderOptionDeadline'], $date_convert);
$deadline_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
    <?=$arrival_date." - ".$departure_date." (".lang('ReservationOrder.Release.tip')." ".$deadline_date.")"?>

<?=getListValue($out['DB']['ReservationRooms'],$row['ReservationOrderRooms'],array('id'=>'OptionCode','value'=>'OptionName'));?>
				          </td>
				      </tr>
                      <? $bgcolor++;
                  //}
                  }
              }
              else { ?>
                    <? $bgcolor = 1?>
					<? if(is_array($out['DB']['ReservationOrders'])) foreach($out['DB']['ReservationOrders'] as $id=>$row) {?>
                    <? if ($bgcolor < 7) {?>
					<tr>
                    <? if ($bgcolor%2 == 1) {
						echo("<td valign='top' align='left'>");
                      }
                      else {
                    	echo("<td valign='top' align='left' bgcolor='#eeeeee'>");
                      } ?>
<a href="<?=setting('url')?><?=input('SID')?>/ReservationOrderID/<?=$row['ReservationOrderID']?>/ReservationOrderArrival/<?=$row['ReservationOrderArrival']?>/"><?=$row['ReservationOrderClientType']?></a><br>
<?preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderArrival'], $date_convert);
$arrival_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
<?preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderDeparture'], $date_convert);
$departure_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
                            <?=$arrival_date." - ".$departure_date?>

<? $rs = getReference('ReservationOrder.ReservationOrderType','ReservationOrder'.DTR.'ReservationOrderType',$input['ReservationOrder'.DTR.'ReservationOrderType'],array('code'=>'Y', 'type'=>'array'));

if(is_array($rs)) foreach ($rs as $array) {
	if ($array['id'] == $row['ReservationOrderType']) {
		echo '('.$array['value'].')';
	}
}?>
                            
<?=getListValue($out['DB']['ReservationRooms'],$row['ReservationOrderRooms'],array('id'=>'OptionCode','value'=>'OptionName'));?>
						</td> 
					</tr>
                    <? } ?>
                    <? $bgcolor++ ?>

					<? } ?>
              <?}?>
                </table>
            </td>
<?}?>
        </tr>

<? timeTracking('ReservationRightBlockEnd'); ?>
<? //------------------------------CENTRAL-TOP MENU--------------------------?>


<?
if (!empty($input[ReservationOrderArrival]))
{
	preg_match('/(\d+)-(\d+)-(\d+)/s', $input['ReservationOrderArrival'], $date_convert);
	$currentMonth = $date_convert[2];
	$input[ReservationShowMonth] = $date_convert[2];
	$currentYer = $date_convert[1];
	$input[ReservationShowYear] = $date_convert[1];
	
}
elseif ($input[actionMode] == "save" || $input[actionMode] == "add")
{
	$currentMonth = $input['ReservationOrder_11_ReservationOrderArrival_month'];
	$input[ReservationShowMonth] = $input['ReservationOrder_11_ReservationOrderArrival_month'];
	$currentYer = $input['ReservationOrder_11_ReservationOrderArrival_year'];
	$input[ReservationShowYear] = $input['ReservationOrder_11_ReservationOrderArrival_year'];
}
else
{
	$currentMonth = date('m');
	$input[ReservationShowMonth] = date('m');
	$currentYer = date('Y');
	$input[ReservationShowYear] = date('Y');
}

	$options_month[0]['id'] = '01';
	$options_month[0]['value'] = lang('ReservationTitle.MonthJanuary.tip');
						
	$options_month[1]['id'] = '02';
	$options_month[1]['value'] = lang('ReservationTitle.MonthFebruary.tip');

	$options_month[2]['id'] = '03';
	$options_month[2]['value'] = lang('ReservationTitle.MonthMarch.tip');

	$options_month[3]['id'] = '04';
	$options_month[3]['value'] = lang('ReservationTitle.MonthApril.tip');

	$options_month[4]['id'] = '05';
	$options_month[4]['value'] = lang('ReservationTitle.MonthMay.tip');

	$options_month[5]['id'] = '06';
	$options_month[5]['value'] = lang('ReservationTitle.MonthJune.tip');

	$options_month[6]['id'] = '07';
	$options_month[6]['value'] = lang('ReservationTitle.MonthJuly.tip');

	$options_month[7]['id'] = '08';
	$options_month[7]['value'] = lang('ReservationTitle.MonthAugust.tip');

	$options_month[8]['id'] = '09';
	$options_month[8]['value'] = lang('ReservationTitle.MonthSeptember.tip');

	$options_month[9]['id'] = '10';
	$options_month[9]['value'] = lang('ReservationTitle.MonthOctober.tip');

	$options_month[10]['id'] = '11';
	$options_month[10]['value'] = lang('ReservationTitle.MonthNovember.tip');

	$options_month[11]['id'] = '12';
	$options_month[11]['value'] = lang('ReservationTitle.MonthDecember.tip');

    $options_years[0]['id'] = $currentYer-1;
	$options_years[0]['value'] = $currentYer-1;
	
	$options_years[1]['id'] = $currentYer;
	$options_years[1]['value'] = $currentYer;

	$options_years[2]['id'] = $currentYer+1;
	$options_years[2]['value'] = $currentYer+1;

	$options_years[3]['id'] = $currentYer+2;
	$options_years[3]['value'] = $currentYer+2;
	?>

<?
//echo 'ReservationShowMonth - ' . $input[ReservationShowMonth] . '<br>';
//echo 'ReservationShowMonth1 - ' . $input[ReservationShowMonth1] . '<br>';
//echo 'ReservationShowMonth2 - ' . $input[ReservationShowMonth2] . '<br>';


if (!empty($input[ReservationShowMonth1]) && $input[actionMode] != "save" && $input[actionMode] != "add" && $input[actionMode] != "show2")
{
	$input[ReservationShowMonth] = $input[ReservationShowMonth1];
}
elseif (!empty($input[ReservationShowMonth2]) && $input[actionMode] != "save" && $input[actionMode] != "add" && $input[actionMode] != "show1")
{
	$input[ReservationShowMonth] = $input[ReservationShowMonth2];
}


if (!empty($input[ReservationShowYear1]) && $input[ReservationShowYear] != $input[ReservationShowYear1] && $input[actionMode] != "save" && $input[actionMode] != "add")
{
	$input[ReservationShowYear] = $input[ReservationShowYear1];
}
elseif (!empty($input[ReservationShowYear2]) && $input[ReservationShowYear] != $input[ReservationShowYear2] && $input[actionMode] != "save" && $input[actionMode] != "add")
{
	$input[ReservationShowYear] = $input[ReservationShowYear2];
} 


$input[ReservationSearchPeriod] = 3;
if (!empty($input[ReservationSearchPeriod1]) && $input[ReservationSearchPeriod] != $input[ReservationSearchPeriod1])
{
	$input[ReservationSearchPeriod] = $input[ReservationSearchPeriod1];
}
elseif (!empty($input[ReservationSearchPeriod2]) && $input[ReservationSearchPeriod] != $input[ReservationSearchPeriod2])
{
	$input[ReservationSearchPeriod] = $input[ReservationSearchPeriod2];
}
?>
<? if (input('viewMode')!='rooms') {?>
    <?if (input('windowMode')!='print') {?>
        <tr>
            <td width=968 height=34 colspan=2 align="center" valign=middle bgcolor="#ffffff">
<?
echo getLists($options_month, $currentMonth, array('name'=>'ReservationShowMonth1'));	

echo getLists($options_years, $currentYer, array('name'=>'ReservationShowYear1'));

echo getReference('ReservationSearchPeriod1', 'ReservationSearchPeriod1',3,array('code'=>'Y','action'=>'submit();', delimiter=>'&nbsp;'))
?>

<input type="button" value="<?=lang('ReservationOrder.Show.tip')?>" onClick="document.ReservationOrder.actionMode.value='show1';submit();">
<input type="button" value="<?=lang('ReservationOrder.Print.tip')?>"onClick="popup('<?=setting('url')?><?=input('SID').'Print'?>/ReservationSearchPeriod1/<?=input('ReservationSearchPeriod1')?>/ReservationSearchPeriod2/<?=input('ReservationSearchPeriod2')?>/ReservationShowMonth1/<?=input('ReservationShowMonth1')?>/ReservationShowMonth2/<?=input('ReservationShowMonth2')?>/ReservationShowYear1/<?=input('ReservationShowYear1')?>/ReservationShowYear2/<?=input('ReservationShowYear2')?>/windowMode/print', 1024, 800)"/>
<input type="text" name="searchword1">
<input type="submit" value="<?=lang('ReservationOrder.Search.tip')?>" onClick="document.ReservationOrder.actionMode.value='search';submit();">
            </td>
        </tr>
    <? } ?>
<? } ?>


<?//------------------------------CENTRAL-MIDDLE MENU--------------------------?>


<?if (input('viewMode')!='rooms') {?>
<?for ($show_month=1; $show_month<$input[ReservationSearchPeriod]+1; $show_month++) {?>
        <tr>
            <td height=165 colspan=2 valign=top bgcolor="#ffffff">
<?if (input('windowMode')=='print') {?>
                <table border=1 cellspacing=1 cellpadding=1 bgcolor="#999999">
<?} else {?>
                <table border=0 cellspacing=1 cellpadding=1 bgcolor="#999999">
<?}?>
                    <tr>
                        <td width=400 valign=middle bgcolor="#c9ddf3">
                        <?$MOY = date("F", mktime(0, 0, 0, $input[ReservationShowMonth], 01, $input[ReservationShowYear]))?>
                        <?$MOY = MOY($MOY)?>
<?='<span class="listingfont" style="color:#FF0000">'.$MOY.' '.date("Y", mktime(0, 0, 0, $input[ReservationShowMonth], 01, $input[ReservationShowYear])).'</span>';?>

<?
$month = date("m", mktime(0, 0, 0, $input[ReservationShowMonth], 01, $input[ReservationShowYear]));
$year = date("Y", mktime(0, 0, 0, $input[ReservationShowMonth], 01, $input[ReservationShowYear]));
if(is_array($out['DB']['ReservationOrderStat'])) foreach ($out['DB']['ReservationOrderStat'] as $array) {	
    if ($array['ReservationOrderStatMonth'] == $month && $array['ReservationOrderStatYear'] == $year) {
    	//print_r($array);
		echo '<span class="listingfont">'.round($array['ReservationOrderStatProcent']).'%</font>';
		//echo '<span class="listingfont">'.round($procent_reservation_rooms, 2).'%</font>';
    	break;
    }
}
?>

<? //='<span class="listingfont">'.round($procent_reservation_rooms, 2).'%</span>';?>
                        </td>
<? for($number=1; $number<=date('t', mktime(0, 0, 0, $input[ReservationShowMonth], 01, $input[ReservationShowYear])); $number++) 
{
	$daybgcolor = "#c9ddf3";
	$currentDayTimeStmp = mktime(0, 0, 0, $input[ReservationShowMonth], $number, $input[ReservationShowYear]);
	$dayDateString = date('Y-m-d',$currentDayTimeStmp);
	if($dayDateString == date('Y-m-d'))
	{
		$daybgcolor = "#00CC00";
	}
	if (date('D', $currentDayTimeStmp) == 'Sun') { ?>
		<td width=22 height=14 align='center' valign='middle' bgcolor='<?=$daybgcolor?>'><a href='#' onclick="javascript:popup('<?=setting('url')?>manageReservationStatistics/year/<?=$input['ReservationShowYear']?>/month/<?=$input['ReservationShowMonth']?>/date/<?=$number?>/windowMode/popup/')"><span class="listingfont" style="color:#FF0000"><?=$number?></span></font></a></td>
	<? } else { ?>
		<td width=22 height=14  align='center' valign='middle' bgcolor='<?=$daybgcolor?>'><a href='#' onclick="javascript:popup('<?=setting('url')?>manageReservationStatistics/year/<?=$input['ReservationShowYear']?>/month/<?=$input['ReservationShowMonth']?>/date/<?=$number?>/windowMode/popup/')"><span class="listingfont"><?=$number?></span></font></a></td>
	<? }
}?>
</tr>
<?
$i1 = 1;
$bgcolor = '#ffffff';
if(is_array($out['DB']['ReservationRooms'])) foreach($out['DB']['ReservationRooms'] as $array) {
$array['OptionName'] = $array['OptionName'];
        if ($array['OptionCode'] != 'new') {
            if ($i%2 == 1) {
                $bgcolor='#eeeeee';
            }
            else {
                $bgcolor='#ffffff';
            }
            if ($array['OptionRoomType'] == 'info') {
                $bgcolor='#ffff99';
            }?>
                <tr><td height=19 valign=middle bgcolor=<?=$bgcolor?>>
                <? $check_tasks = 0; ?>
                <? if(is_array($out['DB']['ReservationRoomTask'])) foreach($out['DB']['ReservationRoomTask'] as $tasks_array) 
                   {
	                   if ($tasks_array['ReservationRoomTaskRoomID'] == $array['OptionCode'])
	                   {
	                       $check_tasks = 1;
	                   }
                   } ?>
                <? if ($check_tasks == 1)
                   {?>
                       <img src="<?=Setting('urlfiles')?>/root/images/calendar/alert_img.gif">
                   <?}
                   else
                   {?>
                   	   <img src="<?=Setting('urlfiles')?>/root/images/calendar/dotlightgrey.gif">
                   <?}?>
                &nbsp; <a href='#' onclick="javascript:popup('<?=setting('url')?>manageReservationRoomTasks/RoomID/<?=$array['OptionCode']?>/RoomName/<?=getValue($array['OptionName'])?>/windowMode/popup/')"><?=getValue($array['OptionName'])?></a></td>
        <? $i++;
        }

$i1 = 1;
        if ($array['OptionCode'] != 'new') {
            for($number=1; $number<=date("t", mktime(0, 0, 0, $input[ReservationShowMonth], 01, $input[ReservationShowYear])); $number++) {
      	        $date_arrival = date("Y-m-d", mktime(0, 0, 0, $input[ReservationShowMonth], $number, $input[ReservationShowYear]));
      	        $date_departure = date("Y-m-d", mktime(0, 0, 0, $input[ReservationShowMonth], $number+1, $input[ReservationShowYear]));
               if(is_array($out['DB']['ReservationOrders'])) foreach($out['DB']['ReservationOrders'] as $id=>$row) {

              if ($row['ReservationOrderArrival'] == $date_arrival && $row['ReservationOrderDeparture'] == $date_departure && $row['ReservationOrderRooms'] == $array['OptionCode']) {?>

<? 
preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderArrival'], $date_convert);
$arrival_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];
preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderDeparture'], $date_convert);
$departure_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
                 <? if ($i1%2 != 1) {
                      $bgcolor='#eeeeee';
                  }
                  else {
                      $bgcolor='#ffffff';
                  }
                      if ($array['OptionRoomType'] == 'info') {
                      $bgcolor='#ffff99';
                  }?>
                  <td width=22 height=19 valign=middle bgcolor="<?=$bgcolor?>"><a href="<?=setting('url')?><?=input('SID')?>/ReservationOrderID/<?=$row['ReservationOrderID']?>/ReservationOrderArrival/<?=$row['ReservationOrderArrival']?>/">
<?
if ($row['ReservationOrderType'] == 'reservation') {?>
<img src='<?=Setting('urlfiles')?>/root/images/calendar/item4b1b1.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } elseif ($row['ReservationOrderType'] == 'option' && $row['PermAll'] == '4') {?>
    <?if($row['GroupID'] == 'root' || empty($row['GroupID'])) {?>
        <img src='<?=Setting('urlfiles')?>/root/images/calendar/item4b1b1b.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
    <?} else {?>
        <img src='<?=Setting('urlfiles')?>/root/images/calendar/clientresboth.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
    <?}?>
<? } elseif ($row['ReservationOrderType'] == 'option' && $row['PermAll'] == '5') {?>
    <img src='<?=Setting('urlfiles')?>/root/images/calendar/unavailable_both.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } elseif ($row['ReservationOrderType'] == 'unavailable') {?>
<img src='<?=Setting('urlfiles')?>/root/images/calendar/unavailable_both.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } elseif ($row['ReservationOrderType'] == 'other') {?>
<img src='<?=Setting('urlfiles')?>/root/images/calendar/item4b1b1b1a.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? }?>
               <? $busy_room = 1;
                 $i1++;
                 break;
             }
             
             elseif ($row['ReservationOrderArrival'] == $date_arrival && $row['ReservationOrderRooms'] == $array['OptionCode']) {?>

<? 
preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderArrival'], $date_convert);
$arrival_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];
preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderDeparture'], $date_convert);
$departure_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
                <td width=22 height=19 valign=middle bgcolor="<?=$bgcolor?>"><a href="<?=setting('url')?><?=input('SID')?>/ReservationOrderID/<?=$row['ReservationOrderID']?>/ReservationOrderArrival/<?=$row['ReservationOrderArrival']?>/">
<?
if ($row['ReservationOrderType'] == 'reservation') {?>
<img src='<?=Setting('urlfiles')?>/root/images/calendar/item4a1.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } elseif ($row['ReservationOrderType'] == 'option' && $row['PermAll'] == '4') {?>
    <?if($row['GroupID'] == 'root' || empty($row['GroupID'])) {?>
        <img src='<?=Setting('urlfiles')?>/root/images/calendar/item4a1c1.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
    <?} else {?>
        <img src='<?=Setting('urlfiles')?>/root/images/calendar/clientresleft.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
    <?}?>
<? } elseif ($row['ReservationOrderType'] == 'option' && $row['PermAll'] == '5') {?>
    <img src='<?=Setting('urlfiles')?>/root/images/calendar/unavailable_left.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } elseif ($row['ReservationOrderType'] == 'unavailable') {?>
<img src='<?=Setting('urlfiles')?>/root/images/calendar/unavailable_left.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } elseif ($row['ReservationOrderType'] == 'other') {?>
<img src='<?=Setting('urlfiles')?>/root/images/calendar/item4a4a.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? }?>
               <? $busy_room = 1;
                 $i1++;
                 break;
              }
              
              elseif ($row['ReservationOrderArrival'] < $date_arrival && $row['ReservationOrderDeparture'] > $date_departure && $row['ReservationOrderRooms'] == $array['OptionCode']) {?>

<? preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderArrival'], $date_convert);
$arrival_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];
preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderDeparture'], $date_convert);
$departure_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
                  <td width=22 height=19 valign=middle bgcolor="<?=$bgcolor?>"><a href="<?=setting('url')?><?=input('SID')?>/ReservationOrderID/<?=$row['ReservationOrderID']?>/ReservationOrderArrival/<?=$row['ReservationOrderArrival']?>/">
<?
if ($row['ReservationOrderType'] == 'reservation') { ?>
<img src='<?=Setting('urlfiles')?>/root/images/calendar/item4b1c1.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } elseif ($row['ReservationOrderType'] == 'option' && $row['PermAll'] == '4') {?>
    <?if($row['GroupID'] == 'root' || empty($row['GroupID'])) {?>
        <img src='<?=Setting('urlfiles')?>/root/images/calendar/item4b1c4b1.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
    <?} else {?>
        <img src='<?=Setting('urlfiles')?>/root/images/calendar/clientresstay.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
    <?}?>
<? } elseif ($row['ReservationOrderType'] == 'option' && $row['PermAll'] == '5') {?>
    <img src='<?=Setting('urlfiles')?>/root/images/calendar/unavailable_current.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } elseif ($row['ReservationOrderType'] == 'unavailable') {?>
<img src='<?=Setting('urlfiles')?>/root/images/calendar/unavailable_current.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } elseif ($row['ReservationOrderType'] == 'other') {?>
<img src='<?=Setting('urlfiles')?>/root/images/calendar/item4b1c4b1c.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } ?>
               <? $busy_room = 1;
                 $i1++;
                 break;
             }
             
             elseif ($row['ReservationOrderDeparture'] == $date_departure && $row['ReservationOrderRooms'] == $array['OptionCode']) {?>

<? 


preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderArrival'], $date_convert);
$arrival_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];
preg_match('/(\d+)-(\d+)-(\d+)/s', $row['ReservationOrderDeparture'], $date_convert);
$departure_date = $date_convert[3].".".$date_convert[2].".".$date_convert[1];?>
                 <td width=22 height=19 valign=middle bgcolor="<?=$bgcolor?>"><a href="<?=setting('url')?><?=input('SID')?>/ReservationOrderID/<?=$row['ReservationOrderID']?>/ReservationOrderArrival/<?=$row['ReservationOrderArrival']?>/">
<?
if ($row['ReservationOrderType'] == 'reservation') { ?>
<img src='<?=Setting('urlfiles')?>/root/images/calendar/item4b2a.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } elseif ($row['ReservationOrderType'] == 'option' && $row['PermAll'] == '4') { ?>
    <?if($row['GroupID'] == 'root' || empty($row['GroupID'])) {?>
        <img src='<?=Setting('urlfiles')?>/root/images/calendar/item4b2a1a1.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
        <?} else {?>
            <img src='<?=Setting('urlfiles')?>/root/images/calendar/clientresright.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
        <?}?>
<? } elseif ($row['ReservationOrderType'] == 'option' && $row['PermAll'] == '5') {?>
    <img src='<?=Setting('urlfiles')?>/root/images/calendar/unavailable_right.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } elseif ($row['ReservationOrderType'] == 'unavailable') { ?>
<img src='<?=Setting('urlfiles')?>/root/images/calendar/unavailable_right.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } elseif ($row['ReservationOrderType'] == 'other') { ?>
<img src='<?=Setting('urlfiles')?>/root/images/calendar/item4b2d.gif' border=0 width=20 height=14 title='<?=$row['ReservationOrderClientType']?> <?=$arrival_date."-".$departure_date?> <?=getValue($array['OptionName'])?>'></a></td>
<? } ?>
              <? $busy_room = 1;
                $i1++;
                break;
            }
            else {
                $busy_room = 0;
            }
        }
        if($busy_room == 0) { 
            echo("<td width=22 height=19 valign=middle bgcolor=".$bgcolor."><img src='http://manacoel.com/templates/Resources/free.gif' border=0 width=20 height=14></td>");
        $i1++;
        }
        }
    echo("</tr>");
    }
}?>
</table>
<? $tracki++; timeTracking('ReservationCalendar-'.$tracki); ?>
</td></tr>
<?
$input[ReservationShowMonth] = $input[ReservationShowMonth]+1;?>
<?}?>


<?//------------------------------CENTRAL-BOTTOM MENU--------------------------?>

<?if (input('windowMode')!='print') {?>
<tr>
<td width=968 height=34 colspan=2 align="center" valign=middle bgcolor="#ffffff"><p class="style15 f-lp">

<?					
echo getLists($options_month, $currentMonth, array('name'=>'ReservationShowMonth2'));	

echo getLists($options_years, $currentYer, array('name'=>'ReservationShowYear2'));

echo getReference('ReservationSearchPeriod2','ReservationSearchPeriod2',3,array('code'=>'Y','action'=>'submit();', delimiter=>'&nbsp;'));
?>

<input type="button" value="<?=lang('ReservationOrder.Show.tip')?>" onClick="document.ReservationOrder.actionMode.value='show2';submit();">
<input type="button" value="<?=lang('ReservationOrder.Print.tip')?>"onClick="popup('<?=setting('url')?><?=input('SID').'Print'?>/ReservationSearchPeriod1/<?=input('ReservationSearchPeriod1')?>/ReservationSearchPeriod2/<?=input('ReservationSearchPeriod2')?>/windowMode/print', 1024, 800)"/>
<input type="text" name="searchword2">
<input type="submit" value="<?=lang('ReservationOrder.Search.tip')?>" onClick="document.ReservationOrder.actionMode.value='search';submit();">
</td>
</tr>
<?}?>
<?}?>
</table>
</form>

<script language="JavaScript">
             /*   var fromValidator = new Validator("ReservationOrder");

				fromValidator.setAddnlValidationFunction("CustomValidationFunction");
				function CustomValidationFunction () 
				{ 
					var frm = document.forms["ReservationOrder"]; 
					if (ReservationOrder.ReservationOrder<?=DTR?>ReservationOrderRooms.selectedIndex == 0) {
						ReservationOrder.ReservationOrder<?=DTR?>ReservationOrderRooms.focus();
						<? echo 'alert("'.lang('ReservationOrderRoomsRequired.reservation.tip').'");'; ?>
						return false;
					}
					 
					return true;  
				}
								
                fromValidator.addValidation("ReservationOrder<?=DTR?>ReservationOrderClientType","req","<?=lang('ReservationOrderClientTypeRequired.reservation.tip')?>");
*/
</script>

<? } ?>


<?//------------------------------AVAILABILITY--------------------------?>

<?//print_r($out['DB']['ReferenceOption'])?>
<?//print_r($out['DB']['ReservationOrders']);?>

<?if (input('viewMode')=='availability') {?>
<? $formName  = 'ReservationOrderAvailability'; ?>
<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="actionMode" value="<?=input('actionMode')?>" />
	<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
 	<input type="hidden" name="ReservationOrder_11_ReservationOrderID" value="<?=input('ReservationOrderID')?>" />
 	<input type="hidden" name="viewMode" value="<?=input('viewMode')?>" />
<?
	$arrival_date = input('ReservationOrder'.DTR.'ReservationOrderArrival_day').'.'.input('ReservationOrder'.DTR.'ReservationOrderArrival_month').'.'.input('ReservationOrder'.DTR.'ReservationOrderArrival_year');
	$departure_date = input('ReservationOrder'.DTR.'ReservationOrderDeparture_day').'.'.input('ReservationOrder'.DTR.'ReservationOrderDeparture_month').'.'.input('ReservationOrder'.DTR.'ReservationOrderDeparture_year');
	
	if(empty($arrival_date)) {$arrival_date = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")));}
	if(empty($departure_date)) {$departure_date = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")+7, date("Y")));}
?>	

<table border=0 cellspacing=1 cellpadding=3 bgcolor="#999999" width="100%">
    <tr>
        <td width="100%" valign="top" bgcolor="#ffffff">
            <table border="0" cellspacing="0" cellpadding="1" align="center" width="100%">
                <tr>
                    <td align="left"  height=14 colspan=2 valign=middle bgcolor="#eeeeee">
                        <span class="listingfont"><?=lang('AvailabilityReservationTitle.reservation.tip')?></span>
                    </td>
                </tr>
                <tr>
                    <td width=200 valign=middle>
                        <?=lang('ReservationOrder.ReservationOrderArrival')?>
                    </td>
                    <td valign=middle>
						<?if (empty($input['ReservationOrder'.DTR.'ReservationOrderArrival_day']) || empty($input['ReservationOrder'.DTR.'ReservationOrderDeparture_day']))
                        {
            	            $arrival = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d"), date("Y")));
            	            $departure = date('Y-m-d', mktime(0, 0, 0, date("m"), date("d")+7, date("Y")));
                        }
                        else
                        {
                        	$arrival = input('ReservationOrder'.DTR.'ReservationOrderArrival_year').'-'.input('ReservationOrder'.DTR.'ReservationOrderArrival_month').'-'.input('ReservationOrder'.DTR.'ReservationOrderArrival_day');
	                        $departure = input('ReservationOrder'.DTR.'ReservationOrderDeparture_year').'-'.input('ReservationOrder'.DTR.'ReservationOrderDeparture_month').'-'.input('ReservationOrder'.DTR.'ReservationOrderDeparture_day');
                        }?>
			            
						<?=getFormated($arrival,'Date','separate',array('fieldName'=>'ReservationOrder'.DTR.'ReservationOrderArrival','formName'=>$formName,'startYear'=>date('Y'),'endYear'=>date("Y")+3))?>
                    </td>
                </tr>
                <tr>
                    <td  height=32 valign=middle>
                        <?=lang('ReservationOrder.ReservationOrderDeparture')?>
                    </td>
                    <td  height=32 valign=middle>
				        <?=getFormated($departure,'Date','separate',array('fieldName'=>'ReservationOrder'.DTR.'ReservationOrderDeparture','formName'=>$formName,'startYear'=>date('Y'),'endYear'=>date("Y")+3))?>
                    </td>
                </tr>
                <tr>
                    <td>
                        <?=lang('ReservationOrder.ReservationOrderTotalPersons')?>
                    </td>
                    <td>
                        <?$total_persons = input('total_persons'); if(empty($total_persons)) {$total_persons=2;}?>
						<input type="text" name="total_persons" size="30" value="<?=$total_persons?>" >
                    </td>
                </tr>
                <tr>
                    <td>
                        <?=lang('ReservationOrder.ReservationOrderChildren')?>
                    </td>
                    <td>
                        <?$children = input('children'); if(empty($children)) {$children=0;}?>
                        <input type="text" name="children" size="30" value="<?=$children?>">
                    </td>
                </tr>
                <tr>
					<td>&nbsp;</td>
                    <td align="left">
                        <input type="button" value="<?=lang('AvailabilityReservationTitle.reservation.tip')?>" onClick="document.<?=$formName?>.actionMode.value='availability';submit();">
                    </td>
                </tr>
            </table>
        </td>
        
<?//------------------------------AVAILABILITY Search results--------------------------?>
        

    </tr>
    <tr>
        <td width="100%" align="center" valign=top bgcolor="#ffffff">
            <table border=0 cellspacing=0 cellpadding=1 width="100%">
                        <? if ($input[actionMode] == 'availability') {
				?>
				<? $rs=$out['DB']['ReservationRooms'];
                        	$arrival_date = input('ReservationOrder'.DTR.'ReservationOrderArrival_year').'-'.input('ReservationOrder'.DTR.'ReservationOrderArrival_month').'-'.input('ReservationOrder'.DTR.'ReservationOrderArrival_day');
                        	$departure_date = input('ReservationOrder'.DTR.'ReservationOrderDeparture_year').'-'.input('ReservationOrder'.DTR.'ReservationOrderDeparture_month').'-'.input('ReservationOrder'.DTR.'ReservationOrderDeparture_day');

if(is_array($out['DB']['ReservationSearchRooms'])) foreach($out['DB']['ReservationSearchRooms'] as $array) {
    if(is_array($out['DB']['ReservationOrders'])) foreach($out['DB']['ReservationOrders'] as $id=>$row) {
        if ($array['OptionCode'] == $row['ReservationOrderRooms'] &&
            ((input('total_persons') < $array['OptionMinOccupation']) ||
            (input('total_persons') > $array['OptionMaxOccupation']) ||
            (input('children') > $array['OptionMaxChildren']) ||
            ($arrival_date == $row['ReservationOrderArrival'] ||
            $departure_date == $row['ReservationOrderDeparture']) ||
            ($arrival_date < $row['ReservationOrderArrival'] &&
            $departure_date < $row['ReservationOrderDeparture'] &&
            $departure_date > $row['ReservationOrderArrival']) ||
            ($arrival_date > $row['ReservationOrderArrival'] &&
            $departure_date < $row['ReservationOrderDeparture']) ||
            ($arrival_date < $row['ReservationOrderArrival'] &&
            $departure_date > $row['ReservationOrderDeparture']) ||
            ($departure_date > $row['ReservationOrderDeparture'] &&
            $arrival_date > $row['ReservationOrderArrival'] &&
            $arrival_date < $row['ReservationOrderDeparture'])))
        {
            $array['OptionCode'] = '';
        }
    }
    if (!empty($array['OptionCode']))
    {
    	break;
    }
}?>
<?if ($array['OptionCode'] != '')
{?>
    <td bgcolor="#eeeeee" align="center" colspan="2">
        <?$nights = (strtotime($departure_date)-strtotime($arrival_date))/60/60/24?>
        <span class="listingfont"><?=lang('SearchResultsReservationTitle1.reservation.tip').' '.input('total_persons').' '.lang('SearchResultsReservationTitle2.reservation.tip').' '.$arrival_date.' '.lang('ReservationStatistics.ReservationStatisticsTill').' '.$departure_date.' '.lang('ReservationStatistics.ReservationStatisticsStay').' '.$nights.' '.lang('ReservationStatistics.ReservationStatisticsNights')?></span>
    </td>
<?} else {?>
    <td bgcolor="#eeeeee" align="center" colspan="2">
	    <span class="listingfont"><?=lang('SearchResultsReservationEmptyTitle.reservation.tip').' '.$arrival_date.' '.lang('ReservationStatistics.ReservationStatisticsTill').' '.$departure_date?></span>
	</td>
<?}?>

<? if(is_array($out['DB']['ReservationSearchRooms'])) foreach($out['DB']['ReservationSearchRooms'] as $array) {
        	if(is_array($out['DB']['ReservationOrders'])) foreach($out['DB']['ReservationOrders'] as $id=>$row) {
                if ($array['OptionCode'] == $row['ReservationOrderRooms'] &&
                  ((input('total_persons') < $array['OptionMinOccupation']) ||
                   (input('total_persons') > $array['OptionMaxOccupation']) ||
                   (input('children') > $array['OptionMaxChildren']) ||
                   ($arrival_date == $row['ReservationOrderArrival'] ||
                    $departure_date == $row['ReservationOrderDeparture']) ||
                   ($arrival_date < $row['ReservationOrderArrival'] &&
                    $departure_date < $row['ReservationOrderDeparture'] &&
                    $departure_date > $row['ReservationOrderArrival']) ||
                   ($arrival_date > $row['ReservationOrderArrival'] &&
                    $departure_date < $row['ReservationOrderDeparture']) ||
                   ($arrival_date < $row['ReservationOrderArrival'] &&
                    $departure_date > $row['ReservationOrderDeparture']) ||
                    ($departure_date > $row['ReservationOrderDeparture'] &&
                    $arrival_date > $row['ReservationOrderArrival'] &&
                    $arrival_date < $row['ReservationOrderDeparture'])))
                {
                    $array['OptionCode'] = '';
                }
        	}
        	if ($array['OptionCode'] != '')
        	{?>
                <? if(is_array($rs)) foreach($rs as $rs_array) {
                	if ($rs_array['OptionCode'] == $array['OptionCode'])
                	{
                		if(empty($array['OptionIcon'])) {$array['OptionIcon'] = setting('NoImageIcon');}
						        if ($array['OptionIcon'] == setting('NoImageIcon')) {
						            echo "<tr><td  width='200'>".getFormated($array['OptionIcon'],'Image','',array('imageSizeType'=>'all','fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))."</td><td valign = 'top'><a href = ".getValue($array['OptionRoomUrl']).">".getValue($rs_array['OptionName'])."</a><br/>".getValue($array['OptionDescription'])."</td></tr>";
						        } else {
						        	if ($array['OptionRoomTarget'] == '_blank')
						        	{
						        		if (strstr($array['OptionRoomUrl'], $_SERVER['HTTP_HOST']))
						        		{?>
						        			<tr><td  width='200'><a href='#' onclick="javascript:popup('<?=$array['OptionRoomUrl']?>')"><?=getFormated($array['OptionIcon'],'Image','',array('imageSizeType'=>'all','fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?></a></td><td valign = 'top'><a href = <?=getValue($array['OptionRoomUrl'])?>><?=getValue($rs_array['OptionName'])?></a><br/><?=getValue($array['OptionDescription'])?></td></tr>
						        		<?} else {?>
						        			<tr><td  width='200'><a href = <?=$array['OptionRoomUrl']?> target = _blank><?=getFormated($array['OptionIcon'],'Image','',array('imageSizeType'=>'all','fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?></a></td><td valign = 'top'><a href = <?=getValue($array['OptionRoomUrl'])?>><?=getValue($rs_array['OptionName'])?></a><br/><?=getValue($array['OptionDescription'])?></td></tr>
						        		<?}
						        		
						        	} else {?>
						        		<tr><td  width='200'><a href = <?=$array['OptionRoomUrl']?> ><?=getFormated($array['OptionIcon'],'Image','',array('imageSizeType'=>'all','fieldName'=>$fieldName,'deleteLink'=>'<a href="javascript://" onClick="document.'.$formName.'.SID.value=\''.input('SID').'\';document.'.$formName.'.actionMode.value=\'deletefile\';document.'.$formName.'.fileField.value=\''.$fieldName.'\';document.'.$formName.'.submit();">'.lang('-deleteimage').'</a>'))?></a></td><td valign = 'top'><a href = <?=getValue($array['OptionRoomUrl'])?>><?=getValue($rs_array['OptionName'])?></a><br/><?=getValue($array['OptionDescription'])?></td></tr>
						        	<?}
						        }?>
						<tr><td colspan="2"><hr size="1"/></td></tr>
					<?}
                }
        	}
	}
}
?>
            </table>
        </td>
    </tr>
</table>
</form>

<? } ?>

</td></tr>
<?=boxFooter()?>
<? } ?>
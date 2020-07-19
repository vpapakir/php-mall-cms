<?=boxHeader(array('title'=>'','tabs'=>'manageReservationSearchUsers'))?>
<tr><td>

<?//print_r($input);?>
<?//print_r($config)?>
<?//print_r($user)?>
<?//print_r($out)?>

<? $formName  = 'ReservationSearchUser'; ?>
<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="actionMode" value="<?=input('actionMode')?>" />
	<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
	<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />

	<table border=0 align='center' cellspacing=1 cellpadding=3 bgcolor='#999999'>
	    <tr>
            <td valign='top' bgcolor='#ffffff'>
                <table border=0 width="670" cellspacing=0 cellpadding=1>
                    <tr>
                        <td align='center' colspan='3' bgcolor='#eeeeee'>
	                        <span class="listingfont"><?=lang('ReservationSearchUsers.ReservationSearchUser')?></span>
	                    </td>
	                </tr>
	                <tr>
                        <td height=14 colspan='3'>&nbsp;
                            
                        </td>
                    </tr>
                    <tr>
                        <td align="center" height=14 colspan='3'>
                            <input type="text" name="searchUser">
<input type="submit" value="<?=lang('ReservationSearchUsers.Search.tip')?>" onClick="document.ReservationSearchUser.actionMode.value='search';submit();">
                        </td>
                    </tr>
                    <tr>
                        <td height=14 colspan='3'>&nbsp;
                            
                        </td>
                    </tr>
                        <? foreach ($out['DB']['ReservationUserFields'] as $UserFieldsArray) { ?>
                            <tr>
                                <td width="30%">
                                    <a href='#' onclick="javascript:window.opener.document.ReservationOrder.ReservationOrder<?=DTR?>ReservationOrderClientType.value='<?=$out['DB']['ReservationOrders']['0']['ReservationOrderID']+10000?> <?=ucwords($UserFieldsArray['FirstName'])?> <?=strtoupper($UserFieldsArray['LastName'])?>'; window.opener.document.ReservationOrder.ReservationOrder<?=DTR?>UserID.value='<?=$UserFieldsArray['UserID']?>'; window.close();"><?=ucwords($UserFieldsArray['FirstName'])?> <?=strtoupper($UserFieldsArray['LastName'])?></a>
                                    <a href="javascript://" onClick="popup('<?=setting('url')?>viewUser/UserID/<?=$UserFieldsArray['UserID']?>/windowMode/popup/')"><?=lang('ReservationSearchUsers.profile.tip')?></a>
                                </td>
                                <td>
                                    <?=$UserFieldsArray['Address']?> <?=$UserFieldsArray['City']?> <?=$UserFieldsArray['Country']?>
                                </td>
                                <td>
                                    <a href="javascript://" onClick="popup('<?=setting('url')?>manageUser/UserID/<?=$UserFieldsArray['UserID']?>/windowMode/popup/')"><?=lang('ReservationSearchUsers.edit.tip')?></a>
                                </td>
                            </tr>
                        <? } ?>
                            <tr>
                                <td height=14 colspan='3'>&nbsp;
                                    
                                </td>
                            </tr>
                            <tr>
                                <td align="center" colspan="3">
                                    <input type="button" value="<?=lang('ReservationOrder.ReservationOrderAddClient')?>" onclick="javascript:goback('<?=setting('url')?>manageUser/registerMode/register/GroupID//UserGroupID/user/windowAction/close/windowMode/popup/')">
                                </td>
                            </tr>
                        <!--<?foreach ($out['DB']['ReservationSearchUser'] as $UserArray) {
                            if ($UserFieldsArray['UserID'] != $UserArray['UserID'])
                            { ?>
                            	<tr><td><a href='#' onclick="javascript:window.opener.document.ReservationOrder.ReservationOrder<?=DTR?>ReservationOrderClientType.value='<?=$out['DB']['ReservationOrders']['0']['ReservationOrderID']+10000?> <?=$UserArray['FirstName']?> <?=$UserArray['LastName']?>'; window.opener.document.ReservationOrder.ReservationOrder<?=DTR?>UserID.value='<?=$UserArray['UserID']?>'; window.close();"><?=$UserArray['FirstName']?> <?=$UserArray['LastName']?></a></td>
                                <td><?=$UserArray['UserID']?></td></tr>
                         <?}
                         }?>-->
	            </table>
	        </td>
	    </tr>
	</table>
</form>

</td></tr>
<?=boxFooter()?>
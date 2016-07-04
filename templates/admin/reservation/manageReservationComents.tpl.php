<?=boxHeader(array('title'=>'','tabs'=>'manageReservationComents'))?>
<tr><td>

<?//print_r($input);?>
<?//print_r($config)?>
<?//print_r($user)?>
<?//print_r($out)?>


<? $formName  = 'ReservationComent'; ?>
<form name="<?=$formName?>" method="post" onSubmit="submitonce(this)">
	<input type="hidden" name="SID" value="<?=input('SID')?>" />
	<input type="hidden" name="actionMode" value="<?=input('actionMode')?>" />
	<input type="hidden" name="windowMode" value="<?=input('windowMode')?>" />
	<input type="hidden" name="PermAll" value="<?=input('PermAll')?>" />
	<input type="hidden" name="ReservationOrder<?=DTR?>ReservationOrderID" value="<?=input('ReservationOrder'.DTR.'ReservationOrderID')?>" />
 
 	
	<table border=0 align='center' cellspacing=1 cellpadding=3 bgcolor='#999999'>
	    <tr>
            <td valign='top' bgcolor='#ffffff'>
                <table border=0 width="670" cellspacing=0 cellpadding=1>
                    <tr>
                        <td height=14 colspan='2'>
                            &nbsp;
                        </td>
                    </tr>
	                <tr>
	                    <td align='center'>
	                        <TEXTAREA rows=15 cols=50 name="ReservationOrder<?=DTR?>ReservationOrderComents" size="30"><?=$out['DB']['ReservationComent'][0]['ReservationOrderComents']?></TEXTAREA>
	                    </td>
	                </tr>
	                <tr>
                        <td height=14 colspan='2'>
                            &nbsp;
                        </td>
                    </tr>
	                <tr>
                        <td align='center' colspan='2'>
                            <input type="button" value="<?=lang("ReservationComents.save.button")?>" onClick="document.<?=$formName?>.actionMode.value='save'; submit();">
	                    </td>
	                </tr>
	            </table>
	        </td>
	    </tr>

	</table>
</form>

</td></tr>
<?=boxFooter()?>
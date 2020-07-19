<?=boxHeader(array('title'=>lang('PaymentForm.billing.title')))?>
<? if($out['Balance']>0){?>
	<tr>
		<td valign="top" bgcolor="#ffffff" align="center">
			<font color="#FF0000">
			You have paid for our services.
			<br/><br/>
			After first 3 months you are billed $15 each month.<br/><br/>
			</font>
		</td>
	</tr>
<? }else{?>
	<tr>
		<td valign="top" bgcolor="#ffffff" align="center">
		<form method="post" name="paymentForm" onSubmit="submitonce(this)">
		<input type="hidden" name="SID" value="paymentRequest" />
		<input type="hidden" name="paymentMethod" value="<?=input('paymentMethod')?>" />
		<input type="hidden" name="actionMode" value="pay" />
		
		<input type="hidden" name="BillingOrder<?=DTR?>OrderAmount" value="45" />
		<input type="hidden" name="BillingOrder<?=DTR?>OrderReturnURL" value="<?=input('SID')?>/paymentMethod/SecurePay/" />
		
		<strong>Welcome, <?=user('UserName')?></strong> 
		<p>
			<font color="#FF0000"><b>To become a member your first payment is $45 for 3 months and then 
			you will be billed $15 each month until your membership is cancelled.</b></font>
		</p>
		
		<input type="hidden" name="NumberOfMonths" value="3" />
		<table width="90%"  border="0" cellspacing="5" cellpadding="0">
  <tr>
    <td width="20%"><b>Card number*:</b></td>
    <td><input type="text" name="cardNumber" size="50"/></td>
  </tr>
  <tr>
    <td><b>Expiration date*:</b></td>
    <td>Month - <input type="text" name="expiryMonth" size="2" maxlength="2"/> / Year <input type="text" name="expiryYear" size="2" maxlength="2"/> (Example: 02/06)</td>
  </tr>
  <tr>
    <td><b>CVV number:</b></td>
    <td><input type="text" name="cvv" size="10"/></td>
  </tr>
</table>

	
		<input type="submit" name="goSave" value="Pay with your credit card"/>&#160;&#160;&#160;&#160;&#160;
		</form>
		<script language="JavaScript">
				var fromValidator = new Validator("paymentForm");
				fromValidator.addValidation("cardNumber","req","<?=lang('CardNumberWarning.billing.tip')?>");
				fromValidator.addValidation("expiryMonth","req","<?=lang('ExpiryMonthWarning.billing.tip')?>");
				fromValidator.addValidation("expiryYear","req","<?=lang('ExpiryYearWarning.billing.tip')?>");
		</script>
		</td>
	</tr>
		
	<? }?>		
<?=boxFooter()?>

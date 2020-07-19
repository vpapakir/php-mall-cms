<? getBox('core.frontAdminController'); ?>
<?=getBoxes('system')?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=setting('PageTitle')?> <?=setting('SiteName')?></title>
<link href="<?=setting('layout')?>css/main.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript1.2" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/en/mainscript.js"></script>
<script language="javascript" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/en/validator/validator.js"></script>
<script language="javascript" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/en/calendar/calendar.js"></script>
</head>
<body topmargin=0 leftmargin=0 marginheight=0 background="<?=setting('layout')?>images/bg.gif" marginwidth=0 link="#666600" alink="#cc0033" vlink="#666600"> 
<div id="LayoutTable" align=center> 
    <table border=0 cellspacing=0 cellpadding=0 width=773> 
	<tr height="98">
	<td>

		<table width="100%" border="0" cellpadding="0" cellspacing="0" >
		<tr>
			<td class="header" width="253" height="98" background="<?=setting('layout')?>images/top_left.gif">

		  	<table width="100%" cellpadding="0" cellspacing="0" border="0">
			<tr>
			<td height=31 width=251 valign=middle align="center">&nbsp;
				
			</td>
			</tr>
			</table>

			</td>
			<td class="logo" background="<?=setting('layout')?>images/top_bg.gif"><img src="<?=setting('urlfiles')?><?=setting('SiteLogo')?>" border="0"/></td>
			<td class="header2" width="253" background="<?=setting('layout')?>images/top_right.gif">
			<table width="1" cellpadding="0" cellspacing="2" border="0">
				<tr>
              <td><a href="<?=setting('url')?>myhome/"><img src="<?=setting('layout')?>images/icons/ioiconprofile.gif" border=0 width=30 height=30 alt=""></a></td> 
              <td><a href="<?=setting('url')?>currency/"><img src="<?=setting('layout')?>images/icons/ioiconcurrency.gif" border=0 width=30 height=30 alt=""></a></td> 
              <td><a href="<?=setting('url')?>language/"><img src="<?=setting('layout')?>images/icons/ioiconflags.gif" border=0 width=30 height=30 alt=""></a></td> 
              <td><a href="<?=setting('url')?>home/"><img src="<?=setting('layout')?>images/icons/ioiconhome1a1a1.gif" border=0 width=30 height=30 alt="Home"></a></td> 
              <td><a href="<?=setting('url')?>contact/"><img src="<?=setting('layout')?>images/icons/ioiconmail1a1a1.gif" border=0 width=30 height=30 alt="Send a Mail"></a></td> 
              <td><a href="<?=setting('url')?>logout/"><img src="<?=setting('layout')?>images/icons/ioiconlogout1a1a1.gif" border=0 width=30 height=30 alt="Logout"></a></td> 
				</tr>
			</table>
			</td>
		</tr>
		</table>
		
			</td>
		</tr>
      <tr valign=top> 
        <td colspan=3></td> 
        <td height=4></td> 
      </tr>  
		<tr>
			<td>{SystemMessages}</td>
		</tr>		  
    </table>
 
    <table border=0 cellspacing=0 cellpadding=0 width=773> 
      <tr valign=top> 
        <td colspan="3" height="5"></td> 
      </tr> 
      <tr valign=top>   
        <td>
			<?=getBoxes('left')?>	
	    </td> 
        <td>
		</td> 
        <td width="570" >
			<?=getBoxes('center')?>
		</td>   
      </tr> 
      <tr> 
        <td width=200><img src="<?=setting('layout')?>images/_clear.gif" border=0 width=200 height=1 alt=""></td> 
        <td width=6><img src="<?=setting('layout')?>images/_clear.gif" border=0 width=6 height=1 alt=""></td> 
        <td width=570><img src="<?=setting('layout')?>images/_clear.gif" border=0 width=570 height=1 alt=""></td> 
      </tr> 
    </table> 
    <table border=0 cellspacing=0 cellpadding=0 width=773> 
      <tr valign=top>   
        <td height="5" align="center">&nbsp;</td> 
      </tr> 	
      <tr valign=top>   
        <td height="5" align="center">
			<?=setting('copyright')?>
	    </td> 
      </tr> 
    </table> 	
</div> 
</body>
</html>

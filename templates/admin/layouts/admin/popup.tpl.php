<? getBox('core.frontAdminController'); ?>
<?=getBoxes('system')?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html><head>
<title><?=setting('PageTitle')?> <?=setting('SiteName')?></title>
<link href="<?=setting('layout')?>css/main.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<script language="JavaScript1.2">popupDefaultHeight = <?=setting('popupheight')?>;popupDefaultWith = <?=setting('popupwith')?>;</script>
<script language="JavaScript1.2" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/en/mainscript.js"></script>
<script language="JavaScript" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/en/calendar/calendar.js"></script>
<script language="javascript" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/en/validator/validator.js"></script>
<script language="JavaScript" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/menu/JSCookMenu.js"></script>
<script language="JavaScript"> rooturl='<?=setting('rooturl')?>';</script>
<link href="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/menu/ThemeOffice/theme.css" rel="stylesheet" type="text/css">
<script language="JavaScript" src="<?=setting('rooturl')?>templates/<?=setting('ClientType')?>/js/menu/ThemeOffice/theme.js"></script>
</head>
<body> 
  <tr>
    <td background="<?=setting('layout')?>images/grd.gif"><img src="<?=setting('layout')?>images/grd.gif" width="1" height="1"></td>
  </tr>
	{SystemMessages}
  <tr>
    <td align="left" valign="top" class="center">
		 <?=getBoxes('center')?>
	</td>
  </tr>
  <tr>
    <td background="<?=setting('layout')?>images/bg-line.gif"><img src="<?=setting('layout')?>images/bg-line.gif" width="1" height="2"></td>
  </tr>
  <tr>
  	<td align="center">
		<table border="0" width="100%">
		    <tr>
		        <td align="center">
		            <!--<a href="javascript://" onClick="window.close()" class="subtitle"><?=lang('-closewindow')?></a>-->
		            <input type="button" value="<?=lang('-closewindow')?>" onClick="window.close()" class="subtitle">
		        </td>
		    </tr>
		</table>
	</td>
  </tr>
  <tr>
    <td background="<?=setting('layout')?>images/bg-line.gif"><img src="<?=setting('layout')?>images/bg-line.gif" width="1" height="2"></td>
  </tr>
</table>	 
</body>
</html>

<?=getBoxes('system')?>
<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN">
<html>
<head>
<title><?=setting('PageTitle')?> <?=setting('SiteName')?></title>
<link href="<?=setting('layout')?>css/print/main.css" rel="stylesheet" type="text/css">
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
</head>
<body marginheight="0" marginwidth="0" onLoad="window.print()">
<table width="600"  border="0" cellspacing="0" cellpadding="5">
  <tr>
    <td align="left" valign="top">
		<?=getBoxes('center')?>		
	</td>
  </tr>
</table>
</body>
</html>
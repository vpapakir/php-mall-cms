<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
    "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="<?=$HTTP_GET_VARS['lang']?>" lang="<?=$HTTP_GET_VARS['lang']?>" dir="<?=$HTTP_GET_VARS['lang']?>">

<head>
<title>Calendar</title>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<?php
if (!empty($GLOBALS['cfg']['PmaAbsoluteUri'])) {
    echo '<base href="' . $GLOBALS['cfg']['PmaAbsoluteUri'] . '" />' . "\n";
}

$month = array('01'=>'Jan','02'=>'Feb','03'=>'Mar','04'=>'Apr','05'=>'May','06'=>'Jun','07'=>'Jul','08'=>'Aug','09'=>'Sep','10'=>'Oct','11'=>'Nov','12'=>'Dec');
$day_of_week = array(0=>'Sun',1=>'Mon',2=>'Tue',3=>'Wed',4=>'Thu',5=>'Fri',6=>'Sat');
?>
<link rel="stylesheet" type="text/css" href="calendar.css" />
<noscript>
    <link rel="stylesheet" type="text/css" href="calendar.css" />
</noscript>
<script type="text/javascript" src="calendar.js"></script>
<script type="text/javascript">
<!--
var month_names = new Array("<?php echo implode('","', $month); ?>");
var day_names = new Array("<?php echo implode('","', $day_of_week); ?>");
//-->
</script>
</head>
<body onload="initCalendar();">
<div id="calendar_data"></div>
<div id="clock_data"></div>
</body>
</html>

<?php
#available char
$captchadinx_allowchar = '34579acdefghijkmnpqrstuvwxyzACDEFGHJKLMNPQRTUVWXY';
#max captcha length
$captchadinx_length = 15;
#max code length
$capchadinx_colorlength = 5;

$captchadinx_randomstr = "aaa";

#random bgcolor
$captchadinx_bgcolor = array(0 => '#000000', 1 => '#FFFFFF', 2 => '#CFCFCF', 3 => 'black', 4 => 'white', 5 => 'lightgrey');
$captchadinx_bgcolor_length = count($captchadinx_bgcolor) - 1;
$captchadinx_selectedbgcolor = $captchadinx_bgcolor[rand(0, $captchadinx_bgcolor_length)];

#random color
$captchadinx_color = array(0 => '#CC0099', 1 => '#CC6633', 2 => 'magenta', 3 => '#33CC66', 4 => '#0066FF');
$captchadinx_color_length = count($captchadinx_color) - 1;
$captchadinx_selectedcolor = $captchadinx_color[rand(0, $captchadinx_color_length)];

#random size
$captchadinx_size = array(0 => '16px', 1 => '18px', 2 => '20px');
$captchadinx_size_length = count($captchadinx_size) - 1;
$captchadinx_selectedsize = $captchadinx_size[rand(0, $captchadinx_size_length)];

$captchadinx_arraychar = null;
$captchadinx_randomstr = null;
$captchadinx_charcode = null;
$captchadinx_bok_continue = true;

$captchadinx_allowchar_length = strlen($captchadinx_allowchar);
for($cap = 1; $cap < $captchadinx_length; $cap++)
{
    $captchadinx_randomstr .= $captchadinx_allowchar[rand(0, $captchadinx_allowchar_length)];
}
$q = 0;

$temp_captchadinx_randomstr = $captchadinx_randomstr;

for($cap = 1; $cap < $captchadinx_length; $cap++)
{
    if(1 == rand(0, 1))
    {
        if($q < $capchadinx_colorlength)
        {
            $temp_captchadinx_codestr = $captchadinx_randomstr[$cap];
            if($q == 0)
            {
                $captchadinx_charcode .= $temp_captchadinx_codestr;
            }
            else
            {
                $captchadinx_charcode .= '$'.$temp_captchadinx_codestr;
            }
            $q++;
        }
        else
        {
            $cap = $captchadinx_length + 2;
        }
    }
}
$_SESSION['current_captcha_code'] = str_replace('$', '', $captchadinx_charcode);
$captchadinx_array_charcode = split_string($captchadinx_charcode, '$');
$captchadinx_randomstr =  null;
$captchadinx_bok_insertcoloredchar = false;

$l = 0;
for($u = 0, $countu = count($captchadinx_array_charcode); $u < $countu; $u++)
{
    if(!empty($captchadinx_array_charcode[$u]))
    {
        $temp_captchadinx_array_charcode[$l] = $captchadinx_array_charcode[$u];
        $l++;
    }
}
$captchadinx_array_charcode = $temp_captchadinx_array_charcode;

$l = 0;
$captchadinx_randomstr = "";
for($cap = 0; $cap < $captchadinx_length; $cap++)
{  
    if($l < count($captchadinx_array_charcode))
    {        
        if($temp_captchadinx_randomstr[$cap] == $captchadinx_array_charcode[$l])
        {
            $captchadinx_bok_insertcoloredchar = true;
            $p = $countp;
            $l++;
        }
        else
        {
            $captchadinx_bok_insertcoloredchar = false;
        }

    }
    else
    {
        $captchadinx_bok_insertcoloredchar = false;
    }
    
    if($captchadinx_bok_insertcoloredchar === false)
    {
        switch($captchadinx_selectedbgcolor)
        {
            case '#FFFFFF':
                $capchadinx_charbasiccolor = '#CFCFCF';
                break;
            case '#000000':
                $capchadinx_charbasiccolor = '#FFFFFF';
                break;
            case '#CFCFCF':
                $capchadinx_charbasiccolor = '#000000';
                break; 
            case 'white':
                $capchadinx_charbasiccolor = '#CFCFCF';
                break;
            case 'black':
                $capchadinx_charbasiccolor = '#FFFFFF';
                break;
            case 'lightgrey':
                $capchadinx_charbasiccolor = '#000000';
                break;
        }
        $captchadinx_randomstr .= '<span style="font-size: './*$captchadinx_size[rand(0, $captchadinx_size_length)].*/'; color: './*$capchadinx_charbasiccolor.*/';">'.$temp_captchadinx_randomstr[$cap].'</span>';
    }
    else
    {
        $captchadinx_randomstr .= '<span style="font-size: '.$captchadinx_size[rand(0, $captchadinx_size_length)].'; color: '.$captchadinx_color[rand(0, $captchadinx_color_length)].';">'.$temp_captchadinx_randomstr[$cap].'</span>'; 
    }   
}

echo('<div style="border: 1px solid lightgray; padding: 4px; background-color: '.$captchadinx_selectedbgcolor.';">');
echo($captchadinx_randomstr);
echo('</div>');
?>

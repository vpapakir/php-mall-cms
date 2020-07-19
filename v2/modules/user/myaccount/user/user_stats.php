<tr>
    <td><table class="block_main2" width="100%" style="margin-bottom: 4px;">
<?php
    if($myaccount_user_lastlog != '30-11-1999 - 00:00')
    {
        $myaccount_user_lastlog = converto_timestamp($myaccount_user_lastlog);
        $myaccount_user_lastlog = date('d-m-Y - H:i', $myaccount_user_lastlog);
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('myaccount.subtitle_lastlog', $echo, $config_showtranslationcode); ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_lastlog);
?>
                </span>
            </td>
        </tr>
<?php
    }
    
        $myaccount_user_subscriptiondate = converto_timestamp($myaccount_user_subscriptiondate);
        $myaccount_user_subscriptiondate = date('d-m-Y - H:i', $myaccount_user_subscriptiondate);
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('myaccount.subtitle_subscriptiondate', $echo, $config_showtranslationcode); ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_subscriptiondate);
?>
                </span>
            </td>
        </tr>
    </table></td>
</tr>

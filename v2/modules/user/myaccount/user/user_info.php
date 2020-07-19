<tr>
    <td align="left"><table class="" width="100%" cellpadding="0" cellspacing="0">  
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_typeuser', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                give_translation('subscription.typeuser_'.$myaccount_user_type, $echo, $config_showtranslationcode);
?>
                </span>
            </td>
        </tr>    
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_title', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo(giveCDRvalue($myaccount_user_title, 'cdreditor', $main_id_language));
?>
                </span>
            </td>
        </tr>
<?php
#firstname & lastname
if(!empty($myaccount_user_firstname) || !empty($myaccount_user_lastname))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_firstname', $echo, $config_showtranslationcode); echo('/'); give_translation('subscription.subtitle_lastname', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left">
                <span class="font_main">
<?php
                if(!empty($myaccount_user_firstname))
                {
                    echo($myaccount_user_firstname.' ');
                }

                echo($myaccount_user_lastname);
?>
                </span>
            </td>
        </tr>
<?php
}

#birthday
if(!empty($myaccount_user_birthday))
{
    $myaccount_user_birthday = converto_timestamp($myaccount_user_birthday);
    $myaccount_user_birthday = date('d-m-Y', $myaccount_user_birthday);
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_birthday', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_birthday);
?>
                </span>
            </td>
        </tr>
<?php
}
        
#company name
if(!empty($myaccount_user_companyname))
{
?>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div></div></td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_namecompany', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                if(!empty($myaccount_user_companytype))
                {
                    echo(giveCDRvalue($myaccount_user_companytype, 'cdreditor', $main_id_language).' ');
                }
                
                echo($myaccount_user_companyname);
?>
                </span>
            </td>
        </tr>
<?php
}

#company activity
if(!empty($myaccount_user_companyactivity))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_activitycompany', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo(giveCDRvalue($myaccount_user_companyactivity, 'cdreditor', $main_id_language));
?>
                </span>
            </td>
        </tr>
<?php
}

#company function
if(!empty($myaccount_user_companyfunction))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_functioncompany', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo(giveCDRvalue($myaccount_user_companyfunction, 'cdreditor', $main_id_language));
?>
                </span>
            </td>
        </tr>
<?php
}

#company siret
if(!empty($myaccount_user_companysiret))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_siretcompany', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_companysiret);
?>
                </span>
            </td>
        </tr>
<?php
}

#company vat intra
if(!empty($myaccount_user_companyvatintra))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_vatintracompany', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_companyvatintra);
?>
                </span>
            </td>
        </tr>
<?php
}

#website
if(!empty($myaccount_user_website))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_website', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_website);
?>
                </span>
            </td>
        </tr>
<?php
}
?>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div></div></td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>
<?php
#address1
if(!empty($myaccount_user_address1))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_address1', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_address1);
?>
                </span>
            </td>
        </tr>
<?php
}

#address2
if(!empty($myaccount_user_address2))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_address1', $echo, $config_showtranslationcode) ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_address2);
?>
                </span>
            </td>
        </tr>
<?php
}

#zip/city
if(!empty($myaccount_user_zip) || !empty($myaccount_user_city))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_zip', $echo, $config_showtranslationcode); echo(' - '); give_translation('subscription.subtitle_city', $echo, $config_showtranslationcode); ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                if(!empty($myaccount_user_zip))
                {
                    echo($myaccount_user_zip.' ');
                }
                echo($myaccount_user_city);
?>
                </span>
            </td>
        </tr>
<?php
}

#country
if(!empty($myaccount_user_country))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_country', $echo, $config_showtranslationcode); ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo(giveCDRvalue($myaccount_user_country, 'cdrgeo', $main_id_language));
?>
                </span>
            </td>
        </tr>
<?php
}
?>       
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div></div></td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>
<?php
#landline
if(!empty($myaccount_user_landline))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_landline', $echo, $config_showtranslationcode); ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_landline);
?>
                </span>
            </td>
        </tr>
<?php
}
#mobile
if(!empty($myaccount_user_mobile))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_mobile', $echo, $config_showtranslationcode); ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_mobile);
?>
                </span>
            </td>
        </tr>
<?php
}
#fax
if(!empty($myaccount_user_fax))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_fax', $echo, $config_showtranslationcode); ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_fax);
?>
                </span>
            </td>
        </tr>
<?php
}
?> 
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px dashed lightgrey;"><div></div></td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>
<?php
#pseudo
if(!empty($myaccount_user_nickname))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_nickname', $echo, $config_showtranslationcode); ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_nickname);
?>
                </span>
            </td>
        </tr>
<?php
}

#email
if(!empty($myaccount_user_email))
{
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_email', $echo, $config_showtranslationcode); ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                echo($myaccount_user_email);
?>
                </span>
            </td>
        </tr>
<?php
}
?>
        <tr>
            <td align="left" class="font_subtitle">
                <?php give_translation('subscription.subtitle_language', $echo, $config_showtranslationcode); ?>
            </td>
            <td align="left" width="<?php echo($right_column_width); ?>">
                <span class="font_main">
<?php
                try
                {
                    $prepared_query = 'SELECT L'.$main_id_language.' FROM language
                                       INNER JOIN translation
                                       ON translation.code_translation = language.code_language
                                       WHERE id_language = :idlanguage';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('idlanguage', $myaccount_user_language);
                    $query->execute();
                    if(($data = $query->fetch()) != false)
                    {
                        echo($data[0]);
                    }
                    $query->closeCursor();
                }
                catch(Exception $e)
                {
                    $_SESSION['error400_message'] = $e->getMessage();
                    if($_SESSION['index'] == 'index.php')
                    {
                        die(header('Location: '.$config_customheader.'Error/400'));
                    }
                    else
                    {
                        die(header('Location: '.$config_customheader.'Backoffice/Error/400'));
                    }
                }
?>
                </span>
            </td>
        </tr>
    </table></td>
</tr>

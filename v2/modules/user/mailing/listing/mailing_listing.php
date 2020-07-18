<tr>
<td align="left"><table class="block_expandmain1" width="100%" border="0" style="margin-bottom: 4px;">
    <tr>
        <td align="left">
            <table id="collapseMailingListing"
<?php
                if(empty($_SESSION['expand_mailing_listing']) || $_SESSION['expand_mailing_listing'] == 'false')
                {
                    echo('class="block_collapsetitle1"');
                }
                else
                {
                    echo('class="block_expandtitle1"');
                }
?>
                 width="100%" cellpadding="0" cellspacing="0" onclick="expand_collapse_tab('block_expand_collapseMailingListing', 'img_expand_collapseMailingListing', 'expand_mailing_listing', '<?php echo($config_customheader.'graphics/icons/expand/plus16x16.gif'); ?>', '<?php echo($config_customheader.'graphics/icons/expand/minus16x16.gif'); ?>', '+', '-', 'Afficher', 'Cacher', 'block_collapsetitle1','block_expandtitle1', 'collapseMailingListing');" style="cursor: pointer;">
                <td align="left">                    
<?php
                        if(empty($_SESSION['expand_mailing_listing']) || $_SESSION['expand_mailing_listing'] == 'false')
                        {
?>
                            <img id="img_expand_collapseMailingListing" src="<?php echo($config_customheader); ?>graphics/icons/expand/plus16x16.gif" alt="+" title="Afficher"/>
<?php                        
                        }
                        else
                        {
?>
                            <img id="img_expand_collapseMailingListing" src="<?php echo($config_customheader); ?>graphics/icons/expand/minus16x16.gif" alt="-" title="Cacher"/>
<?php
                        }
?>                    
                </td>
                <td width="100%" align="left">
                    <span style="margin-left: 4px;">
                        <?php echo($usermailing_blocktitle_listing); ?>
                    </span>
                </td>
                <td align="left"></td>
            </table>
            <input id="expand_mailing_listing" style="display: none;" type="hidden" name="expand_mailing_listing" value="<?php if(empty($_SESSION['expand_mailing_listing']) || $_SESSION['expand_mailing_listing'] == 'false'){ echo('false'); }else{ echo('true'); } ?>" />
        </td>
    </tr>
    <tr id="block_expand_collapseMailingListing"
<?php
        if(empty($_SESSION['expand_mailing_listing']) || $_SESSION['expand_mailing_listing'] == 'false')
        {
            echo('style="display: none;"');
        }
        else
        {
            echo(null);
        }
?>
        >
        <td><table width="100%">
<tr>
                <td align="left">
                    <table width="100%" cellpadding="0" cellspacing="1" border="0">
                        <tr>  
                            <td align="center" class="block_main2" style="width: 29%;">
                                <div class="font_subtitle" style="text-align: center;"><?php give_translation('user_edit.listing_title_nameorcompany', '', $config_showtranslationcode); ?></div>
                            </td>
                            <td align="center" class="block_main2" style="width: 10%;">
                                <div class="font_subtitle" style="text-align: center;"><?php give_translation('user_edit.listing_title_zip', '', $config_showtranslationcode); ?></div>
                            </td>
                            <td align="center" class="block_main2" style="width: 20%;">
                                <div class="font_subtitle" style="text-align: center;"><?php give_translation('user_edit.listing_title_city', '', $config_showtranslationcode); ?></div>
                            </td>
                            <td align="center" class="block_main2" style="width: 20%;">
                                <div class="font_subtitle" style="text-align: center;"><?php give_translation('user_edit.listing_title_country', '', $config_showtranslationcode); ?></div>
                            </td>
                            <td align="center" class="block_main2" style="width: 15%;">
                                <div class="font_subtitle" style="text-align: center;"><?php give_translation('user_edit.listing_title_rights', '', $config_showtranslationcode); ?></div>
                            </td>
                            <td align="center" class="block_main2" style="width: 6%;" title="<?php give_translation('user_edit.listing_title_status', '', $config_showtranslationcode); ?>">
                                <input id="chk_mailing_listingall" type="checkbox" name="chk_mailing_all" value="1" <?php if(empty($_SESSION['mailing_chkall'])){ echo('checked="checked"'); } ?> onclick="check_all('chk_mailing_listingall', 'input', 'chk_mailing_listing');"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
<?php
            unset($usermailing_listing_status_srcimage,$usermailing_listing_status_altimage,
                    $usermailing_listing_name,$usermailing_listing_legend_name,
                    $usermailing_listing_country,$usermailing_listing_rights,
                    $usermailing_listing_legend_address,$usermailing_listing_linktomodification,
                    $usermailing_listing_temp_iduser);
            try
            {
                $usermailing_bok_listingstyle = false;

                for($i = 0, $count = count($usermailing_listing_iduser); $i < $count; $i++)
                {
                    $usermailing_listing_temp_iduser = split_string($usermailing_listing_iduser[$i], '$');
                    
                    $prepared_query = 'SELECT * FROM user
                                       INNER JOIN user_rights
                                       ON user_rights.level_rights = user.rights_user
                                       WHERE id_user = :iduser';
                    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                    $query = $connectData->prepare($prepared_query);
                    $query->bindParam('iduser', $usermailing_listing_temp_iduser[3]);
                    $query->execute();
                    if(($data = $query->fetch()) != false)
                    {
                        if($usermailing_bok_listingstyle === true)
                        {
                            $usermailing_listingbgcolor = 'lightgrey'; 
                            $usermailing_bok_listingstyle = false;
                        }
                        else
                        {
                            $usermailing_listingbgcolor = 'white'; 
                            $usermailing_bok_listingstyle = true;
                        }

                        switch ($data['status_user'])
                        {
                            case 1:
                                $usermailing_listing_status_srcimage = 'graphics/icons/status_online/circle_green12x12.gif';
                                $usermailing_listing_status_altimage = give_translation('main.user_status_active', 'false', $config_showtranslationcode);
                                break;
                            case 2:
                                $usermailing_listing_status_srcimage = 'graphics/icons/status_online/circle_orange12x12.gif';
                                $usermailing_listing_status_altimage = give_translation('main.user_status_onhold', 'false', $config_showtranslationcode);
                                break;
                            case 9:
                                $usermailing_listing_status_srcimage = 'graphics/icons/status_online/circle_red12x12.gif';
                                $usermailing_listing_status_altimage = give_translation('main.user_status_blocked', 'false', $config_showtranslationcode);
                                break;
                        }

                        if(!empty($data['namecompany_user']))
                        {
                            $usermailing_listing_name = $data['namecompany_user'];
                            $usermailing_listing_legend_name = $data['namecompany_user'].' - '.$data['firstname_user'].' '.$data['name_user']."\n".$data['email_user'];
                        }
                        else
                        {
                            $usermailing_listing_name = $data['name_user'].' '.substr($data['firstname_user'], 0, 1).'.';
                            $usermailing_listing_legend_name = $data['firstname_user'].' '.$data['name_user']."\n".$data['email_user'];
                        }

                        $usermailing_listing_country = giveCDRvalue($data['country_user'], 'cdrgeo', $main_id_language);
                        $usermailing_listing_rights = give_translation('main.'.$data['name_rights'], 'false', $config_showtranslationcode);

                        if(!empty($data['address2_user']))
                        {
                            $usermailing_listing_legend_address = $data['address1_user']."\n".$data['address2_user']."\n".$data['zip_user'].' '.$data['city_user']."\n".$usermailing_listing_country;
                        }
                        else
                        {
                            $usermailing_listing_legend_address = $data['address1_user']."\n".$data['zip_user'].' '.$data['city_user']."\n".$usermailing_listing_country;
                        }

                        if((checkrights($main_rights_log, '-1,1,2,3,4,5,6,7,8', $redirection, true)) === true && $data['rights_user'] == 9)
                        {
                            $usermailing_listing_linktomodification = false;
                        }
                        else
                        {
                            $usermailing_listing_linktomodification = true;
                        }
    ?>
                        <tr>
                            <td align="left" style="background-color: <?php echo($usermailing_listingbgcolor); ?>;" onmouseover="this.style.backgroundColor = 'lightblue';" onmouseout="this.style.backgroundColor = '<?php echo($usermailing_listingbgcolor); ?>';">
                                <table width="100%" cellpadding="0" cellspacing="1" border="0">
                                    <tr>
                                        <td align="left" width="29%" title="<?php echo($usermailing_listing_legend_name); ?>">
                                            <table width="100%" cellpadding="0" cellspacing="0">
                                                <td align="left">
                                                    <img src="<?php echo($config_customheader.$usermailing_listing_status_srcimage); ?>" alt="<?php echo($usermailing_listing_status_altimage); ?>" title="<?php echo($usermailing_listing_status_altimage); ?>"/>
                                                </td>
                                                <td align="left" width="100%">
    <?php
                                            if($usermailing_listing_linktomodification === true)
                                            {
    ?>
                                                <a href="<?php echo($config_customheader.'edition/user/'.urlencode($data[0])); ?>" class="link_main">
    <?php
                                            }
    ?>           
                                                    <span style="margin-left: 4px;">
                                                        <?php echo(cut_string($usermailing_listing_name, 0, 20, '...')); ?>
                                                    </span>
    <?php
                                            if($usermailing_listing_linktomodification === true)
                                            {
    ?>
                                                </a>
    <?php
                                            }
    ?>
                                                </td>
                                            </table>
                                        </td>
                                        <td align="left" width="10%">
                                            <span class="font_main" style="margin-left: 4px;" title="<?php echo($usermailing_listing_legend_address); ?>">
                                                <?php echo(cut_string($data['zip_user'], 0, 6, '...')); ?>
                                            </span>
                                        </td>
                                        <td align="left" width="20%" title="<?php echo($usermailing_listing_legend_address); ?>">
                                            <span class="font_main" style="margin-left: 4px;">
                                                <?php echo(cut_string($data['city_user'], 0, 15, '...', true)); ?>
                                            </span> 
                                        </td>
                                        <td align="left" width="20%">
                                            <span class="font_main" style="margin-left: 4px;" title="<?php echo($usermailing_listing_legend_address); ?>">
                                                <?php echo(cut_string($usermailing_listing_country, 0, 15, '...', true)); ?>
                                            </span> 
                                        </td>
                                        <td align="left" width="15%">
                                            <span class="font_main" style="margin-left: 4px;" title="<?php echo($usermailing_listing_rights); ?>">
                                                <?php echo(cut_string($usermailing_listing_rights, 0, 8, '...', true)); ?>
                                            </span> 
                                        </td>
                                        <td align="center" width="6%">
                                            <input class="chk_mailing_listing" type="checkbox" name="chk_mailing<?php echo($data[0]); ?>" <?php if(empty($_SESSION['usermailing_chk'.$data[0]])){ if(!empty($_SESSION['useredit_chk'.$data[0]]) && $_SESSION['useredit_chk'.$data[0]] == 1){ echo('checked="checked"'); } }else{ if($_SESSION['usermailing_chk'.$data[0]] == 1){ echo('checked="checked"'); } } ?> value="1"/>                                                 
                                        </td>
                                    </tr>
                                </table>
                            </td>
                        </tr>
    <?php
                        unset($usermailing_listing_status_srcimage,$usermailing_listing_status_altimage,
                                $usermailing_listing_name,$usermailing_listing_legend_name,
                                $usermailing_listing_country,$usermailing_listing_rights,
                                $usermailing_listing_legend_address,$usermailing_listing_linktomodification,
                                $usermailing_listing_temp_iduser);
                    }
                    $query->closeCursor();
                }
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
        </table></td>
    </tr>
</table></td>
</tr>

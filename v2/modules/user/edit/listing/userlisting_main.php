<tr>
    <td align="left">
        <table class="block_main2" width="100%">
            <tr>
                <td align="left">
                    <table class="block_expandtitle1" width="100%" cellpadding="0" cellspacing="0">
                        <tr>
                            <td align="center">
                                <?php echo($useredit_listing_blocktitle); ?>
                            </td>
                        </tr>
                    </table>                   
                </td>
            </tr>
<?php
            if($paging_resultperpage < $useredit_totaluser)
            {
?>
                <tr>
                    <td align="center">
                        <table width="100%" cellpadding="0" cellspacing="0">
<?php
                            $paging_urlscript = $url_page;
                            $paging_anchor_id = '#UserEditSearchPaging';
                            include('modules/search/paging/paging_display.php');
?>
                        </table>
                    </td>
                </tr>
<?php
            }
?>
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
                                <input id="chk_useredit_listingall" type="checkbox" name="chk_useredit_all" value="1" <?php if(!empty($_SESSION['useredit_chkall']) && $_SESSION['useredit_chkall'] == 1){ echo('checked="checked"'); } ?> onclick="check_all('chk_useredit_listingall', 'input', 'chk_useredit_listing'); OnChange('bt_checkedall_useredit');"/>
                                <input id="bt_checkedall_useredit" style="display: none;" hidden="hidden" name="bt_checkedall_useredit" value="checked" type="submit"/>
                                <input id="bt_checked_useredit" style="display: none;" hidden="hidden" name="bt_checked_useredit" type="submit" value="checked"/>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
<?php
                        unset($useredit_listing_status_srcimage,$useredit_listing_status_altimage,
                                $useredit_listing_name,$useredit_listing_legend_name,
                                $useredit_listing_country,$useredit_listing_rights,
                                $useredit_listing_legend_address,$useredit_listing_linktomodification);
                        try
                        {
                            $useredit_bok_listingstyle = false;
                            
                            $prepared_query = $useredit_preparedquery;
                            if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
                            $query = $connectData->prepare($prepared_query);
                            $query->execute();
                            while($data = $query->fetch())
                            {
                                if($useredit_bok_listingstyle === true)
                                {
                                    $useredit_listingbgcolor = 'lightgrey'; 
                                    $useredit_bok_listingstyle = false;
                                }
                                else
                                {
                                    $useredit_listingbgcolor = 'white'; 
                                    $useredit_bok_listingstyle = true;
                                }
                                
                                switch ($data['status_user'])
                                {
                                    case 1:
                                        $useredit_listing_status_srcimage = 'graphics/icons/status_online/circle_green12x12.gif';
                                        $useredit_listing_status_altimage = give_translation('main.user_status_active', 'false', $config_showtranslationcode);
                                        break;
                                    case 2:
                                        $useredit_listing_status_srcimage = 'graphics/icons/status_online/circle_orange12x12.gif';
                                        $useredit_listing_status_altimage = give_translation('main.user_status_onhold', 'false', $config_showtranslationcode);
                                        break;
                                    case 9:
                                        $useredit_listing_status_srcimage = 'graphics/icons/status_online/circle_red12x12.gif';
                                        $useredit_listing_status_altimage = give_translation('main.user_status_blocked', 'false', $config_showtranslationcode);
                                        break;
                                }
                                
                                if(!empty($data['namecompany_user']))
                                {
                                    $useredit_listing_name = $data['namecompany_user'];
                                    $useredit_listing_legend_name = $data['namecompany_user'].' - '.$data['firstname_user'].' '.$data['name_user']."\n".$data['email_user'];
                                }
                                else
                                {
                                    $useredit_listing_name = $data['name_user'].' '.substr($data['firstname_user'], 0, 1).'.';
                                    $useredit_listing_legend_name = $data['firstname_user'].' '.$data['name_user']."\n".$data['email_user'];
                                }
                                
                                $useredit_listing_country = giveCDRvalue($data['country_user'], 'cdrgeo', $main_id_language);
                                $useredit_listing_rights = give_translation('main.'.$data['name_rights'], 'false', $config_showtranslationcode);
                                
                                if(!empty($data['address2_user']))
                                {
                                    $useredit_listing_legend_address = $data['address1_user']."\n".$data['address2_user']."\n".$data['zip_user'].' '.$data['city_user']."\n".$useredit_listing_country;
                                }
                                else
                                {
                                    $useredit_listing_legend_address = $data['address1_user']."\n".$data['zip_user'].' '.$data['city_user']."\n".$useredit_listing_country;
                                }
                                
                                if((checkrights($main_rights_log, '-1,1,2,3,4,5,6,7,8', $redirection, true)) === true && $data['rights_user'] == 9)
                                {
                                    $useredit_listing_linktomodification = false;
                                }
                                else
                                {
                                    $useredit_listing_linktomodification = true;
                                }
?>
                                <tr>
                                    <td align="left" style="background-color: <?php echo($useredit_listingbgcolor); ?>;" onmouseover="this.style.backgroundColor = 'lightblue';" onmouseout="this.style.backgroundColor = '<?php echo($useredit_listingbgcolor); ?>';">
                                        <table width="100%" cellpadding="0" cellspacing="1" border="0">
                                            <tr>
                                                <td align="left" width="29%" title="<?php echo($useredit_listing_legend_name); ?>">
                                                    <table width="100%" cellpadding="0" cellspacing="0">
                                                        <td align="left">
                                                            <img src="<?php echo($config_customheader.$useredit_listing_status_srcimage); ?>" alt="<?php echo($useredit_listing_status_altimage); ?>" title="<?php echo($useredit_listing_status_altimage); ?>"/>
                                                        </td>
                                                        <td align="left" width="100%">
<?php
                                                    if($useredit_listing_linktomodification === true)
                                                    {
?>
                                                        <a href="<?php echo($config_customheader.'edition/user/'.urlencode($data[0])); ?>" class="link_main">
<?php
                                                    }
?>           
                                                            <span style="margin-left: 4px;">
                                                                <?php echo(cut_string($useredit_listing_name, 0, 20, '...')); ?>
                                                            </span>
<?php
                                                    if($useredit_listing_linktomodification === true)
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
                                                    <span class="font_main" style="margin-left: 4px;" title="<?php echo($useredit_listing_legend_address); ?>">
                                                        <?php echo(cut_string($data['zip_user'], 0, 6, '...')); ?>
                                                    </span>
                                                </td>
                                                <td align="left" width="20%" title="<?php echo($useredit_listing_legend_address); ?>">
                                                    <span class="font_main" style="margin-left: 4px;">
                                                        <?php echo(cut_string($data['city_user'], 0, 15, '...', true)); ?>
                                                    </span> 
                                                </td>
                                                <td align="left" width="20%">
                                                    <span class="font_main" style="margin-left: 4px;" title="<?php echo($useredit_listing_legend_address); ?>">
                                                        <?php echo(cut_string($useredit_listing_country, 0, 15, '...', true)); ?>
                                                    </span> 
                                                </td>
                                                <td align="left" width="15%">
                                                    <span class="font_main" style="margin-left: 4px;" title="<?php echo($useredit_listing_rights); ?>">
                                                        <?php echo(cut_string($useredit_listing_rights, 0, 8, '...', true)); ?>
                                                    </span> 
                                                </td>
                                                <td align="center" width="6%">
                                                    <input class="chk_useredit_listing" type="checkbox" name="chk_useredit<?php echo($data[0]); ?>" <?php if(empty($_SESSION['usermailing_chk'.$data[0]])){ if(!empty($_SESSION['useredit_chk'.$data[0]]) && $_SESSION['useredit_chk'.$data[0]] == 1){ echo('checked="checked"'); } }else{ if($_SESSION['usermailing_chk'.$data[0]] == 1){ echo('checked="checked"'); } } ?> value="1" onclick="OnChange('bt_checked_useredit');"/>                                                 
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
<?php
                                unset($useredit_listing_status_srcimage,$useredit_listing_status_altimage,
                                        $useredit_listing_name,$useredit_listing_legend_name,
                                        $useredit_listing_country,$useredit_listing_rights,
                                        $useredit_listing_legend_address,$useredit_listing_linktomodification);
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
                        
            if($paging_resultperpage < $useredit_totaluser)
            {
?>
                <tr>
                    <td align="center">
                        <table width="100%" cellpadding="0" cellspacing="0">
<?php
                            $paging_urlscript = $url_page;
                            $paging_anchor_id = '#UserEditSearchPaging';
                            include('modules/search/paging/paging_display.php');
?>
                        </table>
                    </td>
                </tr>
<?php
            }
?>          
            <tr>
                <td colspan="2"><div style="height: 4px;"></div></td>
            </tr>    
            <tr>
                <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
            </tr>
            <tr>
                <td colspan="2"><table width="100%" style="">
                    <tr>        
                        <td align="center">
                            <input type="submit" name="bt_resetlisting_useredit" value="<?php give_translation('main.bt_reset_user', '', $config_showtranslationcode); ?>"/>
                            <input type="submit" name="bt_new_useredit" value="<?php give_translation('main.bt_new_user', '', $config_showtranslationcode); ?>"/>
                            <input type="submit" name="bt_gotomailing_useredit" value="<?php give_translation('main.bt_writeemail_user', '', $config_showtranslationcode); ?>"/>
                        </td>
                    </tr> 
                </table></td>
            </tr>    
                
        </table>
    </td>
</tr>

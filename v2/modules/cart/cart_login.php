<?php
if(!empty($_SESSION['login_id']))
{
    if($_SESSION['login_id'] < 9000000)
    {
        header('Location: '.$header.$_SESSION['index'].'?page=recap_cart');
    }
    else
    {
?>
<td><form method="post"><TABLE width="100%" border="0">
        
        <td align="center" width="50%" style="vertical-align: top;">
<?php
if(isset($_POST['bt_user_login_cart_x']))
{
    // <editor-fold defaultstate="collapsed" desc="allow members to loggin on website">

    $login = htmlspecialchars($_POST['txtLogin'], ENT_QUOTES);
    $pwd = htmlspecialchars($_POST['txtPwd'], ENT_QUOTES);     
    
    unset($_SESSION['user_add_txtPseudo_cart'], $_SESSION['user_add_txtPwd_cart'], $_SESSION['msg_login_bad_cart']);      
    
    $_SESSION['user_add_txtPseudo_cart'] = $login;
    $_SESSION['user_add_txtPwd_cart'] = $pwd;
    
    $BoK_login_cart = false;
    $BoK_emptylogin_cart = false;
    
    
    if(empty($login) || empty($pwd))
    {
        $BoK_emptylogin_cart = true;
    }
    
    if(!empty($pwd))
    {
        $pwd = crypt_pwd($pwd);
    }
    
    
    
    
    
    if($BoK_emptylogin_cart == false)
    {
        try
        {
            $query = $connectData->prepare('SELECT * 
                                            FROM user
                                            INNER JOIN user_rights
                                            ON user_rights.code_rights = user.code_rights
                                            WHERE (pseudo_user = :pseudo 
                                            OR email_user = :email)
                                            AND password_user = :pwd');

            $query->execute(array(
                                  'pseudo' => $login,
                                  'email' => $login,
                                  'pwd' => $pwd
                                  ));
            $give_real_id_cart = true;

            while($data = $query->fetch())
            {
                if($data['code_status'] == 'AC')
                {
                    if($give_real_id_cart == true && $_SESSION['login_id'] > 9000000)
                    {
                       $goto_cart_recap = true;
                       $query = $connectData->prepare('UPDATE cart SET id_user = :new_user WHERE id_user = :old_user');
                       $query->execute(array(
                                             'new_user' => $data['id_user'],
                                             'old_user' => $_SESSION['login_id'],
                                             ));
                       $query->closeCursor();

                       $query = $connectData->prepare('UPDATE online_order SET id_user = :new_user 
                                                       WHERE id_user = :old_user');
                       $query->execute(array(
                                             'new_user' => $data['id_user'],
                                             'old_user' => $_SESSION['login_id'],
                                             ));
                       $query->closeCursor();

                       $give_real_id_cart = false;
                    }


                    $_SESSION['login_id'] = $data['id_user'];
                    $_SESSION['login_pseudo'] = $data['pseudo_user'];           
                    $user_code_type = $data['name_rights'];
                    $user_type = $data['code_rights']; 
                    $BoK_login_cart = true;
                }  

                $user_status_cart = $data['code_status'];                     
            }

        }
        catch (Exception $e)
        {
           die("<br>Error : ".$e->getMessage());
        }
        $query->closeCursor();

        
    }
    
    if(!empty($login) && !empty($pwd))
    {
        if(!empty($user_code_type))
        {
            $_SESSION['login_user_type'] = $user_code_type;

            if($user_type == 'AD' || $user_type == 'SO') #Site owner and Admin are allowed to access in backoffice
            {
                $_SESSION['access_backoffice'] = true;
            }
            else
            {
                unset($_SESSION['access_backoffice']);
            }
        }
        if($BoK_login_cart == false || $BoK_emptylogin_cart == true)
        {
            $_SESSION['connected_user_cart'] = false;
            unset($_SESSION['user_add_txtPseudo_cart'], $_SESSION['user_add_txtPwd_cart']);
            if($user_status_cart == 'AC' || $BoK_emptylogin_cart == true)
            {
                $_SESSION['msg_login_bad_cart'] = 'Identifiant ou mot de passe incorrect';           
            }
            else
            {
                if($user_status_cart == 'OH')
                {
                    $_SESSION['msg_login_bad_cart'] = 'Votre compte est en attente de validation, veuillez consulter votre boîte mail';
                }
                else
                {
                    if($user_status_cart == 'BK')
                    {
                        $_SESSION['msg_login_bad_cart'] = 'Votre compte a été bloqué. <a id="other_link" style="font-size: 10px; text-decoration: underline;" href="index.php?page=general_form_contact&amp;captcha=true">Contacter un administrateur</a>';
                    }
                    else
                    {
                        $_SESSION['msg_login_bad_cart'] = 'Identifiant ou mot de passe incorrect';
                    }
                }
            }






        }
        else
        {

                $_SESSION['connected_user_cart'] = true;

                //$_SESSION['user_login_refresh'] = 'true';

                if($goto_cart_recap == true)
                {      
                    header('Location: '.$header.$_SESSION['index'].'?page=recap_cart');
                }



                try
                {           
                    $query = $connectData->prepare('UPDATE user SET online_user = 1,
                                                    current_log_user = NOW()
                                                    WHERE id_user = :id');

                    $query->execute(array(
                                          'id' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES)
                                          )); 
                }
                catch (Exception $e)
                {
                   die("<br>Error : ".$e->getMessage());
                }
                $query->closeCursor();
        }
    }
    else
    {
        $_SESSION['connected_user_cart'] = false;
        unset($_SESSION['user_add_txtPseudo_cart'], $_SESSION['user_add_txtPwd_cart']);
        $_SESSION['msg_login_bad_cart'] = 'Identifiant ou mot de passe incorrect';           
    }
    
    // </editor-fold>
}

if(empty($_SESSION['connected_user_cart']) || $_SESSION['connected_user_cart'] == false)
{

?> 
            <TABLE  width="100%" id="<?php echo($block_border_color);  ?>" style="<?php echo($bg_color_blocks_main.' '.$border_blocks); ?>">

                    <td><TABLE width="100%">

                        <td id="menu_title" align="center">
                            <?php echo('Déjà Client ? '); ?>
                        </td>

                    </TABLE></td>

                <tr></tr>

                    <td align="center"><TABLE width="100%" cellpadding="0" cellspacing="1" style="<?php echo($bg_color_blocks_front.' '.$border_blocks); ?>; height: 170px;" id="<?php echo($block_border_color);  ?>">
                    
                        <tr>                      
                            <td align="center"><label id="login_text">Pseudo ou Email</label></td>
                        </tr>

                        <tr>

                            <td align="center"><input id="login_input" type="text" name="txtLogin"></input>
                                <?php
                                    if(!empty($_SESSION['msg_login_bad_cart']))
                                    {                        
                                ?>
                                <br clear="left"/>
                                <span id="msg_wrong"><?php echo($_SESSION['msg_login_bad_cart']); ?></span>
                                <?php
                                    }
                                ?>
                            </td>

                        </tr>
                        <tr>
                            <td align="center"><label id="login_text">Mot de passe</label></td>
                        </tr>

                        <tr>

                            <td align="center">
                                <input id="login_input" type="password" name="txtPwd"></input>
                            </td>

                        </tr>
                        <tr>
                            <td align="center">
                                <input type="submit" name="bt_user_login_cart_x" value="Login"/>
                            </td>
                        </tr>
                        <tr>
                            <td align="center" id="login_link"><a href="index.php?page=forgotten_password&captcha=true">Mot de passe oublié?</a></td>    
                        </tr>

                       

                    </TABLE></td>

            </TABLE>
<?php
} 
?>
        </td>
        
        <td align="center" width="50%" style="vertical-align: top;">
            <TABLE  width="100%" id="<?php echo($block_border_color);  ?>" style="<?php echo($bg_color_blocks_main.' '.$border_blocks); ?>">

                    <td><TABLE width="100%">

                        <td id="menu_title" align="center">
                            <?php echo('Nouveau Client ?'); ?>
                        </td>

                    </TABLE></td>

                <tr></tr>

                    <td><TABLE width="100%" cellpadding="0" cellspacing="1" style="<?php echo($bg_color_blocks_front.' '.$border_blocks); ?>; height: 170px;" id="<?php echo($block_border_color);  ?>" border="0">
                         <tr>   
                            <td align="center">
                                <span id="center_subtitle">Merci de vous inscrire en</span>
                                <br/>
                                <a id="link" href="index.php?page=form_registration&captcha=true&ordercart=true">cliquant ici</a>
                            </td>
                         </tr>
                            
                    </TABLE></td>
            </TABLE>             
        </td>
        
</TABLE></form></td>       
<?php
    }
}
?>

<?php
if(isset($_POST['bt_check_promocode']))
{
    unset($_SESSION['msg_cart_txtCodeBonus']);
    
    $msgcode_1 = 'Invalide';
    $msgcode_2 = 'Expiré';
    $msgcode_3 = 'Déjà utilisé';
    $msgcode_4 = 'Accepté';
    $msgcode_5 = 'Valide à partir du ';
    $msgcode_6 = 'Bonus de ';
    $msgcode_7 = 'Le code a déjà été utilisé';

    $code = trim(htmlspecialchars($_POST['txtCodeBonus'], ENT_QUOTES));
    
    try
    {
        $prepared_query = 'SELECT * FROM bonus
                           WHERE code_bonus = :code
                           AND status_bonus = 1';
        $query = $connectData->prepare($prepared_query);
        $query->bindParam('code', $code);
        $query->execute();
        
        if(($data = $query->fetch()) == false)
        {
            if(!empty($code))
            {
                $_SESSION['msg_cart_txtCodeBonus'] = $msgcode_1;
            }
            else
            {
                unset($_SESSION['msg_cart_txtCodeBonus']);
            }
        }
        else
        {
            $query->execute();
            if(($data = $query->fetch()) != false)
            {
                $datebegin_code = $data['datebegin_bonus'];
                $dateend_code = $data['dateend_bonus'];
                $type_code = $data['type_bonus'];
                $repeat_code = $data['repeat_bonus'];
                $iduser_code = $data['id_user'];
                $valuetype_bonus = $data['valuetype_bonus'];
                $value_bonus = $data['value_bonus'];
            }
            $query->closeCursor();
            
            $datenow = date('Y-m-d', time());
            $frdatebegin_code = converto_timestamp($datebegin_code);
            $frdatebegin_code = date('d-m-Y', $frdatebegin_code);
            
            $array_iduser_code = split_number_product($iduser_code);
            $value_bonus = number_format($value_bonus, 2, '.', '');
            
            if($dateend_code < $datenow)
            {
                $_SESSION['msg_cart_txtCodeBonus'] = $msgcode_2;
            }
            else
            {
                if($datebegin_code > $datenow)
                {
                    $_SESSION['msg_cart_txtCodeBonus'] = $msgcode_5.$frdatebegin_code;
                }
                else
                {
                    $Bok_already_used = false;
                    
                    if($repeat_code == 'once')
                    {
                        for($i = 0, $count = count($array_iduser_code); $i < $count; $i++)
                        {
                            if($array_iduser_code[$i] == $_SESSION['login_id'])
                            {
                                $_SESSION['msg_cart_txtCodeBonus'] = $msgcode_3;
                                $Bok_already_used = true;
                                $i = $count;
                            }
                        }                     
                    }
                    
                    if($Bok_already_used == false && $repeat_code == 'once')
                    {
                        if($array_iduser_code[1] == null)
                        {
                            $iduser_code .= ','.$_SESSION['login_id'];
                        }
                        
                        if($array_iduser_code[0] == null)
                        {
                            $iduser_code = $_SESSION['login_id'];
                        }
                        
                        $prepared_query = 'UPDATE bonus
                                           SET id_user = :id
                                           WHERE code_bonus = :code';
                        $query = $connectData->prepare($prepared_query);
                        $query->execute(array(
                                              'id' => $iduser_code,
                                              'code' => $code
                                              ));
                        $query->closeCursor();
                    }
                    
                    $prepared_query = 'SELECT code_bonus FROM online_order
                                       INNER JOIN bonus 
                                       ON bonus.id_bonus = online_order.id_bonus
                                       WHERE online_order.id_user = :user AND id_order = :order';
                    $query = $connectData->prepare($prepared_query);
                    $query->execute(array(
                                          'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                                          'order' => $last_id_order
                                          ));
                    if(($data = $query->fetch()) != false)
                    {
                        $exist_code_bonus = $data[0];
                    }
                    $query->closeCursor();
                    
                    if($exist_code_bonus == $code)
                    {
                        $Bok_already_used = true;
                        //$_SESSION['msg_cart_txtCodeBonus'] = $msgcode_7;
                    }
                    
                    if($Bok_already_used == false)
                    {                       
                        if($valuetype_bonus == '%')
                        {
                            $_SESSION['msg_cart_txtCodeBonus'] = $msgcode_6.$value_bonus.'% accepté';
                        }
                        else
                        {
                            $_SESSION['msg_cart_txtCodeBonus'] = $msgcode_4;
                        }
                        
                        $prepared_query = 'SELECT MAX(id_order) FROM online_order
                                           WHERE id_user = :user';
                        $query = $connectData->prepare($prepared_query);
                        $query->execute(array(
                                              'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES)
                                              ));
                        if(($data = $query->fetch()) != false)
                        {
                            $user_last_idorder = $data[0];
                        }
                        $query->closeCursor();
                        
                        $prepared_query = 'SELECT * FROM bonus
                                           WHERE code_bonus = :code';
                        $query = $connectData->prepare($prepared_query);
                        $query->execute(array(
                                              'code' => $code
                                              ));
                        if(($data = $query->fetch()) != false)
                        {
                            $id_bonus = $data[0];
                            $typevalue_code = $data['valuetype_bonus'];
                            $value_code = $data['value_bonus'];
                        }
                        $query->closeCursor();
                        
                        $_SESSION['bonus_typevalue'] = $typevalue_code;
                        $_SESSION['bonus_value'] = $value_code;
                        
                        $prepared_query = 'UPDATE online_order
                                           SET id_bonus = :bonus
                                           WHERE id_order = :order';
                        $query = $connectData->prepare($prepared_query);
                        $query->execute(array(
                                              'bonus' => $id_bonus,
                                              'order' => $user_last_idorder
                                              ));
                        $query->closeCursor();
                    }
                }
            }
        }
    }
    catch (Exception $e)
    {
       die("<br>Error : ".$e->getMessage());
    }
    
    //header('Location: '.$header.$_SESSION['index'].'?page=cart_view');
}
?>

<?php
    if(isset($_GET['order']))
    {
        $last_id_order = trim(htmlspecialchars($_GET['order'], ENT_QUOTES));
        $_SESSION['block_cart_default_msg'] = 'opencart';
    }

    if(isset($_GET['registrationcart']))
    {
        if(!empty($_GET['registrationcart']) && $_GET['registrationcart'] == 'true')
        {
            unset($_SESSION['user_add_order_cart']);
        }
    }
    
    include('cart/cart_operation.php');
    
    try #count total authorized country to know which number's given to the last option called 'other country'
    {
        $query = $connectData->prepare('SELECT COUNT(id_country)
                                      FROM country 
                                      WHERE authorized_shipment = 1');
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $count_country_recap = $data[0];
        }
        $query->closeCursor();
        
        $query = $connectData->prepare('SELECT COUNT(id_user)
                                      FROM user_address
                                      
                                      WHERE id_user = :id');
        $query->bindParam('id', htmlspecialchars($_SESSION['login_id'], ENT_QUOTES));
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $count_address_recap = $data[0] + 1;
        }
        $query->closeCursor();
    }
    catch(Exception $e)
    {
        die("Error : ".$e->getMessage());
    }
    
    if(isset($_POST['bt_modify_order']))
    {
        // <editor-fold defaultstate="collapsed" desc="Back to cart view page to change cart content">
        
        $rad_billing_address = $_POST['rad_billing_address'];
        $rad_delivery_address = $_POST['rad_delivery_address'];
        
        $_SESSION['recap_cart_rad_billing'] = $rad_billing_address;
        $_SESSION['recap_cart_rad_delivery'] = $rad_delivery_address;
        
        if($rad_billing_address == ($count_address_recap + 1))
        {
            $title_billing = trim(htmlspecialchars($_POST['cboTitleBilling'], ENT_QUOTES)); 
            $firstname_billing = trim(htmlspecialchars($_POST['txtFirstNameBilling'], ENT_QUOTES)); 
            $lastname_billing = trim(htmlspecialchars($_POST['txtNameBilling'], ENT_QUOTES)); 
            $company_billing = trim(htmlspecialchars($_POST['txtCompanyBilling'], ENT_QUOTES)); 
            $address1_billing = trim(htmlspecialchars($_POST['txtAddress1Billing'], ENT_QUOTES)); 
            $address2_billing = trim(htmlspecialchars($_POST['txtAddress2Billing'], ENT_QUOTES)); 
            $zip_billing = trim(htmlspecialchars($_POST['txtPCBilling'], ENT_QUOTES)); 
            $city_billing = trim(htmlspecialchars($_POST['txtCityBilling'], ENT_QUOTES)); 
            $country_billing = trim(htmlspecialchars($_POST['cboCountryBilling'], ENT_QUOTES)); 
            $other_country_billing = trim(htmlspecialchars($_POST['txtOtherCountryBilling'], ENT_QUOTES)); 
            $landline_billing = trim(htmlspecialchars($_POST['txtLandlineBilling'], ENT_QUOTES)); 
            $mobile_billing = trim(htmlspecialchars($_POST['txtMobileBilling'], ENT_QUOTES)); 
            $email_billing = trim(htmlspecialchars($_POST['txtEmailBilling'], ENT_QUOTES));

            if($country_billing == $count_country_recap)
            {
               $country_billing = 0;
            }
           
            $_SESSION['cart_recap_billing_title'] = $title_billing;
            $_SESSION['cart_recap_billing_txtFirstName'] = $firstname_billing;
            $_SESSION['cart_recap_billing_txtName'] = $lastname_billing;
            $_SESSION['cart_recap_billing_txtCompany'] = $company_billing;
            $_SESSION['cart_recap_billing_txtZIP'] = $zip_billing;
            $_SESSION['cart_recap_billing_txtCity'] = $city_billing;

            $_SESSION['cart_recap_billing_txtAddress1'] = $address1_billing;
            $_SESSION['cart_recap_billing_txtAddress2'] = $address2_billing;

            $_SESSION['cart_recap_billing_selected_country'] = $country_billing;

            $_SESSION['cart_recap_billing_txtOtherCountry'] = $other_country_billing;
            
            $_SESSION['cart_recap_billing_txtLandline'] = $landline_billing;
            $_SESSION['cart_recap_billing_txtMobile'] = $mobile_billing;
            $_SESSION['cart_recap_billing_txtEmail'] = $email_billing;
        }  
        
        if($rad_delivery_address == ($count_address_recap + 1))
        {
            $title_delivery = trim(htmlspecialchars($_POST['cboTitleDelivery'], ENT_QUOTES)); 
            $firstname_delivery = trim(htmlspecialchars($_POST['txtFirstNameDelivery'], ENT_QUOTES)); 
            $lastname_delivery = trim(htmlspecialchars($_POST['txtNameDelivery'], ENT_QUOTES)); 
            $company_delivery = trim(htmlspecialchars($_POST['txtCompanyDelivery'], ENT_QUOTES)); 
            $address1_delivery = trim(htmlspecialchars($_POST['txtAddress1Delivery'], ENT_QUOTES)); 
            $address2_delivery = trim(htmlspecialchars($_POST['txtAddress2Delivery'], ENT_QUOTES)); 
            $zip_delivery = trim(htmlspecialchars($_POST['txtPCDelivery'], ENT_QUOTES)); 
            $city_delivery = trim(htmlspecialchars($_POST['txtCityDelivery'], ENT_QUOTES)); 
            $country_delivery = trim(htmlspecialchars($_POST['cboCountryDelivery'], ENT_QUOTES)); 
            $other_country_delivery = trim(htmlspecialchars($_POST['txtOtherCountryDelivery'], ENT_QUOTES)); 
            $landline_delivery = trim(htmlspecialchars($_POST['txtLandlineDelivery'], ENT_QUOTES)); 
            $mobile_delivery = trim(htmlspecialchars($_POST['txtMobileDelivery'], ENT_QUOTES)); 
            $email_delivery = trim(htmlspecialchars($_POST['txtEmailDelivery'], ENT_QUOTES));

            if($country_delivery == $count_country_recap)
            {
               $country_delivery = 0;
            }
           
            $_SESSION['cart_recap_delivery_title'] = $title_delivery;
            $_SESSION['cart_recap_delivery_txtFirstName'] = $firstname_delivery;
            $_SESSION['cart_recap_delivery_txtName'] = $lastname_delivery;
            $_SESSION['cart_recap_delivery_txtCompany'] = $company_delivery;
            $_SESSION['cart_recap_delivery_txtZIP'] = $zip_delivery;
            $_SESSION['cart_recap_delivery_txtCity'] = $city_delivery;

            $_SESSION['cart_recap_delivery_txtAddress1'] = $address1_delivery;
            $_SESSION['cart_recap_delivery_txtAddress2'] = $address2_delivery;

            $_SESSION['cart_recap_delivery_selected_country'] = $country_delivery;

            $_SESSION['cart_recap_delivery_txtOtherCountry'] = $other_country_delivery;
            
            $_SESSION['cart_recap_delivery_txtLandline'] = $landline_delivery;
            $_SESSION['cart_recap_delivery_txtMobile'] = $mobile_delivery;
            $_SESSION['cart_recap_delivery_txtEmail'] = $email_delivery;
        }
        
        header('Location: '.$header.'index.php?page=cart_view');
        // </editor-fold>
    }
    
    if(isset($_POST['bt_cancel_order']))
    {
       // <editor-fold defaultstate="collapsed" desc="Delete cart and redirect user to the cart view page">
       try
       {
           $query = $connectData->prepare('DELETE FROM cart WHERE id_order = :order');
           $query->bindParam('order', htmlspecialchars($last_id_order, ENT_QUOTES));
           $query->execute();
           $query->closeCursor();
           
           reallocate_table_id('id_cart', 'cart');

           $query = $connectData->prepare('UPDATE online_order SET status_order = \'cancelled\' 
                                           WHERE id_order = :order');
           $query->bindParam('order', htmlspecialchars($last_id_order, ENT_QUOTES));
           $query->execute();
           $query->closeCursor();
       }
       catch (Exception $e)
       {
           die("<br>Error : ".$e->getMessage());
       }
        
        header('Location: '.$header.'index.php?page=cart_view');// </editor-fold>
    }
    
    if(isset($_POST['bt_confirm_order']))
    {
        // <editor-fold defaultstate="collapsed" desc="confirm command">
        $chk_accept_conditions = $_POST['chk_accept_conditions'];
        $rad_payment = $_POST['rad_choose_payment'];       
        $rad_billing_address = $_POST['rad_billing_address'];
        $rad_delivery_address = $_POST['rad_delivery_address'];
        
        $_SESSION['recap_cart_rad_billing'] = $rad_billing_address;
        $_SESSION['recap_cart_rad_delivery'] = $rad_delivery_address;
        $_SESSION['recap_cart_rad_payment'] = $rad_payment;
        
        
        
        if($rad_billing_address == ($count_address_recap + 1) || $rad_delivery_address == ($count_address_recap + 1))
        {
            $_SESSION['msg_recap_cart_accept_conditions'] = 'Veuillez choisir une adresse avant de d\'effectuer votre commande';
            $Bok_choosen_address = false; 
        }
        else
        {
            unset($_SESSION['msg_recap_cart_accept_conditions']);
            $Bok_choosen_address = true;
        }
        
        if($chk_accept_conditions == false)
        {
            $_SESSION['msg_recap_cart_accept_conditions'] = 'Veuillez accepter les conditions générales de vente avant d\'effectuer votre commande';
            unset($_SESSION['cart_recap_rad_payment_send_mail'], $_SESSION['cart_recap_rad_payment_answer_mail']);
        }
        else
        {
            
            if($Bok_choosen_address === true)
            {
                if($rad_billing_address == 1 || $rad_delivery_address == 1)
                {
                    try
                    {
                       $query = $connectData->prepare('SELECT id_real FROM user_real
                                                       WHERE id_user = :id');
                       $query->bindParam('id', htmlspecialchars($_SESSION['login_id'], ENT_QUOTES));
                       $query->execute();
                       
                       if(($data = $query->fetch()) != false)
                       {
                           $id_real = 'original'.$data[0];
                       }
                       $query->closeCursor();
                       
                       if($rad_billing_address == 1)
                       {
                           $query = $connectData->prepare('UPDATE online_order
                                                           SET billing_address_order = :billing
                                                           WHERE id_order = :order
                                                           AND id_user = :user');
                           $query->execute(array(
                                                 'billing' => htmlspecialchars($id_real, ENT_QUOTES),
                                                 'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                                                 'order' => htmlspecialchars($last_id_order, ENT_QUOTES)
                                                  ));
                       }
                       
                       if($rad_delivery_address == 1)
                       {
                           $query = $connectData->prepare('UPDATE online_order
                                                           SET delivery_address_order = :delivery
                                                           WHERE id_order = :order
                                                           AND id_user = :user');
                           $query->execute(array(
                                                 'delivery' => htmlspecialchars($id_real, ENT_QUOTES),
                                                 'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                                                 'order' => htmlspecialchars($last_id_order, ENT_QUOTES)
                                                  ));
                       }
                       
                    }
                    catch(Exception $e)
                    {
                        die("Error : ".$e->getMessage());
                    }
                    
                }
                
                if($rad_billing_address > 1 || $rad_delivery_address > 1)
                {
                    
                    try
                    {
                       $query = $connectData->prepare('SELECT id_address FROM user_address
                                                       WHERE id_user = :id');
                       $query->bindParam('id', htmlspecialchars($_SESSION['login_id'], ENT_QUOTES));
                       $query->execute();
                       
                       $i = 2;
                       $j = 2;
                       
                       while($data = $query->fetch())
                       {
                           $other_address[$i] = $data[0];
                           $i++;
                           $j++;
                       }
                       $query->closeCursor();
                       
                       for($i = 2; $i < $j; $i++)
                       {
                           if($rad_billing_address == $i)
                           {
                               $query = $connectData->prepare('UPDATE online_order
                                                               SET billing_address_order = :billing
                                                               WHERE id_order = :order
                                                               AND id_user = :user');
                               $query->execute(array(
                                                     'billing' => htmlspecialchars($other_address[$i], ENT_QUOTES),
                                                     'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                                                     'order' => htmlspecialchars($last_id_order, ENT_QUOTES)
                                                      ));
                           }

                           if($rad_delivery_address == $i)
                           {
                               $query = $connectData->prepare('UPDATE online_order
                                                               SET delivery_address_order = :delivery
                                                               WHERE id_order = :order
                                                               AND id_user = :user');
                               $query->execute(array(
                                                     'delivery' => htmlspecialchars($other_address[$i], ENT_QUOTES),
                                                     'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                                                     'order' => htmlspecialchars($last_id_order, ENT_QUOTES)
                                                      ));
                           }
                       }
                    }
                    catch(Exception $e)
                    {
                        die("Error : ".$e->getMessage());
                    }     
                }
                
                $Bok_transferred_order_CB = false;
                $Bok_transferred_order_cash = false;
                $Bok_transferred_order_reunion = false;
                
                
                
                switch($rad_payment)
                {
                    case 'CB':
                        include('mail/order_accepted/send_order.php');
                        
                        if($online_payment_destination == 0)
                        {

                           $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Traité par Lux Réunion'; 
                           $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = 'Vous serez contacté par Lux Réunion dans les plus brefs délais'; 
                           $Bok_transferred_order_CB = true;
                        }
                        else
                        {
                           if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true))
                           {
                               if(!empty($_SESSION['cart_cash_discount_ok']) && $_SESSION['cart_cash_discount_ok'] == true)
                               {
                                   $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Carte Bancaire'; 
                                   $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = 'Vous avez choisi de régler par carte bancaire via le serveur sécurisé de PayBox'; 
                                   $Bok_transferred_order_CB = false;
                               }
                               else
                               {  
                                   $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Sous '.$user_add_reseller_creditdelay.' jours'; 
                                   $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = 'Vous avez choisi de régler votre commande sous '.$user_add_reseller_creditdelay.' jours';
                                   $Bok_transferred_order_CB = true; 
                               }
                           }
                           else
                           {
                               $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Carte Bancaire'; 
                               $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = 'Vous avez choisi de régler par carte bancaire via le serveur sécurisé de PayBox'; 
                               $Bok_transferred_order_CB = false;
                           }
                        }

                        if(!empty($_SESSION['cart_recap_billing_rad']))
                        {
                            $id_address_pay = '&addB='.$_SESSION['cart_recap_billing_rad'];
                        }
                        else
                        {
                            $id_address_pay = null;
                        }

                        if($Bok_transferred_order_CB === true)
                        {
                            header('Location: '.$header.'index.php?page=transferred_order&montant=ok');
                        }
                        else
                        {
                            header('Location: '.$header.'index.php?page=payment&idorder='.$last_id_order.$id_address_pay);
                        }
                    break;
                    
                    case 'reunion':
                        include('mail/order_accepted/send_order.php');
                        if($cart_type_real == 'public')
                        {

                           $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Traité par Lux Réunion'; 
                           $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = 'Vous serez contacté par Lux Réunion dans les plus brefs délais pour les modalités de paiement'; 
                           $Bok_transferred_order_reunion = true;
                        }
                        else
                        {
                           if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true) && !empty($_SESSION['cart_cash_discount_ok']) && $_SESSION['cart_cash_discount_ok'] == true)
                           {
                               $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Sous '.$user_add_reseller_creditdelay.' jours'; 
                               $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = 'Vous avez choisi de régler votre commande sous '.$user_add_reseller_creditdelay.' jours';
                               $Bok_transferred_order_reunion = true;
                           }
                           else
                           {
                               $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Traité par Lux Réunion'; 
                               $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = 'Vous serez contacté par Lux Réunion dans les plus brefs délais'; 
                               $Bok_transferred_order_reunion = true;
                           }
                        }

                        if(!empty($_SESSION['cart_recap_billing_rad']))
                        {
                            $id_address_pay = '&addB='.$_SESSION['cart_recap_billing_rad'];
                        }
                        else
                        {
                            $id_address_pay = null;
                        }

                        if($Bok_transferred_order_reunion === true)
                        {
                            header('Location: '.$header.'index.php?page=transferred_order&montant=ok');
                        }
                    break;
                        
                    case 'cash':
                        include('mail/order_accepted/send_order.php');
                        if($online_payment_destination == 0)
                        {

                           $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Espèce au dépôt de Lux Réunion'; 
                           $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = 'Vous serez contacté par Lux Réunion dans les plus brefs délais';
                           $Bok_transferred_order_cash = true;

                        }
                        else
                        {
                           if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true) && !empty($_SESSION['cart_cash_discount_ok']) && $_SESSION['cart_cash_discount_ok'] == true)
                           {
                               $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Espèce au dépôt choisi, paiement sous 8 jours'; 
                               $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = 'Vous avez choisi de régler votre commande en espèce. Vous avez 8 jours pour régler et récupérer votre commande. Passer ce délai, le stock commandé sera à nouveau disponible pour un autre client. Merci de votre compréhension.'; 
                           }
                           else
                           {
                               $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Espèce au dépôt choisi, sous '.$user_add_reseller_creditdelay.' jours'; 
                               $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = 'Vous avez choisi de régler votre commande en espèce sous '.$user_add_reseller_creditdelay.' jours';
                           }
                        }
                        
                        if(!empty($_SESSION['cart_recap_billing_rad']))
                        {
                            $id_address_pay = '&addB='.$_SESSION['cart_recap_billing_rad'];
                        }
                        else
                        {
                            $id_address_pay = null;
                        }

                        header('Location: '.$header.'index.php?page=transferred_order&montant=ok');
                        
                    break;
                    
                    case 'cash_credit':
                        include('mail/order_accepted/send_order.php');
                        
                        $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Règlement sous '.$user_add_reseller_creditdelay.' jours'; 
                        $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = 'Vous avez choisi de régler par carte bancaire votre commande sous '.$user_add_reseller_creditdelay.' jours'; 
                        

                        if(!empty($_SESSION['cart_recap_billing_rad']))
                        {
                            $id_address_pay = '&addB='.$_SESSION['cart_recap_billing_rad'];
                        }
                        else
                        {
                            $id_address_pay = null;
                        }

                        header('Location: '.$header.'index.php?page=transferred_order&montant=ok');
                        
                    break;
                    
                    case 'bank_transfer':
                        include('mail/order_accepted/send_order.php');
                        if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true) && empty($_SESSION['cart_cash_discount_ok']))
                        {
                            $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Règlement sous '.$user_add_reseller_creditdelay.' jours par <strong>virement bancaire</strong>'; 
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = '<br clear="left">Vous avez choisi de régler votre commande sous '.$user_add_reseller_creditdelay.' jours par <strong>virement bancaire</strong>.<br clear="left">';
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] .= 'Nos coordonnées bancaires:<br clear="left">';
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] .= $bank_transfer_info;
                        }
                        else
                        {
                            $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Règlement par <strong>virement bancaire</strong>'; 
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = '<br clear="left">Vous avez choisi de régler votre commande par <strong>virement bancaire</strong>.<br clear="left">';
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] .= 'Nos coordonnées bancaires:<br clear="left"><br clear="left">';
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] .= $bank_transfer_info.'<br clear="left">';
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] .= 'S\'il vous plait, n\'oubliez pas de mentionner le no. de commande situé dans la barre rouge ci-dessous lors de votre virement.<br clear="left"';
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] .= 'La commande sera expédiée après réception de votre virement.';
                        }

                        if(!empty($_SESSION['cart_recap_billing_rad']))
                        {
                            $id_address_pay = '&addB='.$_SESSION['cart_recap_billing_rad'];
                        }
                        else
                        {
                            $id_address_pay = null;
                        }

                        header('Location: '.$header.'index.php?page=transferred_order&montant=ok');
                    break;
                
                    case 'bank_check':
                        include('mail/order_accepted/send_order.php');
                        if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true) && empty($_SESSION['cart_cash_discount_ok']))
                        {
                            $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Règlement sous '.$user_add_reseller_creditdelay.' jours par <strong>chèque bancaire</strong>'; 
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = '<br clear="left">Vous avez choisi de régler votre commande sous '.$user_add_reseller_creditdelay.' jours par <strong>chèque bancaire</strong>.<br clear="left">';
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] .= 'Merci de libeller votre chèque à l\'ordre de <span style="color: '.$company_color.';">'.$copyright.'</span> et de mentionner le no. de commande au dos de ce dernier ou de joindre une copie de la commande<br clear="left">';
                        }
                        else
                        {
                            $_SESSION['cart_recap_rad_payment_send_mail'] = 'Mode de paiement: Règlement par <strong>chèque bancaire</strong>'; 
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] = '<br clear="left">Vous avez choisi de régler votre commande par <strong>chèque bancaire</strong>.<br clear="left">';
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] .= 'Merci de libeller votre chèque à l\'ordre de <span style="color: '.$company_color.';">'.$copyright.'</span> et de mentionner le no. de commande au dos de ce dernier ou de joindre une copie de la commande.<br clear="left">';
                            $_SESSION['cart_recap_rad_payment_autoanswer_mail'] .= 'Cette dernière sera expédiée après encaissement de votre chèque.';
                            
                        }
                        

                        if(!empty($_SESSION['cart_recap_billing_rad']))
                        {
                            $id_address_pay = '&addB='.$_SESSION['cart_recap_billing_rad'];
                        }
                        else
                        {
                            $id_address_pay = null;
                        }

                        header('Location: '.$header.'index.php?page=transferred_order&montant=ok');
                    break;
                }
                
                unset($_SESSION['msg_recap_cart_accept_conditions']);
            }
        }// </editor-fold>
    }
    
    if(isset($_POST['bt_new_address_delivery']))
    {
        // <editor-fold defaultstate="collapsed" desc="Add a new address into the database to the concerned user">
        $title_delivery = trim(htmlspecialchars($_POST['cboTitleDelivery'], ENT_QUOTES)); 
        $firstname_delivery = trim(htmlspecialchars($_POST['txtFirstNameDelivery'], ENT_QUOTES)); 
        $lastname_delivery = trim(htmlspecialchars($_POST['txtNameDelivery'], ENT_QUOTES)); 
        $company_delivery = trim(htmlspecialchars($_POST['txtCompanyDelivery'], ENT_QUOTES)); 
        $address1_delivery = trim(htmlspecialchars($_POST['txtAddress1Delivery'], ENT_QUOTES)); 
        $address2_delivery = trim(htmlspecialchars($_POST['txtAddress2Delivery'], ENT_QUOTES)); 
        $zip_delivery = trim(htmlspecialchars($_POST['txtPCDelivery'], ENT_QUOTES)); 
        $city_delivery = trim(htmlspecialchars($_POST['txtCityDelivery'], ENT_QUOTES)); 
        $country_delivery = trim(htmlspecialchars($_POST['cboCountryDelivery'], ENT_QUOTES)); 
        $other_country_delivery = trim(htmlspecialchars($_POST['txtOtherCountryDelivery'], ENT_QUOTES)); 
        $landline_delivery = trim(htmlspecialchars($_POST['txtLandlineDelivery'], ENT_QUOTES)); 
        $mobile_delivery = trim(htmlspecialchars($_POST['txtMobileDelivery'], ENT_QUOTES)); 
        $email_delivery = trim(htmlspecialchars($_POST['txtEmailDelivery'], ENT_QUOTES));

        $rad_delivery_address = $_POST['rad_delivery_address'];
        
        $_SESSION['recap_cart_rad_delivery'] = $rad_delivery_address;
        
        $BoK_part_delivery_recap = true;
        
        if($country_delivery == $count_country_recap)
        {
           $country_delivery = 0;
        }

        unset($_SESSION['confirm_error_firstname_cart_recap_delivery'],
              $_SESSION['confirm_error_name_cart_recap_delivery'],
              $_SESSION['confirm_error_zip_cart_recap_delivery'],
              $_SESSION['confirm_error_city_cart_recap_delivery'],
              $_SESSION['confirm_error_address1_cart_recap_delivery'],
              $_SESSION['confirm_error_country_cart_recap_delivery'],
              $_SESSION['confirm_error_email_cart_recap_delivery']);
        
        $_SESSION['cart_recap_delivery_title'] = $title_delivery;
        $_SESSION['cart_recap_delivery_txtFirstName'] = $firstname_delivery;
        $_SESSION['cart_recap_delivery_txtName'] = $lastname_delivery;
        $_SESSION['cart_recap_delivery_txtCompany'] = $company_delivery;
        $_SESSION['cart_recap_delivery_txtZIP'] = $zip_delivery;
        $_SESSION['cart_recap_delivery_txtCity'] = $city_delivery;

        $_SESSION['cart_recap_delivery_txtAddress1'] = $address1_delivery;
        $_SESSION['cart_recap_delivery_txtAddress2'] = $address2_delivery;

        $_SESSION['cart_recap_delivery_selected_country'] = $country_delivery;

        $_SESSION['cart_recap_delivery_txtOtherCountry'] = $other_country_delivery;

        $_SESSION['cart_recap_delivery_txtLandline'] = $landline_delivery;
        $_SESSION['cart_recap_delivery_txtMobile'] = $mobile_delivery;
        $_SESSION['cart_recap_delivery_txtEmail'] = $email_delivery;
        
        if(empty($firstname_delivery))
        {
          $_SESSION['confirm_error_firstname_cart_recap_delivery'] = 'Veuillez saisir votre Prénom';
          $BoK_part_delivery_recap = false;
        }

        if(empty($lastname_delivery))
        {
          $_SESSION['confirm_error_name_cart_recap_delivery'] = 'Veuillez saisir votre Nom'; 
          $BoK_part_delivery_recap = false;
        }

        if(empty($zip_delivery))
        {
          $_SESSION['confirm_error_zip_cart_recap_delivery'] = 'Veuillez saisir votre code postal'; 
          $BoK_part_delivery_recap = false;
        }
        else
        {
           if(!is_numeric($zip_delivery))
           {
               $_SESSION['confirm_error_zip_cart_recap_delivery'] = 'Veuillez saisir un code postal valide'; 
               $BoK_part_delivery_recap = false;
           }
        }

        if(empty($city_delivery))
        {
          $_SESSION['confirm_error_city_cart_recap_delivery'] = 'Veuillez saisir votre ville';
          $BoK_part_delivery_recap = false;
        }

        if(empty($address1_delivery))
        {
          $_SESSION['confirm_error_address1_cart_recap_delivery'] = 'Veuillez saisir votre adresse';
          $BoK_part_delivery_recap = false;
        }


        if($selected_country == $count_country_recap)
        {
           if(empty($other_country_delivery))
           {
               $_SESSION['confirm_error_country_cart_recap_delivery'] = 'Veuillez indiquez votre Pays';
               $BoK_part_delivery_recap = false;
           }
        }
        else
        {
           $other_country_delivery = ''; 
        }
       
        if(empty($email_delivery))
        {
            $BoK_part_delivery_recap = false;
            $_SESSION['confirm_error_email_cart_recap_delivery'] = 'Veuillez saisir votre Email';
        }
        else
        {
            if(!preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $email_delivery))
            {
                $BoK_part_delivery_recap = false;
                $_SESSION['confirm_error_email_cart_recap_delivery'] = 'Veuillez saisir un Email valide';
            }
        }
        
        
        if($BoK_part_delivery_recap == true)
        {
            
            try
            {
                $query = $connectData->prepare('INSERT INTO user_address
                                                (id_user, name_address, title_address,
                                                 first_name_address, last_name_address,
                                                 name_company_address, address_1_address,
                                                 address_2_address, zip_address,
                                                 city_address, id_country,
                                                 phone_landline_address, phone_mobile_address,
                                                 email_address, other_country_address)
                                                VALUES
                                                (:id_user, :name_address, :title,
                                                 :firstname, :lastname, :company,
                                                 :address1, :address2, :zip,
                                                 :city, :id_country, :landline,
                                                 :mobile, :email, :other_country)');
                $query->execute(array(
                                      'id_user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                                      'name_address' => htmlspecialchars('address'.$count_address_recap, ENT_QUOTES),
                                      'title' => $title_delivery,
                                      'firstname' => $firstname_delivery,
                                      'lastname' => $lastname_delivery,
                                      'company' => $company_delivery,
                                      'address1' => $address1_delivery,
                                      'address2' => $address2_delivery,
                                      'zip' => $zip_delivery,
                                      'city' => $city_delivery,
                                      'id_country' => $country_delivery,
                                      'landline' => $landline_delivery,
                                      'mobile' => $mobile_delivery,
                                      'email' => $email_delivery,
                                      'other_country' => $other_country_delivery
                                      ));
                
                $query->closeCursor();
                
                unset($_SESSION['confirm_error_firstname_cart_recap_delivery'],
                      $_SESSION['confirm_error_name_cart_recap_delivery'],
                      $_SESSION['confirm_error_zip_cart_recap_delivery'],
                      $_SESSION['confirm_error_city_cart_recap_delivery'],
                      $_SESSION['confirm_error_address1_cart_recap_delivery'],
                      $_SESSION['confirm_error_country_cart_recap_delivery'],
                      $_SESSION['confirm_error_email_cart_recap_delivery'],
                      $_SESSION['cart_recap_delivery_title'],
                      $_SESSION['cart_recap_delivery_txtFirstName'],
                      $_SESSION['cart_recap_delivery_txtName'],
                      $_SESSION['cart_recap_delivery_txtCompany'],
                      $_SESSION['cart_recap_delivery_txtZIP'],
                      $_SESSION['cart_recap_delivery_txtCity'],
                      $_SESSION['cart_recap_delivery_txtAddress1'],
                      $_SESSION['cart_recap_delivery_txtAddress2'],
                      $_SESSION['cart_recap_delivery_selected_country'],
                      $_SESSION['cart_recap_delivery_txtOtherCountry'],
                      $_SESSION['cart_recap_delivery_txtLandline'],
                      $_SESSION['cart_recap_delivery_txtMobile'],
                      $_SESSION['cart_recap_delivery_txtEmail'],
                      $_SESSION['recap_cart_add_address_delivery']);
                
                header('Location: '.$header.$_SESSION['index'].'?page='.$_SESSION['redirect'].'&addAD=false');
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }
        }
        // </editor-fold>
    }
    
    if(isset($_POST['bt_new_address_billing']))
    {
        // <editor-fold defaultstate="collapsed" desc="Add a new address into the database to the concerned user">
        $title_billing = trim(htmlspecialchars($_POST['cboTitleBilling'], ENT_QUOTES)); 
        $firstname_billing = trim(htmlspecialchars($_POST['txtFirstNameBilling'], ENT_QUOTES)); 
        $lastname_billing = trim(htmlspecialchars($_POST['txtNameBilling'], ENT_QUOTES)); 
        $company_billing = trim(htmlspecialchars($_POST['txtCompanyBilling'], ENT_QUOTES)); 
        $address1_billing = trim(htmlspecialchars($_POST['txtAddress1Billing'], ENT_QUOTES)); 
        $address2_billing = trim(htmlspecialchars($_POST['txtAddress2Billing'], ENT_QUOTES)); 
        $zip_billing = trim(htmlspecialchars($_POST['txtPCBilling'], ENT_QUOTES)); 
        $city_billing = trim(htmlspecialchars($_POST['txtCityBilling'], ENT_QUOTES)); 
        $country_billing = trim(htmlspecialchars($_POST['cboCountryBilling'], ENT_QUOTES)); 
        $other_country_billing = trim(htmlspecialchars($_POST['txtOtherCountryBilling'], ENT_QUOTES)); 
        $landline_billing = trim(htmlspecialchars($_POST['txtLandlineBilling'], ENT_QUOTES)); 
        $mobile_billing = trim(htmlspecialchars($_POST['txtMobileBilling'], ENT_QUOTES)); 
        $email_billing = trim(htmlspecialchars($_POST['txtEmailBilling'], ENT_QUOTES));

        $rad_billing_address = $_POST['rad_billing_address'];
        
        $_SESSION['recap_cart_rad_billing'] = $rad_billing_address;
        
        $BoK_part_billing_recap = true;
        
        if($country_billing == $count_country_recap)
        {
           $country_billing = 0;
        }

        unset($_SESSION['confirm_error_firstname_cart_recap_billing'],
              $_SESSION['confirm_error_name_cart_recap_billing'],
              $_SESSION['confirm_error_zip_cart_recap_billing'],
              $_SESSION['confirm_error_city_cart_recap_billing'],
              $_SESSION['confirm_error_address1_cart_recap_billing'],
              $_SESSION['confirm_error_country_cart_recap_billing'],
              $_SESSION['confirm_error_email_cart_recap_billing']);
        
        $_SESSION['cart_recap_billing_title'] = $title_billing;
        $_SESSION['cart_recap_billing_txtFirstName'] = $firstname_billing;
        $_SESSION['cart_recap_billing_txtName'] = $lastname_billing;
        $_SESSION['cart_recap_billing_txtCompany'] = $company_billing;
        $_SESSION['cart_recap_billing_txtZIP'] = $zip_billing;
        $_SESSION['cart_recap_billing_txtCity'] = $city_billing;

        $_SESSION['cart_recap_billing_txtAddress1'] = $address1_billing;
        $_SESSION['cart_recap_billing_txtAddress2'] = $address2_billing;

        $_SESSION['cart_recap_billing_selected_country'] = $country_billing;

        $_SESSION['cart_recap_billing_txtOtherCountry'] = $other_country_billing;

        $_SESSION['cart_recap_billing_txtLandline'] = $landline_billing;
        $_SESSION['cart_recap_billing_txtMobile'] = $mobile_billing;
        $_SESSION['cart_recap_billing_txtEmail'] = $email_billing;
        
        if(empty($firstname_billing))
        {
          $_SESSION['confirm_error_firstname_cart_recap_billing'] = 'Veuillez saisir votre Prénom';
          $BoK_part_billing_recap = false;
        }

        if(empty($lastname_billing))
        {
          $_SESSION['confirm_error_name_cart_recap_billing'] = 'Veuillez saisir votre Nom'; 
          $BoK_part_billing_recap = false;
        }

        if(empty($zip_billing))
        {
          $_SESSION['confirm_error_zip_cart_recap_billing'] = 'Veuillez saisir votre code postal'; 
          $BoK_part_billing_recap = false;
        }
        else
        {
           if(!is_numeric($zip_billing))
           {
               $_SESSION['confirm_error_zip_cart_recap_billing'] = 'Veuillez saisir un code postal valide'; 
               $BoK_part_billing_recap = false;
           }
        }

        if(empty($city_billing))
        {
          $_SESSION['confirm_error_city_cart_recap_billing'] = 'Veuillez saisir votre ville';
          $BoK_part_billing_recap = false;
        }

        if(empty($address1_billing))
        {
          $_SESSION['confirm_error_address1_cart_recap_billing'] = 'Veuillez saisir votre adresse';
          $BoK_part_billing_recap = false;
        }


        if($selected_country == $count_country_recap)
        {
           if(empty($other_country_billing))
           {
               $_SESSION['confirm_error_country_cart_recap_billing'] = 'Veuillez indiquez votre Pays';
               $BoK_part_billing_recap = false;
           }
        }
        else
        {
           $other_country_billing = ''; 
        }
       
        if(empty($email_billing))
        {
            $BoK_part_billing_recap = false;
            $_SESSION['confirm_error_email_cart_recap_billing'] = 'Veuillez saisir votre Email';
        }
        else
        {
            if(!preg_match("#^[a-z0-9A-Z]+[-a-z0-9A-Z._]+@[a-z0-9]+[-a-z0-9]*([.]?){1,}[a-z0-9-]*\.[a-z]{2,6}$#", $email_billing))
            {
                $BoK_part_billing_recap = false;
                $_SESSION['confirm_error_email_cart_recap_billing'] = 'Veuillez saisir un Email valide';
            }
        }
        
        
        if($BoK_part_billing_recap == true)
        {
            
            try
            {
                $query = $connectData->prepare('INSERT INTO user_address
                                                (id_user, name_address, title_address,
                                                 first_name_address, last_name_address,
                                                 name_company_address, address_1_address,
                                                 address_2_address, zip_address,
                                                 city_address, id_country,
                                                 phone_landline_address, phone_mobile_address,
                                                 email_address, other_country_address)
                                                VALUES
                                                (:id_user, :name_address, :title,
                                                 :firstname, :lastname, :company,
                                                 :address1, :address2, :zip,
                                                 :city, :id_country, :landline,
                                                 :mobile, :email, :other_country)');
                $query->execute(array(
                                      'id_user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                                      'name_address' => htmlspecialchars('address'.$count_address_recap, ENT_QUOTES),
                                      'title' => $title_billing,
                                      'firstname' => $firstname_billing,
                                      'lastname' => $lastname_billing,
                                      'company' => $company_billing,
                                      'address1' => $address1_billing,
                                      'address2' => $address2_billing,
                                      'zip' => $zip_billing,
                                      'city' => $city_billing,
                                      'id_country' => $country_billing,
                                      'landline' => $landline_billing,
                                      'mobile' => $mobile_billing,
                                      'email' => $email_billing,
                                      'other_country' => $other_country_billing
                                      ));
                
                $query->closeCursor();
                
                unset($_SESSION['confirm_error_firstname_cart_recap_billing'],
                      $_SESSION['confirm_error_name_cart_recap_billing'],
                      $_SESSION['confirm_error_zip_cart_recap_billing'],
                      $_SESSION['confirm_error_city_cart_recap_billing'],
                      $_SESSION['confirm_error_address1_cart_recap_billing'],
                      $_SESSION['confirm_error_country_cart_recap_billing'],
                      $_SESSION['confirm_error_email_cart_recap_billing'],
                      $_SESSION['cart_recap_billing_title'],
                      $_SESSION['cart_recap_billing_txtFirstName'],
                      $_SESSION['cart_recap_billing_txtName'],
                      $_SESSION['cart_recap_billing_txtCompany'],
                      $_SESSION['cart_recap_billing_txtZIP'],
                      $_SESSION['cart_recap_billing_txtCity'],
                      $_SESSION['cart_recap_billing_txtAddress1'],
                      $_SESSION['cart_recap_billing_txtAddress2'],
                      $_SESSION['cart_recap_billing_selected_country'],
                      $_SESSION['cart_recap_billing_txtOtherCountry'],
                      $_SESSION['cart_recap_billing_txtLandline'],
                      $_SESSION['cart_recap_billing_txtMobile'],
                      $_SESSION['cart_recap_billing_txtEmail'],
                      $_SESSION['recap_cart_add_address_billing']);
                
                header('Location: '.$header.$_SESSION['index'].'?page='.$_SESSION['redirect'].'&addAB=false');
            }
            catch(Exception $e)
            {
                die("Error : ".$e->getMessage());
            }
        }
        // </editor-fold>
    }
    
    ?>

    <td><form method="post"><TABLE width="100%" cellpadding="0" cellspacing="0" border="0">
                
<?php
        if(!empty($_SESSION['msg_recap_cart_accept_conditions']))
        {
?>
           <td colspan="6" align="center">
               <div id="pay_msg_wrong" style="padding: 10px; background-color: red;"><span id="msg_pay_wrong" style="margin-left: 8px;"><?php echo(check_session_input($_SESSION['msg_recap_cart_accept_conditions'])); ?></span></div> 
           </td> 

           <tr style="height: 6px;"></tr>
<?php
        }
?>        
    <?php
    // <editor-fold defaultstate="collapsed" desc="Order Tab">
    
    ?>
        <td>
            <TABLE width="100%" cellpadding="0" cellspacing="0">

                <td colspan="6">
                    <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                        <td>
                            <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">Votre commande</span>
                        </td>
                    </TABLE>
                </td>

                <tr style="height: 6px;"></tr>

                <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Qté</span></div></td>
                <td id="center_text_table" align="center" width="50%"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Libellé</span></div></td>
                <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Taux</span></div></td>
                <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">H.T.</span></div></td>            
                <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">TVA</span></div></td>
                <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">T.T.C.</span></div></td>
                
                <tr></tr>
<?php
$total_product_ht = null;
$total_amount_ht = null;
$total_product_ttc = null;

for($i = 0; $i < count($id_product); $i++)
{ 
//    if(strlen($name_product_cart[$i]) > 50)
//    {
//        $name_product_cart[$i] = substr($name_product_cart[$i], 0, 50).'...';   
//    }

    try
    {
        $query = $connectData->prepare('SELECT product.*, product_details.* 
                                        FROM product
                                        INNER JOIN product_details 
                                        ON product.id_product = product_details.id_product
                                        WHERE product.id_product = :id');

        $query->bindParam('id', htmlspecialchars($id_product[$i], ENT_QUOTES));
        $query->execute();

        if(($data = $query->fetch()) != false)
        {
            $price_resale_cart = $data['price_resale_details'];
            $price_promo_cart = $data['price_promo_details'];
            $delivery_cart = $data['delivery_details'];
        }

        if($cart_bonus_real > 0)
        {
            //$price_resale_cart = $price_resale_cart - ($price_resale_cart * ($cart_bonus_real/100)); 
            $price_bonus_cart = $price_resale_cart - ($price_resale_cart * ($cart_bonus_real/100)); 
            $price_bonus_cart = number_format($price_bonus_cart, 2, '.', '');
        }
        else
        {
            $price_bonus_cart = null;
        }

        $price_resale_cart = number_format($price_resale_cart, 2, '.', '');
    }
    catch (Exception $e)
    {
        die("<br>Error : ".$e->getMessage());
    }



    if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
    {
        if($cart_bonus_real > 0)
        {
           $total_amount = $qty[$i] * $price_bonus_cart;
           
           $total_amount_ttc = $total_amount * (1+$value_tax);
           $total_amount_ttc = number_format($total_amount_ttc, 2, '.', '');
           
           $vat_amount = $total_amount_ttc - $total_amount;
           $vat_amount = number_format($vat_amount, 2, '.', '');
        }
        else
        {
           $total_amount = $qty[$i] * $price_resale_cart;
           
           $total_amount_ttc = $total_amount * (1+$value_tax);
           $total_amount_ttc = number_format($total_amount_ttc, 2, '.', '');
           
           $vat_amount = $total_amount_ttc - $total_amount;
           $vat_amount = number_format($vat_amount, 2, '.', '');
        }

        $total_amount = number_format($total_amount, 2, '.', '');          
    }
    else
    {
        if($price_promo_cart > 0.00)
        {
           $total_amount_ttc = $qty[$i] * $price_promo_cart;
           $total_amount_ttc = number_format($total_amount_ttc, 2, '.', '');
           
           $total_amount = $total_amount_ttc / (1+$value_tax);
           $total_amount = number_format($total_amount, 2, '.', '');
           
           $vat_amount = $total_amount * $value_tax;
           $vat_amount = number_format($vat_amount, 2, '.', '');                 
        }
        else
        {
           $total_amount_ttc = $qty[$i] * $price_public_cart[$i];
           $total_amount_ttc = number_format($total_amount_ttc, 2, '.', '');
           
           $total_amount = $total_amount_ttc / (1+$value_tax);
           $total_amount = number_format($total_amount, 2, '.', '');
           
           $vat_amount = $total_amount * $value_tax;
           $vat_amount = number_format($vat_amount, 2, '.', '');     
        }

    }
       
    if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
    {
        $total_product_ht += $total_amount; 
        $total_product_ht = number_format($total_product_ht, 2, '.', '');
        
        $total_product_ttc += $total_amount_ttc;
        $total_product_ttc = number_format($total_product_ttc, 2, '.', '');      

        $total_product_vat += $vat_amount;
        $total_product_vat = number_format($total_product_vat, 2, '.', '');
    }
    else
    {
        $total_product_ttc += $total_amount_ttc;
        $total_product_ttc = number_format($total_product_ttc, 2, '.', '');

        $total_product_ht = $total_product_ttc / (1+$value_tax); 
        $total_product_ht = number_format($total_product_ht, 2, '.', '');
        
        $total_product_vat = $total_product_ht * $value_tax;
        $total_product_vat = number_format($total_product_vat, 2, '.', '');
    }
    
    
    
?>                
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($qty[$i]); ?></span>
                </td>
                <td>
                    <p id="center_text" style="margin-left: 4px;"><?php echo($name_product_cart[$i]); ?></p>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($tax_percent.'%'); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($total_amount); ?></span>
                </td>           
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($vat_amount); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($total_amount_ttc); ?></span>
                </td>
                
                <tr></tr>
<?php
}

if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
{   
    $vat_destination = $total_destination - $total_destination2;
    $vat_destination = number_format($vat_destination, 2, '.', '');

    $ecotax_ht = $eco_taxe / (1 + $value_tax);
    $ecotax_ht = number_format($ecotax_ht, 2, '.', '');

    $ecotax_vat = $eco_taxe - $ecotax_ht;
    $ecotax_vat = number_format($ecotax_vat, 2, '.', '');
    
}
else
{
    $total_destination2 = $total_destination2 / (1+$value_tax);
    $total_destination2 = number_format($total_destination2, 2, '.', '');
    
    $vat_destination = $total_destination - $total_destination2;
    $vat_destination = number_format($vat_destination, 2, '.', '');

    $ecotax_ht = $eco_taxe / (1 + $value_tax);
    $ecotax_ht = number_format($ecotax_ht, 2, '.', '');

    $ecotax_vat = $eco_taxe - $ecotax_ht;
    $ecotax_vat = number_format($ecotax_vat, 2, '.', '');
}
?>
                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" style="border-bottom: 1px solid lightgray;"><span></span></td>

                <tr></tr>

                <td></td>
                <td align="right"><span id="center_subtitle" style="margin-right: 4px;">Somme des articles</span></td>
                <td></td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($total_product_ht); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($total_product_vat); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($total_product_ttc); ?></span>
                </td>

                <tr></tr>
                
<?php
if(!empty($eco_taxe) && $eco_taxe > 0.00)
{
?>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;">1</span>
                </td>
                <td>
                    <p id="center_text" style="margin-left: 4px;">Total Eco-Taxe</p>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($tax_percent.'%'); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($ecotax_ht); ?></span>
                </td>           
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($ecotax_vat); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo(number_format($eco_taxe, 2, '.', '')); ?></span>
                </td>

                
<?php               
}
?>
                
<?php
if(!empty($_SESSION['bonus_applied']))
{
    $bonus_ttc = $_SESSION['bonus_applied'];
    $bonus_ttc = number_format($bonus_ttc, 2, '.', '');
    
    $bonus_ht = $bonus_ttc / (1 + $value_tax);
    $bonus_ht = number_format($bonus_ht, 2, '.', '');
    
    $bonus_vat = $bonus_ttc - $bonus_ht;
    $bonus_vat = number_format($bonus_vat, 2, '.', '');
    
?>
                <tr></tr>
                
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;">1</span>
                </td>
                <td>
                    <p id="center_text" style="margin-left: 4px;">Bon de réduction</p>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($tax_percent.'%'); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo('-'.$bonus_ht); ?></span>
                </td>           
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo('-'.$bonus_vat); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo('-'.$bonus_ttc); ?></span>
                </td>

                
<?php               
}
?>
                <tr></tr>

                <td align="right">
                    <span id="center_text" style="margin-right: 4px;">1</span>
                </td>
                <td>
                    <p id="center_text" style="margin-left: 4px;">Transport: <?php echo($name_destination); ?></p>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($tax_percent.'%'); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo(number_format($total_destination2, 2, '.', '')); ?></span>
                </td>           
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($vat_destination); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo(number_format($total_destination, 2, '.', '')); ?></span>
                </td>
                
<?php               


if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true) && !empty($_SESSION['cart_cash_discount_ok']) && $_SESSION['cart_cash_discount_ok'] == true)
{
    $discount_ttc = $discount_ht * (1+$value_tax);
    $discount_ttc = number_format($discount_ttc, 2, '.', '');
    
    $discount_vat = $discount_ttc - $discount_ht;
    $discount_vat = number_format($discount_vat, 2, '.', '');
?>
                <tr></tr>

                <td align="right">
                    <span id="center_text" style="margin-right: 4px;">1</span>
                </td>
                <td>
                    <p id="center_text" style="margin-left: 4px;">Escompte de <?php echo($cart_discount_real); ?>% sur <?php echo($total_product_net.'&nbsp;€&nbsp;Hors&nbsp;Taxes'); ?></p>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($tax_percent.'%'); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo('-'.$discount_ht); ?></span>
                </td>           
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo('-'.$discount_vat); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo('-'.$discount_ttc); ?></span>
                </td>

<?php               
}

//if(!empty($_SESSION['cart_total_discount']))
//{
//    $discount_value = $_SESSION['cart_total_discount'];
//
//    if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
//    {
//       $discount_value_ht = $discount_value * $value_tax;
//       $discount_vat = $discount_value - $discount_value_ht;
//
//       $discount_value_ht = number_format($discount_value_ht, 2, '.', '');
//       $discount_vat = number_format($discount_vat, 2, '.', ''); 
//       $discount_value = number_format($discount_value, 2, '.', ''); 
//    }
//    else
//    {
//       $discount_vat = $discount_value * $value_tax;
//       $discount_value_ht = $discount_value - $discount_vat;
//
//       $discount_value_ht = number_format($discount_value_ht, 2, '.', '');
//       $discount_vat = number_format($discount_vat, 2, '.', '');
//       $discount_value = number_format($discount_value, 2, '.', ''); 
//    }
?>
<!--                <tr></tr>

                <td align="right">
                    <span id="center_text" style="margin-right: 4px;">1</span>
                </td>
                <td>
                    <span id="center_text" style="margin-left: 4px;">Bon de réduction</span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php //echo($tax_percent.'%'); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php //echo('-'.$discount_value_ht); ?></span>
                </td>           
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php //echo('-'.$discount_vat); ?></span>
                </td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php //echo('-'.$discount_value); ?></span>
                </td>-->
<?php
//}

if(!empty($discount_value) && $discount_value > 0.00)
{
    if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
    {
        
    }
    else
    {
        $super_total_ht = $total_product_ht + $total_destination2 + $ecotax_ht - $discount_value_ht; 
        $super_total_ht = number_format($super_total_ht, 2, '.', '');

        $super_total_ttc = $total_product_ttc + $total_destination + $eco_taxe - $discount_value;
        $super_total_ttc = number_format($super_total_ttc, 2, '.', '');

        $super_total_vat = $super_total_ttc * $value_tax;
        $super_total_vat = number_format($super_total_vat, 2, '.', '');
    }
}
else
{
    if($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true)
    {
        if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true) && !empty($_SESSION['cart_cash_discount_ok']) && $_SESSION['cart_cash_discount_ok'] == true)
        {
            $super_total_ht -= $discount_ht;
            $super_total_ttc -= $discount_ttc;
            $super_total_vat -= $discount_ttc;
        }
        
        $super_total_ht += $total_product_net + $total_destination2 + $eco_taxe_reseller; 
        $super_total_ht = number_format($super_total_ht, 2, '.', '');

        $super_total_ttc = $super_total;
        $super_total_ttc = number_format($super_total_ttc, 2, '.', '');

        $super_total_vat = $vat_taxe;
        $super_total_vat = number_format($super_total_vat, 2, '.', '');
    }
    else
    {    
        if(!empty($_SESSION['bonus_applied']))
        {
            $super_total_ttc = $super_total - $_SESSION['bonus_applied'];
            $super_total_ttc = number_format($super_total_ttc, 2, '.', '');
            
            $super_total_ht = $super_total_ttc / (1 + $value_tax); 
            $super_total_ht = number_format($super_total_ht, 2, '.', '');
            
            $super_total_vat = $super_total_ttc - $super_total_ht;
            $super_total_vat = number_format($super_total_vat, 2, '.', '');
        }
        else
        {
            $super_total_ht = $total_product_ht + $total_destination2; 
            $super_total_ht = number_format($super_total_ht, 2, '.', '');
            
            $super_total_ttc = $super_total;
            $super_total_ttc = number_format($super_total_ttc, 2, '.', '');
            
            $super_total_vat = $vat_taxe;
            $super_total_vat = number_format($super_total_vat, 2, '.', '');
        }

        
    }
}
?>
                <tr></tr>

                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" style="border-bottom: 1px solid lightgray;"><span></span></td>

                <tr></tr>

                <td></td>
                <td align="right"><span id="center_subtitle" style="margin-right: 4px;">Total Hors Taxes</span></td>
                <td></td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($super_total_ht); ?></span>
                </td>
                <td></td>
                <td></td>

                <tr></tr>

                <td></td>
                <td align="right"><span id="center_subtitle" style="margin-right: 4px;">Total TVA <?php echo($tax_percent.'%'); ?></span></td>
                <td></td>
                <td></td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($super_total_vat); ?></span>
                </td>
                <td></td>

                <tr></tr>

                <td></td>
                <td align="right"><span id="center_subtitle" style="margin-right: 4px;">Total T.T.C.</span></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo($super_total_ttc); ?></span>
                </td>

                <tr></tr>

                <td></td>
                <td></td>
                <td></td>
                <td colspan="3" style="border-bottom: 1px solid lightgray;"><span></span></td>

                <tr></tr>

                <td></td>
                <td align="right"><span id="center_subtitle" style="margin-right: 4px;">Somme à payer en Euro T.T.C.</span></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">
                    <span id="center_subtitle" style="margin-right: 4px;"><?php echo($super_total_ttc); ?></span>
                </td>

                <tr></tr>

                <td></td>
                <td align="right"><span id="center_text" style="margin-right: 4px;">Valeur en Franc T.T.C.</span></td>
                <td></td>
                <td></td>
                <td></td>
                <td align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo(number_format(($super_total_ttc* $currency_franc), 2, '.', '')); ?></span>
                </td>

                <tr style="height: 6px;"></tr>

                <td colspan="6" style="border-bottom: 1px solid lightgray;"><span></span></td>

                <tr style="height: 6px;"></tr>

                <td colspan="6" align="center">
                    <input type="submit" name="bt_modify_order" value="Modifier"></input>
                    &nbsp;
                    <input type="submit" name="bt_cancel_order" value="Annuler"></input>
                </td>

            </TABLE>
        </td>
    <?php
    // </editor-fold>
    ?>
        <tr style="<?php echo($vspacing_tab); ?>"></tr>
    <?php
    // <editor-fold defaultstate="collapsed" desc="Billing address Tab">
    
try
{
   $query = $connectData->prepare('SELECT *
                                   FROM user
                                   INNER JOIN user_real
                                   ON user.id_user = user_real.id_user
                                   WHERE user.id_user = :id');
   $query->bindParam('id', htmlspecialchars($_SESSION['login_id'], ENT_QUOTES));
   $query->execute();
   
   if(($data = $query->fetch()) != false)
   {
      if(empty($data['title_real']) ? $title_cart_recap = '-' : $title_cart_recap = $data['title_real'])
      if(empty($data['first_name_real']) ? $firstname_cart_recap = '-' : $firstname_cart_recap = $data['first_name_real'])
      if(empty($data['name_real']) ? $lastname_cart_recap = '-' : $lastname_cart_recap = $data['name_real'])
      if(empty($data['name_company_real']) ? $company_cart_recap = '-' : $company_cart_recap = $data['name_company_real'])
      if(empty($data['phone_landline_real']) ? $landline_cart_recap = '-' : $landline_cart_recap = $data['phone_landline_real'])   
      if(empty($data['phone_mobile_real']) ? $mobile_cart_recap = '-' : $mobile_cart_recap = $data['phone_mobile_real'])  
      if(empty($data['address_real_1']) ? $address1_cart_recap = '-' : $address1_cart_recap = $data['address_real_1'])  
      if(empty($data['address_real_2']) ? $address2_cart_recap = '-' : $address2_cart_recap = $data['address_real_2'])  
      if(empty($data['ZIP_real']) ? $zip_cart_recap = '-' : $zip_cart_recap = $data['ZIP_real'])  
      if(empty($data['city_real']) ? $city_cart_recap = '-' : $city_cart_recap = $data['city_real']) 
      if(empty($data['email_user']) ? $email_cart_recap = '-' : $email_cart_recap = $data['email_user'])       
      
      if(!empty($data['other_country']))
      {
         $country_cart_recap = $data['other_country'];
      }
      else
      {
         $id_country_cart_recap = $data['id_country']; 
      }
   }
   $query->closeCursor();
   
   if(!empty($id_country_cart_recap))
   {
      $query = $connectData->prepare('SELECT name_country_L1
                                      FROM country
                                      WHERE id_country = :id');
      $query->bindParam('id', htmlspecialchars($id_country_cart_recap, ENT_QUOTES));
      $query->execute();
      
      if(($data = $query->fetch()) != false)
      {
          $country_cart_recap = $data[0];
      }
   }
   $query->closeCursor();
   
   $query = $connectData->prepare('SELECT *
                                   FROM user_address
                                   WHERE id_user = :id');
   $query->bindParam('id', htmlspecialchars($_SESSION['login_id'], ENT_QUOTES));
   $query->execute();
   
   $i = 2;
   
   while($data = $query->fetch())
   {
       $id_cart_billing_address_recap[$i] = $data['id_address'];
       if(empty($data['title_address']) ? $title_cart_other_address_recap[$i] = '-' : $title_cart_other_address_recap[$i] = $data['title_address'])
       if(empty($data['first_name_address']) ? $firstname_cart_other_address_recap[$i] = '-' : $firstname_cart_other_address_recap[$i] = $data['first_name_address'])
       if(empty($data['last_name_address']) ? $lastname_cart_other_address_recap[$i] = '-' : $lastname_cart_other_address_recap[$i] = $data['last_name_address'])
       if(empty($data['name_company_address']) ? $company_cart_other_address_recap[$i] = '-' : $company_cart_other_address_recap[$i] = $data['name_company_address'])
       if(empty($data['phone_landline_address']) ? $landline_cart_other_address_recap[$i] = '-' : $landline_cart_other_address_recap[$i] = $data['phone_landline_address'])   
       if(empty($data['phone_mobile_address']) ? $mobile_cart_other_address_recap[$i] = '-' : $mobile_cart_other_address_recap[$i] = $data['phone_mobile_address'])  
       if(empty($data['address_1_address']) ? $address1_cart_other_address_recap[$i] = '-' : $address1_cart_other_address_recap[$i] = $data['address_1_address'])  
       if(empty($data['address_2_address']) ? $address2_cart_other_address_recap[$i] = '-' : $address2_cart_other_address_recap[$i] = $data['address_2_address'])  
       if(empty($data['zip_address']) ? $zip_cart_other_address_recap[$i] = '-' : $zip_cart_other_address_recap[$i] = $data['zip_address'])  
       if(empty($data['city_address']) ? $city_cart_other_address_recap[$i] = '-' : $city_cart_other_address_recap[$i] = $data['city_address']) 
       if(empty($data['email_address']) ? $email_cart_other_address_recap[$i] = '-' : $email_cart_other_address_recap[$i] = $data['email_address']) 
       $i++;
   }
           
}
catch (Exception $e)
{
   die("<br>Error : ".$e->getMessage());
}
    ?>    
        <td> 
            <TABLE width="100%" cellpadding="0" cellspacing="0">
                <td colspan="2">
                    <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                        <td>
                            <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">Adresse de facturation</span>
                        </td>
                    </TABLE>
                </td>

                <tr style="height: 6px;"></tr>

                <td style="vertical-align: top;">
                    <input style="margin-top: 7px; cursor: pointer;" type="radio" id="rad_billing_address_1" name="rad_billing_address" value="1" <?php if(empty($_SESSION['recap_cart_rad_billing']) || $_SESSION['recap_cart_rad_billing'] == 1){ echo('checked'); unset($_SESSION['cart_recap_billing_rad']); }else{ echo(null); } ?>></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_billing_address_1"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px;" cellpadding="0" cellspacing="0" border="0">

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($company_cart_recap); ?></span>
                        </td>
                        
                        <td>
                            <span style="margin-left: 4px;" id="center_text">Tel. fixe: <?php echo($landline_cart_recap); ?></span>
                        </td>
                        
                        <tr></tr>
                        
                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo(upper_firstchar($title_cart_recap).' '.$firstname_cart_recap.' '.$lastname_cart_recap); ?></span>
                        </td>
                        
                        <td>
                            <span style="margin-left: 4px;" id="center_text">Tel. mobile: <?php echo($mobile_cart_recap); ?></span>
                        </td>

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($address1_cart_recap); ?></span>
                        </td>
                        
                        <td>
                            <span style="margin-left: 4px;" id="center_text">Email: <?php echo($email_cart_recap); ?></span>
                        </td>  

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($address2_cart_recap); ?></span>
                        </td>                                       

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($zip_cart_recap.' '.$city_cart_recap); ?></span>
                        </td>
                        <td></td>

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo(@$country_cart_recap); ?></span>
                        </td>
                        <td></td>

                    </TABLE></LABEL>  
                </td>
<?php
for($i = 2; $i < (count($title_cart_other_address_recap) + 2); $i++)
{
?>
                <tr style="height: 6px;"></tr>

                <td style="vertical-align: top;">
                    <input style="margin-top: 7px; cursor: pointer;" id="rad_billing_address_<?php echo($i); ?>" type="radio" name="rad_billing_address" value="<?php echo($i); ?>" <?php if(!empty($_SESSION['recap_cart_rad_billing']) && $_SESSION['recap_cart_rad_billing'] == $i){ echo('checked'); $_SESSION['cart_recap_billing_rad'] = $id_cart_billing_address_recap[$i]; }else{ echo(null); } ?>></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_billing_address_<?php echo($i); ?>"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px;" cellpadding="0" cellspacing="0" border="0">

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($company_cart_other_address_recap[$i]); ?></span>
                        </td>
                        
                        <td>
                            <span style="margin-left: 4px;" id="center_text">Tel. fixe: <?php echo($landline_cart_other_address_recap[$i]); ?></span>
                        </td>
                        
                        <tr></tr>
                        
                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo(upper_firstchar($title_cart_other_address_recap[$i]).' '.$firstname_cart_other_address_recap[$i].' '.$lastname_cart_other_address_recap[$i]); ?></span>
                        </td>
                        
                        <td>
                            <span style="margin-left: 4px;" id="center_text">Tel. mobile: <?php echo($mobile_cart_other_address_recap[$i]); ?></span>
                        </td>

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($address1_cart_other_address_recap[$i]); ?></span>
                        </td>
                        
                        <td>
                            <span style="margin-left: 4px;" id="center_text">Email: <?php echo($email_cart_other_address_recap[$i]); ?></span>
                        </td>  

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($address2_cart_other_address_recap[$i]); ?></span>
                        </td>                                       

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($zip_cart_other_address_recap[$i].' '.$city_cart_other_address_recap[$i]); ?></span>
                        </td>
                        <td></td>

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo(null); ?></span>
                        </td>
                        <td></td>

                    </TABLE></LABEL>  
                </td>
<?php
}
if(isset($_GET['addAB']) && $_GET['addAB'] == 'true')
{
    $_SESSION['recap_cart_rad_billing'] = $i;
}
?>

                <tr style="height: 6px;"></tr>

                <td style="vertical-align: top;">
                    <input style="margin-top: 7px; cursor: pointer;" type="radio" id="rad_billing_address_<?php echo($i); ?>" name="rad_billing_address" value="<?php echo($i); ?>" <?php if(!empty($_SESSION['recap_cart_rad_billing']) && $_SESSION['recap_cart_rad_billing'] == $i){ echo('checked'); unset($_SESSION['cart_recap_billing_rad']); }else{ echo(null); } ?>></input>
                </td>
                <td width="100%">
                    
<?php
                if(isset($_GET['addAB']) || empty($_SESSION['recap_cart_first_loading_billing']))
                {
                    $_SESSION['recap_cart_first_loading_billing'] = false;
                    if((isset($_GET['addAB']) && $_GET['addAB'] == 'true') || (!empty($_SESSION['recap_cart_add_address_billing']) && $_SESSION['recap_cart_add_address_billing'] == true))
                    {                         
                        $_SESSION['recap_cart_add_address_billing'] = true;
?>
                        <TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px;" cellpadding="0" cellspacing="0" border="0">

                            <td>
                                <span id="center_subtitle">Titre</span>
                            </td>                  

                            <td>
                                <SELECT name="cboTitleBilling">
                                    <option value="mr" <?php if(empty($_SESSION['cart_recap_billing_title']) || $_SESSION['cart_recap_billing_title'] == 'mr'){ echo('selected'); }else{ echo(null); } ?>>Mr</option>
                                    <option value="mme" <?php if(!empty($_SESSION['cart_recap_billing_title']) && $_SESSION['cart_recap_billing_title'] == 'mme'){ echo('selected'); }else{ echo(null); } ?>>Mme</option>
                                    <option value="mlle" <?php if(!empty($_SESSION['cart_recap_billing_title']) && $_SESSION['cart_recap_billing_title'] == 'mlle'){ echo('selected'); }else{ echo(null); } ?>>Mlle</option>
                                    <option value="ste" <?php if(!empty($_SESSION['cart_recap_billing_title']) && $_SESSION['cart_recap_billing_title'] == 'ste'){ echo('selected'); }else{ echo(null); } ?>>Sté</option>
                                </SELECT>                        
                            </td>

                            <tr></tr>

                            <td>
                                <span id="center_subtitle">Prénom</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtFirstNameBilling" value="<?php if(!empty($_SESSION['cart_recap_billing_txtFirstName'])){ echo($_SESSION['cart_recap_billing_txtFirstName']); }else{ echo(null); } ?>"></input> 
                                &nbsp;
                                <span id="center_subtitle">Nom</span>
                                &nbsp;
                                <input type="text" name="txtNameBilling" value="<?php if(!empty($_SESSION['cart_recap_billing_txtName'])){ echo($_SESSION['cart_recap_billing_txtName']); }else{ echo(null); } ?>"></input>
                                <br clear="left"><span id="msg_wrong_user_add">
<?php 
                                if(!empty($_SESSION['confirm_error_firstname_cart_recap_billing']) && !empty($_SESSION['confirm_error_name_cart_recap_billing']))
                                {
                                    echo(check_session_input(@$_SESSION['confirm_error_firstname_cart_recap_billing']).' | '.check_session_input(@$_SESSION['confirm_error_name_cart_recap_billing']));
                                }
                                else
                                {
                                    if(!empty($_SESSION['confirm_error_firstname_cart_recap_billing']))
                                    {
                                        echo(check_session_input(@$_SESSION['confirm_error_firstname_cart_recap_billing']));
                                    }
                                    else
                                    {
                                        echo(check_session_input(@$_SESSION['confirm_error_name_cart_recap_billing']));
                                    }
                                }
?>
                                </span>
                            </td>

                            <tr></tr>

                            <tr></tr>

                            <td>
                                <span id="center_subtitle">Société</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtCompanyBilling" value="<?php if(!empty($_SESSION['cart_recap_billing_txtCompany'])){ echo($_SESSION['cart_recap_billing_txtCompany']); }else{ echo(null); } ?>"></input>                        
                            </td>

                            <tr></tr>

                            <td>
                                <span id="center_subtitle">Adresse 1</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtAddress1Billing" value="<?php if(!empty($_SESSION['cart_recap_billing_txtAddress1'])){ echo($_SESSION['cart_recap_billing_txtAddress1']); }else{ echo(null); } ?>"></input>                        
                                <br clear="left"><span id="msg_wrong_user_add"><?php echo(check_session_input(@$_SESSION['confirm_error_address1_cart_recap_billing'])); ?></span>
                            </td>

                            <tr></tr>

                            <td>
                                <span id="center_subtitle">Adresse 2</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtAddress2Billing" value="<?php if(!empty($_SESSION['cart_recap_billing_txtAddress2'])){ echo($_SESSION['cart_recap_billing_txtAddress2']); }else{ echo(null); } ?>"></input>                        
                            </td>

                            <tr></tr>

                            <td>
                                <span id="center_subtitle">Code Postal</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtPCBilling" value="<?php if(!empty($_SESSION['cart_recap_billing_txtZIP'])){ echo($_SESSION['cart_recap_billing_txtZIP']); }else{ echo(null); } ?>"></input> 
                                &nbsp;
                                <span id="center_subtitle">Ville</span>
                                &nbsp;
                                <input type="text" name="txtCityBilling" value="<?php if(!empty($_SESSION['cart_recap_billing_txtCity'])){ echo($_SESSION['cart_recap_billing_txtCity']); }else{ echo(null); } ?>"></input> 
                                <br clear="left"><span id="msg_wrong_user_add">
                                <?php 
                                if(!empty($_SESSION['confirm_error_zip_cart_recap_billing']) && !empty($_SESSION['confirm_error_city_cart_recap_billing']))
                                {
                                    echo(check_session_input(@$_SESSION['confirm_error_zip_cart_recap_billing']).' | '.check_session_input(@$_SESSION['confirm_error_city_cart_recap_billing']));
                                }
                                else
                                {
                                    if(!empty($_SESSION['confirm_error_zip_cart_recap_billing']))
                                    {
                                        echo(check_session_input(@$_SESSION['confirm_error_zip_cart_recap_billing']));
                                    }
                                    else
                                    {
                                        echo(check_session_input(@$_SESSION['confirm_error_city_cart_recap_billing']));
                                    }
                                }
?>
                                </span>
                            </td>

                            <tr></tr>

                            <td>
                                <span id="center_subtitle">Pays</span>
                            </td>                  

                            <td>
                                <SELECT id="cboCountryBilling" name="cboCountryBilling" onchange="check_dropdown_registration('cboCountryBilling', 'other_country1', 'other_country2', <?php echo($count_country_recap); ?>)" onsubmit="check_dropdown_registration_onsubmit('cboCountryBilling', 'other_country1', 'other_country2', <?php echo($count_country_recap); ?>)" onload="check_dropdown_registration_onload('cboCountryBilling', 'other_country1', 'other_country2', <?php echo($count_country_recap); ?>)">                                  
<?php
try
{
    $query = $connectData->query('SELECT id_country, code_country, 
                                         name_country_L1, authorized_shipment
                                  FROM country WHERE authorized_shipment = 1
                                  ORDER BY authorized_shipment DESC, name_country_L1');
    
    while($data = $query->fetch())
    {             
        echo('<option value="'.$data[0].'" ');
        
        if(!empty($_SESSION['cart_recap_billing_selected_country']) && $data[0] == $_SESSION['cart_recap_billing_selected_country'])
        {
            echo('selected');
        }
        else
        {
            echo(null);
        }
        
        if(strlen($data[2]) > 30)
        {
            echo('>'.substr($data[2], 0, 30).'...'.'</option>');
        }
        else
        {
            echo('>'.$data[2].'</option>');
        }    
    }
    
}
catch(Exception $e)
{
    die("Error : ".$e->getMessage());
}
?>
                                    <option value="<?php echo($count_country_recap); ?>" <?php if(!empty($_SESSION['cart_recap_billing_selected_country']) && $_SESSION['cart_recap_billing_selected_country'] == $count_country_recap){ echo('selected'); }else{ echo(null); } ?>>Autre pays</option>
                                </SELECT> 
                            </td>
                            
                            <tr id="other_country2" style="display: none;"></tr>                            

                            <td colspan="2">
                                <TABLE style="display: none;" cellpadding="0" cellspacing="0" id="other_country1">
                                    <td><label id="center_subtitle" for="txtOtherCountryBilling">Indiquez votre pays&nbsp;</label></td>
                                    <td>
                                        <input style="width: 250px;" type="text" name="txtOtherCountryBilling" value="<?php if(!empty($_SESSION['cart_recap_billing_txtOtherCountry'])){ echo($_SESSION['cart_recap_billing_txtOtherCountry']); }else{ echo(null); } ?>"></input>
                                        <br clear="left"><span id="msg_wrong_user_add"><?php echo(check_session_input(@$_SESSION['confirm_error_country_cart_recap_billing'])); ?></span>
                                    </td>
                                </TABLE>
                            </td>
                            
                            <!--[if lte IE 7]>
                            <tr></tr>                            

                            <td colspan="2">
                                <TABLE cellpadding="0" cellspacing="0">
                                    <td><label id="center_subtitle" for="txtOtherCountryBilling">Indiquez votre pays&nbsp;</label></td>
                                    <td>
                                        <input style="width: 250px;" type="text" name="txtOtherCountryBilling" value="<?php if(!empty($_SESSION['cart_recap_billing_txtOtherCountry'])){ echo($_SESSION['cart_recap_billing_txtOtherCountry']); }else{ echo(null); } ?>"></input>
                                        <br clear="left"><span id="msg_wrong_user_add"><?php echo(check_session_input(@$_SESSION['confirm_error_country_cart_recap_billing'])); ?></span>
                                    </td>
                                </TABLE>
                            </td>
                            <![endif]-->
                            
                            
                            <tr></tr>
                            
                            <td>
                                <span id="center_subtitle">Tel. fixe</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtLandlineBilling" value="<?php if(!empty($_SESSION['cart_recap_billing_txtLandline'])){ echo($_SESSION['cart_recap_billing_txtLandline']); }else{ echo(null); } ?>"></input>                        
                            </td>
                            
                            <tr></tr>
                            
                            <td>
                                <span id="center_subtitle">Tel. mobile</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtMobileBilling" value="<?php if(!empty($_SESSION['cart_recap_billing_txtMobile'])){ echo($_SESSION['cart_recap_billing_txtMobile']); }else{ echo(null); } ?>"></input>                        
                            </td>
                            
                            <tr></tr>
                            
                            <td>
                                <span id="center_subtitle">Email</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtEmailBilling" value="<?php if(!empty($_SESSION['cart_recap_billing_txtEmail'])){ echo($_SESSION['cart_recap_billing_txtEmail']); }else{ echo(null); } ?>"></input>                        
                                <br clear="left"><span id="msg_wrong_user_add"><?php echo(check_session_input(@$_SESSION['confirm_error_email_cart_recap_billing'])); ?></span>
                            </td>
                            
                            <tr style="height: 6px;"></tr>
                            
                            <td colspan="2" align="center">
                                <input type="submit" name="bt_new_address_billing" value="Ajouter adresse"></input>
                            </td>

                        </TABLE>
<?php
                    }
                    else
                    {  
                        $_SESSION['recap_cart_add_address_billing'] = false;
?>
                        <LABEL for="rad_billing_address_<?php echo($i); ?>"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px;" cellpadding="0" cellspacing="0" border="0">
                        <td>
                            <a href="index.php?page=recap_cart&addAB=true" id="link">Ajouter une adresse</a>
                        </td> 
                        </TABLE></LABEL>
<?php        
                    }                   
                }
?>
                    
                        
                        
                          
                </td>



            </TABLE>
        </td>
    <?php
    // </editor-fold>
    ?>
        <tr style="<?php echo($vspacing_tab); ?>"></tr>
    <?php
    // <editor-fold defaultstate="collapsed" desc="Delivery address Tab">
    ?>    
        <td>  
            <TABLE width="100%" cellpadding="0" cellspacing="0">
                <td colspan="2">
                    <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                        <td>
                            <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">Adresse de livraison</span>
                        </td>
                    </TABLE>
                </td>

                <tr style="height: 6px;"></tr>

                <td style="vertical-align: top;">
                    <input style="margin-top: 7px; cursor: pointer;" id="rad_delivery_address_1" type="radio" name="rad_delivery_address" value="1" <?php if(empty($_SESSION['recap_cart_rad_delivery']) || $_SESSION['recap_cart_rad_delivery'] == 1){ echo('checked'); }else{ echo(null); } ?>></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_delivery_address_1"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px;" cellpadding="0" cellspacing="0" border="0">

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($company_cart_recap); ?></span>
                        </td>
                        
                        <td>
                            <span style="margin-left: 4px;" id="center_text">Tel. fixe: <?php echo($landline_cart_recap); ?></span>
                        </td>
                        
                        <tr></tr>
                        
                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo(upper_firstchar($title_cart_recap).' '.$firstname_cart_recap.' '.$lastname_cart_recap); ?></span>
                        </td>
                        
                        <td>
                            <span style="margin-left: 4px;" id="center_text">Tel. mobile: <?php echo($mobile_cart_recap); ?></span>
                        </td>

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($address1_cart_recap); ?></span>
                        </td>
                        
                        <td>
                            <span style="margin-left: 4px;" id="center_text">Email: <?php echo($email_cart_recap); ?></span>
                        </td>  

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($address2_cart_recap); ?></span>
                        </td>                                       

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($zip_cart_recap.' '.$city_cart_recap); ?></span>
                        </td>
                        <td></td>

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo(@$country_cart_recap); ?></span>
                        </td>
                        <td></td>

                    </TABLE></LABEL>  
                </td>

<?php
for($i = 2; $i < (count($title_cart_other_address_recap) + 2); $i++)
{
?>
                <tr style="height: 6px;"></tr>

                <td style="vertical-align: top;">
                    <input style="margin-top: 7px; cursor: pointer;" id="rad_delivery_address_<?php echo($i); ?>" type="radio" name="rad_delivery_address" value="<?php echo($i); ?>" <?php if(!empty($_SESSION['recap_cart_rad_delivery']) && $_SESSION['recap_cart_rad_delivery'] == $i){ echo('checked'); }else{ echo(null); } ?>></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_delivery_address_<?php echo($i); ?>"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px;" cellpadding="0" cellspacing="0" border="0">

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($company_cart_other_address_recap[$i]); ?></span>
                        </td>
                        
                        <td>
                            <span style="margin-left: 4px;" id="center_text">Tel. fixe: <?php echo($landline_cart_other_address_recap[$i]); ?></span>
                        </td>
                        
                        <tr></tr>
                        
                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo(upper_firstchar($title_cart_other_address_recap[$i]).' '.$firstname_cart_other_address_recap[$i].' '.$lastname_cart_other_address_recap[$i]); ?></span>
                        </td>
                        
                        <td>
                            <span style="margin-left: 4px;" id="center_text">Tel. mobile: <?php echo($mobile_cart_other_address_recap[$i]); ?></span>
                        </td>

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($address1_cart_other_address_recap[$i]); ?></span>
                        </td>
                        
                        <td>
                            <span style="margin-left: 4px;" id="center_text">Email: <?php echo($email_cart_other_address_recap[$i]); ?></span>
                        </td>  

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($address2_cart_other_address_recap[$i]); ?></span>
                        </td>                                       

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo($zip_cart_other_address_recap[$i].' '.$city_cart_other_address_recap[$i]); ?></span>
                        </td>
                        <td></td>

                        <tr></tr>

                        <td style="border-right: 1px solid lightgray;">
                            <span id="center_text"><?php echo(null); ?></span>
                        </td>
                        <td></td>

                    </TABLE></LABEL>  
                </td>
<?php
}

if(isset($_GET['addAD']) && $_GET['addAD'] == 'true')
{
    $_SESSION['recap_cart_rad_delivery'] = $i;
}
?>

                <tr style="height: 6px;"></tr>

                <td style="vertical-align: top;">
                    <input style="margin-top: 7px; cursor: pointer;" type="radio" id="rad_delivery_address_<?php echo($i); ?>" name="rad_delivery_address" value="<?php echo($i); ?>" <?php if(!empty($_SESSION['recap_cart_rad_delivery']) && $_SESSION['recap_cart_rad_delivery'] == $i){ echo('checked'); }else{ echo(null); } ?>></input>
                </td>
                <td width="100%">
<?php
                if(isset($_GET['addAD']) || empty($_SESSION['recap_cart_first_loading_delivery']))
                {
                    $_SESSION['recap_cart_first_loading_delivery'] = false;
                    if((isset($_GET['addAD']) && $_GET['addAD'] == 'true') || (!empty($_SESSION['recap_cart_add_address_delivery']) && $_SESSION['recap_cart_add_address_delivery'] == true))
                    { 
                        $_SESSION['recap_cart_add_address_delivery'] = true;
?>
                        <TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px;" cellpadding="0" cellspacing="0" border="0">

                            <td>
                                <span id="center_subtitle">Titre</span>
                            </td>                  

                            <td>
                                <SELECT name="cboTitleDelivery">
                                    <option value="mr" <?php if(empty($_SESSION['cart_recap_delivery_title']) || $_SESSION['cart_recap_delivery_title'] == 'mr'){ echo('selected'); }else{ echo(null); } ?>>Mr</option>
                                    <option value="mme" <?php if(!empty($_SESSION['cart_recap_delivery_title']) && $_SESSION['cart_recap_delivery_title'] == 'mme'){ echo('selected'); }else{ echo(null); } ?>>Mme</option>
                                    <option value="mlle" <?php if(!empty($_SESSION['cart_recap_delivery_title']) && $_SESSION['cart_recap_delivery_title'] == 'mlle'){ echo('selected'); }else{ echo(null); } ?>>Mlle</option>
                                    <option value="ste" <?php if(!empty($_SESSION['cart_recap_delivery_title']) && $_SESSION['cart_recap_delivery_title'] == 'ste'){ echo('selected'); }else{ echo(null); } ?>>Sté</option>
                                </SELECT>                        
                            </td>

                            <tr></tr>

                            <td>
                                <span id="center_subtitle">Prénom</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtFirstNameDelivery" value="<?php if(!empty($_SESSION['cart_recap_delivery_txtFirstName'])){ echo($_SESSION['cart_recap_delivery_txtFirstName']); }else{ echo(null); } ?>"></input> 
                                &nbsp;
                                <span id="center_subtitle">Nom</span>
                                &nbsp;
                                <input type="text" name="txtNameDelivery" value="<?php if(!empty($_SESSION['cart_recap_delivery_txtName'])){ echo($_SESSION['cart_recap_delivery_txtName']); }else{ echo(null); } ?>"></input>   
                                <br clear="left"><span id="msg_wrong_user_add">
<?php 
                                if(!empty($_SESSION['confirm_error_firstname_cart_recap_delivery']) && !empty($_SESSION['confirm_error_name_cart_recap_delivery']))
                                {
                                    echo(check_session_input(@$_SESSION['confirm_error_firstname_cart_recap_delivery']).' | '.check_session_input(@$_SESSION['confirm_error_name_cart_recap_delivery']));
                                }
                                else
                                {
                                    if(!empty($_SESSION['confirm_error_firstname_cart_recap_delivery']))
                                    {
                                        echo(check_session_input(@$_SESSION['confirm_error_firstname_cart_recap_delivery']));
                                    }
                                    else
                                    {
                                        echo(check_session_input(@$_SESSION['confirm_error_name_cart_recap_delivery']));
                                    }
                                }
?>
                                </span>                            
                            </td>

                            <tr></tr>

                            <tr></tr>

                            <td>
                                <span id="center_subtitle">Société</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtCompanyDelivery" value="<?php if(!empty($_SESSION['cart_recap_delivery_txtCompany'])){ echo($_SESSION['cart_recap_delivery_txtCompany']); }else{ echo(null); } ?>"></input>                        
                            </td>

                            <tr></tr>

                            <td>
                                <span id="center_subtitle">Adresse 1</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtAddress1Delivery" value="<?php if(!empty($_SESSION['cart_recap_delivery_txtAddress1'])){ echo($_SESSION['cart_recap_delivery_txtAddress1']); }else{ echo(null); } ?>"></input>                        
                                <br clear="left"><span id="msg_wrong_user_add"><?php echo(check_session_input(@$_SESSION['confirm_error_address1_cart_recap_delivery'])); ?></span>
                            </td>

                            <tr></tr>

                            <td>
                                <span id="center_subtitle">Adresse 2</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtAddress2Delivery" value="<?php if(!empty($_SESSION['cart_recap_delivery_txtAddress2'])){ echo($_SESSION['cart_recap_delivery_txtAddress2']); }else{ echo(null); } ?>"></input>                        
                            </td>

                            <tr></tr>

                            <td>
                                <span id="center_subtitle">Code Postal</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtPCDelivery" value="<?php if(!empty($_SESSION['cart_recap_delivery_txtZIP'])){ echo($_SESSION['cart_recap_delivery_txtZIP']); }else{ echo(null); } ?>"></input> 
                                &nbsp;
                                <span id="center_subtitle">Ville</span>
                                &nbsp;
                                <input type="text" name="txtCityDelivery" value="<?php if(!empty($_SESSION['cart_recap_delivery_txtCity'])){ echo($_SESSION['cart_recap_delivery_txtCity']); }else{ echo(null); } ?>"></input> 
                                <br clear="left"><span id="msg_wrong_user_add">
                                <?php 
                                if(!empty($_SESSION['confirm_error_zip_cart_recap_delivery']) && !empty($_SESSION['confirm_error_city_cart_recap_delivery']))
                                {
                                    echo(check_session_input(@$_SESSION['confirm_error_zip_cart_recap_delivery']).' | '.check_session_input(@$_SESSION['confirm_error_city_cart_recap_delivery']));
                                }
                                else
                                {
                                    if(!empty($_SESSION['confirm_error_zip_cart_recap_delivery']))
                                    {
                                        echo(check_session_input(@$_SESSION['confirm_error_zip_cart_recap_delivery']));
                                    }
                                    else
                                    {
                                        echo(check_session_input(@$_SESSION['confirm_error_city_cart_recap_delivery']));
                                    }
                                }
?>
                                </span>
                            </td>

                            <tr></tr>

                            <td>
                                <span id="center_subtitle">Pays</span>
                            </td>                  

                            <td>
                                <SELECT id="cboCountryDelivery" name="cboCountryDelivery" onchange="check_dropdown_registration('cboCountryDelivery', 'other_country4', 'other_country3', <?php echo($count_country_recap); ?>)" onsubmit="check_dropdown_registration_onsubmit('cboCountryDelivery', 'other_country4', 'other_country3', <?php echo($count_country_recap); ?>)" onload="check_dropdown_registration_onload('cboCountryDelivery', 'other_country4', 'other_country3', <?php echo($count_country_recap); ?>)">
                                    
<?php
try
{
    $query = $connectData->query('SELECT id_country, code_country, 
                                         name_country_L1, authorized_shipment
                                  FROM country WHERE authorized_shipment = 1
                                  ORDER BY authorized_shipment DESC, name_country_L1');
    
    while($data = $query->fetch())
    {             
        echo('<option value="'.$data[0].'" ');
        
        if(!empty($_SESSION['cart_recap_delivery_selected_country']) && $data[0] == $_SESSION['cart_recap_delivery_selected_country'])
        {
            echo('selected');
        }
        else
        {
            echo(null);
        }
        
        if(strlen($data[2]) > 30)
        {
            echo('>'.substr($data[2], 0, 30).'...'.'</option>');
        }
        else
        {
            echo('>'.$data[2].'</option>');
        }    
    }
    
}
catch(Exception $e)
{
    die("Error : ".$e->getMessage());
}
?>
                                    <option value="<?php echo($count_country_recap); ?>" <?php if(!empty($_SESSION['cart_recap_delivery_selected_country']) && $_SESSION['cart_recap_delivery_selected_country'] == $count_country_recap){ echo('selected'); }else{ echo(null); } ?>>Autre pays</option>
                                </SELECT> 
                            </td>
                            
                            <tr id="other_country4" style="display: none;"></tr>                            

                            <td colspan="2">
                                <TABLE style="display: none;" cellpadding="0" cellspacing="0" id="other_country3">
                                    <td><label id="center_subtitle" for="txtOtherCountryDelivery">Indiquez votre pays&nbsp;</label></td>
                                    <td>
                                        <input style="width: 250px;" type="text" name="txtOtherCountryDelivery" value="<?php if(!empty($_SESSION['cart_recap_delivery_txtOtherCountry'])){ echo($_SESSION['cart_recap_delivery_txtOtherCountry']); }else{ echo(null); } ?>"></input>
                                        <br clear="left"><span id="msg_wrong_user_add"><?php echo(check_session_input(@$_SESSION['confirm_error_country_cart_recap_delivery'])); ?></span>
                                    </td>
                                </TABLE>
                            </td>
                            
                            <!--[if lte IE 7]>
                            <tr></tr>                            

                            <td colspan="2">
                                <TABLE cellpadding="0" cellspacing="0">
                                    <td><label id="center_subtitle" for="txtOtherCountryDelivery">Indiquez votre pays&nbsp;</label></td>
                                    <td>
                                        <input style="width: 250px;" type="text" name="txtOtherCountryDelivery" value="<?php if(!empty($_SESSION['cart_recap_delivery_txtOtherCountry'])){ echo($_SESSION['cart_recap_delivery_txtOtherCountry']); }else{ echo(null); } ?>"></input>
                                        <br clear="left"><span id="msg_wrong_user_add"><?php echo(check_session_input(@$_SESSION['confirm_error_country_cart_recap_delivery'])); ?></span>
                                    </td>
                                </TABLE>
                            </td>
                            <![endif]-->
                            
                            <tr></tr>
                            
                            <td>
                                <span id="center_subtitle">Tel. fixe</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtLandlineDelivery" value="<?php if(!empty($_SESSION['cart_recap_delivery_txtLandline'])){ echo($_SESSION['cart_recap_delivery_txtLandline']); }else{ echo(null); } ?>"></input>                        
                            </td>
                            
                            <tr></tr>
                            
                            <td>
                                <span id="center_subtitle">Tel. mobile</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtMobileDelivery" value="<?php if(!empty($_SESSION['cart_recap_delivery_txtMobile'])){ echo($_SESSION['cart_recap_delivery_txtMobile']); }else{ echo(null); } ?>"></input>                        
                            </td>
                            
                            <tr></tr>
                            
                            <td>
                                <span id="center_subtitle">Email</span>
                            </td>                  

                            <td>                   
                                <input type="text" name="txtEmailDelivery" value="<?php if(!empty($_SESSION['cart_recap_delivery_txtEmail'])){ echo($_SESSION['cart_recap_delivery_txtEmail']); }else{ echo(null); } ?>"></input>                        
                                <br clear="left"><span id="msg_wrong_user_add"><?php echo(check_session_input(@$_SESSION['confirm_error_email_cart_recap_billing'])); ?></span>
                            </td>
                            
                            <tr style="height: 6px;"></tr>
                            
                            <td colspan="2" align="center">
                                <input type="submit" name="bt_new_address_delivery" value="Ajouter adresse"></input>
                            </td>

                        </TABLE>                  
<?php
                    }
                    else
                    { 
                        $_SESSION['recap_cart_add_address_delivery'] = false;
?>
                        <LABEL for="rad_delivery_address_<?php echo($i); ?>"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px;" cellpadding="0" cellspacing="0" border="0">
                        <td>
                            <a href="index.php?page=recap_cart&addAD=true" id="link">Ajouter une adresse</a>
                        </td> 
                        </TABLE></LABEL>
<?php        
                    }                   
                }
?>  
                </td>

            </TABLE>
        </td>
    <?php
    // </editor-fold>
    ?>    
        <tr style="<?php echo($vspacing_tab); ?>"></tr>
    <?php
    // <editor-fold defaultstate="collapsed" desc="Payment Method Tab">
    
    if($online_payment_destination == 1)
    {
    ?>
        <tr style="height: 6px;"></tr> 
        
        <td> 
            <TABLE width="100%" cellpadding="0" cellspacing="0">
                <td colspan="2">
                    <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                        <td>
                            <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">Mode de paiement</span>
                        </td>
                    </TABLE>
                </td>

                
<?php
            if(($cart_type_real == 'reseller' || $_SESSION['autorisation'] == true) && empty($_SESSION['cart_cash_discount_ok']))
            {
//                if($pickup_destination == 0)
//                {
?>
                <tr></tr>
                
                <td style="vertical-align: top;">
                    <input style="margin-top: 7px;" id="rad_choose_payment_1" type="radio" name="rad_choose_payment" value="bank_transfer" checked="true"></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_choose_payment_1"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px; cursor: pointer;" cellpadding="0" cellspacing="0" border="0">
                        <td>
                            <span id="center_text">Par virement bancaire sous <?php echo($user_add_reseller_creditdelay); ?> jours</span>
                        </td>                    
                    </TABLE></LABEL>
                </td>
                
                <tr></tr>
                
                <td style="vertical-align: top;">
                    <input style="margin-top: 7px;" id="rad_choose_payment_2" type="radio" name="rad_choose_payment" value="bank_check"></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_choose_payment_2"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px; cursor: pointer;" cellpadding="0" cellspacing="0" border="0">
                        <td>
                            <span id="center_text">Par chèque bancaire sous <?php echo($user_add_reseller_creditdelay); ?> jours</span>
                        </td>                    
                    </TABLE></LABEL>
                </td>
                
                <tr></tr>
                
                <td style="vertical-align: top;">
                    <input style="margin-top: 7px;" id="rad_choose_payment_3" type="radio" name="rad_choose_payment" value="cash_credit"></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_choose_payment_3"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px; cursor: pointer;" cellpadding="0" cellspacing="0" border="0">
                        <td>
                            <span id="center_text">Par carte bancaire sur notre site via Paybox sous <?php echo($user_add_reseller_creditdelay); ?> jours</span>
                        </td>                    
                    </TABLE></LABEL>
                </td>
<?php
//                }
            }
            else
            {
?>
                <tr></tr>
                
                <td style="vertical-align: top;">
                    <input style="margin-top: 7px;" id="rad_choose_payment_1" type="radio" name="rad_choose_payment" value="CB" checked="true"></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_choose_payment_1"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px; cursor: pointer;" cellpadding="0" cellspacing="0" border="0">
                        <td>
                            <span id="center_subtitle">Par carte bancaire </span><span id="center_text">(expédition immédiate de votre commande)</span>
                        </td>                    
                    </TABLE></LABEL>
                </td>
                
                <tr></tr>
                
                <td style="vertical-align: top;">
                    <input style="margin-top: 7px;" id="rad_choose_payment_2" type="radio" name="rad_choose_payment" value="bank_check"></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_choose_payment_2"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px; cursor: pointer;" cellpadding="0" cellspacing="0" border="0">
                        <td>
                            <span id="center_subtitle">Par chèque bancaire </span><span id="center_text">(expédition de votre commande après réception du chèque)</span>
                        </td>                    
                    </TABLE></LABEL>
                </td>
                
                <tr></tr>
                
                <td style="vertical-align: top;">
                    <input style="margin-top: 7px;" id="rad_choose_payment_1" type="radio" name="rad_choose_payment" value="bank_transfer"></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_choose_payment_1"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px; cursor: pointer;" cellpadding="0" cellspacing="0" border="0">
                        <td>
                            <span id="center_subtitle">Par virement bancaire </span><span id="center_text">(expédition de votre commande après transfert du virement)</span>
                        </td>                    
                    </TABLE></LABEL>
                </td>

<?php
            }
?>
<!--                <tr></tr>

                <td style="vertical-align: top;">
                    <input style="margin-top: 7px;" id="rad_choose_payment_2" type="radio" name="rad_choose_payment" value="2"></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_choose_payment_2"><TABLE width="100%" style="<?php //echo($list_box); ?> padding: 4px; cursor: pointer;" cellpadding="0" cellspacing="0" border="0">
                        <td>
                            <span id="center_subtitle">Par PayPal</span>
                        </td>                    
                    </TABLE></LABEL>
                </td>-->

<!--                <tr></tr>

                <td style="vertical-align: top;">
                    <input style="margin-top: 7px;" id="rad_choose_payment_3" type="radio" name="rad_choose_payment" value="3"></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_choose_payment_3"><TABLE width="100%" style="<?php //echo($list_box); ?> padding: 4px; cursor: pointer;" cellpadding="0" cellspacing="0" border="0">
                        <td>
                            <span id="center_subtitle">Par Kwixo</span>
                        </td>                    
                    </TABLE></LABEL>
                </td>-->
<?php
            if($pickup_destination == 1)
            {
?>
                <tr></tr>

                <td style="vertical-align: top;">
                    <input style="margin-top: 7px;" id="rad_choose_payment_6" type="radio" name="rad_choose_payment" value="cash" <?php if(!empty($_SESSION['recap_cart_rad_payment']) && $_SESSION['recap_cart_rad_payment'] == 6){ echo('checked'); }else{ echo(null); } ?>></input>
                </td>
                <td width="100%">
                    <LABEL for="rad_choose_payment_6"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px; cursor: pointer;" cellpadding="0" cellspacing="0" border="0">
                        <td>
                            <span id="center_subtitle">En espèce à la récupération au dépôt</span>
                        </td>                    
                    </TABLE></LABEL>
                </td>
                
<?php
            }
?>
            </TABLE>
      </td>           
            
<?php

    }
    else
    {
?>
              <tr style="height: 6px;"></tr> 
              
              <td> 
                <TABLE width="100%" cellpadding="0" cellspacing="0">
                    <td colspan="2">
                        <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                            <td>
                                <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">Mode de paiement</span>
                            </td>
                        </TABLE>
                    </td>

                    <tr></tr>

                    <td style="vertical-align: top;">
                        <input style="margin-top: 7px;" id="rad_choose_payment_1" type="radio" name="rad_choose_payment" value="reunion" checked="true"></input>
                    </td>
                    <td width="100%">
                        <LABEL for="rad_choose_payment_1"><TABLE width="100%" style="<?php echo($list_box); ?> padding: 4px; cursor: pointer;" cellpadding="0" cellspacing="0" border="0">
                            <td>
                                <span id="center_text">Vous serez contacté par </span>
                                <span id="center_subtitle">Lux Réunion</span>
                                <span id="center_text">dans les plus brefs délais</span>
                            </td>                    
                        </TABLE></LABEL>
                    </td>
                </TABLE>
            </td> 
                
<?php                
    }
?>
                   
                <tr style="height: 6px;"></tr>

                <td colspan="6" style="border-bottom: 1px solid lightgray;"><span></span></td>

                <tr style="height: 6px;"></tr>

                <td colspan="6" align="center">
                    <input id="chk_accept_conditions" type="checkbox" name="chk_accept_conditions"></input>
                    &nbsp;
                    <LABEL for="chk_accept_conditions"><span id="center_text" style="cursor: pointer;">J'accepte les <a href="index.php?page=disclaimer" id="link">conditions générales</a> de Lux France/France Purification</span></LABEL>
                </td>
<?php
            if(!empty($_SESSION['msg_recap_cart_accept_conditions']))
            {
?>
               <tr style="height: 6px;"></tr>

               <td colspan="6" align="center">
                   <div id="pay_msg_wrong" style="padding: 10px; background-color: red;"><span id="msg_pay_wrong" style="margin-left: 8px;"><?php echo(check_session_input($_SESSION['msg_recap_cart_accept_conditions'])); ?></span></div> 
               </td>  
<?php
            }
?>

                <tr style="height: 6px;"></tr>

                <td colspan="6" align="center">
                    <input type="submit" name="bt_confirm_order" value="Commander"></input>
                    &nbsp;
                    <input type="submit" name="bt_cancel_order" value="Annuler"></input>
                </td>
        
<?php           
// </editor-fold>
?> 
        
<!--        <tr></tr>
        <td><?php //echo(var_dump($_SESSION['cart_cash_discount_ok'])); ?></td>-->
<!--        <tr></tr>
        <td><?php //echo(var_dump($total_destination2)); ?></td>
        <tr></tr>
        <td><?php //echo(var_dump($super_total_ht)); ?></td>-->
           
</TABLE></form></td> 
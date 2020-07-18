<?php
if(preg_match('#^original#', $id_billing_address) == true)
{
    $BoK_address_billing_real = true;
    $id_billing_real = str_replace('original', '', $id_billing_address);
    $query = $connectData->prepare('SELECT * FROM user_real
                                    INNER JOIN user
                                    ON user.id_user = user_real.id_user
                                    WHERE id_real = :user');
    $query->bindParam('user', htmlspecialchars($id_billing_real, ENT_QUOTES));
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        if(empty($data['title_real']) ? $title_pay_accepted_billing = '-' : $title_pay_accepted_billing = $data['title_real'])
        if(empty($data['first_name_real']) ? $firstname_pay_accepted_billing = '-' : $firstname_pay_accepted_billing = $data['first_name_real'])
        if(empty($data['name_real']) ? $lastname_pay_accepted_billing = '-' : $lastname_pay_accepted_billing = $data['name_real'])
        if(empty($data['name_company_real']) ? $company_pay_accepted_billing = '-' : $company_pay_accepted_billing = $data['name_company_real'])
        if(empty($data['phone_landline_real']) ? $landline_pay_accepted_billing = '-' : $landline_pay_accepted_billing = $data['phone_landline_real'])   
        if(empty($data['phone_mobile_real']) ? $mobile_pay_accepted_billing = '-' : $mobile_pay_accepted_billing = $data['phone_mobile_real'])  
        if(empty($data['address_real_1']) ? $address1_pay_accepted_billing = '-' : $address1_pay_accepted_billing = $data['address_real_1'])  
        if(empty($data['address_real_2']) ? $address2_pay_accepted_billing = '-' : $address2_pay_accepted_billing = $data['address_real_2'])  
        if(empty($data['ZIP_real']) ? $zip_pay_accepted_billing = '-' : $zip_pay_accepted_billing = $data['ZIP_real'])  
        if(empty($data['city_real']) ? $city_pay_accepted_billing = '-' : $city_pay_accepted_billing = $data['city_real']) 
        if(empty($data['email_user']) ? $email_pay_accepted_billing = '-' : $email_pay_accepted_billing = $data['email_user'])       

        if(!empty($data['other_country']))
        {
           $country_pay_accepted_billing = $data['other_country'];
        }
        else
        {
           $id_country_pay_accepted_billing = $data['id_country']; 
        }
    }

    $query->closeCursor();
}
else
{
    $query = $connectData->prepare('SELECT * FROM user_address
                            WHERE id_user = :user AND id_address = :address');
    $query->execute(array(
                          'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                          'address' => htmlspecialchars($id_billing_address, ENT_QUOTES)
                          ));
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        if(empty($data['title_address']) ? $title_pay_accepted_billing = '-' : $title_pay_accepted_billing = $data['title_address'])
        if(empty($data['first_name_address']) ? $firstname_pay_accepted_billing = '-' : $firstname_pay_accepted_billing = $data['first_name_address'])
        if(empty($data['last_name_address']) ? $lastname_pay_accepted_billing = '-' : $lastname_pay_accepted_billing = $data['last_name_address'])
        if(empty($data['name_company_address']) ? $company_pay_accepted_billing = '-' : $company_pay_accepted_billing = $data['name_company_address'])
        if(empty($data['phone_landline_address']) ? $landline_pay_accepted_billing = '-' : $landline_pay_accepted_billing = $data['phone_landline_address'])   
        if(empty($data['phone_mobile_address']) ? $mobile_pay_accepted_billing = '-' : $mobile_pay_accepted_billing = $data['phone_mobile_address'])  
        if(empty($data['address_1_address']) ? $address1_pay_accepted_billing = '-' : $address1_pay_accepted_billing = $data['address_1_address'])  
        if(empty($data['address_2_address']) ? $address2_pay_accepted_billing = '-' : $address2_pay_accepted_billing = $data['address_2_address'])  
        if(empty($data['zip_address']) ? $zip_pay_accepted_billing = '-' : $zip_pay_accepted_billing = $data['zip_address'])  
        if(empty($data['city_address']) ? $city_pay_accepted_billing = '-' : $city_pay_accepted_billing = $data['city_address']) 
        if(empty($data['email_address']) ? $email_pay_accepted_billing = '-' : $email_pay_accepted_billing = $data['email_address'])       

        if(!empty($data['other_country_address']))
        {
           $country_pay_accepted_billing = $data['other_country_address'];
        }
        else
        {
           $id_country_pay_accepted_billing = $data['id_country']; 
        }
    }

    $query->closeCursor();

    $BoK_address_billing_real = false;
}

if(preg_match('#^original#', $id_delivery_address) == true)
{
    $BoK_address_delivery_real = true;
    $id_delivery_real = str_replace('original', '', $id_delivery_address);
    $query = $connectData->prepare('SELECT * FROM user_real
                                    INNER JOIN user
                                    ON user.id_user = user_real.id_user
                                    WHERE id_real = :user');
    $query->bindParam('user', htmlspecialchars($id_delivery_real, ENT_QUOTES));
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        if(empty($data['title_real']) ? $title_pay_accepted_delivery = '-' : $title_pay_accepted_delivery = $data['title_real'])
        if(empty($data['first_name_real']) ? $firstname_pay_accepted_delivery = '-' : $firstname_pay_accepted_delivery = $data['first_name_real'])
        if(empty($data['name_real']) ? $lastname_pay_accepted_delivery = '-' : $lastname_pay_accepted_delivery = $data['name_real'])
        if(empty($data['name_company_real']) ? $company_pay_accepted_delivery = '-' : $company_pay_accepted_delivery = $data['name_company_real'])
        if(empty($data['phone_landline_real']) ? $landline_pay_accepted_delivery = '-' : $landline_pay_accepted_delivery = $data['phone_landline_real'])   
        if(empty($data['phone_mobile_real']) ? $mobile_pay_accepted_delivery = '-' : $mobile_pay_accepted_delivery = $data['phone_mobile_real'])  
        if(empty($data['address_real_1']) ? $address1_pay_accepted_delivery = '-' : $address1_pay_accepted_delivery = $data['address_real_1'])  
        if(empty($data['address_real_2']) ? $address2_pay_accepted_delivery = '-' : $address2_pay_accepted_delivery = $data['address_real_2'])  
        if(empty($data['ZIP_real']) ? $zip_pay_accepted_delivery = '-' : $zip_pay_accepted_delivery = $data['ZIP_real'])  
        if(empty($data['city_real']) ? $city_pay_accepted_delivery = '-' : $city_pay_accepted_delivery = $data['city_real']) 
        if(empty($data['email_user']) ? $email_pay_accepted_delivery = '-' : $email_pay_accepted_delivery = $data['email_user'])       

        if(!empty($data['other_country']))
        {
           $country_pay_accepted_delivery = $data['other_country'];
        }
        else
        {
           $id_country_pay_accepted_delivery = $data['id_country']; 
        }
    }

    $query->closeCursor();
}
else
{
    $query = $connectData->prepare('SELECT * FROM user_address
                            WHERE id_user = :user AND id_address = :address');
    $query->execute(array(
                          'user' => htmlspecialchars($_SESSION['login_id'], ENT_QUOTES),
                          'address' => htmlspecialchars($id_delivery_address, ENT_QUOTES)
                          ));
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        if(empty($data['title_address']) ? $title_pay_accepted_delivery = '-' : $title_pay_accepted_delivery = $data['title_address'])
        if(empty($data['first_name_address']) ? $firstname_pay_accepted_delivery = '-' : $firstname_pay_accepted_delivery = $data['first_name_address'])
        if(empty($data['last_name_address']) ? $lastname_pay_accepted_delivery = '-' : $lastname_pay_accepted_delivery = $data['last_name_address'])
        if(empty($data['name_company_address']) ? $company_pay_accepted_delivery = '-' : $company_pay_accepted_delivery = $data['name_company_address'])
        if(empty($data['phone_landline_address']) ? $landline_pay_accepted_delivery = '-' : $landline_pay_accepted_delivery = $data['phone_landline_address'])   
        if(empty($data['phone_mobile_address']) ? $mobile_pay_accepted_delivery = '-' : $mobile_pay_accepted_delivery = $data['phone_mobile_address'])  
        if(empty($data['address_1_address']) ? $address1_pay_accepted_delivery = '-' : $address1_pay_accepted_delivery = $data['address_1_address'])  
        if(empty($data['address_2_address']) ? $address2_pay_accepted_delivery = '-' : $address2_pay_accepted_delivery = $data['address_2_address'])  
        if(empty($data['zip_address']) ? $zip_pay_accepted_delivery = '-' : $zip_pay_accepted_delivery = $data['zip_address'])  
        if(empty($data['city_address']) ? $city_pay_accepted_delivery = '-' : $city_pay_accepted_delivery = $data['city_address']) 
        if(empty($data['email_address']) ? $email_pay_accepted_delivery = '-' : $email_pay_accepted_delivery = $data['email_address'])       

        if(!empty($data['other_country_address']))
        {
           $country_pay_accepted_delivery = $data['other_country_address'];
        }
        else
        {
           $id_country_pay_accepted_delivery = $data['id_country']; 
        }
    }

    $query->closeCursor();

    $BoK_address_delivery_real = false; 
}

if(!empty($id_country_pay_accepted_billing))
{
    $query = $connectData->prepare('SELECT name_country_L1 FROM country
                                    WHERE id_country = :id');
    $query->bindParam('id', htmlspecialchars($id_country_pay_accepted_billing, ENT_QUOTES));
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $country_pay_accepted_billing = $data[0]; 
    }
    $query->closeCursor();
}

if(!empty($id_country_pay_accepted_delivery))
{
    $query = $connectData->prepare('SELECT name_country_L1 FROM country
                                    WHERE id_country = :id');
    $query->bindParam('id', htmlspecialchars($id_country_pay_accepted_delivery, ENT_QUOTES));
    $query->execute();

    if(($data = $query->fetch()) != false)
    {
        $country_pay_accepted_delivery = $data[0]; 
    }
    $query->closeCursor();
}
?>

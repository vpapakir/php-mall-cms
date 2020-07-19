<?php
$subscriptionform_password = crypt_pwd($subscriptionform_password);

$prepared_query = 'INSERT INTO user
                   (nickname_user, email_user, password_user, online_user, 
                   last_log_user, current_log_user, subscription_date_user, 
                   rights_user, status_user, ip_user, idsponsor_user, type_user, 
                   title_user, firstname_user, name_user, birthday_user, 
                   typecompany_user, namecompany_user, functioncompany_user, 
                   activitycompany_user, siretcompany_user, vatintracompany_user, 
                   address1_user, address2_user, city_user, zip_user, country_user, 
                   landline_user, mobile_user, fax_user, website_user, skype_user, facebook_user, 
                   twitter_user, linkedin_user, remarks_user, id_language, id_currency, shop_id)
                   VALUES
                   (:nickname, :email, :password, :online, :lastlog, :currentlog,
                    NOW(), :rights, :status, :ip, :idsponsor, :type, 
                    :title, :firstname, :name, :birthday, :typecompany, :namecompany,
                    :functioncompany, :activitycompany, :siretcompany, :vatintracompany,
                    :address1, :address2, :city, :zip, :country, :landline, :mobile,
                    :fax, :website, :skype, :facebook, :twitter, :linkedin, :remarks,
                    :language, :currency, :shop_id)';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'nickname' => $subscriptionform_nickname,
                      'email' => $subscriptionform_email,
                      'password' => $subscriptionform_password,
                      'online' => 0,
                      'lastlog' => '0000-00-00 00:00:00',
                      'currentlog' => '0000-00-00 00:00:00',
                      'rights' => 1,
                      'status' => 2,
                      'ip' => $_SERVER['REMOTE_ADDR'],
                      'idsponsor' => 0,
                      'type' => $subscriptionform_type,
                      'title' => $subscriptionform_title,
                      'firstname' => $subscriptionform_firstname,
                      'name' => $subscriptionform_lastname,
                      'birthday' => $subscriptionform_birthyear.'-'.$subscriptionform_birthmonth.'-'.$subscriptionform_birthday,
                      'typecompany' => $subscriptionform_companytype,
                      'namecompany' => $subscriptionform_companyname,
                      'functioncompany' => $subscriptionform_companyfunction,
                      'activitycompany' => $subscriptionform_companyactivity,
                      'siretcompany' => $subscriptionform_companysiret,
                      'vatintracompany' => $subscriptionform_companyvatintra,
                      'address1' => $subscriptionform_address1,
                      'address2' => $subscriptionform_address2,
                      'city' => $subscriptionform_city,
                      'zip' => $subscriptionform_zip,
                      'country' => $subscriptionform_country,
                      'landline' => $subscriptionform_landline,
                      'mobile' => $subscriptionform_mobile,
                      'fax' => $subscriptionform_fax,
                      'website' => $subscriptionform_website,
                      'skype' => null,
                      'facebook' => null,
                      'twitter' => null,
                      'linkedin' => null,
                      'remarks' => null,
                      'language' => $subscriptionform_language,
                      'currency' => null,
					  'shop_id' => $_SESSION['cooshopid']
                      ));
$query->closeCursor();

$prepared_query = 'SELECT COUNT(id_user) FROM user';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
if(($data = $query->fetch()) != false)
{
    $subscriptionform_lastiduser = $data[0];
}
$query->closeCursor();
?>

<?php
$useredit_password = crypt_pwd($useredit_password);

$prepared_query = 'INSERT INTO user
                   (nickname_user, email_user, password_user, rights_user, status_user,   
                    type_user, title_user, firstname_user, name_user, birthday_user, 
                    typecompany_user, namecompany_user, functioncompany_user, 
                    activitycompany_user, siretcompany_user, vatintracompany_user, 
                    address1_user, address2_user, city_user, zip_user, country_user, 
                    landline_user, mobile_user, fax_user, website_user, remarks_user, id_language)
                   VALUES
                   (:nickname, :email, :password, :rights, :status,
                    :type, :title, :firstname, :name, :birthday, :typecompany, :namecompany,
                    :functioncompany, :activitycompany, :siretcompany, :vatintracompany, :address1, :address2,
                    :city, :zip, :country, :landline, :mobile, :fax, :website, :remarks, :idlanguage)';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'nickname' => $useredit_nickname,
                      'email' => $useredit_email,
                      'password' => $useredit_password,
                      'rights' => $useredit_rights,
                      'status' => $useredit_status,
                      'type' => $useredit_type,
                      'title' => $useredit_title,
                      'firstname' => $useredit_firstname,
                      'name' => $useredit_lastname,
                      'birthday' => $useredit_birthday_data,
                      'typecompany' => $useredit_companytype,
                      'namecompany' => $useredit_companyname,
                      'functioncompany' => $useredit_companyfunction,
                      'activitycompany' => $useredit_companyactivity,
                      'siretcompany' => $useredit_companysiret,
                      'vatintracompany' => $useredit_companyvatintra,
                      'address1' => $useredit_address1,
                      'address2' => $useredit_address2,
                      'city' => $useredit_city,
                      'zip' => $useredit_zip,
                      'country' => $useredit_country,
                      'landline' => $useredit_landline,
                      'mobile' => $useredit_mobile,
                      'fax' => $useredit_fax,
                      'website' => $useredit_website,
                      'remarks' => $useredit_remarks,
                      'idlanguage' => $useredit_language
                      ));
$query->closeCursor();
$_SESSION['msg_useredit_done'] = str_replace('[#name_useredit]', $useredit_nickname, $msg_done_useredit_add);
?>

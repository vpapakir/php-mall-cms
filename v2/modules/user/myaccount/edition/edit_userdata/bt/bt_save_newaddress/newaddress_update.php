<?php
$prepared_query = 'UPDATE user
                   SET type_user = :type,
                       title_user = :title,
                       firstname_user = :firstname,
                       name_user = :lastname,
                       birthday_user = :birthday,
                       typecompany_user = :typecompany,
                       namecompany_user = :namecompany,
                       functioncompany_user = :functioncompany,
                       activitycompany_user = :activitycompany,
                       siretcompany_user = :siret,
                       vatintracompany_user = :vatintra,
                       address1_user = :address1,
                       address2_user = :address2,
                       city_user = :city,
                       zip_user = :zip,
                       country_user = :country,
                       landline_user = :landline,
                       mobile_user = :mobile,
                       fax_user = :fax,
                       website_user = :website,
                       id_language = :language
                    WHERE id_user = :iduser';

if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'type' => $myaccount_useredition_type,
                      'title' => $myaccount_useredition_title,
                      'firstname' => $myaccount_useredition_firstname,
                      'lastname' => $myaccount_useredition_lastname,
                      'birthday' => $subscription_birthday_data,
                      'typecompany' => $myaccount_useredition_companytype,
                      'namecompany' => $myaccount_useredition_companyname,
                      'functioncompany' => $myaccount_useredition_companyfunction,
                      'activitycompany' => $myaccount_useredition_companyactivity,
                      'siret' => $myaccount_useredition_companysiret,
                      'vatintra' => $myaccount_useredition_companyvatintra,
                      'address1' => $myaccount_useredition_address1,
                      'address2' => $myaccount_useredition_address2,
                      'city' => $myaccount_useredition_city,
                      'zip' => $myaccount_useredition_zip,
                      'country' => $myaccount_useredition_country,
                      'landline' => $myaccount_useredition_landline,
                      'mobile' => $myaccount_useredition_mobile,
                      'fax' => $myaccount_useredition_fax,
                      'website' => $myaccount_useredition_website,
                      'language' => $myaccount_useredition_language,
                      'iduser' => $main_iduser_log
                      ));
$query->closeCursor();

#-main
$_SESSION['myaccount_useredition_radUserEditionType'] = $myaccount_useredition_type;
$_SESSION['myaccount_useredition_cdreditor_title_UserEdition'] = $myaccount_useredition_title;
$_SESSION['myaccount_useredition_txtUserEditionFirstname'] = $myaccount_useredition_firstname;
$_SESSION['myaccount_useredition_txtUserEditionLastname'] = $myaccount_useredition_lastname;
$_SESSION['myaccount_useredition_txtUserEditionNamecompany'] = $myaccount_useredition_companyname;
$_SESSION['myaccount_useredition_cdreditor_typecompany_UserEdition'] = $myaccount_useredition_companytype;
$_SESSION['myaccount_useredition_cdreditor_activitycompany_UserEdition'] = $myaccount_useredition_companyactivity;
$_SESSION['myaccount_useredition_cdreditor_functioncompany_UserEdition'] = $myaccount_useredition_companyfunction;
$_SESSION['myaccount_useredition_txtUserEditionSiretcompany'] = $myaccount_useredition_companysiret;
$_SESSION['myaccount_useredition_txtUserEditionVatintracompany'] = $myaccount_useredition_companyvatintra;
#-address
$_SESSION['myaccount_useredition_txtUserEditionAddress1']= $myaccount_useredition_address1;
$_SESSION['myaccount_useredition_txtUserEditionAddress2']= $myaccount_useredition_address2;
$_SESSION['myaccount_useredition_txtUserEditionZip']= $myaccount_useredition_zip;
$_SESSION['myaccount_useredition_txtUserEditionCity']= $myaccount_useredition_city;
$_SESSION['myaccount_useredition_cdrgeo_country_situation']= $myaccount_useredition_country;
$_SESSION['myaccount_useredition_cboUserEditionLanguage'] = $myaccount_useredition_language;
#-phone & web info
$_SESSION['myaccount_useredition_cboUserEditionBirthDay'] = $myaccount_useredition_birthday;
$_SESSION['myaccount_useredition_cboUserEditionBirthMonth'] = $myaccount_useredition_birthmonth;
$_SESSION['myaccount_useredition_cboUserEditionBirthYear'] = $myaccount_useredition_birthyear;
$_SESSION['myaccount_useredition_txtUserEditionWebsite']= $myaccount_useredition_website;
$_SESSION['myaccount_useredition_txtUserEditionLandline']= $myaccount_useredition_landline;
$_SESSION['myaccount_useredition_txtUserEditionMobile']= $myaccount_useredition_mobile;
$_SESSION['myaccount_useredition_txtUserEditionFax']= $myaccount_useredition_fax;

?>

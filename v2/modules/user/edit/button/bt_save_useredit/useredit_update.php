<?php
if(!empty($useredit_checknewpassword) && $useredit_checknewpassword == 1)
{
    $useredit_password = crypt_pwd($useredit_password);
    
    $prepared_query = 'UPDATE user
                       SET password_user = :pwd
                       WHERE id_user = :iduser';
    if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
    $query = $connectData->prepare($prepared_query);
    $query->execute(array(
                          'pwd' => $useredit_password,
                          'iduser' => $_SESSION['useredit_iduser']
                          ));
    $query->closeCursor();
}

$prepared_query = 'UPDATE user
                   SET nickname_user = :nickname,
                       email_user = :email,
                       rights_user = :rights,
                       status_user = :status,
                       type_user = :type,
                       title_user = :title,
                       firstname_user = :firstname,
                       name_user = :name,
                       birthday_user = :birthday,
                       typecompany_user = :typecompany,
                       namecompany_user = :namecompany,
                       functioncompany_user = :functioncompany,
                       activitycompany_user = :activitycompany,
                       siretcompany_user = :siretcompany,
                       vatintracompany_user = :vatintracompany,
                       address1_user = :address1,
                       address2_user = :address2,
                       city_user = :city,
                       zip_user = :zip,
                       country_user = :country,
                       landline_user = :landline,
                       mobile_user = :mobile,
                       fax_user = :fax,
                       website_user = :website,
                       remarks_user = :remarks,
                       id_language = :idlanguage
                   WHERE id_user = :iduser';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'nickname' => $useredit_nickname,
                      'email' => $useredit_email,
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
                      'idlanguage' => $useredit_language,
                      'iduser' => $_SESSION['useredit_iduser']
                      ));
$query->closeCursor();

#-main
$_SESSION['userdata_radUserdataType'] = $useredit_type;
$_SESSION['userdata_cdreditor_title_userdata'] = $useredit_title;
$_SESSION['userdata_txtUserdataFirstname'] = $useredit_firstname;
$_SESSION['userdata_txtUserdataLastname'] = $useredit_lastname;
$_SESSION['userdata_txtUserdataNamecompany'] = $useredit_companyname;
$_SESSION['userdata_cdreditor_typecompany_userdata'] = $useredit_companytype;
$_SESSION['userdata_cdreditor_activitycompany_userdata'] = $useredit_companyactivity;
$_SESSION['userdata_cdreditor_functioncompany_userdata'] = $useredit_companyfunction;
$_SESSION['userdata_txtUserdataSiretcompany'] = $useredit_companysiret;
$_SESSION['userdata_txtUserdataVatintracompany'] = $useredit_companyvatintra;
#-address
$_SESSION['userdata_txtUserdataAddress1']= $useredit_address1;
$_SESSION['userdata_txtUserdataAddress2']= $useredit_address2;
$_SESSION['userdata_txtUserdataZip']= $useredit_zip;
$_SESSION['userdata_txtUserdataCity']= $useredit_city;
$_SESSION['userdata_cdrgeo_country_situation']= $useredit_country;
$_SESSION['userdata_cboUserdataLanguage'] = $useredit_language;
#-phone & web info
$_SESSION['userdata_cboUserdataBirthDay'] = $useredit_birthday;
$_SESSION['userdata_cboUserdataBirthMonth'] = $useredit_birthmonth;
$_SESSION['userdata_cboUserdataBirthYear'] = $useredit_birthyear;
$_SESSION['userdata_txtUserdataWebsite']= $useredit_website;
$_SESSION['userdata_txtUserdataLandline']= $useredit_landline;
$_SESSION['userdata_txtUserdataMobile']= $useredit_mobile;
$_SESSION['userdata_txtUserdataFax']= $useredit_fax;
#-login info
$_SESSION['userdata_txtUserdataEmail']= $useredit_email;
#-admin
$_SESSION['useredit_cboRightsUserEdit'] = $useredit_rights;
$_SESSION['useredit_cboStatusUserEdit'] = $useredit_status;
$_SESSION['userdata_txtUserdataNickname']= $useredit_nickname;
$_SESSION['useredit_areaRemarksUserEdit'] = $useredit_remarks;

$_SESSION['msg_useredit_done'] = str_replace('[#name_useredit]', $useredit_nickname, $msg_done_useredit_edit);
?>

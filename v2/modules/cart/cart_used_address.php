<?php
try
{
   $query = $connectData->prepare('SELECT * FROM user_real
                                   INNER JOIN country ON user_real.id_country = country.id_country
                                   WHERE id_user = :user');  
   $query->bindParam('user', htmlspecialchars($_SESSION['login_id']));
   $query->execute();
   
   if(($data = $query->fetch()) != false)
   {
      $title_user = $data['title_real'];
      $first_name_user = $data['first_name_real'];
      $name_user = $data['name_user'];
      $name_company_user = $data['name_company_real'];
      $address_user = $data['address_real_1'];
      $zip_user = $data['ZIP_real'];
      $city_user = $data['city_real'];
      $country_real = $data['name_country_L1'];
   }
}
catch (Exception $e)
{
    die("<br>Error : ".$e->getMessage());
}

?>

<td><TABLE width="100%">
        
        <td></td>
        
</TABLE></td>
        

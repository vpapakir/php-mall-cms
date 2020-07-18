<?php

try
{
   $allowed_destination = null; 
   
   $query = $connectData->prepare('SELECT COUNT(id_destination_shipping) FROM shipping_destination');
   $query->execute();
   
   if(($data = $query->fetch()) != false)
   {
       $count_destination = $data[0];
   }
   $query->closeCursor();
    
   if($count_destination != 0)
   {
       for($i = 1; $i <= $count_destination; $i++)
       {
           if($_POST['chk_allowed_destination'.$i] != false)
           {
               if($allowed_destination == null)
               {
                  $allowed_destination = $i.','; 
               }
               else
               {
                  $allowed_destination .= $i.','; 
               }
           }
       }
   }
   
   if($allowed_destination == null)
   {
      $allowed_destination = '1,3,5,6'; 
   }
   else
   {  
      $allowed_destination = preg_replace('#,$#', '', $allowed_destination);
   }

   
}
catch(Exception $e)
{
    die('<br>Error: '.$e->getMessage());
}

?>

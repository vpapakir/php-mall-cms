<html>
    
    <head>
    </head>
    
    <body>
    <p style="font-family: 'Tahoma', monospace; font-weight: bold; font-size: 10px;">      
<?php
//$backoffice_path = realpath('modules/central_footer/central_page_footer.php');
//echo('realpath: '.$backoffice_path.'<br>');
//$backoffice_path = dirname($backoffice_path);
//echo('dirname: '.$backoffice_path);
//
//include('modules/functions/function.php');
//if(isset($_POST['send_crypt']))
//{
//
//    $login = $_POST['login'];
//    $pass_crypte = crypt($_POST['pass']); // On crypte le mot de passe
//
//    echo 'Ligne à copier dans le .htpasswd :<br />' . $login . ':' . $pass_crypte;
//}
//
//else // On n'a pas encore rempli le formulaire
//{
?>
</p>
<p style="font-family: 'Tahoma', monospace; font-weight: bold;">Entrez votre login et votre mot de passe pour le crypter.</p>

<form method="post" action="test.php">
    <table style="border: 1px solid black; border-radius: 6px; padding: 4px;">
        <tr>
            <td align="left" style="font-family: 'Tahoma', monospace; font-weight: bold;">
                Login
            </td>
            <td align="left" width="80%">
                <input type="text" name="login" style="width: 99%;"/>
            </td>
        </tr>
        <tr>
            <td align="left" style="font-family: 'Tahoma', monospace; font-weight: bold;">
                Mot de passe
            </td>
            <td align="left">
                <input type="text" name="pass" style="width: 99%;"/>
            </td>
        </tr>
        <tr>
            <td colspan="2"><div style="height: 4px;"></div></td>
        </tr>    
        <tr>
            <td colspan="2" style="border-top: 1px solid lightgrey;"><div style="height: 4px;"></div></td>
        </tr>
        <tr>
            <td colspan="2"><table width="100%">
                <tr>        
                    <td align="center">
                        <input type="submit" name="send_crypt" value="Crypter"/>
                    </td>
                </tr> 
            </table></td>
        </tr>
    </table>
</form>
<?php
//}
?>
    </body>   
</html>

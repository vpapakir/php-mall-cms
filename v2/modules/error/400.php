<table width="100%">
   
        <td id="center_title" align="center" style="font-size: 24px;">Erreur 400</td>
        
        <tr></tr>
        
        <td id="center_text" align="center">La syntaxe de la requête est erronée:</td>
        
        <tr></tr>
        
        <td id="center_text" align="center"><strong><?php if(isset($_SESSION['prepared_query'])) { echo($_SESSION['prepared_query']); } ?></strong></td>
        
        <tr></tr>
        
        <td id="center_text" align="center">Message: <?php echo($_SESSION['error400_message']); ?></td>
        
        <tr></tr>
        
        <td id="center_text" align="center">Pour revenir à la page d'acceuil, <a id="link" href="<?php echo($_SESSION['index']); ?>?page=<?php change_link('home', 'bo_home'); ?>">Cliquez ici</a></td>
        
</table>

<table width="100%" cellpaddin="0" cellspacing="0">
        
    <td><table class="block_main1" width="100%">

        <?php
            include('modules/custom/immo/sale/search_option/region.php');
        ?>
        
        <tr></tr>    
            
        <?php
            include('modules/custom/immo/sale/search_option/type.php');
        ?>
        
        <tr></tr>    
            
        <?php
            include('modules/custom/immo/sale/search_option/price.php');
        ?>
        
        <tr></tr>
        
        <?php
            include('modules/custom/immo/sale/search_option/room.php');
        ?>
        
        <tr></tr>
        
        <?php
            include('modules/custom/immo/sale/search_option/bathroom.php');
        ?>
        
        <tr></tr>
        
        <?php
            include('modules/custom/immo/sale/search_option/surface.php');
        ?>
        
        <tr></tr>
        
        <?php
            include('modules/custom/immo/sale/search_option/ground.php');
        ?>
        
        <tr></tr>
        
        <?php
            include('modules/custom/immo/sale/search_option/heating.php');
        ?>
        
        <tr></tr>
        
        <?php
            include('modules/custom/immo/sale/search_option/energy.php');
        ?>
        
        <tr></tr>
        
        <?php
            include('modules/custom/immo/sale/search_option/geo.php');
        ?>
        
        <tr></tr>
        
        <?php
            include('modules/custom/immo/sale/search_option/state.php');
        ?>
        
        

    </table></td>
    
    <tr style="height: 6px;"></tr>
        
    <td align="center">
        <input type="submit" name="bt_search_sale" value="<?php give_translation('main.bt_search', $echo, $config_showtranslationcode); ?>"></input>
    </td>
    
    <tr style="height: 6px;"></tr>
    
    <?php
        include('modules/custom/immo/sale/search_result/result_main.php');
    ?>
        
</table>

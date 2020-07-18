<?php
try
{
    $prepared_query = 'SELECT COUNT(id_order_history) FROM order_history
                       WHERE (status_order_history = \'paid\' OR status_order_history = \'onhold\' OR status_order_history = \'sent\') AND new_order_history = 1';
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    if(($data = $query->fetch()) != false)
    {
        $count_order_history_pending = $data[0];
    }
    $query->closeCursor();
}
catch(Exception $e)
{
    die('<br>Error: '.$e->getMessage());
}
?>

<td>

<script type="text/javascript">
function getRequest() {
    var req = false;
    try{
        // most browsers
        req = new XMLHttpRequest();
    } catch (e){
        // IE
        try{
            req = new ActiveXObject("Msxml2.XMLHTTP");
        } catch (e) {
            // try an older version
            try{
                req = new ActiveXObject("Microsoft.XMLHTTP");
            } catch (e){
                return false;
            }
        }
    }
    return req;
}

function getOutput(retVal,id_order_history) {
  var ajax = getRequest();
  if(ajax == false) {
	alert("Ajax Request ignored!");
  }
  ajax.onreadystatechange = function(){
      if(ajax.readyState == 4){
          //document.getElementById('output').innerHTML = ajax.responseText;
      }
  }
  ajax.open("POST", "passtnumber.php?tnumber=" + retVal + "&ordid=" + id_order_history, true);
  ajax.send(null);
}

function submitTnumber(id_order_history,id_select) {
	var idselect = document.getElementById(id_select);
	if(idselect) {
		var x=document.getElementById(id_select).selectedIndex;
		var y=document.getElementById(id_select).options;
		var retVal = "";
		if(y[x].value == "sent") {
			retVal = prompt("Enter the tracking number: ", "tracking  number");
			if( (retVal == 0) || (retVal == "tracking  number") || (retVal == "") || (retVal == null) || (retVal == undefined) ) {
				retVal = 9999;
			}
			myWindow=window.open("http://france-purification.com/shop/order_history/passtnumber.php?tnumber=" + retVal + "&ordid=" + id_order_history,'','width=200,height=100');
			/*var data = 'tnumber=' + retVal + '&ordid=' + id_order_history;
			window.location = "http://france-purification.com/shop/order_history/passtnumber.php?tnumber=" + retVal + "&ordid=" + id_order_history;
			return;*/
			//getOutput(retVal,id_order_history);
			/*jQuery.ajax({
				url: 'passtnumber.php',
				type: "POST",
				data: data,
				dataType: "html",
				success: function (html) {
					alert("The tracking number you have entered is: "+html);
				}
				
			});*/
		}
	}
}

</script>

    <TABLE width="100%" cellpadding="0" cellspacing="0">

        <td colspan="6">
            <TABLE id="<?php echo($block_frontend_approach_result); ?>" width="100%" cellpadding="0" cellspacing="0">
                <td>
                    <span style="margin-left: 4px;" id="<?php echo($text_frontend_approach_result); ?>">
                        <?php

                        echo('Commandes en cours (impayées, payées mais pas livrées / transférées)');

?>
                    </span>
                </td>
            </TABLE>
        </td>

        <tr style="height: 6px;"></tr>
<?php
if($count_order_history_pending > 0)
{
?>
        <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">No.</span></div></td>
        <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Client</span></div></td>
        <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Type</span></div></td>
        <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Montant</span></div></td>            
        <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Date</span></div></td>
        <td id="center_text_table" align="center"><div id="<?php echo($box_general_subtitle); ?>"><span id="<?php echo($text_general_subtitle); ?>">Statut</span></div></td>
       
        <tr style="height: 6px;"></tr>

<?php
}
else
{
?>
        <tr style="height: 6px;"></tr>
        
        <td id="center_text_table" align="center">Aucune nouvelle commande</td>   
<?php
}


try
{
    $BoK_style_order_history_pending = false;
    
    $prepared_query = 'SELECT * FROM order_history
                       INNER JOIN user_real
                       ON order_history.id_user = user_real.id_user
                       WHERE (status_order_history = \'paid\' 
                       OR status_order_history = \'onhold\' 
                       OR status_order_history = \'sent\')
                       AND new_order_history = 1
                       ORDER BY date_order_history DESC';
    
    $query = $connectData->prepare($prepared_query);
    $query->execute();
    
    while($data = $query->fetch())
    {

        if($BoK_style_order_history_pending == false)
        {
            $style_order_history_pending = 'style="background-color: white;"';
            $BoK_style_order_history_pending = true;
        }
        else
        {
            $style_order_history_pending = 'style="background-color: #EEEEEE;"';
            $BoK_style_order_history_pending = false;
        }
        
        if(!empty($data['name_company_real']))
        {
            $name_order_history_pending = upper_firstchar($data['name_company_real']);
        }
        else
        {
            $name_order_history_pending = upper_firstchar($data['name_real']).' '.upper_firstchar(substr($data['name_real'], 0 , 1)).'.';
        }
        
        switch($data['type_real'])
        {
            case 'reseller':
                $type_order_history_pending = 'Revendeur';
                break;
            case 'public':
                $type_order_history_pending = 'Particulier';
                break;
            case 'admin':
                $type_order_history_pending = 'Administrateur';
                break;
        }
        
        $timestamp = converto_timestamp($data['date_order_history']);
        
?>
                <td <?php echo($style_order_history_pending); ?> align="center">
                    <span id="center_text"><?php echo($data['number_order_history']); ?></span>
                </td>
                <td <?php echo($style_order_history_pending); ?>>
                    <span id="center_text" style="margin-left: 4px;"><?php echo($name_order_history_pending); ?></span>
                </td>
                <td <?php echo($style_order_history_pending); ?>>
                    <span id="center_text" style="margin-left: 4px;"><?php echo($type_order_history_pending); ?></span>
                </td>
                <td <?php echo($style_order_history_pending); ?> align="right">
                    <span id="center_text" style="margin-right: 4px;"><?php echo(number_format($data['amount_order_history'], 2, '.', '').' €'); ?></span>
                </td>           
                <td <?php echo($style_order_history_pending); ?> align="center">
                    <span id="center_text" style="margin-left: 4px;"><?php echo(date('d/m/Y', $timestamp)); ?></span>
                </td> 
                <td <?php echo($style_order_history_pending); ?> align="center">
                    <span id="center_text" style="margin-left: 4px;">
                        <SELECT <?php if($data['status_order_history'] == 'onhold') { echo('id="cboOrderPendingStatus'.$data['id_order_history'].'"'); } ?> name="cboOrderPendingStatus<?php echo($data['id_order_history']) ?>" onchange="<?php if($data['status_order_history'] == 'onhold') { echo "submitTnumber(".$data['id_order_history'].",'cboOrderPendingStatus".$data['id_order_history']."');"."OnChange('bt_change_order_pending_status".$data['id_order_history']."')"; } else { echo "OnChange('bt_change_order_pending_status".$data['id_order_history']."')"; } ?>">
                            <option value="onhold" <?php if($data['status_order_history'] == 'onhold'){ echo('selected'); }else{ echo(null); } ?>>En attente</option>
                            <option value="transferred" <?php if($data['status_order_history'] == 'paid'){ echo('selected'); }else{ echo(null); } ?>>Transféré</option>
                            <option value="paid" <?php if($data['status_order_history'] == 'paid'){ echo('selected'); }else{ echo(null); } ?>>Payé</option>
                            <option value="sent" <?php if($data['status_order_history'] == 'sent'){ echo('selected'); }else{ echo(null); } ?>>Expédié</option>
                            <option value="delivered" <?php if($data['status_order_history'] == 'delivered'){ echo('selected'); }else{ echo(null); } ?>>Livré</option>
                            <option value="cancelled" <?php if($data['status_order_history'] == 'cancelled'){ echo('selected'); }else{ echo(null); } ?>>Annulé</option>
                        </SELECT>
                        <input id="bt_change_order_pending_status<?php echo($data['id_order_history']) ?>" hidden style="display: none;" type="submit" name="bt_change_order_pending_status<?php echo($data['id_order_history']) ?>" value="Choix Statut"></input> 
                    </span>
                </td> 

                <tr></tr>

<?php
    }
    $query->closeCursor();
}
catch(Exception $e)
{
    die('<br>Error: '.$e->getMessage());
}
?>

    </TABLE>
</td>

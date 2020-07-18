<?php
#style_color
$prepared_query = 'UPDATE style_color
                   SET name_color = :name,
                       code_color = :code, ';
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    if($i < ($count-1))
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$color_name[$i].'\', ';
    }
    else
    {
        $prepared_query .= 'L'.$main_activatedidlang[$i].' = \''.$color_name[$i].'\' ';
    }
}
$prepared_query .= 'WHERE id_color = :id';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'name' => $color_name[0],
                      'code' => $color_code,
                      'id' => $color_id
                      ));
$query->closeCursor();

#body
$prepared_query = 'UPDATE structure_body
                   SET bgcolor_body = :bgcolor
                   WHERE bgcolor_body = :old_bgcolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bgcolor' => $color_code,
                      'old_bgcolor' => $color_oldcode,
                      ));
$query->closeCursor();

#skin
$prepared_query = 'UPDATE structure_skin
                   SET bordercolor_skin = :bordercolor
                   WHERE bordercolor_skin = :old_bordercolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bordercolor' => $color_code,
                      'old_bordercolor' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE structure_skin
                   SET tablebg_skin = :tablebg
                   WHERE tablebg_skin = :old_tablebg';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'tablebg' => $color_code,
                      'old_tablebg' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE structure_skin
                   SET bgcolor_skin  = :bgcolor
                   WHERE bgcolor_skin  = :old_bgcolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bgcolor' => $color_code,
                      'old_bgcolor' => $color_oldcode,
                      ));
$query->closeCursor();

#section
$prepared_query = 'UPDATE structure_section
                   SET bordercolor_section = :bordercolor
                   WHERE bordercolor_section = :old_bordercolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bordercolor' => $color_code,
                      'old_bordercolor' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE structure_section
                   SET tablebg_section = :tablebg
                   WHERE tablebg_section = :old_tablebg';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'tablebg' => $color_code,
                      'old_tablebg' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE structure_section
                   SET bgcolor_section  = :bgcolor
                   WHERE bgcolor_section  = :old_bgcolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bgcolor' => $color_code,
                      'old_bgcolor' => $color_oldcode,
                      ));
$query->closeCursor();

#layout
$prepared_query = 'UPDATE structure_layout
                   SET bordercolor_layout = :bordercolor
                   WHERE bordercolor_layout = :old_bordercolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bordercolor' => $color_code,
                      'old_bordercolor' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE structure_layout
                   SET tablebg_layout = :tablebg
                   WHERE tablebg_layout = :old_tablebg';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'tablebg' => $color_code,
                      'old_tablebg' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE structure_layout
                   SET bgcolor_layout  = :bgcolor
                   WHERE bgcolor_layout  = :old_bgcolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bgcolor' => $color_code,
                      'old_bgcolor' => $color_oldcode,
                      ));
$query->closeCursor();

#frame
$prepared_query = 'UPDATE structure_frame
                   SET bordercolor_frame = :bordercolor
                   WHERE bordercolor_frame = :old_bordercolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bordercolor' => $color_code,
                      'old_bordercolor' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE structure_frame
                   SET tablebg_frame = :tablebg
                   WHERE tablebg_frame = :old_tablebg';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'tablebg' => $color_code,
                      'old_tablebg' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE structure_frame
                   SET bgcolor_frame  = :bgcolor
                   WHERE bgcolor_frame  = :old_bgcolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bgcolor' => $color_code,
                      'old_bgcolor' => $color_oldcode,
                      ));
$query->closeCursor();

#box
$prepared_query = 'UPDATE structure_box
                   SET bordercolor_box = :bordercolor
                   WHERE bordercolor_box = :old_bordercolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bordercolor' => $color_code,
                      'old_bordercolor' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE structure_box
                   SET tablebg_box = :tablebg
                   WHERE tablebg_box = :old_tablebg';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'tablebg' => $color_code,
                      'old_tablebg' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE structure_box
                   SET bgcolor_box  = :bgcolor
                   WHERE bgcolor_box  = :old_bgcolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bgcolor' => $color_code,
                      'old_bgcolor' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE structure_box
                   SET defaultfont_box  = REPLACE(defaultfont_box, \''.$color_oldcode.'\', \''.$color_code.'\')
                   WHERE defaultfont_box LIKE \'%'.$color_oldcode.'%\'';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
$query->closeCursor();

#[logo]
$prepared_query = 'UPDATE structure_logo
                   SET color_logo  = :logocolor
                   WHERE color_logo  = :old_logocolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'logocolor' => $color_code,
                      'old_logocolor' => $color_oldcode,
                      ));
$query->closeCursor();
#[/logo]

#[block]
$prepared_query = 'UPDATE style_block
                   SET bordercolor_block = :bordercolor
                   WHERE bordercolor_block  = :old_bordercolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bordercolor' => $color_code,
                      'old_bordercolor' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE style_block
                   SET bgcolor_block = :bgcolor
                   WHERE bgcolor_block  = :old_bgcolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bgcolor' => $color_code,
                      'old_bgcolor' => $color_oldcode,
                      ));
$query->closeCursor();

$prepared_query = 'UPDATE style_block
                   SET bgcolorhover_block = :bghovercolor
                   WHERE bgcolorhover_block  = :old_bghovercolor';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute(array(
                      'bghovercolor' => $color_code,
                      'old_bghovercolor' => $color_oldcode,
                      ));
$query->closeCursor();
#[/block]

#[button]
$prepared_query = 'UPDATE style_button
                   SET color_button = REPLACE(color_button, \''.$color_oldcode.'\', \''.$color_code.'\')
                   WHERE color_button LIKE \'%'.$color_oldcode.'%\'';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
$query->closeCursor();

$prepared_query = 'UPDATE style_button
                   SET bordercolor_button = REPLACE(bordercolor_button, \''.$color_oldcode.'\', \''.$color_code.'\')
                   WHERE bordercolor_button LIKE \'%'.$color_oldcode.'%\'';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
$query->closeCursor();

$prepared_query = 'UPDATE style_button
                   SET bgcolor_button = REPLACE(bgcolor_button, \''.$color_oldcode.'\', \''.$color_code.'\')
                   WHERE bgcolor_button LIKE \'%'.$color_oldcode.'%\'';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
$query->closeCursor();
#[/button]

#[font]
$prepared_query = 'SHOW COLUMNS FROM style_font';
if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
$query = $connectData->prepare($prepared_query);
$query->execute();
$i = 0;
while($data = $query->fetch())
{
    if($i > 2)
    {
        $prepared_query = 'UPDATE style_font
                           SET '.$data[0].' = REPLACE('.$data[0].', \''.$color_oldcode.'\', \''.$color_code.'\')
                           WHERE '.$data[0].' LIKE \'%'.$color_oldcode.'%\'';
        if((checkrights($main_rights_log, '9', $redirection)) === true){ $_SESSION['prepared_query'] = $prepared_query; }
        $color_query = $connectData->prepare($prepared_query);
        $color_query->execute();
        $color_query->closeCursor();
    }
    $i++;
}
$query->closeCursor();
#[/font]



$_SESSION['color_cboColor'] = $color_id;
for($i = 0, $count = count($main_activatedidlang); $i < $count; $i++)
{
    $_SESSION['color_txtNameColor'.$main_activatedidlang[$i]] = $color_name[$i];
}
$_SESSION['color_txtCodeColor'] = $color_code;

$msg_done_color_edit = str_replace('[#name_color]', $color_name[$color_selected_lang], $msg_done_color_edit);
$_SESSION['msg_color_done'] = $msg_done_color_edit;
?>

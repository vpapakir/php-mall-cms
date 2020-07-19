<tr>
    <td align="left">
        <table class="block_main2" width="100%" style="margin-bottom: 4px;">
            <tr>
                <td align="left">
                    <span class="font_subtitle">
                        <?php give_translation('dirtyword_edit.subtitle_ordertype', $echo, $config_showtranslationcode); ?>
                    </span>
                </td>
                <td align="left" width="<?php echo($right_column_width); ?>">
                    <select name="cboOrderTypeDirtyword" onchange="OnChange('bt_cboOrderTypeDirtyword');">
                        <option value="dateadd_replace"
                            <?php if(empty($_SESSION['dirtyword_cboOrderTypeDirtyword']) || $_SESSION['dirtyword_cboOrderTypeDirtyword'] == 'dateadd_replace'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_dateadd', $echo, $config_showtranslationcode); ?></option>
                        <option value="dateedit_replace"
                            <?php if(!empty($_SESSION['dirtyword_cboOrderTypeDirtyword']) && $_SESSION['dirtyword_cboOrderTypeDirtyword'] == 'dateedit_replace'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_dateedit', $echo, $config_showtranslationcode); ?></option>
                        <option value="sourceL<?php echo($dirtyword_idlang); ?>"
                            <?php if(!empty($_SESSION['dirtyword_cboOrderTypeDirtyword']) && $_SESSION['dirtyword_cboOrderTypeDirtyword'] == 'sourceL'.$dirtyword_idlang){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_source', $echo, $config_showtranslationcode); ?></option>
                        <option value="replaceL<?php echo($dirtyword_idlang); ?>"
                            <?php if(!empty($_SESSION['dirtyword_cboOrderTypeDirtyword']) && $_SESSION['dirtyword_cboOrderTypeDirtyword'] == 'replaceL'.$dirtyword_idlang){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_replace', $echo, $config_showtranslationcode); ?></option>
                        <option value="statusL<?php echo($dirtyword_idlang); ?>"
                            <?php if(!empty($_SESSION['dirtyword_cboOrderTypeDirtyword']) && $_SESSION['dirtyword_cboOrderTypeDirtyword'] == 'statusL'.$dirtyword_idlang){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_status', $echo, $config_showtranslationcode); ?></option>
                        <option value="commentL<?php echo($dirtyword_idlang); ?>"
                            <?php if(!empty($_SESSION['dirtyword_cboOrderTypeDirtyword']) && $_SESSION['dirtyword_cboOrderTypeDirtyword'] == 'commentL'.$dirtyword_idlang){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_comment', $echo, $config_showtranslationcode); ?></option>
                        <option value="searchL<?php echo($dirtyword_idlang); ?>"
                            <?php if(!empty($_SESSION['dirtyword_cboOrderTypeDirtyword']) && $_SESSION['dirtyword_cboOrderTypeDirtyword'] == 'searchL'.$dirtyword_idlang){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_search', $echo, $config_showtranslationcode); ?></option>
                        <option value="keywordL<?php echo($dirtyword_idlang); ?>"
                            <?php if(!empty($_SESSION['dirtyword_cboOrderTypeDirtyword']) && $_SESSION['dirtyword_cboOrderTypeDirtyword'] == 'keywordL'.$dirtyword_idlang){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_keyword', $echo, $config_showtranslationcode); ?></option>
                    </select>  
                    <input id="bt_cboOrderTypeDirtyword" style="display: none;" hidden="hidden" type="submit" name="bt_cboOrderTypeDirtyword" value="select"/>
                    &nbsp;
                    <select name="cboOrderModeDirtyword" onchange="OnChange('bt_cboOrderModeDirtyword');">
                        <option value="ASC"
                            <?php if(empty($_SESSION['dirtyword_cboOrderModeDirtyword']) || $_SESSION['dirtyword_cboOrderModeDirtyword'] == 'ASC'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_modeorder_asc', $echo, $config_showtranslationcode); ?></option>
                        <option value="DESC"
                            <?php if(!empty($_SESSION['dirtyword_cboOrderModeDirtyword']) && $_SESSION['dirtyword_cboOrderModeDirtyword'] == 'DESC'){ echo('selected="selected"'); } ?>
                                ><?php give_translation('main.dd_modeorder_desc', $echo, $config_showtranslationcode); ?></option>
                    </select>  
                    <input id="bt_cboOrderModeDirtyword" style="display: none;" hidden="hidden" type="submit" name="bt_cboOrderModeDirtyword" value="select"/>
                </td>
            </tr>
        </table>
    </td>
</tr>

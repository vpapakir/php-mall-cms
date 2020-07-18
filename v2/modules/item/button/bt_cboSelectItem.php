<?php
if(isset($_POST['bt_cboSelectItem']))
{
    unset($_SESSION['msg_item_main_done']);
    
    unset($_SESSION['item_block_txtEditNameBlock'],
            $_SESSION['item_block_txtEditBordersizeBlock'],
            $_SESSION['item_block_cboEditBordercolorBlock'],
            $_SESSION['item_block_txtEditBorderRadiusLTBlock'],
            $_SESSION['item_block_txtEditBorderRadiusRTBlock'],
            $_SESSION['item_block_txtEditBorderRadiusRBBlock'],
            $_SESSION['item_block_txtEditBorderRadiusLBBlock'],
            $_SESSION['item_block_cboBgColorEditBlock'],
            $_SESSION['item_block_txtEditWidthBlock'],
            $_SESSION['item_block_txtEditHeightBlock'],
            $_SESSION['item_block_txtEditPaddingBlock'],
            $_SESSION['item_block_txtEditImageBlock'],
            $_SESSION['item_block_cboEditFontBlock'],
            $_SESSION['item_block_cboBgColorHoverEditBlock']);
    unset($_SESSION['item_button_cboEditFamilyButton'],
            $_SESSION['item_button_txtEditSizeButton'],   
            $_SESSION['item_button_cboEditWeightButton'],
            $_SESSION['item_button_cboEditColorButton'],
            $_SESSION['item_button_cboEditAlignButton'],
            $_SESSION['item_button_txtEditSizeBorderButton'],
            $_SESSION['item_button_cboBordercolorButton'],
            $_SESSION['item_button_txtEditBorderRadiusLTButton'],
            $_SESSION['item_button_txtEditBorderRadiusRTButton'],
            $_SESSION['item_button_txtEditBorderRadiusRBButton'],
            $_SESSION['item_button_txtEditBorderRadiusLBButton'],
            $_SESSION['item_button_cboBgColorButton'],
            $_SESSION['item_button_txtEditWidthButton'],
            $_SESSION['item_button_txtEditHeightButton'],
            $_SESSION['item_button_txtEditPaddingButton'],
            $_SESSION['item_button_txtEditImageButton']);
    unset($_SESSION['item_button_cboEditFamilyButtonHover'],
            $_SESSION['item_button_txtEditSizeButtonHover'],   
            $_SESSION['item_button_cboEditWeightButtonHover'],
            $_SESSION['item_button_cboEditColorButtonHover'],
            $_SESSION['item_button_cboEditAlignButtonHover'],
            $_SESSION['item_button_txtEditSizeBorderButtonHover'],
            $_SESSION['item_button_cboBordercolorButtonHover'],
            $_SESSION['item_button_txtEditBorderRadiusLTButtonHover'],
            $_SESSION['item_button_txtEditBorderRadiusRTButtonHover'],
            $_SESSION['item_button_txtEditBorderRadiusRBButtonHover'],
            $_SESSION['item_button_txtEditBorderRadiusLBButtonHover'],
            $_SESSION['item_button_cboBgColorButtonHover'],
            $_SESSION['item_button_txtEditWidthButtonHover'],
            $_SESSION['item_button_txtEditHeightButtonHover'],
            $_SESSION['item_button_txtEditPaddingButtonHover'],
            $_SESSION['item_button_txtEditImageButtonHover']);
    unset($_SESSION['item_button_cboEditFamilyButtonActive'],
            $_SESSION['item_button_txtEditSizeButtonActive'],   
            $_SESSION['item_button_cboEditWeightButtonActive'],
            $_SESSION['item_button_cboEditColorButtonActive'],
            $_SESSION['item_button_cboEditAlignButtonActive'],
            $_SESSION['item_button_txtEditSizeBorderButtonActive'],
            $_SESSION['item_button_cboBordercolorButtonActive'],
            $_SESSION['item_button_txtEditBorderRadiusLTButtonActive'],
            $_SESSION['item_button_txtEditBorderRadiusRTButtonActive'],
            $_SESSION['item_button_txtEditBorderRadiusRBButtonActive'],
            $_SESSION['item_button_txtEditBorderRadiusLBButtonActive'],
            $_SESSION['item_button_cboBgColorButtonActive'],
            $_SESSION['item_button_txtEditWidthButtonActive'],
            $_SESSION['item_button_txtEditHeightButtonActive'],
            $_SESSION['item_button_txtEditPaddingButtonActive'],
            $_SESSION['item_button_txtEditImageButtonActive']);
    
    $selected_operation_item = htmlspecialchars($_POST['cboSelectItem'], ENT_QUOTES);
    
    $_SESSION['item_main_edit_cboSelectItem'] = $selected_operation_item;
    
    if($_SESSION['index'] == 'index.php')
    {
        header('Location: '.$config_customheader.$rewritingF_page);
    }
    else
    {
        header('Location: '.$config_customheader.$rewritingB_page);
    }
}
?>

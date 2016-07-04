<?php
//XCMSPro: Web Service entity class
class ImageText
{
var $_DS;
function manageImageText()
	{
		global $CORE;
    $this->_DS = new DataSource('main');
    $DS = &$this->_DS;
    $input = $CORE->getInput();
   // print_r($input);exit;
    if($input['ResourceID'])
   {
     $imgTxt = $DS->query("SELECT * FROM ImageText WHERE ImageTextID=" . $input['ResourceID']);
     $fullText = $imgTxt[0]['fullText'];
     $iconText = $imgTxt[0]['iconText'];
     $previewText = $imgTxt[0]['previewText'];
     $id = $imgTxt[0]['ImageTextID'];
     
     $CORE->setTempInputVar('fullText',$fullText);
     $CORE->setTempInputVar('iconText',$iconText);
     $CORE->setTempInputVar('previewText',$previewText);
   }
   if($input['imgTextF']||$input['imgText2F']||$input['imgText3F']||$input['imgText']||$input['imgText2']||$input['imgText3']){
    if(($input['imgTextF']||$input['imgText2F']||$input['imgText3F']||$input['imgText']||$input['imgText2']||$input['imgText3'])&& (!$id))
    {  
        
        $sql = "";

        if($input['imgText']||$input['imgTextF'])
        {
            $sql = $sql . "'<en>" . $input['imgText'] . "</en><fr>" . $input['imgTextF'] . "</fr>' ";
        }else {
            $sql = $sql . "' '";
        }
        if($input['imgText2']||$input['imgText2F'])
        {
            $sql = $sql . ", '<en>" . $input['imgText2'] . "<en><fr>" . $input['imgText2F'] . "</fr>' ";
        }else{
              $sql = $sql . ", ' '";
        }
         if($input['imgText3']||$input['imgText3F'])
        {
            $sql = $sql . ", '<en>" . $input['imgText3'] . "</en><fr>" . $input['imgText3F'] . "</fr>' ";
            
        }else{
            $sql = $sql . ", ' '";
        }
        $query = "INSERT INTO `ImageText` ( `ImageTextID` , `fullText`, `iconText`, `previewText`) VALUES (" . $input['ResourceID'] . ", " . $sql . ")";
      
        $DS->query($query); 
    } else
    {
    $sql = $sql . "SET `fullText` = '<en>" . $input['imgText'] . "</en><fr>" . $input['imgTextF'] . "</fr>'";
       
    $sql = $sql . ", `iconText` = '<en>" . $input['imgText2']  . "</en><fr>" . $input['imgText2F'] . "</fr>'";
       
    $sql = $sql . ", `previewText` = '<en>" . $input['imgText3'] . "</en><fr>" . $input['imgText3F'] . "</fr>'";

    $query = "UPDATE ImageText " . $sql . " WHERE ImageTextID ='". $input['ResourceID'] . "'";
    $DS->query($query);
    }
    }
     if($input['del']=='delEf')
    {
      $query = "UPDATE ImageText SET `fullText`=' ' WHERE ImageTextID ='". $input['ResourceID'] . "'";
     $DS->query($query);

    }
     if($input['del']=='delEi')
    {
     $query = "UPDATE ImageText SET `iconText`=' ' WHERE ImageTextID ='". $input['ResourceID'] . "'";
     $DS->query($query);

    }
     if($input['del']=='delEp')
    {
   $query = "UPDATE ImageText SET `previewText`=' ' WHERE ImageTextID ='". $input['ResourceID'] . "'";
     $DS->query($query);

    }
    if($input['ResourceID'])
   {
     $imgTxt = $DS->query("SELECT * FROM ImageText WHERE ImageTextID=" . $input['ResourceID']);
     $fullText = $imgTxt[0]['fullText'];
     $iconText = $imgTxt[0]['iconText'];
     $previewText = $imgTxt[0]['previewText'];

     $CORE->setTempInputVar('fullText',$fullText);
     $CORE->setTempInputVar('iconText',$iconText);
     $CORE->setTempInputVar('previewText',$previewText);
   }
    
   // print_r($input); exit;
   
	}
	function ImageText()
{
  //  getBoxes('manageImageText');
}
}
$ImageTexto = new ImageText();
$ImageTexto->manageImageText();
?>

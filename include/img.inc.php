<?php

  if (!$iImageIteration)
    $iImageIteration = '';

  $oImage = NULL;
  switch($_POST['radImage'.$iImageIteration]){
  case 0:
    //None
    $iImageCod = 0;
    break;
  case 1:
    //Image code
    if (IsNothing($_POST['txtImageCod'.$iImageIteration]))
      $iImageCod = 0;
    else
      $iImageCod = $_POST['txtImageCod'.$iImageIteration];
    break;
  case 2:
    $iImageCod = $_POST['selImageFilename'.$iImageIteration];
    break;
  case 3:
    //New image
    $iImageCod = 0;

    require_once 'HTTP/Upload.php';

    if (!$oUpload)
      $oUpload = new HTTP_Upload(_('en'));

    $oFile = $oUpload->getFiles('filImage'.$iImageIteration);
    if ($oFile->isValid()){
      $oImage = new ProdLer_Image($oFile);
      if (!$oImage->CorrectSize($_POST['MAX_FILE_SIZE'.$iImageIteration])){
        $oImage = NULL;
        $iImageCod = -1;
      }
    }
  }

  if ($iImageCod != 0){
    $oColImages = new ProdLer_Collection_Images();
    $oImage = $oColImages->ObtainObject('cod',$iImageCod);
  }

?>
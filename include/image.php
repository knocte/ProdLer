<?php

  require_once './init.inc.php';

  $_DATA = $_REQUEST;

  if (!IsNothing($_DATA['cod'])){

    $oColImages = new ProdLer_Collection_Images();

    $oImage = $oColImages->ObtainObject('cod',$_DATA['cod']);

    if ($oImage){
      $oImage->Show($_DATA['dim']);
    }
  }

  require_once './exit.inc.php';

?>

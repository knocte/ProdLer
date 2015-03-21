<?php

  require_once '../../include/init.inc.php';

  $_DATA = $_POST;

  $sDisplay='error.htm.tpl';

  require_once '../../include/img.inc.php';

  if ( IsNothing($_DATA['hidBrandCod'])
       ||(!is_numeric($_DATA['hidBrandCod']))
       ||($_DATA['hidBrandCod']<0) ){
    $sMessage = _('Invalid data received from the form').'.';
  }
  else if ( IsNothing($_DATA['radImage'])
       ||(!is_numeric($_DATA['radImage']))
       ||($_DATA['radImage']>3)
       ||($_DATA['radImage']<0) ){
    $sMessage = _('Invalid data received from the form').'.';
  }
  else if ($iImageCod == -1){
    $sMessage = _('The image size is too large').'.';
  }
  else if (IsNothing($_DATA['txtBrandName'])){
    $sMessage = _('Brand name is a required field').'.';
  }
  else if (strlen($_DATA['txtBrandName'])>48){
    $sMessage = _('You have exceeded the maximum number of characters for the brand name').'.';
  }
  else if ((!IsNothing($_DATA['txtBrandURL']))&&(strlen($_DATA['txtBrandURL'])>48)){
    $sMessage = _('You have exceeded the maximum number of characters for the brand URL').'.';
  }
  else if ((!IsNothing($_DATA['txtBrandURL']))&&(!IsOneWord($_DATA['txtBrandURL']))){
    $sMessage = _('URL cannot have spaces').'.';
  }
  else{
    $sDisplay='message.htm.tpl';

    $sBrandName = FixString($_DATA['txtBrandName']);
    $sBrandURL = FixString($_DATA['txtBrandURL']);

    if ($_DATA['hidBrandCod']=='0'){
      //Brand creation

      $oBrand = new ProdLer_Brand($sBrandName);
      $oBrand->SetURL($sBrandURL);
      if ($oImage) $oBrand->SetImage($oImage);

      $oColBrands = new ProdLer_Collection_Brands();
      if ($oColBrands->IncludeObject($oBrand)){
        $sMessage=_('The brand has been successfully created').'.';
      }
      else{
        $sMessage=_('There is already a brand with that name').'.';
        $sDisplay='error.htm.tpl';
      }

    }
    else{
      //Brand modification

      $oColBrands = new ProdLer_Collection_Brands();
      $oBrand = $oColBrands->ObtainObject('cod',$_DATA['hidBrandCod']);

      if (!$oBrand)
        $sMessage=_('Brand not found').'.';
      else{
        $oBrand->SetName($sBrandName);
        $oBrand->SetURL($sBrandURL);
        $oBrand->SetImage($oImage);

        if ($oColBrands->UpdateObject($oBrand)){
          $sMessage=_('The brand has been successfully modified').'.';
        }
        else{
          $sMessage=_('There is already a brand with that name').'.';
          $sDisplay='error.htm.tpl';
        }
      }
    }
  }

  $oSmarty = new Xsmarty();

  $oSmarty->assign('sReturn','form_brands.php');
  $oSmarty->assign('sMessage',$sMessage);
  $oSmarty->display($sDisplay);

  require_once '../../include/exit.inc.php';

?>